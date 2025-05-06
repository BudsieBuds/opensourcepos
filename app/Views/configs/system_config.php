<br>

<ul class="nav nav-tabs">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="system-tabs" data-bs-toggle="tab" data-bs-target="#system_tabs" title="<?= lang('Config.system_conf') ?>"><?= lang('Config.system_conf') ?></button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="email-tabs" data-bs-toggle="tab" data-bs-target="#email_tabs" title="<?= lang('Config.email_configuration') ?>"><?= lang('Config.email') ?></button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="message-tabs" data-bs-toggle="tab" data-bs-target="#message_tabs" title="<?= lang('Config.message_configuration') ?>"><?= lang('Config.message') ?></button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="integrations-tabs" data-bs-toggle="tab" data-bs-target="#integrations_tabs" title="<?= lang('Config.integrations_configuration') ?>"><?= lang('Config.integrations') ?></button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="license-tabs" data-bs-toggle="tab" data-bs-target="#license_tabs" title="<?= lang('Config.license_configuration') ?>"><?= lang('Config.license') ?></button>
    </li>
</ul>

<div class="tab-content">
    <div class="tab-pane active" id="system_tabs" role="tabpanel" aria-labelledby="system-tabs" tabindex="0">
        <?= view('configs/system_info') ?>
    </div>
    <div class="tab-pane" id="email_tabs" role="tabpanel" aria-labelledby="email-tabs" tabindex="0">
        <?= view('configs/email_config') ?>
    </div>
    <div class="tab-pane" id="message_tabs" role="tabpanel" aria-labelledby="message-tabs" tabindex="0">
        <?= view('configs/message_config') ?>
    </div>
    <div class="tab-pane" id="integrations_tabs" role="tabpanel" aria-labelledby="integrations-tabs" tabindex="0">
        <?= view('configs/integrations_config') ?>
    </div>
    <div class="tab-pane" id="license_tabs" role="tabpanel" aria-labelledby="license-tabs" tabindex="0">
        <?= view('configs/license_config') ?>
    </div>
</div>
