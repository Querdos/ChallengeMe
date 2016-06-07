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
use Querdos\ChallengeMe\AdministratorBundle\Manager\ModeratorManager;
use Querdos\ChallengeMe\AdministratorBundle\Manager\RedactorManager;
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

    /**
     * @var ModeratorManager $moderatorManager
     */
    private $moderatorManager;

    /** @var  RedactorManager $redactorManager */
    private $redactorManager;

    /** {@inheritdoc} */
    public function validateUsername($name) {
        if (
            // Check from admin repository
            null !== $this->adminManager->checkUsername($name) ||

            // Check from moderator repository
            null !== $this->moderatorManager->checkUsername($name) ||

            // Check from redactor repository
            null !== $this->redactorManager->checkUsername($name)

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
            null !== $this->adminManager->checkEmailBack($email) ||

            // Check from moderator repository
            null !== $this->moderatorManager->checkEmail($email) ||
            null !== $this->moderatorManager->checkEmailBack($email) ||

            // Check from redactor repository
            null !== $this->redactorManager->checkEmail($email) ||
            null !== $this->redactorManager->checkEmailBack($email)
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
            null !== $this->adminManager->checkEmail($email) ||

            // Check from moderator repository
            null !== $this->moderatorManager->checkEmail($email) ||
            null !== $this->moderatorManager->checkEmailBack($email) ||

            // Check from redactor repository
            null !== $this->redactorManager->checkEmail($email) ||
            null !== $this->redactorManager->checkEmailBack($email)
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

    /**
     * @param ModeratorManager $moderatorManager
     */
    public function setModeratorManager($moderatorManager)
    {
        $this->moderatorManager = $moderatorManager;
    }

    /**
     * @param RedactorManager $redactorManager
     */
    public function setRedactorManager($redactorManager)
    {
        $this->redactorManager = $redactorManager;
    }
}