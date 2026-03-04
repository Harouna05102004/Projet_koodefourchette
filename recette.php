<?php
require_once 'config/database.php';
session_start();

$db = getDB();
$id = (int)($_GET['id'] ?? 0);
if (!$id) { header('Location: recettes.php'); exit; }

$stmt = $db->prepare("
    SELECT r.*, m.prenom, m.nom, m.gravatar, m.idMembre AS membreId, c.nom AS categorie
    FROM recettes r
    JOIN membres m ON r.membre = m.idMembre
    LEFT JOIN categories c ON r.categorie = c.idCategorie
    WHERE r.idRecette = ?
");
$stmt->execute([$id]);
$r = $stmt->fetch();
if (!$r) { header('Location: recettes.php'); exit; }

$couleurHex = ['fushia'=>'#c0006e','bleuClair'=>'#5b9bd5','vertClair'=>'#8bc34a'];
$couleur    = $couleurHex[$r['couleur']] ?? '#c0006e';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($r['titre']) ?> - Koo2fourchette</title>
  <link rel="stylesheet" href="style.css">
  <style>
    .detail       { max-width:860px; margin:30px auto; padding:0 20px 50px; }
    .detail h1    { font-size:28px; font-weight:700; color:<?= $couleur ?>; margin-bottom:12px; }
    .badge-cat    { display:inline-block; background:<?= $couleur ?>; color:#fff; padding:3px 12px; font-size:12px; font-weight:700; text-transform:uppercase; margin-bottom:10px; }
    .meta-bar     { display:flex; flex-wrap:wrap; gap:15px; padding:14px 18px; background:#f5f5f5; border-left:4px solid <?= $couleur ?>; margin-bottom:22px; }
    .meta-item    { display:flex; align-items:center; gap:7px; font-size:13px; color:#444; }
    .meta-item img{ width:22px; height:22px; object-fit:contain; }
    .detail-img   { width:100%; max-height:400px; object-fit:cover; margin-bottom:25px; }
    .chapo        { font-size:15px; color:#555; font-style:italic; border-left:4px solid <?= $couleur ?>; padding-left:15px; margin-bottom:28px; line-height:1.8; }
    .section      { margin-bottom:28px; }
    .section h2   { font-size:19px; font-weight:700; color:<?= $couleur ?>; border-bottom:2px solid <?= $couleur ?>; padding-bottom:6px; margin-bottom:14px; text-transform:uppercase; }
    .section ul, .section ol { padding-left:22px; line-height:2.1; color:#444; }
    .author-box   { display:flex; align-items:center; gap:15px; padding:16px; background:#f9f9f9; border-left:4px solid <?= $couleur ?>; margin-top:35px; }
    .author-box img { width:56px; height:56px; border-radius:50%; object-fit:cover; border:2px solid #ddd; }
    .btn-back     { display:inline-block; margin:15px 0 20px; color:<?= $couleur ?>; font-weight:700; font-size:13px; }
    .actions      { display:flex; gap:10px; margin-bottom:18px; }
    .btn-edit     { background:#0054a6; color:#fff; padding:8px 18px; font-size:13px; font-weight:700; }
    .btn-del      { background:#c62828; color:#fff; padding:8px 18px; font-size:13px; font-weight:700; }
  </style>
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

<div class="detail">
  <a href="recettes.php" class="btn-back">← Retour aux recettes</a>

  <?php if (isset($_SESSION['membre']) && $_SESSION['membre']['idMembre'] == $r['membreId']): ?>
  <div class="actions">
    <a href="recette_edit.php?id=<?= $r['idRecette'] ?>" class="btn-edit">✏ Modifier</a>
    <a href="recette_delete.php?id=<?= $r['idRecette'] ?>" onclick="return confirm('Supprimer ?')" class="btn-del">✕ Supprimer</a>
  </div>
  <?php endif; ?>

  <span class="badge-cat">📂 <?= htmlspecialchars($r['categorie'] ?? 'Non classée') ?></span>
  <h1><?= htmlspecialchars($r['titre']) ?></h1>

  <div class="meta-bar">
    <div class="meta-item"><img src="images/temps.png" alt="Prépa"><span>Prépa : <strong><?= htmlspecialchars($r['tempsPreparation']) ?></strong></span></div>
    <div class="meta-item"><img src="images/cuisson.png" alt="Cuisson"><span>Cuisson : <strong><?= htmlspecialchars($r['tempsCuisson']) ?></strong></span></div>
    <div class="meta-item"><img src="images/fourchette.png" alt="Difficulté"><span>Difficulté : <strong><?= htmlspecialchars($r['difficulte']) ?></strong></span></div>
    <div class="meta-item"><img src="images/prix.png" alt="Prix"><span>Prix : <strong><?= htmlspecialchars($r['prix']) ?></strong></span></div>
  </div>

  <!-- Photo recette dans photos/recettes/ -->
  <img src="photos/recettes/<?= htmlspecialchars($r['img']) ?>"
       class="detail-img" alt="<?= htmlspecialchars($r['titre']) ?>"
       onerror="this.src='photos/recettes/marmelade-carottes.jpg'">

  <div class="chapo"><?= htmlspecialchars($r['chapo']) ?></div>
  <div class="section"><h2>Ingrédients</h2><?= $r['ingredient'] ?></div>
  <div class="section"><h2>Préparation</h2><?= $r['preparation'] ?></div>

  <div class="author-box">
    <!-- Avatar dans photos/gravatars/ -->
    <img src="photos/gravatars/<?= htmlspecialchars($r['gravatar']) ?>"
         alt="" onerror="this.style.display='none'">
    <div>
      <strong><?= htmlspecialchars($r['prenom'].' '.$r['nom']) ?></strong><br>
      <span style="color:#777;font-size:12px;">A proposé cette recette le <?= date('d/m/Y', strtotime($r['dateCrea'])) ?></span>
    </div>
  </div>
</div>

<footer><p>© <?= date('Y') ?> Koo2fourchette - Tous droits réservés</p></footer>
</body>
</html>