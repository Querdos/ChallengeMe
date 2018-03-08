<?php
/**
 * Created by Hamza ESSAYEGH.
 * User: querdos
 * Date: 21/02/17
 * Time: 11:42
 */

namespace Querdos\ChallengeMe\UserBundle\Command;


use Faker\Factory;
use Querdos\ChallengeMe\UserBundle\Entity\Administrator;
use Querdos\ChallengeMe\UserBundle\Entity\InfoUser;
use Querdos\ChallengeMe\UserBundle\Entity\PersonalInformation;
use Querdos\ChallengeMe\UserBundle\Entity\Role;
use Querdos\ChallengeMe\UserBundle\Manager\AdministratorManager;
use Sensio\Bundle\GeneratorBundle\Command\GeneratorCommand;
use Sensio\Bundle\GeneratorBundle\Command\Helper\QuestionHelper;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateAdminsCommand extends GeneratorCommand
{
    /**
     * @var AdministratorManager $adminManager
     */
    private $adminManager;

    /**
     * @var QuestionHelper $questionHelper
     */
    private $questionHelper;

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        // Retrieving the container
        $container = $this->getContainer();

        // Initializing global attributes
        $this->adminManager     = $container->get('challengeme.manager.administrator');
        $this->questionHelper   = $this->getQuestionHelper();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName("challengeme:generate:fake-admins")
            ->setDescription("Generate a list of fake administrators")

            ->setDefinition(array(
                new InputArgument("number", InputArgument::REQUIRED, "The number of administrators to generate", null),
                new InputArgument("role", InputArgument::REQUIRED, "The role for each admin to generate", null)
            ))
            ->setHelp(<<<EOT
"The <info>%command.name%</info> command helps you generates a list of fake admins.
EOT
);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Retrieving the count from given argument
        $count = $input->getArgument('number');
        $role  = $input->getArgument('role');

        // Checking the given role
        if (false === Role::check($role)) {
            throw new \Exception("Role not recognized");
        }

        // Retrieving faker
        $faker = Factory::create();

        // Creating progressbar
        $progress = new ProgressBar($output, $count);

        // Information
        switch ($role) {
            case Role::ROLE_ADMIN:
                $output->writeln("Generating administrators...");
            break;

            case Role::ROLE_MODERATOR:
                $output->writeln("Generating moderators...");
            break;

            case Role::ROLE_REDACTOR:
                $output->writeln("Generating redactors...");
            break;
        }

        // Generation
        for ($i=0; $i<$count; $i++) {
            $admin                  = new Administrator();
            $infoUser               = new InfoUser();
            $personalInformation    = new PersonalInformation();

            // Personal information
            $personalInformation
                ->setAddress($faker->address)
                ->setJob($faker->jobTitle)
                ->setWebsite($faker->url)
            ;

            // Basic informations
            $infoUser
                ->setFirstName($faker->firstName)
                ->setLastName($faker->lastName)
                ->setBirthday($faker->dateTimeThisCentury)
                ->setLocale('en')
                ->setPersonalInformation($personalInformation)
            ;

            // Admin entity
            $admin
                ->setUsername($faker->userName)
                ->setEmail($faker->email)
                ->setEmailBack($faker->companyEmail)
                ->setPlainPassword($faker->password)
                ->setInfoUser($infoUser)
            ;

            // Persisting
            $this->adminManager->create($admin, $role);

            // Progressing
            $progress->advance(1);
        }

        // Stopping the progress bar
        $progress->finish();

        // Everything ok
        $output->writeln("");
        $this->questionHelper->writeSection($output, "Generation complete");

    }

    /**
     * {@inheritdoc}
     */
    protected function createGenerator() {}
}