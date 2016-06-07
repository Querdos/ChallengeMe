<?php
/**
 * Created by Hamza ESSAYEGH.
 * Date: 6/7/16
 * Time: 9:40 PM
 */

namespace Querdos\ChallengeMe\AdministratorBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Querdos\ChallengeMe\AdministratorBundle\Entity\Administrator;
use Querdos\ChallengeMe\AdministratorBundle\Entity\InfoUser;
use Querdos\ChallengeMe\AdministratorBundle\Entity\Moderator;
use Querdos\ChallengeMe\AdministratorBundle\Entity\Redactor;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Tests\Encoder\PasswordEncoder;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{

    /**
     * @var ContainerInterface $container
     */
    private $container;

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        // Initial objects
        $userAdmin      = new Administrator();
        $userModerator  = new Moderator();
        $userRedactor   = new Redactor();

        /** @var PasswordEncoder $encoder */
        $encoder            = $this->container->get('security.password_encoder');

        $passwordAdmin      = $encoder->encodePassword($userAdmin, 'admin');
        $passwordModerator  = $encoder->encodePassword($userModerator, 'moderator');
        $passwordRedactor    = $encoder->encodePassword($userRedactor, 'redactor');

        /** @var InfoUser $infoAdmin */
        $infoAdmin      = $this->getReference('admin-info');

        /** @var InfoUser $infoModerator */
        $infoModerator  = $this->getReference('moderator-info');

        /** @var InfoUser $infoRedactor */
        $infoRedactor   = $this->getReference('redactor-info');

        // Hidrating admin
        $userAdmin
            ->setUsername('admin')
            ->setEmail('admin@challengeme.com')
            ->setEmailBack('admin@gmail.com')
            ->setPassword($passwordAdmin)
            ->setInfoUser($infoAdmin);
        ;

        // Hidrating moderator
        $userModerator
            ->setUsername('moderator')
            ->setEmail('moderator@challengeme.com')
            ->setEmailBack('moderator@gmail.com')
            ->setPassword($passwordModerator)
            ->setInfoUser($infoModerator)
        ;

        // Hidrating redactor
        $userRedactor
            ->setUsername('redactor')
            ->setEmail('redactor@challengeme.com')
            ->setEmailBack('redactor@gmail.com')
            ->setPassword($passwordRedactor)
            ->setInfoUser($infoRedactor)
        ;

        $manager->persist($userAdmin);
        $manager->persist($userModerator);
        $manager->persist($userRedactor);
        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 2;
    }

    public function setContainer(ContainerInterface $containerInterface = null)
    {
        $this->container = $containerInterface;
    }
}