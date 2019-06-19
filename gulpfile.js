var path = require('path'),
    gulp = require('gulp'),
    sourcemaps = require('gulp-sourcemaps'),
    sass = require('gulp-sass'),
    browserSync = require('browser-sync'),
    concat = require('gulp-concat'),
    uglify = require('gulp-uglifyjs'),
    cssnano = require('gulp-cssnano'),
    rename = require('gulp-rename'),
    imagemin = require('gulp-imagemin'),
    pngquant = require('imagemin-pngquant'),
    cache = require('gulp-cache'),
    autoprefixer = require('gulp-autoprefixer'),
    plumber = require('gulp-plumber'),
    ftp = require('gulp-ftp'),
    sftp = require('gulp-sftp'),
    gutil = require('gulp-util'),
    del = require('del');



gulp.task('sass', function() {
    return gulp.src([
        '!./frontend/template/css/_*.sass',
        './frontend/template/css/*.sass',
    ])
        .pipe(concat('main.sass'))
        .pipe(sourcemaps.init())
        .pipe(sass().on('error', sass.logError))
        .pipe(autoprefixer(
            ['last 15 versions', '> 1%', 'ie 8', 'ie 7'], { cascade: true }
        ))
        .pipe(sourcemaps.write())
        .pipe(cssnano())
        .pipe(rename({ suffix: '.min' }))
        .pipe(gulp.dest('./frontend/template/css/')) // выходные файлы в папке
});


gulp.task('scripts-min-libs', function() {
    return gulp.src([
            './frontend/libs/jquery/dist/jquery.min.js',
            './frontend/libs/jquery-json/dist/jquery.json.min.js',
            './frontend/template/bootstrap/js/bootstrap.min.js',
            './frontend/libs/jquery-mousewheel/jquery.mousewheel.min.js',
            './frontend/libs/fancybox/source/jquery.fancybox.js',
            './frontend/libs/jquery.inputmask/dist/min/inputmask/inputmask.min.js',
            './frontend/libs/jquery.inputmask/dist/min/inputmask/inputmask.extensions.min.js',
            './frontend/libs/jquery.inputmask/dist/min/inputmask/inputmask.numeric.extensions.min.js',
            './frontend/libs/jquery.inputmask/dist/min/inputmask/jquery.inputmask.min.js',
            './cms/plugins/chosen-jquery/chosen.jquery.js',
            //        './frontend/libs/fotorama/fotorama.js',
            // './frontend/libs/jquery.cookie/jquery.cookie.js',
            // './frontend/libs/accounting/accounting.min.js',
            './frontend/modules/callme/callme.js'
        ])
        .pipe(concat('libs.min.js')) // Собираем все подключенные библиотеки в один файл
        .pipe(uglify()) // Сжимаеnpm i -gм
        .pipe(gulp.dest('./frontend/js/')); // Выводим файл
});

gulp.task('scripts-main-min', function() {
    return gulp.src([

            './frontend/js/main.js',
            // './frontend/js/basket.js'

        ])
        .pipe(concat('main.min.js')) // Собираем все подключенные библиотеки в один файл
        .pipe(sourcemaps.init())
        .pipe(uglify()) // Сжимаем
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('./frontend/js/')) // Выводим файл
        .pipe(browserSync.reload({ stream: true }))
});


gulp.task('css-min-libs', function() {
    return gulp.src([
            // './frontend/template/css/libs.css',
            // './frontend/template/uikit/uikit.css',
            './frontend/template/bootstrap/css/bootstrap.min.css',
            './frontend/libs/fancybox/source/jquery.fancybox.css',
            './cms/plugins/chosen-jquery/chosen_frontend.css',
            //                './frontend/template/css/fontello/fontello.css',
            //                './frontend/libs/chosen/chosen.css',
            //                './frontend/libs/fotorama/fotorama.css',
            //                './frontend/libs/nathansmith-960-Grid-System-b44f524/code/css/min/960_24_col.css',
        ])
        .pipe(cssnano())
        .pipe(concat('libs.css'))
        .pipe(rename({ suffix: '.min' }))
        .pipe(gulp.dest('./frontend/template/css/'))
});


gulp.task('css-min-main', ['sass'], function() {
    return gulp.src('./frontend/template/css/main.css')
        .pipe(cssnano())
        .pipe(rename({ suffix: '.min' }))
        .pipe(gulp.dest('./frontend/template/css/'))
        .pipe(browserSync.reload({ stream: true }))
});


gulp.task('bs', function() { //Остслеживаем изменения
    browserSync({
        proxy: 'dom-pereezdov.local',
        notify: false
    })
});


gulp.task('img', function() {
    return gulp.src([
            './frontend/template/images/*.*'
        ])
        .pipe(cache(imagemin({
            interlaced: true,
            progressive: true,
            svgoPlugins: [{ removeViewBox: false }],
            une: [pngquant()]
        })))
        .pipe(gulp.dest('./frontend/template/images/min/'))
})


gulp.task('clean', function() {
    return del.sync('dist')
})

gulp.task('clear', function() { //Прописываем вручную в cmd
    return cache.clearAll();
})


gulp.task('watch', ['bs', 'css-min-libs', 'css-min-main', 'scripts-min-libs', 'scripts-main-min'], function() { //Остслеживаем изменения
    gulp.watch('./frontend/template/css/*.sass', ['css-min-main', browserSync.reload]);
    gulp.watch(['!./cms/**/*.php', './*.php'], browserSync.reload);
    gulp.watch(['!./cms/**/*.php', './**/*.php'], browserSync.reload);
    gulp.watch('./frontend/**/*.js', ['scripts-main-min', browserSync.reload]);
    gulp.watch('./frontend/**/*.php', browserSync.reload);
    //    gulp.watch('./app/js/**/*.js', browserSync.reload);
    //    gulp.watch('./app/*.html', browserSync.reload);
    //    gulp.watch('./*.php', ['ftp']);
});
// ['bs'] - перечесляем таски, которые нужно выполнить до того как запустить текущий watch
//, , 'scripts-main-min' 



//gulp.task('ftp', function () {
//    return gulp.src([
//            '/frontend/pages/**/*',
//            '/frontend/template/css/**/*',
//            '/frontend/template/images/**/*'
//        ])
//        .pipe(ftp({
//            host: 'xn--80aaacdjwqs2a9i.xn--p1ai',
//            user: '9144665628_gulp',
//            pass: 'TRT615c',
//            remotePath: '/',
//            parallel: 10
//        }))
//        .pipe(gutil.noop());
//});






gulp.task('build', [
    'clean',
    'img',
    'scripts-min-libs',
    'scripts-main-min',
    'css-min-libs',
    'css-min-main',
], function() {
    var buildCss = gulp.src([
            'app/css/main.min.css',
            'app/css/libs.min.css'
        ])
        .pipe(gulp.dest('dist/css'));

    var buildFonts = gulp.src('app/fonts/**/*')
        .pipe(gulp.dest('dist/fonts'));

    var buildJs = gulp.src('app/js/**/*')
        .pipe(gulp.dest('dist/js'));

    var buldHtml = gulp.src('app/*.html')
        .pipe(gulp.dest('dist'));
})