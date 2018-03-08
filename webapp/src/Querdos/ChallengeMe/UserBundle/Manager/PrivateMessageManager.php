<?php
/**
 * Created by Hamza ESSAYEGH.
 * User: querdos
 * Date: 23/02/17
 * Time: 19:50
 */

namespace Querdos\ChallengeMe\UserBundle\Manager;


use Doctrine\ORM\EntityManager;
use Querdos\ChallengeMe\UserBundle\Entity\Administrator;
use Querdos\ChallengeMe\UserBundle\Entity\PrivateMessage;
use Querdos\ChallengeMe\UserBundle\Repository\PrivateMessageRepository;

class PrivateMessageManager extends BaseManager
{
    /**
     * @var AdministratorManager $adminManager
     */
    private $adminManager;

    /**
     * Retrieve all private messages with a given author
     *
     * @param Administrator $author
     * @return PrivateMessage[]
     */
    public function readByAuthor(Administrator $author)
    {
        return $this->repository->getByAuthor($author);
    }

    /**
     * Retrieve all private messages with a given recipient
     *
     * @param   Administrator $recipient
     * @return  PrivateMessage[]
     */
    public function readByRecipient(Administrator $recipient)
    {
        return $this->repository->getByRecipient($recipient);
    }

    /**
     * @param AdministratorManager $adminManager
     */
    public function setAdminManager($adminManager)
    {
        $this->adminManager = $adminManager;
    }
}