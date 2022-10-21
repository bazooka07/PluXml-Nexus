<div class="content">
    <div class="page">
        <h2><?= $h2 ?></h2>
        <p>Hello <?= $_SESSION['user'] ?> !</p>

        <?php if (isset($flash['success'])): ?>
            <div class="alert green">
                <?= $flash['success'][0] ?>
            </div>
        <?php elseif (isset($flash['error'])): ?>
            <div class="alert red">
                <?= $flash['error'][0] ?>
            </div>
        <?php endif; ?>

        <div class="grid">
            <div class="col sml-12 med-3 panel text-center">
                <a href="<?= $routerService->urlFor('boplugins') ?>">
                    <div class="panel-content">
                        <img src="/img/favicon/favicon-32x32.png" alt="add or edit a plugin picto"/>
                        <h3 class="no-margin h4">Plugins</h3>
                        <p>Add or edit a plugin</p>
                    </div>
                </a>
            </div>
            <div class="col sml-12 med-3 panel text-center">
                <a href="<?= $routerService->urlFor('bothemes') ?>">
                    <div class="panel-content">
                        <img src="/img/favicon/favicon-32x32.png" alt="add or edit a theme picto"/>
                        <h3 class="no-margin h4">Themes</h3>
                        <p>Add or edit a theme</p>
                    </div>
                </a>
            </div>
            <div class="col sml-12 med-3 panel text-center">
                <a href="<?= $routerService->urlFor('boeditprofile') ?>">
                    <div class="panel-content">
                        <img src="/img/favicon/favicon-32x32.png" alt="edit your profile picto"/>
                        <h3 class="no-margin h4">My profile</h3>
                        <p>Edit my profile</p>
                    </div>
                </a>
            </div>
            <?php if ($adminUser): ?>
            <div class="col sml-12 med-3 panel text-center">
                <a href="<?= $routerService->urlFor('bousers') ?>">
                    <div class="panel-content">
                        <img src="/img/favicon/favicon-32x32.png" alt="registred users"/>
                        <h3 class="no-margin h4">Users</h3>
                        <p>Display registred users</p>
                    </div>
                </a>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
