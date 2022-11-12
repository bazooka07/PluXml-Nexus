<div class="content">
    <div class="page">
        <h2><?= $h2 ?></h2>
        <ul class="menu breadcrumb">
            <li><a href="<?= $routerService->urlFor('backoffice') ?>">Backoffice</a></li>
            <li>New theme</li>
        </ul>
        <h3><?= $h3 ?></h3>
<?php include 'flash.php'; ?>
        <div class="alert blue">
            <small>
                <strong>Warning</strong>
                <ul>
                    <li>The theme name must be unique by user</li>
                    <li>The uploaded file must be a "zip" archive</li>
                    <li>The uploaded file will be renamed with the theme name</li>
                </ul>
            </small>
        </div>

        <form action="<?= $routerService->urlFor('themeSaveAction') ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="<?= $csrf['nameKey'] ?>" value="<?= $csrf['name'] ?>">
            <input type="hidden" name="<?= $csrf['valueKey'] ?>" value="<?= $csrf['value'] ?>">
            <input type="hidden" name="author" value="<?= $_SESSION['userid'] ?>">
            <div <?php if (isset($flash['name'][0]) or isset($flash['name'][0])): ?>style="color:red"<?php endif; ?>>
                <label for="name">Name*: </label>
                <input type="text" name="name" id="name"
                       <?php if (isset($formOldValues['name'])): ?>value="<?= $formOldValues['name'] ?>"<?php endif; ?>
                       required>
                <?php if (isset($flash['name'][0])): ?><p><?= $flash['name'][0] ?></p><?php endif; ?>
            </div>
            <div
                <?php if (isset($flash['description'][0]) or isset($flash['description'][0])): ?>style="color:red"<?php endif; ?>>
                <label for="description">Description: </label>
                <input type="text" name="description" id="description"
                       <?php if (isset($formOldValues['description'])): ?>value="<?= $formOldValues['description'] ?>"<?php endif; ?>>
                <?php if (isset($flash['description'][0])): ?><p><?= $flash['description'][0] ?></p><?php endif; ?>
            </div>
            <div <?php if (isset($flash['version'][0])): ?>style="color:red"<?php endif; ?>>
                <label for="version">Version: </label>
                <input type="text" name="version" id="version"
                       <?php if (isset($formOldValues['version'])): ?>value="<?= $formOldValues['version'] ?>"<?php endif; ?>>
                <?php if (isset($flash['version'][0])): ?><p><?= $flash['version'][0] ?></p><?php endif; ?>
            </div>
            <div <?php if (isset($flash['pluxml'][0])): ?>style="color:red"<?php endif; ?>>
                <label for="pluxml">PluXml version: </label>
                <input type="text" name="pluxml" id="pluxml"
                       <?php if (isset($formOldValues['pluxml'])): ?>value="<?= $formOldValues['pluxml'] ?>"<?php endif; ?>>
                <?php if (isset($flash['pluxml'][0])): ?><p><?= $flash['pluxml'][0] ?></p><?php endif; ?>
            </div>
            <div <?php if (isset($flash['link'][0])): ?>style="color:red"<?php endif; ?>>
                <label for="link">Link: </label>
                <input type="url" name="link" id="link"
                       <?php if (isset($formOldValues['link'])): ?>value="<?= $formOldValues['link'] ?>"<?php endif; ?>>
                <?php if (isset($flash['link'][0])): ?><p><?= $flash['link'][0] ?></p><?php endif; ?>
            </div>
            <div <?php if (isset($flash['file'][0])): ?>style="color:red"<?php endif; ?>>
                <label for="file">File*: </label>
                <input type="file" name="file" id="file" required>
                <?php if (isset($flash['file'][0])): ?><p><?= $flash['file'][0] ?></p><?php endif; ?>
            </div>
            <button type="submit"><i class="icon-floppy"></i>Save</button>
        </form>
    </div>
</div>
