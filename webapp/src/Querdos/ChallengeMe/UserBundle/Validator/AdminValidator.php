<?php
/**
 * Created by Hamza ESSAYEGH.
 * Date: 6/5/16
 * Time: 12:18 PM
 */

namespace Querdos\ChallengeMe\UserBundle\Validator;


use Querdos\ChallengeMe\UserBundle\Entity\Administrator;
use Querdos\ChallengeMe\UserBundle\Entity\InfoUser;
use Querdos\ChallengeMe\UserBundle\Manager\AdministratorManager;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AdminValidator implements UserValidatorInterface
{
    /**
     * @var ValidatorInterface $validator
     */
    private $validator;

    /**
     * @var AdministratorManager $adminManager
     */
    private $adminManager;

    /** {@inheritdoc} */
    public function validateUsername($name) {
        if (
            // Check from admin repository
            null !== $this->adminManager->checkUsername($name)
        ) {
            throw new \RuntimeException("Username already exists");
        }

        $error = $this->validator->validatePropertyValue(Administrator::class, 'username', $name);

        if (count($error) > 0) {
            throw new \RuntimeException($error[0]->getMessage());
        } else {
            return $name;
        }

    }

    /** {@inheritdoc} */
    public function validatePassword($password) {
        $password = trim($password);
        $error = $this->validator->validatePropertyValue(Administrator::class, 'password', $password);

        if (count($error) > 0) {
            throw new \RuntimeException($error[0]->getMessage());
        } else {
            return $password;
        }
    }

    /** {@inheritdoc} */
    public function validateEmail($email) {
        if (
            // Check from admin repository
            null !== $this->adminManager->checkEmail($email) ||
            null !== $this->adminManager->checkEmailBack($email)
        ) {
            throw new \RuntimeException("Email alreayd exists");
        }

        $error = $this->validator->validatePropertyValue(Administrator::class, 'email', $email);

        if (count($error) > 0) {
            throw new \RuntimeException($error[0]->getMessage());
        } else {
            return $email;
        }
    }

    /** {@inheritdoc} */
    public function validateEmailBack($email) {
        if (
            // Check from admin repository
            null !== $this->adminManager->checkEmailBack($email) ||
            null !== $this->adminManager->checkEmail($email)
        ) {
            throw new \RuntimeException("Email already exists");
        }

        $error = $this->validator->validatePropertyValue(Administrator::class, 'emailBack', $email);

        if (count($error) > 0) {
            throw new \RuntimeException($error[0]->getMessage());
        } else {
            return $email;
        }
    }

    /** {@inheritdoc} */
    public function validateFirstname($name) {
        $error = $this->validator->validatePropertyValue(InfoUser::class, 'firstName', $name);

        if (count($error) > 0) {
            throw new \RuntimeException($error[0]->getMessage());
        } else {
            return $name;
        }
    }

    /** {@inheritdoc} */
    public function validateLastname($name) {
        $error = $this->validator->validatePropertyValue(InfoUser::class, 'lastName', $name);

        if (count($error) > 0) {
            throw new \RuntimeException($error[0]->getMessage());
        } else {
            return $name;
        }
    }

    /** {@inheritdoc} */
    public function validateBirthday($birthday) {
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