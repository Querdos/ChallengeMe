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
}
