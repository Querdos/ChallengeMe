<?php
/**
 * Created by Hamza ESSAYEGH
 * Date : 6/4/16
 * Time : 7:37 PM
 */

namespace Querdos\ChallengeMe\AdministratorBundle\Manager;


use Querdos\ChallengeMe\AdministratorBundle\Entity\Moderator;
use Querdos\ChallengeMe\AdministratorBundle\Repository\ModeratorRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Tests\Encoder\PasswordEncoder;
use Doctrine\ORM\EntityManager;

class ModeratorManager implements ModeratorManagerInterface
{
    /**
     * @var ModeratorRepository $repository
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
     * {@inheritDoc}
     * @see \Querdos\ChallengeMe\AdministratorBundle\Manager\ModeratorManagerInterface::create()
     */
    public function create(Moderator $moderator)
    {
        // Encoding the password
        $moderator
            ->setPassword(
                $this->passwordEncoder->encodePassword($moderator, $moderator->getPlainPassword())
            )
            ->eraseCredentials();

        // Persisting and flushing
        $this->entityManager->persist($moderator);
        $this->entityManager->flush($moderator);
    }

    /**
     * {@inheritDoc}
     * @see \Querdos\ChallengeMe\AdministratorBundle\Manager\ModeratorManagerInterface::update()
     */
    public function update(Moderator $moderator)
    {
        // If the plain password is not empty <=> resetting password
        if ("" !== $moderator->getPlainPassword()) {
            $moderator
                ->setPassword(
                    $this->passwordEncoder->encodePassword($moderator, $moderator->getPlainPassword())
                )
                ->eraseCredentials()
            ;
        }

        // Retrieving unit of work
        $unitOfWork = $this->entityManager->getUnitOfWork();
        
        // Checking if already persisted
        if (!$unitOfWork->isEntityScheduled($moderator)) {
        	$this->entityManager->persist($moderator);
        }
        
        // Flushing
        $this->entityManager->flush($moderator);
    }

    /**
     * {@inheritDoc}
     * @see \Querdos\ChallengeMe\AdministratorBundle\Manager\ModeratorManagerInterface::delete()
     */
    public function delete(Moderator $moderator)
    {
        // Retrieving unit of work
        $unitOfWork = $this->entityManager->getUnitOfWork();
        
        // Checking if already persisted
        if (!$unitOfWork->isEntityScheduled($moderator)) {
        	$this->entityManager->persist($moderator);
        }
        
        // Flushing
        $this->entityManager->flush($moderator);
    }
    
    /**
     * {@inheritDoc}
     * @see \Querdos\ChallengeMe\AdministratorBundle\Manager\ModeratorManagerInterface::all()
     */
    public function all()
    {
        return $this->repository->findAll();
    }

    /**
     * {@inheritDoc}
     * @see \Querdos\ChallengeMe\AdministratorBundle\Manager\ModeratorManagerInterface::resetPassword()
     */
    public function resetPassword(Moderator $moderator)
    {
        $moderator->setPlainPassword(uniqid());
        $this->update($moderator);
    }

    /**
     * {@inheritDoc}
     * @see \Querdos\ChallengeMe\AdministratorBundle\Manager\ModeratorManagerInterface::getModeratorData()
     */
    public function getModeratorData($username)
    {
        return $this->repository->getModeratorData($username);
    }

    /**
     * {@inheritDoc}
     * @see \Querdos\ChallengeMe\AdministratorBundle\Manager\ModeratorManagerInterface::getModeratorPublicInfo()
     */
    public function getModeratorPublicInfo($id)
    {
        return $this->repository->getModeratorPublicInfo($id);
    }

    /**
     * {@inheritDoc}
     * @see \Querdos\ChallengeMe\AdministratorBundle\Manager\ModeratorManagerInterface::checkUsername()
     */
    public function checkUsername($username)
    {
        return $this->repository->checkUsername($username);
    }

    /**
     * {@inheritDoc}
     * @see \Querdos\ChallengeMe\AdministratorBundle\Manager\ModeratorManagerInterface::checkEmail()
     */
    public function checkEmail($email)
    {
        return $this->repository->checkEmail($email);
    }

    /**
     * {@inheritDoc}
     * @see \Querdos\ChallengeMe\AdministratorBundle\Manager\ModeratorManagerInterface::checkEmailBack()
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
     * @return Moderator
     */
    public function readById($id)
    {
        return $this->repository->findOneById($id);
    }
    
    /**
     * Set the repository
     *
     * @param ModeratorRepository $repository
     */
    public function setRepository(ModeratorRepository $repository)
    {
    	$this->repository = $repository;
    	return $this;
    }
    
    /**
     * Set the entity manager
     * 
     * @param EntityManager $entityManager
     */
    public function setEntityManager(EntityManager $entityManager)
    {
    	$this->entityManager = $entityManager;
    	return $this;
    }
}