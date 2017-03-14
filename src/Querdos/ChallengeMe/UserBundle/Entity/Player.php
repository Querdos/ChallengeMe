<?php
/**
 * Created by Hamza ESSAYEGH
 * User: Querdos
 * Date: 3/8/17
 * Time: 9:49 AM
 */

namespace Querdos\ChallengeMe\UserBundle\Entity;


use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Security\Core\User\UserInterface;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Class Player
 *
 * @Vich\Uploadable
 *
 * @package Querdos\ChallengeMe\UserBundle\Entity
 */
class Player extends BaseUser implements UserInterface, \Serializable
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
     * Administrator constructor.
     *
     * @param string $id
     * @param string $username
     * @param string $email
     * @param string $password
     */
    public function __construct($id = "", $username = "", $email = "", $password = "")
    {
        $this->id           = $id;
        $this->username     = $username;
        $this->email        = $email;
        $this->emailBack    = "";
        $this->password     = $password;
        $this->creationDate = new \DateTime();

        $this->infoUser     = new InfoUser();
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
}