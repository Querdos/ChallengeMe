<?php
/**
 * Created by Hamza ESSAYEGH.
 * Date: 6/5/16
 * Time: 4:02 PM
 */

namespace Tests\AdminBundle\Entity;


use Doctrine\ORM\EntityManager;
use Querdos\ChallengeMe\AdministratorBundle\Entity\Moderator;
use Querdos\ChallengeMe\AdministratorBundle\Repository\ModeratorRepository;
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
        $usernames = ['modo0', 'modo1', 'modo2', 'modo3'];

        $usernamesExists = [
            $this->em->getRepository('AdminBundle:Moderator')->checkUsername($usernames[0]),
            $this->em->getRepository('AdminBundle:Moderator')->checkUsername($usernames[1]),
            $this->em->getRepository('AdminBundle:Moderator')->checkUsername($usernames[2]),
            $this->em->getRepository('AdminBundle:Moderator')->checkUsername($usernames[3])
        ];


        $this->assertNotNull($usernamesExists[0], "Problem with modo0");
        $this->assertNotNull($usernamesExists[1], "Problem with modo1");

        $this->assertNull($usernamesExists[2], "Problem with modo2");
        $this->assertNull($usernamesExists[3], "Problem with modo3");
    }

    public function testGetModeratorData()
    {
        /** @var ModeratorRepository $repo */
        $repo = $this->em->getRepository('AdminBundle:Moderator');

        /** @var Moderator $moderator */
        $moderator0  = new Moderator(1, 'modo0', 'modo0@gmail.com', 'qsdfqsdjfhlkdj');

        /** @var Moderator $admin0 */
        $moderator1 = new Moderator(2, 'modo1', 'modo1@gmail.com', 'qsdfqsdjfhlkdj');

        $moderator0Data     = $repo->getModeratorData('modo0');
        $moderator1Data     = $repo->getModeratorData('modo1');

        // Tests for admin
        $this->assertEquals(
            $moderator0->getId(),
            $moderator0Data['id']
        );

        $this->assertEquals(
            $moderator0->getUsername(),
            $moderator0Data['username']
        );

        $this->assertEquals(
            $moderator0->getEmail(),
            $moderator0Data['email']
        );

        // Tests for modorator1
        $this->assertEquals(
            $moderator1->getId(),
            $moderator1Data['id']
        );

        $this->assertEquals(
            $moderator1->getUsername(),
            $moderator1Data['username']
        );

        $this->assertEquals(
            $moderator1->getEmail(),
            $moderator1Data['email']
        );
    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->em->close();
        $this->em = null;
    }
}
