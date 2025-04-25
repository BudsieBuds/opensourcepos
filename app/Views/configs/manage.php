<?= view('partial/header') ?>

<script type="application/javascript">
    dialog_support.init("a.modal-dlg");

    $(document).ready(function() {
        // Function to activate a tab based on the hash in the URL
        function activateTabFromHash() {
            if (location.hash) {
                const hash = location.hash.substring(1); // Get the part after #
                const currentTab = $('#config_select a[href="#' + hash + '"]');
                if (currentTab.length) {
                    // Remove 'active' class from all tabs and tab content
                    $('#config_select a').removeClass('active');
                    $('.tab-pane').removeClass('active');

                    // Add 'active' class to the clicked tab and corresponding content
                    currentTab.addClass('active');
                    $('#' + hash).addClass('active');

                    // Show the tab content (Bootstrap 3 method)
                    currentTab.tab('show');
                }
            } else {
                // If no hash, manually activate the first tab
                $('#config_select a:first').tab('show');
                $('#config_select a:first').addClass('active');
                $('.tab-pane:first').addClass('active');
            }
        }

        // Call the function to activate the tab on page load
        activateTabFromHash();

        // Listen for URL hash changes (for manual URL changes in address bar)
        $(window).on('hashchange', function() {
            activateTabFromHash(); // Re-activate tab based on the new hash
        });

        // Change URL and add 'active' class based on selected tab
        $('#config_select a[data-toggle="tab"]').on('click', function (e) {
            e.preventDefault(); // Prevent the default link behavior

            const target = $(this).attr('href').substring(1); // Get the tab ID from href (without '#')

            // Remove active class from all tabs and tab content
            $('#config_select a').removeClass('active');
            $('.tab-pane').removeClass('active');

            // Add active class to the clicked tab and corresponding content
            $(this).addClass('active');
            $('#' + target).addClass('active');

            // Update the URL with the clicked tab's hash (deep linking)
            const newUrl = location.origin + location.pathname + '#' + target;
            history.pushState(null, null, newUrl); // Update the hash without refreshing the page

            // Show the tab content (Bootstrap 3 method)
            $(this).tab('show');
        });
    });
</script>

<div class="list-group col-xs-5 col-sm-4 col-md-3 <?= $config['config_menu_position'] == 'start' ? '' : 'col-md-push-9' ?>" id="config_select">
    <a data-toggle="tab" class="list-group-item" href="#information" title="<?= lang('Config.info_configuration') ?>">
        <i class="bi-shop icon-spacing"></i><?= lang('Config.info') ?>
    </a>
    <a data-toggle="tab" class="list-group-item" href="#general" title="<?= lang('Config.general_configuration') ?>">
        <i class="bi-sliders icon-spacing"></i><?= lang('Config.general') ?>
    </a>
    <a data-toggle="tab" class="list-group-item" href="#appearance" title="...">
        <i class="bi-eye icon-spacing"></i>Appearance
    </a>
    <a data-toggle="tab" class="list-group-item" href="#localization" title="<?= lang('Config.locale_configuration') ?>">
        <i class="bi-translate icon-spacing"></i><?= lang('Config.locale') ?>
    </a>
    <a data-toggle="tab" class="list-group-item" href="#tax" title="<?= lang('Config.tax_configuration') ?>">
        <i class="bi-piggy-bank icon-spacing"></i><?= lang('Config.tax') ?>
    </a>
    <a data-toggle="tab" class="list-group-item" href="#barcode" title="<?= lang('Config.barcode_configuration') ?>">
        <i class="bi-upc-scan icon-spacing"></i><?= lang('Config.barcode') ?>
    </a>
    <a data-toggle="tab" class="list-group-item" href="#stock" title="<?= lang('Config.location_configuration') ?>">
        <i class="bi-truck icon-spacing"></i><?= lang('Config.location') ?>
    </a>
    <a data-toggle="tab" class="list-group-item" href="#receipt" title="<?= lang('Config.receipt_configuration') ?>">
        <i class="bi-receipt icon-spacing"></i><?= lang('Config.receipt') ?>
    </a>
    <a data-toggle="tab" class="list-group-item" href="#invoice" title="<?= lang('Config.invoice_configuration') ?>">
        <i class="bi-file-text icon-spacing"></i><?= lang('Config.invoice') ?>
    </a>
    <a data-toggle="tab" class="list-group-item" href="#reward" title="<?= lang('Config.reward_configuration') ?>">
        <i class="bi-trophy icon-spacing"></i><?= lang('Config.reward') ?>
    </a>
    <a data-toggle="tab" class="list-group-item" href="#table" title="<?= lang('Config.table_configuration') ?>">
        <i class="bi-cup-straw icon-spacing"></i><?= lang('Config.table') ?>
    </a>
    <a data-toggle="tab" class="list-group-item" href="#e-mail" title="<?= lang('Config.email_configuration') ?>">
        <i class="bi-envelope icon-spacing"></i><?= lang('Config.email') ?>
    </a>
    <a data-toggle="tab" class="list-group-item" href="#message" title="<?= lang('Config.message_configuration') ?>">
        <i class="bi-chat icon-spacing"></i><?= lang('Config.message') ?>
    </a>
    <a data-toggle="tab" class="list-group-item" href="#integrations" title="<?= lang('Config.integrations_configuration') ?>">
        <i class="bi-share icon-spacing"></i><?= lang('Config.integrations') ?>
    </a>
    <a data-toggle="tab" class="list-group-item" href="#system" title="<?= lang('Config.system_info') ?>">
        <i class="bi-info-circle icon-spacing"></i><?= lang('Config.system_info') ?>
    </a>
    <a data-toggle="tab" class="list-group-item" href="#license" title="<?= lang('Config.license_configuration') ?>">
        <i class="bi-journal-check icon-spacing"></i><?= lang('Config.license') ?>
    </a>
</div>

<div class="tab-content col-xs-7 col-sm-8 col-md-9 <?= $config['config_menu_position'] == 'start' ? '' : 'col-md-pull-3' ?>">
    <div class="tab-pane" id="information"><?= view('configs/info_config') ?></div>
    <div class="tab-pane" id="general"><?= view('configs/general_config') ?></div>
    <div class="tab-pane" id="appearance"><?= view('configs/appearance_config') ?></div>
    <div class="tab-pane" id="localization"><?= view('configs/locale_config') ?></div>
    <div class="tab-pane" id="tax"><?= view('configs/tax_config') ?></div>
    <div class="tab-pane" id="barcode"><?= view('configs/barcode_config') ?></div>
    <div class="tab-pane" id="stock"><?= view('configs/stock_config') ?></div>
    <div class="tab-pane" id="receipt"><?= view('configs/receipt_config') ?></div>
    <div class="tab-pane" id="invoice"><?= view('configs/invoice_config') ?></div>
    <div class="tab-pane" id="reward"><?= view('configs/reward_config') ?></div>
    <div class="tab-pane" id="table"><?= view('configs/table_config') ?></div>
    <div class="tab-pane" id="e-mail"><?= view('configs/email_config') ?></div>
    <div class="tab-pane" id="message"><?= view('configs/message_config') ?></div>
    <div class="tab-pane" id="integrations"><?= view('configs/integrations_config') ?></div>
    <div class="tab-pane" id="system"><?= view('configs/system_info') ?></div>
    <div class="tab-pane" id="license"><?= view('configs/license_config') ?></div>
</div>

<?= view('partial/footer') ?>
