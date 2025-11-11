# Marie_Lory_Mise_en_place_d_une_application_MVC_en_php

Ce dépôt contient le projet MVC PHP pour l'application de covoiturage (intranet).

## Contenu
- `Script_de_la_creation_de_la_base_de_donnee.sql` : script de création de la base de données
- `Script_de_l_alimentation_de_la_base_de_donnee.sql` : script d'insertions (agences, users, trips) basé sur `agences.txt`, `users.txt` et `artisanentreprise.xlsx`
- `composer.json` : dépendances PHP
- `src/` : code source (scaffold minimal)
- `public/` : point d'entrée
- `tests/` : tests unitaires (exemples)
- `doc/` : MCD image et MLD text

## Installation rapide (local)
1. Installer PHP 8.1+, Composer, MySQL.
2. Importer `Script_de_la_creation_de_la_base_de_donnee.sql` puis `Script_de_l_alimentation_de_la_base_de_donnee.sql` dans MySQL.
3. `composer install`
4. Lancer le serveur : `php -S localhost:8000 -t public`
5. Accéder à l'application: http://localhost:8000
