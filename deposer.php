<?php
require_once 'config/database.php';
session_start();
if (!isset($_SESSION['membre'])) { header('Location: login.php'); exit; }

$db    = getDB();
$cats  = $db->query("SELECT * FROM categories")->fetchAll();
$error = '';
$couleurs = ['fushia'=>'Rose (Fushia)','bleuClair'=>'Bleu clair','vertClair'=>'Vert clair'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre       = trim($_POST['titre']            ?? '');
    $chapo       = trim($_POST['chapo']            ?? '');
    $ingredient  = trim($_POST['ingredient']       ?? '');
    $preparation = trim($_POST['preparation']      ?? '');
    $categorie   = (int)($_POST['categorie']       ?? 1);
    $couleur     = $_POST['couleur']               ?? 'fushia';
    $tempsCuisson= trim($_POST['tempsCuisson']     ?? '');
    $tempsPrepa  = trim($_POST['tempsPreparation'] ?? '');
    $difficulte  = trim($_POST['difficulte']       ?? 'Facile');
    $prix        = trim($_POST['prix']             ?? 'Pas cher');

    if (!$titre || !$chapo || !$ingredient || !$preparation) {
        $error = "Veuillez remplir tous les champs obligatoires (*).";
    } else {
        $img = 'marmelade-carottes.jpg';
        if (!empty($_FILES['img']['name'])) {
            $ext = strtolower(pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION));
            if (in_array($ext, ['jpg','jpeg','png','gif','webp'])) {
                $img = uniqid('recette_').'.'.$ext;
                // Upload dans photos/recettes/
                move_uploaded_file($_FILES['img']['tmp_name'], "photos/recettes/$img");
            }
        }
        $stmt = $db->prepare("INSERT INTO recettes (titre, chapo, img, preparation, ingredient, membre, couleur, categorie, tempsCuisson, tempsPreparation, difficulte, prix) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
        $stmt->execute([$titre,$chapo,$img,$preparation,$ingredient,$_SESSION['membre']['idMembre'],$couleur,$categorie,$tempsCuisson,$tempsPrepa,$difficulte,$prix]);
        header('Location: recette.php?id='.$db->lastInsertId()); exit;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Déposer une recette - Koo2fourchette</title>
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
        <span class="btn-login"><?= htmlspecialchars($_SESSION['membre']['prenom']) ?></span>
        <a href="logout.php" class="btn-register">se déconnecter</a>
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

<div class="form-wrap" style="max-width:680px;">
  <h2>DÉPOSER UNE RECETTE</h2>
  <p style="color:#777;font-size:13px;margin-bottom:15px;">Connecté : <strong><?= htmlspecialchars($_SESSION['membre']['prenom'].' '.$_SESSION['membre']['nom']) ?></strong></p>
  <?php if ($error): ?><div class="msg-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
  <form method="POST" enctype="multipart/form-data">
    <div class="form-group"><label>Titre <span class="required">*</span></label>
      <input type="text" name="titre" required placeholder="Ex: Soupe de légumes" value="<?= htmlspecialchars($_POST['titre'] ?? '') ?>"></div>
    <div class="form-group"><label>Description courte <span class="required">*</span></label>
      <textarea name="chapo" required><?= htmlspecialchars($_POST['chapo'] ?? '') ?></textarea></div>
    <div class="form-row">
      <div class="form-group"><label>Catégorie</label>
        <select name="categorie">
          <?php foreach ($cats as $c): ?><option value="<?= $c['idCategorie'] ?>"><?= htmlspecialchars($c['nom']) ?></option><?php endforeach; ?>
        </select></div>
      <div class="form-group"><label>Couleur</label>
        <select name="couleur">
          <?php foreach ($couleurs as $v=>$l): ?><option value="<?= $v ?>"><?= $l ?></option><?php endforeach; ?>
        </select></div>
    </div>
    <div class="form-group"><label>Ingrédients <span class="required">*</span></label>
      <textarea name="ingredient" required><?= htmlspecialchars($_POST['ingredient'] ?? '') ?></textarea></div>
    <div class="form-group"><label>Préparation <span class="required">*</span></label>
      <textarea name="preparation" required><?= htmlspecialchars($_POST['preparation'] ?? '') ?></textarea></div>
    <div class="form-row">
      <div class="form-group"><label>Temps préparation</label>
        <input type="text" name="tempsPreparation" placeholder="Ex: 15 min"></div>
      <div class="form-group"><label>Temps cuisson</label>
        <input type="text" name="tempsCuisson" placeholder="Ex: 30 min"></div>
    </div>
    <div class="form-row">
      <div class="form-group"><label>Difficulté</label>
        <select name="difficulte"><option>Facile</option><option>Moyen</option><option>Difficile</option></select></div>
      <div class="form-group"><label>Prix</label>
        <select name="prix"><option>Pas cher</option><option>Abordable</option><option>Coûteux</option></select></div>
    </div>
    <div class="form-group"><label>Photo de la recette</label>
      <input type="file" name="img" accept="image/*"></div>
    <button type="submit" class="btn-submit">PUBLIER MA RECETTE</button>
  </form>
</div>
<footer><p>© <?= date('Y') ?> Koo2fourchette - Tous droits réservés</p></footer>
</body>
</html>