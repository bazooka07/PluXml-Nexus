<div class="content">
<?php require_once 'tags/tabs.php' ?>
    <div class="page">
        <h2><?= $h2 ?></h2>
        <ul>
<?php foreach ($profiles as $profile): ?>
            <li>
                <a href="<?= $routerService->urlFor('profile', ['username' => $profile['username']]) ?>"><?= $profile['username'] ?></a>
            </li>
<?php endforeach; ?>
        </ul>
    </div>
</div>