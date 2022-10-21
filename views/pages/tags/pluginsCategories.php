<div class="text-center">
    <h2 class="h3">Categories</h2>
    <ul class="inline-list categories">
        <li class="tab <?= !isset($category) ? 'activeTab' : '' ?>"><a href="<?= $routerService->urlFor('plugins') ?>">All</a></li>
<?php foreach ($categories as $value): ?>
        <li class="tab <?= (isset($category) and $value['name'] == $category) ? 'activeTab' : '' ?>">
            <a href="<?= $routerService->urlFor('category', ['name' => $value['name']]) ?>"><?= $value['name'] ?></a>
        </li>
<?php endforeach; ?>
    </ul>
</div>
