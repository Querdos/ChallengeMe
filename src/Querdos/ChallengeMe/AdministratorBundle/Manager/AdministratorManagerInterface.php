<?php
/**
 * Created by PhpStorm.
 * User: querdos
 * Date: 5/21/16
 * Time: 5:20 PM
 */

namespace Querdos\ChallengeMe\AdministratorBundle\Manager;


use Querdos\ChallengeMe\AdministratorBundle\Entity\Adminstrator;

interface AdministratorManagerInterface
{
    public function create(Adminstrator $admin);

    public function update(Adminstrator $admin);

    public function delete(Adminstrator $admin);
}