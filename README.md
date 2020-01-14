#Projet LBC

**Lancement du serveur Symfony si il n'y a pas Apache**

symfony server:start

**Configuration de la base de données**

Il faut une BDD mysql, la configuration est dans le fichier .env sur la ligne **DATABASE_URL**

Ensuite il faut faire la commande, pour voir les requêtes que va faire Symfony

``php bin/console doctrine:schema:update --dump-sql``

Pour lancer les requêtes, il faut faire la commande : 

``php bin/console doctrine:schema:update --force``

**Création de routes**

Si vous voulez limitez l'accès à une route, il faut mettre le nom du role au début de l'url :

**Liste des rôles :**
    - visiteur
    - responsable
    - comptable

Par exemple la route : /visiteur : Sera accessible seulement par ceux qui ont le role visiteur
