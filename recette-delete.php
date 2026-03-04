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

// Vérification que la recette existe et appartient au membre connecté
if (!$rec || $rec['membre'] != $_SESSION['membre']['idMembre']) {
    header('Location: recettes.php'); exit;
}

// Supprimer la photo si c'est une image uploadée (pas une image par défaut)
$imgDefaut = ['marmelade-carottes.jpg', 'default.jpg'];
if ($rec['img'] && !in_array($rec['img'], $imgDefaut) && file_exists("photos/" . $rec['img'])) {
    unlink("photos/" . $rec['img']);
}

$stmt = $db->prepare("DELETE FROM recettes WHERE idRecette = ?");
$stmt->execute([$id]);

header('Location: recettes.php');
exit;