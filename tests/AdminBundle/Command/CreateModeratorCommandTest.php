<?php
/**
 * Created by Hamza ESSAYEGH.
 * Date: 6/5/16
 * Time: 7:50 PM
 */

namespace Tests\AdminBundle\Command;


use Querdos\ChallengeMe\AdministratorBundle\Command\CreateAdminCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class CreateModeratorCommandTest extends \PHPUnit_Framework_TestCase
{
    public function testInterract()
    {
        $application = new Application();
        $application->add(new CreateAdminCommand());

        $command = $application->find('challengeme:generate:admin');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command'   => $command->getName()
        ));

        $this->assertRegExp('/.../', $commandTester->getDisplay());
    }
}