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
                <table>
                    <thead>
                    <tr>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Website</th>
                        <th>Plugins</th>
                        <th>Themes</th>
                        <th>Validate before</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($profiles as $key => $profile): ?>
                        <tr>
                            <td>
                                <a href="<?= $routerService->urlFor('profile', ['username' => $profile['username']]) ?>"><?= $profile['username'] ?></a>
                            </td>
                            <td><?= $profile['email'] ?></td>
                            <td><?= $profile['website'] ?></td>
                            <td><?= $profile['plugins_cnt'] ?></td>
                            <td><?= $profile['themes_cnt'] ?></td>
                            <td><?= !empty($profile['token']) ? $profile['tokenexpire']: '&nbsp;' ?></td>
                            <td>
<?php if ($profile['role'] !== 'admin'): ?>
                                <a onclick="confirmModal('<?= $profile['username'] ?>', '<?= $routerService->urlFor('bormuser', ['userid' => $profile['id']]) ?>', 'user')"><i class="icon-trash"></i></a>
<?php else: ?>
    admin
<?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No users found</p>
            <?php endif; ?>
        </div>
    </div>
</div>
<script src="/js/confirmModal.js"></script>
