<?php
/**
 * Created by Hamza ESSAYEGH
 * User: querdos
 * Date: 3/24/17
 * Time: 3:24 PM
 */

namespace Querdos\ChallengeMe\PlayerBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Querdos\ChallengeMe\UserBundle\Entity\Team;

/**
 * /!\  Do not use these OrderedFixture in production, it's just to fill the database in order
 *      to have a visual of the platform with subscribed players
 *
 * Will generate :
 *      - 190   Player for each player
 *      - 3     Administrator (admin, moderator, redac)
 *
 * Class LoadTeamData
 * @package Querdos\ChallengeMe\PlayerBundle\DataFixtures\ORM
 */
class LoadTeamData extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // creating a basic team object
        $team = new Team();

        // retrieving faker
        $faker = Factory::create();

        $counter = 0;
        for ($i=0; $i<90; $i+=3) {
            // retreving corresponding players
            /** Player[] $players */
            $players[] = $this->getReference('player-' . ($i));
            $players[] = $this->getReference('player-' . ($i+1));
            $players[] = $this->getReference('player-' . ($i+2));

            // creating the team for them
            $team
                ->setName($faker->company)
                ->setLeader($players[0])
            ;

            $manager->persist($team);

            $this->addReference("team-" . ($counter++), $team);

            foreach($players as $player) {
                $player->setTeam($team);
                $manager->persist($player);
            }

            $players = [];
            $team = new Team();
        }

        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 4;
    }
}