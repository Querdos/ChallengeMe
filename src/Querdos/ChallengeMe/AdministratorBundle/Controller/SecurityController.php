<?php
/**
 * Created by Hamza ESSAYEGH.
 * Date: 6/5/16
 * Time: 12:18 PM
 */

namespace Querdos\ChallengeMe\AdministratorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;

class SecurityController extends Controller
{
    /**
     * @Template("AdminBundle:security:login.html.twig")
     *
     * @return  array
     */
    public function loginAction() {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error          = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername   = $authenticationUtils->getLastUsername();

        return array(
            // last username entered by the user
            'last_username' => $lastUsername,
            'error'         => $error,
        );
    }

    /**
     * Check login method for the admin
     */
    public function loginCheckAction() {}

    /**
     * @param   Request         $request
     * @return  RedirectResponse
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