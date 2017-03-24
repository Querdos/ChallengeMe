<?php
/**
 * Created by Hamza ESSAYEGH
 * User: querdos
 * Date: 3/24/17
 * Time: 4:32 PM
 */

namespace Querdos\ChallengeMe\PlayerBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Querdos\ChallengeMe\ChallengesBundle\Entity\Category;
use Querdos\ChallengeMe\ChallengesBundle\Entity\Challenge;
use Querdos\ChallengeMe\ChallengesBundle\Entity\ChallengeSolution;
use Querdos\ChallengeMe\UserBundle\Entity\Administrator;

class LoadChallengeData extends AbstractFixture implements OrderedFixtureInterface
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

        // retrieving categories
        /** @var Category[] $categories */
        for ($i=0; $i<25; $i++) {
            $categories[] = $this->getReference("category-$i");
        }

        // retrieving redactors
        /** @var Administrator[] $redacs */
        for ($i=0; $i<10; $i++) {
            $redacs[] = $this->getReference("redactor-$i");
        }

        $counter = 0;
        // generating challenges
        foreach ($categories as $index => $category) {
            for ($i=0; $i<5; $i++) {
                $challenge = new Challenge(
                    $faker->sentence(2),
                    $faker->sentence(50),
                    $faker->numberBetween(5, 30),
                    $faker->numberBetween(1, 5),
                    $faker->text(1000),
                    $category,
                    $redacs[$faker->numberBetween(0, 9)],
                    new ChallengeSolution("solution-" . ($counter))
                );

                $manager->persist($challenge);
                $this->addReference("challenge-" . ($counter), $challenge);
                $counter++;
            }
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
        return 6;
    }
}