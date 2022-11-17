<div class="content">
    <div class="page">
        <div class="auth">
            <h3><?= _['LOG_IN'] ?></h3>
<?php include 'flash.php'; ?>
            <form action="<?= $routerService->urlFor('loginAction') ?>" method="post">
                <input type="hidden" name="<?= $csrf['nameKey'] ?>" value="<?= $csrf['name'] ?>">
                <input type="hidden" name="<?= $csrf['valueKey'] ?>" value="<?= $csrf['value'] ?>">
                <div <?php if (isset($flash['error'][1])): ?>style="color:red"<?php endif; ?>>
                    <label for="username"><?= _['LOGIN'] ?> :</label>
                    <input type="text" name="username" id="username"
                           <?php if (isset($formOldValues['username'])): ?>value="<?= $formOldValues['username'] ?>"<?php endif; ?>
                           required>
                    <?php if (isset($flash['error'][1])): ?><p><?= $flash['error'][1] ?></p><?php endif; ?>
                </div>
                <div <?php if (isset($flash['error'][2])): ?>style="color:red"<?php endif; ?>>
                    <label for="password"><?= _['PASSWORD'] ?> : </label>
                    <input type="password" name="password" id="password" required>
                    <?php if (isset($flash['error'][2])): ?><p><?= $flash['error'][2] ?></p><?php endif; ?>
                </div>
                <div>
                    <input type="submit" value="<?= _['LOG_IN'] ?>">
                </div>
            </form>
            <small><a href="<?= $routerService->urlFor('lostPassword') ?>"><?= _['LOST_PASSSWORD'] ?></a></small>
        </div>
    </div>
</div>