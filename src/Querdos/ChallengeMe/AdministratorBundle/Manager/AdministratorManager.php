<?php
/**
 * Created by PhpStorm.
 * User: querdos
 * Date: 5/21/16
 * Time: 5:14 PM
 */

namespace Querdos\ChallengeMe\AdministratorBundle\Manager;


use Doctrine\ORM\EntityManager;
use Querdos\ChallengeMe\AdministratorBundle\Entity\Administrator;
use Querdos\ChallengeMe\AdministratorBundle\Repository\AdministratorRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Tests\Encoder\PasswordEncoder;

class AdministratorManager implements AdministratorManagerInterface
{
    /**
     * @var AdministratorRepository $repository
     */
    private $repository;

    /**
     * @var UserPasswordEncoder $passwordEncoder
     */
    private $passwordEncoder;

    /**
     * AdministratorManager constructor.
     * 
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->repository = $em->getRepository('AdminBundle:Administrator');
    }

    public function create(Administrator $admin)
    {
        // Encoding the password and setting it
        $admin
            ->setPassword(
                $this->passwordEncoder->encodePassword($admin, $admin->getPlainPassword())
            )
            ->eraseCredentials()
        ;

        // Persisting
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

    /**
     * Setting the repository
     *
     * @param AdministratorRepository $repository
     */
    public function setRepository($repository)
    {
        $this->repository = $repository;
    }

    /**
     * Setting the password encoder
     *
     * @param PasswordEncoder $passwordEncoder
     */
    public function setPasswordEncoder($passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

}