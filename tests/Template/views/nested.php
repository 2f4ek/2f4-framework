<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'nested-title.php'; ?>
</head>
<body>
<?php include 'nested-header.php'; ?>
<h1><?= htmlspecialchars($heading, ENT_QUOTES, 'UTF-8') ?></h1>
<p><?= htmlspecialchars($content, ENT_QUOTES, 'UTF-8') ?></p>
<footer>Footer Content</footer>
<?php include 'nested-footer.php'; ?>
</html>