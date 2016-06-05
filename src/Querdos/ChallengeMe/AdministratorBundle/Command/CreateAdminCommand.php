<?php
/**
 * Created by Hamza ESSAYEGH.
 * Date: 6/5/16
 * Time: 11:37 AM
 */

namespace Querdos\ChallengeMe\AdministratorBundle\Command;

use Querdos\ChallengeMe\AdministratorBundle\Entity\Administrator;
use Querdos\ChallengeMe\AdministratorBundle\Entity\InfoUser;
use Querdos\ChallengeMe\AdministratorBundle\Manager\AdministratorManager;
use Querdos\ChallengeMe\AdministratorBundle\Validator\AdminValidator;
use Sensio\Bundle\GeneratorBundle\Command\GeneratorCommand;
use Sensio\Bundle\GeneratorBundle\Command\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\VarDumper\VarDumper;

class CreateAdminCommand extends GeneratorCommand
{

    /**
     * @var AdminValidator $adminValidator
     */
    private $adminValidator;

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->adminValidator = $this->getContainer()->get('challengeme.validator.admin');
    }

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
     * @param   InputInterface $input
     * @param   OutputInterface $output
     * 
     * @return  int|null|void
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var QuestionHelper $questionHelper */
        $questionHelper = $this->getQuestionHelper();

        /** @var AdministratorManager $adminManager */
        $adminManager = $this->getContainer()->get('challengeme.manager.administrator');
        
        /*
         * Summary before generation
         */
        $questionHelper->writeSection($output, "Summary before generation");

        $output->writeln("Firstname:\t<info>" .     $input->getOption('firstname') . "</info>");
        $output->writeln("Lastname:\t<info>" .      $input->getOption('lastname') . "</info>");
        $output->writeln("Username:\t<info>" .      $input->getOption('username') . "</info>");
        $output->writeln("Email:\t\t<info>" .       $input->getOption('email') . "</info>");
        $output->writeln("Email (2):\t<info>" .     $input->getOption('emailback') . "</info>");
        $output->writeln("Birthday:\t<info>" .      $input->getOption('birthday') . "</info>");
        $output->writeln("");

        $question = new ConfirmationQuestion("Continue ? (y|n)", true);
        if (!$questionHelper->ask($input, $output, $question)) {
            $this->interact($input, $output);
        }

        $admin      = new Administrator();
        $infoUser   = new InfoUser();

        $encoder    = $this->getContainer()->get('security.password_encoder');

        /*
         * Optional informations
         */
        $infoUser
            ->setFirstName($input->getOption('firstname'))
            ->setLastName($input->getOption('lastname'))
            ->setBirthday(
                new \DateTime($input->getOption('birthday'))
            );

        /*
         * Mandatory informations
         */
        $admin
            ->setUsername($input->getOption('username'))
            ->setPlainPassword($input->getOption('password'))
            ->setEmail($input->getOption('email'))
            ->setEmailBack($input->getOption('emailback'))
            ->setInfoUser($infoUser)
            ->setPassword($encoder->encodePassword($admin, $admin->getPlainPassword()))
            ->eraseCredentials();
        /*
         * Persisting the admin
         */
        $adminManager
            ->create($admin);

        /*
         * Summary
         */
        $questionHelper->writeGeneratorSummary($output, null);
    }

    protected function interact(InputInterface $input, OutputInterface $output)
    {
        /** @var QuestionHelper $questionHelper */
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
            ->setMaxAttempts(3)
            ->setValidator(function($inputUsername) {
                return $this->adminValidator->validateUsername($inputUsername);
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
            ->setMaxAttempts(3)
            ->setHidden(true)
            ->setHiddenFallback(false)
            ->setValidator(function($inputPassword) {
                return $this->adminValidator->validatePassword($inputPassword);
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
            ->setMaxAttempts(3)
            ->setValidator(function($inputEmail) {
                return $this->adminValidator->validateEmail($inputEmail);
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
        $question
            ->setMaxAttempts(3)
            ->setValidator(function($inputFirstName) {
                return $this->adminValidator->validateFirstname($inputFirstName);
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
            ->setMaxAttempts(3)
            ->setValidator(function($inputLastname) {
                return $this->adminValidator->validateLastname($inputLastname);
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
            ->setMaxAttempts(3)
            ->setValidator(function($inputEmail) {
                return $this->adminValidator->validateEmailBack($inputEmail);
            });
        $emailBack = $questionHelper->ask($input, $output, $question);
        $input->setOption('emailback', $emailBack);

        /*
         * Birthday
         */
        $birthday = $input->getOption('birthday');
        $question = new Question($questionHelper->getQuestion(
            'Birthday (YYYY-MM-DD)',
            $birthday
        ), $birthday);
        $question
            ->setMaxAttempts(3)
            ->setValidator(function($inputBirthday) {
                return $this->adminValidator->validateBirthday($inputBirthday);
            });
        $birthday = $questionHelper->ask($input, $output, $question);
        $input->setOption('birthday', $birthday);
    }

    protected function createGenerator()
    {
        // TODO: Implement createGenerator() method.
    }
}