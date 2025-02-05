// Gulp Build Script

import gulp from 'gulp'
import clean from 'gulp-clean'
import rev from 'gulp-rev'
import concat from 'gulp-concat'
import cleanCSS from 'gulp-clean-css'
import rename from 'gulp-rename'
import uglify from 'gulp-uglify'
import inject from 'gulp-inject'
import logStream from 'gulp-debug'
import series from 'stream-series'
import header from 'gulp-header'
import tar from 'gulp-tar'
import gzip from 'gulp-gzip'
import zip from 'gulp-zip'
import run from 'gulp-run'

import { Stream } from 'readable-stream'
const {finished, pipeline} = Stream.promises


var prod0js;
var prod1js;

// Clear and remove the resources folder
gulp.task('clean', function () {
	return pipeline(
		gulp.src('./public/resources', {read: false, allowEmpty: true}),
		clean()
	);
});

gulp.task('compress', function() {
    const sources = ['app*/**/*', 'public*/**/*', 'vendor*/**/*', '*.md', 'LICENSE', 'docker*', 'Dockerfile', '**/.htaccess', 'writable*/**/*'] ;
    gulp.src(sources, {encoding: false}).pipe(tar('opensourcepos.tar')).pipe(gulp.dest('dist'));
    return gulp.src(sources, {encoding: false}).pipe(zip('opensourcepos.zip')).pipe(gulp.dest('dist'));
});

// Copy the bootswatch styles into their own folder so OSPOS can select one from the collection
gulp.task('copy-bootswatch', function() {
	pipeline(gulp.src('./node_modules/bootswatch/dist/cerulean/*.min.css*'),gulp.dest('public/resources/bootswatch/cerulean'));
	pipeline(gulp.src('./node_modules/bootswatch/dist/cosmo/*.min.css*'),gulp.dest('public/resources/bootswatch/cosmo'));
	pipeline(gulp.src('./node_modules/bootswatch/dist/cyborg/*.min.css*'),gulp.dest('public/resources/bootswatch/cyborg'));
	pipeline(gulp.src('./node_modules/bootswatch/dist/darkly/*.min.css*'),gulp.dest('public/resources/bootswatch/darkly'));
	pipeline(gulp.src('./node_modules/bootswatch/dist/flatly/*.min.css*'),gulp.dest('public/resources/bootswatch/flatly'));
	pipeline(gulp.src('./node_modules/bootswatch/dist/journal/*.min.css*'),gulp.dest('public/resources/bootswatch/journal'));
	pipeline(gulp.src('./node_modules/bootswatch/dist/litera/*.min.css*'),gulp.dest('public/resources/bootswatch/litera'));
	pipeline(gulp.src('./node_modules/bootswatch/dist/lumen/*.min.css*'),gulp.dest('public/resources/bootswatch/lumen'));
	pipeline(gulp.src('./node_modules/bootswatch/dist/lux/*.min.css*'),gulp.dest('public/resources/bootswatch/lux'));
	pipeline(gulp.src('./node_modules/bootswatch/dist/materia/*.min.css*'),gulp.dest('public/resources/bootswatch/materia'));
	pipeline(gulp.src('./node_modules/bootswatch/dist/minty/*.min.css*'),gulp.dest('public/resources/bootswatch/minty'));
	pipeline(gulp.src('./node_modules/bootswatch/dist/morph/*.min.css*'),gulp.dest('public/resources/bootswatch/morph'));
	pipeline(gulp.src('./node_modules/bootswatch/dist/pulse/*.min.css*'),gulp.dest('public/resources/bootswatch/pulse'));
	pipeline(gulp.src('./node_modules/bootswatch/dist/quartz/*.min.css*'),gulp.dest('public/resources/bootswatch/quartz'));
	pipeline(gulp.src('./node_modules/bootswatch/dist/sandstone/*.min.css*'),gulp.dest('public/resources/bootswatch/sandstone'));
	pipeline(gulp.src('./node_modules/bootswatch/dist/simplex/*.min.css*'),gulp.dest('public/resources/bootswatch/simplex'));
	pipeline(gulp.src('./node_modules/bootswatch/dist/sketchy/*.min.css*'),gulp.dest('public/resources/bootswatch/sketchy'));
	pipeline(gulp.src('./node_modules/bootswatch/dist/slate/*.min.css*'),gulp.dest('public/resources/bootswatch/slate'));
	pipeline(gulp.src('./node_modules/bootswatch/dist/solar/*.min.css*'),gulp.dest('public/resources/bootswatch/solar'));
	pipeline(gulp.src('./node_modules/bootswatch/dist/spacelab/*.min.css*'),gulp.dest('public/resources/bootswatch/spacelab'));
	pipeline(gulp.src('./node_modules/bootswatch/dist/superhero/*.min.css*'),gulp.dest('public/resources/bootswatch/superhero'));
	pipeline(gulp.src('./node_modules/bootswatch/dist/united/*.min.css*'),gulp.dest('public/resources/bootswatch/united'));
	pipeline(gulp.src('./node_modules/bootswatch/dist/vapor/*.min.css*'),gulp.dest('public/resources/bootswatch/vapor'));
	pipeline(gulp.src('./node_modules/bootswatch/dist/yeti/*.min.css*'),gulp.dest('public/resources/bootswatch/yeti'));
	return pipeline(gulp.src('./node_modules/bootswatch/dist/zephyr/*.min.css*'),gulp.dest('public/resources/bootswatch/zephyr'));
});

// /public/resources/ospos - contains the minimized files to be packed into opensourcepos.min.[css/js]
// /public/resources/[css/js] - contains the unpacked versions to be used in development mode
// /public/resources - contains the packed opensourcepos.min.[css/js] and the jquery.min.js

// Copy JavaScript into a folder which will be used as the source to create opensourcepos.min.js (except for jquery.mn.js)

// Inject will be in the sequence of the files in the stream.  So make sure dependencies are in their proper order


gulp.task('debug-js', function() {
	var debugjs = gulp.src(['./node_modules/jquery/dist/jquery.js',
		'./node_modules/jquery-form/src/jquery.form.js',
		'./node_modules/jquery-validation/dist/jquery.validate.js',
		'./node_modules/jquery-ui-dist/jquery-ui.js',
		'./node_modules/bootstrap/dist/js/bootstrap.bundle.js',
		'./node_modules/bootstrap3-dialog/dist/js/bootstrap-dialog.js',
		'./node_modules/jasny-bootstrap/dist/js/jasny-bootstrap.js',
		'./node_modules/bootstrap-datetime-picker/js/bootstrap-datetimepicker.js',
		'./node_modules/bootstrap-select/dist/js/bootstrap-select.js',
		'./node_modules/bootstrap-table/dist/bootstrap-table.js',
		'./node_modules/bootstrap-table/dist/extensions/export/bootstrap-table-export.js',
		'./node_modules/bootstrap-table/dist/extensions/mobile/bootstrap-table-mobile.js',
		'./node_modules/bootstrap-table/dist/extensions/sticky-header/bootstrap-table-sticky-header.js',
		'./node_modules/moment/min/moment.min.js',
		'./node_modules/bootstrap-daterangepicker/daterangepicker.js',
		'./node_modules/es6-promise/dist/es6-promise.js',
		'./node_modules/file-saver/dist/FileSaver.js',
		'./node_modules/html2canvas/dist/html2canvas.js',
		'./node_modules/jspdf/dist/jspdf.umd.js',
		'./node_modules/jspdf-autotable/dist/jspdf.plugin.autotable.js',
		'./node_modules/tableexport.jquery.plugin/tableExport.min.js',
		'./node_modules/chartist/dist/chartist.js',
		'./node_modules/chartist-plugin-pointlabels/dist/chartist-plugin-pointlabels.js',
		'./node_modules/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.js',
		'./node_modules/chartist-plugin-axistitle/dist/chartist-plugin-axistitle.js',
		'./node_modules/chartist-plugin-barlabels/dist/chartist-plugin-barlabels.js',
		'./public/js/bootstrap-notify/bootstrap-notify.js',
		'./node_modules/js-cookie/src/js.cookie.js',
		'./node_modules/bootstrap-tagsinput-2021/dist/bootstrap-tagsinput.js',
		'./node_modules/bootstrap5-toggle/js/bootstrap5-toggle.ecmas.js',
		'./public/js/imgpreview.full.jquery.js',
		'./public/js/manage_tables.js',
		'./public/js/nominatim.autocomplete.js']).pipe(rev()).pipe(gulp.dest('public/resources/js'));
	return gulp.src('./app/Views/partial/header.php').pipe(inject(debugjs,{addRootSlash: false, ignorePath: '/public/', starttag: '<!-- inject:debug:js -->'})).pipe(gulp.dest('./app/Views/partial'));
});

gulp.task('prod-js', function() {

	var prod0js = gulp.src('./node_modules/jquery/dist/jquery.min.js').pipe(rev()).pipe(gulp.dest('public/resources'));

	var opensourcepos1js = gulp.src(['./node_modules/bootstrap/dist/js/bootstrap.bundle.min.js',
		'./node_modules/bootstrap-table/dist/bootstrap-table.min.js',
		'./node_modules/moment/min/moment.min.js',
		'./node_modules/jquery-ui-dist/jquery-ui.min.js',
		'./node_modules/bootstrap3-dialog/dist/js/bootstrap-dialog.min.js',
		'./node_modules/jasny-bootstrap/dist/js/jasny-bootstrap.min.js',
		'./node_modules/bootstrap-select/dist/js/bootstrap-select.min.js',
		'./node_modules/bootstrap-table/dist/extensions/sticky-header/bootstrap-table-sticky-header.min.js',
		'./node_modules/bootstrap-tagsinput-2021/dist/bootstrap-tagsinput.min.js',
		'./node_modules/bootstrap5-toggle/js/bootstrap5-toggle.ecmas.min.js',
		'./node_modules/bootstrap-table/dist/extensions/export/bootstrap-table-export.min.js',
		'./node_modules/bootstrap-table/dist/extensions/mobile/bootstrap-table-mobile.min.js',
		'./public/js/bootstrap-notify/bootstrap-notify.min.js',
		'./node_modules/jquery-form/dist/jquery.form.min.js',
		'./node_modules/jquery-validation/dist/jquery.validate.min.js',
		'./node_modules/bootstrap-datetime-picker/js/bootstrap-datetimepicker.min.js',
		'./node_modules/es6-promise/dist/es6-promise.min.js',
		'./node_modules/file-saver/dist/FileSaver.min.js',
		'./node_modules/file-saver/dist/FileSaver.js',
		'./node_modules/html2canvas/dist/html2canvas.min.js',
		'./node_modules/chartist/dist/chartist.min.js',
		'./node_modules/jspdf/dist/jspdf.umd.min.js',
		'./node_modules/chartist/dist/chartist.min.js',
		'./node_modules/chartist-plugin-pointlabels/dist/chartist-plugin-pointlabels.min.js',
		'./node_modules/chartist-plugin-axistitle/dist/chartist-plugin-axistitle.min.js',
		'./node_modules/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js',
		'./node_modules/chartist-plugin-barlabels/dist/chartist-plugin-barlabels.min.js',
		'./node_modules/tableexport.jquery.plugin/tableExport.min.js'], { allowEmpty: true });

	var opensourcepos2js = gulp.src(['./node_modules/bootstrap-daterangepicker/daterangepicker.js',
		'./node_modules/js-cookie/src/js.cookie.js',
		'./public/js/imgpreview.full.jquery.js',
		'./public/js/manage_tables.js',
		'./public/js/nominatim.autocomplete.js']).pipe(uglify());


	var prod1js = series(opensourcepos1js, opensourcepos2js).pipe(concat('opensourcepos.min.js'))
		.pipe(rev())
		.pipe(gulp.dest('./public/resources/'));

	return gulp.src('./app/Views/partial/header.php').pipe(inject(
		series(prod0js, prod1js), {addRootSlash: false, ignorePath: '/public/', starttag: '<!-- inject:prod:js -->'})).pipe(gulp.dest('./app/Views/partial'));

});



gulp.task('debug-css', function() {
	var debugcss = gulp.src(['./node_modules/jquery-ui-dist/jquery-ui.css',
		'./node_modules/bootstrap3-dialog/dist/css/bootstrap-dialog.css',
		'./node_modules/jasny-bootstrap/dist/css/jasny-bootstrap.css',
		'./node_modules/bootstrap-datetime-picker/css/bootstrap-datetimepicker.css',
		'./node_modules/bootstrap-select/dist/css/bootstrap-select.css',
		'./node_modules/bootstrap-table/dist/bootstrap-table.css',
		'./node_modules/bootstrap-table/dist/extensions/sticky-header/bootstrap-table-sticky-header.css',
		'./node_modules/bootstrap-daterangepicker/daterangepicker.css',
		'./node_modules/chartist/dist/chartist.css',
		'./node_modules/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.css',
		'./node_modules/bootstrap-tagsinput-2021/src/bootstrap-tagsinput.css',
		'./node_modules/bootstrap5-toggle/css/bootstrap5-toggle.css',
		'./public/css/bootstrap.autocomplete.css',
		'./public/css/interface.css',
		'./public/css/invoice.css',
		'./public/css/ospos_print.css',
		'./public/css/popupbox.css',
		'./public/css/receipt.css',
		'./public/css/reports.css'
	]).pipe(rev()).pipe(gulp.dest('public/resources/css'));
	return gulp.src('./app/Views/partial/header.php').pipe(inject(debugcss,{addRootSlash: false, ignorePath: '/public/', starttag: '<!-- inject:debug:css -->'})).pipe(gulp.dest('./app/Views/partial'));
});


gulp.task('prod-css', function() {
	var opensourcepos1css = gulp.src(['./node_modules/jquery-ui-dist/jquery-ui.min.css',
		'./node_modules/bootstrap3-dialog/dist/css/bootstrap-dialog.min.css',
		'./node_modules/jasny-bootstrap/dist/css/jasny-bootstrap.min.css',
		'./node_modules/bootstrap-datetime-picker/css/bootstrap-datetimepicker.min.css']);

	var opensourcepos2css = gulp.src(['./node_modules/bootstrap-daterangepicker/daterangepicker.css',
		'./node_modules/bootstrap-tagsinput-2021/src/bootstrap-tagsinput.css']).pipe(cleanCSS({compatibility: 'ie8'}));

	var opensourcepos3css = gulp.src(['./node_modules/bootstrap-select/dist/css/bootstrap-select.min.css',
		'./node_modules/bootstrap-table/dist/bootstrap-table.min.css',
		'./node_modules/bootstrap-table/dist/extensions/sticky-header/bootstrap-table-sticky-header.min.css',
		'./node_modules/bootstrap5-toggle/css/bootstrap5-toggle.min.css',
		'./node_modules/chartist/dist/chartist.min.css']);

	var opensourcepos4css = gulp.src('./node_modules/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.css').pipe(cleanCSS({compatibility: 'ie8'}));

	var opensourcepos5css = gulp.src(['./node_modules/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.css',
		'./public/css/bootstrap.autocomplete.css',
		'./public/css/interface.css',
		'./public/css/invoice.css',
		'./public/css/ospos_print.css',
		'./public/css/popupbox.css',
		'./public/css/receipt.css',
		'./public/css/reports.css'
	]).pipe(cleanCSS({compatibility: 'ie8'}));

	var prodcss = series(opensourcepos1css, opensourcepos2css, opensourcepos3css, opensourcepos4css, opensourcepos5css)
		.pipe(concat('opensourcepos.min.css')).pipe(rev()).pipe(gulp.dest('public/resources'));


	return gulp.src('./app/Views/partial/header.php').pipe(inject(prodcss,{addRootSlash: false, ignorePath: '/public/', starttag: '<!-- inject:prod:css -->'})).pipe(gulp.dest('./app/Views/partial'));
});

gulp.task('copy-js', function() {
	return pipeline(gulp.src('./node_modules/clipboard/dist/clipboard.min.js'),gulp.dest('public/resources/clipboard'));
});

gulp.task('copy-bootstrap', function() {
	pipeline(gulp.src('./node_modules/bootstrap/dist/css/bootstrap.min.css*'),gulp.dest('public/resources/bootswatch/bootstrap'));
	return pipeline(gulp.src('./node_modules/bootstrap/dist/js/bootstrap.bundle.min*'),gulp.dest('public/resources/bootstrap/js'));
});


gulp.task('copy-icons', function() {
	return pipeline(gulp.src('./node_modules/bootstrap-icons/font/**/*', {encoding: false}),gulp.dest('public/resources/bootstrap-icons'));
});


gulp.task('copy-menubar', function() {
	pipeline(gulp.src("./node_modules/elegant-circles/svg/full-color/star.svg"),rename("attributes.svg"),gulp.dest("public/images/menubar"));
	pipeline(gulp.src("./node_modules/elegant-circles/svg/full-color/bookshelf.svg"),rename("cashups.svg"),gulp.dest("public/images/menubar"));
	pipeline(gulp.src("./node_modules/elegant-circles/svg/full-color/gear.svg"),rename("config.svg"),gulp.dest("public/images/menubar"));
	pipeline(gulp.src("./node_modules/elegant-circles/svg/full-color/contacts.svg"),rename("customers.svg"),gulp.dest("public/images/menubar"));
	pipeline(gulp.src("./node_modules/elegant-circles/svg/full-color/profle.svg"),rename("employees.svg"),gulp.dest("public/images/menubar"));
	pipeline(gulp.src("./node_modules/elegant-circles/svg/full-color/compose.svg"),rename("expenses.svg"),gulp.dest("public/images/menubar"));
	pipeline(gulp.src("./node_modules/elegant-circles/svg/full-color/clipboard.svg"),rename("expenses_categories.svg"),gulp.dest("public/images/menubar"));
	pipeline(gulp.src("./node_modules/elegant-circles/svg/full-color/heart.svg"),rename("giftcards.svg"),gulp.dest("public/images/menubar"));
	pipeline(gulp.src("./node_modules/elegant-circles/svg/full-color/door.svg"),rename("home.svg"),gulp.dest("public/images/menubar"));
	pipeline(gulp.src("./node_modules/elegant-circles/svg/full-color/stack.svg"),rename("item_kits.svg"),gulp.dest("public/images/menubar"));
	pipeline(gulp.src("./node_modules/elegant-circles/svg/full-color/shop.svg"),rename("items.svg"),gulp.dest("public/images/menubar"));
	pipeline(gulp.src("./node_modules/elegant-circles/svg/full-color/smartphone.svg"),rename("messages.svg"),gulp.dest("public/images/menubar"));
	pipeline(gulp.src("./node_modules/elegant-circles/svg/full-color/tools.svg"),rename("migrate.svg"),gulp.dest("public/images/menubar"));
	pipeline(gulp.src("./node_modules/elegant-circles/svg/full-color/door.svg"),rename("office.svg"),gulp.dest("public/images/menubar"));
	pipeline(gulp.src("./node_modules/elegant-circles/svg/full-color/dolly.svg"),rename("receivings.svg"),gulp.dest("public/images/menubar"));
	pipeline(gulp.src("./node_modules/elegant-circles/svg/full-color/bar-chart.svg"),rename("reports.svg"),gulp.dest("public/images/menubar"));
	pipeline(gulp.src("./node_modules/elegant-circles/svg/full-color/cart.svg"),rename("sales.svg"),gulp.dest("public/images/menubar"));
	pipeline(gulp.src("./node_modules/elegant-circles/svg/full-color/briefcase.svg"),rename("suppliers.svg"),gulp.dest("public/images/menubar"));
	return pipeline(gulp.src('./node_modules/elegant-circles/svg/full-color/money.svg'),rename("taxes.svg"),gulp.dest("public/images/menubar"));
});

gulp.task('update-licenses', function() {
	run('composer licenses --format=json --no-dev > public/license/composer.LICENSES').exec();
	return pipeline(gulp.src('LICENSE'),gulp.dest('public/license'));
});


gulp.task('build-database', function() {
	return gulp.src(['./app/Database/tables.sql','./app/Database/constraints.sql'])
		.pipe(header('-- >> This file is autogenerated from tables.sql and constraints.sql. Do not modify directly << --'))
		.pipe(concat('database.sql'))
		.pipe(gulp.dest('./app/Database'));
});

// Run all required tasks
gulp.task('default',
	gulp.series('clean',
		'copy-bootswatch',
		'debug-js',
		'prod-js',
		'debug-css',
		'prod-css',
		'copy-js',
		'copy-bootstrap',
		'copy-icons',
		'copy-menubar',
		'update-licenses',
		'build-database'
	));
