<?php
/**
 * Created by Hamza ESSAYEGH.
 * Date: 6/7/16
 * Time: 9:52 PM
 */

namespace Querdos\ChallengeMe\AdministratorBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Querdos\ChallengeMe\AdministratorBundle\Entity\InfoUser;

class LoadInfoUserData extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $infoUser = new InfoUser();

        // Admin
        $infoUser
            ->setFirstName("Admin")
            ->setBirthday(new \DateTime());
        
        $manager->persist($infoUser);
        $manager->flush();

        $this->addReference('admin-info', $infoUser);

        $infoUser = new InfoUser();

        // Moderator
        $infoUser
            ->setFirstName('Moderator')
            ->setBirthday(new \DateTime());

        $manager->persist($infoUser);
        $manager->flush();

        $this->addReference('moderator-info', $infoUser);

        // Redactor
        // TODO : Redactor info user data fixture
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 1;
    }
}