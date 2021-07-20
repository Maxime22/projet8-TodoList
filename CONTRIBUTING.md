# Guide de contribution
Pourquoi ce document ?

Ce document ouvre la marche en matière de collaboration à plusieurs sur le projet. Il explique comment doivent procéder tous les développeurs qui souhaitent apporter des modifications au projet. Ces explications concernent le processus de qualité à utiliser ainsi que les règles à respecter pour les fonctionnalités actuelles et futures. 
Comment procéder pour faire évoluer le projet ? Règles de qualité à respecter pour tous les développeurs du projet

## Installation et prérequis
L’ensemble des prérequis et l’explication de l’installation sont disponibles dans le README.MD du projet. Le projet est cependant en version 5.3 qui n’est pas une version stable (LTS). Il faudra passer le projet en Symfony 5.4 dès que la version sera disponible (https://symfony.com/releases/5.4). 

### Migration SQL
Le projet utilise la base de données MySQL. Pour suivre l’évolution du schéma des données, Symfony préconise l’utilisation des migrations (https://symfony.com/doc/current/doctrine.html#migrations-creating-the-database-tables-schema).

### Maker
L’utilisation du maker de symfony permet d’augmenter la rapidité de code. Symfony nous offre une librairie nous facilitant la vie pour ses utilisations standards.

### Les fichiers .env
Il ne faut pas modifier le fichier .env directement. Si jamais vous désirez apporter des modifications aux paramètres d’environnement, il faut créer un fichier .env.local dédié qui surchargera les données du .env. Le .env de base ne sert que de fichier d’information et de structure.

### SOLID, STUPID et code propre
Les principes SOLID et STUPID sont détaillés dans la partie Audit de ce projet. Ces principes permettent de guider vers une application facile à comprendre et à maintenir sur le long terme. Les principes STUPID sont les choses à éviter ou à supprimer progressivement (duplication de code, couplage fort…) lorsque l’on code afin de garder un code propre. Nous invitons l’ensemble des développeurs à apprendre et à peaufiner l’usage de ces principes. Pour exemple, le fait d’externaliser la logique hors des controllers fait partie des principes SOLID (une méthode ou une classe ne doit avoir qu’un seul but). Une ressource intéressante en PHP est https://github.com/errorname/clean-code-php.

### PSR
Les PSR (https://www.php-fig.org/psr/) sont les recommandations standards de code à suivre pour tout développeur. Ils permettent de se mettre d’accord sur la façon d’écrire du code afin que celui-ci soit facilement lisible et compréhensible. Nous respectons notamment les PSR 1, 4 et 12 en priorité.

### Tests
De nombreux tests ont été développés pour assurer la qualité et la maintenabilité de l’application. Pour chaque nouvelle fonctionnalité ajoutée à partir de là, il est important de faire les tests au fur et à mesure afin de garantir la robustesse de l’application et de ne pas laisser trop de place à d’éventuelles erreurs. De plus, il est important de relancer les tests régulièrement. Pour être sûr de ne pas régresser, il est possible de mettre en place de l’intégration continue à travers des outils comme TravisCI (https://travis-ci.org/). Différentes méthodes peuvent être mises en place pour l’écriture de ces tests (avant de coder (TDD), pendant, ou après).

### Choix de l’hébergeur 
Le choix du serveur est prépondérant en ce qui concerne les performances. C’est parfois le rôle du développeur en chef, notamment en start up de choisir celui-ci avec soin (piste éventulle : https://www.codeur.com/blog/comment-choisir-un-hebergeur-web/). 

## Collaboration et pistes d’améliorations

Pour le moment, l’application permet de gérer des utilisateurs et un système de tâches. L’ensemble du code est disponible sur Github dans un répertoire public. Pour le reprendre, il suffit de cloner le projet sur un répertoire local. Libre ensuite de mettre ce projet sur un repository privé et/ou sur un autre outil de versioning. 

### Etapes de collaboration
- Les pull request : Sur les outils de versioning comme Github, il est possible de faire ce qu’on appelle des pull request. Cela permet de proposer sa MAJ de code à la vérification. Il est important de soumettre son code à la vérification d’autres développeurs (même moins expérimentés) lorsque l’on travaille en équipe. Cela permet de garder un code plus fiable sur le long terme et de potentiellement progresser à chaque review.
- Une branche par fonctionnalité : Pour chaque nouvelle fonctionnalité, il est plus simple de s’organiser en créant une nouvelle branche. Cela permet de splitter le travail au sein de l’équipe et de ne pas - mélanger des fonctionnalités qui n’ont rien à voir entre elles.

### Les pistes d’améliorations éventuelles
- Varnish : Varnish est un outil de cache HTTP permettant d’améliorer encore la performance de notre application (https://symfony.com/doc/current/http_cache/varnish.html)
Intégrer React.js ou Vue.js à travers Webpack pour certaines pages : les pages utilisent pour le moment le moteur de template Twig. Cela permet d’utiliser les formulaires basiques de Symfony et d’afficher des pages twig avec du Bootstrap. Cependant, si la société évolue. Elle pourrait faire appel, par exemple, à des développeurs front spécialisés dans le JavaScript et/ou des UX/UI designers spécialisés dans l’expérience utilisateur. L’intégration des outils front peut se faire notamment par Webpack (https://symfony.com/doc/current/frontend/encore/reactjs.html).
- Intégration continue : Des outils comme Travis CI (https://docs.travis-ci.com/user/languages/php/) permettent de mettre en place une politique d’intégration continue. Cela permet de ne pas faire régresser l’application et de vérifier que l’ensemble des nouvelles fonctionnalités respectent les tests. Pour cela, il ne faut évidemment pas oublier d’écrire des tests au fur et à mesure.
Une documentation à l’intérieur du site (How to use) : Mettre des explications à l’intérieur du site permettrait de rendre l’expérience utilisateur meilleure.
- Transformer le site en API : Si jamais l’application évolue vers différentes plateformes (mobile, tablettes, etc...), il pourrait être intéressant de dissocier le back du front. Cela permettrait d’avoir un seul back (l’API) et plusieurs front réalisés dans des langages et des frameworks adaptés (React Native, Swift, Kotlin…). Cependant, cette amélioration vise une refonte un peu plus profonde du site (bien qu’on resterait avec Symfony pour la partie backend).
- Mettre un système d’inscription (Oauth ou Symfony) avec récupération de mot de passe : pour le moment les utilisateurs ne peuvent être créé que par des administrateurs, si jamais l’application s’ouvre à un plus large public, on pourrait ouvrir l’application à plus de monde
- Mettre un système de log : les utilisateurs rencontrent souvent des problèmes inattendus en production. Mettre en place en système de log permettrait de retrouver la trace des différentes actions effectuées.
- Mettre en place une sauvegarde automatique avec le CRON : Pour éviter de perdre les données de la base de donnée, une sauvegarde automatique peut être mise en place sur le serveur de production.

Ces différentes améliorations ne sont que des pistes éventuelles. Maintenant que le site est performant et fiable, les améliorations sont potentiellement infinies. Le but étant de respecter au mieux, selon le contexte, l’ensemble des directives de ce document qui est amené à évoluer.
