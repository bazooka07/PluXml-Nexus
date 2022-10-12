<!doctype html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
<!--[if IE]>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
<![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
<?php
const ICON_URL_BASE = 'https://medias.pluxml.org/favicon/purple/';

foreach([ 57, 60, 72, 76, 114, 120, 144, 152, 180, ] as $size) {
?>
    <link rel="apple-touch-icon" href="<?= ICON_URL_BASE?>apple-icon-<?= $size ?>x<?= $size ?>.png" sizes="<?= $size ?>x<?= $size ?>">
<?php
}
?>
<?php
foreach([ 16, 32, 96, ] as $size) {
?>
    <link rel="icon" href="<?= ICON_URL_BASE ?>favicon-<?= $size ?>x<?= $size ?>.png" sizes="<?= $size ?>x<?= $size ?>" type="image/png">
<?php
}
?>
    <link rel="icon" type="image/png" sizes="192x192" href="<?= ICON_URL_BASE ?>android-icon-192x192.png">
    <link rel="manifest" href="<?= ICON_URL_BASE ?>manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?= ICON_URL_BASE ?>ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" href="https://www.pluxml.org/assets/plucss-min.css">
    <link rel="stylesheet" href="https://www.pluxml.org/assets/plx-common-min.css">
    <link rel="stylesheet" href="/css/styles.css">
    <link rel="stylesheet" href="/css/fontello/css/fontello.css">
</head>

<body>

<div id="plxnav" data-title="Ressources" data-logo="purple" data-link="nexus"></div>

<header class="header" role="banner">
    <div class="container">
        <div class="grid">
            <div class="col sml-12 med-8">
                <nav class="nav" role="navigation">
                    <ul class="inline-list">
                        <li><a href="<?= $routerService->urlFor('homepage') ?>"><h1>Ressources</h1></a></li>
                        <li><a href="<?= $routerService->urlFor('profiles') ?>">Contributors</a></li>
                    </ul>
                </nav>
            </div>

            <div class="col sml-12 med-4">
                <nav class="nav text-right" role="navigation">
                    <ul class="inline-list">
                        <?php if (!$isLogged): ?>
                            <li><a href="<?= $routerService->urlFor('signup') ?>">Sign up</a></li>
                            <li><a href="<?= $routerService->urlFor('auth') ?>">Log in</a></li>
                        <?php else: ?>
                            <li><a href="<?= $routerService->urlFor('backoffice') ?>"><?= $_SESSION['user'] ?></a></li>
                            <li><a href="<?= $routerService->urlFor('logoutAction') ?>">Log out</a></li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</header>

<main id="main" role="main" class="main">
    <div class="container">
        <?= $content ?>
    </div>
</main>

<footer>
    PluXml - Blog ou Cms à l'Xml !
    <!-- script src="https://medias.pluxml.org/navigation/nav.js"></script -->
</footer>

</body>

</html>
