<?php

namespace Querdos\ChallengeMe\AdministratorBundle\Controller;

use Querdos\ChallengeMe\AdministratorBundle\Entity\Administrator;
use Querdos\ChallengeMe\AdministratorBundle\Repository\AdministratorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\VarDumper\VarDumper;

class AdminController extends Controller
{
    /**
     * @Route("/", name="admin_homepage")
     * @Template("AdminBundle:content:dashboard.html.twig")
     *
     * @Method("GET")
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
     * @Route("/inbox", name="admin_inbox")
     * @Template("AdminBundle:content:inbox.html.twig")
     *
     * @Method("GET")
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
     * @Route("/profile", name="admin_profile")
     * @Template("AdminBundle:content:profile.html.twig")
     *
     * @Method("GET")
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
     * @Route("/players-management", name="admin_playersManagement")
     * @Template("AdminBundle:content:players_management.html.twig")
     *
     * @Method("GET")
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
     * @Route("/admins-management", name="admin_adminsManagement")
     * @Template("AdminBundle:content:admins_management.html.twig")
     *
     * @Method("GET")
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
     * @Route("/moderators-management", name="admin_moderatorsManagement")
     * @Template("AdminBundle:content:moderators_management.html.twig")
     *
     * @Method("GET")
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
     * @Route("/redactors-management", name="admin_redactorsManagement")
     * @Template("AdminBundle:content:redactors_management.html.twig")
     *
     * @Method("GET")
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
