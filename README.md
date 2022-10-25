![Logo](public/images/logo.png)

# StayFit

Back Office permettant aux administrateurs de la marque
de salle sport de paramétrer les modules accessibles à chaque
partenaire et chaque structure de la marque.

## Table of Contents
- [Annexes](#annexes)
- [Badges](#badges)
- [Prérequis](#prérequis)
- [Installation](#installation)
- [Login](#login)
- [Documentation](#documentation)
- [Author](#author)

## Annexes

Les documents Annexes sont disponibles dans le dossier ``annexes`` : 
- Charte graphique
- Manuel d'utilisation
- Documentation technique
- Les Wireframes

## Badges
![FIGMA](https://img.shields.io/badge/Figma-F24E1E?style=for-the-badge&logo=figma&logoColor=white)
![TRELLO](https://img.shields.io/badge/Trello-0052CC?style=for-the-badge&logo=trello&logoColor=white)
![VISUAL STUDIO CODE](https://img.shields.io/badge/Visual_Studio_Code-0078D4?style=for-the-badge&logo=visual%20studio%20code&logoColor=white)
![GIT](https://img.shields.io/badge/GIT-E44C30?style=for-the-badge&logo=git&logoColor=white)

![HTML](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)
![CSS](https://img.shields.io/badge/CSS-239120?&style=for-the-badge&logo=css3&logoColor=white)
![BOOTSTRAP](https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white)
![JAVASCRIPT](https://img.shields.io/badge/JavaScript-323330?style=for-the-badge&logo=javascript&logoColor=F7DF1E)
![JQUERY](https://img.shields.io/badge/jQuery-0769AD?style=for-the-badge&logo=jquery&logoColor=white)

![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)

## Prérequis

- PHP Version 8.0.23 (CLI)
- Symfony version 5.4.12 CLI [Installer Symfony](https://symfony.com/doc/current/setup.html)
- Composer [Installer Composer](https://getcomposer.org/download/) 
- Npm [Installer Npm](https://nodejs.org/en/download/) 


## Installation

Après avoir cloné le projet avec git clone 
``git clone https://github.com/marinebde/stay-fit.git``

Rendez vous dans le terminal

Ensuite, dans l'ordre taper les commandes dans votre terminal :

- 1 composer install afin d'installer toutes les dépendances composer du projet.

- 2 npm install afin d'installer toutes les dépendances npm du projet.

- 3 installer la base de donnée MySQL. Pour paramétrer la création de votre base de donnée, rdv dans le fichier .env du projet, et modifier la variable d'environnement selon vos paramètres :
DATABASE_URL=mysql://User:Password@127.0.0.1:3306/nameDatabasse?serverVersion=5.7
Puis exécuter la création de la base de donnée avec la commande : php bin/console doctrine:database:create

- 4 Exécuter la migration en base de donnée : php bin/console doctrine:migration:migrate

- 5 Compiler le css/js : npm run build

- 6 Vous pouvez maintenant accéder à votre portfolio en vous connectant au serveur : npm run watch

## Login

Voici un compte super-admin qui vous permettra de vous connecter à la plateforme :
  - Nom d’utilisateur :  ``mbcontactservice@gmail.com``
  - Mot de Passe :       ``123456789``

Voici un compte partenaire qui vous permettra de vous connecter à la plateforme :
  - Nom d’utilisateur :  ``boidemarine@hotmail.fr``
  - Mot de Passe :       ``123456789``

Voici un compte structure qui vous permettra de vous connecter à la plateforme :
  - Nom d’utilisateur :  ``m4riine_44@hotmail.fr``
  - Mot de Passe :       ``123456789``

## Documentation

Lisez le [guide](https://symfony.com/doc/current/page_creation.html) de démarrage si vous êtes nouveau sur Symfony.

## Author

* **Marine Boidé** _alias_  [@marinebde](https://github.com/marinebde)