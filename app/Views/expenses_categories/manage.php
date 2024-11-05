<?php
/**
 * @var string $controller_name
 * @var string $table_headers
 * @var array $config
 */
?>
<?= view('partial/header') ?>

<?php
$title_info['config_title'] = 'Expenses Categories';
echo view('configs/config_header', $title_info);
?>

<script type="application/javascript">
$(document).ready(function()
{
	<?= view('partial/bootstrap_tables_locale') ?>

	table_support.init({
		resource: '<?= esc($controller_name) ?>',
		headers: <?= $table_headers ?>,
		pageSize: <?= $config['lines_per_page'] ?>,
		uniqueId: 'expense_category_id',

	});

	// when any filter is clicked and the dropdown window is closed
	$('#filters').on('hidden.bs.select', function(e)
	{
		table_support.refresh();
	});
});
</script>

<div class="d-flex gap-2 justify-content-end">
	<button type="button" class="btn btn-primary icon-link" data-btn-submit="<?= lang('Common.submit') ?>" data-href="<?= esc('$controller_name/view') ?>" title="<?= lang(ucfirst($controller_name). ".new") ?>">
		<i class="bi-bookmark-plus"></i><?= lang(ucfirst($controller_name). ".new") ?>
	</button>
</div>

<div id="toolbar">
	<div class="d-flex gap-2">
		<button type="button" class="btn btn-secondary icon-link">
			<i class="bi-trash"></i><span class="d-none d-sm-block"><?= lang('Common.delete') ?></span>
		</button>
	</div>
</div>

<div id="table_holder">
	<table id="table"></table>
</div>

<?= view('partial/footer') ?>
