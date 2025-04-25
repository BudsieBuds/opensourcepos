<h4 style="margin-top: 0;"><strong><i class="bi-eye icon-spacing"></i>Appearance Configuration</strong></h4>
<hr style="margin-top: 0;">

<form action="<?= site_url('config/saveAppearance/') ?>" method="post" id="config_form_appearance" enctype="multipart/form-data">

	<div class="form-group">
		<div id="error_alert_appearance" class="alert alert-warning d-none" style="padding-left: 2em;"></div>
	</div>

	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label for="theme"><?= lang('Config.theme') ?></label>
				<div class="input-group">
					<span class="input-group-addon"><i class="bi-binoculars"></i></span>
                    <select class="form-control" name="theme" id="theme">
                        <?php foreach ($themes as $value => $display): ?>
                            <option value="<?= $value ?>" <?= $config['theme'] == $value ? 'selected' : '' ?>><?= $display ?></option>
                        <?php endforeach; ?>
                    </select>
				</div>
			</div>
		</div>

		<div class="col-md-6">
			<div class="form-group">
				<label for="login_form"><?= lang('Config.login_form') ?></label>
				<div class="input-group">
					<span class="input-group-addon"><i class="bi-view-stacked"></i></span>
                    <select class="form-control" name="login_form" id="login_form">
                        <option value="floating_labels" <?= $config['login_form'] == 'floating_labels' ? 'selected' : '' ?>><?= lang('Config.floating_labels') ?></option>
                        <option value="input_groups" <?= $config['login_form'] == 'input_groups' ? 'selected' : '' ?>><?= lang('Config.input_groups') ?></option>
                    </select>
				</div>
			</div>
		</div>

		<div class="col-md-6">
			<div class="form-group">
				<label for="notify_position"><?= lang('Config.notify_alignment') ?></label>
                <div class="row" id="notify_position">
                    <div class="col-xs-12 col-sm-6">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="bi-arrow-down-up"></i></span>
                            <select class="form-control" name="notify_vertical_position">
                                <option value="top" <?= $config['notify_vertical_position'] == 'top' ? 'selected' : '' ?>><?= lang('Config.top') ?></option>
                                <option value="bottom" <?= $config['notify_vertical_position'] == 'bottom' ? 'selected' : '' ?>><?= lang('Config.bottom') ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="bi-arrow-left-right"></i></span>
                            <select class="form-control" name="notify_horizontal_position">
                                <option value="left" <?= $config['notify_horizontal_position'] == 'left' ? 'selected' : '' ?>><?= lang('Config.left') ?></option>
                                <option value="center" <?= $config['notify_horizontal_position'] == 'center' ? 'selected' : '' ?>><?= lang('Config.center') ?></option>
                                <option value="right" <?= $config['notify_horizontal_position'] == 'right' ? 'selected' : '' ?>><?= lang('Config.right') ?></option>
                            </select>
                        </div> 
                    </div>
                </div>
			</div>
		</div>

		<div class="col-md-6">
			<div class="form-group">
				<label for="config_menu_position">Configuration Menu Position</label>
				<div class="input-group">
					<span class="input-group-addon"><i class="bi-distribute-horizontal"></i></span>
                    <select class="form-control" id="config_menu_position" name="config_menu_position">
                        <option value="start" <?= $config['config_menu_position'] == 'start' ? 'selected' : '' ?>>Start</option>
                        <option value="end" <?= $config['config_menu_position'] == 'end' ? 'selected' : '' ?>>End</option>
                    </select>
				</div>
			</div>
		</div>
	</div>

    <div class="form-group text-right">
		<button type="submit" name="submit_appearance" id="submit_appearance" class="btn btn-primary">
			<i class="bi-check-lg icon-spacing"></i><?= lang('Common.submit') ?>
		</button>
	</div>

</form>

<script type="application/javascript">
//validation and submit handling
$(document).ready(function()
{
	$('#config_form_appearance').validate($.extend(form_support.handler, {

		errorLabelContainer: "#error_alert_appearance",
		errorElement: "div"
	}));
});
</script>