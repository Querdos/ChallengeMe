<?php
/**
 * Created by Hamza ESSAYEGH.
 * Date: 6/5/16
 * Time: 11:37 AM
 */

namespace Querdos\ChallengeMe\AdministratorBundle\Command;


use Querdos\ChallengeMe\AdministratorBundle\Validator\ModeratorValidator;
use Sensio\Bundle\GeneratorBundle\Command\GeneratorCommand;
use Sensio\Bundle\GeneratorBundle\Command\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class CreateModeratorCommand extends GeneratorCommand
{
    /**
     * @var ModeratorValidator $moderatorValidator
     */
    private $moderatorValidator;

    protected function initialize(InputInterface $inputInterface, OutputInterface $outputInterface)
    {
        $this->moderatorValidator = $this->getContainer()->get('challengeme.validator.moderator');
    }

    // TODO : Update help (user interaction)
    public function configure()
    {
        $this
            ->setName("challengeme:generate:moderator")
            ->setDescription("Generate administrator")

            ->setDefinition(array(
                new InputOption("username", '', InputOption::VALUE_REQUIRED, "The username of the moderator to create"),
                new InputOption("password", '', InputOption::VALUE_REQUIRED, "The password of the moderator to create"),
                new InputOption("email",    '', InputOption::VALUE_REQUIRED, "The email of the moderator to create"),

                new InputOption("firstname", '', InputOption::VALUE_OPTIONAL, "The firstname of the moderator to create"),
                new InputOption("lastname",  '', InputOption::VALUE_OPTIONAL, "The lastname of the moderator to create"),
                new InputOption("emailback", '', InputOption::VALUE_OPTIONAL, "An additional email for the moderator to create"),
                new InputOption("birthday",  '', InputOption::VALUE_OPTIONAL, "The birthday of the moderator to create")
            ))
            ->setHelp(<<<EOT
The <info>%command.name%</info> command helps you generates new moderator.

By default, the command interacts with the developer to tweak the generation.
Any passed option will be used as a default value for the interaction.

If you want to disable any user interaction, use <comment>--no-interaction</comment> but don't forget to pass all needed options:
<info>php %command.full_name% --username=root --password=toor --email=admin@challengeme.com
EOT
);
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        //
    }

    /**
     * {@inheritdoc}
     */
    public function interact(InputInterface $input, OutputInterface $output)
    {
        /** @var QuestionHelper $questionHelper */
        $questionHelper = $this->getQuestionHelper();

        $questionHelper->writeSection($output, "Welcome to the ChallengeMe Moderator generator");

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
                return $this->moderatorValidator->validateUsername($inputUsername);
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
                return $this->moderatorValidator->validatePassword($inputPassword);
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
                return $this->moderatorValidator->validateEmail($inputEmail);
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
                return $this->moderatorValidator->validateFirstname($inputFirstName);
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
                return $this->moderatorValidator->validateLastname($inputLastname);
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
                return $this->moderatorValidator->validateEmailBack($inputEmail);
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
                return $this->moderatorValidator->validateBirthday($inputBirthday);
            });
        $birthday = $questionHelper->ask($input, $output, $question);
        $input->setOption('birthday', $birthday);
    }

    protected function createGenerator()
    {
        // TODO: Implement createGenerator() method.
    }
}