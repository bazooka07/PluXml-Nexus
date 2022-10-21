<div class="grid">
<?php
foreach([
	'homepage' => ['PluXml', 1],
	'plugins'  => ['Plugins', 3],
	'themes'   => ['Themes', 2],
] as $url=>$infos) {
?>
    <div class="col sml-12 med-4">
        <div class="tab<?php if (isset($activeTab) and $infos[1] == $activeTab): ?> activeTab<?php endif; ?>">
            <a href="<?= $routerService->urlFor($url) ?>"><?= $infos[0] ?></a>
        </div>
    </div>
<?php
}
?>
</div>
