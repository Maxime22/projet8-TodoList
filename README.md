# ToDoList

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
- Mettre APP_ENV=dev dans le .env
- Dans un premier terminal : ```symfony serve``` (si vous avez la commande symfony), autrement faire ```php bin/console server:start```
- Dans un second terminal en même temps que le serveur est en route : ```yarn watch```

### Lancer l’application en production
- Mettre APP_ENV=prod dans le .env
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
- Si vous souhaitez tester les performances de l'application, installez et utilisez Blackfire : https://blackfire.io/docs/up-and-running/installation

--------------------------------------------------------------------------------------

## English

### Prerequisites
- **PHP >= 7.4**
- **composer**: https://getcomposer.org/doc/00-intro.md
- **yarn**: https://classic.yarnpkg.com/en/docs/getting-started/
- **Functional local server** allowing to connect to a database (WAMP/MAMP/LAMP with php, mysql and phpmyadmin or any other similar configuration)

### Project installation
- Clone the project on your repository
- Go to the directory of the newly created project and do: ```composer update```
- Fill in the DATABASE_URL data in .env.local and .env.test.local (if the files do not exist => create them at the root of the project (at the same level as the .env)
    Example: ```DATABASE_URL=mysql://username:password@localhost:3306/databasename``` (put another database name in .env.test.local if you want to do tests)
- Create the database: ```php bin/console doctrine:database:create```
- Perform the migrations to update the database schema: ```php bin/console doctrine:migrations:migrate```
- Load fixtures: ```php bin/console doctrine:fixtures:load```
- Install webpack: ```yarn install```

### Launch the application in development
- Put APP_ENV = dev in the .env
- In a first terminal: ```symfony serve``` (if you have the symfony command), otherwise do ```php bin/console server:start```
- In a second terminal at the same time that the server is on the way: ```yarn watch```

### Launch the application in production
- Put APP_ENV=prod in the .env
- Create a production build for CSS and JS minification: ```yarn build```
- In a terminal: ```symfony serve``` (if you have the symfony command), otherwise do ```php bin/console server:start```

### Optimization management
- It is possible that the application does not launch after using: ```composer dump-autoload --no-dev --classmap-authoritative```, then do a ```composer update``` to reload development packages
- To optimize your server configuration in production: https://symfony.com/doc/current/performance.html

### Cache management
- ```php bin/console cache:clear``` or empty unwanted /var/cache folders

### Tests
If you ever want to see if the tests are working:
- Add xdebug to your php configuration if you don't have it: https://xdebug.org/
- Create a test database: ```php bin/console doctrine:database:create --env=test```
- Update the test database schema: ```php bin/console doctrine:schema:update --env=test --force```
- Load the fixtures in the test database: ```php bin/console doctrine:fixtures:load --env=test```
- Run the tests: ```php bin/phpunit``` or ```./vendor/bin/phpunit```
- If you ever want to see the test-coverage (in the public/test-coverage folder): ```./vendor/bin/phpunit --coverage-html public/test-coverage```

### Profiling
- If you want to test the performance of the application, install and use Blackfire: https://blackfire.io/docs/up-and-running/installation