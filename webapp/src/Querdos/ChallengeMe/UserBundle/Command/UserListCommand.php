<?php
/**
 * Created by Hamza ESSAYEGH.
 * Date: 6/11/16
 * Time: 2:39 PM
 */

namespace Querdos\ChallengeMe\UserBundle\Command;

use Querdos\ChallengeMe\UserBundle\Entity\Administrator;
use Querdos\ChallengeMe\UserBundle\Manager\AdministratorManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class UserListCommand extends ContainerAwareCommand
{
    /**
     * @var AdministratorManager $adminManager
     */
    private $adminManager;

    /**
     * {@inheritdoc}
     */
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        // Retrieving the container
        $container = $this->getContainer();

        // Initializing managers
        $this->adminManager     = $container->get('challengeme.manager.administrator');
    }

    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this
            ->setName('challengeme:administrators:list')
            ->setDefinition(array(
                new InputOption('admin',        '', InputOption::VALUE_NONE, 'Return the list of administrators'),
                new InputOption('moderators',   '', InputOption::VALUE_NONE, 'Return the list of moderators'),
                new InputOption('redactors',    '', InputOption::VALUE_NONE, 'Return the list of redactors'),
                new InputOption('all',          '', InputOption::VALUE_NONE, 'Return the complete list of administrators')
            ))
            ->setDescription('Return a readable list of administrators users')
            ->setHelp(<<<EOT
The <info>%command.name%</info> command returns you a readable list of administrators users :
    
    * Administrators
    * Moderators
    * Redactors
    
You can combine each of the three options below to get multiple list :
    
    * <info>--admin</info>
    * <info>--moderators</info>
    * <info>--redactors</info>
    
If the <info>--all</info> option is specified, no matter other options, it will output the complete list of administrators.
If no option is specified, the command will output the complete list.
EOT
)
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        // Getting options
        $administratorList  = $input->getOption('admin');
        $moderatorList      = $input->getOption('moderators');
        $redacatorList      = $input->getOption('redactors');
        $all                = $input->getOption('all');

        $output->writeln('');

        // All option
        if ($all) {
            $this->printAll($output);
            $output->writeln('');
            return;
        }

        // Administrator list
        elseif ($administratorList) {
            $this->printAdministrators($output);
            $output->writeln('');
        }

        // Moderator list
        elseif ($moderatorList) {
            $this->printModerators($output);
            $output->writeln('');
        }

        // Redactor list
        elseif ($redacatorList) {
            $this->printRedactors($output);
            $output->writeln('');
        }
        
        // Otherwise, the complete list
        else {
        	$this->printAll($output);
        	$output->writeln('');
        }
    }

    /**
     * Print Administrators list
     *
     * @param OutputInterface $output
     */
    private function printAdministrators(OutputInterface $output)
    {
        $table = new Table($output);
        $table->setHeaders([
            'Username',
            'First name',
            'Last name',
            'Email',
            'Email (2)',
            'Birthday'
        ]);

        /** @var Administrator $admin */
        foreach ($this->adminManager->all() as $admin) {
            $table->addRow([
                $admin->getUsername(),
                $admin->getInfoUser()->getFirstName(),
                $admin->getInfoUser()->getLastName(),
                $admin->getEmail(),
                $admin->getEmailBack(),
                $admin->getInfoUser()->getBirthday()->format('m / d / Y')
            ]);
        }

        $output->writeln('<comment>Administrators list:</comment>');
        $table->render();
    }

    /**
     * Print Moderators list
     *
     * @param OutputInterface $output
     */
    private function printModerators(OutputInterface $output)
    {
        $table = new Table($output);
        $table->setHeaders([
            'Username',
            'First name',
            'Last name',
            'Email',
            'Email (2)',
            'Birthday'
        ]);

        /** @var Moderator $moderator */
        foreach ($this->moderatorManager->all() as $moderator) {
            $table->addRow([
                $moderator->getUsername(),
                $moderator->getInfoUser()->getFirstName(),
                $moderator->getInfoUser()->getLastName(),
                $moderator->getEmail(),
                $moderator->getEmailBack(),
                $moderator
                    ->getInfoUser()
                    ->getBirthday()
                    ->format('m / d / Y')
            ]);
        }

        $output->writeln('<comment>Moderators list:</comment>');
        $table->render();
    }

    /**
     * Print Redactors list
     *
     * @param OutputInterface $output
     */
    private function printRedactors(OutputInterface $output)
    {
        $table = new Table($output);
        $table->setHeaders([
            'Username',
            'First name',
            'Last name',
            'Email',
            'Email (2)',
            'Birthday'
        ]);

        /** @var Redactor $redactor */
        foreach ($this->redactorManager->all() as $redactor) {
            $table->addRow([
                $redactor->getUsername(),
                $redactor->getInfoUser()->getFirstName(),
                $redactor->getInfoUser()->getLastName(),
                $redactor->getEmail(),
                $redactor->getEmailBack(),
                $redactor->getInfoUser()->getBirthday()->format('m / d / Y')
            ]);
        }

        $output->writeln('<comment>Redactors list:</comment>');
        $table->render();
    }

    /**
     * Print all lists
     *
     * @param OutputInterface $output
     */
    private function printAll(OutputInterface $output)
    {
        $table = new Table($output);
        $table->setHeaders(array(
            'Username',
            'First name',
            'Last name',
            'Email',
            'Email (2)',
            'Birthday',
            'Role'
        ));

        /** @var Administrator $administrator */
        foreach ($this->adminManager->all() as $administrator) {
            $table->addRow(array(
                $administrator->getUsername(),
                $administrator->getInfoUser()->getFirstName(),
                $administrator->getInfoUser()->getLastName(),
                $administrator->getEmail(),
                $administrator->getEmailBack(),
                $administrator->getInfoUser()->getBirthday()->format('m / d / Y'),
                'Administrator'
            ));
        }

        /** @var Moderator $moderator */
        foreach ($this->moderatorManager->all() as $moderator) {
            $table->addRow([
                $moderator->getUsername(),
                $moderator->getInfoUser()->getFirstName(),
                $moderator->getInfoUser()->getLastName(),
                $moderator->getEmail(),
                $moderator->getEmailBack(),
                $moderator->getInfoUser()->getBirthday()->format('m / d / Y'),
                'Moderator'
            ]);
        }

        /** @var Redactor $redactor */
        foreach ($this->redactorManager->all() as $redactor) {
            $table->addRow([
                $redactor->getUsername(),
                $redactor->getInfoUser()->getFirstName(),
                $redactor->getInfoUser()->getLastName(),
                $redactor->getEmail(),
                $redactor->getEmailBack(),
                $redactor->getInfoUser()->getBirthday()->format('m / d / Y'),
                'Redactor'
            ]);
        }

        $output->writeln('Complete list:');
        $table->render();
    }
}