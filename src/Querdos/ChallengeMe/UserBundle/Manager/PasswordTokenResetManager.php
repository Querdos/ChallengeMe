<?php
/**
 * Created by Hamza ESSAYEGH
 * User: querdos
 * Date: 4/6/17
 * Time: 11:30 AM
 */

namespace Querdos\ChallengeMe\UserBundle\Manager;


use Querdos\ChallengeMe\UserBundle\Entity\PasswordTokenReset;

class PasswordTokenResetManager extends BaseManager
{
    /**
     * Return a password token reset with the given value
     *
     * If not found, return null
     *
     * @param string $token
     *
     * @return null|PasswordTokenReset
     */
    public function readByValue($token)
    {
        return $this->repository->readByValue($token);
    }
}