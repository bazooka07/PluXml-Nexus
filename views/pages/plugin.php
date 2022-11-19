<div class="content">
    <?php require_once 'tags/tabs.php' ?>

    <div class="page">
        <h2>Plugin <?= $plugin['name'] ?></h2>
        <p>
            <i class="icon-user"></i>
            <em><a href="<?= $routerService->urlFor('profile', ['username' => $plugin['author']]) ?>"><?= $plugin['username'] ?></a></em>
            <i class="icon-link-1"></i>
            <em><a href="<?= $plugin['link'] ?>"><?= $plugin['link'] ?></a></em>
            <i class="<?= $plugin['categoryIcon'] ?>"></i>
            <em><a href="<?= $routerService->urlFor('category', ['name' => $plugin['categoryName']]) ?>"><?= $plugin['categoryName'] ?></a></em>
        </p>
        <p><?= $plugin['description'] ?></p>
        <ul class="unstyled-list">
            <li><i class="icon-tag"></i>Version : <?= $plugin['version'] ?></li>
            <li><i class="icon-leaf"></i>PluXml version required : <?= $plugin['pluxml'] ?></li>
        </ul>
        <a href=" <?= $plugin['file'] ?>">
            <button><i class="icon-download"></i>Download</button>
        </a>
    </div>
</div>
