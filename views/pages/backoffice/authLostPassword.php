<div class="content">
    <div class="page">
        <div class="auth">
            <h3><?= _['LOST_YOUR_PASSWORD'] ?></h3>
            <form action="<?= $routerService->urlFor('lostPasswordAction') ?>" method="post">
                <input type="hidden" name="<?= $csrf['nameKey'] ?>" value="<?= $csrf['name'] ?>">
                <input type="hidden" name="<?= $csrf['valueKey'] ?>" value="<?= $csrf['value'] ?>">
                <div <?php if (isset($flash['error'][1])): ?>style="color:red"<?php endif; ?>>
                    <label for="username"><?= _['LOGIN'] ?></label>
                    <input type="text" name="username" id="username"
                           <?php if (isset($formOldValues['username'])): ?>value="<?= $formOldValues['username'] ?>"<?php endif; ?>
                           required>
                    <?php if (isset($flash['error'][1])): ?><p><?= $flash['error'][1] ?></p><?php endif; ?>
                </div>
                <div>
                    <input type="submit" value="<?= _['GET_NEW_PASSWORD'] ?>">
                </div>
            </form>
            <small><a href="<?= $routerService->urlFor('auth') ?>">← <?= _['BACK_TO_LOG_IN'] ?></a></small>
        </div>
    </div>
</div>