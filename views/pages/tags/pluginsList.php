<?php foreach ($plugins as $plugin): ?>
    <div class="col sml-12 med-3 panel plugin">
        <a href="<?= $routerService->urlFor('plugin', ['name' => $plugin['name']]) ?>">
            <div class="panel-content">
                <span class="panel-header text-center">
<?php if (!empty($plugin['media'])) : ?>
                    <img src="<?= $plugin['media'] ?>" />
<?php else : ?>
                    <i class="<?= $plugin['categoryIcon'] ?>"></i>
<?php endif; ?>
                </span>
                <strong><?= $plugin['name'] ?></strong>
                <ul class="unstyled-list">
                    <li><?= $plugin['description'] ?></li>
                    <li><i class="icon-user"></i><em><a
                                href="<?= $routerService->urlFor('profile', ['username' => $plugin['author']]) ?>"><?= $plugin['author'] ?></a></em>
                    </li>
                    <li><i class="icon-tag"></i>Version : <?= $plugin['version'] ?></li>
                    <li><i class="icon-leaf"></i>PluXml version <?= $plugin['pluxml'] ?></li>
                </ul>
                <a href=" <?= $plugin['file'] ?>">
                    <button><i class="icon-download"></i>Download</button>
                </a>
            </div>
        </a>
    </div>
<?php endforeach; ?>
