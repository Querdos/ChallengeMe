<?php
/**
 * Created by Hamza ESSAYEGH.
 * Date: 6/4/16
 * Time: 8:08 PM
 */

namespace Querdos\ChallengeMe\AdministratorBundle\Validator;


interface UserValidatorInterface
{
    /**
     * Validate the username
     *
     * @param $name
     * @return mixed
     */
    public function validateUsername($name);

    /**
     * Validate the password
     *
     * @param $password
     * @return mixed
     */
    public function validatePassword($password);

    /**
     * Validate the email
     *
     * @param $email
     * @return mixed
     */
    public function validateEmail($email);

    /**
     * Validate the secondary email
     *
     * @param   $email
     * @return  mixed
     */
    public function validateEmailBack($email);

    /**
     * Validate the firstname
     *
     * @param $name
     * @return mixed
     */
    public function validateFirstname($name);

    /**
     * Validate the lastname
     *
     * @param $name
     * @return mixed
     */
    public function validateLastname($name);

    /**
     * Validate the birthday
     *
     * @param $birthday
     * @return mixed
     */
    public function validateBirthday($birthday);
}