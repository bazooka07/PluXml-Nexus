<div class="content">
    <div class="page">
	<ul class="menu breadcrumb">
		<li><a href="<?= $routerService->urlFor('backoffice') ?>"><?= $h2 ?></a></li>
		<li><span><?= _['USERS'] ?></span></li>
	</ul>
        <h3><?= $h3 ?></h3>
<?php
include 'flash.php';

if (!empty($profiles)):
?>
            <div class="scrollable-table">
                <table id="users" data-user="<?= _['DEL_USER'] ?>" data-contributor="<?= _['DEL_CONTRIBUTOR'] ?>">
                    <thead>
                    <tr>
                        <th><?= _['LOGIN'] ?></th>
                        <th><?= _['EMAIL'] ?></th>
                        <th><?= _['WEBSITE'] ?></th>
                        <th><?= _['PLUGINS'] ?></th>
                        <th><?= _['THEMES'] ?></th>
                        <th><?= _['VALIDATE_BEFORE'] ?></th>
                        <th><?= _['ACTIONS'] ?></th>
                    </tr>
                    </thead>
                    <tbody>
<?php foreach ($profiles as $key => $profile): ?>
                        <tr>
                            <td>
<?php
$cnt = $profile['plugins_cnt'] + $profile['themes_cnt'];
if(empty($profile['token']) and $cnt > 0):
?>
                                <a href="<?= $routerService->urlFor('profile', ['username' => $profile['username']]) ?>"><?= $profile['username'] ?></a>
<?php else : ?>
                                <span><?= $profile['username'] ?></span>
<?php endif; ?>
                            </td>
                            <td><?= $profile['email'] ?></td>
                            <td><?= $profile['website'] ?></td>
                            <td><?= $profile['plugins_cnt'] ?></td>
                            <td><?= $profile['themes_cnt'] ?></td>
                            <td><?= !empty($profile['token']) ? $profile['tokenexpire']: '&nbsp;' ?></td>
                            <td>
<?php if ($profile['role'] == 'admin') : ?>
    admin
<?php
else :
    $params = array(
        '\'' . $profile['username'] . '\'',
        '\'' . $routerService->urlFor('bormuser', ['userid' => $profile['id']]) . '\'',
        !empty($profile['plugins_cnt']) ? $profile['plugins_cnt'] : 0,
        !empty($profile['themes_cnt']) ? $profile['themes_cnt'] : 0,
    );
?>
                                <a onclick="confirmUserModal(<?= implode(',', $params) ?>)"><i class="icon-trash <?= ($profile['plugins_cnt'] or $profile['themes_cnt']) ? 'contributor' : '' ?>"></i></a>
<?php endif; ?>
                            </td>
                        </tr>
<?php endforeach; ?>
                    </tbody>
                </table>
            </div>
<?php
    if ($expireCount > 0) :
?>
            <div class="grid">
                <div class="col med-6 lrg-4">
                    <?= $expireCount ?> <?= _['INVALIDATE_USERS'] ?>
                </div>
                <div class="col med-2 med-offset-4 lrg-2 lrg-offset-6">
                    <a href="<?= $routerService->urlFor('bormusers') ?>" onclick="return confirm('drop <?= $expireCount ?> user(s)');"><button><?= _['DROP'] ?></button></a>
                </div>

            </div>
<?php
    endif;
else:
?>
            <p><?= _['NO_USERS_FOUND'] ?></p>
<?php
endif;
?>
    </div>
</div>
