<?php
/**
 * Created by Hamza ESSAYEGH
 * User: Querdos
 * Date: 3/8/17
 * Time: 11:30 AM
 */

namespace Querdos\ChallengeMe\UserBundle\Manager;

use Doctrine\ORM\EntityManager;
use Querdos\ChallengeMe\UserBundle\Entity\Player;
use Querdos\ChallengeMe\UserBundle\Repository\PlayerRepository;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Tests\Encoder\PasswordEncoder;
use Symfony\Component\VarDumper\VarDumper;

class PlayerManager extends BaseManager
{
    /**
     * @var PasswordEncoder
     */
    private $passwordEncoder;

    /**
     * Create a new player in database
     *
     * @param Player $player
     */
    public function create($player)
    {
        // encoding the password and setting ti
        // erasing credential then
        $player
            ->setPassword(
                $this->passwordEncoder->encodePassword(
                    $player,
                    $player->getPlainPassword()
                )
            )
            ->eraseCredentials()
        ;

        // heritage
        parent::create($player);
    }

    /**
     * Update an existing player in database
     *
     * @param Player $player
     */
    public function update($player)
    {
        // if the plain password is not empty <=> resetting
        if ("" !== $player->getPlainPassword() && null !== $player->getPlainPassword()) {
            $player
                ->setPassword(
                    $this->passwordEncoder->encodePassword(
                        $player,
                        $player->getPlainPassword())
                )
                ->eraseCredentials()
            ;
        }

        // heritage
        parent::update($player);

        // flushing info user
        $this->entityManager->flush($player->getInfoUser());
    }

    /**
     * @param string $username
     *
     * @throws UsernameNotFoundException
     * @return null|Player
     */
    public function getPlayerData($username)
    {
        if (null === ($playerData = $this->repository->getPlayerData($username))){
            throw new UsernameNotFoundException(
                "$username not in database"
            );
        }

        return $playerData;
    }

    /**
     * Return the count of existing players in database
     *
     * @return int
     */
    public function count()
    {
        return $this->repository->getPlayerCount();
    }

    /**
     * @param PasswordEncoder $passwordEncoder
     */
    public function setPasswordEncoder($passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
}