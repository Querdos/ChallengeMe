<?php
/**
 * Created by Hamza ESSAYEGH.
 * Date: 6/5/16
 * Time: 12:18 PM
 */

namespace Querdos\ChallengeMe\AdministratorBundle\Controller;

use Querdos\ChallengeMe\UserBundle\Entity\Administrator;
use Querdos\ChallengeMe\AdministratorBundle\Form\AdministratorType;
use Querdos\ChallengeMe\UserBundle\Entity\Role;
use Querdos\ChallengeMe\UserBundle\Manager\AdministratorManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class AdministrationController extends Controller
{
    /**
     * @Template("AdminBundle:content:dashboard.html.twig")
     *
     * @return array
     */
    public function indexAction()
    {
        // retrieving admin manager
        $adminManager       = $this->get('challengeme.manager.administrator');

        // TODO: Create method in manager to retrieve only the count for each kind of admin
        return array(
            'adminCount'    => count($adminManager->getAllAdmin()),
            'modoCount'     => count($adminManager->getAllModerators()),
            'redacCount'    => count($adminManager->getAllRedactors())
        );
    }

    /**
     * @Template("AdminBundle:content:inbox.html.twig")
     *
     * @return array
     */
    public function inboxAction()
    {
        // retrieving all private messages with the connected user as recipient
        $messages = $this->container
            ->get('challengeme.manager.private_message')
            ->readByRecipient($this->getUser())
        ;

        return array(
            'messages' => $messages
        );
    }

    /**
     * @Template("AdminBundle:content:profile.html.twig")
     *
     * @return array
     */
    public function profileAction()
    {
        return array();
    }

    /**
     * @Template("AdminBundle:content:players_management.html.twig")
     *
     * @return array
     */
    public function playersManagementAction() {
        return array();
    }

    /**
     * @Template("AdminBundle:content:admins_management.html.twig")
     *
     * @return array
     */
    public function adminsManagementAction() {
        /** @var AdministratorManager $adminManager */
        $adminManager = $this->get('challengeme.manager.administrator');

        return array(
            'administrators'    => $adminManager->getAllAdmin()
        );
    }

    /**
     * @Template("AdminBundle:content:add_admin.html.twig")
     *
     * @param   Request $request
     * @return  array | RedirectResponse
     */
    public function addAdminAction(Request $request)
    {
        $admin = new Administrator();
        $form  = $this->createForm(AdministratorType::class, $admin, array(
            'create'    => true
        ));

        $form
            ->add('save', SubmitType::class, array(
                'label' => 'Save',
                'attr'  => array(
                    'class' => 'btn btn-success'
                ),
                'translation_domain' => 'forms'
            ))
        ;

        $form->handleRequest($request);
        if ($form->isValid()) {
            // Persisting the new administrator
            $this->get('challengeme.manager.administrator')->create($admin, Role::ROLE_ADMIN);

            // Redirecting after success
            return $this->redirectToRoute('administration_adminsManagement');
        }

        return array(
            'form'  => $form->createView()
        );
    }

    /**
     * @Template("AdminBundle:content:update_admin.html.twig")
     *
     * @param $id
     * @param Request $request
     * @return array|RedirectResponse
     */
    public function updateAdminAction($id, Request $request)
    {
        // Retrieving admin
        $admin = $this->get('challengeme.manager.administrator')->readById($id);
        
        // Building the form
        $form   = $this->createForm(AdministratorType::class, $admin, array(
            'create' => false
        ));
        $form
            ->add('save', SubmitType::class, array(
                'label' => 'Save',
                'attr'  => array(
                    'class' => 'btn btn-success'
                ),
                'translation_domain' => 'forms'
            ))
        ;
        
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            // In case the plain password haven't been changed
            if ($admin->getPlainPassword() === "********") {
                $admin->eraseCredentials();
            }

            // Persisting the admin
            $this->get('challengeme.manager.administrator')->update($admin);
            
            // Redirecting to the admins management page
            return $this->redirectToRoute('administration_adminsManagement');
        }
        
        return array(
            'username' => $admin->getUsername(),
            'form'     => $form->createView()
        );
    }
    
    /**
     * Remove and admin from the database
     *
     * @param $id
     * @param Request $request
     * @return RedirectResponse
     */
    public function removeAdminAction($id, Request $request)
    {
        // Checking authorization
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'You are not allowed to access this page');

        // Retrieving url and the referer
        $url        = $this->generateUrl('administration_adminsManagement');
        $referer    = $request->server->get('HTTP_REFERER');

        // If not from adminsManagement, redirecting without doing anything
        if (false === strstr($referer, $url)) {
            return $this->redirectToRoute('administration_adminsManagement');
        }

        // Retrieving admin
        $admin = $this->get('challengeme.manager.administrator')->readById($id);

        // Everything correct, removing
        $this->get('challengeme.manager.administrator')->delete($admin);

        // Redirecting
        return $this->redirectToRoute('administration_adminsManagement');
    }

    /**
     * @Template("AdminBundle:content:moderators_management.html.twig")
     *
     * @return array
     */
    public function moderatorsManagementAction() {
        /** @var AdministratorManager $adminManager */
        $adminManager = $this->get('challengeme.manager.administrator');

        return array(
            'moderators' => $adminManager->getAllModerators()
        );
    }

    /**
     * @Template("AdminBundle:content:add_moderator.html.twig")
     *
     * @param Request $request
     * @return array|RedirectResponse
     */
    public function addModeratorAction(Request $request)
    {
        $moderator  = new Administrator();
        $form   = $this->createForm(ModeratorType::class, $moderator);

        $form
            ->add('save', SubmitType::class, array(
                'label' => 'Save',
                'attr'  => array(
                    'class' => 'btn btn-success'
                ),
                'translation_domain' => 'forms'
            ))
        ;

        $form->handleRequest($request);
        if ($form->isValid()) {
            // Persisting the new administrator
            $this->get('challengeme.manager.administrator')->create($moderator, Role::ROLE_MODERATOR);

            // Redirecting after success
            return $this->redirectToRoute('administration_moderatorsManagement');
        }

        return array(
            'form'  => $form->createView()
        );
    }

    /**
     * @Template("AdminBundle:content:update_moderator.html.twig")
     *
     * @param   int     $id
     * @param   Request $request
     * @return  array | RedirectResponse
     */
    public function updateModeratorAction($id, Request $request)
    {
        // Retrieving admin
        $moderator = $this->get('challengeme.manager.administrator')->readById($id);

        // Building the form
        $form   = $this->createForm(AdministratorType::class, $moderator, array(
            'create' => false
        ));
        $form
            ->add('save', SubmitType::class, array(
                'label' => 'Save',
                'attr'  => array(
                    'class' => 'btn btn-success'
                ),
                'translation_domain' => 'forms'
            ))
        ;

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            // In case the plain password haven't been changed
            if ($moderator->getPlainPassword() === "********") {
                $moderator->eraseCredentials();
            }

            // Persisting the admin
            $this->get('challengeme.manager.administrator')->update($moderator);

            // Redirecting to the admins management page
            return $this->redirectToRoute('administration_moderatorsManagement');
        }

        return array(
            'username' => $moderator->getUsername(),
            'form'     => $form->createView()
        );
    }
    
    /**
     * Remove a moderator from database
     *
     * @param $id
     * @param Request $request
     * @return RedirectResponse
     */
    public function removeModeratorAction($id, Request $request)
    {
        // Checking authorization
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'You are not allowed to access this page');

        // Retrieving url and the referer
        $url        = $this->generateUrl('administration_moderatorsManagement');
        $referer    = $request->server->get('HTTP_REFERER');

        // If not from adminsManagement, redirecting without doing anything
        if (false === strstr($referer, $url)) {
            return $this->redirectToRoute('administration_moderatorsManagement');
        }

        // Retrieving admin
        $moderator = $this->get('challengeme.manager.administrator')->readById($id);

        // Everything correct, removing
        $this->get('challengeme.manager.administrator')->delete($moderator);

        // Redirecting
        return $this->redirectToRoute('administration_moderatorsManagement');
    }

    /**
     * @Template("AdminBundle:content:redactors_management.html.twig")
     *
     * @return array
     */
    public function redactorsManagementAction() {
        /** @var AdministratorManager $adminManager*/
        $adminManager = $this->get('challengeme.manager.administrator');

        return array(
            'redactors' => $adminManager->getAllRedactors()
        );
    }

    /**
     * @Template("AdminBundle:content:add_redactor.html.twig")
     *
     * @param Request $request
     * @return array|RedirectResponse
     */
    public function addRedactorAction(Request $request)
    {
        $redactor = new Administrator();
        $form     = $this->createForm(RedactorType::class, $redactor);

        $form
            ->add('save', SubmitType::class, array(
                'label' => 'Save',
                'attr'  => array(
                    'class' => 'btn btn-success'
                ),
                'translation_domain' => 'forms'
            ))
        ;

        $form->handleRequest($request);
        if ($form->isValid()) {
            // Persisting the new redactor
            $this->get('challengeme.manager.administrator')->create($redactor, Role::ROLE_REDACTOR);

            // Redirecting after success
            return $this->redirectToRoute('administration_redactorsManagement');
        }

        return array(
            'form'  => $form->createView()
        );
    }

    /**
     * @Template("AdminBundle:content:update_redactor.html.twig")
     *
     * @param $id
     * @param Request $request
     * @return array|RedirectResponse
     */
    public function updateRedactorAction($id, Request $request)
    {
        // Retrieving admin
        $redactor = $this->get('challengeme.manager.administrator')->readById($id);

        // Building the form
        $form   = $this->createForm(AdministratorType::class, $redactor, array(
            'create' => false
        ));
        $form
            ->add('save', SubmitType::class, array(
                'label' => 'Save',
                'attr'  => array(
                    'class' => 'btn btn-success'
                ),
                'translation_domain' => 'forms'
            ))
        ;

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            // In case the plain password haven't been changed
            if ($redactor->getPlainPassword() === "********") {
                $redactor->eraseCredentials();
            }

            // Persisting the admin
            $this->get('challengeme.manager.administrator')->update($redactor);

            // Redirecting to the admins management page
            return $this->redirectToRoute('administration_redactorsManagement');
        }

        return array(
            'username' => $redactor->getUsername(),
            'form'     => $form->createView()
        );
    }
    
    /**
     * Remove a redactor from database
     *
     * @param $id
     * @param Request $request
     * @return RedirectResponse
     */
    public function removeRedactorAction($id, Request $request)
    {
        // Checking authorization
        $this->denyAccessUnlessGranted('ROLE_MODERATOR', null, 'You are not allowed to access this page');

        // Retrieving url and the referer
        $url        = $this->generateUrl('administration_redactorsManagement');
        $referer    = $request->server->get('HTTP_REFERER');

        // If not from adminsManagement, redirecting without doing anything
        if (false === strstr($referer, $url)) {
            return $this->redirectToRoute('administration_redactorsManagement');
        }

        // Retrieving admin
        $redactor = $this->get('challengeme.manager.administrator')->readById($id);

        // Everything correct, removing
        $this->get('challengeme.manager.administrator')->delete($redactor);

        // Redirecting
        return $this->redirectToRoute('administration_redactorsManagement');
    }

    /**
     * Reset the password for the given user
     *
     * @param   $id
     * @param   Request $request
     * @return  RedirectResponse
     */
    public function resetPasswordAction($id, Request $request)
    {
        // Retreving the referer
        $referer    = $request->server->get('HTTP_REFERER');

        // Generating url
        $adminUrl       = $this->generateUrl('administration_adminsManagement');
        $moderatorUrl   = $this->generateUrl('administration_moderatorsManagement');
        $redactorUrl    = $this->generateUrl('administration_redactorsManagement');

        // Resetting admin password
        if (false !== strstr($referer, $adminUrl)) {
            // Denying access
            $this->denyAccessUnlessGranted('ROLE_ADMIN', null, "You are not allowed to access this page");

            // Retrieving the manager
            $manager = $this->get('challengeme.manager.administrator');

            // Retrieving admin
            $admin   = $manager->readById($id);

            // Resetting the password
            $manager->resetPassword($admin);

            // Redirecting
            return $this->redirectToRoute('administration_adminsManagement', array(
                'success' => 'Password reseted successfully'
            ));
        }

        // Resetting moderator password
        else if (false !== strstr($referer, $moderatorUrl)) {
            // Denying access
            $this->denyAccessUnlessGranted('ROLE_ADMIN', null, "You are not allowed to access this page");

            // Retrieving the manager
            $manager    = $this->get('challengeme.manager.administrator');

            // Retrieving admin
            $moderator  = $manager->readById($id);

            // Resetting the password
            $manager->resetPassword($moderator);

            // Redirecting
            return $this->redirectToRoute('administration_moderatorsManagement');
        }

        // Resetting redactor password
        else if (false !== strstr($referer, $redactorUrl)) {
            // Denying access
            $this->denyAccessUnlessGranted('ROLE_MODERATOR', null, "You are not allowed to access this page");

            // Retrieving the manager
            $manager    = $this->get('challengeme.manager.administrator');

            // Retrieving admin
            $redactor   = $manager->readById($id);

            // Resetting the password
            $manager->resetPassword($redactor);

            // Redirecting
            return $this->redirectToRoute('administration_redactorsManagement');
        }

        // Resetting admin password
        else {
            // Redirecting
            return $this->redirectToRoute('administration_homepage');
        }
    }
}
