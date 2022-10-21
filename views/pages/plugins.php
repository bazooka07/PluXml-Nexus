<div class="content">
    <?php require_once 'tags/tabs.php' ?>

    <div class="page grid">
        <?php include 'tags/pluginsCategories.php'; ?>
        <?php if (!empty($plugins)): ?>
            <?php include 'tags/pluginsList.php'; ?>
        <?php else: ?>
            <div class="alert orange">No plugins found</div>
        <?php endif; ?>
    </div>
</div>
