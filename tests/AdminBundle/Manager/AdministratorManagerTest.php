<?php
/**
 * Created by Hamza ESSAYEGH.
 * Date: 6/5/16
 * Time: 1:29 PM
 */

namespace Tests\AdministratorBundle\Manager;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityRepository;

use Querdos\ChallengeMe\AdministratorBundle\Entity\Administrator;
use Querdos\ChallengeMe\AdministratorBundle\Manager\AdministratorManager;

class AdministratorManagerTest extends \PHPUnit_Framework_TestCase
{
    public function testCheckUsername()
    {
        // Mocking the object to test
        $admin = $this
            ->getMock(Administrator::class);
        $admin
            ->expects($this->once())
            ->method('checkUsername')
            ->will($this->returnValue('admin'));

        // Mocking the repository
        $adminRepository = $this
            ->getMockBuilder(EntityRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $adminRepository
            ->expects($this->once())
            ->method('find')
            ->will($this->returnValue($admin));

        // Mocking the entity manager
        $entityManager = $this
            ->getMockBuilder(ObjectManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        $entityManager
            ->expects($this->once())
            ->method('getRepository')
            ->will($this->returnValue($adminRepository));

        $adminManager = new AdministratorManager($entityManager);
        $this->assertEquals('admin', $adminManager->checkUsername('admin'));
    }
}