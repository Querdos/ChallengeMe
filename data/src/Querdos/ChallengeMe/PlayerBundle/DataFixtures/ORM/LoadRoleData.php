<?php
/**
 * Created by Hamza ESSAYEGH.
 * User: querdos
 * Date: 18/02/17
 * Time: 18:21
 */

namespace Querdos\ChallengeMe\PlayerBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Querdos\ChallengeMe\UserBundle\Entity\Role;

class LoadRoleData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // Admin
        $role = new Role(Role::ROLE_ADMIN);
        $manager->persist($role);
        $this->addReference('role-admin', $role);

        // Moderator
        $role = new Role(Role::ROLE_MODERATOR);
        $manager->persist($role);
        $this->addReference('role-moderator', $role);

        // Redactor
        $role = new Role(Role::ROLE_REDACTOR);
        $manager->persist($role);
        $this->addReference('role-redactor', $role);

        $manager->flush();
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