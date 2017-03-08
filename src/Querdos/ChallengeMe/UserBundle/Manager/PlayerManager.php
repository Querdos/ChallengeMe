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

class PlayerManager
{
    /**
     * @var PlayerRepository $repository
     */
    private $repository;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var PasswordEncoder
     */
    private $passwordEncoder;

    /**
     * Create a new player in database
     *
     * @param Player $player
     */
    public function create(Player $player)
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

        // persisting and flushing
        $this->entityManager->persist($player);
        $this->entityManager->flush($player);

    }

    /**
     * Update an existing player in database
     *
     * @param Player $player
     */
    public function update(Player $player)
    {
        // if the plain password is not empty <=> resetting
        if ("" !== $player->getPlainPassword()) {
            $player
                ->setPassword(
                    $this->passwordEncoder->encodePassword(
                        $player,
                        $player->getPlainPassword())
                )->eraseCredentials()
            ;
        }

        // retrieving unit of work
        $unitOfWork = $this->entityManager->getUnitOfWork();

        // checking if already persisted
        if (!$unitOfWork->isEntityScheduled($player)) {
            $this->entityManager->persist($player);
        }

        // flushing
        $this->entityManager->flush($player);
        $this->entityManager->flush($player->getInfoUser());
    }

    /**
     * Remove a player from the database
     *
     * @param Player $player
     */
    public function delete(Player $player)
    {
        $this->entityManager->remove($player);
        $this->entityManager->flush($player);
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
     * Retreive all players from the database
     *
     * @return Player[]
     */
    public function all()
    {
        return $this->repository->findAll();
    }

    /**
     * @param PlayerRepository $repository
     */
    public function setRepository($repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param EntityManager $entityManager
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param PasswordEncoder $passwordEncoder
     */
    public function setPasswordEncoder($passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
}