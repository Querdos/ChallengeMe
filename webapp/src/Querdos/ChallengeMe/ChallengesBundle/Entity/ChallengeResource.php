<?php
/**
 * Created by Hamza ESSAYEGH
 * User: querdos
 * Date: 3/24/17
 * Time: 10:36 AM
 */

namespace Querdos\ChallengeMe\ChallengesBundle\Entity;


use Symfony\Component\HttpFoundation\File\File;
use Querdos\ChallengeMe\UserBundle\Entity\Administrator;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Class ChallengeResource
 * @package Querdos\ChallengeMe\ChallengesBundle\Entity
 *
 * @Vich\Uploadable
 */
class ChallengeResource
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var Challenge
     */
    private $challenge;

    /**
     * @Vich\UploadableField(mapping="challenge_resource", fileNameProperty="resourceName")
     *
     * @var File
     */
    private $resourceFile;

    /**
     * @var string
     */
    private $resourceName;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var Administrator
     */
    private $uploadedBy;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return ChallengeResource
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param File|UploadedFile $resource
     *
     * @return ChallengeResource
     */
    public function setResourceFile(File $resource = null)
    {
        $this->resourceFile = $resource;

        if ($resource) {
            $this->updatedAt = new \DateTimeImmutable();
        }

        return $this;
    }

    /**
     * @return File|null
     */
    public function getResourceFile()
    {
        return $this->resourceFile;
    }

    /**
     * @param $resourceName
     *
     * @return ChallengeResource
     */
    public function setResourceName($resourceName)
    {
        $this->resourceName = $resourceName;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getResourceName()
    {
        return $this->resourceName;
    }

    /**
     * @return Challenge
     */
    public function getChallenge()
    {
        return $this->challenge;
    }

    /**
     * @param Challenge $challenge
     *
     * @return ChallengeResource
     */
    public function setChallenge($challenge)
    {
        $this->challenge = $challenge;
        return $this;
    }

    /**
     * @return Administrator
     */
    public function getUploadedBy()
    {
        return $this->uploadedBy;
    }

    /**
     * @param Administrator $uploadedBy
     *
     * @return ChallengeResource
     */
    public function setUploadedBy($uploadedBy)
    {
        $this->uploadedBy = $uploadedBy;
        return $this;
    }
}