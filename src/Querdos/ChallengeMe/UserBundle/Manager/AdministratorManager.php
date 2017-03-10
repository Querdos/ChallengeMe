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
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Tests\Encoder\PasswordEncoder;
use Symfony\Component\VarDumper\VarDumper;

/**
 * Class AdministratorManager
 *
 * @package Querdos\ChallengeMe\UserBundle\Manager
 */
class AdministratorManager extends BaseManager
{
    /**
     * @var UserPasswordEncoder $passwordEncoder
     */
    private $passwordEncoder;

    /**
     * @var RoleManager $roleManager
     */
    private $roleManager;

    /**
     * Create a new administrator
     *
     * @param   Administrator $admin
     *
     * @throws \Exception
     */
    public function create($admin)
    {
        // Encoding the password and setting it
        // Adding the corresponding role
        $admin
            ->setPassword(
                $this->passwordEncoder->encodePassword($admin, $admin->getPlainPassword())
            )
            ->eraseCredentials()
        ;

        parent::create($admin);
    }

    /**
     * Update an existing administrator
     *
     * @param Administrator $admin
     */
    public function update($admin)
    {
        // checking if the password has been modified
        if ($admin->getPlainPassword() !== "") {
            $admin
                ->setPassword(
                    $this->passwordEncoder->encodePassword(
                        $admin,
                        $admin->getPlainPassword()
                    )
                )
                ->eraseCredentials()
            ;
        }

        // heritage
        parent::update($admin);

        // persisting info user
        $this->entityManager->flush($admin->getInfoUser());

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
     * @throws  UsernameNotFoundException
     * @param   string $username
     * @return  Administrator
     */
    public function getAdminData($username)
    {
        if (null === ($adminData = $this->repository->getAdminData($username))) {
            throw new UsernameNotFoundException(
                "$username doesn't exist"
            );
        }

        return $adminData;
    }

    /**
     * Return an administrator public information, with a given id
     *
     * @param   int     $id
     * @return  array
     */
    public function getAdminPublicInfo($id)
    {
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
     * Return the count of administrators in database
     *
     * @return int
     */
    public function adminCount()
    {
        return $this->repository->getAdminCount();
    }

    /**
     * Return the count of moderators in database
     *
     * @return int
     */
    public function modoCount()
    {
        return $this->repository->getModoCount();
    }

    /**
     * Return the count of redactors in database
     *
     * @return int
     */
    public function redacCount()
    {
        return $this->repository->getRedacCount();
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