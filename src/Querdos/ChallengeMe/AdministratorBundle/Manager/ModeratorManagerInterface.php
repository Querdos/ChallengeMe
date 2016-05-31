<?php
/**
 * Created by PhpStorm.
 * User: querdos
 * Date: 5/31/16
 * Time: 11:58 PM
 */

namespace Querdos\ChallengeMe\AdministratorBundle\Manager;


use Querdos\ChallengeMe\AdministratorBundle\Entity\Moderator;

interface ModeratorManagerInterface
{
    public function create(Moderator $admin);

    public function update(Moderator $admin);

    public function delete(Moderator $admin);

    public function adminExists(Moderator $admin);

    public function getModeratorData($username);

    public function getModeratorPublicInfo($id);

    public function checkUsername($username);

    public function checkEmail($email);

    public function checkEmailBack($email);
}