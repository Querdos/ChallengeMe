<?php
/**
 * Created by Hamza ESSAYEGH
 * Date : 11/13/2016
 * Time : 14:28 PM
 */

namespace Querdos\ChallengeMe\AdministratorBundle\Command;

use Sensio\Bundle\GeneratorBundle\Command\GeneratorCommand;
use Querdos\ChallengeMe\AdministratorBundle\Validator\RedactorValidator;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Proxies\__CG__\Querdos\ChallengeMe\AdministratorBundle\Entity\Redactor;
use Querdos\ChallengeMe\AdministratorBundle\Entity\InfoUser;

class CreateRedactorCommand extends GeneratorCommand 
{
	/**
	 * @var RedactorValidator $redactorValidator
	 */
	private $redactorValidator;
	
	/**
	 * {@inheritDoc}
	 */
	protected function initialize(InputInterface $input, OutputInterface $output)
	{
		$this->redactorValidator = $this->getContainer()->get('challengeme.validator.redactor');
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
		/** @var QuestionHelper $questionHelper */
		$questionHelper 	= $this->getQuestionHelper();
		
		/** @var AdministratorManager $adminManager */
		$redactorManager 	= $this->getContainer()->get('challengeme.manager.redactor');
		
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
		
		// Creating new objects
		$redactor   = new Redactor();
		$infoUser   = new InfoUser();
		
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
		$redactorManager->create($redactor);
		
		/*
		 * Summary
		 */
		$questionHelper->writeGeneratorSummary($output, null);
	}
	
	protected function createGenerator() {}
}