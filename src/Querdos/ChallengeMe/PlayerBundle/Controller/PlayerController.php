<?php

namespace Querdos\ChallengeMe\PlayerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
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
        $categoryManager  = $this->get('challengeme.manager.category');
        $challengeManager = $this->get('challengeme.manager.challenge');
        $playerManager    = $this->get('challengeme.manager.player');

        // returning array
        return array(
            'categories'        => $categoryManager->all(),
            'categoryCount'     => $categoryManager->count(),
            'challengesCount'   => $challengeManager->count(),
            'playerCount'       => $playerManager->count()
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

        return array(
            'categories' => $categories,
            'teams'      => $teams
        );
    }

    /**
     * @Template("PlayerBundle:content-players:player_my_team.html.twig")
     *
     * @return array
     */
    public function myTeamAction()
    {
        // retrieving categories
        $categories = $this->get('challengeme.manager.category')->all();

        return array(
            'categories' => $categories
        );
    }

    /**
     * @Template("PlayerBundle:content-players:player_create_team.html.twig")
     *
     * @param Request $request
     *
     * @return array
     */
    public function createTeamAction(Request $request)
    {
        // retrieving categories
        $categories = $this->get('challengeme.manager.category')->all();

        return array(
            'categories' => $categories
        );
    }
}
