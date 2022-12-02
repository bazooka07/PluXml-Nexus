<div class="content">
    <div class="page">
        <h2><?= $h2 ?></h2>
        <p><a href="<?= $routerService->urlFor('backoffice') ?>">Backoffice</a>&nbsp;/&nbsp;Users</p>
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

        <div class="scrollable-table">
            <?php if (!empty($profiles)): ?>
                <table id="users">
                    <thead>
                    <tr>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Website</th>
                        <th>Had plugins</th>
                        <th>Validated</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
<?php
foreach ($profiles as $key => $profile):
    $expiredClass = ($profile['tokenexpire'] != '0000-00-00 00:00:00' and $profile['tokenexpire'] < $now) ? 'expired' : '';
    $expiredCaption = ($profile['tokenexpire'] == '0000-00-00 00:00:00') ? 'Yes' : 'No (' . $profile['tokenexpire'] . ')';
?>
                        <tr>
                            <td><a href="<?= $routerService->urlFor('profile', ['username' => $profile['username']]) ?>"><?= $profile['username'] ?></a></td>
                            <td><?= $profile['email'] ?></td>
                            <td><a href="<?= $profile['website'] ?>" target="_blank"><?= $profile['website'] ?></a></td>
                            <td><?= ($profile['hadPlugins']) ? 'Yes' : 'No' ?></td>
                            <td class="<?= $expiredClass ?>"><?= $expiredCaption ?></td>
                            <td>
                                <a onclick="confirmModal('<?= $profile['username'] ?>', '<?= $routerService->urlFor('bormuser', ['username' => $profile['username']]) ?>')"><i class="icon-trash"></i></a>
                            </td>
                        </tr>
<?php endforeach; ?>
                    </tbody>
                </table>
<?php
if(!empty($expired)) {
?>
                <div>
                    <a href="<?= $routerService->urlFor('boexpiredusers') ?>" onclick="return confirm(this.textContent + ' ?')"><button><i class="icon-trash"></i> <span>Drop <?= $expired ?> expired users</span></button></a>
                </div>
<?php
}
?>
            <?php else: ?>
                <p>No users found</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="/js/confirmModal.js"></script>
