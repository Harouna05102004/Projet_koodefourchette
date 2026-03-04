<?php
require_once 'config/database.php';
session_start();
if (isset($_SESSION['membre'])) { header('Location: index.php'); exit; }

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $mdp   = $_POST['password']  ?? '';
    if ($login && $mdp) {
        $db   = getDB();
        $hash = sha1($mdp);
        $stmt = $db->prepare("SELECT * FROM membres WHERE login = ? AND password = ?");
        $stmt->execute([$login, $hash]);
        $membre = $stmt->fetch();
        if ($membre) {
            $_SESSION['membre'] = ['idMembre'=>$membre['idMembre'],'login'=>$membre['login'],'prenom'=>$membre['prenom'],'nom'=>$membre['nom'],'statut'=>$membre['statut'],'gravatar'=>$membre['gravatar']];
            header('Location: index.php'); exit;
        } else { $error = "Login ou mot de passe incorrect."; }
    } else { $error = "Veuillez remplir tous les champs."; }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Connexion - Koo2fourchette</title>
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
  <h2>SE CONNECTER</h2>
  <div class="msg-hint">💡 Comptes de test : <strong>natha</strong>, <strong>syl92</strong>, <strong>lolo</strong>… — mot de passe : <strong>password</strong></div>
  <?php if ($error): ?><div class="msg-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
  <form method="POST">
    <div class="form-group">
      <label>Login</label>
      <input type="text" name="login" required placeholder="Ex: natha" value="<?= htmlspecialchars($_POST['login'] ?? '') ?>">
    </div>
    <div class="form-group">
      <label>Mot de passe</label>
      <input type="password" name="password" required placeholder="password">
    </div>
    <button type="submit" class="btn-submit">SE CONNECTER</button>
  </form>
  <div class="link-alt">Pas encore de compte ? <a href="register.php">Créer un compte</a></div>
</div>

<footer><p>© <?= date('Y') ?> Koo2fourchette - Tous droits réservés</p></footer>
</body>
</html>