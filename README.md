# 🍴 Koo2fourchette

> Site de recettes en auto-hébergement — AP SIO 1A

![PHP](https://img.shields.io/badge/PHP-8.0-blue) ![MySQL](https://img.shields.io/badge/MySQL-MariaDB-orange) ![Apache](https://img.shields.io/badge/Apache-2.4-red) ![Linux](https://img.shields.io/badge/OS-Ubuntu-purple)

---

## 📋 Description

Projet d'infrastructure et de développement web pour la société **Koo_2_fourchette**, spécialisée dans la mise en ligne de recettes par des particuliers. Le site est hébergé en auto-hébergement sur une VM Linux avec Apache, PHP et MySQL.

---

## 🏗️ Architecture

```
PC Windows (hôte)
    │
    ├── 🌐 VM Serveur Web (Ubuntu)
    │       ├── Apache2 + PHP
    │       ├── MariaDB (koo_2_fourchette)
    │       ├── Adapter 1 : NAT (10.0.2.15) → Internet
    │       └── Adapter 2 : intnet (192.168.100.1) → FTP
    │
    └── 📁 VM Serveur FTP (Ubuntu)
            ├── vsftpd
            ├── Adapter 1 : intnet (192.168.100.2) → Web
            └── Adapter 2 : NAT → Internet
```

### Redirections de ports (VirtualBox NAT)

| Port Hôte | Port VM | Service |
|-----------|---------|---------|
| 8080      | 80      | Site web |
| 2222      | 22      | SSH |

---

## 🚀 Installation

### 1. Cloner le projet

```bash
git clone https://github.com/Harouna05102004/Projet_koodefourchette.git
cd koo2fourchette
```

### 2. Importer la base de données

```bash
mysql -u root koo_2_fourchette < database_corrige.sql
```

### 3. Configurer la connexion BDD

Éditer `config/database.php` :

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'koo_2_fourchette');
define('DB_USER', 'root');
define('DB_PASS', '');
```

### 4. Copier les fichiers dans Apache

```bash
sudo cp -r * /var/www/html/
sudo chown -R www-data:www-data /var/www/html/
```

### 5. Accéder au site

```
http://localhost:8080
```

---

## 📁 Structure du Projet

```
koo2fourchette/
├── config/
│   └── database.php          # Connexion BDD
├── images/                   # Logo et icônes UI
│   ├── koo_2_fourchette.png
│   ├── facebook.png
│   ├── temps.png
│   └── ...
├── photos/
│   ├── recettes/             # Photos des recettes
│   ├── gravatars/            # Avatars des membres
│   └── slides/               # Image hero accueil
├── index.php                 # Page d'accueil
├── recettes.php              # Liste des recettes
├── recette.php               # Détail d'une recette
├── login.php                 # Connexion
├── register.php              # Inscription
├── logout.php                # Déconnexion
├── deposer.php               # Ajouter une recette
├── recette_edit.php          # Modifier une recette
├── recette_delete.php        # Supprimer une recette
├── test_connexion.php        # Page de diagnostic
├── style.css                 # Styles CSS
└── database_corrige.sql      # Base de données
```

---

## 🗄️ Base de Données

**Nom :** `koo_2_fourchette`

| Table | Description |
|-------|-------------|
| `membres` | Comptes utilisateurs (SHA1) |
| `recettes` | Recettes avec photos et métadonnées |
| `categories` | viande, légume, poisson, fruit |

---

## 👥 Comptes de Test

| Login | Mot de passe | Prénom |
|-------|-------------|--------|
| natha | password | Nathalie |
| syl92 | password | Sylvie |
| lolo  | password | Laure |
| ann75 | password | Annie |
| did93 | password | Didier |

---

## ✅ Fonctionnalités

- [x] Affichage des recettes (accueil + liste complète)
- [x] Recherche de recettes par mot-clé
- [x] Filtrage par catégorie
- [x] Détail d'une recette (ingrédients, préparation, métadonnées)
- [x] Création de compte
- [x] Connexion / Déconnexion
- [x] Déposer une recette (avec photo)
- [x] Modifier une recette (auteur uniquement)
- [x] Supprimer une recette (auteur uniquement)
- [x] Cartes colorées selon la BDD (fushia, bleuClair, vertClair)

---

## 🖥️ Commandes Utiles

### Apache
```bash
sudo systemctl start apache2
sudo systemctl status apache2
sudo systemctl restart apache2
```

### MySQL
```bash
mysql -u root
USE koo_2_fourchette;
SHOW TABLES;
SELECT COUNT(*) FROM recettes;
```

### SSH
```bash
# Depuis Windows
ssh -p 2222 harouna@localhost
```

### FTP (depuis VM Web)
```bash
ftp 192.168.100.2
# Login: harouna
# Password: ton_mot_de_passe
```

### Sauvegarde manuelle
```bash
sudo /usr/local/bin/backup_ftp.sh
```

### Vérifier le cron
```bash
sudo crontab -l
```

---

## 🌐 Réseau Interne

```bash
# Vérifier les IPs
ip a

# Tester la connexion entre VMs
ping 192.168.100.2   # Depuis VM Web → VM FTP
ping 192.168.100.1   # Depuis VM FTP → VM Web
```

---

## 📦 Technologies

| Technologie | Version | Usage |
|-------------|---------|-------|
| PHP | 8.x | Backend dynamique |
| MariaDB | 10.x | Base de données |
| Apache2 | 2.4 | Serveur web |
| Ubuntu | 22.04 | Système d'exploitation |
| vsftpd | 3.0 | Serveur FTP |
| VirtualBox | 7.x | Virtualisation |

---

## 👤 Auteur

**Harouna Diakite** 
