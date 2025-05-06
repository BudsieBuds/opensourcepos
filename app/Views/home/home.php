<?php
/**
 * @var array $allowed_modules
 */
?>

<?= view('partial/header') ?>

<div class="py-4">

    <h3 class="text-center pb-4"><?= lang('Common.welcome_message') ?></h3>

    <section class="d-flex flex-wrap justify-content-center gap-4">
        <?php foreach ($allowed_modules as $module) { ?>
            <div class="d-inline-block" title="<?= lang("Module.$module->module_id" . '_desc') ?>">
                <a href="<?= base_url($module->module_id) ?>">
                    <img class="d-block mx-auto" src="<?= base_url("images/menubar/$module->module_id.svg") ?>" alt="Menubar Image">
                </a>
                <a class="d-block text-center" href="<?= base_url($module->module_id) ?>">
                    <?= lang("Module.$module->module_id") ?>
                </a>
            </div>
        <?php } ?>
    </section>

</div>

<?= view('partial/footer') ?>
