<?php

namespace Querdos\ChallengeMe\AdministratorBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\Config\FileLocator;

/**
 *
 * @author querdos
 *        
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
		
		// Injecting managers
		$loader->load('managers.yml');
		
		// Injecting repositories
		$loader->load('repositories.yml');
		
		// Injecting validators
		$loader->load('validators.yml');
	
	}
}