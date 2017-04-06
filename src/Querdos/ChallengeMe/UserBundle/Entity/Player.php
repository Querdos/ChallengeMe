<?php
/**
 * Created by Hamza ESSAYEGH
 * User: Querdos
 * Date: 3/8/17
 * Time: 9:49 AM
 */

namespace Querdos\ChallengeMe\UserBundle\Entity;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Class Player
 *
 * @Vich\Uploadable
 *
 * @package Querdos\ChallengeMe\UserBundle\Entity
 */
class Player extends BaseUser implements UserInterface, \Serializable, AdvancedUserInterface
{
    /**
     * @var Team
     */
    private $team;

    /**
     * @Vich\UploadableField(mapping="player_avatar", fileNameProperty="avatarName")
     *
     * @var File
     */
    private $avatar;

    /**
     * @var string
     */
    private $avatarName;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var PlayerRole
     */
    private $playerRole;

    /**
     * Allow the player to submit a solution for a given challenge
     *
     * @var string
     */
    private $solution;

    /**
     * Allow the admin to block a player. If true, the player will be able to connect,
     * but won't be able to do anything
     *
     * @var bool
     */
    private $blocked;

    /**
     * Administrator constructor.
     *
     * @param string $username
     * @param string $email
     * @param string $password
     */
    public function __construct($username = null, $email = null, $password = null)
    {
        $this->username     = $username;
        $this->email        = $email;
        $this->emailBack    = null;
        $this->password     = $password;
        $this->creationDate = new \DateTime();

        $this->infoUser     = new InfoUser();
        $this->blocked      = false; // by default, the player is not blocked
    }

    /**
     * {@inheritdoc}
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
        ) = unserialize($serialized);
    }

    /**
     * {@inheritdoc}
     */
    public function getRoles()
    {
        return array(Role::ROLE_USER);
    }

    /**
     * {@inheritdoc}
     */
    public function getSalt() {}

    /**
     * {@inheritdoc}
     */
    public function eraseCredentials()
    {
        $this->plainPassword = "";
        return $this;
    }

    /**
     * Return the team of the player
     *
     * @return Team
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * Set the team for the player
     *
     * @param $team
     *
     * @return $this
     */
    public function setTeam($team)
    {
        $this->team = $team;
        return $this;
    }

    /**
     * Return true if the player has a team
     *
     * @return bool
     */
    public function hasTeam()
    {
        return $this->getTeam() !== null;
    }

    /**
     * Set the avatar for the current player
     *
     * @param File $avatar
     *
     * @return $this
     */
    public function setAvatar(File $avatar = null)
    {
        $this->avatar = $avatar;
        if ($avatar) {
            $this->updatedAt = new \DateTimeImmutable();
        }

        return $this;
    }

    /**
     * @return File|null
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Set the avatar name
     *
     * @param string $name
     *
     * @return $this
     */
    public function setAvatarName($name)
    {
        $this->avatarName = $name;
        return $this;
    }

    /**
     * Get the avatar name
     *
     * @return string
     */
    public function getAvatarName()
    {
        return $this->avatarName;
    }

    /**
     * @return PlayerRole
     */
    public function getPlayerRole()
    {
        return $this->playerRole;
    }

    /**
     * @param PlayerRole $playerRole
     */
    public function setPlayerRole($playerRole)
    {
        $this->playerRole = $playerRole;
    }

    /**
     * @return string
     */
    public function getSolution()
    {
        return $this->solution;
    }

    /**
     * @param string $solution
     *
     * @return $this
     */
    public function setSolution($solution)
    {
        $this->solution = $solution;
        return $this;
    }

    /**
     * @return bool
     */
    public function isBlocked()
    {
        return $this->blocked;
    }

    /**
     * @param bool $blocked
     *
     * @return Player
     */
    public function setBlocked($blocked)
    {
        $this->blocked = $blocked;
        return $this;
    }

    /**
     * Checks whether the user's account has expired.
     *
     * Internally, if this method returns false, the authentication system
     * will throw an AccountExpiredException and prevent login.
     *
     * @return bool true if the user's account is non expired, false otherwise
     *
     * @see AccountExpiredException
     */
    public function isAccountNonExpired()
    {
        // not handled yet
        return true;
    }

    /**
     * Checks whether the user is locked.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a LockedException and prevent login.
     *
     * @return bool true if the user is not locked, false otherwise
     *
     * @see LockedException
     */
    public function isAccountNonLocked()
    {
        return !$this->isBlocked();
    }

    /**
     * Checks whether the user's credentials (password) has expired.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a CredentialsExpiredException and prevent login.
     *
     * @return bool true if the user's credentials are non expired, false otherwise
     *
     * @see CredentialsExpiredException
     */
    public function isCredentialsNonExpired()
    {
        // Not handled yet
        return true;
    }

    /**
     * Checks whether the user is enabled.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a DisabledException and prevent login.
     *
     * @return bool true if the user is enabled, false otherwise
     *
     * @see DisabledException
     */
    public function isEnabled()
    {
        // Not Handled yet
        return true;
    }
}