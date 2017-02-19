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
use Querdos\ChallengeMe\AdministratorBundle\Entity\Role;
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
        // roles
        /** @var Role $roleAdmin */
        $roleAdmin          = $this->getReference('role-admin');
        /** @var Role $roleRedactor */
        $roleRedactor       = $this->getReference('role-redactor');
        /** @var Role $roleModerator */
        $roleModerator      = $this->getReference('role-moderator');

        // Initial objects
        $userAdmin          = new Administrator();

        /** @var PasswordEncoder $encoder */
        $encoder            = $this->container->get('security.password_encoder');

        $passwordAdmin      = $encoder->encodePassword($userAdmin, 'admin');
        $passwordModo       = $encoder->encodePassword($userAdmin, 'modo');
        $passwordRedac      = $encoder->encodePassword($userAdmin, 'redac');

        /** @var InfoUser $infoAdmin */
        $infoAdmin          = $this->getReference('admin-info');
        /** @var InfoUser $infoModo */
        $infoModo           = $this->getReference('moderator-info');
        /** @var InfoUser $infoRedac */
        $infoRedac          = $this->getReference('redactor-info');

        // Hidrating admin
        $userAdmin
            ->setUsername('admin')
            ->setEmail('admin@challengeme.com')
            ->setEmailBack('admin@gmail.com')
            ->setPassword($passwordAdmin)
            ->setInfoUser($infoAdmin)
            ->setRole($roleAdmin)
        ;

        $manager->persist($userAdmin);

        // Hidrating moderator
        $userAdmin = new Administrator();
        $userAdmin
            ->setUsername('moderator')
            ->setEmail('moderator@challengeme.com')
            ->setEmailBack('moderator@gmail.com')
            ->setPassword($passwordModo)
            ->setInfoUser($infoModo)
            ->setRole($roleModerator)
        ;

        $manager->persist($userAdmin);

        // Hidrating redactor
        $userAdmin = new Administrator();
        $userAdmin
            ->setUsername('redactor')
            ->setEmail('redactor@challengeme.com')
            ->setEmailBack('redactor@gmail.com')
            ->setPassword($passwordRedac)
            ->setInfoUser($infoRedac)
            ->setRole($roleRedactor)
        ;

        $manager->persist($userAdmin);
        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 3;
    }

    public function setContainer(ContainerInterface $containerInterface = null)
    {
        $this->container = $containerInterface;
    }
}