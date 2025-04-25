<?php
/**
 * @var array $config
 */
?>

<h4 style="margin-top: 0;"><strong><i class="bi-chat icon-spacing"></i><?= lang('Config.message_configuration'); ?></strong></h4>
<hr style="margin-top: 0;">

<form action="<?= site_url('config/saveMessage/') ?>" method="post" id="config_form_message" enctype="multipart/form-data">

    <div class="form-group">
        <div id="error_alert_message" class="alert alert-warning d-none" style="padding-left: 2em;"></div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group has-feedback">
                <label for="msg_uid"><?= lang('Config.msg_uid') ?></label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="bi-person"></i></span>
                    <input type="text" name="msg_uid" id="msg_uid" class="form-control" value="<?= $config['msg_uid'] ?>" required>
                </div>
                <span class="bi-asterisk text-warning form-control-feedback"></span>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group has-feedback">
                <label for="msg_pwd"><?= lang('Config.msg_pwd') ?></label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="bi-lock"></i></span>
                    <input type="password" name="msg_pwd" id="msg_pwd" class="form-control" value="<?= $config['msg_pwd'] ?>" required>
                </div>
                <span class="bi-asterisk text-warning form-control-feedback"></span>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group has-feedback">
                <label for="msg_src"><?= lang('Config.msg_src') ?></label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="bi-megaphone"></i></span>
                    <input type="text" name="msg_src" id="msg_src" class="form-control" value="<?= $config['msg_src'] ?? $config['company'] ?>" required>
                </div>
                <span class="bi-asterisk text-warning form-control-feedback"></span>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="form-group">
                <label for="msg_msg"><?= lang('Config.msg_msg') ?></label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="bi-chat-quote"></i></span>
                    <textarea name="msg_msg" id="msg_msg" class="form-control" style="resize: vertical; min-height: 2.5em;" rows="10" placeholder="<?= lang('Config.msg_msg_placeholder') ?>"><?= $config['msg_msg'] ?></textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group text-right">
        <button type="submit" name="submit_message" id="submit_message" class="btn btn-primary">
            <i class="bi-check-lg icon-spacing"></i><?= lang('Common.submit') ?>
        </button>
    </div>

</form>

<script type="application/javascript">
//validation and submit handling
$(document).ready(function() {
    $('#config_form_message').validate($.extend(form_support.handler, {

        errorLabelContainer: "#error_alert_message",
        errorElement: "div",

        rules: {
            msg_uid: "required",
            msg_pwd: "required",
            msg_src: "required"
           },

        messages: {
            msg_uid: "<?= lang('Config.msg_uid_required') ?>",
            msg_pwd: "<?= lang('Config.msg_pwd_required') ?>",
            msg_src: "<?= lang('Config.msg_src_required') ?>"
        },
    }));
});
</script>
