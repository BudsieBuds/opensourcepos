<?php

use Config\OSPOS;

?>

    </main>

    <footer class="text-body-secondary small fw-semibold bg-secondary-subtle py-5 text-center">
        <span><?= lang('Common.copyrights', [date('Y')]) ?></span>
        <span>&middot;</span>
        <a href="https://opensourcepos.org" target="_blank" rel="noopener"><?= lang('Common.website') ?></a>
        <span>&middot;</span>
        <span><?= esc(config('App')->application_version) ?></span>
        <span>-</span>
        <a href="https://github.com/opensourcepos/opensourcepos/commit/<?= esc(config(OSPOS::class)->commit_sha1) ?>" target="_blank" rel="noopener">
            <?= esc(substr(config(OSPOS::class)->commit_sha1, 0, 6)); ?>
        </a>
    </footer>

</body>

</html>
