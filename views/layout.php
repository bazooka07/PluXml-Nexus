<!doctype html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
<!--[if IE]>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
<![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="apple-touch-icon" sizes="57x57"
          href="https://medias.pluxml.org/favicon/purple/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60"
          href="https://medias.pluxml.org/favicon/purple/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72"
          href="https://medias.pluxml.org/favicon/purple/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76"
          href="https://medias.pluxml.org/favicon/purple/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114"
          href="https://medias.pluxml.org/favicon/purple/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120"
          href="https://medias.pluxml.org/favicon/purple/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144"
          href="https://medias.pluxml.org/favicon/purple/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152"
          href="https://medias.pluxml.org/favicon/purple/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180"
          href="https://medias.pluxml.org/favicon/purple/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"
          href="https://medias.pluxml.org/favicon/purple/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32"
          href="https://medias.pluxml.org/favicon/purple/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96"
          href="https://medias.pluxml.org/favicon/purple/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16"
          href="https://medias.pluxml.org/favicon/purple/favicon-16x16.png">
    <link rel="manifest" href="https://medias.pluxml.org/favicon/purple/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage"
          content="https://medias.pluxml.org/favicon/purple/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <link href="https://www.pluxml.org/assets/plucss-min.css"
          rel="stylesheet">
    <link href="https://www.pluxml.org/assets/plx-common-min.css"
          rel="stylesheet">
    <link href="/css/styles.css" rel="stylesheet">
    <link href="/css/fontello/css/fontello.css" rel="stylesheet">
</head>

<body>

<div id="plxnav" data-title="Ressources" data-logo="purple" data-link="nexus" style="height: 43px; background-color: #333; border-bottom: 2px solid #cdcdcd;"></div>

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
