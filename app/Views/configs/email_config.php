<?php
/**
 * @var array $config
 */
?>

<h4 style="margin-top: 0;"><strong><i class="bi-envelope icon-spacing"></i><?= lang('Config.email_configuration'); ?></strong></h4>
<hr style="margin-top: 0;">

<form action="<?= site_url('config/saveEmail/') ?>" method="post" id="config_form_email" enctype="multipart/form-data">

    <div class="form-group">
        <div id="error_alert_email" class="alert alert-warning d-none" style="padding-left: 2em;"></div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="protocol"><?= lang('Config.email_protocol') ?></label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="bi-mailbox"></i></span>
                    <select class="form-control" id="protocol" name="protocol">
                        <option value="mail" <?= $config['protocol'] == 'mail' ? 'selected' : ''; ?>>Mail</option>
                        <option value="sendmail" <?= $config['protocol'] == 'sendmail' ? 'selected' : ''; ?>>Sendmail</option>
                        <option value="smtp" <?= $config['protocol'] == 'smtp' ? 'selected' : ''; ?>>SMTP</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="mailpath"><?= lang('Config.email_mailpath') ?></label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="bi-braces"></i></span>
                    <input type="text" name="mailpath" id="mailpath" class="form-control" value="<?= $config['mailpath'] ?>">
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="smtp_host"><?= lang('Config.email_smtp_host') ?></label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="bi-database"></i></span>
                    <input type="text" name="smtp_host" id="smtp_host" class="form-control" value="<?= $config['smtp_host'] ?>">
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="smtp_port"><?= lang('Config.email_smtp_port') ?></label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="bi-door-open"></i></span>
                    <input type="number" name="smtp_port" id="smtp_port" class="form-control" value="<?= $config['smtp_port'] ?>">
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="smtp_crypto"><?= lang('Config.email_smtp_crypto') ?></label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="bi-shield-lock"></i></span>
                    <select class="form-control" id="smtp_crypto" name="smtp_crypto">
                        <option value="" <?= $config['smtp_crypto'] == '' ? 'selected' : ''; ?>>None</option>
                        <option value="tls" <?= $config['smtp_crypto'] == 'tls' ? 'selected' : ''; ?>>TLS</option>
                        <option value="ssl" <?= $config['smtp_crypto'] == 'ssl' ? 'selected' : ''; ?>>SSL</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="smtp_timeout"><?= lang('Config.email_smtp_timeout') ?></label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="bi-stopwatch"></i></span>
                    <input type="number" name="smtp_timeout" id="smtp_timeout" class="form-control" value="<?= $config['smtp_timeout'] ?>">
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="smtp_user"><?= lang('Config.email_smtp_user') ?></label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="bi-person"></i></span>
                    <input type="text" name="smtp_user" id="smtp_user" class="form-control" value="<?= $config['smtp_user'] ?>">
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="smtp_pass"><?= lang('Config.email_smtp_pass') ?></label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="bi-lock"></i></span>
                    <input type="password" name="smtp_pass" id="smtp_pass" class="form-control" value="<?= $config['smtp_pass'] ?>">
                </div>
            </div>
        </div>
    </div>

    <div class="form-group text-right">
        <button type="submit" name="submit_email" id="submit_email" class="btn btn-primary">
            <i class="bi-check-lg icon-spacing"></i><?= lang('Common.submit') ?>
        </button>
    </div>

</form>

<script type="application/javascript">
//validation and submit handling
$(document).ready(function()
{
    var check_protocol = function() {
        if($('#protocol').val() == 'sendmail')
        {
            $('#mailpath').prop('disabled', false);
            $('#smtp_host, #smtp_user, #smtp_pass, #smtp_port, #smtp_timeout, #smtp_crypto').prop('disabled', true);
        }
        else if($('#protocol').val() == 'smtp')
        {
            $('#smtp_host, #smtp_user, #smtp_pass, #smtp_port, #smtp_timeout, #smtp_crypto').prop('disabled', false);
            $('#mailpath').prop('disabled', true);
        }
        else
        {
            $('#mailpath, #smtp_host, #smtp_user, #smtp_pass, #smtp_port, #smtp_timeout, #smtp_crypto').prop('disabled', true);
        }
    };

    $('#protocol').change(check_protocol).ready(check_protocol);

    $('#config_form_email').validate($.extend(form_support.handler, {
        submitHandler: function(form) {
            $(form).ajaxSubmit({
                beforeSerialize: function(arr, $form, options) {
                    $('#mailpath, #smtp_host, #smtp_user, #smtp_pass, #smtp_port, #smtp_timeout, #smtp_crypto').prop('disabled', false);
                    return true;
                },
                success: function(response) {
                    $.notify( { message: response.message }, { type: response.success ? 'success' : 'danger'} )
                    // set back disabled state
                    check_protocol();
                },
                dataType: 'json'
            });
        },

        errorLabelContainer: '#error_alert_email'
    }));
});
</script>
