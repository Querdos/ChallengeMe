<?php
/**
 * Created by Hamza ESSAYEGH
 * User: querdos
 * Date: 4/6/17
 * Time: 3:46 PM
 */

namespace Querdos\ChallengeMe\AdministratorBundle\Command;


use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CheckAndCleanPasswordTokenCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this
            ->setName("challengeme:check-clean-pass-token")
            ->setDescription('Check and clean password tokens (expiration date)')
        ;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        // retrieving manager
        $manager = $this->getContainer()->get('challengeme.manager.password_token_reset');

        // retrieving expired tokens
        $expired = $manager->getExpired();

        foreach ($expired as $exp) {
            $token = $manager->readById($exp['id']);
            $manager->delete($token);
        }
    }
}