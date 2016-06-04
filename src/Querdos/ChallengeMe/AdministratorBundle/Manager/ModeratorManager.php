<?php
/**
 * Created by Hamza ESSAYEGH
 * Date : 6/4/16
 * Time : 7:37 PM
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

    public function create(Moderator $moderator)
    {
        $this->repository->create($moderator);
    }

    public function update(Moderator $moderator)
    {
        $this->repository->update($moderator);
    }

    public function delete(Moderator $moderator)
    {
        $this->repository->delete($moderator);
    }

    public function moderatorExists(Moderator $moderator)
    {
        return $this->repository->moderatorExists($moderator);
    }

    public function getModeratorData($username)
    {
        return $this->repository->getModeratorData($username);
    }

    public function getModeratorPublicInfo($id)
    {
        return $this->repository->getModeratorPublicInfo($id);
    }

    public function checkUsername($username)
    {
        return $this->repository->checkUsername($username);
    }

    public function checkEmail($email)
    {
        return $this->repository->checkEmail($email);
    }

    public function checkEmailBack($email)
    {
        return $this->repository->checkEmailBack($email);
    }
}