<?php

/**
 *
 */

$beta = '<sup><span class="badge bg-secondary">BETA</span></sup>';
?>

<?= form_open('config/saveAppearance/', ['id' => 'appearance_config_form']) ?>

<?php
$title_info['config_title'] = 'Appearance';
echo view('configs/config_header', $title_info);
?>

<ul id="error_message_box" class="appearance_error_message_box alert alert-warning d-none"></ul>

<div class="row">
    <div class="col-12 col-lg-6">
        <label for="theme-change" class="form-label">Color Theme</label>
        <div class="input-group mb-3">
            <span class="input-group-text"><i class="bi bi-palette"></i></span>
            <select class="form-select" name="theme" id="theme-change">
                <?php foreach ($themes as $value => $display): ?>
                    <option value="<?= $value ?>" <?= $config['theme'] == $value ? 'selected' : '' ?>><?= $display ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <label for="login_form" class="form-label"><?= lang('Config.login_form'); ?></label>
        <div class="input-group mb-3">
            <span class="input-group-text"><i class="bi bi-view-stacked"></i></span>
            <select class="form-select" name="login_form" id="login_form">
                <option value="floating_labels" <?= $config['login_form'] == 'floating_labels' ? 'selected' : '' ?>><?= lang('Config.floating_labels') ?></option>
                <option value="input_groups" <?= $config['login_form'] == 'input_groups' ? 'selected' : '' ?>><?= lang('Config.input_groups') ?></option>
            </select>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <label for="color_mode" class="form-label">Color Mode <?= $beta; ?></label>
        <div class="input-group mb-3">
            <span class="input-group-text" id="color-mode-icon"><i class="bi bi-palette"></i></span>
            <select class="form-select" id="color_mode" name="color_mode" aria-describedby="color-mode-icon">
                <option value="system" <?= ($config['color_mode'] ?? 'light') == 'system' ? 'selected' : '' ?>>System</option>
                <option value="light" <?= ($config['color_mode'] ?? 'light') == 'light' ? 'selected' : '' ?>>Light</option>
                <option value="dark" <?= ($config['color_mode'] ?? 'light') == 'dark' ? 'selected' : '' ?>>Dark</option>
            </select>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <label for="notify_position" class="form-label"><?= lang('Config.notify_alignment'); ?></label>
        <div class="row" id="notify_position">
            <div class="col-6 mb-3">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-arrow-down-up"></i></span>
                    <select class="form-select" name="notify_vertical_position">
                        <option value="top" <?= $config['notify_vertical_position'] == 'top' ? 'selected' : '' ?>><?= lang('Config.top') ?></option>
                        <option value="bottom" <?= $config['notify_vertical_position'] == 'bottom' ? 'selected' : '' ?>><?= lang('Config.bottom') ?></option>
                    </select>
                </div>
            </div>
            <div class="col-6 mb-3">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-arrow-left-right"></i></span>
                    <select class="form-select" name="notify_horizontal_position">
                        <option value="left" <?= $config['notify_horizontal_position'] == 'left' ? 'selected' : '' ?>><?= lang('Config.left') ?></option>
                        <option value="center" <?= $config['notify_horizontal_position'] == 'center' ? 'selected' : '' ?>><?= lang('Config.center') ?></option>
                        <option value="right" <?= $config['notify_horizontal_position'] == 'right' ? 'selected' : '' ?>><?= lang('Config.right') ?></option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <label for="config_menu_position" class="form-label">Configuration Menu Position</label>
        <div class="input-group mb-3">
            <span class="input-group-text" id="config-menu-position-icon"><i class="bi bi-distribute-horizontal"></i></span>
            <select class="form-select" id="config_menu_position" name="config_menu_position" aria-describedby="config-menu-position-icon">
                <option value="start" <?= $config['config_menu_position'] == 'start' ? 'selected' : '' ?>>Start</option>
                <option value="end" <?= $config['config_menu_position'] == 'end' ? 'selected' : '' ?>>End</option>
            </select>
        </div>
    </div>
</div>

<hr class="my-4">

<h5 class="mb-3">Layout & Styling Options</h5>

<div class="row">
    <div class="col-12 col-md-6 col-lg-4 mb-3">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" id="theme_rounded" name="theme_rounded" value="1" <?= ($config['theme_rounded'] ?? 1) == 1 ? 'checked' : '' ?>>
            <label class="form-check-label" for="theme_rounded">Enable Rounded Corners ($enable-rounded)</label>
        </div>
    </div>

    <div class="col-12 col-md-6 col-lg-4 mb-3">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" id="theme_shadows" name="theme_shadows" value="1" <?= ($config['theme_shadows'] ?? 0) == 1 ? 'checked' : '' ?>>
            <label class="form-check-label" for="theme_shadows">Enable Box Shadows ($enable-shadows)</label>
        </div>
    </div>

    <div class="col-12 col-md-6 col-lg-4 mb-3">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" id="theme_gradients" name="theme_gradients" value="1" <?= ($config['theme_gradients'] ?? 0) == 1 ? 'checked' : '' ?>>
            <label class="form-check-label" for="theme_gradients">Enable Gradients ($enable-gradients)</label>
        </div>
    </div>

    <div class="col-12 col-md-6 col-lg-4 mb-3">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" id="theme_compact_tables" name="theme_compact_tables" value="1" <?= ($config['theme_compact_tables'] ?? 0) == 1 ? 'checked' : '' ?>>
            <label class="form-check-label" for="theme_compact_tables">Compact Tables (table-sm)</label>
        </div>
    </div>

    <div class="col-12 col-md-6 col-lg-4 mb-3">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" id="theme_compact_elements" name="theme_compact_elements" value="1" <?= ($config['theme_compact_elements'] ?? 0) == 1 ? 'checked' : '' ?>>
            <label class="form-check-label" for="theme_compact_elements">Small Elements (button-sm, input-sm)</label>
        </div>
    </div>

    <div class="col-12 col-md-6 col-lg-4 mb-3">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" id="responsive_design" name="responsive_design" value="responsive_design" <?= ($config['responsive_design'] ?? 1) == 1 ? 'checked' : '' ?>>
            <label class="form-check-label" for="responsive_design">Responsive Design <?= $beta; ?></label>
        </div>
    </div>
</div>

<div class="d-flex justify-content-end">
    <button type="submit" class="btn btn-primary" name="submit_appearance"><?= lang('Common.submit'); ?></button>
</div>

<?= form_close() ?>

<script type="application/javascript">
    // Validation and submit handling
    $(document).ready(function() {
        $('#appearance_config_form').validate($.extend(form_support.handler, {
            submitHandler: function(form) {
                $(form).ajaxSubmit({
                    success: function(response) {
                        $.notify({
                            icon: 'bi bi-bell-fill',
                            message: response.message + '&nbsp;<em>Click to refresh.</em>',
                            url: 'javascript:window.location.reload();',
                            target: '_self'
                        }, {
                            type: response.success ? 'success' : 'danger'
                        })
                    },
                    dataType: 'json'
                });
            },

            errorLabelContainer: '.appearance_error_message_box'
        }));
    });
</script>
