<?php
/**
 * Created by Hamza ESSAYEGH
 * User: querdos
 * Date: 3/29/17
 * Time: 11:05 AM
 */

namespace Querdos\ChallengeMe\AdministratorBundle\Entity;

use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Class DatabaseDump
 * @package Querdos\ChallengeMe\AdministratorBundle\Entity
 *
 * @Vich\Uploadable
 */
class DatabaseDump
{
    /**
     * @var int
     */
    private $id;

    /**
     * @Vich\UploadableField(mapping="database_dump", fileNameProperty="dumpName", size="dumpSize")
     *
     * @var File
     */
    private $dumpFile;

    /**
     * @var string
     */
    private $dumpName;

    /**
     * @var string
     */
    private $dumpFileName;

    /**
     * @var int
     */
    private $dumpSize;

    /**
     * @var \DateTime
     */
    private $updatedAt;

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
     * @return DatabaseDump
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param File|null $dumpFile
     *
     * @return $this
     */
    public function setDumpFile(File $dumpFile = null)
    {
        $this->dumpFile = $dumpFile;

        if ($dumpFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }

        return $this;
    }

    /**
     * @return File
     */
    public function getDumpFile()
    {
        return $this->dumpFile;
    }

    /**
     * @param $dumpName
     *
     * @return $this
     */
    public function setDumpName($dumpName)
    {
        $this->dumpName = $dumpName;
        return $this;
    }

    /**
     * @param $dumpSize
     *
     * @return $this
     */
    public function setDumpSize($dumpSize)
    {
        $this->dumpSize = $dumpSize;
        return $this;
    }

    /**
     * @return string
     */
    public function getDumpName()
    {
        return $this->dumpName;
    }

    /**
     * @return int
     */
    public function getDumpSize()
    {
        return $this->dumpSize;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @return string
     */
    public function getDumpFileName()
    {
        return $this->dumpFileName;
    }

    /**
     * @param string $dumpFileName
     *
     * @return DatabaseDump
     */
    public function setDumpFileName($dumpFileName)
    {
        $this->dumpFileName = $dumpFileName;
        return $this;
    }
}