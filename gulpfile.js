const gulp = require('gulp');
const concat = require('gulp-concat');
const uglify = require('gulp-uglify');
const postcss = require('gulp-postcss');
const cssnano = require('cssnano');

// Tâche existante pour les scripts
gulp.task('scripts', function() {
    return gulp.src([
        'public/Assets/js/jquery.3.7.1.min.js',
        'public/Assets/js/fullcalendar.6.1.9.min.js',
        'public/Assets/js/preline_select.js',
        'public/Assets/js/preline_inputnumber.js',
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

// Nouvelle tâche pour les styles
gulp.task('styles', function() {
    return gulp.src([
        'public/Assets/css/select2.min.css',
        'public/Assets/css/wd_composed_style.css',
        'public/Assets/css/wd_datepicker.css'
    ], { allowEmpty: true })
    .pipe(concat('all.min.css')) // Concaténer en un seul fichier
    .pipe(postcss([
        cssnano() // Minifier le CSS
    ]))
    .pipe(gulp.dest('public/Assets/css/all')); // Destination du fichier résultant
});

// Tâche par défaut exécutant les tâches 'scripts' et 'styles'
gulp.task('default', gulp.series('scripts', 'styles'));