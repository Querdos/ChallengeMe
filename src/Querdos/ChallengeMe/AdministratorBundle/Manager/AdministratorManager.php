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
        // TODO: Implement update() method.
    }

    public function delete(Administrator $admin)
    {
        // TODO: Implement delete() method.
    }

    public function adminExists(Administrator $admin)
    {
        return $this->repository->adminExists($admin);
    }

    public function getAdminData($username)
    {
        return $this->repository->getAdminData($username);
    }
}