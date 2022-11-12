<div class="content">
    <div class="page">
        <h2><?= $h2 ?></h2>
        <p><?= _['HELLO'] ?> <?= $_SESSION['user'] ?> !</p>
<?php include 'flash.php'; ?>
        <div class="grid">
            <div class="col sml-12 med-3 panel text-center">
                <a href="<?= $routerService->urlFor('boplugins') ?>">
                    <div class="panel-content">
                        <img src="/img/favicon/favicon-32x32.png" alt="add or edit a plugin picto"/>
                        <h3 class="no-margin h4"><?= _['PLUGINS'] ?></h3>
                        <p><?= _['ADD_EDIT_PLUGIN'] ?></p>
                    </div>
                </a>
            </div>
            <div class="col sml-12 med-3 panel text-center">
                <a href="<?= $routerService->urlFor('bothemes') ?>">
                    <div class="panel-content">
                        <img src="/img/favicon/favicon-32x32.png" alt="add or edit a theme picto"/>
                        <h3 class="no-margin h4"><?= _['THEMES'] ?></h3>
                        <p><?= _['ADD_EDIT_THEME'] ?></p>
                    </div>
                </a>
            </div>
            <div class="col sml-12 med-3 panel text-center">
                <a href="<?= $routerService->urlFor('boeditprofile') ?>">
                    <div class="panel-content">
                        <img src="/img/favicon/favicon-32x32.png" alt="edit your profile picto"/>
                        <h3 class="no-margin h4"><?= _['MY_PROFILE'] ?></h3>
                        <p><?= _['EDIT_MY_PROFILE'] ?></p>
                    </div>
                </a>
            </div>
<?php if ($adminUser): ?>
            <div class="col sml-12 med-3 panel text-center">
                <a href="<?= $routerService->urlFor('bousers') ?>">
                    <div class="panel-content">
                        <img src="/img/favicon/favicon-32x32.png" alt="registred users"/>
                        <h3 class="no-margin h4"><?= _['USERS'] ?></h3>
                        <p><?= _['DISPLAY_REGISTERED_USERS'] ?></p>
                    </div>
                </a>
            </div>
<?php endif; ?>
        </div>
    </div>
</div>
