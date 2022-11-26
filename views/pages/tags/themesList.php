<?php
if (empty($themes)) {
?>
	<div class="alert orange">No themes found</div>
<?php
} else {
?>
    <div id="themes-list" class="page grid">
<?php
foreach ($themes as $item) {
    $src = !empty($item['media']) ? $item['media'] : '/img/theme.png';
    $preview = !empty($item['media']) ?'preview' : '';
    $imgSrc = getimagesize(PUBLIC_DIR . $src);
?>
    <div class="col sml-12 med-3 panel item">
        <div class="panel-content">
            <div class="panel-header <?= $preview ?> text-center">
                <img src="<?= $src ?>" <?= $imgSrc[3] ?> />
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
<?php if(!empty($item['file'])) { ?>
                <a href=" <?= $item['file'] ?>" download>
                    <button><i class="icon-download"></i><?= _['DOWNLOAD'] ?></button>
                </a>
<?php
        } else {
?>
                <button disabled><?= _['UNAVAILABLE'] ?></button>
<?php
        }
?>
            </div>
        </div>
    </div>
<?php
}
?>
    </div>
<?php
}
