<?php
/**
 * @var bool $logo_exists
 * @var string $controller_name
 * @var array $config
 */
?>

<h4 style="margin-top: 0;"><strong><i class="bi-shop icon-spacing"></i><?= lang('Config.info_configuration'); ?></strong></h4>
<hr style="margin-top: 0;">

<form action="<?= site_url('config/saveInfo/') ?>" method="post" id="config_form_info" enctype="multipart/form-data">

    <div class="form-group">
        <div id="error_alert_info" class="alert alert-warning d-none" style="padding-left: 2em;"></div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group has-feedback">
                <label for="company"><?= lang('Config.company') ?></label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="bi-shop-window"></i></span>
                    <input type="text" name="company" id="company" class="form-control" value="<?= $config['company'] ?>" placeholder="Open Source Point of Sale" required>
                </div>
                <span class="bi-asterisk text-warning form-control-feedback"></span>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group has-feedback">
                <label for="company_logo"><?= lang('Config.company_logo') ?></label>
                <div class="fileinput <?= $logo_exists ? 'fileinput-exists' : 'fileinput-new' ?>" data-provides="fileinput" style="width: 100%;">
                    <div class="thumbnail fileinput-new" style="width: 100%; height: 200px;"></div>
                    <div class="thumbnail fileinput-exists fileinput-preview" style="width: 100%; max-height: 200px;">
                        <img data-src="holder.js/100%x100%" alt="<?= lang('Config.company_logo') ?>"
                                src="<?php if($logo_exists) echo base_url('uploads/' . $config['company_logo']); else echo '' ?>"
                                style="max-height: 100%; max-width: 100%;">
                    </div>
                    <div>
                        <button class="btn btn-default btn-file">
                            <span class="fileinput-new"><i class="bi-hand-index icon-spacing"></i><?= lang('Config.company_select_image') ?></span>
                            <span class="fileinput-exists"><i class="bi-images icon-spacing"></i><?= lang('Config.company_change_image') ?></span>
                            <input type="file" name="company_logo">
                        </button>
                        <button class="btn btn-default fileinput-exists" data-dismiss="fileinput">
                            <i class="bi-eraser icon-spacing"></i><?= lang('Config.company_remove_image') ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group has-feedback">
                <label for="address"><?= lang('Config.address') ?></label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="bi-geo-alt"></i></span>
                    <textarea name="address" id="address" class="form-control" style="resize: vertical; min-height: 2.5em;" rows="6" placeholder="123 Main Street &#10;Springfield, IL &#10;62701" required><?= $config['address'] ?></textarea>
                </div>
                <span class="bi-asterisk text-warning form-control-feedback"></span>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="website"><?= lang('Config.website') ?></label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="bi-globe"></i></span>
                    <input type="text" name="website" id="website" class="form-control" value="<?= $config['website'] ?>" placeholder="https://example.com">
                    <!-- Didn't use type="url" because of the strictness of it -->
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="email"><?= lang('Config.email') ?></label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="bi-envelope"></i></span>
                    <input type="email" name="email" id="email" class="form-control" value="<?= $config['email'] ?>" placeholder="example@example.com">
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group has-feedback">
                <label for="phone"><?= lang('Config.phone') ?></label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="bi-telephone"></i></span>
                    <input type="tel" name="phone" id="phone" class="form-control" value="<?= $config['phone'] ?>" placeholder="(123) 456-7890" required>
                </div>
                <span class="bi-asterisk text-warning form-control-feedback"></span>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="fax"><?= lang('Config.fax') ?></label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="bi-printer"></i></span>
                    <input type="tel" name="fax" id="fax" class="form-control" value="<?= $config['fax'] ?>" placeholder="(123) 456-7890">
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group has-feedback">
                <label for="return_policy"><?= lang('Common.return_policy') ?></label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="bi-box-arrow-in-down-left"></i></span>
                    <textarea name="return_policy" id="return_policy" class="form-control" style="resize: vertical; min-height: 2.5em;" rows="10" placeholder="Return within x days with receipt" required><?= $config['return_policy'] ?></textarea>
                </div>
                <span class="bi-asterisk text-warning form-control-feedback"></span>
            </div>
        </div>
    </div>

    <div class="form-group text-right">
        <button type="submit" name="submit_info" id="submit_info" class="btn btn-primary">
            <i class="bi-check-lg icon-spacing"></i><?= lang('Common.submit') ?>
        </button>
    </div>

</form>

<script type="application/javascript">
//validation and submit handling
$(document).ready(function()
{
    $("a.fileinput-exists").click(function() {
        $.ajax({
            type: 'POST',
            url: '<?= "$controller_name/removeLogo"; ?>',
            dataType: 'json'
        })
    });

    $('#config_form_info').validate($.extend(form_support.handler, {

        errorLabelContainer: "#error_alert_info",
        errorElement: "div",

        rules:
        {
            company: "required",
            address: "required",
            phone: "required",
            email: "email",
            return_policy: "required"
           },

        messages:
        {
            company: "<?= lang('Config.company_required') ?>",
            address: "<?= lang('Config.address_required') ?>",
            phone: "<?= lang('Config.phone_required') ?>",
            email: "<?= lang('Common.email_invalid_format') ?>",
            return_policy: "<?= lang('Config.return_policy_required') ?>"
        }
    }));
});
</script>
