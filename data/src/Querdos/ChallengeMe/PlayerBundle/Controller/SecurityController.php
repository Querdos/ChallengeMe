<?php
/**
 * Created by Hamza ESSAYEGH
 * User: Querdos
 * Date: 3/8/17
 * Time: 12:37 PM
 */

namespace Querdos\ChallengeMe\PlayerBundle\Controller;

use Querdos\ChallengeMe\PlayerBundle\Form\PasswordResetType;
use Querdos\ChallengeMe\PlayerBundle\Form\PlayerType;
use Querdos\ChallengeMe\UserBundle\Entity\InfoUser;
use Querdos\ChallengeMe\UserBundle\Entity\PasswordTokenReset;
use Querdos\ChallengeMe\UserBundle\Entity\Player;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Finder\Exception\AccessDeniedException;
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
            // setting random password for the user
            $player->setPlainPassword(uniqid());

            // persisting a basic player
            $this
                ->get('challengeme.manager.player')
                ->create($player)
            ;

            // creating password token reset
            $date = new \DateTime();
            date_add($date, date_interval_create_from_date_string('2 days'));
            $passwordToken = new PasswordTokenReset(
                uniqid("", true),
                $player,
                $date
            );

            // persisting
            $this->get('challengeme.manager.password_token_reset')->create($passwordToken);

            // sending mail for verification
            $this
                ->get('challengeme.manager.mailer')
                ->sendMail($player->getEmail(), $this->renderView(
                    'Emails/registration.html.twig',
                    array(
                        'name'  => $player->getUsername(),
                        'token' => $passwordToken->getValue()
                    )
                ), "ChallengeMe - Registration");
            ;

            $data['account_created'] = true;
        }

        return $data;
    }

    /**
     * Allow the user to reset password without authentication
     *
     * @Template("PlayerBundle:security:reset_password.html.twig")
     *
     * @param string  $token
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function resetPasswordAction($token, Request $request)
    {
        // retrieving the corresponding password token
        $passwordTokenReset = $this
            ->get('challengeme.manager.password_token_reset')
            ->readByValue($token)
        ;

        // denying access if the token does not exists
        if (null === $passwordTokenReset) {
            throw new AccessDeniedException('You are not allowed to perform this operation');
        }

        // creating the form
        $formResetPassword = $this->createForm(PasswordResetType::class);

        // handling form
        $formResetPassword->handleRequest($request);
        if ($formResetPassword->isSubmitted()) {
            // retrieving form data
            $data = $formResetPassword->getData();

            // checking that passwords match
            if ($data['password_1'] !== $data['password_confirmation']) {
                $dataView['error'] = 'Password don\'t match';
            } else {
                // passwords match, we can set it and enable him
                $player = $passwordTokenReset->getPlayer();
                $player
                    ->setPlainPassword($data['password_confirmation'])
                    ->setEnabled(true)
                ;

                // updating player
                $this
                    ->get('challengeme.manager.player')
                    ->update($player)
                ;

                // removing the password token reset
                $this
                    ->get('challengeme.manager.password_token_reset')
                    ->delete($passwordTokenReset)
                ;

                return $this->redirectToRoute('player_login');
            }
        }

        // adding the form to the view
        $dataView['form'] = $formResetPassword->createView();

        // returning data
        return $dataView;
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
}