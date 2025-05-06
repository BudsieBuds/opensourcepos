<?php
/**
 * @var object $user_info
 * @var array $allowed_modules
 * @var CodeIgniter\HTTP\IncomingRequest $request
 * @var array $config
 */

use Config\Services;

$request = Services::request();
?>

<!doctype html>
<html lang="<?= $request->getLocale() ?>">

<head>
    <meta charset="utf-8">
    <base href="<?= base_url() ?>">
    <title><?= esc($config['company']) . ' | ' . lang('Common.powered_by') . ' OSPOS ' . esc(config('App')->application_version) ?></title>
    <meta name="robots" content="noindex, nofollow">
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
    <link rel="stylesheet" href="<?= 'resources/bootswatch/' . (empty($config['theme']) ? 'flatly' : esc($config['theme'])) . '/bootstrap.min.css' ?>">
    <link rel="stylesheet" href="resources/bootstrap-icons/bootstrap-icons.min.css">

    <?php if (ENVIRONMENT == 'development' || get_cookie('debug') == 'true' || $request->getGet('debug') == 'true') : ?>
        <!-- inject:debug:css -->
        <!-- endinject -->
        <!-- inject:debug:js -->
        <!-- endinject -->
    <?php else : ?>
        <!--inject:prod:css -->
        <!-- endinject -->

        <!-- Tweaks to the UI for a particular theme should drop here  -->
        <?php if ($config['theme'] != 'flatly' && file_exists($_SERVER['DOCUMENT_ROOT'] . '/public/css/' . esc($config['theme']) . '.css')) { ?>
            <link rel="stylesheet" href="<?= 'css/' . esc($config['theme']) . '.css' ?>">
        <?php } ?>
        <!-- inject:prod:js -->
        <!-- endinject -->
    <?php endif; ?>

    <?= view('partial/header_js') ?>
    <?= view('partial/lang_lines') ?>
</head>

<body>
    <header class="bg-primary-subtle py-1 small">
        <div class="container d-flex justify-content-between align-items-center">
			<div class="flex-grow-1">
				<span id="liveclock"><?= date($config['dateformat'] . ' ' . $config['timeformat']) ?></span>
			</div>
			<div class="fw-bold">
				<?= esc($config['company']) ?>
			</div>
			<div class="flex-grow-1 text-end">
                <?= anchor("home/changePassword/$user_info->person_id", "$user_info->first_name $user_info->last_name", ['class' => 'modal-dlg', 'data-btn-submit' => lang('Common.submit'), 'title' => lang('Employees.change_password')]) ?>
                <span>&nbsp;|&nbsp;</span>
                <?= anchor('home/logout', lang('Login.logout')) ?>
			</div>
		</div>
    </header>

    <nav class="navbar navbar-expand navbar-dark bg-primary py-1">
        <div class="container">
            <a class="navbar-brand pe-1" href="<?= site_url() ?>">OSPOS</a>
            <button class="navbar-toggler my-2 mx-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse small" id="navbar">
                <ul class="navbar-nav ms-auto">
                    <?php foreach ($allowed_modules as $module): ?>
                        <li class="nav-item <?= $module->module_id == $request->getUri()->getSegment(1) ? 'active' : '' ?>" title="<?= lang("Module.$module->module_id") ?>">
                            <a class="nav-link p-2 text-center" href="<?= base_url($module->module_id) ?>">
                                <img src="<?= base_url("images/menubar/$module->module_id.svg") ?>" alt="<?= lang('Common.icon') . '&nbsp;' . lang("Module.$module->module_id") ?>">
                                <br>
                                <span><?= lang('Module.' . $module->module_id) ?></span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container py-3">
