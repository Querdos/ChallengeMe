<?php
/**
 * Created by Hamza ESSAYEGH
 * User: querdos
 * Date: 3/24/17
 * Time: 2:47 PM
 */

namespace Querdos\ChallengeMe\PlayerBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Querdos\ChallengeMe\UserBundle\Entity\InfoUser;
use Faker\Factory;

/**
 * /!\  Do not use these OrderedFixture in production, it's just to fill the database in order
 *      to have a visual of the platform with subscribed players
 *
 * Will generate :
 *      - 90   infoUser for each player
 *      - 3     infoUser for 3 administrator (admin, moderator, redac)
 *
 * Class LoadInfoUserData
 * @package Querdos\ChallengeMe\PlayerBundle\DataFixtures\ORM
 */
class LoadInfoUserData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // creating a basic object
        $infoUser = new InfoUser();

        // loading faker
        $faker = Factory::create();

        // generating players
        for ($i=0; $i<90; $i++) {
            $infoUser
                ->setFirstName($faker->firstName)
                ->setLastName($faker->lastName)
                ->setBirthday($faker->dateTime)
            ;

            $manager->persist($infoUser);
            $manager->flush();

            $this->addReference("info-player-$i", $infoUser);

            $infoUser = new InfoUser();
        }

        // generating admin
        $infoUser
            ->setFirstName($faker->firstName)
            ->setLastName($faker->lastName)
            ->setBirthday($faker->dateTime)
        ;

        $manager->persist($infoUser);
        $manager->flush();

        $this->addReference("info-admin", $infoUser);

        $infoUser = new InfoUser();

        // generating moderator
        $infoUser
            ->setFirstName($faker->firstName)
            ->setLastName($faker->lastName)
            ->setBirthday($faker->dateTime)
        ;

        $manager->persist($infoUser);
        $manager->flush();

        $this->addReference("info-moderator", $infoUser);

        $infoUser = new InfoUser();

        for ($i=0; $i<10; $i++) {
            // generating redactor
            $infoUser
                ->setFirstName($faker->firstName)
                ->setLastName($faker->lastName)
                ->setBirthday($faker->dateTime)
            ;

            $manager->persist($infoUser);
            $manager->flush();

            $this->addReference("info-redactor-$i", $infoUser);

            $infoUser = new InfoUser();
        }
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
}