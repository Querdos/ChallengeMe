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
     * @var EntityManager $entityManager
     */
    private $entityManager;
    
    /**
     * Create a new administrator
     * 
     * {@inheritDoc}
     * @see \Querdos\ChallengeMe\AdministratorBundle\Manager\AdministratorManagerInterface::create()
     */
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
        $this->entityManager->persist($admin);
        $this->entityManager->flush($admin);
    }

    /**
     * {@inheritDoc}
     * @see \Querdos\ChallengeMe\AdministratorBundle\Manager\AdministratorManagerInterface::update()
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
        
    }

    /**
     * {@inheritDoc}
     * @see \Querdos\ChallengeMe\AdministratorBundle\Manager\AdministratorManagerInterface::delete()
     */
    public function delete(Administrator $admin)
    {
    	// Retrieving unit of work
    	$unitOfWork = $this->entityManager->getUnitOfWork();
    	
    	// Checking if already persisted
    	if (!$unitOfWork->isEntityScheduled($admin)) {
    		$this->entityManager->persist($admin);
    	}
    	
    	// Flushing
    	$this->entityManager->flush($admin);
    }

    /**
     * {@inheritDoc}
     * @see \Querdos\ChallengeMe\AdministratorBundle\Manager\AdministratorManagerInterface::all()
     */
    public function all()
    {
        return $this->repository->findAll();
    }

    /**
     * {@inheritDoc}
     * @see \Querdos\ChallengeMe\AdministratorBundle\Manager\AdministratorManagerInterface::resetPassword()
     */
    public function resetPassword(Administrator $admin)
    {
        $admin->setPlainPassword(uniqid());
        $this->update($admin);
    }

    /**
     * {@inheritDoc}
     * @see \Querdos\ChallengeMe\AdministratorBundle\Manager\AdministratorManagerInterface::getAdminData()
     */
    public function getAdminData($username)
    {
        return $this->repository->getAdminData($username);
    }

    /**
     * {@inheritDoc}
     * @see \Querdos\ChallengeMe\AdministratorBundle\Manager\AdministratorManagerInterface::getAdminPublicInfo()
     */
    public function getAdminPublicInfo($id) {
        return $this->repository->getAdminPublicInfo($id);
    }

    /**
     * {@inheritDoc}
     * @see \Querdos\ChallengeMe\AdministratorBundle\Manager\AdministratorManagerInterface::checkUsername()
     */
    public function checkUsername($username)
    {
        return $this->repository->checkUsername($username);
    }

    /**
     * {@inheritDoc}
     * @see \Querdos\ChallengeMe\AdministratorBundle\Manager\AdministratorManagerInterface::checkEmail()
     */
    public function checkEmail($email)
    {
        return $this->repository->checkEmail($email);
    }

    /**
     * {@inheritDoc}
     * @see \Querdos\ChallengeMe\AdministratorBundle\Manager\AdministratorManagerInterface::checkEmailBack()
     */
    public function checkEmailBack($email)
    {
        return $this->repository->checkEmailBack($email);
    }

    /**
     * Return an administrator with a given id
     *
     * @param  int $id
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
     * @param EntityManager $entityManager
     * @return \Querdos\ChallengeMe\AdministratorBundle\Manager\AdministratorManager
     */
    public function setEntityManager(EntityManager $entityManager) 
    {
    	$this->entityManager = $entityManager;
    	return $this;
    }
}