<div class="content">
    <div class="page">
        <h2><?= $h2 ?></h2>
        <ul class="menu breadcrumb">
            <li><a href="<?= $routerService->urlFor('backoffice') ?>"><?= _['BACKOFFICE'] ?></a></li>
            <li><a href="<?= $routerService->urlFor('boplugins') ?>">Plugins</a></li>
            <li><?= $plugin['name'] ?></li>
        </ul>
        <h3><?= $h3 ?></h3>
<?php include 'flash.php'; ?>
        <form action="<?= $routerService->urlFor('pluginEditAction', ['name' => $plugin['name']]) ?>" method="post"
              enctype="multipart/form-data">
            <input type="hidden" name="<?= $csrf['nameKey'] ?>" value="<?= $csrf['name'] ?>">
            <input type="hidden" name="<?= $csrf['valueKey'] ?>" value="<?= $csrf['value'] ?>">
            <input type="hidden" name="name" value="<?= $plugin['name'] ?>">
            <input type="hidden" name="id" value="<?= $plugin['id'] ?>">
            <input type="hidden" name="author" value="<?= $_SESSION['userid'] ?>">
            <div
                <?php if (isset($flash['description'][0]) or isset($flash['description'][0])): ?>style="color:red"<?php endif; ?>>
                <label for="description">Description*: </label>
                <input type="text" name="description" id="description"
                       <?php if (isset($formOldValues['description'])): ?>value="<?= $formOldValues['description'] ?>"
                       <?php else: ?>value="<?= $plugin['description'] ?>"<?php endif; ?>>
                <?php if (isset($flash['description'][0])): ?><p><?= $flash['description'][0] ?></p><?php endif; ?>
            </div>
            <div <?php if (isset($flash['category'][0])): ?>style="color:red"<?php endif; ?>>
                <label for="category">Category: </label>
                <select name="category" id="category" required>
                    <?php foreach ($categories as $category => $value): ?>
                        <option value="<?= $value['id'] ?>" <?php if ($plugin['category'] == $value['id']):?>selected="selected"<?php endif; ?>><?= $value['name'] ?></option>
                    <?php endforeach; ?>
                </select>
                <?php if (isset($flash['category'][0])): ?><p><?= $flash['category'][0] ?></p><?php endif; ?>
            </div>
            <div <?php if (isset($flash['version'][0])): ?>style="color:red"<?php endif; ?>>
                <label for="version">Version*: </label>
                <input type="text" name="version" id="version"
                       <?php if (isset($formOldValues['version'])): ?>value="<?= $formOldValues['version'] ?>"
                       <?php else: ?>value="<?= $plugin['version'] ?>"<?php endif; ?>>
                <?php if (isset($flash['version'][0])): ?><p><?= $flash['version'][0] ?></p><?php endif; ?>
            </div>
            <div <?php if (isset($flash['pluxml'][0])): ?>style="color:red"<?php endif; ?>>
                <label for="pluxml">PluXml version*: </label>
                <input type="text" name="pluxml" id="pluxml"
                       <?php if (isset($formOldValues['pluxml'])): ?>value="<?= $formOldValues['pluxml'] ?>"
                       <?php else: ?>value="<?= $plugin['pluxml'] ?>"<?php endif; ?>>
                <?php if (isset($flash['pluxml'][0])): ?><p><?= $flash['pluxml'][0] ?></p><?php endif; ?>
            </div>
            <div <?php if (isset($flash['link'][0])): ?>style="color:red"<?php endif; ?>>
                <label for="link">Link: </label>
                <input type="url" name="link" id="link"
                       <?php if (isset($formOldValues['link'])): ?>value="<?= $formOldValues['link'] ?>"
                       <?php else: ?>value="<?= $plugin['link'] ?>"<?php endif; ?>>
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
        <form action="<?= $routerService->urlFor('pluginDeleteAction', ['name' => $plugin['name']]) ?>" method="post">
            <input type="hidden" name="<?= $csrf['nameKey'] ?>" value="<?= $csrf['name'] ?>">
            <input type="hidden" name="<?= $csrf['valueKey'] ?>" value="<?= $csrf['value'] ?>">
            <button type="submit" class="blue"><i class="icon-trash"></i>Delete</button>
        </form>
    </div>
</div>
