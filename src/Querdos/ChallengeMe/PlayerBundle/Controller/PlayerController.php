<?php

namespace Querdos\ChallengeMe\PlayerBundle\Controller;

use Ivory\CKEditorBundle\Exception\Exception;
use Querdos\ChallengeMe\ChallengesBundle\Entity\Category;
use Querdos\ChallengeMe\ChallengesBundle\Entity\Rating;
use Querdos\ChallengeMe\PlayerBundle\Entity\Notification;
use Querdos\ChallengeMe\PlayerBundle\Entity\TeamActivity;
use Querdos\ChallengeMe\PlayerBundle\Form\PlayerRoleType;
use Querdos\ChallengeMe\PlayerBundle\Form\SolveChallengeType;
use Querdos\ChallengeMe\PlayerBundle\Form\TeamType;
use Querdos\ChallengeMe\PlayerBundle\Form\UploadAvatarType;
use Querdos\ChallengeMe\UserBundle\Entity\Demand;
use Querdos\ChallengeMe\UserBundle\Entity\Player;
use Querdos\ChallengeMe\UserBundle\Entity\PlayerRole;
use Querdos\ChallengeMe\UserBundle\Entity\Team;
use Querdos\ChallengeMe\UserBundle\Manager\DemandManager;
use Querdos\ChallengeMe\UserBundle\Manager\PlayerManager;
use Querdos\ChallengeMe\UserBundle\Manager\TeamManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

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
        $categoryManager     = $this->get('challengeme.manager.category');
        $challengeManager    = $this->get('challengeme.manager.challenge');
        $playerManager       = $this->get('challengeme.manager.player');
        $teamManager         = $this->get('challengeme.manager.team');
        $notificationManager = $this->get('challengeme.manager.notification');

        $data['stats'] = [
            'categoryCount'     => $categoryManager->count(),
            'challengesCount'   => $challengeManager->count(),
            'playerCount'       => $playerManager->count(),
            'teamCount'         => $teamManager->count(),
        ];

        $data['unreadNotifications'] = $notificationManager->getUnreadForPlayer($this->getUser());
        if ($this->getUser()->hasTeam()) {
            $data['teamRank'] = $teamManager
                ->getTeamRank($this->getUser()->getTeam())
            ;

            // retrieving recent activities for current team
            $data['teamActivities'] = $this
                ->get('challengeme.manager.team_activity')
                ->readForTeam($this->getUser()->getTeam())
            ;
        }

        // retrieving recent activities for current player
        $data['playerActivities'] = $this
            ->get('challengeme.manager.player_activity')
            ->readForPlayer($this->getUser())
        ;

        // returning array
        return $data;
    }

    /**
     * @Template("PlayerBundle:content:profile.html.twig")
     *
     * @return array
     */
    public function profileAction()
    {
        // retrieving the notification manager
        $notificationManager = $this->get('challengeme.manager.notification');

        return array(
            'unreadNotifications'   => $notificationManager->getUnreadForPlayer($this->getUser())
        );
    }

    /**
     * @Template("PlayerBundle:content-players:player_players_list.html.twig")
     *
     * @return array
     */
    public function playersListAction()
    {
        // retrieving players
        $players             = $this->get('challengeme.manager.player')->all();
        $notificationManager = $this->get('challengeme.manager.notification');

        return array(
            'players'               => $players,
            'unreadNotifications'   => $notificationManager->getUnreadForPlayer($this->getUser())
        );
    }

    /**
     * @Template("PlayerBundle:content-players:player_teams_list.html.twig")
     *
     * @return array
     */
    public function teamsListAction()
    {
        // retrieving all teams
        $teams      = $this->get('challengeme.manager.team')->all();

        // retrieving demands for the current user
        $demands    = $this->get('challengeme.manager.demand')->allForPlayer($this->getUser());

        // retrieving ranks
        $ranks = array();
        $teamManager = $this->get('challengeme.manager.team');

        /** @var Team $team */
        foreach ($teams as $team) {
            $ranks[$team->getId()] = $teamManager->getTeamRank($team);
        }

        // retrieving notifications manager
        $notificationManager = $this->get('challengeme.manager.notification');

        // returning data
        return array(
            'teams'                 => $teams,
            'demands'               => $demands,
            'ranks'                 => $ranks,
            'unreadNotifications'   => $notificationManager->getUnreadForPlayer($this->getUser())
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
        // retrieving notification manager
        $notificationManager         = $this->get('challengeme.manager.notification');
        $data['unreadNotifications'] = $notificationManager->getUnreadForPlayer($this->getUser());

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
            $data['form'] = $form->createView();
        }

        // otherwise, if the user has a team
        else {
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

            // retrieving challenges completion
            $challengesCompletion = $this
                ->get('challengeme.manager.challenge_solving')
                ->getChallengesCompletionForTeam($this->getUser()->getTeam())
            ;

            // team manager
            /** @var TeamManager $teamManager */
            $teamManager = $this->get('challengeme.manager.team');

            // ranking (top 3)
            $top3 = $teamManager->getTeamsRanked(3);

            // the user has a team
            $data['challengesCompletion'] = $challengesCompletion;
            $data['lastActivities']       = $this->get('challengeme.manager.team_activity')->readForTeam($team);
            $data['top3']                 = $top3;
            $data['team']                 = $team;
            $data['totalTeam']            = $teamManager->count();
            $data['rank']                 = $teamManager->getTeamRank($team);
            $data['formAvatar']           = $formAvatar->createView();
            $data['formPlayerRole']       = $formPlayerRole->createView();
            $data['avatarPath']           = $avatarPath;
            $data['demands']              = $demands;
            $data['playerRoles']          = $playerRoles;
        }

        // returning data
        return $data;
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
        // the user has no team, redirecting
        if (!$this->getUser()->hasTeam()) {
            return $this->redirectToRoute('player_homepage');
        }

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
        // the user has no team, redirecting
        if (!$this->getUser()->hasTeam()) {
            return $this->redirectToRoute('player_homepage');
        }

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
        // the user has no team, redirecting
        if (!$this->getUser()->hasTeam()) {
            return $this->redirectToRoute('player_homepage');
        }

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
        // the user has no team, redirecting
        if (!$this->getUser()->hasTeam()) {
            return $this->redirectToRoute('player_homepage');
        }

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
        /** @var PlayerRole $role */
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
        $this
            ->get('challengeme.manager.player_role')
            ->setRoleForPlayer($role, $player)
        ;

        return new JsonResponse();
    }

    /**
     * @Template("PlayerBundle:content-players:player_challenges.html.twig")
     *
     * @return array|RedirectResponse
     */
    public function challengesAction()
    {
        // checking if a challenge is in progress for the current team
        if (null !== $this->getUser()->getTeam()) {
            // retrieving challenge solving manager
            $challengeSolvingManager = $this->get('challengeme.manager.challenge_solving');

            if (null !== $challengeSolvingManager->getChallengeInProgress($this->getUser()->getTeam())) {
                return $this->redirectToRoute('player_challenge_solving');
            }
        }

        // retrieving categories
        $categories       = $this->get('challengeme.manager.category')->all();
        $challengeManager = $this->get('challengeme.manager.challenge');

        // retrieving total challenges by categories
        $countChallenges = array();
        /** @var Category $category */
        foreach ($categories as $category) {
            $countChallenges[$category->getId()] = $challengeManager->count($category);
        }

        // retrieving notification manager
        $notificationManager = $this->get('challengeme.manager.notification');

        return array(
            'categories'            => $categories,
            'countChallenges'       => $countChallenges,
            'unreadNotifications'   => $notificationManager->getUnreadForPlayer($this->getUser())
        );
    }

    /**
     * @Template("PlayerBundle:content-players:player_challenges_by_category.html.twig")
     *
     * @param int $categoryId
     *
     * @return array|RedirectResponse
     */
    public function challengesByCategoryAction($categoryId)
    {
        // retrieving challenge solving manager
        $challengeSolvingManager = $this->get('challengeme.manager.challenge_solving');

        // checking if a challenge is in progress for the current team
        if (null !== $this->getUser()->getTeam()) {
            if (null !== $challengeSolvingManager->getChallengeInProgress($this->getUser()->getTeam())) {
                return $this->redirectToRoute('player_challenge_solving');
            }
        }

        // retrieving the category
        $category = $this->get('challengeme.manager.category')->readById($categoryId);

        // retrieving challenges for this category
        $challenges = $this->get('challengeme.manager.challenge')->readByCategory($category);

        // retrieving validations
        $validations = array();
        foreach($challenges as $challenge) {
            $validations[$challenge->getId()] = $challengeSolvingManager->getValidationForChallenge($challenge);
        }

        // retrieving notes for each challenges
        $notes = array();
        $ratingManager = $this->get('challengeme.manager.rating');

        foreach ($challenges as $challenge) {
            $notes[$challenge->getId()] = $ratingManager->noteForChallenge($challenge);
        }

        // retrieving challenges solved (ids)
        $challengesSolved = $this
            ->get('challengeme.manager.challenge_solving')
            ->getChallengesSolved($this->getUser()->getTeam())
        ;

        // retrieving notification manager
        $notificationManager = $this->get('challengeme.manager.notification');

        $lastTeams = $this->get('challengeme.manager.challenge_solving')->getLastTeamsForCategory($category);

        // returning data
        return array(
            'category'              => $category,
            'lastTeams'             => $lastTeams,
            'challenges'            => $challenges,
            'challengesSolved'      => $challengesSolved,
            'notes'                 => $notes,
            'validations'           => $validations,
            'notifications'         => $notificationManager->getForPlayer($this->getUser()),
            'unreadNotifications'   => $notificationManager->getUnreadForPlayer($this->getUser())
        );
    }

    /**
     * @param int $challengeId
     *
     * @return RedirectResponse
     */
    public function startChallengeAction($challengeId)
    {
        // redirecting if user has no team
        if (null === $this->getUser()->getTeam()) {
            return $this->redirectToRoute('player_homepage');
        }

        // retrieving the challenge
        $challenge = $this->get('challengeme.manager.challenge')->readById($challengeId);

        try {
            // starting it for the current team
            $this
                ->get('challengeme.manager.challenge_solving')
                ->startChallenge(
                    $challenge,
                    $this->getUser()->getTeam()
                );
        } catch (\Exception $e) {
            // meaning that a challenge has already been started
            return $this->redirectToRoute('player_challenge_solving');
        }

        // everything ok, redirecting
        return $this->redirectToRoute('player_challenge_solving');
    }

    /**
     * @Template("PlayerBundle:content-players:player_challenge_solving.html.twig")
     *
     * @param Request $request
     *
     * @return array|RedirectResponse
     */
    public function challengeSolvingAction(Request $request)
    {
        // the user has no team, redirecting
        if (!$this->getUser()->hasTeam()) {
            return $this->redirectToRoute('player_homepage');
        }

        // retrieving challengesolving manager
        $challengeSolvingManager = $this->get('challengeme.manager.challenge_solving');

        // checking if the user's team has a challenge in progress
        if (null === ($challengeSolving = $challengeSolvingManager->getChallengeInProgress($this->getUser()->getTeam()))) {
            return $this->redirectToRoute('player_homepage');
        }

        // retrieving the challenge
        $challenge = $challengeSolving->getChallenge();

        // retrieving validations for this challenge
        $validations = $challengeSolvingManager->getValidationForChallenge($challenge);

        // creating a form for submitting a solution
        $formSubmitSolution = $this->createForm(SolveChallengeType::class, $this->getUser());
        $formSubmitSolution
            ->add('save', SubmitType::class, array(
                'label' => 'Send',
                'attr' => array(
                    'class' => 'btn btn-primary'
                ),
                'translation_domain' => 'forms'
            ))
        ;

        // handling the form
        $formSubmitSolution->handleRequest($request);
        if ($formSubmitSolution->isSubmitted()) {
            // submit the solution
            $check = $this
                ->get('challengeme.manager.player')
                ->checkSolution(
                    $this->getUser()->getSolution(),
                    $challenge,
                    $this->getUser()->getTeam()
                )
            ;

            // if the solution is correct
            if (true === $check) {
                // send a notification for the team
                $this
                    ->get('challengeme.manager.notification')
                    ->sendForTeam(
                        $this->getUser()->getTeam(),
                        "Congratulations, your team has solved a new challenge (" . $challenge->getTitle() .")!"
                    )
                ;

                // returning to challenges page
                return $this->redirectToRoute('player_challenges_category', array('categoryId' => $challenge->getCategory()->getId()));
            }

            return $this->redirectToRoute('player_challenge_solving');
        }

        // retrieving notifications manager
        $notificationManager = $this->get('challengeme.manager.notification');

        // retrieving resources for the challenge
        $resources = $this->get('challengeme.manager.challenge_resource')->readByChallenge($challenge);

        // returning data
        return array(
            'challenge'             => $challenge,
            'challengeSolve'        => $challengeSolving,
            'formSolution'          => $formSubmitSolution->createView(),
            'validations'           => $validations,
            'unreadNotifications'   => $notificationManager->getUnreadForPlayer($this->getUser()),
            'resources'             => $resources
        );
    }

    /**
     * @param int $resourceId
     *
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function downloadResourceForChallengeAction($resourceId)
    {
        // retrieving the resource
        $resource = $this->get('challengeme.manager.challenge_resource')->readById($resourceId);

        // generating the download link
        $downloadHandler = $this->get('vich_uploader.download_handler');
        return $downloadHandler->downloadObject($resource, 'resourceFile');
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     * @throws \Exception
     */
    public function rateChallengeAction(Request $request)
    {
        // Checking that the user has a team
        if (!$this->getUser()->hasTeam()) {
            throw new \Exception("You are not allowed to perform this operation");
        }

        // retrieving the challenge
        $challenge = $this
            ->get('challengeme.manager.challenge')
            ->readById($request->request->get('challengeId'))
        ;

        // checking that the team has completed this challenge
        $solved = $this
            ->get('challengeme.manager.challenge_solving')
            ->teamHasSolveChallenge(
                $this->getUser()->getTeam(),
                $challenge
            )
        ;

        // stopping if not solved
        if (!$solved) {
            throw new \Exception("You are not allowed to perform this operation");
        }

        // retrieving the mark
        $mark = $request->request->get('rating');

        // retrieving the rating manager
        $ratingManager = $this->get('challengeme.manager.rating');
        $rating = new Rating(
            $challenge,
            $this->getUser(),
            $mark
        );

        // persisting
        $ratingManager->create($rating);

        // everything ok
        return new JsonResponse();
    }

    /**
     * @Template("PlayerBundle:content-players:player_teams_ranking.html.twig")
     */
    public function rankingAction()
    {
        // retrieving ranked team
        $teamsRanked         = $this->get('challengeme.manager.team')->getTeamsRanked();
        $notificationManager = $this->get('challengeme.manager.notification');

        // returning data
        return array(
            'teams'                 => $teamsRanked,
            'notifications'         => $notificationManager->getForPlayer($this->getUser()),
            'unreadNotifications'   => $notificationManager->getUnreadForPlayer($this->getUser())
        );
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     * @throws \Exception
     */
    public function setNotificationRedAction(Request $request)
    {
        // retrieving parameter
        $notificationId = $request->request->get('notificationId');

        // retrieving the corresponding notification
        $notificationManager = $this->get('challengeme.manager.notification');
        /** @var Notification $notification */
        $notification        = $notificationManager->readById($notificationId);

        // checking that the user is correct
        if ($notification->getPlayer()->getUsername() !== $this->getUser()->getUsername()) {
            throw new \Exception('You are not allowed to perform this operation');
        }

        // changing the state and updating
        $notification->setState(true);
        $notificationManager->update($notification);

        // everything ok
        return new JsonResponse();
    }

    /**
     * @return RedirectResponse
     * @throws Exception
     */
    public function leaveTeamAction()
    {
        // checking that the user is not the team leader
        $team = $this->getUser()->getTeam();
        if ($team->getLeader()->getUsername() === $this->getUser()->getUsername()) {
            throw new Exception("You are not allowed to perform this operation");
        }

        // only the user can leave his own team
        $this->get('challengeme.manager.player')->leaveTeam($this->getUser());

        // redirecting to the teams list page
        return $this->redirectToRoute('player_teams_list');
    }

    /**
     * @param int $playerId
     *
     * @return RedirectResponse
     * @throws Exception
     */
    public function promotePlayerAction($playerId)
    {
        // checking that the current user has a team
        if (!$this->getUser()->hasTeam()) {
            throw new Exception("You are not allowed to perform this operation");
        }
        /** @var Team $team */
        $team = $this->getUser()->getTeam();

        // checking that the current user is the leader
        if ($team->getLeader()->getUsername() !== $this->getUser()->getUsername()) {
            throw new Exception("You are not allowed to perform this operation");
        }

        // retrieving player and checking that he is on the team
        /** @var Player $player */
        $player = $this->get('challengeme.manager.player')->readById($playerId);
        if (!$player->hasTeam()) {
            throw new Exception("The player to promote is not on the team.");
        } else if ($player->getTeam()->getName() !== $team->getName()) {
            throw new Exception("The player to promote is not on the team");
        }

        // promoting player
        $this->get('challengeme.manager.team')->promote($player);

        // redirecting
        return $this->redirectToRoute('player_my_team');
    }
}
