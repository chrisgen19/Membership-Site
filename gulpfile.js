const gulp = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const sourcemaps = require('gulp-sourcemaps');
const autoprefixer = require('gulp-autoprefixer');
const browserSync = require('browser-sync').create();
const terser = require('gulp-terser');
const imagemin = require('gulp-imagemin');
const postcss = require('gulp-postcss');
const cssnano = require('cssnano');
const concat = require('gulp-concat');

const config = {
    proxyURL: 'https://membership.test',
    paths: {
        styles: {
            src: {
                main: 'assets/sass/main.scss',
                memberpress: 'assets/sass/memberpress.scss'
            },
            dest: 'assets/css'
        },
        scripts: {
            src: [
                'node_modules/@popperjs/core/dist/umd/popper.js',
                'node_modules/bootstrap/dist/js/bootstrap.js',
                'assets/js/src/**/*.js'
            ],
            dest: 'assets/js/dist'
        },
        images: {
            src: 'assets/images/src/**/*',
            dest: 'assets/images/dist'
        },
        php: '**/*.php'
    }
};  

function mainStyles() {
    return compileScss(config.paths.styles.src.main, 'main.css');
}

function memberpressStyles() {
    return compileScss(config.paths.styles.src.memberpress, 'memberpress.css');
}

function compileScss(src, outputName) {
    return gulp.src(src)
        .pipe(sourcemaps.init())
        .pipe(sass({
            outputStyle: 'compressed'
        }).on('error', sass.logError))
        .pipe(autoprefixer())
        .pipe(postcss([cssnano()]))
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest(config.paths.styles.dest))
        .pipe(browserSync.stream());
}

function scripts() {
    return gulp.src(config.paths.scripts.src, { 
        sourcemaps: true,
        allowEmpty: true
    })
        .pipe(sourcemaps.init())
        .pipe(concat('main.js'))
        .pipe(terser())
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest(config.paths.scripts.dest))
        .pipe(browserSync.stream());
}

function images() {
    return gulp.src(config.paths.images.src)
        .pipe(imagemin([
            imagemin.gifsicle({ interlaced: true }),
            imagemin.mozjpeg({ quality: 75, progressive: true }),
            imagemin.optipng({ optimizationLevel: 5 }),
            imagemin.svgo({
                plugins: [
                    { removeViewBox: false },
                    { cleanupIDs: false }
                ]
            })
        ]))
        .pipe(gulp.dest(config.paths.images.dest));
}

function serve(done) {
    browserSync.init({
        proxy: config.proxyURL,
        injectChanges: true,
        open: false
    });
    done();
}

function watchFiles() {
    gulp.watch(config.paths.styles.src.main, mainStyles);
    gulp.watch(config.paths.styles.src.memberpress, memberpressStyles);
    gulp.watch(config.paths.scripts.src, scripts);
    gulp.watch(config.paths.images.src, images);
    gulp.watch(config.paths.php).on('change', browserSync.reload);
}

const styles = gulp.parallel(mainStyles, memberpressStyles);
const watch = gulp.series(
    gulp.parallel(styles, scripts, images),
    serve,
    watchFiles
);

const build = gulp.parallel(styles, scripts, images);

exports.styles = styles;
exports.mainStyles = mainStyles;
exports.memberpressStyles = memberpressStyles;
exports.scripts = scripts;
exports.images = images;
exports.watch = watch;
exports.build = build;
exports.default = watch;