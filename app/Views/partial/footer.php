<?php

use Config\OSPOS;

?>

    </main>

    <footer class="flex-shrink-0 fg-secondary small fw-semibold bg-secondary-subtle py-3 print:d-none">
        <div class="lg:container d-flex flex-wrap justify-content-center align-items-center">
            <div>
                <span><?= lang('Common.copyrights', [date('Y')]) ?></span>
            </div>
            <div>
                <span class="d-none xl:d-block">&nbsp;·&nbsp;<a href="https://opensourcepos.org" class="fg-secondary" target="_blank" rel="noopener"><?= lang('Common.website') ?></a>&nbsp;·&nbsp;</span>
                <span class="xl:d-none">&nbsp;·&nbsp;<?= lang('Common.website') ?>&nbsp;·&nbsp;</span>
            </div>
            <div>
                <span><?= esc(config('App')->application_version) ?>&nbsp;-</span>
                <span class="d-none xl:d-inline"><a href="https://github.com/opensourcepos/opensourcepos/commit/<?= esc(config(OSPOS::class)->commit_sha1) ?>" class="fg-secondary" target="_blank" rel="noopener"><?= esc(substr(config(OSPOS::class)->commit_sha1, 0, 6)); ?></a></span>
                <span class="xl:d-none"><?= esc(substr(config(OSPOS::class)->commit_sha1, 0, 6)); ?></span>
            </div>
        </div>
    </footer>

    <script type="text/javascript" src="js/bs-tooltips.js"></script>
    <script type="text/javascript" src="js/bs-modal_switch_content.js"></script>
</body>

</html>
