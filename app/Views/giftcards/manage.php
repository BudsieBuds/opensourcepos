<?php
/**
 * @var string $controller_name
 * @var string $table_headers
 * @var array $config
 */
?>
<?= view('partial/header') ?>
<script type="application/javascript">
$(document).ready(function()
{
	<?= view('partial/bootstrap_tables_locale') ?>
	table_support.init({
		resource: '<?= esc($controller_name) ?>',
		headers: <?= $table_headers ?>,
		pageSize: <?= $config['lines_per_page'] ?>,
		uniqueId: 'giftcard_id'
	});
});
</script>

<div id="title_bar" class="btn-toolbar">
	<button class='btn btn-info btn-sm pull-right modal-dlg' data-btn-submit='<?= lang('Common.submit') ?>' data-href='<?= esc("$controller_name/view") ?>'
			title='<?= lang(ucfirst($controller_name) . '.new') ?>'>
		<i class="bi-gift icon-spacing"></i><?= lang(ucfirst($controller_name) . '.new') ?>
	</button>
</div>

<div id="toolbar">
	<div class="pull-left btn-toolbar">
		<button id="delete" class="btn btn-default btn-sm">
			<i class="bi-trash icon-spacing"></i><?= lang('Common.delete') ?>
		</button>
	</div>
</div>

<div id="table_holder">
	<table id="table"></table>
</div>

<?= view('partial/footer') ?>
