<?php
/**
 * Created by Hamza ESSAYEGH
 * User: querdos
 * Date: 3/24/17
 * Time: 4:33 PM
 */

namespace Querdos\ChallengeMe\PlayerBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Querdos\ChallengeMe\ChallengesBundle\Entity\Category;

/**
 * /!\  Do not use these OrderedFixture in production, it's just to fill the database in order
 *      to have a visual of the platform with subscribed players
 *
 * Class LoadCategoryData
 * @package Querdos\ChallengeMe\PlayerBundle\DataFixtures\ORM
 */
class LoadCategoryData extends AbstractFixture implements OrderedFixtureInterface
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

        // creating categories
        for ($i=0; $i<25; $i++) {
            $category = new Category(
                $faker->words(2, true),
                $faker->sentence()
            );

            $manager->persist($category);
            $this->addReference("category-$i", $category);
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
        return 5;
    }
}