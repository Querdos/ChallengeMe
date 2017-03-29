<?php
/**
 * Created by Hamza ESSAYEGH.
 * Date: 6/5/16
 * Time: 12:18 PM
 */

namespace Querdos\ChallengeMe\AdministratorBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\Config\FileLocator;
/**
 * Created by Hamza ESSAYEGH.
 * User: querdos
 * Date: 20/02/17
 * Time: 16:29
 */

class AdminExtension extends Extension {
	
	/**
	 *
	 * {@inheritdoc}
	 *
	 * @see \Symfony\Component\DependencyInjection\Extension\ExtensionInterface::load()
	 */
	public function load(array $configs, ContainerBuilder $container) {
		// Creating the loader
		$loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));

        // Injecting listeners
        $loader->load('listeners.yml');

        // Injecting repositories
        $loader->load('repositories.yml');

        // Injecting managers
        $loader->load('managers.yml');
	}
}