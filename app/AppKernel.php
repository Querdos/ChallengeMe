<?php

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = [
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
        		
        	new Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle(),

            new Symfony\Bundle\AsseticBundle\AsseticBundle(),

            new JMS\DiExtraBundle\JMSDiExtraBundle($this),
            new JMS\AopBundle\JMSAopBundle(),
            new JMS\TranslationBundle\JMSTranslationBundle(),

            new Ivory\CKEditorBundle\IvoryCKEditorBundle(),

            new Vich\UploaderBundle\VichUploaderBundle(),

            new Querdos\ChallengeMe\AdministratorBundle\AdminBundle(),
            new Querdos\ChallengeMe\LandingBundle\LandingBundle(),
            new Querdos\ChallengeMe\UserBundle\UserBundle(),
            new Querdos\ChallengeMe\ChallengesBundle\ChallengesBundle(),
            new Querdos\ChallengeMe\PlayerBundle\PlayerBundle(),
        ];

        if (in_array($this->getEnvironment(), ['dev', 'test'], true)) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
            $bundles[] = new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle();
            $bundles[] = new Kendrick\SymfonyDebugToolbarGit\SymfonyDebugToolbarGit();
        }

        return $bundles;
    }

    public function getRootDir()
    {
        return __DIR__;
    }

    public function getCacheDir()
    {
        return dirname(__DIR__).'/var/cache/'.$this->getEnvironment();
    }

    public function getLogDir()
    {
        return dirname(__DIR__).'/var/logs';
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir().'/config/config_'.$this->getEnvironment().'.yml');
        $loader->load($this->getRootDir().'/config/config_assetic_global.yml');
        
        // Loading defaults configuration files
        $loader->load($this->getRootDir().'/config/parameters.yml');
        $loader->load($this->getRootDir().'/config/security.yml');
        $loader->load($this->getRootDir().'/config/services.yml');
    }
}
