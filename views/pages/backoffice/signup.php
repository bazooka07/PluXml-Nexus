<div class="content">
    <div class="page">
        <div class="auth">
            <h3><?= _['REGISTRATION'] ?></h3>
<?php
include 'flash.php';

if(!empty($enable)) {
?>
            <form action="<?= $routerService->urlFor('signupAction') ?>" method="post">
                <input type="hidden" name="<?= $csrf['nameKey'] ?>" value="<?= $csrf['name'] ?>">
                <input type="hidden" name="<?= $csrf['valueKey'] ?>" value="<?= $csrf['value'] ?>">
                <div <?php if (isset($flash['username'][0])): ?>style="color:red"<?php endif; ?>>
                    <label for="username"><?= _['LOGIN'] ?>:</label>
                    <input type="text" name="username" id="username"
                           <?php if (isset($formOldValues['username'])): ?>value="<?= $formOldValues['username'] ?>"<?php endif; ?>
                           required>
                    <?php if (isset($flash['username'][0])): ?><p><?= $flash['username'][0] ?></p><?php endif; ?>
                </div>
                <div
                    <?php if (isset($flash['password'][0]) or isset($flash['password2'][0])): ?>style="color:red"<?php endif; ?>>
                    <label for="password"><?= _['PASSWORD'] ?>: </label>
                    <input type="password" name="password" id="password"
                           <?php if (isset($formOldValues['password'])): ?>value="<?= $formOldValues['password'] ?>"<?php endif; ?>
                           required>
                    <?php if (isset($flash['password'][0])): ?><p><?= $flash['password'][0] ?></p><?php endif; ?>
                </div>
                <div <?php if (isset($flash['password2'][0])): ?>style="color:red"<?php endif; ?>>
                    <label for="password2"><?= _['PASSWORD_CONFIRM'] ?>:</label>
                    <input type="password" name="password2" id="password2" required>
                    <?php if (isset($flash['password2'][0])): ?><p><?= $flash['password2'][0] ?></p><?php endif; ?>
                </div>
                <div <?php if (isset($flash['email'][0])): ?>style="color:red"<?php endif; ?>>
                    <label for="email"><?= _['EMAIL'] ?>:</label>
                    <input type="email" name="email" id="email"
                           <?php if (isset($formOldValues['email'])): ?>value="<?= $formOldValues['email'] ?>"<?php endif; ?>
                           required>
                    <?php if (isset($flash['email'][0])): ?><p><?= $flash['email'][0] ?></p><?php endif; ?>
                </div>
                <div class="text-center">
                    <button type="submit"><?= _['REGISTRATION_REQUEST'] ?></button>
                </div>
            </form>
<?php
} else {
?>
           <div class="text-center alert red"><?= nl2br(_['DISABLED_SIGNUP']) ?></div>
<?php
}
?>
        </div>
    </div>
</div>