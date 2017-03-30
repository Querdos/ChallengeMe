<?php
/**
 * Created by Hamza ESSAYEGH
 * User: querdos
 * Date: 3/29/17
 * Time: 5:29 PM
 */

namespace Querdos\ChallengeMe\AdministratorBundle\Utils;

use Querdos\ChallengeMe\ChallengesBundle\Manager\ChallengeResourceManager;
use Querdos\ChallengeMe\UserBundle\Manager\PlayerManager;
use Querdos\ChallengeMe\UserBundle\Manager\TeamManager;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpKernel\Kernel;


/**
 * Class DatabaseUtils
 * @package Querdos\ChallengeMe\AdministratorBundle\Utils
 *
 * This class regroup a list of functions used for the database dump
 *        - Cleaning the database with commands
 *        - Removing unused uploads or dumps after restoring the db
 */
class DatabaseUtils
{
    /**
     * @var Kernel
     */
    private $kernel;

    /**
     * @var TeamManager
     */
    private $teamManager;

    /**
     * @var PlayerManager
     */
    private $playerManager;

    /**
     * @var ChallengeResourceManager
     */
    private $challengeResourceManager;

    // TODO: Set admin manager when their avatar is implemented
    //private $adminManager;

    /**
     * Function that empty the database
     *
     * @param array $options
     */
    public static function emptyDatabase(array $options)
    {
        // checking db_user param
        if (!key_exists("db_user", $options)) {
            throw new Exception("Parameter `db_user` is missing");
        }
        $db_user = $options["db_user"];

        // checking db_pwd param
        if (!key_exists("db_pwd", $options)) {
            throw new Exception("Parameter `db_pwd` is missing");
        }
        $db_pwd = $options["db_pwd"];

        // checking db_name
        if (!key_exists("db_name", $options)) {
            throw new Exception("Parameter `db_name` is missing");
        }
        $db_name = $options["db_name"];

        // emptying database
        shell_exec("mysql -u $db_user --password=\"$db_pwd\" -e \"DROP DATABASE $db_name; CREATE DATABASE $db_name\"");
    }

    /**
     * Restore the database with the given dump
     *
     * @param array  $options
     * @param string $pathDump
     */
    public static function restoreDatabase($options, $pathDump)
    {
       // checking db_user param
        if (!key_exists("db_user", $options)) {
            throw new Exception("Parameter `db_user` is missing");
        }
        $db_user = $options["db_user"];

        // checking db_pwd param
        if (!key_exists("db_pwd", $options)) {
            throw new Exception("Parameter `db_pwd` is missing");
        }
        $db_pwd = $options["db_pwd"];

        // checking db_name
        if (!key_exists("db_name", $options)) {
            throw new Exception("Parameter `db_name` is missing");
        }
        $db_name = $options["db_name"];

        // checking file existance
        if (!file_exists($pathDump)) {
            throw new Exception("The specified dump doesn't exists");
        }

        // restoring
        shell_exec("mysql -u $db_user --password=\"$db_pwd\" $db_name < $pathDump");
    }

    /**
     * Compare resources and files and finally remove what is not in resources
     *
     * @param array  $resources
     * @param array  $files
     * @param string $dirPath
     */
    private function compareAndUnlink($resources, $files, $dirPath)
    {
        foreach ($files as $file) {
            if ($file !== "." && $file !== "..") {
                if (!in_array($file, $resources)) {
                    // removing unused avatars
                    unlink($dirPath . $file);
                }
            }
        }
    }

    /**
     * Check resources (files) in accordance to the database and remove unused files
     */
    public function checkResources()
    {
        $teamAvatarsPath = $this->kernel->getRootDir() . "/../web/uploads/team/avatars/";
        if (is_dir($teamAvatarsPath)) {
            $teamAvatarFiles = scandir($teamAvatarsPath);
            $this->compareAndUnlink(
                $this->teamManager->getResourcesForAll(),
                $teamAvatarFiles,
                $teamAvatarsPath
            );
        }

        $playerAvatarPath = $this->kernel->getRootDir() . "/../web/uploads/player/avatars/";
        if (is_dir($playerAvatarPath)) {
            $playerAvatarFiles = scandir($playerAvatarPath);
            $this->compareAndUnlink(
                $this->playerManager->getResourcesForAll(),
                $playerAvatarFiles,
                $playerAvatarPath
            );
        }

        $challengeResourcePath = $this->kernel->getRootDir() . "/../web/uploads/challenge/resources/";
        if (is_dir($challengeResourcePath)) {
            $challengeResourceFiles = scandir($challengeResourcePath);
            $this->compareAndUnlink(
                $this->challengeResourceManager->getResourcesForAll(),
                $challengeResourceFiles,
                $challengeResourcePath
            );
        }
    }

    /**
     * @param TeamManager $teamManager
     *
     * @return DatabaseUtils
     */
    public function setTeamManager($teamManager)
    {
        $this->teamManager = $teamManager;
        return $this;
    }

    /**
     * @param PlayerManager $playerManager
     *
     * @return DatabaseUtils
     */
    public function setPlayerManager($playerManager)
    {
        $this->playerManager = $playerManager;
        return $this;
    }

    /**
     * @param ChallengeResourceManager $challengeResourceManager
     *
     * @return DatabaseUtils
     */
    public function setChallengeResourceManager($challengeResourceManager)
    {
        $this->challengeResourceManager = $challengeResourceManager;
        return $this;
    }

    /**
     * @param Kernel $kernel
     *
     * @return DatabaseUtils
     */
    public function setKernel($kernel)
    {
        $this->kernel = $kernel;
        return $this;
    }
}