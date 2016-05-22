<?php
/**
 * Created by PhpStorm.
 * User: querdos
 * Date: 5/22/16
 * Time: 1:00 PM
 */

namespace Querdos\ChallengeMe\AdministratorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="admin_login")
     * @Template("AdminBundle:security:login.html.twig")
     *
     * @param Request $request
     * @return array
     */
    public function loginAction(Request $request) {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return array(
            // last username entered by the user
            'last_username' => $lastUsername,
            'error'         => $error,
        );
    }

    /**
     * @Route("/login_check", name="admin_login_check")
     *
     */
    public function loginCheckAction() {}

    /**
     * @Route("/logout", name="admin_logout")
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function logoutAction(Request $request) {
        $user = $this->getUser();
        if ($user instanceof UserInterface) {
            $this->get('security.firewall.context')->setToken(null);
            $request->getSession()->invalidate();
        }

        return $this->redirectToRoute('admin_login');
    }
}