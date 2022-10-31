<div class="content">
    <?php require_once 'tags/tabs.php' ?>
    <div>
        <h2><?= $username ?></h2>
<?php if (!empty($website)): ?>
        <div>
           Website: <a href="<?= $website ?>" target="_blank"><?= $website ?></a></li>
        </div>
<?php endif; ?>
    </div>
<?php if (!empty($plugins)): ?>
    <div class="grid">
        <h3>Plugins:</h3>
<?php include 'tags/pluginsList.php'; ?>
    </div>
<?php endif; ?>
<?php if (!empty($themes)): ?>
    <div class="grid">
        <h3>Themes:</h3>
<?php include 'tags/themesList.php'; ?>
    </div>
<?php endif; ?>
</div>