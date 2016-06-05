<?php
/**
 * Created by Hamza ESSAYEGH.
 * Date: 6/5/16
 * Time: 4:02 PM
 */

namespace Tests\AdminBundle\Entity;


use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ModeratorRepositoryTest extends KernelTestCase
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

    protected function tearDown()
    {
        parent::tearDown();

        $this->em->close();
        $this->em = null;
    }
}
