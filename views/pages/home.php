<?php if (isset($flash['success'])): ?>
    <div class="alert green">
        <?= $flash['success'][0] ?>
    </div>
<?php elseif (isset($flash['error'])): ?>
    <div class="alert red">
        <?= $flash['error'][0] ?>
    </div>
<?php endif; ?>

<div class="content">
    <?php require_once 'tags/tabs.php' ?>
    <div class="page text-center">
        <h2>PluXml <?= $pluxmlCurrentVersion ?></h2>
        <p><a href="https://www.pluxml.org/download/pluxml-latest.zip"
              title="Download PluXml"><button><i class="icon-download"></i><?= _['DOWNLOAD'] ?></button></a></p>
        <p><small><a href="https://www.pluxml.org/download/changelog.txt">Changelog</a> - <a
                        href="https://github.com/pluxml/PluXml/releases" target="_blank"><?= _['PREVIOUS_VERSIONS'] ?></a></small></p>
        <h2><?= _['INSTALLATION'] ?></h2>
        <p><?php
$link = '<a href="https://wiki.pluxml.org/docs/install/" target="_blank">' . _['AVAILABLE_HERE'] . '</a> <em>(french only 🇫🇷)</em>';
printf(_['DOC_INSTALL'], $link);
?></p>
    </div>
</div>
