<?php
/**
 * Created by PhpStorm.
 * User: querdos
 * Date: 5/21/16
 * Time: 5:14 PM
 */

namespace Querdos\ChallengeMe\AdministratorBundle\Manager;


use Doctrine\Common\Persistence\ObjectManager;
use Querdos\ChallengeMe\AdministratorBundle\Entity\Administrator;
use Querdos\ChallengeMe\AdministratorBundle\Repository\AdministratorRepository;

class AdministratorManager implements AdministratorManagerInterface
{
    /**
     * @var AdministratorRepository $repository
     */
    private $repository;

    public function __construct(ObjectManager $objectManager)
    {
        $this->repository = $objectManager->getRepository('AdminBundle:Administrator');
    }

    public function create(Administrator $admin)
    {
        $this->repository->create($admin);
    }

    public function update(Administrator $admin)
    {
        $this->repository->update($admin);
    }

    public function delete(Administrator $admin)
    {
        $this->repository->delete($admin);
    }

    public function all()
    {
        return $this->repository->findAll();
    }

    public function adminExists(Administrator $admin)
    {
        return $this->repository->adminExists($admin);
    }

    public function getAdminData($username)
    {
        return $this->repository->getAdminData($username);
    }

    public function getAdminPublicInfo($id) {
        return $this->repository->getAdminPublicInfo($id);
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