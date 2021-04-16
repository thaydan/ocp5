<!doctype html>
<html lang="fr">
<head>
  <?php require('Components/Head.php'); ?>
  <title><?= $head_title ?></title>
  <script src="https://www.google.com/recaptcha/api.js"></script>
</head>
<body>
  <?php require('Components/Header.php'); ?>
  <div id="b">
    <?= $template_content ?>
  </div>
  <?php require('Components/Footer.php'); ?>
</body>
</html>