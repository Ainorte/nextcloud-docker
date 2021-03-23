# Nextcloud sur Docker

MBDS 2020 - 2021

## Auteurs

- Kamel Bourrek
- Hassan Mazyad
- William Poitevin

## Mise en route

Cloner le projet : 

```sh
git clone https://github.com/Ainorte/nextcloud-docker
```

Rentrer dans le projet :

```sh
cd nextcloud-docker
```

Lancer docker compose :

```sh
docker-compose up -d
```

Se connecter sur l'addresse http://localhost:8080


## Faire la configuration

Créer un compte admin avec les ids souhaités

Cliquer sur `Stockage & base de donnée`

Répertoire des données : `/nextcloud`

Selectionner `MYSQL/MariaDB`

Saisir :

- Utilisateur de la base de donnée : `nextcloud`
- Mot de passe de la base de donnée : `nextcloud`
- Nom de la base de donnée : `nextcloud`
- Hôte de la base de donnée : `database`

Valider

Le projet tourne sur docker
