# Laravel Deployment on Render

Ce projet est une démonstration de déploiement d'une application Laravel sur **Render**. Il inclut une configuration Docker pour le serveur **Nginx**, ainsi qu'un environnement de développement pour Laravel avec les outils nécessaires pour le déploiement.

## Table des matières
- [Prérequis](#prérequis)
- [Installation en local](#installation-en-local)
- [Configuration de Docker](#configuration-de-docker)
- [Déploiement sur Render](#déploiement-sur-render)
- [Structure du projet](#structure-du-projet)
- [Contributions](#contributions)
- [Licence](#licence)

## Prérequis

Avant de commencer, vous devez avoir installé les outils suivants sur votre machine :

- [Git](https://git-scm.com/)
- [Docker](https://www.docker.com/products/docker-desktop)
- [Node.js](https://nodejs.org/en/) (pour le build des assets frontend)
- [Composer](https://getcomposer.org/) (pour gérer les dépendances PHP)
- Un compte sur [Render](https://render.com/)

## Installation en local

### Cloner ce dépôt

Clonez ce dépôt Git sur votre machine locale :

```bash
git clone https://github.com/Micael-26/nginx-laravel-deploy-mic.git
cd nginx-laravel-deploy-mic
