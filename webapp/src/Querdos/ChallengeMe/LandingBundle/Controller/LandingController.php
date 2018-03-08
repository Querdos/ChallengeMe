<?php
/**
 * Created by Hamza ESSAYEGH.
 * Date: 6/5/16
 * Time: 12:18 PM
 */

namespace Querdos\ChallengeMe\LandingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class LandingController extends Controller
{
    /**
     * @Route("/", name="landing_homepage")
     * @Template("LandingBundle::index.html.twig")
     *
     * @Method("GET")
     */
    public function indexAction()
    {
        return array();
    }
}
