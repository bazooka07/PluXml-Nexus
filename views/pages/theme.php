<div class="content">
<h2><?= _['THEME'] ?> <?= $item['name'] ?></h1>
	<div class="page">
		<!-- p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin et leo
et ex congue blandit. Sed vel eleifend lorem. Proin laoreet commodo
libero non dictum. Vestibulum at bibendum nunc, a ullamcorper turpis.
Vestibulum sed libero lacus. Nulla urna lectus, viverra id arcu ac,
tempus aliquet elit. Donec aliquam et nisl eu rhoncus. Maecenas semper
urna mauris, a aliquam orci sagittis vel. Cras neque neque, porta a
sagittis ac, sodales id nisl. Interdum et malesuada fames ac ante ipsum
primis in faucibus. Pellentesque habitant morbi tristique senectus et
netus et malesuada fames ac turpis egestas. Nunc in erat augue.
Vestibulum a ipsum eu massa finibus fringilla.</p -->
        <p>
            <i class="icon-user"></i>
            <em><a href="<?= $routerService->urlFor('profile', ['username' => $item['author']]) ?>" class="icon-user"><?= $item['username'] ?></a></em>
            <i class="icon-link-1"></i>
            <em><a href="<?= $item['link'] ?>"><?= $item['link'] ?></a></em>
        </p>
		<img src="<?= $item['media'] ?>" />
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
