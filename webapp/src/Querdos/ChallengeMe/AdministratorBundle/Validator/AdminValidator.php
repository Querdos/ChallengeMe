<?php
/**
 * Created by PhpStorm.
 * User: querdos
 * Date: 5/27/16
 * Time: 1:02 AM
 */

namespace Querdos\ChallengeMe\AdministratorBundle\Validator;


use Querdos\ChallengeMe\AdministratorBundle\Entity\Administrator;
use Querdos\ChallengeMe\AdministratorBundle\Entity\InfoUser;
use Querdos\ChallengeMe\AdministratorBundle\Manager\AdministratorManager;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AdminValidator
{
    /**
     * @var ValidatorInterface $validator
     */
    private $validator;

    /**
     * @var AdministratorManager $adminManager
     */
    private $adminManager;

    public function __construct(ValidatorInterface $validator, AdministratorManager $administratorManager)
    {
        $this->validator    = $validator;
        $this->adminManager = $administratorManager;
    }

    /**
     * Validate the username
     *
     * @param $name
     * @return mixed
     */
    public function validateUsername($name) {
        if (null !== $this->adminManager->checkUsername($name)) {
            throw new \RuntimeException("Username already exists");
        }

        $error = $this->validator->validatePropertyValue(Administrator::class, 'username', $name);

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
    public function validatePassword($password) {
        $password = trim($password);
        $error = $this->validator->validatePropertyValue(Administrator::class, 'password', $password);

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
    public function validateEmail($email) {
        if (null !== $this->adminManager->checkEmail($email)) {
            throw new \RuntimeException("Email alreayd exists");
        }

        $error = $this->validator->validatePropertyValue(Administrator::class, 'email', $email);

        if (count($error) > 0) {
            throw new \RuntimeException($error[0]->getMessage());
        } else {
            return $email;
        }
    }

    /**
     * Validate the secondary email
     *
     * @param $email
     * @return mixed
     */
    public function validateEmailBack($email) {
        if (null !== $this->adminManager->checkEmailBack($email)) {
            throw new \RuntimeException("This email is already in use");
        }
        
        $error = $this->validator->validatePropertyValue(Administrator::class, 'emailBack', $email);

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
    public function validateFirstname($name) {
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
    public function validateLastname($name) {
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
    public function validateBirthday($birthday) {
        $error = $this->validator->validatePropertyValue(InfoUser::class, 'birthday', $birthday);

        if (count($error) > 0) {
            throw new \RuntimeException($error[0]->getMessage());
        } else {
            return $birthday;
        }
    }
}