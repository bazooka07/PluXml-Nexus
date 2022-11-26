<?php
if(empty($plugins)) {
?>
    <div class="alert orange">No plugins found</div>
<?php
} else {
    include 'pluginsCategories.php';
?>
    <div id="plugins-list" class="page grid">
<?php
foreach ($plugins as $item) {
?>
    <div class="col sml-12 med-3 panel item">
        <div class="panel-content">
            <div class="panel-header text-center">
<?php
    if (!empty($item['media'])) {
        $imgSize = getimagesize(PUBLIC_DIR . $item['media']);
?>
            <img src="<?= $item['media'] ?>" <?= $imgSize[3] ?> />
<?php
    } else {
?>
            <i class="<?= $item['categoryIcon'] ?>"></i>
<?php
    }
?>
            </div>
            <strong><?= $item['name'] ?></strong>
            <ul class="unstyled-list">
                <li class="description"><?= $item['description'] ?></li>
                <li class="author"><i class="icon-user"></i><?= _['AUTHOR'] ?> : <em><a href="<?= $routerService->urlFor('profile', $item) ?>"><?= $item['username'] ?></a></em></li>
<?php
    if(!empty($item['link'])) {
?>
                <li class="link"><i class="icon-link-1"></i><?= _['LINK'] ?> : <a href="<?= $item['link'] ?>" target="_blank"><?= $item['link'] ?></a></li>
<?php
        }
?>
<?php
    foreach(array(
        'tag'   => 'date',
        'tag' => 'version',
        'leaf' => 'pluxml',
    ) as $icon=>$field) {
        if(!empty($item[$field])) {
?>
                <li class="<?= $field ?>"><i class="icon-<?= $icon ?>"></i><?= _[strtoupper($field)] ?> : <?= $item[$field] ?></li>
<?php
        }
    }
?>
            </ul>
            <div class="text-center">
<?php if(!empty($item['file'])): ?>
                <a href=" <?= $item['file'] ?>" download>
                    <button><i class="icon-download"></i><?= _['DOWNLOAD'] ?></button>
                </a>
<?php else: ?>
                <button disabled><?= _['UNAVAILABLE'] ?></button>
<?php endif; ?>
            </div>
        </div>
    </div>
<?php
}
?>
    </div>
<?php
}
