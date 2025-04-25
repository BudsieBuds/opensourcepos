<?php

use Config\OSPOS;

/**
 * @var string $dbVersion
 * @var array $config
 */

$logs = WRITEPATH . 'logs/';
$uploads = FCPATH . 'uploads/';
$images = FCPATH . 'uploads/item_pics/';
$importCustomers = WRITEPATH . '/uploads/importCustomers.csv';
$bullet = '&raquo;' . '&nbsp;';
$divider = ' &middot;' . '&nbsp;';
$enabled = '<span class="text-success">&#10003; Enabled</span>';
$disabled = '<span class="text-danger">&#10007; Disabled</span>';

/**
 * @param string $userAgent
 * @return string
 */
function getBrowserNameAndVersion(string $userAgent): string {
    $browser = match (true) {
        strpos($userAgent, 'Opera') !== false || strpos($userAgent, 'OPR/') !== false => 'Opera',
        strpos($userAgent, 'Edge') !== false => 'Edge',
        strpos($userAgent, 'Chrome') !== false => 'Chrome',
        strpos($userAgent, 'Safari') !== false => 'Safari',
        strpos($userAgent, 'Firefox') !== false => 'Firefox',
        strpos($userAgent, 'MSIE') !== false || strpos($userAgent, 'Trident/7') !== false => 'Internet Explorer',
        default => 'Other',
    };

    $version = match ($browser) {
        'Opera' => preg_match('/(Opera|OPR)\/([0-9.]+)/', $userAgent, $matches) ? $matches[2] : '',
        'Edge' => preg_match('/Edge\/([0-9.]+)/', $userAgent, $matches) ? $matches[1] : '',
        'Chrome' => preg_match('/Chrome\/([0-9.]+)/', $userAgent, $matches) ? $matches[1] : '',
        'Safari' => preg_match('/Version\/([0-9.]+)/', $userAgent, $matches) ? $matches[1] : '',
        'Firefox' => preg_match('/Firefox\/([0-9.]+)/', $userAgent, $matches) ? $matches[1] : '',
        'Internet Explorer' => preg_match('/(MSIE|rv:)([0-9.]+)/', $userAgent, $matches) ? $matches[2] : '',
        default => '',
    };

    return $browser . ($version ? ' ' . $version : '');
}

function checkPermission($path, $expectedPermissions = null) {
    $filePerm = substr(sprintf("%o", fileperms($path)), -4);
    $isWritable = is_writable($path) ? '<span class="text-success">&#10003; Writable</span>' : '<span class="text-danger">&#10007; Not Writable</span>';
    $isReadable = is_readable($path) ? '<span class="text-success">&#10003; Readable</span>' : '<span class="text-danger">&#10007; Not Readable</span>';
    $status = ($expectedPermissions && $filePerm != $expectedPermissions) ? '<span class="text-danger">&#10007; Vulnerable or Incorrect Permissions</span>' : '<span class="text-success">&#10003; Security Check Passed</span>';

    return [
        'filePerm' => $filePerm,
        'isWritable' => $isWritable,
        'isReadable' => $isReadable,
        'status' => $status
    ];
}

function generatePermissionAlert($logs, $uploads, $images, $importCustomers) {
    $alerts = [];
    if (substr(decoct(fileperms($logs)), -4) != 750) {
        $alerts[] = '<li>&raquo;&nbsp;<code>[writable/logs]</code> ' . lang('Config.is_writable') . '</li>';
    }
    if (substr(decoct(fileperms($uploads)), -4) != 750) {
        $alerts[] = '<li>&raquo;&nbsp;<code>[writable/uploads]</code> ' . lang('Config.is_writable') . '</li>';
    }
    if (substr(decoct(fileperms($images)), -4) != 750) {
        $alerts[] = '<li>&raquo;&nbsp;<code>[writable/uploads/item_pics]</code> ' . lang('Config.is_writable') . '</li>';
    }
    if (!(substr(decoct(fileperms($importCustomers)), -4) == 640 || substr(decoct(fileperms($importCustomers)), -4) == 660)) {
        $alerts[] = '<li>&raquo;&nbsp;<code>[importCustomers.csv]</code> ' . lang('Config.is_readable') . '</li>';
    }

    if (!empty($alerts)) {
        return '<div class="alert alert-danger" role="alert">
                    <label><i class="bi-exclamation-circle icon-spacing"></i>' . lang('Config.security_issue') . '</label>
                    <p>' . lang('Config.perm_risk') . '</p>
                    <ul class="list-unstyled">' . implode('', $alerts) . '</ul>
                </div>';
    }
    return '';
}
?>

<script type="application/javascript" src="js/clipboard.min.js"></script>

<h4 style="margin-top: 0;"><strong><i class="bi-info-circle icon-spacing"></i><?= lang('Config.system_info'); ?></strong></h4>
<hr style="margin-top: 0;">

<p><?= lang('Config.server_notice') ?></p>

<form id="copy-issue">

    <div class="row">
        <label for="general-info" class="col-xs-12 col-lg-2">General Info</label>
        <div id="general-info" class="col-xs-12 col-lg-10">
            <div><?= lang('Config.ospos_info') . ':&nbsp;' . esc(config('App')->application_version) . '&nbsp;-&nbsp;' . esc(substr(config(OSPOS::class)->commit_sha1, 0, 6)); ?></div>
            <div>Language Code: <?= current_language_code(); ?></div><br>
            <div id="time-error" class="d-none">
                <label class="text-danger"><?= lang('Config.timezone_error'); ?></label>
                <div class="row">
                    <div class="col-xs-12 col-lg-4">
                        <label for="timezone"><?= lang('Config.user_timezone'); ?></label>
                        <div id="timezone"></div>
                    </div>
                    <div class="col-xs-12 col-lg-4">
                        <label for="ostimezone"><?= lang('Config.os_timezone'); ?></label>
                        <div id="ostimezone"><?= $config['timezone']; ?></div>
                    </div>
                </div>
                <br>
            </div>
            <span>Extensions & Modules:</span>
            <ul class="list-unstyled">
                <li><?= $bullet . 'GD: ', extension_loaded('gd') ? $enabled : $disabled; ?></li>
                <li><?= $bullet . 'BC Math: ', extension_loaded('bcmath') ? $enabled : $disabled; ?></li>
                <li><?= $bullet . 'INTL: ', extension_loaded('intl') ? $enabled : $disabled; ?></li>
                <li><?= $bullet . 'OpenSSL: ', extension_loaded('openssl') ? $enabled : $disabled; ?></li>
                <li><?= $bullet . 'MBString: ', extension_loaded('mbstring') ? $enabled : $disabled; ?></li>
                <li><?= $bullet . 'Curl: ', extension_loaded('curl') ? $enabled : $disabled; ?></li>
                <li><?= $bullet . 'XML: ', extension_loaded('xml') ? $enabled : $disabled; ?></li>
            </ul>
        </div>
    </div>

    <div class="row" style="padding-top: 1em;">
        <label for="user-setup" class="col-xs-12 col-lg-2">User Setup</label>
        <div id="user-setup" class="col-xs-12 col-lg-10">
            <ul class="list-unstyled">
                <li><?= $bullet . 'Browser: ' . esc(getBrowserNameAndVersion($_SERVER['HTTP_USER_AGENT'])); ?></li>
                <li><?= $bullet . 'Server Software: ' . esc($_SERVER['SERVER_SOFTWARE']); ?></li>
                <li><?= $bullet . 'PHP Version: ' . PHP_VERSION; ?></li>
                <li><?= $bullet . 'DB Version: ' . esc($dbVersion); ?></li>
                <li><?= $bullet . 'Server Port: ' . esc($_SERVER['SERVER_PORT']); ?></li>
                <li><?= $bullet . 'OS: ' . php_uname('s') . '&nbsp;' . php_uname('r'); ?></li>
            </ul>
        </div>
    </div>

    <div class="row" style="padding-top: 1em;">
        <label for="permissions" class="col-xs-12 col-lg-2">Permissions</label>
        <div id="permissions" class="col-xs-12 col-lg-10">
            <ul class="list-unstyled">
            <?= $bullet; ?><code>[writable/logs]</code>
                <?php
                    $logsPermission = checkPermission($logs, '750');
                    echo $logsPermission['filePerm'] . $divider . $logsPermission['isWritable'] . $divider . $logsPermission['status'];
                    clearstatcache();
                ?>
                </li>
                <li>
                    <?= $bullet; ?><code>[writable/uploads]</code>
                    <?php
                        $uploadsPermission = checkPermission($uploads, '750');
                        echo $uploadsPermission['filePerm'] . $divider . $uploadsPermission['isWritable'] . $divider . $uploadsPermission['status'];
                        clearstatcache();
                    ?>
                </li>
                <li>
                    <?= $bullet; ?><code>[writable/uploads/item_pics]</code>
                    <?php
                        $imagesPermission = checkPermission($images, '750');
                        echo $imagesPermission['filePerm'] . $divider . $imagesPermission['isWritable'] . $divider . $imagesPermission['status'];
                        clearstatcache();
                    ?>
                </li>
                <li>
                    <?= $bullet; ?><code>[importCustomers.csv]</code>
                    <?php
                        $importCustomersPermission = checkPermission($importCustomers, '640');
                        echo $importCustomersPermission['filePerm'] . $divider . $importCustomersPermission['isReadable'] . $divider . $importCustomersPermission['status'];
                        clearstatcache();
                    ?>
                </li>
            </ul>
        </div>
    </div>

    <div class="row" style="padding-top: 1em;">
        <div class="col-lg-2"></div>
        <div class="col-lg-10">
            <?= generatePermissionAlert($logs, $uploads, $images, $importCustomers); ?>
        </div>
    </div>

</form>

<p class="text-center" style="padding-top: 1em;">
    <button class="copy btn btn-default" data-clipboard-target="#copy-issue"><i class="bi-clipboard-plus icon-spacing"></i>Copy Info</button>
    <a type="button" class="btn btn-default" href="https://github.com/opensourcepos/opensourcepos/issues/new" target="_blank" rel="noopener"><i class="bi-flag icon-spacing"></i><?= lang('Config.report_an_issue') ?></a>
</p>

<script type="application/javascript">
    var clipboard = new ClipboardJS('.copy');

    clipboard.on('success', function(e) {
        document.getSelection().removeAllRanges();
        $.notify( { icon: 'bi-clipboard-check-fill icon-spacing', message: 'System info successfully copied.'}, { type: 'success'} );
    });

    clipboard.on('error', function(e) {
        $.notify( { icon: 'bi-clipboard-x-fill icons-spacing', message: 'Something went wrong while copying.'}, { type: 'danger'} );
    });

    $(function() {
        $('#timezone').clone().appendTo('#timezoneE');
    });

    if($('#timezone').html() !== $('#ostimezone').html()) {
        document.getElementById("timezone").innerText = Intl.DateTimeFormat().resolvedOptions().timeZone;
        $('#time-error').removeClass('d-none');
    }
</script>
