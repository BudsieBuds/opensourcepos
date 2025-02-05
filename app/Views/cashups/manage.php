<?php
/**
 * @var string $controller_name
 * @var string $table_headers
 * @var array $filters
 * @var array $config
 */
?>
<?= view('partial/header') ?>

<?php
$title_info['config_title'] = 'Cashups';
echo view('configs/config_header', $title_info);
?>

<script type="application/javascript">
$(document).ready(function()
{
	// when any filter is clicked and the dropdown window is closed
	$('#filters').on('hidden.bs.select', function(e) {
		table_support.refresh();
	});

	// load the preset datarange picker
	<?= view('partial/daterangepicker') ?>

	$("#daterangepicker").on('apply.daterangepicker', function(ev, picker) {
		table_support.refresh();
	});

	<?= view('partial/bootstrap_tables_locale') ?>

	table_support.init({
		resource: '<?= esc($controller_name) ?>',
		headers: <?= $table_headers ?>,
		pageSize: <?= $config['lines_per_page'] ?>,
		uniqueId: 'cashup_id',
		queryParams: function() {
			return $.extend(arguments[0], {
				"end_date": end_date,
				"filters": $("#filters").val(),
				"start_date": start_date
			});
		}
	});
});
</script>

<?= view('partial/print_receipt', ['print_after_sale'=> false, 'selected_printer' => 'takings_printer']) ?>

<div class="d-flex gap-2 justify-content-end d-print-none">
	<button type="button" class="btn btn-primary icon-link" data-btn-submit="<?= lang('Common.submit') ?>" data-href="<?= '$controller_name/view' ?>" title="<?= lang(esc(ucfirst($controller_name)) . '.new') //TODO: String Interpolation ?>">
		<i class="bi-journal-check"></i><?= lang(esc(ucfirst($controller_name)) . '.new') //TODO: String Interpolation ?>
	</button>
	<button type="button" class="btn btn-primary icon-link" onclick="window.print()" title="<?= lang('Common.print') ?>">
		<i class="bi-printer"></i><?= lang('Common.print') ?>
	</button>
</div>

<div id="toolbar">
	<div class="d-flex gap-2">
		<button type="button" class="btn btn-secondary icon-link d-print-none">
			<i class="bi-trash"></i><span class="d-none d-sm-block"><?= lang('Common.delete') ?></span>
		</button>
		<input type="text" class="form-control" name="daterangepicker" id="daterangepicker">
		<select id="filters" name="filters[]" class="selectpicker show-menu-arrow" data-none-selected-text="<?= lang('Common.none_selected_text') ?>" data-selected-text-format="count > 1" data-style="btn-secondary" data-width="fit" multiple>
			<?php foreach ($filters as $key => $value): ?>
				<option value="<?= esc($key) ?>"><?= esc($value) ?></option>
			<?php endforeach; ?>
		</select>
	</div>
</div>

<div id="table_holder">
	<table id="table"></table>
</div>

<?= view('partial/footer') ?>
