<?php
/**
 * Created by Hamza ESSAYEGH
 * User: Querdos
 * Date: 3/8/17
 * Time: 12:37 PM
 */

namespace Querdos\ChallengeMe\PlayerBundle\Controller;

use Querdos\ChallengeMe\PlayerBundle\Form\PlayerType;
use Querdos\ChallengeMe\UserBundle\Entity\InfoUser;
use Querdos\ChallengeMe\UserBundle\Entity\Player;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\VarDumper\VarDumper;

class SecurityController extends Controller
{
    /**
     * @return RedirectResponse
     */
    public function defaultAction()
    {
        $user = $this->getUser();

        // checking player
        if ($user instanceof Player) {
            return $this->redirectToRoute('player_homepage');
        }

        return $this->redirectToRoute('player_login');
    }

    /**
     * @Template("PlayerBundle:security:login.html.twig")
     *
     * @param Request $request
     *
     * @return array|RedirectResponse
     */
    public function loginAction(Request $request)
    {
        $user = $this->getUser();
        if ($user instanceof Player) {
            return $this->redirectToRoute('player_homepage');
        }

        /** @var AuthenticationException $exception */
        $exception = $this
            ->get('security.authentication_utils')
            ->getLastAuthenticationError()
        ;

        // creating the form
        $player = new Player();
        $form = $this->createForm(PlayerType::class, $player);

        $data['formRegister']    = $form->createView();
        $data['error']           = $exception ? $exception->getMessage() : NULL;
        $data['account_created'] = false;

        // handling the form
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $this
                ->get('challengeme.manager.player')
                ->create($player)
            ;

            $data['account_created'] = true;
        }

        return $data;
    }

    public function loginCheckAction() {}

    /**
     * @param   Request $request
     */
    public function logoutAction(Request $request)
    {
        $user = $this->getUser();
        if ($user instanceof UserInterface) {
            $this->get('security.firewall.map')->setToken(null);
            $request->getSession()->invalidate();
        }
    }

    /**
     * @Template("PlayerBundle:security:register.html.twig")
     *
     * @param Request $request
     */
    public function registerAction(Request $request)
    {
        //
    }
}