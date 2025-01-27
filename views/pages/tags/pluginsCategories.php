<div class="text-center">
    <h2 class="h3"><?= _['CATEGORIES'] ?></h2>
    <ul class="inline-list categories">
<?php
if(count($categories) > 1) {
    $cntAll = array_reduce(
        $categories,
        function($carry, $item) {
            $carry += $item['cnt'];
            return $carry;
        }
    );
?>
        <li class="tab <?= !isset($category) ? 'activeTab' : '' ?>"><a href="<?= $routerService->urlFor('plugins') ?>"><?= _['ALL'] ?> (<?= $cntAll ?>)</a></li>
<?php
}

foreach ($categories as $value): ?>
        <li class="tab <?= (isset($category) and $value['name'] == $category) ? 'activeTab' : '' ?>">
            <a href="<?= $routerService->urlFor('category', ['name' => $value['name']]) ?>">
                <?= $value['name'] ?>
                <?php if (isset($value['cnt'])) : ?>
                (<?= $value['cnt'] ?>)
                <?php endif; ?>
            </a>
        </li>
<?php endforeach; ?>
    </ul>
</div>
