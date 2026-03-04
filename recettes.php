<?php
require_once 'config/database.php';
session_start();

$db  = getDB();
$q   = trim($_GET['q']   ?? '');
$cat = (int)($_GET['cat'] ?? 0);

if ($q) {
    $stmt = $db->prepare("SELECT r.*, m.prenom, m.gravatar FROM recettes r JOIN membres m ON r.membre = m.idMembre WHERE r.titre LIKE ? OR r.chapo LIKE ? ORDER BY r.dateCrea DESC");
    $s = "%$q%"; $stmt->execute([$s, $s]);
} elseif ($cat) {
    $stmt = $db->prepare("SELECT r.*, m.prenom, m.gravatar FROM recettes r JOIN membres m ON r.membre = m.idMembre WHERE r.categorie = ? ORDER BY r.dateCrea DESC");
    $stmt->execute([$cat]);
} else {
    $stmt = $db->query("SELECT r.*, m.prenom, m.gravatar FROM recettes r JOIN membres m ON r.membre = m.idMembre ORDER BY r.dateCrea DESC");
}
$recettes = $stmt->fetchAll();

$couleurCSS = ['fushia'=>'card-pink','bleuClair'=>'card-blue-light','vertClair'=>'card-yellow'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Recettes - Koo2fourchette</title>
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
        <input type="text" name="q" placeholder="rechercher une recette" value="<?= htmlspecialchars($q) ?>">
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
        <?php if (isset($_SESSION['membre'])): ?>
          <span class="btn-login"><?= htmlspecialchars($_SESSION['membre']['prenom']) ?></span>
          <a href="logout.php" class="btn-register">se déconnecter</a>
        <?php else: ?>
          <a href="login.php" class="btn-login">se connecter</a>
          <a href="register.php" class="btn-register">créer un compte</a>
        <?php endif; ?>
      </div>
      <a href="deposer.php" class="btn-deposer">déposer une recette</a>
    </div>
  </div>
  <nav class="main-nav">
    <a href="recettes.php"       class="nav-link active">RECETTES</a>
    <a href="recettes.php?cat=1" class="nav-link">MENUS</a>
    <a href="recettes.php?cat=4" class="nav-link">DESERTS</a>
    <a href="recettes.php?cat=2" class="nav-link">MINCEUR</a>
    <a href="#"                  class="nav-link">ATELIER</a>
    <a href="#"                  class="nav-link">CONTACT</a>
  </nav>
</header>

<section class="recettes-jour">
  <div class="section-title">
    <h2><?= $q ? 'RÉSULTATS POUR « '.htmlspecialchars($q).' »' : 'TOUTES LES RECETTES' ?></h2>
  </div>
  <?php if (empty($recettes)): ?>
    <p style="padding:40px;text-align:center;color:#777;">Aucune recette trouvée.</p>
  <?php else: ?>
  <div class="cards-grid">
    <?php foreach ($recettes as $r):
      $css = $couleurCSS[$r['couleur']] ?? 'card-yellow';
    ?>
    <div class="recipe-card">
      <div class="card-img">
        <a href="recette.php?id=<?= $r['idRecette'] ?>">
          <img src="photos/recettes/<?= htmlspecialchars($r['img']) ?>"
               alt="<?= htmlspecialchars($r['titre']) ?>"
               onerror="this.src='photos/recettes/marmelade-carottes.jpg'">
        </a>
      </div>
      <div class="card-body <?= $css ?>">
        <h3 class="card-title">
          <a href="recette.php?id=<?= $r['idRecette'] ?>" style="color:inherit;"><?= htmlspecialchars($r['titre']) ?></a>
        </h3>
        <p class="card-desc"><?= htmlspecialchars(substr(strip_tags($r['chapo']), 0, 150)) ?></p>
      </div>
      <div class="card-author">
        <img src="photos/gravatars/<?= htmlspecialchars($r['gravatar']) ?>"
             class="avatar" alt=""
             onerror="this.style.display='none'">
        <span>proposé par <strong><?= htmlspecialchars($r['prenom']) ?></strong></span>
        <?php if (isset($_SESSION['membre']) && $_SESSION['membre']['idMembre'] == $r['membre']): ?>
          <a href="recette_edit.php?id=<?= $r['idRecette'] ?>" style="margin-left:auto;color:var(--blue);font-weight:700;">✏</a>
          <a href="recette_delete.php?id=<?= $r['idRecette'] ?>" onclick="return confirm('Supprimer ?')" style="color:red;font-weight:700;">✕</a>
        <?php endif; ?>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>
</section>

<footer><p>© <?= date('Y') ?> Koo2fourchette - Tous droits réservés</p></footer>
</body>
</html>