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
        $admin  = new Administrator(1, 'admin', 'admin@gmail.com', 'qsdfqsdjfhlkdj');

        /** @var Administrator $admin0 */
        $admin0 = new Administrator(2, 'admin0', 'admin0@gmail.com', 'qsdfqsdjfhlkdj');

        $adminData  = $repo->getAdminData('admin');
        $admin0Data = $repo->getAdminData('admin0');

        // Tests for admin
        $this->assertEquals(
            $admin->getId(),
            $adminData['id']
        );

        $this->assertEquals(
            $admin->getUsername(),
            $adminData['username']
        );

        $this->assertEquals(
            $admin->getEmail(),
            $adminData['email']
        );

        // Tests for admin0
        $this->assertEquals(
            $admin0->getId(),
            $admin0Data['id']
        );

        $this->assertEquals(
            $admin0->getUsername(),
            $admin0Data['username']
        );

        $this->assertEquals(
            $admin0->getEmail(),
            $admin0Data['email']
        );
    }

    public function testGetAdminPublicInfo()
    {
        /** @var AdministratorRepository $repo */
        $repo = $this->em->getRepository('AdminBundle:Administrator');

        /** @var Administrator $admin */
        $admin  = new Administrator(1, 'admin', 'admin@gmail.com', 'qsdfqsdjfhlkdj');
        $admin
            ->setEmailBack('admin@hotmail.fr')
            ->getInfoUser()
            ->setFirstName('Hamza')
            ->setLastName('ESSAYEGH')
            ->setBirthday(new \DateTime('1992-03-30'));

        /** @var Administrator $admin0 */
        $admin0 = new Administrator(2, 'admin0', 'admin0@gmail.com', 'qsdfqsdjfhlkdj');
        $admin0
            ->setEmailBack('admin0@hotmail.fr')
            ->getInfoUser()
            ->setFirstName('Admin0')
            ->setLastName('Admin0')
            ->setBirthday(new \DateTime('1992-03-30'));

        // Tests for admin0
        $this->assertEquals(
            $admin0->getUsername(),
            $repo->getAdminPublicInfo($admin0->getId())['username']
        );

        $this->assertEquals(
            $admin0->getEmail(),
            $repo->getAdminPublicInfo($admin0->getId())['email']
        );

        $this->assertEquals(
            $admin0->getEmailBack(),
            $repo->getAdminPublicInfo($admin0->getId())['emailBack']
        );

        $this->assertEquals(
            $admin0->getInfoUser()->getFirstName(),
            $repo->getAdminPublicInfo($admin0->getId())['firstname']
        );

        $this->assertEquals(
            $admin0->getInfoUser()->getLastName(),
            $repo->getAdminPublicInfo($admin0->getId())['lastname']
        );

        $this->assertEquals(
            $admin0->getInfoUser()->getBirthday(),
            $repo->getAdminPublicInfo($admin0->getId())['birthday']
        );

        // Tests for admin
        $this->assertEquals(
            $admin->getUsername(),
            $repo->getAdminPublicInfo($admin->getId())['username']
        );

        $this->assertEquals(
            $admin->getEmail(),
            $repo->getAdminPublicInfo($admin->getId())['email']
        );

        $this->assertEquals(
            $admin->getEmailBack(),
            $repo->getAdminPublicInfo($admin->getId())['emailBack']
        );

        $this->assertEquals(
            $admin->getInfoUser()->getFirstName(),
            $repo->getAdminPublicInfo($admin->getId())['firstname']
        );

        $this->assertEquals(
            $admin->getInfoUser()->getLastName(),
            $repo->getAdminPublicInfo($admin->getId())['lastname']
        );

        $this->assertEquals(
            $admin->getInfoUser()->getBirthday(),
            $repo->getAdminPublicInfo($admin->getId())['birthday']
        );

    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->em->close();
        $this->em = null;
    }
}