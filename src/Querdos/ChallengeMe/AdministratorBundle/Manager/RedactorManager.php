<?php
/**
 * Created by Hamza ESSAYEGH.
 * Date: 6/7/16
 * Time: 10:31 PM
 */

namespace Querdos\ChallengeMe\AdministratorBundle\Manager;


use Doctrine\Common\Persistence\ObjectManager;
use Querdos\ChallengeMe\AdministratorBundle\Entity\Redactor;
use Querdos\ChallengeMe\AdministratorBundle\Repository\RedactorRepository;

class RedactorManager implements RedactorManagerInterface
{
    /** @var  RedactorRepository $repository */
    private $repository;

    public function __construct(ObjectManager $objectManager)
    {
        $this->repository = $objectManager->getRepository('AdminBundle:Redactor');
    }

    public function create(Redactor $redactor)
    {
        $this->repository->create($redactor);
    }

    public function update(Redactor $redactor)
    {
        $this->repository->update($redactor);
    }

    public function delete(Redactor $redactor)
    {
        $this->repository->delete($redactor);
    }

    public function all()
    {
        $this->repository->findAll();
    }

    public function getRedactorData($username)
    {
        return $this->repository->getRedactorData($username);
    }

    public function getRedactorPublicInfo($id)
    {
        return $this->getRedactorPublicInfo($id);
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