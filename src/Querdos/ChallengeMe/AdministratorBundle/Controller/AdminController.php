<?php

namespace Querdos\ChallengeMe\AdministratorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class AdminController extends Controller
{
    /**
     * @Route("/", name="admin_homepage")
     * @Template("AdminBundle::index.html.twig")
     */
    public function indexAction()
    {
        return array();
    }
}
