<?php
/**
 * Created by PhpStorm.
 * User: querdos
 * Date: 3/22/17
 * Time: 6:10 PM
 */

namespace Querdos\ChallengeMe\PlayerBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\Config\FileLocator;

class PlayerExtension extends Extension
{

    /**
     * Loads a specific configuration.
     *
     * @param array $configs An array of configuration values
     * @param ContainerBuilder $container A ContainerBuilder instance
     *
     * @throws \InvalidArgumentException When provided tag is not defined in this extension
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        // creating the loader
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));

        // injecting managers
        $loader->load('managers.yml');

        // injecting repositories
        $loader->load('repositories.yml');
    }
}