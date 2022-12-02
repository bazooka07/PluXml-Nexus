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
                        <th><?= _['LASTCONNECTED'] ?></th>
                        <th>IP v4</td>
                        <th><?= _['ACTIONS'] ?></th>
                    </tr>
                    </thead>
                    <tbody>
<?php
$now = date('Y-m-d H:i:s');
foreach ($profiles as $key => $profile):
?>
                        <tr>
                            <td>
<?php
$isContributor = !empty($profile['plugins_cnt']) or !empty($profile['themes_cnt']);
if(empty($profile['token']) and $isContributor):
?>
                                <a href="<?= $routerService->urlFor('profile', ['username' => $profile['username']]) ?>"><?= $profile['username'] ?></a>
<?php else : ?>
                                <span><?= $profile['username'] ?></span>
<?php endif; ?>
                            </td>
                            <td><?= $profile['email'] ?></td>
<?php
if(!empty($profile['website'])) {
?>
                            <td><a href="<?= $profile['website'] ?>" target="_blank"><?= $profile['website'] ?></a></td>
<?php
} else {
?>
                            <td>&nbsp;</td>
<?php
}
?>
                            <td><?= $profile['plugins_cnt'] ?></td>
                            <td><?= $profile['themes_cnt'] ?></td>
<?php
if(!empty($profile['token'])) {
?>
                            <td class="<?= ($profile['tokenexpire'] < $now) ? 'expired' : 'waiting' ?>"><?= reverseDate($profile['tokenexpire']) ?></td>
<?php
} else {
?>
                            <td><?= !empty($profile['lastconnected']) ? reverseDate($profile['lastconnected']) : '&nbsp;' ?></td>
<?php
}
?>
                            <td><?= !empty($profile['ipv4']) ? long2ip($profile['ipv4']) : '&nbsp;' ?></td>
<?php if ($profile['role'] == 'admin') : ?>
                            <td><strong>admin</strong></td>
<?php
else :
    $params = '\'' . $profile['username'] . '\'';
    if($isContributor) {
        $params .= ',' . $profile['plugins_cnt'] . ',' . $profile['themes_cnt'];
    }
?>
                            <td><a href="<?= $routerService->urlFor('bormuser', $profile) ?>" onclick="return confirmUserModal(<?= $params ?>)"><i class="icon-trash <?= ($profile['plugins_cnt'] or $profile['themes_cnt']) ? 'contributor' : '' ?>"></i></a></td>
<?php endif; ?>
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
                    <span class="users expired"><?= sprintf(_['INVALIDATE_USERS'], $expireCount) ?></span>
                </div>
                <div class="col med-2 med-offset-4 lrg-2 lrg-offset-6">
                    <a href="<?= $routerService->urlFor('bormusers') ?>" onclick="return confirm('<?= sprintf(_['DROP_USERS_COUNT'], $expireCount) ?>');"><button><?= _['DROP'] ?></button></a>
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
