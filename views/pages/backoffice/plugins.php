<div class="content ressource">
    <div class="page">
        <ul class="menu breadcrumb">
            <li><a href="<?= $routerService->urlFor('backoffice') ?>"><?= $h2 ?></a></li>
            <li><?= _['PLUGINS'] ?></li>
        </ul>
        <div class="grid">
            <div class="col med-8">
                <h3><?= $h3 ?></h3>
            </div>
            <div class="col med-2 med-offset-2">
                <a href="<?= $routerService->urlFor('boaddplugin') ?>"><button><?= _['ADD_PLUGIN'] ?></button></a>
            </div>
        </div>
<?php include 'flash.php' ?>
<?php if (!empty($plugins)): ?>
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
<?php foreach ($plugins as $key => $plugin): ?>
                    <tr>
			<td><a href="<?= $routerService->urlFor('plugin', $plugin) ?>"><?= $plugin['name'] ?></a></td>
                        <td><?= $plugin['description'] ?></td>
                        <td><?= $plugin['version'] ?></td>
                        <td><?= $plugin['pluxml'] ?></td>
                        <td><a href="<?= $plugin['link'] ?>" target="_blank"><?= $plugin['link'] ?></a></td>
                        <td>
                            <a href="<?= $routerService->urlFor('boeditplugin', $plugin) ?>" title="<?= _['EDIT'] ?>"><i
                                        class="icon-pencil"></i></a>
                            <a href="<?= $plugin['file'] ?>" title="<?= _['DOWNLOAD'] ?>" download><i class="icon-download"></i></a>
                        </td>
                    </tr>
<?php endforeach; ?>
                </tbody>
            </table>
        </div>
<?php else: ?>
        <p><?= _['NO_PLUGIN_EDIT'] ?></p>
<?php endif; ?>
    </div>
</div>
