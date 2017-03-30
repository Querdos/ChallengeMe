<?php
/**
 * Created by Hamza ESSAYEGH.
 * Date: 6/5/16
 * Time: 12:18 PM
 */

namespace Querdos\ChallengeMe\AdministratorBundle\Controller;

use Querdos\ChallengeMe\AdministratorBundle\Entity\DatabaseDump;
use Querdos\ChallengeMe\AdministratorBundle\Form\UploadDumpType;
use Querdos\ChallengeMe\AdministratorBundle\Utils\DatabaseUtils;
use Querdos\ChallengeMe\UserBundle\Entity\Administrator;
use Querdos\ChallengeMe\AdministratorBundle\Form\AdministratorType;
use Querdos\ChallengeMe\UserBundle\Entity\Player;
use Querdos\ChallengeMe\UserBundle\Entity\Role;
use Querdos\ChallengeMe\UserBundle\Manager\AdministratorManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\VarDumper\VarDumper;

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
        $adminManager  = $this->get('challengeme.manager.administrator');
        $playerManager = $this->get('challengeme.manager.player');
        $teamManager   = $this->get('challengeme.manager.team');

        // retrieving categories
        $categories = $this->get('challengeme.manager.category')->all();

        return array(
            'adminCount'    => $adminManager->adminCount(),
            'modoCount'     => $adminManager->modoCount(),
            'redacCount'    => $adminManager->redacCount(),
            'playerCount'   => $playerManager->count(),
            'teamCount'     => $teamManager->count(),
            'categories'    => $categories
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
            ->readByRecipient($this->getUser());

        // retrieving categories
        $categories = $this->get('challengeme.manager.category')->all();

        return array(
            'messages'      => $messages,
            'categories'    => $categories
        );
    }

    /**
     * @Template("AdminBundle:content:profile.html.twig")
     *
     * @return array
     */
    public function profileAction()
    {
        // retrieving categories
        $categories = $this->get('challengeme.manager.category')->all();

        return array(
            'categories' => $categories
        );
    }

    /**
     * @Template("AdminBundle:content-user:players_management.html.twig")
     *
     * @return array
     */
    public function playersManagementAction()
    {
        // retrieving categories
        $categories = $this->get('challengeme.manager.category')->all();

        // retrieving players
        $players = $this->get('challengeme.manager.player')->all();

        return array(
            'categories' => $categories,
            'players'    => $players
        );
    }

    /**
     * @Template("AdminBundle:content-user:admin_management.html.twig")
     *
     * @return array
     */
    public function adminsManagementAction()
    {
        /** @var AdministratorManager $adminManager */
        $adminManager = $this->get('challengeme.manager.administrator');

        // retrieving categories
        $categories = $this->get('challengeme.manager.category')->all();

        return array(
            'administrators' => $adminManager->getAllAdmin(),
            'categories'     => $categories
        );
    }

    /**
     * @Template("AdminBundle:content-user:admin_add.html.twig")
     *
     * @param   Request $request
     *
     * @return  array | RedirectResponse
     */
    public function addAdminAction(Request $request)
    {
        $admin = new Administrator();
        $form = $this->createForm(AdministratorType::class, $admin, array(
            'create' => true
        ));

        $form
            ->add('save', SubmitType::class, array(
                'label' => 'Save',
                'attr' => array(
                    'class' => 'btn btn-success'
                ),
                'translation_domain' => 'forms'
            ));

        $form->handleRequest($request);
        if ($form->isValid()) {
            // setting admin role
            $admin->setRole(
                $this->get('challengeme.manager.role')->adminRole()
            );

            // Persisting the new administrator
            $this->get('challengeme.manager.administrator')->create($admin, Role::ROLE_ADMIN);

            // Redirecting after success
            return $this->redirectToRoute('administration_adminsManagement');
        }

        // retrieving categories
        $categories = $this->get('challengeme.manager.category')->all();

        return array(
            'form'          => $form->createView(),
            'categories'    => $categories
        );
    }

    /**
     * @Template("AdminBundle:content-user:admin_update.html.twig")
     *
     * @param int     $id
     * @param Request $request
     *
     * @return array|RedirectResponse
     */
    public function updateAdminAction($id, Request $request)
    {
        // Retrieving admin
        $admin = $this->get('challengeme.manager.administrator')->readById($id);

        // Building the form
        $form = $this->createForm(AdministratorType::class, $admin, array(
            'create' => false
        ));
        $form
            ->add('save', SubmitType::class, array(
                'label' => 'Save',
                'attr' => array(
                    'class' => 'btn btn-success'
                ),
                'translation_domain' => 'forms'
            ));

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

        // retrieving categories
        $categories = $this->get('challengeme.manager.category')->all();

        return array(
            'username'      => $admin->getUsername(),
            'form'          => $form->createView(),
            'categories'    => $categories
        );
    }

    /**
     * Remove and admin from the database
     *
     * @param int     $id
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function removeAdminAction($id, Request $request)
    {
        // Retrieving url and the referer
        $url     = $this->generateUrl('administration_adminsManagement');
        $referer = $request->server->get('HTTP_REFERER');

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
     * @Template("AdminBundle:content-user:moderator_management.html.twig")
     *
     * @return array
     */
    public function moderatorsManagementAction()
    {
        /** @var AdministratorManager $adminManager */
        $adminManager = $this->get('challengeme.manager.administrator');

        // retrieving categories
        $categories = $this->get('challengeme.manager.category')->all();

        return array(
            'moderators' => $adminManager->getAllModerators(),
            'categories' => $categories
        );
    }

    /**
     * @Template("AdminBundle:content-user:moderator_add.html.twig")
     *
     * @param Request $request
     *
     * @return array|RedirectResponse
     */
    public function addModeratorAction(Request $request)
    {
        $moderator = new Administrator();
        $form = $this->createForm(AdministratorType::class, $moderator);

        $form
            ->add('save', SubmitType::class, array(
                'label' => 'Save',
                'attr' => array(
                    'class' => 'btn btn-success'
                ),
                'translation_domain' => 'forms'
            ));

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            // setting moderator role
            $moderator->setRole(
                $this->get('challengeme.manager.role')->moderatorRole()
            );

            // Persisting the new administrator
            $this->get('challengeme.manager.administrator')->create($moderator);

            // Redirecting after success
            return $this->redirectToRoute('administration_moderatorsManagement');
        }

        // retrieving categories
        $categories = $this->get('challengeme.manager.category')->all();

        return array(
            'form'          => $form->createView(),
            'categories'    => $categories
        );
    }

    /**
     * @Template("AdminBundle:content-user:moderator_update.html.twig")
     *
     * @param   int     $id
     * @param   Request $request
     *
     * @return  array | RedirectResponse
     */
    public function updateModeratorAction($id, Request $request)
    {
        // Retrieving admin
        $moderator = $this->get('challengeme.manager.administrator')->readById($id);

        // Building the form
        $form = $this->createForm(AdministratorType::class, $moderator, array(
            'create' => false
        ));
        $form
            ->add('save', SubmitType::class, array(
                'label' => 'Save',
                'attr' => array(
                    'class' => 'btn btn-success'
                ),
                'translation_domain' => 'forms'
            ));

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

        // retrieving categories
        $categories = $this->get('challengeme.manager.category')->all();

        return array(
            'username'      => $moderator->getUsername(),
            'form'          => $form->createView(),
            'categories'    => $categories
        );
    }

    /**
     * Remove a moderator from database
     *
     * @param int     $id
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function removeModeratorAction($id, Request $request)
    {
        // Retrieving url and the referer
        $url = $this->generateUrl('administration_moderatorsManagement');
        $referer = $request->server->get('HTTP_REFERER');

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
     * @Template("AdminBundle:content-user:redactor_management.html.twig")
     *
     * @return array
     */
    public function redactorsManagementAction()
    {
        /** @var AdministratorManager $adminManager */
        $adminManager = $this->get('challengeme.manager.administrator');

        // retrieving categories
        $categories = $this->get('challengeme.manager.category')->all();

        return array(
            'redactors'     => $adminManager->getAllRedactors(),
            'categories'    => $categories
        );
    }

    /**
     * @Template("AdminBundle:content-user:redactor_add.html.twig")
     *
     * @param Request $request
     *
     * @return array|RedirectResponse
     */
    public function addRedactorAction(Request $request)
    {
        $redactor = new Administrator();
        $form = $this->createForm(AdministratorType::class, $redactor);

        $form
            ->add('save', SubmitType::class, array(
                'label' => 'Save',
                'attr' => array(
                    'class' => 'btn btn-success'
                ),
                'translation_domain' => 'forms'
            ));

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            // setting the redactor
            $redactor->setRole(
                $this->get('challengeme.manager.role')->redactorRole()
            );

            // Persisting the new redactor
            $this->get('challengeme.manager.administrator')->create($redactor);

            // Redirecting after success
            return $this->redirectToRoute('administration_redactorsManagement');
        }

        // retrieving categories
        $categories = $this->get('challengeme.manager.category')->all();

        return array(
            'form'       => $form->createView(),
            'categories' => $categories
        );
    }

    /**
     * @Template("AdminBundle:content-user:redactor_update.html.twig")
     *
     * @param int     $id
     * @param Request $request
     *
     * @return array|RedirectResponse
     */
    public function updateRedactorAction($id, Request $request)
    {
        // Retrieving admin
        $redactor = $this->get('challengeme.manager.administrator')->readById($id);

        // Building the form
        $form = $this->createForm(AdministratorType::class, $redactor, array(
            'create' => false
        ));
        $form
            ->add('save', SubmitType::class, array(
                'label' => 'Save',
                'attr' => array(
                    'class' => 'btn btn-success'
                ),
                'translation_domain' => 'forms'
            ));

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

        // retrieving categories
        $categories = $this->get('challengeme.manager.category')->all();

        return array(
            'username'      => $redactor->getUsername(),
            'form'          => $form->createView(),
            'categories'    => $categories
        );
    }

    /**
     * Remove a redactor from database
     *
     * @param int     $id
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function removeRedactorAction($id, Request $request)
    {
        // Retrieving url and the referer
        $url = $this->generateUrl('administration_redactorsManagement');
        $referer = $request->server->get('HTTP_REFERER');

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
     * @param   int     $id
     * @param   Request $request
     *
     * @return  RedirectResponse
     */
    public function resetPasswordAction($id, Request $request)
    {
        // Retreving the referer
        $referer = $request->server->get('HTTP_REFERER');

        // Generating url
        $adminUrl     = $this->generateUrl('administration_adminsManagement');
        $moderatorUrl = $this->generateUrl('administration_moderatorsManagement');
        $redactorUrl  = $this->generateUrl('administration_redactorsManagement');
        $playersUrl   = $this->generateUrl('administration_playersManagement');

        // Resetting admin password
        if (false !== strstr($referer, $adminUrl)) {
            // Retrieving the manager
            $manager = $this->get('challengeme.manager.administrator');

            // Retrieving admin
            $admin = $manager->readById($id);

            // Resetting the password
            $manager->resetPassword($admin);

            // Redirecting
            return $this->redirectToRoute('administration_adminsManagement', array(
                'success' => 'Password reseted successfully'
            ));
        } // Resetting moderator password
        else if (false !== strstr($referer, $moderatorUrl)) {
            // Retrieving the manager
            $manager = $this->get('challengeme.manager.administrator');

            // Retrieving admin
            $moderator = $manager->readById($id);

            // Resetting the password
            $manager->resetPassword($moderator);

            // Redirecting
            return $this->redirectToRoute('administration_moderatorsManagement');
        } // Resetting redactor password
        else if (false !== strstr($referer, $redactorUrl)) {
            // Retrieving the manager
            $manager = $this->get('challengeme.manager.administrator');

            // Retrieving admin
            $redactor = $manager->readById($id);

            // Resetting the password
            $manager->resetPassword($redactor);

            // Redirecting
            return $this->redirectToRoute('administration_redactorsManagement');
        } // Resetting player password
        else if (false !== strstr($referer, $playersUrl)) {
            // retrieving the manager
            $manager = $this->get('challengeme.manager.player');

            // retrieving player
            $player = $manager->readById($id);

            // reseting the password
            $manager->resetPassword($player);

            // redirecting
            return $this->redirectToRoute('administration_playersManagement');
        } // Otherwise, redirecting
        else {
            // Redirecting
            return $this->redirectToRoute('administration_homepage');
        }
    }

    /**
     * @param int $playerId
     *
     * @return RedirectResponse
     */
    public function blockPlayerAction($playerId)
    {
        // retrieving the manager
        $manager = $this->get('challengeme.manager.player');

        // retrieving the player
        /** @var Player $player */
        $player = $manager->readById($playerId);

        // checking if the player is blocked
        if ($player->isBlocked()) {
            $manager->changePlayerState($player);
        } else {
            // blocking the user
            $manager->changePlayerState($player);
        }

        // redirecting
        return $this->redirectToRoute('administration_playersManagement');
    }

    /**
     * @Template("AdminBundle:content:system.html.twig")
     *
     * @param Request $request
     *
     * @return array|RedirectResponse
     */
    public function systemAction(Request $request)
    {
        // retrieving categories
        $categories = $this->get('challengeme.manager.category')->all();

        // retrieving dumps
        $dumps = $this->get('challengeme.manager.database_dump')->all();

        // building the form for the upload dump
        $dump     = new DatabaseDump();
        $formDump = $this
            ->createForm(UploadDumpType::class, $dump, array(
                'attr' => array(
                    'id' => 'formUploadDump'
                ),
            ))
            ->add('save', SubmitType::class, array(
                'label' => 'Restore',
                'attr' => array(
                    'id'    => 'buttonRestoreDatabase',
                    'class' => 'btn btn-danger'
                ),
                'translation_domain' => 'forms'
            ))
        ;

        // handling the form
        $formDump->handleRequest($request);
        if ($formDump->isSubmitted()) {
            // moving the dump to TMP folder
            $dump->getDumpFile()->move('/tmp', 'dump.sql');

            // retrieving container and database informations
            $options   = [
                "db_user" => $this->container->getParameter('database_user'),
                "db_pwd"  => $this->container->getParameter("database_password"),
                "db_name" => $this->container->getParameter("database_name")
            ];

            // retrieving database utils
            $dbUtils = $this->get('challengeme.utils.database');

            // emptying database
            DatabaseUtils::emptyDatabase($options);

            // restoring
            DatabaseUtils::restoreDatabase($options, "/tmp/dump.sql");

            // cleaning if needed
            $dbUtils->checkResources();

            // removing the temporary dump
            unlink("/tmp/dump.sql");

            // redirecting
            return $this->redirectToRoute('administration_system');
        }

        return array(
            'categories' => $categories,
            'dumps'      => $dumps,
            'formDump'   => $formDump->createView()
        );
    }

    /**
     * @return JsonResponse
     */
    public function dumpAction()
    {
        // retrieving mysql informations
        $container     = $this->get('service_container');
        $database_name = $container->getParameter('database_name');
        $database_user = $container->getParameter('database_user');
        $database_pwd  = $container->getParameter('database_password');

        // executing the dump
        shell_exec("mysqldump -u $database_user --password=\"$database_pwd\" --databases $database_name > /tmp/dump.sql");

        // creating the dump object
        $databaseDump = new DatabaseDump();
        $file = new File("/tmp/dump.sql");

        // hydrating
        $databaseDump
            ->setDumpFile($file)
            ->setDumpName(uniqid() . ".sql")
            ->setDumpFileName("dump-challengeme-" . ((new \DateTime())->format("mdY")) . ".sql")
            ->setDumpSize($file->getSize())
        ;

        // moving the file and renaming it
        $file->move(
            $container->get('kernel')->getRootDir() . "/../web/dumps",
            $databaseDump->getDumpName()
        );

        // persisting
        $this->get('challengeme.manager.database_dump')->create($databaseDump);
        return new JsonResponse();
    }

    /**
     * @param int $dumpId
     *
     * @return RedirectResponse
     */
    public function deleteDumpAction($dumpId)
    {
        $dumpManager = $this->get('challengeme.manager.database_dump');

        // retrieving the dump
        $dump = $dumpManager->readById($dumpId);

        // deleting and redirecting
        $dumpManager->delete($dump);
        return $this->redirectToRoute('administration_system');
    }
}
