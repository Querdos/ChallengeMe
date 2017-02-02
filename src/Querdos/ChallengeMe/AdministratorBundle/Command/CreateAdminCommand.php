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

class CreateAdminCommand extends GeneratorCommand
{

    /**
     * @var AdminValidator $adminValidator
     */
    private $adminValidator;

    /**
     * @var AdministratorManager $adminManager
     */
    private $adminManager;
    
    /**
     * @var QuestionHelper $questionHelper
     */
    private $questionHelper;
    
    /**
     * {@inheritDoc}
     */
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
    	// Retrieving the container
    	$container = $this->getContainer();
    	
    	// Initializing global attributes
        $this->adminValidator = $container->get('challengeme.validator.admin');
        $this->adminManager	  = $container->get('challengeme.manager.administrator');
        $this->questionHelper = $this->getQuestionHelper();
    }

    /**
     * {@inheritDoc}
     */
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

By default, the command interacts with the developer to tweak the generation.
Any passed option will be used as a default value for the interaction.

If you want to disable any user interaction, use <comment>--no-interaction</comment> but don't forget to pass all needed options:
<info>%command.full_name% --username=root --password=toor --email=admin@challengeme.com
EOT
);
    }

    /**
     * {@inheritdoc} 
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /*
         * Summary before generation
         */
        $this->questionHelper->writeSection($output, "Summary before generation");

        $output->writeln("Firstname:\t<info>" .     $input->getOption('firstname') . "</info>");
        $output->writeln("Lastname:\t<info>" .      $input->getOption('lastname') . "</info>");
        $output->writeln("Username:\t<info>" .      $input->getOption('username') . "</info>");
        $output->writeln("Email:\t\t<info>" .       $input->getOption('email') . "</info>");
        $output->writeln("Email (2):\t<info>" .     $input->getOption('emailback') . "</info>");
        $output->writeln("Birthday:\t<info>" .      $input->getOption('birthday') . "</info>");
        $output->writeln("");

        $question = new ConfirmationQuestion("Continue ? (y|n)", true);
        if (!$this->questionHelper->ask($input, $output, $question)) {
            $this->interact($input, $output);
        }

        // Creating new objects
        $admin      = new Administrator();
        $infoUser   = new InfoUser();

        /*
         * Optional informations
         */
        $infoUser
            ->setFirstName($input->getOption('firstname'))
            ->setLastName($input->getOption('lastname'))
            ->setBirthday(
                new \DateTime($input->getOption('birthday'))
            )
            ->setLocale('fr')
        ;

        /*
         * Mandatory informations
         */
        $admin
            ->setUsername($input->getOption('username'))
            ->setPlainPassword($input->getOption('password'))
            ->setEmail($input->getOption('email'))
            ->setEmailBack($input->getOption('emailback'))
            ->setInfoUser($infoUser)
        ;
        /*
         * Persisting the admin
         */
        $this->adminManager->create($admin);

        /*
         * Summary
         */
        $this->questionHelper->writeGeneratorSummary($output, null);
    }

    /**
     * {@inheritDoc}
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
    	// Initializing super
        parent::interact($input, $output);

        $this->questionHelper->writeSection($output, "Welcome to the ChallengeMe Admin generator");

        /*
         * Username
         */
        $username = $input->getOption('username');
        if (!$username) {
            $question = new Question($this->questionHelper->getQuestion(
                'Username',
                $username
            ), $username);
            $question
                ->setMaxAttempts(3)
                ->setValidator(function ($inputUsername) {
                    return $this->adminValidator->validateUsername($inputUsername);
                });
            $username = $this->questionHelper->ask($input, $output, $question);
            $input->setOption('username', $username);
        } else {
            $this->adminValidator->validateUsername($username);
        }

        /*
         * Password
         */
        $plainPassword = $input->getOption('password');
        if (!$plainPassword) {
            $question = new Question($this->questionHelper->getQuestion(
                'Password',
                $plainPassword
            ), $plainPassword);
            $question
                ->setMaxAttempts(3)
                ->setHidden(true)
                ->setHiddenFallback(false)
                ->setValidator(function ($inputPassword) {
                    return $this->adminValidator->validatePassword($inputPassword);
                });
            $plainPassword = $this->questionHelper->ask($input, $output, $question);
            $input->setOption('password', $plainPassword);
        } else {
            $this->adminValidator->validatePassword($plainPassword);
        }

        /*
         * Email
         */
        $email = $input->getOption('email');
        if (!$email) {
            $question = new Question($this->questionHelper->getQuestion(
                'Email',
                $email
            ), $email);
            $question
                ->setMaxAttempts(3)
                ->setValidator(function ($inputEmail) {
                    return $this->adminValidator->validateEmail($inputEmail);
                });
            $email = $this->questionHelper->ask($input, $output, $question);
            $input->setOption('email', $email);
        } else {
            $this->adminValidator->validateEmail($email);
        }

        /*
         * Firstname
         */
        $firstName = $input->getOption('firstname');
        if (!$firstName) {
            $question = new Question($this->questionHelper->getQuestion(
                'Firstname',
                $firstName
            ), $firstName);
            $question
                ->setMaxAttempts(3)
                ->setValidator(function ($inputFirstName) {
                    return $this->adminValidator->validateFirstname($inputFirstName);
                });
            $firstName = $this->questionHelper->ask($input, $output, $question);
            $input->setOption('firstname', $firstName);
        } else {
            $this->adminValidator->validateFirstname($firstName);
        }

        /*
         * LastName
         */
        $lastName = $input->getOption('lastname');
        if (!$lastName) {
            $question = new Question($this->questionHelper->getQuestion(
                'Lastname',
                $lastName
            ), $lastName);
            $question
                ->setMaxAttempts(3)
                ->setValidator(function ($inputLastname) {
                    return $this->adminValidator->validateLastname($inputLastname);
                });
            $lastName = $this->questionHelper->ask($input, $output, $question);
            $input->setOption('lastname', $lastName);
        } else {
            $this->adminValidator->validateLastname($lastName);
        }

        /*
         * Additionnal email
         */
        $emailBack = $input->getOption('emailback');
        if (!$emailBack) {
            $question = new Question($this->questionHelper->getQuestion(
                'Additionnal email',
                $emailBack
            ), $emailBack);
            $question
                ->setMaxAttempts(3)
                ->setValidator(function ($inputEmail) {
                    return $this->adminValidator->validateEmailBack($inputEmail);
                });
            $emailBack = $this->questionHelper->ask($input, $output, $question);
            $input->setOption('emailback', $emailBack);
        } else {
            $this->adminValidator->validateEmailBack($emailBack);
        }

        /*
         * Birthday
         */
        $birthday = $input->getOption('birthday');
        if (!$birthday) {
            $question = new Question($this->questionHelper->getQuestion(
                'Birthday (YYYY-MM-DD)',
                $birthday
            ), $birthday);
            $question
                ->setMaxAttempts(3)
                ->setValidator(function ($inputBirthday) {
                    return $this->adminValidator->validateBirthday($inputBirthday);
                });
            $birthday = $this->questionHelper->ask($input, $output, $question);
            $input->setOption('birthday', $birthday);
        } else {
            $this->adminValidator->validateBirthday($birthday);
        }
    }

    /**
     * {@inheritDoc}
     */
    protected function createGenerator() {}
}