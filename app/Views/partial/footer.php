<?php

use Config\OSPOS;

?>

    </main>

    <footer class="text-muted small text-center" style="padding-top: 1em;">
        <div class="jumbotron">
            <?= lang('Common.copyrights', [date('Y')]) ?>
            <span>·</span>
            <a href="https://opensourcepos.org" target="_blank" rel="noopener"><?= lang('Common.website') ?></a>
            <span>·</span>
            <?= esc(config('App')->application_version) ?>
            <span>-</span>
            <a href="https://github.com/opensourcepos/opensourcepos/commit/<?= esc(config(OSPOS::class)->commit_sha1) ?>" target="_blank" rel="noopener">
                <?= esc(substr(config(OSPOS::class)->commit_sha1, 0, 6)); ?>
            </a>
        </div>
    </footer>

</body>

</html>
