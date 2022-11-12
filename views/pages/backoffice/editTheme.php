<div class="content">
    <div class="page">
        <h2><?= $h2 ?></h2>
        <p>
            <a href="<?= $routerService->urlFor('backoffice') ?>">Backoffice</a>&nbsp;/&nbsp;
            <a href="<?= $routerService->urlFor('bothemes') ?>">Themes</a>&nbsp;/&nbsp;
            <?= $theme['name'] ?>
        </p>
        <h3><?= $h3 ?></h3>
<?php include 'flash.php'; ?>
        <form action="<?= $routerService->urlFor('themeEditAction', ['name' => $theme['name']]) ?>" method="post"
              enctype="multipart/form-data">
            <input type="hidden" name="<?= $csrf['nameKey'] ?>" value="<?= $csrf['name'] ?>">
            <input type="hidden" name="<?= $csrf['valueKey'] ?>" value="<?= $csrf['value'] ?>">
            <input type="hidden" name="name" value="<?= $theme['name'] ?>">
            <input type="hidden" name="id" value="<?= $theme['id'] ?>">
            <input type="hidden" name="author" value="<?= $_SESSION['userid'] ?>">
            <div
                <?php if (isset($flash['description'][0]) or isset($flash['description'][0])): ?>style="color:red"<?php endif; ?>>
                <label for="description">Description*: </label>
                <input type="text" name="description" id="description"
                       <?php if (isset($formOldValues['description'])): ?>value="<?= $formOldValues['description'] ?>"
                       <?php else: ?>value="<?= $theme['description'] ?>"<?php endif; ?>>
                <?php if (isset($flash['description'][0])): ?><p><?= $flash['description'][0] ?></p><?php endif; ?>
            </div>
            <div <?php if (isset($flash['version'][0])): ?>style="color:red"<?php endif; ?>>
                <label for="version">Version*: </label>
                <input type="text" name="version" id="version"
                       <?php if (isset($formOldValues['version'])): ?>value="<?= $formOldValues['version'] ?>"
                       <?php else: ?>value="<?= $theme['version'] ?>"<?php endif; ?>>
                <?php if (isset($flash['version'][0])): ?><p><?= $flash['version'][0] ?></p><?php endif; ?>
            </div>
            <div <?php if (isset($flash['pluxml'][0])): ?>style="color:red"<?php endif; ?>>
                <label for="pluxml">PluXml version*: </label>
                <input type="text" name="pluxml" id="pluxml"
                       <?php if (isset($formOldValues['pluxml'])): ?>value="<?= $formOldValues['pluxml'] ?>"
                       <?php else: ?>value="<?= $theme['pluxml'] ?>"<?php endif; ?>>
                <?php if (isset($flash['pluxml'][0])): ?><p><?= $flash['pluxml'][0] ?></p><?php endif; ?>
            </div>
            <div <?php if (isset($flash['link'][0])): ?>style="color:red"<?php endif; ?>>
                <label for="link">Link: </label>
                <input type="url" name="link" id="link"
                       <?php if (isset($formOldValues['link'])): ?>value="<?= $formOldValues['link'] ?>"
                       <?php else: ?>value="<?= $theme['link'] ?>"<?php endif; ?>>
                <?php if (isset($flash['link'][0])): ?><p><?= $flash['link'][0] ?></p><?php endif; ?>
            </div>
            <div <?php if (isset($flash['file'][0])): ?>style="color:red"<?php endif; ?>>
                <label for="file">File (optionnal): </label>
                <input type="file" name="file" id="file">
                <?php if (isset($flash['file'][0])): ?><p><?= $flash['file'][0] ?></p><?php endif; ?>
            </div>
            <button type="submit"><i class="icon-floppy"></i>Save</button>&nbsp;
        </form>
        <hr>
        <form action="<?= $routerService->urlFor('themeDeleteAction', ['name' => $theme['name']]) ?>" method="post">
            <input type="hidden" name="<?= $csrf['nameKey'] ?>" value="<?= $csrf['name'] ?>">
            <input type="hidden" name="<?= $csrf['valueKey'] ?>" value="<?= $csrf['value'] ?>">
            <button type="submit" class="blue"><i class="icon-trash"></i>Delete</button>
        </form>
    </div>
</div>
