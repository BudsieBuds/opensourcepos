<?= view('partial/header') ?>

<ul class="nav nav-tabs">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info_tab" title="<?= lang('Config.info_configuration') ?>"><?= lang('Config.info') ?></button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="general-tab" data-bs-toggle="tab" data-bs-target="#general_tab" title="<?= lang('Config.general_configuration') ?>"><?= lang('Config.general') ?></button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="tax-tab" data-bs-toggle="tab" data-bs-target="#tax_tab" title="<?= lang('Config.tax_configuration') ?>"><?= lang('Config.tax') ?></button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="locale-tab" data-bs-toggle="tab" data-bs-target="#locale_tab" title="<?= lang('Config.locale_configuration') ?>"><?= lang('Config.locale') ?></button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="barcode-tab" data-bs-toggle="tab" data-bs-target="#barcode_tab" title="<?= lang('Config.barcode_configuration') ?>"><?= lang('Config.barcode') ?></button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="stock-tab" data-bs-toggle="tab" data-bs-target="#stock_tab" title="<?= lang('Config.location_configuration') ?>"><?= lang('Config.location') ?></button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="receipt-tab" data-bs-toggle="tab" data-bs-target="#receipt_tab" title="<?= lang('Config.receipt_configuration') ?>"><?= lang('Config.receipt') ?></button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="invoice-tab" data-bs-toggle="tab" data-bs-target="#invoice_tab" title="<?= lang('Config.invoice_configuration') ?>"><?= lang('Config.invoice') ?></button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="reward-tab" data-bs-toggle="tab" data-bs-target="#reward_tab" title="<?= lang('Config.reward_configuration') ?>"><?= lang('Config.reward') ?></button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="table-tab" data-bs-toggle="tab" data-bs-target="#table_tab" title="<?= lang('Config.table_configuration') ?>"><?= lang('Config.table') ?></button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="system-tab" data-bs-toggle="tab" data-bs-target="#system_tab" title="<?= lang('Config.system_conf') ?>"><?= lang('Config.system_conf') ?></button>
    </li>
</ul>

<div class="tab-content">
    <div class="tab-pane active" id="info_tab" role="tabpanel" aria-labelledby="info-tab" tabindex="0">
        <?= view('configs/info_config') ?>
    </div>
    <div class="tab-pane" id="general_tab" role="tabpanel" aria-labelledby="general-tab" tabindex="0">
        <?= view('configs/general_config') ?>
    </div>
    <div class="tab-pane" id="tax_tab" role="tabpanel" aria-labelledby="tax-tab" tabindex="0">
        <?= view('configs/tax_config') ?>
    </div>
    <div class="tab-pane" id="locale_tab" role="tabpanel" aria-labelledby="locale-tab" tabindex="0">
        <?= view('configs/locale_config') ?>
    </div>
    <div class="tab-pane" id="barcode_tab" role="tabpanel" aria-labelledby="barcode-tab" tabindex="0">
        <?= view('configs/barcode_config') ?>
    </div>
    <div class="tab-pane" id="stock_tab" role="tabpanel" aria-labelledby="stock-tab" tabindex="0">
        <?= view('configs/stock_config') ?>
    </div>
    <div class="tab-pane" id="receipt_tab" role="tabpanel" aria-labelledby="receipt-tab" tabindex="0">
        <?= view('configs/receipt_config') ?>
    </div>
    <div class="tab-pane" id="invoice_tab" role="tabpanel" aria-labelledby="invoice-tab" tabindex="0">
        <?= view('configs/invoice_config') ?>
    </div>
    <div class="tab-pane" id="reward_tab" role="tabpanel" aria-labelledby="reward-tab" tabindex="0">
        <?= view('configs/reward_config') ?>
    </div>
    <div class="tab-pane" id="table_tab" role="tabpanel" aria-labelledby="table-tab" tabindex="0">
        <?= view('configs/table_config') ?>
    </div>
    <div class="tab-pane" id="system_tab" role="tabpanel" aria-labelledby="system-tab" tabindex="0">
        <?= view('configs/system_config') ?>
    </div>
</div>

<?= view('partial/footer') ?>
