#!/bin/bash
#
# Author: Hamza ESSAYEGH (Querdos)
#
# This script can be used to create a new installation of the platform
#

# checking arguments
withFixtures=0
if [[ ! -z $1 ]];then
  if [[ $1 = "--with-fixtures" ]]; then
    withFixtures=1
  else
    echo "Usage: $0 [--with-fixtures]"
  fi
fi
exit
# checking directory
[[ $(pwd) =~ .*\/ChallengeMe$ ]] || { echo "You must execute this script in the ChallengeMe root directory" && exit; }

# checking php installation
command -v php > /dev/null 2>&1 || \
  { echo "PHP is not installed. Please install it and retry the installation." && exit; }

# checking curl installation
command -v curl > /dev/null 2>&1 || \
  { echo "CURL is not installed. Please install it and retry the installation." && exit; }

# checking bower
command -v bower > /dev/null 2>&1 || \
  { echo "BOWER is not installed. Please install it and retry the installation." && exit; }

# checking that composer is installed
installComposer=0
command -v composer > /dev/null 2>&1 || installComposer=1

if [[ installComposer -eq 1 ]]; then
    while true; do
        read -p "Composer is not installed, do you want me to install it for you? " yn
        case ${yn} in
            [Yy]* ) curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --filename=composer; echo; break;;
            [Nn]* ) echo "aborting."; exit;;
            * ) echo "Please answer yes or no.";echo;;
        esac
    done
fi

# composer and bower vendor installation
composer install
bower install

# dumping assets for prod environment
./console assetic:dump --env=prod

# database configuration
echo "Migrating the database ..."
./console doctrine:migration:migrate --quiet

# checking if fixtures generation or not
[[ ${withFixtures} -eq 1 ]] && ./console doctrine:fixtures:load --fixtures=src/Querdos/ChallengeMe/PlayerBundle/DataFixtures

# Adding tasks to the cron list
./console cron:add
