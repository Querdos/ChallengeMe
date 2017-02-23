<?php
/**
 * Created by Hamza ESSAYEGH.
 * User: querdos
 * Date: 5/21/16
 * Time: 5:14 PM
 */

namespace Querdos\ChallengeMe\UserBundle\Manager;

use Doctrine\ORM\EntityManager;
use Querdos\ChallengeMe\UserBundle\Entity\Administrator;
use Querdos\ChallengeMe\UserBundle\Entity\Role;
use Querdos\ChallengeMe\UserBundle\Repository\AdministratorRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Tests\Encoder\PasswordEncoder;
use Symfony\Component\VarDumper\VarDumper;

class AdministratorManager
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
     * @var RoleManager $roleManager
     */
    private $roleManager;
    
    /**
     * @var EntityManager $entityManager
     */
    private $entityManager;

    /**
     * Create a new administrator, depending on the given role
     *
     * @param   Administrator   $admin
     * @param   string          $role
     * @throws \Exception
     */
    public function create(Administrator $admin, $role)
    {
        // checking the role
        if (false === Role::check($role)) {
            throw new \Exception("Unrecognized role");
        }

        // Encoding the password and setting it
        // Adding the corresponding role
        $admin
            ->setPassword(
                $this->passwordEncoder->encodePassword($admin, $admin->getPlainPassword())
            )
            ->eraseCredentials()
        ;

        // setting role
        switch ($role) {
            case Role::ROLE_ADMIN:
                $admin->setRole($this->roleManager->adminRole());
            break;

            case Role::ROLE_MODERATOR:
                $admin->setRole($this->roleManager->moderatorRole());
            break;

            case Role::ROLE_REDACTOR:
                $admin->setRole($this->roleManager->redactorRole());
            break;
        }

        // Persisting
        $this->entityManager->persist($admin);
        $this->entityManager->flush($admin);
    }

    /**
     * Update an administrator entity
     *
     * @param Administrator $admin
     */
    public function update(Administrator $admin)
    {
        // If the plain password is not empty <=> resetting password
        if ("" !== $admin->getPlainPassword()) {
            $admin
                ->setPassword(
                    $this->passwordEncoder->encodePassword($admin, $admin->getPlainPassword())
                )
                ->eraseCredentials()
            ;
        }
        
        // Retrieving unit of work
        $unitOfWork = $this->entityManager->getUnitOfWork();
        
        // Checking if already persisted
        if (!$unitOfWork->isEntityScheduled($admin)) {
        	$this->entityManager->persist($admin);
        }
        
        // Flushing
        $this->entityManager->flush($admin);
        $this->entityManager->flush($admin->getInfoUser());
        
    }

    /**
     * Remove an administrator from the database
     *
     * @param Administrator $admin
     */
    public function delete(Administrator $admin)
    {
    	$this->entityManager->remove($admin);
    	$this->entityManager->flush();
    }

    /**
     * Return all administrators from the database
     *
     * @return Administrator[]
     */
    public function all()
    {
        return $this->repository->findAll();
    }

    /**
     * Return all administrators (ROLE_ADMIN)
     *
     * @return Administrator[]
     */
    public function getAllAdmin()
    {
        return $this->repository->all(Role::ROLE_ADMIN);
    }

    /**
     * Return all moderators (ROLE_MODERATOR)
     *
     * @return Administrator[]
     */
    public function getAllModerators()
    {
        return $this->repository->all(Role::ROLE_MODERATOR);
    }

    /**
     * Return all redactors (ROLE_REDACTOR)
     *
     * @return Administrator[]
     */
    public function getAllRedactors()
    {
        return $this->repository->all(Role::ROLE_REDACTOR);
    }

    /**
     * Reset password for a given administrator (random uid, to be changed)
     *
     * @param Administrator $admin
     */
    public function resetPassword(Administrator $admin)
    {
        $admin->setPlainPassword(uniqid());
        $this->update($admin);
    }

    /**
     * Retrieve an administrator informations, with a given username
     *
     * @param   string $username
     * @return  array
     */
    public function getAdminData($username)
    {
        return $this->repository->getAdminData($username);
    }

    /**
     * Return an administrator public information, with a given id
     *
     * @param   int     $id
     * @return  array
     */
    public function getAdminPublicInfo($id) {
        return $this->repository->getAdminPublicInfo($id);
    }

    /**
     * Check if the given username exists in database
     *
     * @param   string  $username
     * @return  Administrator | null
     */
    public function checkUsername($username)
    {
        return $this->repository->checkUsername($username);
    }

    /**
     * Check email existance for administrators
     *
     * @param   string $email
     * @return  string
     */
    public function checkEmail($email)
    {
        return $this->repository->checkEmail($email);
    }

    /**
     * Check if the secondary email exists for administrators
     *
     * @param   string $email
     * @return  string | null
     */
    public function checkEmailBack($email)
    {
        return $this->repository->checkEmailBack($email);
    }

    /**
     * Return an administrator with a given id
     *
     * @param  int              $id
     * @return Administrator
     */
    public function readById($id)
    {
    	return $this->repository->findOneById($id);
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

    /**
     * Set the repository
     *
     * @param AdministratorRepository $repository
     * @return AdministratorManager
     */
    public function setRepository(AdministratorRepository $repository)
    {
    	$this->repository = $repository;
    	return $this;
    }
    
    /**
     * Set the entity manager
     * 
     * @param   EntityManager           $entityManager
     * @return  AdministratorManager
     */
    public function setEntityManager(EntityManager $entityManager) 
    {
    	$this->entityManager = $entityManager;
    	return $this;
    }

    /**
     * Set the role manager
     *
     * @param   RoleManager $roleManager
     * @return  $this
     */
    public function setRoleManager(RoleManager $roleManager)
    {
        $this->roleManager = $roleManager;
        return $this;
    }
}