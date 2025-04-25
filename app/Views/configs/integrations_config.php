<?php
/**
 * @var array $mailchimp
 * @var string $controller_name
 */
?>

<h4 style="margin-top: 0;"><strong><i class="bi-share icon-spacing"></i><?= lang('Config.integrations_configuration'); ?></strong></h4>
<hr style="margin-top: 0;">

<form action="<?= site_url('config/saveMailchimp/') ?>" method="post" id="config_form_integrations" enctype="multipart/form-data">

    <div class="form-group">
        <div id="error_alert_integrations" class="alert alert-warning d-none" style="padding-left: 2em;"></div>
    </div>

    <legend><h5><strong><?= lang('Config.mailchimp_configuration') ?></strong></h5></legend>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="mailchimp_api_key"><?= lang('Config.mailchimp_api_key') ?></label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="bi-key"></i></span>
                    <input type="text" name="mailchimp_api_key" id="mailchimp_api_key" class="form-control" value="<?= $mailchimp['api_key'] ?>">
                </div>
                <a class="help-block" href="https://eepurl.com/dyijVH" target="_blank" rel="noopener">
                    <i class="bi-info-square icon-spacing"></i><?= lang('Config.mailchimp_tooltip') ?>
                </a>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="mailchimp_list_id"><?= lang('Config.mailchimp_lists') ?></label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="bi-list"></i></span>
                    <select name="mailchimp_list_id" id="mailchimp_list_id" class="form-control" <?= $mailchimp['api_key'] == null ? 'disabled' : '' ?>>
                        <?php foreach ($mailchimp['lists'] as $list_id => $list_name): ?>
                            <option value="<?= $list_id ?>" <?= $list_id == $mailchimp['list_id'] ? 'selected' : '' ?>><?= $list_name ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group text-right">
        <button type="submit" name="submit_mailchimp" id="submit_mailchimp" class="btn btn-primary">
            <i class="bi-check-lg icon-spacing"></i><?= lang('Common.submit') ?>
        </button>
    </div>

</form>

<script type="application/javascript">
//validation and submit handling
$(document).ready(function()
{
    $('#mailchimp_api_key').change(function() {
        $.post("<?= "$controller_name/checkMailchimpApiKey" ?>", {
                'mailchimp_api_key': $('#mailchimp_api_key').val()
            },
            function(response) {
                $.notify({message: response.message}, {type: response.success ? 'success' : 'danger'} );
                $('#mailchimp_list_id').empty();
                $.each(response.mailchimp_lists, function(val, text) {
                    $('#mailchimp_list_id').append(new Option(text, val));
                });
                $('#mailchimp_list_id').prop('selectedIndex', 0);
            },
            'json'
        );
    });

    $('#config_form_integrations').validate($.extend(form_support.handler, {
        submitHandler: function(form) {
            $(form).ajaxSubmit({
                success: function(response) {
                    $.notify( { message: response.message }, { type: response.success ? 'success' : 'danger'} )
                },
                dataType: 'json'
            });
        },

        errorLabelContainer: '#error_alert_integrations'
    }));
});
</script>
