<div class="content">
    <div class="page">
        <h2><?= $h2 ?></h2>
        <ul class="menu breadcrumb">
            <li><a href="<?= $routerService->urlFor('backoffice') ?>"><?= _['BACKOFFICE'] ?></a></li>
	    <li><a href="<?= $routerService->urlFor('bo' . $ressource . 's') ?>"><?= _[strtoupper($ressource . 's')] ?></a></li>
            <li><span><?= $item['name'] ?></span></li>
        </ul>
        <h3><?= $h3 ?></h3>
<?php include 'flash.php'; ?>
        <form action="<?= $routerService->urlFor($ressource . 'EditAction', $item) ?>" method="post"
              enctype="multipart/form-data">
            <input type="hidden" name="<?= $csrf['nameKey'] ?>" value="<?= $csrf['name'] ?>">
            <input type="hidden" name="<?= $csrf['valueKey'] ?>" value="<?= $csrf['value'] ?>">
            <input type="hidden" name="name" value="<?= $item['name'] ?>">
            <input type="hidden" name="id" value="<?= $item['id'] ?>">
            <input type="hidden" name="author" value="<?= $_SESSION['userid'] ?>">
            <div
                <?php if (isset($flash['description'][0]) or isset($flash['description'][0])): ?>style="color:red"<?php endif; ?>>
                <label for="description"><?= _['DESCRIPTION'] ?>*: </label>
                <input type="text" name="description" id="description"
                       <?php if (isset($formOldValues['description'])): ?>value="<?= $formOldValues['description'] ?>"
                       <?php else: ?>value="<?= $item['description'] ?>"<?php endif; ?>>
                <?php if (isset($flash['description'][0])): ?><p><?= $flash['description'][0] ?></p><?php endif; ?>
            </div>
<?php if(isset($item['category'])): ?>
            <div <?php if (isset($flash['category'][0])): ?>style="color:red"<?php endif; ?>>
	    <label for="category"><?= _['CATEGORY'] ?>: </label>
                <select name="category" id="category" required>
                    <?php foreach ($categories as $category => $value): ?>
                        <option value="<?= $value['id'] ?>" <?php if ($item['category'] == $value['id']):?>selected="selected"<?php endif; ?>><?= $value['name'] ?></option>
                    <?php endforeach; ?>
                </select>
                <?php if (isset($flash['category'][0])): ?><p><?= $flash['category'][0] ?></p><?php endif; ?>
	    </div>
<?php endif; ?>
            <div <?php if (isset($flash['version'][0])): ?>style="color:red"<?php endif; ?>>
	    <label for="version"><?= _['VERSION'] ?>*: </label>
                <input type="text" name="version" id="version"
                       <?php if (isset($formOldValues['version'])): ?>value="<?= $formOldValues['version'] ?>"
                       <?php else: ?>value="<?= $item['version'] ?>"<?php endif; ?>>
                <?php if (isset($flash['version'][0])): ?><p><?= $flash['version'][0] ?></p><?php endif; ?>
            </div>
            <div <?php if (isset($flash['pluxml'][0])): ?>style="color:red"<?php endif; ?>>
               <label for="pluxml"><?= _['PLUXML'] ?>*: </label>
                <input type="text" name="pluxml" id="pluxml"
                       <?php if (isset($formOldValues['pluxml'])): ?>value="<?= $formOldValues['pluxml'] ?>"
                       <?php else: ?>value="<?= $item['pluxml'] ?>"<?php endif; ?>>
                <?php if (isset($flash['pluxml'][0])): ?><p><?= $flash['pluxml'][0] ?></p><?php endif; ?>
            </div>
            <div <?php if (isset($flash['link'][0])): ?>style="color:red"<?php endif; ?>>
                <label for="link"><?= _['LINK'] ?>: </label>
                <input type="url" name="link" id="link"
                       <?php if (isset($formOldValues['link'])): ?>value="<?= $formOldValues['link'] ?>"
                       <?php else: ?>value="<?= $item['link'] ?>"<?php endif; ?>>
                <?php if (isset($flash['link'][0])): ?><p><?= $flash['link'][0] ?></p><?php endif; ?>
            </div>
            <div <?php if (isset($flash['file'][0])): ?>style="color:red"<?php endif; ?>>
                <label for="file"><?= _['FILE'] ?> (optionnal): </label>
                <input type="file" name="file" id="file">
                <?php if (isset($flash['file'][0])): ?><p><?= $flash['file'][0] ?></p><?php endif; ?>
            </div>
	    <button type="submit"><i class="icon-floppy"></i><?= _['SAVE'] ?></button>&nbsp;
        </form>
        <hr>
        <form action="<?= $routerService->urlFor($ressource . 'DeleteAction', $item) ?>" method="post">
            <input type="hidden" name="<?= $csrf['nameKey'] ?>" value="<?= $csrf['name'] ?>">
            <input type="hidden" name="<?= $csrf['valueKey'] ?>" value="<?= $csrf['value'] ?>">
	    <button type="submit" class="blue"><i class="icon-trash"></i><?= _['DELETE'] ?></button>
        </form>
    </div>
</div>
