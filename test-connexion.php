<?php // ⚠️ SUPPRIMER CE FICHIER EN PRODUCTION ! ?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Test - Koo2fourchette</title>
  <link rel="stylesheet" href="style.css">
  <style>
    body  { max-width:800px; margin:30px auto; padding:20px; }
    h1    { color:#c0006e; }
    h2    { border-bottom:2px solid #c0006e; padding-bottom:5px; margin:20px 0 10px; }
    .ok   { background:#e8f5e9; border-left:4px solid #4caf50; padding:10px; margin:5px 0; }
    .err  { background:#fdecea; border-left:4px solid #f44336; padding:10px; margin:5px 0; }
    .info { background:#e3f2fd; padding:9px; margin:4px 0; font-size:13px; }
    .warn { background:#fff3e0; border-left:4px solid #ff9800; padding:10px; margin:5px 0; }
    table { width:100%; border-collapse:collapse; font-size:13px; margin-top:8px; }
    th,td { border:1px solid #ddd; padding:7px 10px; }
    th    { background:#c0006e; color:#fff; }
    tr:nth-child(even){ background:#f9f9f9; }
  </style>
</head>
<body>
<h1>🔧 Page de test — Koo2fourchette</h1>
<div class="warn">⚠️ <strong>Supprimer ce fichier avant la mise en production !</strong></div>

<h2>1. PHP</h2>
<div class="ok">✅ PHP fonctionne — Version : <strong><?= phpversion() ?></strong></div>
<div class="info">Serveur : <?= $_SERVER['SERVER_SOFTWARE'] ?? 'Inconnu' ?></div>
<div class="info">Date : <?= date('d/m/Y H:i:s') ?></div>

<h2>2. Connexion MySQL</h2>
<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=koo_2_fourchette;charset=utf8","root","",
        [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
    echo '<div class="ok">✅ Connexion réussie à <strong>koo_2_fourchette</strong> !</div>';

    echo '<h2>3. Tables</h2><ul>';
    foreach($pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN) as $t) echo "<li><b>$t</b></li>";
    echo '</ul>';

    $nbM = $pdo->query("SELECT COUNT(*) FROM membres")->fetchColumn();
    echo "<h2>4. Membres ($nbM)</h2>";
    echo '<table><tr><th>ID</th><th>Login</th><th>Prénom</th><th>Nom</th><th>Avatar</th></tr>';
    foreach($pdo->query("SELECT * FROM membres ORDER BY idMembre")->fetchAll() as $m) {
        echo "<tr><td>{$m['idMembre']}</td><td><b>{$m['login']}</b></td><td>{$m['prenom']}</td><td>{$m['nom']}</td>
              <td><img src='photos/{$m['gravatar']}' style='height:35px;border-radius:50%;' onerror=\"this.style.display='none'\"> {$m['gravatar']}</td></tr>";
    }
    echo '</table>';

    $nbR = $pdo->query("SELECT COUNT(*) FROM recettes")->fetchColumn();
    echo "<h2>5. Recettes ($nbR)</h2>";
    echo '<table><tr><th>ID</th><th>Titre</th><th>Auteur</th><th>Photo</th><th>Couleur</th></tr>';
    foreach($pdo->query("SELECT r.*,m.login FROM recettes r JOIN membres m ON r.membre=m.idMembre ORDER BY r.dateCrea DESC")->fetchAll() as $r) {
        echo "<tr><td>{$r['idRecette']}</td><td><a href='recette.php?id={$r['idRecette']}'>"
            .htmlspecialchars($r['titre'])."</a></td><td>{$r['login']}</td>
              <td><img src='photos/{$r['img']}' style='height:40px;' onerror=\"this.style.display='none'\"> {$r['img']}</td>
              <td>{$r['couleur']}</td></tr>";
    }
    echo '</table>';

    echo '<h2>6. Test SHA1 (mot de passe "password")</h2>';
    $stmt = $pdo->prepare("SELECT login,prenom FROM membres WHERE password=? LIMIT 1");
    $stmt->execute([sha1('password')]);
    $u = $stmt->fetch();
    if($u) echo "<div class='ok'>✅ SHA1 OK — Login: <b>{$u['login']}</b> ({$u['prenom']}) — Mot de passe: <b>password</b></div>";
    else   echo "<div class='err'>❌ Aucun compte avec 'password'. Importez database_corrige.sql</div>";

} catch(PDOException $e) {
    echo '<div class="err">❌ Erreur MySQL : <b>'.$e->getMessage().'</b></div>';
    echo '<div class="info">Vérifiez : Apache + MySQL démarrés dans XAMPP, base <b>koo_2_fourchette</b> importée.</div>';
}
?>

<h2>7. Extensions PHP</h2>
<?php foreach(['pdo','pdo_mysql','mbstring'] as $ext): ?>
  <div class="<?= extension_loaded($ext)?'ok':'err' ?>">
    <?= extension_loaded($ext)?'✅':'❌' ?> <b><?= $ext ?></b>
  </div>
<?php endforeach; ?>

<h2>8. Images</h2>
<?php foreach(['images/koo_2_fourchette.png','images/facebook.png','images/twitter.png','images/google.png','images/youtube.png','images/temps.png','images/cuisson.png','images/fourchette.png','images/prix.png'] as $img): ?>
  <div class="<?= file_exists($img)?'ok':'err' ?>">
    <?= file_exists($img)?'✅':'❌' ?> <b><?= $img ?></b>
    <?php if(file_exists($img)): ?><img src="<?= $img ?>" style="height:22px;vertical-align:middle;margin-left:8px;"><?php endif; ?>
  </div>
<?php endforeach; ?>

<br><a href="index.php" style="color:#c0006e;font-weight:700;">← Retour à l'accueil</a>
</body>
</html>