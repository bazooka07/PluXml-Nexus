<div class="content">
    <div class="page">
        <div class="auth">
            <h3>Reset password</h3>
<?php include 'flash.php'; ?>
            <form action="<?= $routerService->urlFor('resetPassword') ?>" method="post">
                <input type="hidden" name="<?= $csrf['nameKey'] ?>" value="<?= $csrf['name'] ?>">
                <input type="hidden" name="<?= $csrf['valueKey'] ?>" value="<?= $csrf['value'] ?>">
                <input type="hidden" name="username" value="<?= $user['username'] ?>">
                <div <?php if (isset($flash['error'][2])): ?>style="color:red"<?php endif; ?>>
                    <label for="password">Password: </label>
                    <input type="password" name="password" id="password" required>
                    <?php if (isset($flash['error'][2])): ?><p><?= $flash['error'][2] ?></p><?php endif; ?>
                </div>
                <div>
                    <input type="submit" value="Change my password">
                </div>
            </form>
            <small><a href="<?= $routerService->urlFor('lostPassword') ?>">← Back to log in</a></small>
        </div>
    </div>
</div>