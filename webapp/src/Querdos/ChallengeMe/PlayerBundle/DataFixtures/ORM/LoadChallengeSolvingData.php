<?php
/**
 * Created by Hamza ESSAYEGH
 * User: querdos
 * Date: 3/24/17
 * Time: 5:26 PM
 */

namespace Querdos\ChallengeMe\PlayerBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Querdos\ChallengeMe\ChallengesBundle\Entity\Challenge;
use Querdos\ChallengeMe\ChallengesBundle\Entity\ChallengeSolving;
use Querdos\ChallengeMe\UserBundle\Entity\Team;

class LoadChallengeSolvingData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // retrieving faker
        $faker = Factory::create();

        // retrieving teams
        /** @var Team[] $teams */
        for ($i=0; $i<30; $i++) {
            $teams[] = $this->getReference("team-$i");
        }

        // retrieving challenges
        /** @var Challenge[] $challenges */
        for ($i=0; $i<125; $i++) {
            $challenges[] = $this->getReference("challenge-$i");
        }

        // generating solving for each team
        foreach($teams as $team) {
            // each team solved 75 challenges
            for ($i=0; $i<75; $i++) {
                // retrieving a challenge that hasn't been solved
                do {
                    $challenge = $challenges[$faker->numberBetween(0, 124)];
                } while ($manager->getRepository(ChallengeSolving::class)->teamHasSolvedChallenge($team, $challenge));

                // setting solved
                $challengeSolving = new ChallengeSolving(
                    $team,
                    $challenge,
                    true
                );

                $challengeSolving
                    ->setDateEnd($dateEnd = $faker->dateTimeThisMonth)
                    ->setDateStart($faker->dateTimeThisMonth($dateEnd))
                    ->setDuration()
                ;

                // persisting the entity
                $manager->persist($challengeSolving);

                // increasing team's points and persisting
                $team->incrementScore($challenge->getPoints());
                $manager->persist($team);

            }

            // flushing
            $manager->flush();
        }
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 7;
    }
}