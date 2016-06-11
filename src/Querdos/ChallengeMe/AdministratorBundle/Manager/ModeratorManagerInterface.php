<?php
/**
 * Created by PhpStorm.
 * User: querdos
 * Date: 5/31/16
 * Time: 11:58 PM
 */

namespace Querdos\ChallengeMe\AdministratorBundle\Manager;


use Querdos\ChallengeMe\AdministratorBundle\Entity\Moderator;

// TODO : PHPDoc
interface ModeratorManagerInterface
{
    public function create(Moderator $moderator);

    public function update(Moderator $moderator);

    public function delete(Moderator $moderator);

    public function all();

    public function getModeratorData($username);

    public function getModeratorPublicInfo($id);

    public function checkUsername($username);

    public function checkEmail($email);

    public function checkEmailBack($email);
}