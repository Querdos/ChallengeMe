<?php
/**
 * Created by Hamza ESSAYEGH
 * Date : 11/13/2016
 * Time : 14:28 PM
 */

namespace Querdos\ChallengeMe\UserBundle\Command;

use Querdos\ChallengeMe\UserBundle\Entity\InfoUser;
use Querdos\ChallengeMe\UserBundle\Entity\PersonalInformation;
use Querdos\ChallengeMe\UserBundle\Validator\RedactorValidator;
use Sensio\Bundle\GeneratorBundle\Command\GeneratorCommand;
use Sensio\Bundle\GeneratorBundle\Command\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

class CreateRedactorCommand extends GeneratorCommand 
{
	/**
	 * @var RedactorValidator $redactorValidator
	 */
	private $redactorValidator;

    /**
     * @var RedactorManager $redactorManager
     */
    private $redactorManager;

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

        // Retrieving validator and manager
		$this->redactorValidator = $container->get('challengeme.validator.redactor');
        $this->redactorManager   = $container->get('challengeme.manager.redactor');

        // Retrieving the question helper
        $this->questionHelper    = $this->getQuestionHelper();
	}
	
	/**
	 * {@inheritDoc}
	 */
	public function configure() 
	{
		$this
			->setName('challengeme:generate:redactor')
			->setDescription('Generate a redactor')
			
			->setDefinition(array(
					new InputOption("username", '', InputOption::VALUE_REQUIRED, "The username of the admin to create"),
					new InputOption("password", '', InputOption::VALUE_REQUIRED, "The password of the admin to create"),
					new InputOption("email",    '', InputOption::VALUE_REQUIRED, "The email of the admin to create"),
					
					new InputOption("firstname", '', InputOption::VALUE_OPTIONAL, "The firstname of the admin to create"),
					new InputOption("lastname",  '', InputOption::VALUE_OPTIONAL, "The lastname of the admin to create"),
					new InputOption("emailback", '', InputOption::VALUE_OPTIONAL, "An additionnal email for the admin to create"),
			))
			->setHelp(<<<EOT
The <info>%command.name%</info> command helps you generates new redactor.

By default, the command interacts with the developer to tweak the generation.
Any passed option will be used as a default value for the interaction.

If you want to disable any user interaction, use <comment>--no-interaction</comment> but don't forget to pass all needed options:
<info>%command.full_name% --username=root --password=toor --email=admin@challengeme.com				
EOT
			)
		;
	}
	
	public function execute(InputInterface $input, OutputInterface $output)
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
		$redactor            = new Redactor();
		$infoUser            = new InfoUser();
		$personalInformation = new PersonalInformation();
		
		/*
		 * Optional informations
		 */
		$infoUser
			->setFirstName($input->getOption('firstname'))
			->setLastName($input->getOption('lastname'))
			->setBirthday(
				new \DateTime($input->getOption('birthday'))
			)
            ->setLocale('en')
            ->setPersonalInformation($personalInformation)
        ;
		
		/*
		 * Mandatory informations
		 */
		$redactor
			->setUsername($input->getOption('username'))
			->setPlainPassword($input->getOption('password'))
			->setEmail($input->getOption('email'))
			->setEmailBack($input->getOption('emailback'))
			->setInfoUser($infoUser)
		;
		
		/*
		 * Persisting the admin
		 */
		$this->redactorManager->create($redactor);
		
		/*
		 * Summary
		 */
		$this->questionHelper->writeGeneratorSummary($output, null);
	}
	
	protected function createGenerator() {}
}