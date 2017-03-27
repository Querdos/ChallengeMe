<?php
/**
 * Created by Hamza ESSAYEGH
 * User: querdos
 * Date: 3/27/17
 * Time: 1:20 PM
 */

namespace Querdos\ChallengeMe\PlayerBundle\Twig;


class PlayerExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('secondsToString', array($this, 'secondsToStringFilter'))
        );
    }

    public function secondsToStringFilter($seconds)
    {
        $secs  = $seconds - floor($seconds / 60) * 60;
        $mins  = floor($seconds / 60) - floor((floor($seconds / 60) / 60)) * 60;
        $hours = floor(floor($seconds / 60) / 60);

        $string = "";
        if ($hours > 0) {
            $string .= $hours . " h, ";
        }

        if ($mins > 0) {
            $string .= $mins . " min, ";
        }

        $string .= $secs . " sec";
        return $string;
    }
}