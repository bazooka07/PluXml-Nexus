<div class="content">
    <div class="page">
        <h2><?= $h2 ?></h2>
        <p><a href="<?= $routerService->urlFor('backoffice') ?>">Backoffice</a>&nbsp;/&nbsp;Plugins</p>
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

        <a href="<?= $routerService->urlFor('boaddplugin') ?>"><button>Add a plugin</button></a>

        <div class="scrollable-table">
            <?php if (!empty($plugins)): ?>
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
                    <?php foreach ($plugins as $key => $plugin): ?>
                        <tr>
                            <td>
                                <a href="<?= $routerService->urlFor('plugin', ['name' => $plugin['name']]) ?>"><?= $plugin['name'] ?></a>
                            </td>
                            <td><?= $plugin['description'] ?></td>
                            <td><?= $plugin['versionPlugin'] ?></td>
                            <td><?= $plugin['versionPluxml'] ?></td>
                            <td><a href="<?= $plugin['link'] ?>"><?= $plugin['link'] ?></a></td>
                            <td>
                                <a href="<?= $routerService->urlFor('boeditplugin', ['name' => $plugin['name']]) ?>"><i
                                            class="icon-pencil"></i></a>
                                <a href="<?= $plugin['file'] ?>"><i class="icon-download"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No plugins to edit</p>
            <?php endif; ?>
        </div>
    </div>
</div>
