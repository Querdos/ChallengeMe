<?php

namespace Querdos\ChallengeMe\PlayerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

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
}
