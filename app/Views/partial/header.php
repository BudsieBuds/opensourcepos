<?php
/**
 * @var object          $user_info
 * @var array           $allowed_modules
 * @var IncomingRequest $request
 * @var array           $config
 */

use CodeIgniter\HTTP\IncomingRequest;
use Config\Services;

$request = Services::request();

// Services::language()->setLocale('de-DE');

$theme = (empty($config['theme']) ? 'bootstrap' : $config['theme']);

$themeColors = [
    'bootstrap' => '#0d6efd',
    'flatly'    => '#2c3e50',
    'darkly'    => '#375a7f',
    'cosmo'     => '#2780e3',
    'cerulean'  => '#2fa4e7',
    'journal'   => '#eb6864',
    'litera'    => '#4582ec',
    'lumen'     => '#158cba',
    'lux'       => '#1a1a1a',
    'materia'   => '#2196f3',
    'minty'     => '#78c2ad',
    'morph'     => '#378dfc',
    'pulse'     => '#593196',
    'quartz'    => '#6d45bb',
    'sandstone' => '#93c54b',
    'simplex'   => '#d9230f',
    'sketchy'   => '#333333',
    'slate'     => '#3a3f44',
    'solar'     => '#b58900',
    'spacelab'  => '#446e9b',
    'superhero' => '#df6919',
    'united'    => '#e95420',
    'vapor'     => '#6f42c1',
    'yeti'      => '#008cba',
    'zephyr'    => '#3459e6',
];

$themeColor = $themeColors[$theme] ?? '#0d6efd';

?>

<!doctype html>
<html lang="<?= current_language_code() ?>" data-bs-theme="<?= $config['color_mode'] ?>" <?= $config['rtl_language'] === 1 ? 'dir="rtl"' : '' ?>>

<head>
    <meta charset="utf-8">
    <base href="<?= base_url() ?>">
    <title><?= esc($config['company']) . ' | ' . lang('Common.powered_by') . ' OSPOS ' . esc(config('App')->application_version) ?></title>
    <?= $config['responsive_design'] === 1 ? '<meta name="viewport" content="width=device-width, initial-scale=1">' : '' ?>
    <meta name="robots" content="noindex, nofollow">
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
    <link rel="stylesheet" href="resources/bootswatch/<?= $theme ?>/bootstrap.min.css">
    <link rel="stylesheet" href="resources/bootstrap-icons/bootstrap-icons.min.css">
    <meta name="theme-color" content="<?= $themeColor ?>">

    <?php if (ENVIRONMENT === 'development' || get_cookie('debug') === 'true' || $request->getGet('debug') === 'true') : ?>
        <!-- inject:debug:css -->
        <!-- endinject -->
        <!-- inject:debug:js -->
        <!-- endinject -->
    <?php else : ?>
        <!-- inject:prod:css -->
        <!-- endinject -->
        <!-- inject:prod:js -->
        <!-- endinject -->
    <?php endif; ?>

    <script type="module">
        import(document.querySelector('script[type="module"][src*="bootstrap"]')?.src || 'resources/bootstrap.bundle.min.js').then(bs => {
            window.bootstrap = Object.assign({}, bs, { Modal: bs.Dialog });
        }).catch(() => {});
    </script>
    <?= view('partial/header_js') ?>
    <?= view('partial/lang_lines') ?>

</head>

<body class="d-flex flex-column">
    <header class="flex-shrink-0 small bg-secondary-subtle py-1 print:d-none">
        <div class="lg:container container-navbar d-flex flex-wrap-reverse justify-content-between align-items-center">
            <div class="flex-grow-1 d-none md:d-block md:ps-3 lg:ps-0">
                <span id="liveclock"><?= date($config['dateformat'] . ' ' . $config['timeformat']) ?></span>
            </div>
            <div class="fw-bold ps-3 md:ps-0">
                <?= esc($config['company']) ?>
            </div>
            <div class="flex-grow-1 text-end pe-3 lg:pe-0">
                <button type="button" class="btn-outline btn-sm theme-primary" onclick="removeAnimationBg()" data-bs-toggle="dialog" data-bs-target="#profile-modal" title="<?= lang('Employees.change_password'); ?>">
                    <?= $user_info->first_name . '&nbsp;' . $user_info->last_name; ?>
                </button>
                <?= view('home/profile'); ?>
            </div>
        </div>
    </header>

    <nav class="navbar lg:navbar-expand bg-primary py-0 print:d-none">
        <div class="lg:container container-navbar">
            <a class="navbar-brand py-2 pe-1 ps-3 lg:ps-0 fs-xl" href="<?= site_url() ?>"><i class="bi bi-house-fill"></i></a>
            <button type="button" class="navbar-toggler my-2 mx-3" data-bs-toggle="drawer" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <dialog class="drawer drawer-start navbar-collapse" id="navbar">
                <div class="drawer-header lg:d-none">
                    <h5 class="drawer-title"><?= esc($config['company']) ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="drawer" aria-label="Close"></button>
                </div>
                <div class="drawer-body">
                    <ul class="navbar-nav ms-0 lg:ms-auto">
                        <?php foreach ($allowed_modules as $module): ?>
                        <li class="d-none lg:d-block nav-item ms-1 <?= $module->module_id === $request->getUri()->getSegment(1) ? 'active bg-light bg-opacity-25' : '' ?>" data-bs-toggle="tooltip" data-bs-placement="bottom" title="<?= lang("Module.{$module->module_id}") ?>">
                            <a class="nav-link p-2" href="<?= base_url($module->module_id) ?>">
                                <img src="<?= base_url("images/menubar/{$module->module_id}.svg") ?>" alt="<?= lang('Common.icon') . '&nbsp;' . lang("Module.{$module->module_id}") ?>">
                            </a>
                        </li>
                        <li class="lg:d-none nav-item py-1 <?= $module->module_id === $request->getUri()->getSegment(1) ? 'active bg-light bg-opacity-25' : '' ?>">
                            <a class="nav-link p-0" href="<?= base_url($module->module_id) ?>">
                                <img class="ps-3 pe-1 my-1" src="<?= base_url("images/menubar/{$module->module_id}.svg") ?>" alt="<?= lang('Common.icon') . '&nbsp;' . lang("Module.{$module->module_id}") ?>">
                                <span class="align-middle fg-contrast-primary"><?= lang("Module.{$module->module_id}") ?></span>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </dialog>
        </div>
    </nav>

    <main class="lg:container flex-grow-1 py-3">
