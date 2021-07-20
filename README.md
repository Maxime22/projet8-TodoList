# TodoList

## Français

### Prérequis
- PHP >= 7.4
- composer : https://getcomposer.org/doc/00-intro.md
- yarn : https://classic.yarnpkg.com/en/docs/getting-started/
- Serveur local fonctionnel permettant de se connecter à une base de donnée (WAMP/MAMP/LAMP avec php, mysql et phpmyadmin ou tout autre configuration similaire)

### Installation du projet
- Cloner le projet sur votre repository
- Aller sur le répertoire du projet nouvellement créé et faire : ```composer update```
- Remplir les données DATABASE_URL dans .env.local et .env.test.local (si les fichiers n’existent pas => les créer à la racine du projet (au même niveau que le .env)
    Exemple : ```DATABASE_URL=mysql://username:password@localhost:3306/databasename``` (mettre un autre nom de database dans .env.test.local si vous voulez faire des tests)
- Créer la base de donnée : ```php bin/console doctrine:database:create```
- Faire les migrations pour mettre à jour le schéma de la base de donnée : ```php bin/console doctrine:migrations:migrate```
- Charger les fixtures : ```php bin/console doctrine:fixtures:load```
- Installer webpack : ```yarn install```

### Lancer l’application en développement
- Mettre APP_ENV=dev dans les .env concernés
- Dans un premier terminal : ```symfony serve``` (si vous avez la commande symfony), autrement faire ```php bin/console server:start```
- Dans un second terminal en même temps que le serveur est en route : ```yarn watch```

### Lancer l’application en production
- Mettre APP_ENV=prod dans les .env concernés
- Créer un build de production pour la minification du CSS et du JS : ```yarn build```
- Dans un terminal : ```symfony serve``` (si vous avez la commande symfony), autrement faire ```php bin/console server:start```

### Gestion de l'optimisation
- Il est possible que l'application ne se lance pas suite à l'utilisation de : ```composer dump-autoload --no-dev --classmap-authoritative```, faire alors un ```composer update``` pour recharger les packages de développement
- Pour optimiser votre configuration serveur en production : https://symfony.com/doc/current/performance.html

### Gestion du cache
- ```php bin/console cache:clear``` ou vider les dossiers de /var/cache non désirés

### Tests
Si jamais vous voulez regarder si les tests fonctionnent :
- Rajouter xdebug à votre configuration php si vous ne l'avez pas : https://xdebug.org/
- Créer une base de donnée de test : ```php bin/console doctrine:database:create --env=test```
- Mettre à jour le schéma de la base de donnée de test : ```php bin/console doctrine:schema:update --env=test --force```
- Charger les fixtures dans la base de donnée de test : ```php bin/console doctrine:fixtures:load --env=test```
- Lancer les tests : ```php bin/phpunit``` ou ```./vendor/bin/phpunit```
- Si jamais vous voulez voir le test-coverage (dans le dossier public/test-coverage) : ```./vendor/bin/phpunit --coverage-html public/test-coverage```

### Profiling
- Si vous souhaiter tester les performances de l'application, installez et utilisez Blackfire : https://blackfire.io/docs/up-and-running/installation

--------------------------------------------------------------------------------------

## English