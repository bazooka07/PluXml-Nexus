<div class="content">
    <div class="page">
        <ul class="menu breadcrumb">
            <li><a href="<?= $routerService->urlFor('backoffice') ?>"><?= $h2 ?></a></li>
            <li><?= $h3 ?></li>
        </ul>
<?php include 'flash.php'; ?>
        <form action="<?= $routerService->urlFor('profileSaveAction') ?>" method="post">
            <input type="hidden" name="<?= $csrf['nameKey'] ?>" value="<?= $csrf['name'] ?>">
            <input type="hidden" name="<?= $csrf['valueKey'] ?>" value="<?= $csrf['value'] ?>">
            <input type="hidden" name="username" value="<?= $username ?>">
            <input type="hidden" name="userid" value="<?= $userid ?>">
            <div <?php if (isset($flash['email'][0])): ?>style="color:red"<?php endif; ?>>
                <label for="email"><?= _['EMAIL'] ?>: </label>
                <input type="email" name="email" id="email"
                       <?php if (isset($formOldValues['email'])): ?>value="<?= $formOldValues['email'] ?>"
                       <?php else: ?>value="<?= $email ?>"<?php endif; ?>
                       required>
                <?php if (isset($flash['email'][0])): ?><p><?= $flash['email'][0] ?></p><?php endif; ?>
            </div>
            <div <?php if (isset($flash['website'][0])): ?>style="color:red"<?php endif; ?>>
                <label for="website"><?= _['WEBSITE'] ?> : </label>
                <input type="url" name="website" id="website"
                       <?php if (isset($formOldValues['website'])): ?>value="<?= $formOldValues['website'] ?>"
                       <?php else: ?>value="<?= $website ?>"<?php endif; ?>>
                <?php if (isset($flash['website'][0])): ?><p><?= $flash['website'][0] ?></p><?php endif; ?>
            </div>
            <div>
                <button type="submit"><?= _['SAVE'] ?></button>
            </div>
        </form>
    </div>
</div>
