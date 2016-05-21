<?php
/**
 * Created by PhpStorm.
 * User: querdos
 * Date: 5/21/16
 * Time: 3:34 PM
 */
namespace Querdos\ChallengeMe\AdministratorBundle\Command;

use Symfony\Component\Form\Exception\RuntimeException;

class Validators {

    /**
     * Username validator
     * @param string $username
     *
     * @return string
     */
    public static function usernameValidator($username) {
        if (empty($username) || null == $username) {
            throw new RuntimeException("Username is mandatory");
        }

        return $username;

    }

    /**
     * Password Validator
     *
     * @param $plainPassword
     * @return mixed
     */
    public static function passwordValidator($plainPassword) {
        if (trim($plainPassword) == '') {
            throw new \RuntimeException("Password can not be empty");
        }

        return $plainPassword;
    }

    /**
     * Email validator
     *
     * @param $email
     * @return mixed
     */
    public static function emailValidator($email) {
        if (empty($email) || null === $email) {
            throw new \RuntimeException("Email is mandatory");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \RuntimeException("The email is incorrect");
        }

        return $email;
    }

    /**
     * Check if the given string doesn't contains
     * any white space
     *
     * Used with Firstname and Lastname
     *
     * @param string $string
     * @return mixed
     */
    public static function noWhiteSpaceValidator($string) {
        if (!empty($string) || null !== $string) {
            if (strpos($string, ' ') === true) {
                throw new \RuntimeException("No whitespace for this field");
            }
        }

        return $string;
    }

    /**
     * Birthday Validator with a given string
     *
     * @param string $birthday
     * @return string
     */
    public static function birthdayValidator($birthday) {
        if (!empty($birthday) || null !== $birthday) {
            // Birthday isn't empty, we can check if it's correctly formated (m/d/y)
            if (!self::validateDate($birthday)) {
                throw new \RuntimeException("Date format is incorrect. Format : mm/dd/yyyy");
            }

            // Birthday is correctly formated, check if it isn't greater than today
            $today = new \DateTime();
            $birth = \DateTime::createFromFormat('m/d/Y', $birthday);

            if ($birth >= $today) {
                throw new \RuntimeException("Birthday must be lower than today.");
            }
        }

        return $birthday;
    }

    private static function validateDate($date, $format = 'm/d/Y')
    {
        $d = \DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }
}