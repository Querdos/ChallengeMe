ChallengeMe
===========

## Introduction ##

At first, it was a school initiative project for a CTF (Capture the flag) platform.  
The goal is to provide a complete solution for persons or organizations who wants  
to organize CTF events.

## Credits ##

Originally, it was developed as an ESIEA project by :

  * [Hamza ESSAYEGH](essayegh@et.esiea.fr)
  * [Quentin SALLIO](sallio@et.esiea.fr)
  * [Christian IPOLI FELHO](ipoli@et.esiea.fr)

Feel free to contact us if you want to fork the project.

# Installation

## Requirements ##

  * PHP 5.5.9 or higher;
  * NPM and Bower packages, for web vendor installation
  * and the [usual Symfony application requirements](http://symfony.com/doc/current/reference/requirements.html).

## Vendors installation

On the challengeme root directory, launch PHP Vendors installation by running the following command:  
`$ composer install`

The next step will consist on installing Web vendors with the following command:  
`$ bower install`

## Database configuration ##
Now that all vendors are installed, you have to configure your `parameters.yml` file by specifying database connection.
After these parameters entered, you can migrate your database by running the following command:  
`$ ./console doctrine:migration:migrate`  

## Optional: Load fixture (not for production)
If you want to have a first look at the platform with fictive players, teams and challenges, with the the following set:

    * 90    players
    * 30    teams
    * 25    categories
    * 125   challenges
    * Each team will have solved 75 challenges (randomly), so the ranking will be natural and not predefined
    
You can run the following Fixture command:  
`$ ./console doctrine:fixtures:load --fixtures=Querdos\ChallengeMe\PlayerBundle\DataFixtures`
