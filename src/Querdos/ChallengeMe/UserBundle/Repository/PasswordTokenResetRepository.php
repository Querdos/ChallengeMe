<?php
/**
 * Created by Hamza ESSAYEGH
 * User: querdos
 * Date: 4/6/17
 * Time: 11:24 AM
 */

namespace Querdos\ChallengeMe\UserBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Querdos\ChallengeMe\UserBundle\Entity\PasswordTokenReset;

class PasswordTokenResetRepository extends EntityRepository
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
        $query = $this
            ->getEntityManager()
            ->createQueryBuilder()

            ->select('token')
            ->addSelect('player')

            ->from('UserBundle:PasswordTokenReset', 'token')
            ->join('token.player', 'player')

            ->where('token.value = :value')

            ->setParameter('value', $token)
        ;

        /** @var PasswordTokenReset $result */
        $result = $query
            ->getQuery()
            ->getOneOrNullResult()
        ;

        // checking that expiration date is valid (just in case)
        if (null !== $result) {
            // retrieving today's date
            $today = new \DateTime();

            if ($today > $result->getExpirationDate()) {
                return null;
            }
        }

        return $result;
    }
}