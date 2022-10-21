<?php foreach ($themes as $theme): ?>
    <div class="col sml-12 med-3 panel">
        <a href="<?= $routerService->urlFor('theme', ['name' => $theme['name']]) ?>">
            <div class="panel-content">
                <strong><?= $theme['name'] ?></strong>
                <ul class="unstyled-list">
                    <li><i class="icon-user"></i><em><a
                                href="<?= $routerService->urlFor('profile', ['username' => $theme['author']]) ?>"><?= $theme['author'] ?></a></em>
                    </li>
                    <li><i class="icon-tag"></i>Version : <?= $theme['versionTheme'] ?></li>
                    <li><i class="icon-leaf"></i>PluXml version <?= $theme['versionPluxml'] ?></li>
                </ul>
                <a href=" <?= $theme['file'] ?>">
                    <button><i class="icon-download"></i>Download</button>
                </a>
            </div>
        </a>
    </div>
<?php endforeach; ?>
