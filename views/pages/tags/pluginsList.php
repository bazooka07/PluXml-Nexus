<?php foreach ($plugins as $item): ?>
    <div class="col sml-12 med-3 panel item">
        <div class="panel-content">
            <a class="ressource" href="<?= $routerService->urlFor('plugin', $item) ?>">
                <span class="panel-header text-center">
<?php if (!empty($item['media'])) : ?>
                <img src="<?= $item['media'] ?>" />
<?php else : ?>
                    <i class="<?= $item['categoryIcon'] ?>"></i>
<?php endif; ?>
                </span>
                <strong><?= $item['name'] ?></strong>
            </a>
            <ul class="unstyled-list">
                <li><?= $item['description'] ?></li>
                <li><i class="icon-user"></i><em><a href="<?= $routerService->urlFor('profile', $item) ?>"><?= $item['username'] ?></a></em></li>
                <li><i class="icon-tag"></i>Date : <?= $item['date'] ?></li>
<?php if(!empty($item['version'])) : ?>
                <li><i class="icon-tag"></i>Version : <?= $item['version'] ?></li>
<?php endif; ?>
<?php if(!empty($item['pluxml'])) : ?>
                <li><i class="icon-leaf"></i>PluXml version <?= $item['pluxml'] ?></li>
<?php endif; ?>
            </ul>
            <a href=" <?= $item['file'] ?>" download>
                <button><i class="icon-download"></i><?= _['DOWNLOAD'] ?></button>
            </a>
        </div>
    </div>
<?php endforeach; ?>
