## Projet Ovni news / API 
#### Lien du projet : http://ovni-news-reactapp.herokuapp.com/  ** Site accessible uniquement en HTTP **
#### Lien de l'API: https://api-ovni-news.herokuapp.com/

--------------------------------------------------------
#### API Symfony 5.3 / Librairie Javascript React / Base de données relationnelle MariaDB

### Résumé & Fonctionnalités

Projet de réseaux social autour de l'actualité avec un partage d'articles provenant de divers journaux couvrant plusieurs thèmes avec un système de commentaire pour permettre l'interaction entre utilisateurs enregistré sur la plateforme.

L'utilisateur arrivant sur la page d'accueil aura la possibilité de se connecter et de choisir dans quelle catégorie d'information il veut naviguer.
Les appels à l'API se font à chaque fois qu'un utilisateur clique sur la catégorie de son choix', la catégorie est placée dans l'url d'appel à l'API.
Une fois les articles récupérés de l'API, l'application traitera les données en filtrant les données comportant obligatoire titre, image et url de la source extérieur, puis vérifiera si les données sont déjà enregistrées ou non dans la base de données et les ajoutes dans celle-ci dans le cas où elle ne serait pas enregistré.

L'utilisateur à accès à un filtre par auteur et par nombre d'articles retournés dans la liste.

Une fois l'article choisi, une page de détail de celui-ci s'affichera et un espace de commentaire permettant aux utilisateurs de réagir à l'info.


### Deploiement en local

- Cloner les fichiers sur votre ordinateur avec GIT `https://github.com/kevin-chlt/Api-Ovni-New.git`.
- Installer les dépendances de l'application avec `composer install`.
- Aller sur le site de [News Api](https://newsapi.org/) pour obtenir une clé d'API que vous définirez dans la variable d'environnement `NEWS_API_KEY` à l'intérieur du projet.
- Effectué la migration de la base de données (vous avez préalablement configuré les identifiants dans le fichier `.env`) avec la commande `php bin/console doctrine:migrations:migrate`.
- Pour recevoir les articles provenant de l'API `News API`, vous allez devoir importez les différentes catégories d'informations contenues dans`category_import.sql` est disponible à 
la racine du projet de l'API. La commande est `php bin/console doctrine:database:import category_import.sql`.
- Pour l'authentification utilisateur et la génération du token, le bundle `LexikJWTAuthenticationBundle` nécessite les clés de sécurité que vous pourrez générer avec `php bin/console lexik:jwt:generate-keypair`,
vous allez devoir aussi créer une variable d'environnement nommée `JWT_PASSPHRASE` que vous définirez dans le fichier .env. 

Vous pouvez maintenant lancer votre serveur local et commencer à naviguer dans l'API.




