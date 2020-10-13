<div class="content">
    <?php require_once 'tags/tabs.php' ?>

    <div class="page grid">
        <? foreach ($plugins as $key => $plugin): ?>
            <div class="col sml-12 med-3 panel">
                <a href="<?= $routerService->urlFor('plugin', ['name' => $plugin['name']]) ?>">
                    <div class="panel-content">
                        <span class="panel-header text-center"><i class="icon-leaf"></i></span>
                        <strong><?= $plugin['name'] ?></strong>
                        <ul class="unstyled-list">
                            <li><i class="icon-user"></i><em><a href="<?= $routerService->urlFor('profile', ['username' => $plugin['author']]) ?>"><?= $plugin['author'] ?></a></em></li>
                            <li><i class="icon-tag"></i>Version : <?= $plugin['versionPlugin'] ?></li>
                            <li><i class="icon-leaf"></i>PluXml version <?= $plugin['versionPluxml'] ?></li>
                        </ul>
                        <a href=" <?= $plugin['file'] ?>">
                            <button><i class="icon-download"></i>Download</button>
                        </a>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>