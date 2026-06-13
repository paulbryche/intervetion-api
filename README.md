# Intervention API

API de gestion de demandes d'intervention terrain.

Une demande d’intervention représente une action à réaliser sur le terrain (ex : réparation, maintenance, intervention technique).

Une demande suit un cycle de vie : création, prise en charge, clôture ou rejet.

## 🧰 Stack technique

- PHP 8.3
- Symfony 7
- API Platform
- Doctrine ORM
- PostgreSQL (Docker)
- Symfony Messenger (asynchrone)
- Docker / Docker Compose

## 🚀 Installation du projet

### 1. Cloner le projet
git clone https://github.com/paulbryche/intervetion-api.git
cd intervetion-api

### 2. Lancer l’environnement Docker
docker compose up -d

### 3. Installer les dépendances
composer install

### 4. Vérifier Symfony
symfony check:requirements

### 5. Configuration base de données
DATABASE_URL="postgresql://app:app@127.0.0.1:5432/app?serverVersion=16&charset=utf8"

### 6. Créer et exécuter les migrations
php bin/console doctrine:migrations:migrate

### 7. Lancer le serveur Symfony
symfony server:start

## 📡 Accès à l’application
API : http://localhost:8000/api

## 🧱 Architecture du projet

- API Platform pour exposer l’API REST
- Doctrine ORM pour la persistance
- PostgreSQL via Docker
- Symfony Messenger pour l’asynchrone

## 📦 Fonctionnalités

- Création d’une demande d’intervention
- Consultation des demandes
- Suivi du cycle de vie

Statuts :
- PENDING : demande créée
- ASSIGNED : prise en charge
- COMPLETED : intervention terminée
- REJECTED : demande refusée

## 🔄 Règles métier

- Une demande commence toujours en PENDING
- Une demande COMPLETED ou REJECTED est finale
- Une transition invalide doit être rejetée
- Une demande ASSIGNED ne peut pas revenir à PENDING

## ⚙️ Asynchrone (Messenger)

Lors de la création d’une demande :
- Un message est dispatché via Symfony Messenger
- Un handler simule une notification technicien
- Traitement asynchrone

## 🔮 Améliorations possibles

- Authentification JWT
- Gestion des techniciens
- Historique des transitions
- Notifications email réelles
- Tests unitaires et fonctionnels
- CI/CD GitHub Actions

## ▶️ Lancer le projet (résumé)
git clone https://github.com/paulbryche/intervetion-api.git
cd intervetion-api
docker compose up -d
composer install
php bin/console doctrine:migrations:migrate
symfony server:start

## 👤 Auteur
Paul Bryche