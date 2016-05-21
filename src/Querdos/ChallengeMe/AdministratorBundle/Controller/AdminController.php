<?php

namespace Querdos\ChallengeMe\AdministratorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

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
        return array();
    }
}
