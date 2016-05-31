<?php
/**
 * Created by PhpStorm.
 * User: querdos
 * Date: 5/31/16
 * Time: 11:59 PM
 */

namespace Querdos\ChallengeMe\AdministratorBundle\Manager;


use Doctrine\Common\Persistence\ObjectManager;
use Querdos\ChallengeMe\AdministratorBundle\Entity\Moderator;
use Querdos\ChallengeMe\AdministratorBundle\Repository\ModeratorRepository;

class ModeratorManager implements ModeratorManagerInterface
{
    /** @var ModeratorRepository $repository */
    private $repository;

    public function __construct(ObjectManager $objectManager)
    {
        $this->repository = $objectManager->getRepository('AdminBundle:Moderator');
    }

    public function create(Moderator $admin)
    {
        // TODO: Implement create() method.
    }

    public function update(Moderator $admin)
    {
        // TODO: Implement update() method.
    }

    public function delete(Moderator $admin)
    {
        // TODO: Implement delete() method.
    }

    public function adminExists(Moderator $admin)
    {
        // TODO: Implement adminExists() method.
    }

    public function getModeratorData($username)
    {
        // TODO: Implement getModeratorData() method.
    }

    public function getModeratorPublicInfo($id)
    {
        // TODO: Implement getModeratorPublicInfo() method.
    }

    public function checkUsername($username)
    {
        // TODO: Implement checkUsername() method.
    }

    public function checkEmail($email)
    {
        // TODO: Implement checkEmail() method.
    }

    public function checkEmailBack($email)
    {
        // TODO: Implement checkEmailBack() method.
    }
}