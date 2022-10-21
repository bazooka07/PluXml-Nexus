<div class="content">
    <div class="page">
        <h2><?= $h2 ?></h2>
        <p>
            <a href="<?= $routerService->urlFor('backoffice') ?>">Backoffice</a>&nbsp;/&nbsp;
            New theme
        </p>
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

        <div class="alert blue">
            <small>
                <strong>Warning</strong>
                <ul>
                    <li>The theme name must be unique</li>
                    <li>The uploaded file must be a "zip" archive</li>
                    <li>The uploaded file will be renamed with the theme name</li>
                </ul>
            </small>
        </div>

        <form action="<?= $routerService->urlFor('themeSaveAction') ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="<?= $csrf['nameKey'] ?>" value="<?= $csrf['name'] ?>">
            <input type="hidden" name="<?= $csrf['valueKey'] ?>" value="<?= $csrf['value'] ?>">
            <input type="hidden" name="author" value="<?= $_SESSION['user'] ?>">
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
            <div <?php if (isset($flash['versionTheme'][0])): ?>style="color:red"<?php endif; ?>>
                <label for="versionTheme">Version: </label>
                <input type="text" name="versionTheme" id="versionTheme"
                       <?php if (isset($formOldValues['versionTheme'])): ?>value="<?= $formOldValues['versionTheme'] ?>"<?php endif; ?>>
                <?php if (isset($flash['versionTheme'][0])): ?><p><?= $flash['versionTheme'][0] ?></p><?php endif; ?>
            </div>
            <div <?php if (isset($flash['versionPluxml'][0])): ?>style="color:red"<?php endif; ?>>
                <label for="versionPluxml">PluXml version: </label>
                <input type="text" name="versionPluxml" id="versionPluxml"
                       <?php if (isset($formOldValues['versionPluxml'])): ?>value="<?= $formOldValues['versionPluxml'] ?>"<?php endif; ?>>
                <?php if (isset($flash['versionPluxml'][0])): ?><p><?= $flash['versionPluxml'][0] ?></p><?php endif; ?>
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
