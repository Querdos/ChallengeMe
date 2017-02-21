<?php
/**
 * Created by Hamza ESSAYEGH.
 * User: querdos
 * Date: 20/02/17
 * Time: 16:29
 */

namespace Querdos\ChallengeMe\UserBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\Config\FileLocator;

class UserExtension extends Extension
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
        // Creating the loader
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));

        // Injecting managers
        $loader->load('managers.yml');

        // Injecting repositories
        $loader->load('repositories.yml');

        // Injecting validators
        $loader->load('validators.yml');
    }
}