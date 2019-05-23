#!/bin/bash
# Prepare Symfony app for REST API

if [ -n "$1" ]; then
   echo Proceed? It will install Symfony ... Ctrl-C to Cancel
   read -p "Press Enter to process"

   composer create-project symfony/skeleton $1
   cd $1
#   composer require friendsofsymfony/rest-bundle
   composer require sensio/framework-extra-bundle
   composer require jms/serializer-bundle
   composer require symfony/validator
   composer require symfony/form
   composer require symfony/orm-pack
else
   echo "Podaj nazwę projektu jako pierwszy parametr np task3"
fi


