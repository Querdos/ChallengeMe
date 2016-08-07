<?php
/**
 * Created by Hamza ESSAYEGH.
 * Date: 6/7/16
 * Time: 10:31 PM
 */

namespace Querdos\ChallengeMe\AdministratorBundle\Manager;


use Doctrine\ORM\EntityManager;
use Querdos\ChallengeMe\AdministratorBundle\Entity\Redactor;
use Querdos\ChallengeMe\AdministratorBundle\Repository\RedactorRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Tests\Encoder\PasswordEncoder;

class RedactorManager implements RedactorManagerInterface
{
    /**
     * @var RedactorRepository $repository
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
     * Set the repository
     * 
     * @param RedactorRepository $repository
     * @return \Querdos\ChallengeMe\AdministratorBundle\Manager\RedactorManager
     */
    public function setRepository(RedactorRepository $repository) 
    {
    	$this->repository = $repository;
    	return $this;
    }

    /**
     * {@inheritDoc}
     * @see \Querdos\ChallengeMe\AdministratorBundle\Manager\RedactorManagerInterface::create()
     */
    public function create(Redactor $redactor)
    {
        // Encoding the password and setting it
        $redactor
            ->setPassword(
                $this->passwordEncoder->encodePassword($redactor, $redactor->getPlainPassword())
            )
            ->eraseCredentials()
        ;
        
        // Persisting and flushing
        $this->entityManager->persist($redactor);
        $this->entityManager->flush($redactor);
    }

    /**
     * {@inheritDoc}
     * @see \Querdos\ChallengeMe\AdministratorBundle\Manager\RedactorManagerInterface::update()
     */
    public function update(Redactor $redactor)
    {
        // If the plain password is not empty <=> resetting password
        if ("" !== $redactor->getPlainPassword()) {
            $redactor
                ->setPassword(
                    $this->passwordEncoder->encodePassword($redactor, $redactor->getPlainPassword())
                )
                ->eraseCredentials()
            ;
        }

        // Retrieving unit of work
        $unitOfWork = $this->entityManager->getUnitOfWork();
        
        // Checking if already persisted
        if (!$unitOfWork->isEntityScheduled($redactor)) {
        	$this->entityManager->persist($redactor);
        }
        
        // Flushing 
        $this->entityManager->flush($redactor);
    }

    /**
     * {@inheritDoc}
     * @see \Querdos\ChallengeMe\AdministratorBundle\Manager\RedactorManagerInterface::delete()
     */
    public function delete(Redactor $redactor)
    {
        // Retrieivng unit of work
        $unitOfWork = $this->entityManager->getUnitOfWork();
        
        // Checking if already persisted
        if (!$unitOfWork->isEntityScheduled($redactor)) {
        	$this->entityManager->persist($redactor);
        }
        
        // Flushing
        $this->entityManager->flush($redactor);
    }

    /**
     * {@inheritDoc}
     * @see \Querdos\ChallengeMe\AdministratorBundle\Manager\RedactorManagerInterface::all()
     */
    public function all()
    {
        return $this->repository->findAll();
    }

    /**
     * {@inheritDoc}
     * @see \Querdos\ChallengeMe\AdministratorBundle\Manager\RedactorManagerInterface::resetPassword()
     */
    public function resetPassword(Redactor $redactor)
    {
        $redactor->setPlainPassword(uniqid());
        $this->update($redactor);
    }

    /**
     * {@inheritDoc}
     * @see \Querdos\ChallengeMe\AdministratorBundle\Manager\RedactorManagerInterface::getRedactorData()
     */
    public function getRedactorData($username)
    {
        return $this->repository->getRedactorData($username);
    }

    /**
     * {@inheritDoc}
     * @see \Querdos\ChallengeMe\AdministratorBundle\Manager\RedactorManagerInterface::getRedactorPublicInfo()
     */
    public function getRedactorPublicInfo($id)
    {
        return $this->getRedactorPublicInfo($id);
    }

    /**
     * {@inheritDoc}
     * @see \Querdos\ChallengeMe\AdministratorBundle\Manager\RedactorManagerInterface::checkUsername()
     */
    public function checkUsername($username)
    {
        return $this->repository->checkUsername($username);
    }

    /**
     * {@inheritDoc}
     * @see \Querdos\ChallengeMe\AdministratorBundle\Manager\RedactorManagerInterface::checkEmail()
     */
    public function checkEmail($email)
    {
        return $this->repository->checkEmail($email);
    }

    /**
     * {@inheritDoc}
     * @see \Querdos\ChallengeMe\AdministratorBundle\Manager\RedactorManagerInterface::checkEmailBack()
     */
    public function checkEmailBack($email)
    {
        return $this->repository->checkEmailBack($email);
    }

    /**
     * Set the password encoder
     * 
     * @param PasswordEncoder $passwordEncoder
     */
    public function setPasswordEncoder($passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @param $id
     * @return Redactor
     */
    public function readById($id)
    {
        return $this->repository->findOneById($id);
    }
    
    /**
     * Set the entity manager
     * 
     * @param EntityManager $entityManager
     * @return \Querdos\ChallengeMe\AdministratorBundle\Manager\RedactorManager
     */
    public function setEntityManager(EntityManager $entityManager)
    {
    	$this->entityManager = $entityManager;
    	return $this;
    }
}