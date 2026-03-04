<?php
require_once 'config/database.php';
session_start();
if (!isset($_SESSION['membre'])) { header('Location: login.php'); exit; }

$db = getDB();
$id = (int)($_GET['id'] ?? 0);
if (!$id) { header('Location: recettes.php'); exit; }

$stmt = $db->prepare("SELECT * FROM recettes WHERE idRecette = ?");
$stmt->execute([$id]);
$rec = $stmt->fetch();
if (!$rec || $rec['membre'] != $_SESSION['membre']['idMembre']) { header('Location: recettes.php'); exit; }

$cats     = $db->query("SELECT * FROM categories")->fetchAll();
$couleurs = ['fushia'=>'Rose (Fushia)','bleuClair'=>'Bleu clair','vertClair'=>'Vert clair'];
$error    = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre       = trim($_POST['titre']            ?? '');
    $chapo       = trim($_POST['chapo']            ?? '');
    $ingredient  = trim($_POST['ingredient']       ?? '');
    $preparation = trim($_POST['preparation']      ?? '');
    $categorie   = (int)($_POST['categorie']       ?? $rec['categorie']);
    $couleur     = $_POST['couleur']               ?? $rec['couleur'];
    $tempsCuisson= trim($_POST['tempsCuisson']     ?? '');
    $tempsPrepa  = trim($_POST['tempsPreparation'] ?? '');
    $difficulte  = trim($_POST['difficulte']       ?? '');
    $prix        = trim($_POST['prix']             ?? '');

    if (!$titre||!$chapo||!$ingredient||!$preparation) { $error = "Veuillez remplir tous les champs."; }
    else {
        $img = $rec['img'];
        if (!empty($_FILES['img']['name'])) {
            $ext = strtolower(pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION));
            if (in_array($ext, ['jpg','jpeg','png','gif','webp'])) {
                $img = uniqid('recette_').'.'.$ext;
                move_uploaded_file($_FILES['img']['tmp_name'], "photos/recettes/$img");
            }
        }
        $stmt = $db->prepare("UPDATE recettes SET titre=?,chapo=?,img=?,preparation=?,ingredient=?,couleur=?,categorie=?,tempsCuisson=?,tempsPreparation=?,difficulte=?,prix=? WHERE idRecette=?");
        $stmt->execute([$titre,$chapo,$img,$preparation,$ingredient,$couleur,$categorie,$tempsCuisson,$tempsPrepa,$difficulte,$prix,$id]);
        header("Location: recette.php?id=$id"); exit;
    }
    $rec = array_merge($rec, $_POST);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Modifier - Koo2fourchette</title>
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
  <h2>MODIFIER LA RECETTE</h2>
  <?php if ($error): ?><div class="msg-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
  <form method="POST" enctype="multipart/form-data">
    <div class="form-group"><label>Titre *</label>
      <input type="text" name="titre" required value="<?= htmlspecialchars($rec['titre']) ?>"></div>
    <div class="form-group"><label>Chapeau *</label>
      <textarea name="chapo" required><?= htmlspecialchars($rec['chapo']) ?></textarea></div>
    <div class="form-row">
      <div class="form-group"><label>Catégorie</label>
        <select name="categorie">
          <?php foreach ($cats as $c): ?>
            <option value="<?= $c['idCategorie'] ?>" <?= ($rec['categorie']==$c['idCategorie'])?'selected':'' ?>><?= htmlspecialchars($c['nom']) ?></option>
          <?php endforeach; ?>
        </select></div>
      <div class="form-group"><label>Couleur</label>
        <select name="couleur">
          <?php foreach ($couleurs as $v=>$l): ?><option value="<?= $v ?>" <?= ($rec['couleur']==$v)?'selected':'' ?>><?= $l ?></option><?php endforeach; ?>
        </select></div>
    </div>
    <div class="form-group"><label>Ingrédients *</label>
      <textarea name="ingredient" required><?= htmlspecialchars($rec['ingredient']) ?></textarea></div>
    <div class="form-group"><label>Préparation *</label>
      <textarea name="preparation" required><?= htmlspecialchars($rec['preparation']) ?></textarea></div>
    <div class="form-row">
      <div class="form-group"><label>Temps préparation</label>
        <input type="text" name="tempsPreparation" value="<?= htmlspecialchars($rec['tempsPreparation']) ?>"></div>
      <div class="form-group"><label>Temps cuisson</label>
        <input type="text" name="tempsCuisson" value="<?= htmlspecialchars($rec['tempsCuisson']) ?>"></div>
    </div>
    <div class="form-row">
      <div class="form-group"><label>Difficulté</label>
        <select name="difficulte">
          <?php foreach(['Facile','Moyen','Difficile'] as $d): ?><option <?= ($rec['difficulte']==$d)?'selected':'' ?>><?= $d ?></option><?php endforeach; ?>
        </select></div>
      <div class="form-group"><label>Prix</label>
        <select name="prix">
          <?php foreach(['Pas cher','Abordable','Coûteux'] as $p): ?><option <?= ($rec['prix']==$p)?'selected':'' ?>><?= $p ?></option><?php endforeach; ?>
        </select></div>
    </div>
    <div class="form-group"><label>Nouvelle photo (vide = garder l'actuelle)</label>
      <img src="photos/recettes/<?= htmlspecialchars($rec['img']) ?>" style="height:60px;display:block;margin-bottom:8px;" onerror="this.style.display='none'">
      <input type="file" name="img" accept="image/*"></div>
    <button type="submit" class="btn-submit">ENREGISTRER</button>
    <a href="recette.php?id=<?= $id ?>" style="margin-left:15px;color:#777;font-size:13px;">Annuler</a>
  </form>
</div>
<footer><p>© <?= date('Y') ?> Koo2fourchette - Tous droits réservés</p></footer>
</body>
</html>