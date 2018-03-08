<?php
/**
 * Created by Hamza ESSAYEGH
 * User: querdos
 * Date: 3/24/17
 * Time: 2:59 PM
 */

namespace Querdos\ChallengeMe\PlayerBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Querdos\ChallengeMe\UserBundle\Entity\Administrator;
use Querdos\ChallengeMe\UserBundle\Entity\InfoUser;
use Querdos\ChallengeMe\UserBundle\Entity\PersonalInformation;
use Querdos\ChallengeMe\UserBundle\Entity\Player;
use Querdos\ChallengeMe\UserBundle\Entity\Role;
use Querdos\ChallengeMe\UserBundle\Entity\Skill;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Faker\Factory;

/**
 * /!\  Do not use these OrderedFixture in production, it's just to fill the database in order
 *      to have a visual of the platform with subscribed players
 *
 * Will generate :
 *      - 90   Player for each player
 *      - 3     Player for 3 administrator (admin, moderator, redac)
 *
 * Notice: password for all players -> password-player
 *
 * Class LoadUserData
 * @package Querdos\ChallengeMe\PlayerBundle\DataFixtures\ORM
 */
class LoadUserData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // initial objects
        $player = new Player();

        // retrieving encoder for the password
        $encoder = $this->container->get('security.password_encoder');

        // retrieving faker
        $faker = Factory::create();

        // generating players
        for ($i=0; $i<90; $i++) {
            $persoInfo  = new PersonalInformation();
            $persoInfo
                ->setAddress($faker->address)
                ->setJob($faker->jobTitle)
                ->setWebsite($faker->url)
            ;

            /** @var InfoUser $infoPlayer */
            $infoPlayer = $this->getReference("info-player-$i");
            $infoPlayer->setPersonalInformation($persoInfo);

            $player
                ->setUsername($faker->userName)
                ->setEmail($faker->email)
                ->setEmailBack($faker->email)
                ->setPassword(
                    $encoder->encodePassword($player, 'password-player')
                )
                ->setInfoUser($infoPlayer)
            ;

            // persisting
            $manager->persist($player);

            // adding reference
            $this->addReference("player-$i", $player);

            $player = new Player();
        }

        $manager->flush();

        // retrieving roles
        /** @var Role $roleAdmin */
        $roleAdmin          = $this->getReference('role-admin');
        /** @var Role $roleRedactor */
        $roleRedactor       = $this->getReference('role-redactor');
        /** @var Role $roleModerator */
        $roleModerator      = $this->getReference('role-moderator');

        // retrieving info user
        /** @var InfoUser $infoAdmin */
        $infoAdmin          = $this->getReference('info-admin');
        /** @var InfoUser $infoModo */
        $infoModo           = $this->getReference('info-moderator');

        // setting personnal informations
        $persoInfoAdmin     = new PersonalInformation();
        $persoInfoAdmin
            ->setAddress($faker->address)
            ->setJob($faker->jobTitle)
            ->setWebsite($faker->url)
        ;

        $infoAdmin->setPersonalInformation($persoInfoAdmin);
        $persoInfoModo      = new PersonalInformation();
        $persoInfoModo
            ->setAddress($faker->address)
            ->setJob($faker->jobTitle)
            ->setWebsite($faker->url)
        ;

        $infoModo->setPersonalInformation($persoInfoModo);


        // generating admin
        $admin = new Administrator();
        $admin
            ->setUsername('admin')
            ->setEmail($faker->email)
            ->setEmailBack($faker->email)
            ->setPassword(
                $encoder->encodePassword($admin, 'password-admin')
            )
            ->setInfoUser($infoAdmin)
            ->setRole($roleAdmin)
        ;

        $manager->persist($admin);

        // generating moderator
        $admin = new Administrator();
        $admin
            ->setUsername('moderator')
            ->setEmail($faker->email)
            ->setEmailBack($faker->email)
            ->setPassword(
                $encoder->encodePassword($admin, 'password-admin')
            )
            ->setInfoUser($infoModo)
            ->setRole($roleModerator)
        ;

        $manager->persist($admin);

        // generating redactors
        for ($i=0; $i<10; $i++) {
            $persoInfoRedac     = new PersonalInformation();
            $persoInfoRedac
                ->setAddress($faker->address)
                ->setJob($faker->jobTitle)
                ->setWebsite($faker->url)
            ;

            /** @var InfoUser $infoRedac */
            $infoRedac = $this->getReference("info-redactor-$i");

            $infoRedac->setPersonalInformation($persoInfoRedac);

            $admin = new Administrator();
            $admin
                ->setUsername("redactor-$i")
                ->setEmail($faker->email)
                ->setEmailBack($faker->email)
                ->setPassword(
                    $encoder->encodePassword($admin, 'password-admin')
                )
                ->setInfoUser(
                    $infoRedac
                )
                ->setRole($roleRedactor)
            ;

            $manager->persist($admin);
            $this->addReference("redactor-$i", $admin);
        }

        // finally flushing
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