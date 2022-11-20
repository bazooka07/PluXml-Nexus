<div class="content <?= $ressource ?>">
    <div class="page">
        <ul class="menu breadcrumb">
            <li><a href="<?= $routerService->urlFor('backoffice') ?>"><?= $h2 ?></a></li>
            <li><?= _[strtoupper($ressource . 's')] ?></li>
        </ul>
        <div class="grid">
            <div class="col med-8">
                <h3><?= $h3 ?></h3>
            </div>
            <div class="col med-2 med-offset-2">
                <a href="<?= $routerService->urlFor('boadd' . $ressource) ?>"><button><?= _['ADD_' . strtoupper($ressource)] ?></button></a>
            </div>
        </div>
<?php include 'flash.php' ?>
<?php if (!empty($items)): ?>
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
<?php foreach ($items as $key => $item): ?>
                    <tr>
                       <td><a href="<?= $routerService->urlFor($ressource, $item) ?>"><?= $item['name'] ?></a></td>
                        <td><?= $item['description'] ?></td>
                        <td><?= $item['version'] ?></td>
                        <td><?= $item['pluxml'] ?></td>
                        <td><a href="<?= $item['link'] ?>" target="_blank"><?= $item['link'] ?></a></td>
                        <td>
                            <a href="<?= $routerService->urlFor('boedit' . $ressource, $item) ?>" title="<?= _['EDIT'] ?>"><i class="icon-pencil"></i></a>
                            <a href="<?= $item['file'] ?>" title="<?= _['DOWNLOAD'] ?>" download><i class="icon-download"></i></a>
                        </td>
                    </tr>
<?php endforeach; ?>
                </tbody>
            </table>
        </div>
<?php else: ?>
        <p><?= _['NO_' . strtoupper($ressource) . '_EDIT'] ?></p>
<?php endif; ?>
    </div>
</div>
