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
<html lang="<?= current_language_code() ?>">

<head>
    <meta charset="utf-8">
    <base href="<?= base_url() ?>">
    <title><?= esc($config['company']) . '&nbsp;|&nbsp;' . lang('Common.powered_by') . '&nbsp;OSPOS&nbsp;' . esc(config('App')->application_version) ?></title>
    <meta name="robots" content="noindex, nofollow">
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
    <?php $theme = (empty($config['theme']) ? 'flatly' : esc($config['theme'])); ?>
    <link rel="stylesheet" type="text/css" href="resources/bootswatch/<?= "$theme" ?>/bootstrap.min.css">
    <link rel="stylesheet" href="resources/bootstrap-icons/bootstrap-icons.css">

    <?php if (ENVIRONMENT == 'development' || get_cookie('debug') == 'true' || $request->getGet('debug') == 'true') : ?>
        <!-- inject:debug:css -->
        <!-- endinject -->
        <!-- inject:debug:js -->
        <!-- endinject -->
    <?php else : ?>
        <!--inject:prod:css -->
        <!-- endinject -->
        <!-- inject:prod:js -->
        <!-- endinject -->
    <?php endif; ?>

    <?= view('partial/header_js') ?>
    <?= view('partial/lang_lines') ?>

</head>

<body>

    <header id="topbar" class="navbar navbar-default small">
        <div class="container">
            <div class="navbar-left navbar-text">
                <div id="liveclock"><?= date($config['dateformat'] . ' ' . $config['timeformat']) ?></div>
            </div>

            <div class="navbar-right navbar-text">
                <a href="<?= "home/changePassword/$user_info->person_id" ?>" class="modal-dlg navbar-link" data-btn-submit="<?= lang('Common.submit') ?>" title="<?= lang('Employees.change_password') ?>"><?= "$user_info->first_name $user_info->last_name" ?></a>
                <span class="navbar-text">&nbsp;|&nbsp;</span>
                <a href="home/logout" class="navbar-link"><?= lang('Login.logout') ?></a>
            </div>

            <div class="text-center navbar-text">
                <strong><?= esc($config['company']) ?></strong>
            </div>
        </div>
    </header>

    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" style="padding-bottom: 0; display: flex; align-items: center;" href="<?= site_url() ?>">
                <?php if (isset($config['company_logo']) && !empty($config['company_logo'])): ?>
                        <img class="logo" style="max-height: 100%; max-width: 240px;" src="<?= base_url('uploads/' . $config['company_logo']) ?>" alt="<?= lang('Common.logo') . '&nbsp;' . $config['company'] ?>">
                    <?php else: ?>
                        <svg class="logo text-info" style="height: 100%; width: auto;" role="img" viewBox="0 0 308.57998 308.57997" xmlns="http://www.w3.org/2000/svg">
                            <title><?= lang('Common.software_title') . '&nbsp;' . lang('Common.logo') ?></title>
                            <circle cx="154.28999" cy="154.28999" r="154.28999" fill="currentColor"/>
                            <path fill="#fff" d="M154.88998 145.66999c-.03-1.26-.03-3.29.19-4.29 4.6-11.1 15.57-18.82 28.3-18.82h.41v58.3c0 .12-.03.78-.04.9-.54 16.46-14.01 29.7-30.59 29.7v27.08c21 0 39.17-11.27 49.29-28.07l.07-.11c2.9.45 5.86.75 8.9.75 31.95 0 57.81-26 57.81-57.81 0-30.87-24.37-56.46-55.1-57.81h-30.74c-17.18 0-32.61 7.64-43.22 19.63-10.59-11.92-25.86-19.59-43.02-19.59-31.86 0-57.77 25.91-57.77 57.77 0 31.86 25.91 57.77 57.77 57.77 31.86 0 57.77-25.91 57.77-57.77v-3.68c-.01.01-.02-3.31-.03-3.95zm-57.75 38.33c-16.92 0-30.69-13.77-30.69-30.69s13.77-30.69 30.69-30.69 30.69 13.77 30.69 30.69-13.77 30.69-30.69 30.69zm142.96-19.87c-4.33 11.64-15.57 19.9-28.7 19.9h-.54v-61.47h.54c13.13 0 24.37 8.26 28.7 19.9 1.35 3.25 2.03 6.91 2.03 10.83s-.67 7.59-2.03 10.84z"/>
                        </svg>
                    <?php endif; ?>
                </a>
            </div>

            <div class="navbar-collapse collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right" id="modules">
                    <?php foreach($allowed_modules as $module): ?>
                        <li data-toggle="tooltip" data-placement="bottom" title="<?= lang('Module.' . $module->module_id) ?>" class="<?= $module->module_id == $request->getUri()->getSegment(1) ? 'active' : '' ?>">
                            <a href="<?= base_url($module->module_id) ?>" title="<?= lang("Module.$module->module_id") ?>">
                                <img src="<?= base_url("images/menubar/$module->module_id.svg") ?>" alt="">
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container">
