<?php
require_once 'config/database.php';
session_start();
$error = $success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login  = trim($_POST['login']  ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $nom    = trim($_POST['nom']    ?? '');
    $mdp    = $_POST['password']    ?? '';
    $mdp2   = $_POST['password2']   ?? '';

    if (!$login||!$prenom||!$nom||!$mdp||!$mdp2) { $error = "Veuillez remplir tous les champs."; }
    elseif ($mdp !== $mdp2)  { $error = "Les mots de passe ne correspondent pas."; }
    elseif (strlen($mdp)<6)  { $error = "Le mot de passe doit faire au moins 6 caractères."; }
    else {
        $db   = getDB();
        $stmt = $db->prepare("SELECT idMembre FROM membres WHERE login = ?");
        $stmt->execute([$login]);
        if ($stmt->fetch()) { $error = "Ce login est déjà utilisé."; }
        else {
            $hash = sha1($mdp);
            $stmt = $db->prepare("INSERT INTO membres (gravatar, login, password, statut, prenom, nom) VALUES ('default.png', ?, ?, 'membre', ?, ?)");
            $stmt->execute([$login, $hash, $prenom, $nom]);
            $success = "Compte créé ! <a href='login.php'>Se connecter</a>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inscription - Koo2fourchette</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
  <div class="header-top">
    <div class="logo-area">
      <a href="index.php"><img src="images/koo_2_fourchette.png" alt="Koo2fourchette" style="height:70px;"></a>
      <p class="tagline">miam miam, gloup gloup, laps laps</p>
    </div>
    <div class="search-area">
      <form class="search-form" action="recettes.php" method="GET">
        <input type="text" name="q" placeholder="rechercher une recette">
        <button type="submit">OK</button>
      </form>
    </div>
    <div class="auth-area">
      <div class="social-icons">
        <a href="#" class="social-icon"><img src="images/facebook.png" alt="Facebook"></a>
        <a href="#" class="social-icon"><img src="images/twitter.png"  alt="Twitter"></a>
        <a href="#" class="social-icon"><img src="images/google.png"   alt="Google+"></a>
        <a href="#" class="social-icon"><img src="images/youtube.png"  alt="YouTube"></a>
      </div>
      <div class="auth-buttons">
        <a href="login.php"    class="btn-login">se connecter</a>
        <a href="register.php" class="btn-register">créer un compte</a>
      </div>
      <a href="deposer.php" class="btn-deposer">déposer une recette</a>
    </div>
  </div>
  <nav class="main-nav">
    <a href="recettes.php"       class="nav-link">RECETTES</a>
    <a href="recettes.php?cat=1" class="nav-link">MENUS</a>
    <a href="recettes.php?cat=4" class="nav-link">DESERTS</a>
    <a href="recettes.php?cat=2" class="nav-link">MINCEUR</a>
    <a href="#"                  class="nav-link">ATELIER</a>
    <a href="#"                  class="nav-link">CONTACT</a>
  </nav>
</header>

<div class="form-wrap">
  <h2>CRÉER UN COMPTE</h2>
  <?php if ($error):   ?><div class="msg-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
  <?php if ($success): ?><div class="msg-success"><?= $success ?></div><?php endif; ?>
  <form method="POST">
    <div class="form-group"><label>Login <span class="required">*</span></label>
      <input type="text" name="login" required placeholder="Ex: jean75" value="<?= htmlspecialchars($_POST['login'] ?? '') ?>"></div>
    <div class="form-group"><label>Prénom <span class="required">*</span></label>
      <input type="text" name="prenom" required placeholder="Jean" value="<?= htmlspecialchars($_POST['prenom'] ?? '') ?>"></div>
    <div class="form-group"><label>Nom <span class="required">*</span></label>
      <input type="text" name="nom" required placeholder="Dupont" value="<?= htmlspecialchars($_POST['nom'] ?? '') ?>"></div>
    <div class="form-group"><label>Mot de passe <span class="required">*</span></label>
      <input type="password" name="password" required placeholder="Min. 6 caractères"></div>
    <div class="form-group"><label>Confirmer le mot de passe <span class="required">*</span></label>
      <input type="password" name="password2" required></div>
    <button type="submit" class="btn-submit">CRÉER MON COMPTE</button>
  </form>
  <div class="link-alt">Déjà un compte ? <a href="login.php">Se connecter</a></div>
</div>

<footer><p>© <?= date('Y') ?> Koo2fourchette - Tous droits réservés</p></footer>
</body>
</html>