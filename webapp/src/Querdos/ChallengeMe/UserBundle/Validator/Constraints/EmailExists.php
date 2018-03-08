<?php
/**
 * Created by Hamza ESSAYEGH.
 * Date: 6/26/16
 * Time: 8:02 PM
 */

namespace Querdos\ChallengeMe\UserBundle\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

class EmailExists extends Constraint
{
    public $message = "This email already exists";
}