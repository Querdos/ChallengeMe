<?php
/**
 * Created by Hamza ESSAYEGH.
 * Date: 6/7/16
 * Time: 10:31 PM
 */

namespace Querdos\ChallengeMe\AdministratorBundle\Manager;


use Querdos\ChallengeMe\AdministratorBundle\Entity\Redactor;

// TODO : PHPDoc
interface RedactorManagerInterface
{
    public function create(Redactor $redactor);

    public function update(Redactor $redactor);

    public function delete(Redactor $redactor);

    public function all();

    public function readById($id);

    public function getRedactorData($username);

    public function getRedactorPublicInfo($id);

    public function checkUsername($username);

    public function checkEmail($email);

    public function checkEmailBack($email);
}