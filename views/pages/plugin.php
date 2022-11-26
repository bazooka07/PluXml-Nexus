<div class="content">
<?php require_once 'tags/tabs.php' ?>
    <div class="page">
	<h2><?= _['PLUGIN'] ?> <?= $item['name'] ?></h2>
        <p>
            <em><a href="<?= $routerService->urlFor('profile', ['username' => $item['author']]) ?>" class="icon-user"><?= $item['username'] ?></a></em>
            <em><a href="<?= $item['link'] ?>" class="icon-link-1"><?= $item['link'] ?></a></em>
            <em><a href="<?= $routerService->urlFor('category', ['name' => $item['categoryName']]) ?>" class="<?= $item['categoryIcon'] ?>"><?= $item['categoryName'] ?></a></em>
        </p>
        <p><?= $item['description'] ?></p>
        <ul class="unstyled-list">
<?php foreach(array('tag' => 'version', 'leaf' => 'pluxml',) as $icon=>$field) {
	if(!empty($item[$field])) {
?>
	    <li><i class="icon-<?= $icon ?>"></i><?= _[strtoupper($field)] ?> : <?= $item[$field] ?></li>
<?php
	}
}
?>
        </ul>
<div>
        <a href=" <?= $item['file'] ?>">
            <button><i class="icon-download"></i>Download</button>
        </a>
</div>
    </div>
</div>
