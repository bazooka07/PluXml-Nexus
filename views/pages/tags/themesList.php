<?php foreach ($themes as $i=>$theme): ?>
    <div class="col sml-12 med-3 panel theme">
        <div class="panel-content">
<?php if (!empty($theme['media'])) : ?>
            <input type="checkbox" id="media-<?= $i ?>"/>
            <div class="overlay">
                <label for="media-<?= $i ?>">
                    <img src="<?= $theme['media'] ?>" />
                </label>
            </div>
<?php endif; ?>
            <a href="<?= $routerService->urlFor('theme', ['name' => $theme['name']]) ?>">
                <button><?= $theme['name'] ?></button>
            </a>
            <ul class="unstyled-list">
<?php if(!isset($username)) : ?>
                <li><i class="icon-user"></i><em><a
                            href="<?= $routerService->urlFor('profile', ['username' => $theme['username']]) ?>"><?= $theme['username'] ?></a></em>
                </li>
<?php endif; ?>
                <li><i class="icon-tag"></i>Date : <?= $theme['date'] ?></li>
<?php if(!empty($theme['version'])) : ?>
                <li><i class="icon-tag"></i>Version : <?= $theme['version'] ?></li>
<?php endif; ?>
<?php if(!empty($theme['pluxml'])) : ?>
                <li><i class="icon-leaf"></i>PluXml version <?= $theme['pluxml'] ?></li>
<?php endif; ?>
            </ul>
            <a href=" <?= $theme['file'] ?>">
                <button><i class="icon-download"></i>Download</button>
            </a>
        </div>
    </div>
<?php endforeach; ?>
