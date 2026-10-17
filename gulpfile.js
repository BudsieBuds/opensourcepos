// Gulp Build Script

import gulp from 'gulp';
import rev from 'gulp-rev';
import concat from 'gulp-concat';
import cleanCSS from 'gulp-clean-css';
import uglify from 'gulp-uglify';
import inject from 'gulp-inject';
import tar from 'gulp-tar';
import zip from 'gulp-zip';

import { exec } from 'node:child_process';
import fs from 'node:fs/promises';
import { PassThrough } from 'node:stream';
import { pipeline } from 'node:stream/promises';
import { promisify } from 'node:util';

const execAsync = promisify(exec);


// -----------------------------------------------------------------------------
// Shared Constants & Helpers
// -----------------------------------------------------------------------------

/**
 * Navigation SVG icon mapping for menubar:
 * - source:  Original SVG filename from 'node_modules/elegant-circles/svg/full-color/'
 * - renamed: Target filename saved in 'public/images/menubar/'
 */
const MENUBAR_ICONS = [
    { source: 'star.svg', renamed: 'attributes.svg' },
    { source: 'bookshelf.svg', renamed: 'cashups.svg' },
    { source: 'gear.svg', renamed: 'config.svg' },
    { source: 'contacts.svg', renamed: 'customers.svg' },
    { source: 'profle.svg', renamed: 'employees.svg' },
    { source: 'compose.svg', renamed: 'expenses.svg' },
    { source: 'clipboard.svg', renamed: 'expenses_categories.svg' },
    { source: 'heart.svg', renamed: 'giftcards.svg' },
    { source: 'door.svg', renamed: 'home.svg' },
    { source: 'door.svg', renamed: 'office.svg' },
    { source: 'stack.svg', renamed: 'item_kits.svg' },
    { source: 'shop.svg', renamed: 'items.svg' },
    { source: 'smartphone.svg', renamed: 'messages.svg' },
    { source: 'tools.svg', renamed: 'migrate.svg' },
    { source: 'dolly.svg', renamed: 'receivings.svg' },
    { source: 'bar-chart.svg', renamed: 'reports.svg' },
    { source: 'cart.svg', renamed: 'sales.svg' },
    { source: 'briefcase.svg', renamed: 'suppliers.svg' },
    { source: 'money.svg', renamed: 'taxes.svg' }
];

/**
 * Bootswatch 5 themes that were not present in Bootswatch 3 are excluded to maintain theme parity.
 */
const BOOTSWATCH5_EXCLUDED_THEMES = [
    'brite', 'litera', 'lux', 'materia', 'minty', 'morph',
    'pulse', 'quartz', 'sketchy', 'solar', 'vapor', 'zephyr'
];

/**
 * Standardized options helper for gulp-inject comment markers.
 * Generates options matching the pattern <!-- inject:${tag} -->.
 */
const injectOptions = (tag, options = {}) => ({
    addRootSlash: false,
    ignorePath: '/public/',
    starttag: `<!-- inject:${tag} -->`,
    ...options
});

/**
 * Emits Vinyl file objects from multiple streams sequentially.
 * Native replacement for the stream-series package using node:stream PassThrough buffers.
 */
const streamSeries = (...streams) => {
    const output = new PassThrough({ objectMode: true });
    let pending = streams.length;

    if (pending === 0) {
        output.end();
        return output;
    }

    const buffers = streams.map(stream => {
        const passThrough = new PassThrough({ objectMode: true });
        passThrough.pause();
        stream.pipe(passThrough);
        return passThrough;
    });

    const next = () => {
        const passThrough = buffers.shift();
        passThrough.pipe(output, { end: false });
        passThrough.on('end', () => {
            if (--pending === 0) {
                output.end();
            } else {
                next();
            }
        });
        passThrough.resume();
    };

    next();
    return output;
};


// =============================================================================
// Group 1: Clean & Licensing
// =============================================================================

// Remove compiled public resources directory before a fresh build
gulp.task('clean', () => fs.rm('./public/resources', { recursive: true, force: true }));

// Generate Composer and npm production/development license reports in public/license/
gulp.task('update-licenses', function() {
    const npmFields = '--fields=name --fields=author --fields=homepage --fields=installedVersion --fields=licenseType';

    return Promise.all([
        execAsync('composer licenses --format=json --no-dev > public/license/composer.LICENSES'),
        execAsync(`npx license-report --only=prod --output=json ${npmFields} > public/license/npm-prod.LICENSES`),
        execAsync(`npx license-report --only=dev --output=json ${npmFields} > public/license/npm-dev.LICENSES`),
        pipeline(gulp.src('LICENSE'), gulp.dest('public/license'))
    ]);
});


// =============================================================================
// Group 2: Vendor Themes & Static Asset Copies
// =============================================================================

// Copy all Bootswatch 3 theme stylesheets and fonts to public/resources/bootswatch/
gulp.task('copy-bootswatch', function() {
    return pipeline(
        gulp.src([
            './node_modules/bootswatch/*/*.min.css',
            './node_modules/bootswatch/fonts/*.*'
        ], { base: './node_modules/bootswatch', encoding: false }),
        gulp.dest('public/resources/bootswatch')
    );
});

// Copy Bootswatch 5 theme stylesheets to public/resources/bootswatch5/,
// excluding themes that were not present in Bootswatch 3
gulp.task('copy-bootswatch5', function() {
    const exclusions = BOOTSWATCH5_EXCLUDED_THEMES.map(theme => `!./node_modules/bootswatch5/dist/${theme}/**`);

    return pipeline(
        gulp.src([
            './node_modules/bootswatch5/dist/*/*.min.css',
            ...exclusions
        ], { base: './node_modules/bootswatch5/dist' }),
        gulp.dest('public/resources/bootswatch5')
    );
});

// Copy base Bootstrap 3 and Bootstrap 5 stylesheets
gulp.task('copy-bootstrap', function() {
    return Promise.all([
        pipeline(
            gulp.src('./node_modules/bootstrap/dist/css/bootstrap.min.css*'),
            gulp.dest('public/resources/bootswatch/bootstrap')
        ),
        pipeline(
            gulp.src([
                './node_modules/bootstrap5/dist/css/bootstrap.min.css*',
                './node_modules/bootstrap5/dist/css/bootstrap.rtl.min.css*'
            ]),
            gulp.dest('public/resources/bootswatch5/bootstrap')
        )
    ]);
});

// Copy and rename menubar navigation SVG icons to public/images/menubar/
gulp.task('copy-menubar', async function() {
    await fs.mkdir('public/images/menubar', { recursive: true });

    return Promise.all(
        MENUBAR_ICONS.map(({ source, renamed }) =>
            fs.copyFile(
                `./node_modules/elegant-circles/svg/full-color/${source}`,
                `public/images/menubar/${renamed}`
            )
        )
    );
});


// =============================================================================
// Group 3: Global Application Assets (injected into app/Views/partial/header.php)
//
// Two-tier architecture:
// 1. Stylesheets: Injected into <head> (debug-css / prod-css).
// 2. JavaScript:
//    - Core JS: Injected synchronously into <head> (jQuery, Bootstrap, tables, forms, UI helpers).
//    - Deferred JS: Injected with 'defer' attribute (heavy export dependencies: SheetJS/xlsx, jsPDF, html2canvas, tableExport).
// =============================================================================

// Development mode: Injects individual global stylesheets into app/Views/partial/header.php
gulp.task('debug-css', function() {
    const debugCss = gulp.src([
        './node_modules/jquery-ui-dist/jquery-ui.css',
        './node_modules/bootstrap3-dialog/dist/css/bootstrap-dialog.css',
        './node_modules/jasny-bootstrap/dist/css/jasny-bootstrap.css',
        './node_modules/bootstrap-datetime-picker/css/bootstrap-datetimepicker.css',
        './node_modules/bootstrap-select/dist/css/bootstrap-select.css',
        './node_modules/bootstrap-table/dist/bootstrap-table.css',
        './node_modules/bootstrap-table/dist/extensions/sticky-header/bootstrap-table-sticky-header.css',
        './node_modules/bootstrap-daterangepicker/daterangepicker.css',
        './node_modules/bootstrap-toggle/css/bootstrap-toggle.css',
        './public/css/bootstrap.autocomplete.css',
        './public/css/invoice.css',
        './public/css/ospos_print.css',
        './public/css/ospos.css',
        './public/css/popupbox.css',
        './public/css/receipt.css',
        './public/css/register.css',
        './public/css/reports.css'
    ]).pipe(rev()).pipe(gulp.dest('public/resources/css'));

    return gulp.src('./app/Views/partial/header.php')
        .pipe(inject(debugCss, injectOptions('debug:css')))
        .pipe(gulp.dest('./app/Views/partial'));
});

// Production mode: Concatenates and minifies global stylesheets into opensourcepos.min.css for app/Views/partial/header.php
gulp.task('prod-css', function() {
    const preminifiedVendorCss1 = gulp.src([
        './node_modules/jquery-ui-dist/jquery-ui.min.css',
        './node_modules/bootstrap3-dialog/dist/css/bootstrap-dialog.min.css',
        './node_modules/jasny-bootstrap/dist/css/jasny-bootstrap.min.css',
        './node_modules/bootstrap-datetime-picker/css/bootstrap-datetimepicker.min.css'
    ]);

    const daterangepickerCss = gulp.src('./node_modules/bootstrap-daterangepicker/daterangepicker.css')
        .pipe(cleanCSS());

    const preminifiedVendorCss2 = gulp.src([
        './node_modules/bootstrap-select/dist/css/bootstrap-select.min.css',
        './node_modules/bootstrap-table/dist/bootstrap-table.min.css',
        './node_modules/bootstrap-table/dist/extensions/sticky-header/bootstrap-table-sticky-header.min.css',
        './node_modules/bootstrap-toggle/css/bootstrap-toggle.min.css'
    ]);

    const applicationCss = gulp.src([
        './public/css/bootstrap.autocomplete.css',
        './public/css/invoice.css',
        './public/css/ospos.css',
        './public/css/ospos_print.css',
        './public/css/popupbox.css',
        './public/css/receipt.css',
        './public/css/register.css',
        './public/css/reports.css'
    ]).pipe(cleanCSS());

    const prodCss = streamSeries(preminifiedVendorCss1, daterangepickerCss, preminifiedVendorCss2, applicationCss)
        .pipe(concat('opensourcepos.min.css'))
        .pipe(rev())
        .pipe(gulp.dest('public/resources'));

    return gulp.src('./app/Views/partial/header.php')
        .pipe(inject(prodCss, injectOptions('prod:css')))
        .pipe(gulp.dest('./app/Views/partial'));
});

// Development mode: Revisions and injects individual core and deferred scripts into app/Views/partial/header.php
gulp.task('debug-js', function() {
    const debugCoreJs = gulp.src([
        './node_modules/jquery/dist/jquery.js',
        './node_modules/jquery-form/src/jquery.form.js',
        './node_modules/jquery-validation/dist/jquery.validate.js',
        './node_modules/jquery-ui-dist/jquery-ui.js',
        './node_modules/bootstrap/dist/js/bootstrap.js',
        './node_modules/bootstrap3-dialog/dist/js/bootstrap-dialog.js',
        './node_modules/jasny-bootstrap/dist/js/jasny-bootstrap.js',
        './node_modules/bootstrap-datetime-picker/js/bootstrap-datetimepicker.js',
        './node_modules/bootstrap-select/dist/js/bootstrap-select.js',
        './node_modules/bootstrap-table/dist/bootstrap-table.js',
        './node_modules/bootstrap-table/dist/extensions/mobile/bootstrap-table-mobile.js',
        './node_modules/bootstrap-table/dist/extensions/sticky-header/bootstrap-table-sticky-header.js',
        './node_modules/moment/min/moment.min.js',
        './node_modules/bootstrap-daterangepicker/daterangepicker.js',
        './node_modules/dompurify/dist/purify.js',
        './node_modules/bootstrap-notify/bootstrap-notify.js',
        './node_modules/bootstrap-toggle/js/bootstrap-toggle.js',
        './public/js/imgpreview.full.jquery.js',
        './public/js/manage_tables.js',
        './public/js/nominatim.autocomplete.js'
    ]).pipe(rev()).pipe(gulp.dest('public/resources/js'));

    const debugDeferredJs = gulp.src([
        './node_modules/file-saver/dist/FileSaver.js',
        './node_modules/html2canvas/dist/html2canvas.js',
        './node_modules/jspdf/dist/jspdf.umd.js',
        './node_modules/jspdf-autotable/dist/jspdf.plugin.autotable.js',
        './node_modules/xlsx/dist/xlsx.full.min.js',
        './node_modules/tableexport.jquery.plugin/tableExport.min.js',
        './node_modules/bootstrap-table/dist/extensions/export/bootstrap-table-export.js'
    ]).pipe(rev()).pipe(gulp.dest('public/resources/js'));

    return gulp.src('./app/Views/partial/header.php')
        .pipe(inject(debugCoreJs, injectOptions('debug:js')))
        .pipe(inject(debugDeferredJs, injectOptions('debug:deferred:js', {
            transform: filepath => `<script src="${filepath}" defer></script>`
        })))
        .pipe(gulp.dest('./app/Views/partial'));
});

// Production mode: Bundles core scripts into opensourcepos.min.js (sync in <head>) and export libraries into opensourcepos-deferred.min.js (deferred) for app/Views/partial/header.php
gulp.task('prod-js', function() {
    const jqueryStream = gulp.src('./node_modules/jquery/dist/jquery.min.js')
        .pipe(rev())
        .pipe(gulp.dest('public/resources'));

    const preminifiedVendorJs = gulp.src([
        './node_modules/bootstrap/dist/js/bootstrap.min.js',
        './node_modules/bootstrap-table/dist/bootstrap-table.min.js',
        './node_modules/moment/min/moment.min.js',
        './node_modules/jquery-ui-dist/jquery-ui.min.js',
        './node_modules/bootstrap3-dialog/dist/js/bootstrap-dialog.min.js',
        './node_modules/jasny-bootstrap/dist/js/jasny-bootstrap.min.js',
        './node_modules/bootstrap-select/dist/js/bootstrap-select.min.js',
        './node_modules/bootstrap-table/dist/extensions/sticky-header/bootstrap-table-sticky-header.min.js',
        './node_modules/bootstrap-toggle/js/bootstrap-toggle.min.js',
        './node_modules/bootstrap-table/dist/extensions/mobile/bootstrap-table-mobile.min.js',
        './node_modules/bootstrap-notify/bootstrap-notify.min.js',
        './node_modules/jquery-form/dist/jquery.form.min.js',
        './node_modules/jquery-validation/dist/jquery.validate.min.js',
        './node_modules/bootstrap-datetime-picker/js/bootstrap-datetimepicker.min.js',
        './node_modules/dompurify/dist/purify.min.js'
    ], { allowEmpty: true });

    const uglifiedAppJs = gulp.src([
        './node_modules/bootstrap-daterangepicker/daterangepicker.js',
        './public/js/imgpreview.full.jquery.js',
        './public/js/manage_tables.js',
        './public/js/nominatim.autocomplete.js'
    ]).pipe(uglify());

    const coreBundleStream = streamSeries(preminifiedVendorJs, uglifiedAppJs)
        .pipe(concat('opensourcepos.min.js'))
        .pipe(rev())
        .pipe(gulp.dest('./public/resources/'));

    const deferredExportStream = gulp.src([
        './node_modules/file-saver/dist/FileSaver.min.js',
        './node_modules/html2canvas/dist/html2canvas.min.js',
        './node_modules/jspdf/dist/jspdf.umd.min.js',
        './node_modules/jspdf-autotable/dist/jspdf.plugin.autotable.js',
        './node_modules/xlsx/dist/xlsx.full.min.js',
        './node_modules/tableexport.jquery.plugin/tableExport.min.js',
        './node_modules/bootstrap-table/dist/extensions/export/bootstrap-table-export.min.js'
    ], { allowEmpty: true })
        .pipe(concat('opensourcepos-deferred.min.js'))
        .pipe(rev())
        .pipe(gulp.dest('./public/resources/'));

    return gulp.src('./app/Views/partial/header.php')
        .pipe(inject(streamSeries(jqueryStream, coreBundleStream), injectOptions('prod:js')))
        .pipe(inject(deferredExportStream, injectOptions('prod:deferred:js', {
            transform: filepath => `<script src="${filepath}" defer></script>`
        })))
        .pipe(gulp.dest('./app/Views/partial'));
});


// =============================================================================
// Group 4: Page-Scoped Assets
// =============================================================================

// Inject standalone jQuery into app/Views/login.php (development mode)
gulp.task('debug-login-js', function() {
    const loginDebugJs = gulp.src([
        './public/resources/js/jquery-*.js',
        '!./public/resources/js/jquery-*.form.js',
        '!./public/resources/js/jquery-*.validate.js',
        '!./public/resources/js/jquery-ui-*.js'
    ]);

    return gulp.src('./app/Views/login.php')
        .pipe(inject(loginDebugJs, injectOptions('login:debug:js')))
        .pipe(gulp.dest('./app/Views'));
});

// Inject production minified jQuery into app/Views/login.php (production mode)
gulp.task('prod-login-js', function() {
    const loginProdJs = gulp.src('./public/resources/jquery-*.min.js');

    return gulp.src('./app/Views/login.php')
        .pipe(inject(loginProdJs, injectOptions('login:prod:js')))
        .pipe(gulp.dest('./app/Views'));
});

// Inject individual TagsInput CSS, TagsInput JS, and ClipboardJS into app/Views/configs/manage.php (development mode)
gulp.task('debug-config', function() {
    const configDebugCss = gulp.src('./node_modules/bootstrap-tagsinput-2021/src/bootstrap-tagsinput.css')
        .pipe(rev())
        .pipe(gulp.dest('public/resources/css'));

    const configDebugJs = gulp.src([
        './node_modules/bootstrap-tagsinput-2021/dist/bootstrap-tagsinput.js',
        './node_modules/clipboard/dist/clipboard.js'
    ]).pipe(rev()).pipe(gulp.dest('public/resources/js'));

    return gulp.src('./app/Views/configs/manage.php')
        .pipe(inject(configDebugCss, injectOptions('config:debug:css')))
        .pipe(inject(configDebugJs, injectOptions('config:debug:js')))
        .pipe(gulp.dest('./app/Views/configs'));
});

// Bundle TagsInput CSS into config.min.css and JS (TagsInput + Clipboard) into config.min.js for app/Views/configs/manage.php (production mode)
gulp.task('prod-config', function() {
    const configProdCss = gulp.src('./node_modules/bootstrap-tagsinput-2021/src/bootstrap-tagsinput.css')
        .pipe(cleanCSS())
        .pipe(concat('config.min.css'))
        .pipe(rev())
        .pipe(gulp.dest('public/resources'));

    const configProdJs = gulp.src([
        './node_modules/bootstrap-tagsinput-2021/dist/bootstrap-tagsinput.min.js',
        './node_modules/clipboard/dist/clipboard.min.js'
    ], { allowEmpty: true })
        .pipe(concat('config.min.js'))
        .pipe(rev())
        .pipe(gulp.dest('public/resources'));

    return gulp.src('./app/Views/configs/manage.php')
        .pipe(inject(configProdCss, injectOptions('config:prod:css')))
        .pipe(inject(configProdJs, injectOptions('config:prod:js')))
        .pipe(gulp.dest('./app/Views/configs'));
});

// Inject individual Chartist CSS, core JS, and plugins into app/Views/reports/graphical.php (development mode)
gulp.task('debug-reportsgraphical', function() {
    const reportsGraphicalDebugCss = gulp.src([
        './node_modules/chartist/dist/chartist.css',
        './node_modules/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.css'
    ]).pipe(rev()).pipe(gulp.dest('public/resources/css'));

    const reportsGraphicalDebugJs = gulp.src([
        './node_modules/chartist/dist/chartist.js',
        './node_modules/chartist-plugin-pointlabels/dist/chartist-plugin-pointlabels.js',
        './node_modules/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.js',
        './node_modules/chartist-plugin-axistitle/dist/chartist-plugin-axistitle.js',
        './node_modules/chartist-plugin-barlabels/dist/chartist-plugin-barlabels.js'
    ]).pipe(rev()).pipe(gulp.dest('public/resources/js'));

    return gulp.src('./app/Views/reports/graphical.php')
        .pipe(inject(reportsGraphicalDebugCss, injectOptions('reportsgraphical:debug:css')))
        .pipe(inject(reportsGraphicalDebugJs, injectOptions('reportsgraphical:debug:js')))
        .pipe(gulp.dest('./app/Views/reports'));
});

// Bundle Chartist CSS into chartist.min.css and JS into chartist.min.js for app/Views/reports/graphical.php (production mode)
gulp.task('prod-reportsgraphical', function() {
    const chartistMinCss = gulp.src('./node_modules/chartist/dist/chartist.min.css');
    const chartistTooltipCss = gulp.src('./node_modules/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.css')
        .pipe(cleanCSS());

    const reportsGraphicalProdCss = streamSeries(chartistMinCss, chartistTooltipCss)
        .pipe(concat('reportsgraphical.min.css'))
        .pipe(rev())
        .pipe(gulp.dest('public/resources'));

    const reportsGraphicalProdJs = gulp.src([
        './node_modules/chartist/dist/chartist.min.js',
        './node_modules/chartist-plugin-pointlabels/dist/chartist-plugin-pointlabels.min.js',
        './node_modules/chartist-plugin-axistitle/dist/chartist-plugin-axistitle.min.js',
        './node_modules/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js',
        './node_modules/chartist-plugin-barlabels/dist/chartist-plugin-barlabels.min.js'
    ], { allowEmpty: true })
        .pipe(concat('reportsgraphical.min.js'))
        .pipe(rev())
        .pipe(gulp.dest('public/resources'));

    return gulp.src('./app/Views/reports/graphical.php')
        .pipe(inject(reportsGraphicalProdCss, injectOptions('reportsgraphical:prod:css')))
        .pipe(inject(reportsGraphicalProdJs, injectOptions('reportsgraphical:prod:js')))
        .pipe(gulp.dest('./app/Views/reports'));
});


// =============================================================================
// Group 5: Master Build Pipeline & Distribution Packaging
// =============================================================================

// Master build task: cleans resources, exports licenses, copies vendor assets, and generates all debug/prod bundles
gulp.task('default',
    gulp.series(
        'clean',
        'update-licenses',
        'copy-bootswatch',
        'copy-bootswatch5',
        'copy-bootstrap',
        'copy-menubar',
        'debug-css',
        'prod-css',
        'debug-js',
        'prod-js',
        'debug-login-js',
        'prod-login-js',
        'debug-config',
        'prod-config',
        'debug-reportsgraphical',
        'prod-reportsgraphical'
    ));

// Archive project sources and assets into distributable tar and zip packages in dist/
gulp.task('compress', function() {
    const sources = [
        'app*/**/*',
        'public*/**/*',
        'vendor*/**/*',
        '*.md',
        'docs/**/*',
        'LICENSE',
        'docker*',
        'Dockerfile',
        '**/.htaccess',
        'writable*/**/*',
        '.env.example'
    ];

    return Promise.all([
        pipeline(
            gulp.src(sources, { encoding: false }),
            tar('opensourcepos.tar'),
            gulp.dest('dist')
        ),
        pipeline(
            gulp.src(sources, { encoding: false }),
            zip('opensourcepos.zip'),
            gulp.dest('dist')
        )
    ]);
});
