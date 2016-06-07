<?php
/**
 * Created by Hamza ESSAYEGH.
 * Date: 6/7/16
 * Time: 10:30 PM
 */

namespace Querdos\ChallengeMe\AdministratorBundle\Validator;


use Querdos\ChallengeMe\AdministratorBundle\Manager\AdministratorManager;
use Querdos\ChallengeMe\AdministratorBundle\Manager\ModeratorManager;
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
     * Validate the username
     *
     * @param $name
     * @return mixed
     */
    public function validateUsername($name)
    {
        // TODO: Implement validateUsername() method.
    }

    /**
     * Validate the password
     *
     * @param $password
     * @return mixed
     */
    public function validatePassword($password)
    {
        // TODO: Implement validatePassword() method.
    }

    /**
     * Validate the email
     *
     * @param $email
     * @return mixed
     */
    public function validateEmail($email)
    {
        // TODO: Implement validateEmail() method.
    }

    /**
     * Validate the secondary email
     *
     * @param   $email
     * @return  mixed
     */
    public function validateEmailBack($email)
    {
        // TODO: Implement validateEmailBack() method.
    }

    /**
     * Validate the firstname
     *
     * @param $name
     * @return mixed
     */
    public function validateFirstname($name)
    {
        // TODO: Implement validateFirstname() method.
    }

    /**
     * Validate the lastname
     *
     * @param $name
     * @return mixed
     */
    public function validateLastname($name)
    {
        // TODO: Implement validateLastname() method.
    }

    /**
     * Validate the birthday
     *
     * @param $birthday
     * @return mixed
     */
    public function validateBirthday($birthday)
    {
        // TODO: Implement validateBirthday() method.
    }
}