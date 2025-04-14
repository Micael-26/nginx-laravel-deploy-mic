<h1 align="center">
  Déploiement de l'application Laravel 12 sur Render via Docker
</h1>

[![Live Deployment](https://img.shields.io/badge/LIVE_DEMO-▶_laravel--docker--deploy.onrender.com-46E3B7?style=for-the-badge)](https://laravel-docker-deploy.onrender.com)

## Stack utilisée

- **Laravel 12** (backend PHP)
- **Jetstream** (authentification)
- **Livewire** (composants dynamiques)
- **PostgreSQL** (base de données)
- **Docker** (conteneurisation)
- **Render** (hébergement cloud)

---

## Tests d'authentification réussis (Jetstream + Livewire)

### ✅ Fonctionnalités vérifiées

1. **Inscription utilisateur**
   - Création de compte avec validation email
   - Hachage sécurisé des mots de passe
   - Redirection vers le dashboard après inscription

2. **Connexion/Déconnexion**
   - Authentification via email/mot de passe
   - Gestion des sessions actives
   - Déconnexion sécurisée

3. **Protection des routes**
   - Accès restreint au dashboard pour utilisateurs non authentifiés
   - Middleware `auth` fonctionnel sur les routes protégées

4. **Profil utilisateur**
   - Mise à jour des informations du profil
   - Changement de mot de passe sécurisé
   - Suppression de compte

### Tests effectués

| Fonctionnalité       | Méthode de test          | Résultat |
|----------------------|--------------------------|----------|
| Inscription          | Formulaire Livewire      | ✅       |
| Connexion            | Session persistante      | ✅       |
| Mot de passe oublié  | Lien de réinitialisation | ✅       |
| Dashboard protégé   | Accès non authentifié    | ❌ (Bloqué) |

### Captures d'écran

![Authentification réussie](https://github.com/user-attachments/assets/dba5e88c-8109-442b-9646-1a532f88c250)
*Interface d'authentification Laravel Jetstream*
