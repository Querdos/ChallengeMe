<?php
/**
 * Created by Hamza ESSAYEGH
 * Date : 6/4/16
 * Time : 7:37 PM
 */

namespace Querdos\ChallengeMe\AdministratorBundle\Manager;


use Doctrine\ORM\EntityManager;
use Querdos\ChallengeMe\AdministratorBundle\Entity\Moderator;
use Querdos\ChallengeMe\AdministratorBundle\Repository\ModeratorRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Tests\Encoder\PasswordEncoder;

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

    public function __construct(EntityManager $em)
    {
        $this->repository = $em->getRepository('AdminBundle:Moderator');
    }

    public function create(Moderator $moderator)
    {
        // Encoding the password
        $moderator
            ->setPassword(
                $this->passwordEncoder->encodePassword($moderator, $moderator->getPlainPassword())
            )
            ->eraseCredentials();

        // Persisting
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
    
    public function all()
    {
        return $this->repository->findAll();
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

    /**
     * @param ModeratorRepository $repository
     */
    public function setRepository($repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param PasswordEncoder $passwordEncoder
     */
    public function setPasswordEncoder($passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

}