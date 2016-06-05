<?php
/**
 * Created by Hamza ESSAYEGH.
 * Date: 6/5/16
 * Time: 2:46 PM
 */

namespace tests\AdminBundle\Entity;


use Doctrine\ORM\EntityManager;
use Querdos\ChallengeMe\AdministratorBundle\Entity\Administrator;
use Querdos\ChallengeMe\AdministratorBundle\Repository\AdministratorRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AdministratorRepositoryTest extends KernelTestCase
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        self::bootKernel();

        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testCheckUsername()
    {
        // List of usernames to test
        $usernames = ['admin', 'admin0', 'admin1', 'admin2'];

        $usernamesExists = [
            $this->em->getRepository('AdminBundle:Administrator')->checkUsername($usernames[0]),
            $this->em->getRepository('AdminBundle:Administrator')->checkUsername($usernames[1]),
            $this->em->getRepository('AdminBundle:Administrator')->checkUsername($usernames[2]),
            $this->em->getRepository('AdminBundle:Administrator')->checkUsername($usernames[3])
        ];


        $this->assertNotNull($usernamesExists[0], "Problem with admin");
        $this->assertNotNull($usernamesExists[1], "Problem with admin0");

        $this->assertNull($usernamesExists[2], "Problem with admin1");
        $this->assertNull($usernamesExists[3], "Problem with admin2");
    }

    public function testGetAdminData()
    {
        /** @var AdministratorRepository $repo */
        $repo = $this->em->getRepository('AdminBundle:Administrator');

        /** @var Administrator $admin */
        $admin  = new Administrator('1', 'admin', 'admin@gmail.com', 'qsdfqsdjfhlkdj');

        /** @var Administrator $admin0 */
        $admin0 = new Administrator('2', 'admin0', 'admin0@gmail.com', 'qsdfqsdjfhlkdj');

        $adminData  = $repo->getAdminData('admin');
        $admin0Data = $repo->getAdminData('admin0');

//        dump()
        
        // Tests for admin
        $this->assertEquals(
            $admin->getId(),
            $adminData['id']
        );

        // Tests for admin0
    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->em->close();
        $this->em = null;
    }
}