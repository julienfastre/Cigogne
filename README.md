Cigogne est un logiciel libre qui vise à partager des listes de naissance alternatives.

Il est basé sur le framework Symfony.

#Installation

## Créer une base de donnée

Vous devez avoir créé une base de donnée au préalable. Celle-ci peut être gérée par un serveur MySql, PostgreSQL ou SQLite (seul Postgresql est utilisé pendant la période de développement).

## Télécharger et configurer le bundle

- Créer un répertoire d'installation

Ce répertoire doit être situé dans l'arborescence accessible par votre serveur web.

Si `user` est le nom d'utilisateur et `www-data` est le groupe du service web :

```bash
mkdir cigogne
sudo chown user:www-data cigogne
sudo chmod 775 cigogne
cd cigogne
```

- Initaliser git et importer depuis github

Remplacer éventuellement l'adresse du dépôt github par celle en lecture seule (git://github.com/julienfastre/Cigogne.git), ou par celle de votre fork.

```bash
git init
git remote add origin git@github.com:julienfastre/Cigogne.git
git pull origin master
```

- Installer composer

Avec CURL:

```bash
curl -s https://getcomposer.org/installer | php
```

(autres systèmes: voir http://getcomposer.org/download/)

- Télécharger Symfony et les dépendances avec composer:

```bash
php composer.phar install
```

- Modifier les paramètres

Les paramètres de connexion à la base de donnée sont situés dans le fichier parameters.yml.

Copiez ou renommez le fichier parameters.bak.yml en parameters.yml et modifiez le.

```bash
cp parameters.bak.yml parameters.yml
```

Exemples de paramètres :

```yaml
parameters:
    database_driver:   pdo_sqlite
    database_host:     127.0.0.1
    database_port:     ~
    database_name:     username
    database_user:     password
    database_password: ~
    database_path: %kernel.root_dir%./bd/bd.sqlite

    mailer_transport:  smtp
    mailer_host:       127.0.0.1
    mailer_user:       ~
    mailer_password:   ~

    locale:            fr #important pour la traduction
    secret:            ThisTokenIsNotSoSecretChangeIt
```

- créez le schéma de la base de donnée :

En quelques clics grâce à la commande de doctrine:

```bash
php app/console doctrine:schema:create
```

- importez les données test (optionnel, mais très utile pour le développement)

```bash
php app/console doctrine:fixtures:load
```

# Erreurs communes

## Droits d'écriture des répertoire app/cache et app/logs

Très souvent, Symfony se plaint de ne pas avoir les droits d'écriture dans les répertoires app/cache et app/logs. 

Cela peut se résoudre très simplement. 

- S'il s'agit de la première utlisation: créer les répertoires et leur assigner les droits ad hoc :

```bash
mkdir app/cache
chown user:www-data app/cache
chmod 770 user:www-data app/cache
mkdir app/logs
chown user:www-data app/logs
chmod 770 user:www-data app/logs
```

- si vous avez déjà exécuté les script, il vous faudra sûrement corriger les droits (n'oubliez pas le paramètre -R qui rend l'opération récursive sur tout le contenu du répertoire) :

```bash
chown -R user:www-data app/cache
chmod -R 770 user:www-data app/cache
chown -R user:www-data app/logs
chmod -R 770 user:www-data app/logs
```



