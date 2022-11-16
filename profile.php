<?php
require_once __DIR__ . '/database/database.php';
$authDB = require_once __DIR__ . '/database/security.php';
$articleDB = require_once __DIR__ . '/database/models/ArticleDB.php';
$commentDB = require_once __DIR__ . '/database/models/CommentsDB.php';

$articles = [];
$comments = [];
$currentUser = $authDB->isLoggedin();

if (!$currentUser) {
  header('Location: /');
  exit;
}

$articles = $articleDB->fetchUserArticle($currentUser['id']);
$comments = $commentDB->fetchUserComments($currentUser['id']);


?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <?php require_once 'includes/head.php' ?>
  <link rel="stylesheet" href="/public/css/profile.css">
  <title>Mon profil</title>
</head>

<body>
  <div class="container">
    <?php require_once 'includes/header.php' ?>
    <div class="content">
      <h1>Mon espace</h1>
      <h2>Mes informations</h2>
      <div class="info-container">
        <ul>
          <li>
            <strong>Prénom :</strong>
            <p><?= $currentUser['firstname'] ?></p>
          </li>
          <li>
            <strong>Nom :</strong>
            <p><?= $currentUser['lastname'] ?></p>
          </li>
          <li>
            <strong>Email :</strong>
            <p><?= $currentUser['email'] ?></p>
          </li>
        </ul>
      </div>
      <h2>Mes articles</h2>
    <?php if ($currentUser['status'] === 'admin') : ?>
      <div class="articles-list">
        <ul>
          <?php foreach ($articles as $a) : ?>
            <li>
              <span><?= $a['title'] ?></span>
              <div class="article-actions">
                <a href="/delete-article.php?id=<?= $a['id'] ?>" class="btn btn-primary btn-small">Supprimer</a>
                <a href="/form-article.php?id=<?= $a['id'] ?>" class="btn btn-secondary btn-small">Modifier</a>
              </div>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
  <?php else : ?>
      <p>Vous devez être administrateur pour pouvoir écrire des articles.</p>
   <?php endif; ?>
   <h2>Mes Commentaires</h2>
      <div class="articles-list">
        <ul>
          <?php foreach ($comments as $c) : ?>
            <li>
              <span><?= $c['content'] ?></span>
              <div class="article-actions">
                <a href="/delete-article.php?id=<?= $c['id'] ?>" class="btn btn-primary btn-small">Supprimer</a>
                <a href="/form-comments.php?id=<?= $c['id'] ?>" class="btn btn-secondary btn-small">Modifier</a>
              </div>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>
    <?php require_once 'includes/footer.php' ?>
  </div>

</body>

</html>