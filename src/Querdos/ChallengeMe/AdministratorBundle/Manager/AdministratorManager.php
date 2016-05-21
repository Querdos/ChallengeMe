<?php
/**
 * Created by PhpStorm.
 * User: querdos
 * Date: 5/21/16
 * Time: 5:14 PM
 */

namespace Querdos\ChallengeMe\AdministratorBundle\Manager;


use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Querdos\ChallengeMe\AdministratorBundle\Entity\Adminstrator;
use Querdos\ChallengeMe\AdministratorBundle\Repository\AdminstratorRepository;

class AdministratorManager implements AdministratorManagerInterface
{
    private $repository;

    public function __construct(ObjectManager $objectManager)
    {
        $this->repository = $objectManager->getRepository('AdminBundle:Adminstrator');
    }

    public function create(Adminstrator $admin)
    {
        $this->repository->create($admin);
    }

    public function update(Adminstrator $admin)
    {
        // TODO: Implement update() method.
    }

    public function delete(Adminstrator $admin)
    {
        // TODO: Implement delete() method.
    }
}