<div class="content">
    <?php require_once 'tags/tabs.php' ?>

    <div class="">
        <h2><?= $username ?></h2>
        <ul>
            <li>
                Website: <a href="<?= $website ?>" target="_blank"><?= $website ?></a></li>
            </li>
        </ul>
    </div>
    <div class="grid">
        <h3>Plugins:</h3>
            <?php if (!empty($plugins)): ?>
                <?php include 'tags/pluginsList.php'; ?>
            <?php else: ?>
                <div class="alert orange">No plugins found</div>
            <?php endif; ?>
    </div>

    <div class="grid">
        <h3>Themes:</h3>
            <?php if (!empty($themes)): ?>
                <?php include 'tags/themesList.php'; ?>
            <?php else: ?>
                <div class="alert orange">No themes found</div>
            <?php endif; ?>
        </div>
    </div>
</div>