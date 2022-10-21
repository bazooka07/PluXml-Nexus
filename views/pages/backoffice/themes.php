<div class="content">
    <div class="page">
        <h2><?= $h2 ?></h2>
        <p><a href="<?= $routerService->urlFor('backoffice') ?>">Backoffice</a>&nbsp;/&nbsp;Themes</p>
        <h3><?= $h3 ?></h3>

        <?php if (isset($flash['success'])): ?>
            <div class="alert green">
                <?= $flash['success'][0] ?>
            </div>
        <?php elseif (isset($flash['error'])): ?>
            <div class="alert red">
                <?= $flash['error'][0] ?>
            </div>
        <?php endif; ?>

        <p><a href="<?= $routerService->urlFor('boaddtheme') ?>" class="button blue">Add a theme</a></p>

        <div class="scrollable-table">
            <?php if (!empty($themes)): ?>
                <table>
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Version</th>
                        <th>PluXml</th>
                        <th>Website</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($themes as $key => $theme): ?>
                        <tr>
                            <td>
                                <a href="<?= $routerService->urlFor('theme', ['name' => $theme['name']]) ?>"><?= $theme['name'] ?></a>
                            </td>
                            <td><?= $theme['description'] ?></td>
                            <td><?= $theme['versionTheme'] ?></td>
                            <td><?= $theme['versionPluxml'] ?></td>
                            <td><a href="<?= $theme['link'] ?>"><?= $theme['link'] ?></a></td>
                            <td>
                                <a href="<?= $routerService->urlFor('boedittheme', ['name' => $theme['name']]) ?>"><i
                                            class="icon-pencil"></i></a>
                                <a href="<?= $theme['file'] ?>"><i class="icon-download"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No themes to edit</p>
            <?php endif; ?>
        </div>
    </div>
</div>
