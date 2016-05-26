<?php

namespace Querdos\ChallengeMe\AdministratorBundle\Controller;

use Querdos\ChallengeMe\AdministratorBundle\Entity\Administrator;
use Querdos\ChallengeMe\AdministratorBundle\Repository\AdministratorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class AdminController extends Controller
{
    /**
     * @Template("AdminBundle:content:dashboard.html.twig")
     *
     * @return array
     */
    public function indexAction()
    {
        /** @var AdministratorRepository $adminRepo */
        $adminRepo = $this->get('challengeme.manager.administrator');

        /** @var Administrator $admin */
        $admin = $this->getUser();

        return array(
            'admin' => $adminRepo->getAdminPublicInfo($admin->getId())
        );
    }

    /**
     * @Template("AdminBundle:content:inbox.html.twig")
     *
     * @return array
     */
    public function inboxAction()
    {
        /** @var AdministratorRepository $adminRepo */
        $adminRepo = $this->get('challengeme.manager.administrator');

        /** @var Administrator $admin */
        $admin = $this->getUser();

        return array(
            'admin' => $adminRepo->getAdminPublicInfo($admin->getId())
        );
    }

    /**
     * @Template("AdminBundle:content:profile.html.twig")
     *
     * @return array
     */
    public function profileAction()
    {
        /** @var AdministratorRepository $adminRepo */
        $adminRepo = $this->get('challengeme.manager.administrator');

        /** @var Administrator $admin */
        $admin = $this->getUser();

        return array(
            'admin' => $adminRepo->getAdminPublicInfo($admin->getId())
        );
    }

    /**
     * @Template("AdminBundle:content:players_management.html.twig")
     *
     * @return array
     */
    public function playersManagementAction() {
        /** @var AdministratorRepository $adminRepo */
        $adminRepo = $this->get('challengeme.manager.administrator');

        /** @var Administrator $admin */
        $admin = $this->getUser();

        return array(
            'admin' => $adminRepo->getAdminPublicInfo($admin->getId())
        );
    }

    /**
     * @Template("AdminBundle:content:admins_management.html.twig")
     *
     * @return array
     */
    public function adminsManagementAction() {
        /** @var AdministratorRepository $adminRepo */
        $adminRepo = $this->get('challengeme.manager.administrator');

        /** @var Administrator $admin */
        $admin = $this->getUser();

        return array(
            'admin' => $adminRepo->getAdminPublicInfo($admin->getId())
        );
    }

    /**
     * @Template("AdminBundle:content:moderators_management.html.twig")
     *
     * @return array
     */
    public function moderatorsManagementAction() {
        /** @var AdministratorRepository $adminRepo */
        $adminRepo = $this->get('challengeme.manager.administrator');

        /** @var Administrator $admin */
        $admin = $this->getUser();

        return array(
            'admin' => $adminRepo->getAdminPublicInfo($admin->getId())
        );
    }

    /**
     * @Template("AdminBundle:content:redactors_management.html.twig")
     *
     * @return array
     */
    public function redactorsManagementAction() {
        /** @var AdministratorRepository $adminRepo */
        $adminRepo = $this->get('challengeme.manager.administrator');

        /** @var Administrator $admin */
        $admin = $this->getUser();

        return array(
            'admin' => $adminRepo->getAdminPublicInfo($admin->getId())
        );
    }
}
