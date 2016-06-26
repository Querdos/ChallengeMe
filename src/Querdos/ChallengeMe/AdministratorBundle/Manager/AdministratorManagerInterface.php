<?php
/**
 * Created by PhpStorm.
 * User: querdos
 * Date: 5/21/16
 * Time: 5:20 PM
 */

namespace Querdos\ChallengeMe\AdministratorBundle\Manager;


use Querdos\ChallengeMe\AdministratorBundle\Entity\Administrator;

// TODO : PHPDoc
interface AdministratorManagerInterface
{
    public function create(Administrator $admin);

    public function update(Administrator $admin);

    public function delete(Administrator $admin);

    public function all();

    public function getAdminData($username);

    public function getAdminPublicInfo($id);

    public function checkUsername($username);

    public function checkEmail($email);

    public function checkEmailBack($email);
}