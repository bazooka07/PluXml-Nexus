<div class="content">
    <div class="page">
        <ul class="menu breadcrumb">
            <li><a href="<?= $routerService->urlFor('backoffice') ?>"><?= $h2 ?></a></li>
            <li><?= $h3 ?></li>
        </ul>
        <h3><?= $h3 ?></h3>
<?php include 'flash.php' ?>
        <p><a href="<?= $routerService->urlFor('boaddtheme') ?>" class="button blue"><?= _['ADD_THEME'] ?></a></p>

<?php if (!empty($themes)): ?>
        <div class="scrollable-table">
            <table>
                <thead>
                <tr>
                    <th><?= _['NAME'] ?></th>
                    <th><?= _['DESCRIPTION'] ?></th>
                    <th><?= _['VERSION'] ?></th>
                    <th><?= _['PLUXML'] ?></th>
                    <th><?= _['WEBSITE'] ?></th>
                    <th><?= _['ACTION'] ?></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($themes as $key => $theme): ?>
                    <tr>
                        <td>
                            <a href="<?= $routerService->urlFor('theme', ['name' => $theme['name']]) ?>"><?= $theme['name'] ?></a>
                        </td>
                        <td><?= $theme['description'] ?></td>
                        <td><?= $theme['version'] ?></td>
                        <td><?= $theme['pluxml'] ?></td>
                        <td><a href="<?= $theme['link'] ?>"><?= $theme['link'] ?></a></td>
                        <td>
                            <a href="<?= $routerService->urlFor('boedittheme', ['name' => $theme['name']]) ?>" title="<?= _['EDIT'] ?>"><i
                                        class="icon-pencil"></i></a>
                            <a href="<?= $theme['file'] ?>" title="<?= _['DOWNLOAD'] ?>" download><i class="icon-download"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
<?php else: ?>
        <p><?= _['NO_THEME_EDIT'] ?></p>
<?php endif; ?>
    </div>
</div>
