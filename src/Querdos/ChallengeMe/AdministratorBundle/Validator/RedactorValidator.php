<?php
/**
 * Created by Hamza ESSAYEGH.
 * Date: 6/7/16
 * Time: 10:30 PM
 */

namespace Querdos\ChallengeMe\AdministratorBundle\Validator;


use Querdos\ChallengeMe\AdministratorBundle\Entity\InfoUser;
use Querdos\ChallengeMe\AdministratorBundle\Entity\Redactor;
use Querdos\ChallengeMe\AdministratorBundle\Manager\AdministratorManager;
use Querdos\ChallengeMe\AdministratorBundle\Manager\ModeratorManager;
use Querdos\ChallengeMe\AdministratorBundle\Manager\RedactorManager;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RedactorValidator implements UserValidatorInterface
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

    /**
     * @var RedactorManager $redactorManager
     */
    private $redactorManager;

    /**
     * Validate the username
     *
     * @param $name
     * @return mixed
     */
    public function validateUsername($name)
    {
        if (
            // Checking from moderator repository
            null !== $this->moderatorManager->checkUsername($name) ||

            // Checking from admin repository
            null !== $this->adminManager->checkUsername($name) ||

            // Checking from redactor repository
            null !== $this->redactorManager->checkUsername($name)
        ) {
            throw new \RuntimeException("Username already exists");
        }

        $error = $this->validator->validatePropertyValue(Redactor::class, 'username', $name);

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
        $error = $this->validator->validatePropertyValue(Redactor::class, 'password', $password);

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
            // Check email from moderator repository
            null !== $this->moderatorManager->checkEmail($email) ||
            null !== $this->moderatorManager->checkEmailBack($email) ||

            // Check mail from admin repository
            null !== $this->adminManager->checkEmail($email) ||
            null !== $this->adminManager->checkEmailBack($email) ||

            // Check mail from redactor repository
            null !== $this->redactorManager->checkEmail($email) ||
            null !== $this->redactorManager->checkEmailBack($email)
        ) {
            throw new \RuntimeException("Email alreayd exists");
        }

        $error = $this->validator->validatePropertyValue(Redactor::class, 'email', $email);

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
            // Check email from moderator repository first
            null !== $this->moderatorManager->checkEmailBack($email) ||
            null !== $this->moderatorManager->checkEmail($email) ||

            // Check email from admin repository
            null !== $this->adminManager->checkEmail($email) ||
            null !== $this->adminManager->checkEmailBack($email) ||

            // Checking from redactor repository
            null !== $this->redactorManager->checkEmail($email) ||
            null !== $this->redactorManager->checkEmailBack($email)
        ) {
            throw new \RuntimeException("Email already exists");
        }

        $error = $this->validator->validatePropertyValue(Redactor::class, 'emailBack', $email);

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