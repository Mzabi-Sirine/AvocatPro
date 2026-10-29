# AvocatPro

**Application web de prise de rendez-vous pour un cabinet d'avocat**, avec un second module
consacré aux rendez-vous en préfecture (ANEF). Projet académique réalisé en PHP, sans framework.

## Fonctionnalités

- **Compte utilisateur** : inscription et connexion, mots de passe hachés avec `password_hash`
  et vérifiés avec `password_verify`.
- **Espace personnel** : consultation du profil et de l'historique des demandes.
- **Rendez-vous cabinet** : formulaire de demande avec type de rendez-vous, observation et
  horodatage automatique.
- **Module préfecture (ANEF)** : espace séparé avec inscription, connexion et demande de
  rendez-vous, stocké dans MySQL.
- **Deux bases** : SQLite pour le cabinet, MySQL pour le module préfecture.

## Stack technique

| Élément | Choix |
| --- | --- |
| Langage | PHP 8 |
| Base cabinet | SQLite via PDO |
| Base préfecture | MySQL via MySQLi |
| Sessions | Sessions PHP natives |
| Interface | HTML5 / CSS3, pages générées côté serveur |

## Structure du projet

```
index.php          page d'accueil du cabinet
login.php          connexion
registre.php       inscription (hachage du mot de passe)
profil.php         profil utilisateur
rdv-avocat.php     demande de rendez-vous au cabinet
compte-rdv.php     espace personnel et historique
rdv-pref.php       module préfecture : inscription, connexion, demande
base-table.php     création de la base SQLite et des tables
```

## Installation

Prérequis : PHP 8 avec les extensions `pdo_sqlite` et `mysqli`.

```bash
git clone https://github.com/Mzabi-Sirine/AvocatPro.git
cd AvocatPro
mkdir -p database

php -S localhost:8000
```

1. Ouvrir `http://localhost:8000/base-table.php` une fois pour créer `database/rdv.sqlite`.
2. Pour le module préfecture, renseigner les paramètres MySQL en haut de `rdv-pref.php`
   (hôte, utilisateur, mot de passe, base) et créer la table `users` correspondante.
3. Ouvrir `http://localhost:8000/`.

## Sécurité

- Requêtes préparées pour tous les accès à la base.
- Mots de passe jamais stockés en clair.
- Échappement des données affichées avec `htmlspecialchars`.

Points d'amélioration identifiés : sortir les identifiants de base du code (variables
d'environnement), désactiver `display_errors` en production, ajouter un jeton CSRF aux
formulaires. Le module préfecture est une démonstration pédagogique : il ne doit pas être
utilisé avec de véritables identifiants ANEF.

## Auteur

**Mzabi Sirine** — TEK-UP
