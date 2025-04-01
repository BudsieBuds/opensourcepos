<?php
/**
 * @var array $allowed_modules
 */
?>

<script type="application/javascript">
	dialog_support.init("a.modal-dlg");
</script>

<h3 class="text-center"><?= lang('Common.welcome_message') ?></h3>

<section class="container-fluid text-center" style="padding: 2.5em 0;">
	<?php foreach($allowed_modules as $module) { ?>
        <div class="module_item" title="<?= lang("Module.$module->module_id" . '_desc') ?>">
            <a href="<?= base_url($module->module_id) ?>"><img src="<?= base_url("images/menubar/$module->module_id.svg") ?>" style="border-width: 0; height: 64px; max-width: 64px;" alt="Menubar Image" /></a>
            <a href="<?= base_url($module->module_id) ?>"><?= lang("Module.$module->module_id") ?></a>
        </div>
    <?php } ?>
</section>

<!--
<h3 class="text-center pb-3 d-none d-lg-block"><?= lang('Common.welcome_message') ?></h3>

<section class="container-fluid d-flex flex-wrap justify-content-center gap-3 p-0 py-1 py-lg-0">
	<?php foreach ($allowed_modules as $module) { ?>
		<div class="border border-primary rounded shadow-sm bg-primary-subtle text-center d-block" title="<?= lang("Module.$module->module_id" . '_desc') ?>">
			<a href="<?= base_url($module->module_id) ?>">
				<img class="d-block mx-auto p-2" src="<?= base_url("images/menubar/$module->module_id.svg") ?>" alt="Menubar Image">
			</a>
			<a href="<?= base_url($module->module_id) ?>">
				<div class="tile-text rounded-bottom d-block bg-primary text-light fw-bold p-2">
					<span><?= lang("Module.$module->module_id") ?></span>
				</div>
			</a>
		</div>
	<?php } ?>
</section>-->