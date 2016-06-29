var gulp       = require('gulp');
var postcss    = require('gulp-postcss');
var cssnext    = require('gulp-cssnext');
var sourcemaps = require('gulp-sourcemaps');
var sass       = require('gulp-sass');
var rjs        = require('gulp-requirejs');
var uglify     = require('gulp-uglify');

gulp.task('default', function() {
  // place code for your default task here
});

// Autoprefixer and some other things.
gulp.task('css', function () {
  return gulp.src('./*.css')
    .pipe( sourcemaps.init() )
    .pipe( postcss([ require('autoprefixer'), require('precss') ]) )
    .pipe( sourcemaps.write('.') )
    .pipe( gulp.dest('./') );
});

// Turn .scss files into .css.
gulp.task('sass', function () {
  gulp.src('./assets/sass/*.scss')
    .pipe(sass().on('error', sass.logError))
    .pipe(gulp.dest(''));
});

gulp.task('sass:watch', function () {
  gulp.watch('./assets/sass/*.scss', ['sass']);
  gulp.watch('./assets/sass/components/*.scss', ['sass']);
});

// Minify CSS
gulp.task("cssnext", function() {
  gulp.src("./*.css")
    .pipe(cssnext({
        compress: true
    }))
    .pipe(gulp.dest("./"));
});

// JS stuff
gulp.task('js', function() {
  rjs({
    baseUrl: '.',
    out: 'assets/js/main-min.js',
    // standard require.js shim options
    mainConfigFile:          'assets/js/main.js',
    preserveLicenseComments: false,
    useStrict:               true,
    wrap:                    true,
    name:                    'bower_components/almond/almond',
    include:                 'assets/js/main',
    shim: {
    },
    // ... more require.js options
  })
  .pipe(uglify())
  .pipe(gulp.dest('.')); // pipe it to the output DIR
});
