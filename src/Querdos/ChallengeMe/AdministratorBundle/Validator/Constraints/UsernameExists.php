<?php
/**
 * Created by Hamza ESSAYEGH.
 * Date: 6/26/16
 * Time: 7:45 PM
 */

namespace Querdos\ChallengeMe\AdministratorBundle\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

class UsernameExists extends Constraint
{
    public $message = "This username exists";
}