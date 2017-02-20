<?php
/**
 * Created by Hamza ESSAYEGH.
 * Date: 6/5/16
 * Time: 12:18 PM
 */

namespace Querdos\ChallengeMe\UserBundle\Manager;


use Querdos\ChallengeMe\UserBundle\Entity\Administrator;

// TODO : PHPDoc
interface AdministratorManagerInterface
{
    public function create(Administrator $admin);

    public function update(Administrator $admin);

    public function delete(Administrator $admin);

    public function all();

    public function readById($id);
    
    public function resetPassword(Administrator $admin);

    public function getAdminData($username);

    public function getAdminPublicInfo($id);

    public function checkUsername($username);

    public function checkEmail($email);

    public function checkEmailBack($email);
}