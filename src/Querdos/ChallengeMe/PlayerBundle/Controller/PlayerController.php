<?php

namespace Querdos\ChallengeMe\PlayerBundle\Controller;

use Querdos\ChallengeMe\PlayerBundle\Form\PlayerRoleType;
use Querdos\ChallengeMe\PlayerBundle\Form\TeamType;
use Querdos\ChallengeMe\PlayerBundle\Form\UploadAvatarType;
use Querdos\ChallengeMe\UserBundle\Entity\Demand;
use Querdos\ChallengeMe\UserBundle\Entity\Player;
use Querdos\ChallengeMe\UserBundle\Entity\PlayerRole;
use Querdos\ChallengeMe\UserBundle\Entity\Team;
use Querdos\ChallengeMe\UserBundle\Manager\DemandManager;
use Querdos\ChallengeMe\UserBundle\Manager\PlayerManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\VarDumper\VarDumper;

class PlayerController extends Controller
{
    /**
     * @Template("PlayerBundle:content:dashboard.html.twig")
     *
     * @return array
     */
    public function indexAction()
    {
        // retreiving managers
        $categoryManager  = $this->get('challengeme.manager.category');
        $challengeManager = $this->get('challengeme.manager.challenge');
        $playerManager    = $this->get('challengeme.manager.player');
        $teamManager      = $this->get('challengeme.manager.team');

        // returning array
        return array(
            'categories'        => $categoryManager->all(),
            'categoryCount'     => $categoryManager->count(),
            'challengesCount'   => $challengeManager->count(),
            'playerCount'       => $playerManager->count(),
            'teamCount'         => $teamManager->count()
        );
    }

    /**
     * @Template("PlayerBundle:content:profile.html.twig")
     *
     * @return array
     */
    public function profileAction()
    {
        // retrieving categories
        $categories = $this->get('challengeme.manager.category');

        return array(
            'categories' => $categories
        );
    }

    /**
     * @Template("PlayerBundle:content-players:player_players_list.html.twig")
     *
     * @return array
     */
    public function playersListAction()
    {
        // retrieving categories
        $categories = $this->get('challengeme.manager.category')->all();

        // retrieving players
        $players    = $this->get('challengeme.manager.player')->all();

        return array(
            'categories' => $categories,
            'players'    => $players
        );
    }

    /**
     * @Template("PlayerBundle:content-players:player_teams_list.html.twig")
     *
     * @return array
     */
    public function teamsListAction()
    {
        // retrieving categories
        $categories = $this->get('challengeme.manager.category')->all();

        // retrieving all teams
        $teams      = $this->get('challengeme.manager.team')->all();

        // retrieving demands for the current user
        $demands = $this->get('challengeme.manager.demand')->allForPlayer($this->getUser());

        return array(
            'categories' => $categories,
            'teams'      => $teams,
            'demands'    => $demands
        );
    }

    /**
     * @Template("PlayerBundle:content-players:player_my_team.html.twig")
     *
     * @param Request $request
     *
     * @return array | RedirectResponse
     */
    public function myTeamAction(Request $request)
    {
        // retrieving categories
        $categories = $this->get('challengeme.manager.category')->all();

        // adding list of categories to the array
        $dataToReturn = array(
            'categories' => $categories
        );

        // creating the form only if the user has no team
        if (false === $this->getUser()->hasTeam()) {
            // object for the team to be eventually created
            $team = new Team();

            // creating the form
            $form = $this->createForm(TeamType::class, $team);
            $form
                ->add('save', SubmitType::class, array(
                    'label' => 'Save',
                    'attr' => array(
                        'class' => 'btn btn-success'
                    ),
                    'translation_domain' => 'forms'
                ));

            // handling request
            $form->handleRequest($request);
            if ($form->isSubmitted()) {
                // adding the current user to the team
                $team->addPlayer($this->getUser());

                // setting the current user as the leader
                $team->setLeader($this->getUser());

                // creating the team
                $this->get('challengeme.manager.team')->create($team);

                // finally redirecting to the my team page
                return $this->redirectToRoute('player_my_team');
            }

            // adding the form to the array to return
            $dataToReturn['form'] = $form->createView();
        } else {
            // retrieving the user's team
            $team       = $this->getUser()->getTeam();
            $playerRole = new PlayerRole();

            // creating the form for the avatar and custom roles
            $formAvatar     = $this->createForm(UploadAvatarType::class, $team);
            $formPlayerRole = $this->createForm(PlayerRoleType::class, $playerRole);

            // adding save button to the avatar form
            $formAvatar
                ->add('save', SubmitType::class, array(
                    'label' => 'Upload',
                    'attr' => array(
                        'class' => 'btn btn-success'
                    ),
                    'translation_domain' => 'forms'
                ))
            ;

            // adding save button to the custom role form
            $formPlayerRole
                ->add('save', SubmitType::class, array(
                    'label' => 'Save',
                    'attr' => array(
                        'class' => 'btn btn-success'
                    ),
                    'translation_domain' => 'forms'
                ))
            ;

            // handling form requests
            $formAvatar->handleRequest($request);
            $formPlayerRole->handleRequest($request);

            // checking if the avatar form is submitted
            if ($formAvatar->isSubmitted()) {
                // updating team
                $this->get('challengeme.manager.team')->update($team);

                // redirecting
                return $this->redirectToRoute('player_my_team');
            }

            // checking if the custom role form is submitted
            if ($formPlayerRole->isSubmitted()) {
                // checking that the user is the leader
                if (false === $this->checkUserIsLeader($this->getUser())) {
                    return $this->redirectToRoute('player_homepage');
                }

                // setting the player that created the role
                $playerRole->setTeam($this->getUser()->getTeam());

                // creating the role
                $this
                    ->get('challengeme.manager.player_role')
                    ->create($playerRole)
                ;

                // redirecting to the main page
                return $this->redirectToRoute('player_my_team');
            }

            $helper     = $this->get('vich_uploader.templating.helper.uploader_helper');
            $avatarPath = $helper->asset($team, 'avatar');

            // retrieving demands and roles for the team
            $demands     = $this->get('challengeme.manager.demand')->readByTeam($team);
            $playerRoles = $this->get('challengeme.manager.player_role')->readByTeam($team);

            // the user has a team
            $dataToReturn['team']           = $team;
            $dataToReturn['formAvatar']     = $formAvatar->createView();
            $dataToReturn['formPlayerRole'] = $formPlayerRole->createView();
            $dataToReturn['avatarPath']     = $avatarPath;
            $dataToReturn['demands']        = $demands;
            $dataToReturn['playerRoles']    = $playerRoles;
        }

        // returning data
        return $dataToReturn;
    }

    /**
     * Check if the given user is the leader of his team or not
     *
     * @param Player $player
     *
     * @return bool
     * @throws \Exception
     */
    private function checkUserIsLeader(Player $player)
    {
        // first checking if player has a team
        if (false === $player->hasTeam()) {
            throw new \Exception("The player has no team");
        }

        // final checking
        return $player->getTeam()->getLeader()->getUsername() === $player->getUsername();
    }

    /**
     * @param int $demandId
     * @param int $status
     *
     * @return RedirectResponse
     * @throws \Exception
     */
    public function editDemandAction($demandId, $status)
    {
        // retrieving the demand
        /** @var Demand $demand */
        $demand        = $this->get('challengeme.manager.demand')->readById($demandId);
        $demandManager = $this->get('challengeme.manager.demand');

        // checking that the current user is the leader
        if (false === $this->checkUserIsLeader($this->getUser())) {
            return $this->redirectToRoute('player_homepage');
        }

        // checking the status
        if ($status == Demand::STATUS_DECLINED) {
            $demandManager->declineDemand($demand);
        } else if ($status == Demand::STATUS_ACCEPTED) {
            $demandManager->acceptDemand($demand);
        } else {
            throw new \Exception("Unknown status");
        }

        // everything ok, redirecting
        return $this->redirectToRoute('player_my_team');
    }

    /**
     * @param int $demandId
     *
     * @return RedirectResponse
     */
    public function clearDemandAction($demandId)
    {
        // demand manager
        $demandManager = $this->get('challengeme.manager.demand');

        // retrieving demand
        $demand = $demandManager->readById($demandId);

        // checking user is the leader
        if (false === $this->checkUserIsLeader($this->getUser())) {
            return $this->redirectToRoute('player_homepage');
        }

        // removing demand from database
        $demandManager->delete($demand);

        // everything ok, redirecting
        return $this->redirectToRoute('player_my_team');
    }

    /**
     * @param int $playerId
     *
     * @return RedirectResponse
     */
    public function removePlayerFromTeamAction($playerId)
    {
        /** @var PlayerManager $playerManager */
        $playerManager = $this->get('challengeme.manager.player');

        /** @var Player $player */
        $player = $playerManager->readById($playerId);

        // checking that the current user is in the same team as the player
        if ($this->getUser()->getTeam()->getName() === $player->getTeam()->getName()) {
            // checking that the current user is the leader
            if (false === $this->checkUserIsLeader($this->getUser())) {
                // redirecting to homepage
                return $this->redirectToRoute('player_homepage');
            } else {
                // finally removing the player from the team
                $player->setTeam(null);
                $playerManager->update($player);

                // redirecting
                return $this->redirectToRoute('player_my_team');
            }
        } else {
            // redirecting to homepage
            return $this->redirectToRoute('player_homepage');
        }
    }

    /**
     * @param int $teamId
     *
     * @return RedirectResponse
     */
    public function askJoinTeamAction($teamId)
    {
        /** @var DemandManager $team */
        $demandManager = $this->get('challengeme.manager.demand');

        // retrieving the team
        $team = $this->get('challengeme.manager.team')->readById($teamId);

        // creating the demand
        $demand = new Demand($this->getUser(), $team);
        $demandManager->create($demand);

        // redirecting
        return $this->redirectToRoute('player_teams_list');
    }

    /**
     * @param int $roleId
     *
     * @return RedirectResponse
     */
    public function deletePlayerRoleAction($roleId)
    {
        // checking that user is the leader
        if (false === $this->checkUserIsLeader($this->getUser())) {
            return $this->redirectToRoute('player_homepage');
        }

        // retrieving custom role
        $playerRoleManager = $this->get('challengeme.manager.player_role');
        $playerRole        = $playerRoleManager->readById($roleId);

        // deleting it and redirecting
        $playerRoleManager->delete($playerRole);
        return $this->redirectToRoute('player_my_team');
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     * @throws \Exception
     */
    public function setPlayerRoleAction(Request $request)
    {
        // checking user
        if (false === $this->checkUserIsLeader($this->getUser())) {
            throw new \Exception("You are not allowed to change players' role.");
        }

        // retrieving post data
        $roleId   = $request->request->get('roleId');
        $playerId = $request->request->get('playerId');

        // retrieving the custom role
        $role = $this->get('challengeme.manager.player_role')->readById($roleId);

        // checking that the role is a one created by the team
        if ($this->getUser()->getTeam()->getName() !== $role->getTeam()->getName()) {
            throw new \Exception("You are not allowed to perform this operation.");
        }

        // retrieving the player
        $playerManager = $this->get('challengeme.manager.player');
        /** @var Player $player */
        $player        = $playerManager->readById($playerId);

        // setting the role
        $player->setPlayerRole($role);

        // updating
        $playerManager->update($player);

        return new JsonResponse("OK");
    }
}
