<?php
/**
 * Created by PhpStorm.
 * User: querdos
 * Date: 07/05/16
 * Time: 17:38
 */

namespace Querdos\ChallengeMe\AdministratorBundle\Command;

use Querdos\ChallengeMe\AdministratorBundle\Entity\Adminstrator;
use Querdos\ChallengeMe\AdministratorBundle\Manager\AdministratorManager;
use Sensio\Bundle\GeneratorBundle\Command\GeneratorCommand;
use Sensio\Bundle\GeneratorBundle\Command\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;

class CreateAdminCommand extends GeneratorCommand
{
    public function configure()
    {
        $this
            ->setName("challengeme:generate:admin")
            ->setDescription("Generate administrator")

            ->setDefinition(array(
                new InputOption("username", '', InputOption::VALUE_REQUIRED, "The username of the admin to create"),
                new InputOption("password", '', InputOption::VALUE_REQUIRED, "The password of the admin to create"),
                new InputOption("email",    '', InputOption::VALUE_REQUIRED, "The email of the admin to create"),

                new InputOption("firstname", '', InputOption::VALUE_OPTIONAL, "The firstname of the admin to create"),
                new InputOption("lastname",  '', InputOption::VALUE_OPTIONAL, "The lastname of the admin to create"),
                new InputOption("emailback", '', InputOption::VALUE_OPTIONAL, "An additionnal email for the admin to create"),
                new InputOption("birthday",  '', InputOption::VALUE_OPTIONAL, "The birthday of the admin to create")
            ))
            ->setHelp(<<<EOT
The <info>%command.name%</info> command helps you generates new admins.

By default, the command intereacts with the developer to tweak the generation.
Any passed option will be used as a default value for the interaction.

If you want to disable any user interaction, use <comment>--no-interaction</comment> but don't forget to pass all needed options:
<info>php %command.full_name% --username=root --password=toor --email=admin@challengeme.com
EOT
);
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * 
     * @return int|null|void
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var QuestionHelper $questionHelper */
        $questionHelper = $this->getQuestionHelper();

        /** @var EncoderFactory $encoderFactory */
        $encoderFactory = $this->getContainer()->get('security.encoder_factory');

        /** @var AdministratorManager $adminManager */
        $adminManager = $this->getContainer()->get('challengeme.manager.administrator');
        
        /*
         * Summary before generation
         */
        $questionHelper->writeSection($output, "Summary before generation");

        $output->writeln("Firstname:\t<info>" . $input->getOption('firstname') . "</info>");
        $output->writeln("Lastname:\t<info>" . $input->getOption('lastname') . "</info>");
        $output->writeln("Username:\t<info>" . $input->getOption('username') . "</info>");
        $output->writeln("Email:\t\t<info>" . $input->getOption('email') . "</info>");
        $output->writeln("Email (2):\t<info>" . $input->getOption('emailback') . "</info>");
        $output->writeln("Birthday:\t<info>" . $input->getOption('birthday') . "</info>");
        $output->writeln("");

        $question = new ConfirmationQuestion("Continue ? (y|n)", true);
        if (!$questionHelper->ask($input, $output, $question)) {
            $this->interact($input, $output);
        }

        $admin = new Adminstrator();

        /*
         * Mandatory informations
         */
        $admin->setUsername($input->getOption('username'));
        $admin->setPlainPassword($input->getOption('password'));
        $admin->setEmail($input->getOption('email'));
        $admin->setEmailBack($input->getOption('emailback'));

        /*
         * Optional informations
         */
        $admin->getInfoUser()->setFirstname($input->getOption('firstname'));
        $admin->getInfoUser()->setLastName($input->getOption('lastname'));
        $admin->getInfoUser()->setBirthday(\DateTime::createFromFormat('m/d/Y', $input->getOption('birthday')));

        /*
         * Encoding the password
         */
        $admin->setPassword(
            $encoderFactory
                ->getEncoder($admin)
                ->encodePassword(
                    $admin->getPlainPassword(),
                    $admin->getSalt()
                )
        );

        /*
         * Persisting the admin
         */
        $adminManager->create($admin);

        $questionHelper->writeGeneratorSummary($output, "Everything ok !");
    }

    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $questionHelper = $this->getQuestionHelper();
        $questionHelper->writeSection($output, "Welcome to the ChallengeMe Admin generator");

        /*
         * Username
         */
        $username = $input->getOption('username');
        $question = new Question($questionHelper->getQuestion(
            'Username',
            $username
        ), $username);
        $question
            ->setValidator(function($inputUsername) {
            return Validators::usernameValidator($inputUsername);
        });
        $username = $questionHelper->ask($input, $output, $question);
        $input->setOption('username', $username);

        /*
         * Password
         */
        $plainPassword = $input->getOption('password');
        $question = new Question($questionHelper->getQuestion(
            'Password',
            $plainPassword
        ), $plainPassword);

        $question
            ->setHidden(true)
            ->setHiddenFallback(false)
            ->setValidator(function($inputPassword) {
                return Validators::passwordValidator($inputPassword);
            });

        $plainPassword = $questionHelper->ask($input, $output, $question);
        $input->setOption('password', $plainPassword);

        /*
         * Email
         */
        $email = $input->getOption('email');
        $question = new Question($questionHelper->getQuestion(
            'Email',
            $email
        ), $email);
        $question
            ->setValidator(function($inputEmail) {
                return Validators::emailValidator($inputEmail);
            });
        $email = $questionHelper->ask($input, $output, $question);
        $input->setOption('email', $email);

        /*
         * Firstname
         */
        $firstName = $input->getOption('firstname');
        $question = new Question($questionHelper->getQuestion(
            'Firstname',
            $firstName
        ), $firstName);
        $question->setValidator(function($inputFirstName) {

            return Validators::noWhiteSpaceValidator($inputFirstName);
        });
        $firstName = $questionHelper->ask($input, $output, $question);
        $input->setOption('firstname', $firstName);

        /*
         * LastName
         */
        $lastName = $input->getOption('lastname');
        $question = new Question($questionHelper->getQuestion(
            'Lastname',
            $lastName
        ), $lastName);
        $question
            ->setValidator(function($inputLastname) {
                return Validators::noWhiteSpaceValidator($inputLastname);
            });
        $lastName = $questionHelper->ask($input, $output, $question);
        $input->setOption('lastname', $lastName);

        /*
         * Additionnal email
         */
        $emailBack = $input->getOption('emailback');
        $question = new Question($questionHelper->getQuestion(
            'Additionnal email',
            $emailBack
        ), $emailBack);
        $question
            ->setValidator(function($inputEmail) {
                return Validators::emailValidator($inputEmail);
            });
        $emailBack = $questionHelper->ask($input, $output, $question);
        $input->setOption('emailback', $emailBack);

        /*
         * Birthday
         */
        $birthday = $input->getOption('birthday');
        $question = new Question($questionHelper->getQuestion(
            'Birthday (m/d/y)',
            $birthday
        ), $birthday);

        $birthday = $questionHelper->ask($input, $output, $question);
        $input->setOption('birthday', $birthday);
    }

    protected function createGenerator()
    {
        // TODO: Implement createGenerator() method.
    }
}