<div class="content">
    <?php require_once 'tags/tabs.php' ?>
    <ul class="menu breadcrumb">
<?php if (!empty($frombackoffice)) :?>
        <li><a href="<?= $routerService->urlFor('backoffice') ?>"><?= _['BACKOFFICE'] ?></a></li>
        <li><a href="<?= $routerService->urlFor('bousers') ?>"><?= _['USERS'] ?></a></li>
<?php else : ?>
        <li><a href="<?= $routerService->urlFor('profiles') ?>"><?= _['CONTRIBUTORS'] ?></a></li>
<?php endif; ?>
        <li class="profile">
            <?= $username ?>
<?php if (!empty($website)): ?>
           ( <a href="<?= $website ?>" target="_blank"><em><?= $website ?></em></a> )
<?php endif; ?>
        </li>
    </ul>
<?php if (!empty($plugins)): ?>
    <div class="grid">
        <h3><?= _['PLUGINS'] ?></h3>
<?php include 'tags/pluginsList.php'; ?>
    </div>
<?php endif; ?>
<?php if (!empty($themes)): ?>
    <div class="grid">
        <h3><?= _['THEMES'] ?></h3>
<?php include 'tags/themesList.php'; ?>
    </div>
<?php endif; ?>
</div>