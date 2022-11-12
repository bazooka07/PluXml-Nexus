<?php if (isset($flash['success'])): ?>
            <div class="alert green">
                <?= $flash['success'][0] ?>
            </div>
<?php elseif (isset($flash['error'])): ?>
            <div class="alert red">
                <?= $flash['error'][0] ?>
            </div>
<?php endif; ?>
