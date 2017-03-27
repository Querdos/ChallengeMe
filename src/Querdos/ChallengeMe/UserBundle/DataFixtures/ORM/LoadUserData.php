<?php
/**
 * Created by Hamza ESSAYEGH.
 * Date: 6/7/16
 * Time: 9:40 PM
 */

namespace Querdos\ChallengeMe\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Provider\ar_JO\Person;
use Querdos\ChallengeMe\UserBundle\Entity\Administrator;
use Querdos\ChallengeMe\UserBundle\Entity\InfoUser;
use Querdos\ChallengeMe\UserBundle\Entity\PersonalInformation;
use Querdos\ChallengeMe\UserBundle\Entity\Player;
use Querdos\ChallengeMe\UserBundle\Entity\Role;
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
        $player             = new Player();

        // Creating passwords
        /** @var PasswordEncoder $encoder */
        $encoder            = $this->container->get('security.password_encoder');

        // passwords for admins
        $passwordAdmin      = $encoder->encodePassword($userAdmin, 'admin');
        $passwordModo       = $encoder->encodePassword($userAdmin, 'modo');
        $passwordRedac      = $encoder->encodePassword($userAdmin, 'redac');

        // passwords for players
        $passwordPlayer1    = $encoder->encodePassword($player, 'player1');
        $passwordPlayer2    = $encoder->encodePassword($player, 'player2');
        $passwordPlayer3    = $encoder->encodePassword($player, 'player3');

        // info user
        /** @var InfoUser $infoAdmin */
        $infoAdmin          = $this->getReference('admin-info');
        /** @var InfoUser $infoModo */
        $infoModo           = $this->getReference('moderator-info');
        /** @var InfoUser $infoRedac */
        $infoRedac          = $this->getReference('redactor-info');
        /** @var InfoUser $infoPlayer1 */
        $infoPlayer1        = $this->getReference('player1-info');
        /** @var InfoUser $infoPlayer2 */
        $infoPlayer2        = $this->getReference('player2-info');
        /** @var InfoUser $infoPlayer3 */
        $infoPlayer3        = $this->getReference('player3-info');

        $persoInfoAdmin     = new PersonalInformation();
        $infoAdmin->setPersonalInformation($persoInfoAdmin);
        $persoInfoModo      = new PersonalInformation();
        $infoModo->setPersonalInformation($persoInfoModo);
        $persoInfoRedac     = new PersonalInformation();
        $infoRedac->setPersonalInformation($persoInfoRedac);
        $persoInfoPlayer1   = new PersonalInformation();
        $infoPlayer1->setPersonalInformation($persoInfoPlayer1);
        $persoInfoPlayer2   = new PersonalInformation();
        $infoPlayer2->setPersonalInformation($persoInfoPlayer2);
        $persoInfoPlayer3   = new PersonalInformation();
        $infoPlayer3->setPersonalInformation($persoInfoPlayer3);

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

        // Player 1
        $player
            ->setUsername('player1')
            ->setEmail('player1@challengeme.com')
            ->setEmailBack('player1@gmail.com')
            ->setPassword($passwordPlayer1)
            ->setInfoUser($infoPlayer1)
        ;

        $manager->persist($player);

        // Player 2
        $player = new Player();
        $player
            ->setUsername('player2')
            ->setEmail('player2@challengeme.com')
            ->setEmailBack('player2@gmail.com')
            ->setPassword($passwordPlayer2)
            ->setInfoUser($infoPlayer2)
        ;

        $manager->persist($player);

        // Player 3
        $player = new Player();
        $player
            ->setUsername('player3')
            ->setEmail('player3@challengeme.com')
            ->setEmailBack('player3@gmail.com')
            ->setPassword($passwordPlayer3)
            ->setInfoUser($infoPlayer3)
        ;

        $manager->persist($player);

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