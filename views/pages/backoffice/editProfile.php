<div class="content">
    <div class="page">
        <h2><?= $h2 ?></h2>
        <p>
            <a href="<?= $routerService->urlFor('backoffice') ?>">Backoffice</a>&nbsp;/&nbsp;
            My profile
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

        <form action="<?= $routerService->urlFor('profileSaveAction') ?>" method="post">
            <input type="hidden" name="<?= $csrf['nameKey'] ?>" value="<?= $csrf['name'] ?>">
            <input type="hidden" name="<?= $csrf['valueKey'] ?>" value="<?= $csrf['value'] ?>">
            <input type="hidden" name="username" value="<?= $username ?>">
            <input type="hidden" name="userid" value="<?= $userid ?>">
            <div <?php if (isset($flash['email'][0])): ?>style="color:red"<?php endif; ?>>
                <label for="email">Email address*: </label>
                <input type="email" name="email" id="email"
                       <?php if (isset($formOldValues['email'])): ?>value="<?= $formOldValues['email'] ?>"
                       <?php else: ?>value="<?= $email ?>"<?php endif; ?>
                       required>
                <?php if (isset($flash['email'][0])): ?><p><?= $flash['email'][0] ?></p><?php endif; ?>
            </div>
            <div <?php if (isset($flash['website'][0])): ?>style="color:red"<?php endif; ?>>
                <label for="website">Website: </label>
                <input type="url" name="website" id="website"
                       <?php if (isset($formOldValues['website'])): ?>value="<?= $formOldValues['website'] ?>"
                       <?php else: ?>value="<?= $website ?>"<?php endif; ?>>
                <?php if (isset($flash['website'][0])): ?><p><?= $flash['website'][0] ?></p><?php endif; ?>
            </div>
            <div>
                <input type="submit" value="Save">
            </div>
        </form>
    </div>
</div>
