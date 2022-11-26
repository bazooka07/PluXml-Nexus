<div class="content">
    <div class="page">
        <h2><?= $h2 ?></h2>
        <ul class="menu breadcrumb">
            <li><a href="<?= $routerService->urlFor('backoffice') ?>"><?= _['BACKOFFICE'] ?></a></li>
            <li><span><?= _['NEW_' . strtoupper($ressource)] ?></span></li>
        </ul>
        <h3><?= $h3 ?></h3>
<?php include 'flash.php'; ?>
        <div class="alert blue">
            <small>
                <strong><?= _['WARNING'] ?></strong>
                <ul>
                    <li><?= _['UNIQUE_NAME_' . strtoupper($ressource)] ?></li>
                    <li><?= _['ZIP_ARCHIVE'] ?></li>
                    <li><?= _['ZIP_RENAME_' . strtoupper($ressource)] ?></li>
                </ul>
            </small>
        </div>

        <form action="<?= $routerService->urlFor($ressource . 'SaveAction') ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="<?= $csrf['nameKey'] ?>" value="<?= $csrf['name'] ?>">
            <input type="hidden" name="<?= $csrf['valueKey'] ?>" value="<?= $csrf['value'] ?>">
            <input type="hidden" name="author" value="<?= $_SESSION['userid'] ?>">
<?php
$fields = array(
    'name' => _['NAME'],
    'description' => _['DESCRIPTION'],
    'category'     => _['CATEGORY'],
    'version'       => _['VERSION'],
    'pluxml'    => _['PLUXML'],
    'link'      => _['LINK'],
    'file'      => _['FILE'],
);
$requiredFields = array('name', 'file',);
foreach($fields as $f=>$label) {
    if ($f == 'category' and $ressource != 'plugin') {
        continue;
    }

    $required = in_array($f, $requiredFields) ? ' required' : '';

?>
            <div <?php if (isset($flash[$f][0])): ?>style="color:red"<?php endif; ?>>
                <label for="$f"><?= ucfirst($label) ?>: </label>
<?php
    switch($f) {
        case 'category':
?>
                <select name="category" id="category" required>
                    <option value="">...</option>
                    <?php foreach ($categories as $category => $value): ?>
                        <option value="<?= $value['id'] ?>" <?php if (isset($formOldValues['category']) and $formOldValues['category'] == $value['id']):?>selected="selected"<?php endif; ?>><?= $value['name'] ?></option>
                    <?php endforeach; ?>
                </select>
<?php
            break;
        case 'file':
?>
                <input type="file" name="<?= $f ?>" id="<?= $f ?>" required>
<?php
            break;
        default:
?>
                <input type="text" name="<?= $f ?>" id="<?= $f ?>"
                       <?php if (isset($formOldValues[$f])): ?>value="<?= $formOldValues[$f] ?>"<?php endif; ?>
                       <?= $required ?>
<?php
    }
?>
                <?php if (isset($flash[$f][0])): ?><p><?= $flash[$f][0] ?></p><?php endif; ?>
            </div>
<?php
}
?>
            <button type="submit"><i class="icon-floppy"></i><?= _['SAVE'] ?></button>
        </form>
    </div>
</div>
