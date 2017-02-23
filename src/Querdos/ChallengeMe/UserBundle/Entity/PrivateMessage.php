<?php

namespace Querdos\ChallengeMe\UserBundle\Entity;

/**
 * PrivateMessage
 */
class PrivateMessage
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $content;

    /**
     * @var \DateTime
     */
    private $sent;

    /**
     * @var Administrator
     */
    private $author;

    /**
     * @var Administrator
     */
    private $recipient;

    /**
     * PrivateMessage constructor.
     *
     * @param   Administrator   $author
     * @param   Administrator   $recipient
     * @param   string          $content
     *
     * @throws  \Exception
     */
    public function __construct(Administrator $author, Administrator $recipient, $content)
    {
        // Checking that the author is not null
        if (null === $author) {
            throw new \Exception("Author cannot be null");
        } else if (null === $recipient) {
            throw new \Exception("Recipient cannot be null");
        }

        $this->author       = $author;
        $this->recipient    = $recipient;
        $this->content      = $content;
        $this->sent         = new \DateTime();
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return PrivateMessage
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Get the time when the message was sent
     *
     * @return \DateTime
     */
    public function getSent()
    {
        return $this->sent;
    }

    /**
     * Set the time when the message was sent
     *
     * @param \DateTime $sent
     * @return $this
     */
    public function setSent($sent)
    {
        $this->sent = $sent;
        return $this;
    }

    /**
     * Get the author of the private message
     *
     * @return Administrator
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set the author of the private message
     *
     * @param   Administrator $author
     * @return                $this
     */
    public function setAuthor($author)
    {
        $this->author = $author;
        return $this;
    }

    /**
     * Return the recipient of the private message
     *
     * @return Administrator
     */
    public function getRecipient()
    {
        return $this->recipient;
    }

    /**
     * Set the recipient of the private message
     *
     * @param Administrator $recipient
     * @return $this
     */
    public function setRecipient($recipient)
    {
        $this->recipient = $recipient;
        return $this;
    }
}

