<?php
/**
 * Created by Hamza ESSAYEGH.
 * Date: 6/4/16
 * Time: 8:22 PM
 */

namespace Querdos\ChallengeMe\UserBundle\Validator;


use Querdos\ChallengeMe\UserBundle\Entity\InfoUser;
use Querdos\ChallengeMe\UserBundle\Entity\Moderator;
use Querdos\ChallengeMe\UserBundle\Manager\AdministratorManager;
use Querdos\ChallengeMe\UserBundle\Validator\UserValidatorInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ModeratorValidator implements UserValidatorInterface
{

    /**
     * @var ValidatorInterface $validator
     */
    private $validator;

    /**
     * @var AdministratorManager $adminManager
     */
    private $adminManager;

    /**
     * Validate the username
     *
     * @param $name
     * @return mixed
     */
    public function validateUsername($name)
    {
        if (
            // Checking from admin repository
            null !== $this->adminManager->checkUsername($name)
        ) {
            throw new \RuntimeException("Username already exists");
        }

        $error = $this->validator->validatePropertyValue(Moderator::class, 'username', $name);

        if (count($error) > 0) {
            throw new \RuntimeException($error[0]->getMessage());
        } else {
            return $name;
        }
    }

    /**
     * Validate the password
     *
     * @param $password
     * @return mixed
     */
    public function validatePassword($password)
    {
        $password = trim($password);
        $error = $this->validator->validatePropertyValue(Moderator::class, 'password', $password);

        if (count($error) > 0) {
            throw new \RuntimeException($error[0]->getMessage());
        } else {
            return $password;
        }
    }

    /**
     * Validate the email
     *
     * @param $email
     * @return mixed
     */
    public function validateEmail($email)
    {
        if (
            // Check mail from admin repository
            null !== $this->adminManager->checkEmail($email) ||
            null !== $this->adminManager->checkEmailBack($email)
        ) {
            throw new \RuntimeException("Email alreayd exists");
        }

        $error = $this->validator->validatePropertyValue(Moderator::class, 'email', $email);

        if (count($error) > 0) {
            throw new \RuntimeException($error[0]->getMessage());
        } else {
            return $email;
        }
    }

    /**
     * Validate the secondary email
     *
     * @param   $email
     * @return  mixed
     */
    public function validateEmailBack($email)
    {
        if (
            // Check email from admin repository
            null !== $this->adminManager->checkEmail($email) ||
            null !== $this->adminManager->checkEmailBack($email)
        ) {
            throw new \RuntimeException("Email already exists");
        }

        $error = $this->validator->validatePropertyValue(Moderator::class, 'emailBack', $email);

        if (count($error) > 0) {
            throw new \RuntimeException($error[0]->getMessage());
        } else {
            return $email;
        }
    }

    /**
     * Validate the firstname
     *
     * @param $name
     * @return mixed
     */
    public function validateFirstname($name)
    {
        $error = $this->validator->validatePropertyValue(InfoUser::class, 'firstName', $name);

        if (count($error) > 0) {
            throw new \RuntimeException($error[0]->getMessage());
        } else {
            return $name;
        }
    }

    /**
     * Validate the lastname
     *
     * @param $name
     * @return mixed
     */
    public function validateLastname($name)
    {
        $error = $this->validator->validatePropertyValue(InfoUser::class, 'lastName', $name);

        if (count($error) > 0) {
            throw new \RuntimeException($error[0]->getMessage());
        } else {
            return $name;
        }
    }

    /**
     * Validate the birthday
     *
     * @param $birthday
     * @return mixed
     */
    public function validateBirthday($birthday)
    {
        $error = $this->validator->validatePropertyValue(InfoUser::class, 'birthday', $birthday);

        if (count($error) > 0) {
            throw new \RuntimeException($error[0]->getMessage());
        } else {
            return $birthday;
        }
    }

    /**
     * @param ValidatorInterface $validator
     */
    public function setValidator($validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param AdministratorManager $adminManager
     */
    public function setAdminManager($adminManager)
    {
        $this->adminManager = $adminManager;
    }
}