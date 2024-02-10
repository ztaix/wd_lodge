const gulp = require('gulp');
const concat = require('gulp-concat');
const uglify = require('gulp-uglify');

gulp.task('scripts', function() {
    return gulp.src([
        'public/Assets/js/jquery.3.7.1.min.js',
        'public/Assets/js/fullcalendar.6.1.9.min.js',
        'public/Assets/js/select2.min.js',
        'public/Assets/js/wd_function_toolbox.js',
        'public/Assets/js/wd_modal_system.js',
        'public/Assets/js/wd_html.js',
        'public/Assets/js/wd_fullcalendar.js',
        'public/Assets/js/wd_sidetools.js'
    ], { allowEmpty: true })
    .pipe(concat('all.min.js'))
    .pipe(uglify())
    .pipe(gulp.dest('public/Assets/js/all/'));
});

gulp.task('default', gulp.series('scripts'));
