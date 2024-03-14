const gulp = require('gulp');
const concat = require('gulp-concat');
const uglify = require('gulp-uglify');
const postcss = require('gulp-postcss');
const cssnano = require('cssnano');

// Tâche pour minifier et concaténer les feuilles de style CSS
gulp.task('scripts', function () {
  return gulp
    .src(
      [
        'public/js/jquery.3.7.1.min.js',
        'public/js/fullcalendar.6.1.9.min.js',
        'public/js/preline_select.js',
        'public/js/preline_inputnumber.js',
        'public/js/select2.min.js',
        'public/js/wd_function_toolbox.js',
        'public/js/wd_modal_system.js',
        'public/js/wd_html.js',
        'public/js/wd_fullcalendar.js',
        'public/js/wd_sidetools.js',
      ],
      { allowEmpty: true }
    )
    .pipe(concat('all.min.js'))
    .pipe(
      uglify({
        mangle: {
          keep_fnames: true, // Empêche le changement des noms de fonction
        },
        compress: {
          sequences: true,
          properties: true,
          dead_code: true,
          drop_debugger: true,
          unsafe: false,
          unsafe_comps: false,
          conditionals: true,
          comparisons: true,
          evaluate: true,
          booleans: true,
          loops: true,
          unused: true,
          hoist_funs: true,
          keep_fargs: true,
          keep_fnames: true,
          hoist_vars: false,
          if_return: true,
          join_vars: true,
          collapse_vars: false,
          reduce_vars: false,
          side_effects: true,
          pure_getters: false,
          pure_funcs: null,
          negate_iife: false,
          drop_console: false,
          passes: 1,
          global_defs: {},
        },
      })
    )
    .pipe(gulp.dest('public/allAssets/'));
});

// Nouvelle tâche pour les styles
gulp.task('styles', function () {
  return gulp
    .src(['public/css/select2.min.css', 'public/css/wd_composed_style.css'], {
      allowEmpty: true,
    })
    .pipe(concat('all.min.css')) // Concaténer en un seul fichier
    .pipe(
      postcss([
        cssnano(), // Minifier le CSS
      ])
    )
    .pipe(gulp.dest('public/allAssets/')); // Destination du fichier résultant
});

// Tâche par défaut exécutant les tâches 'scripts' et 'styles'
gulp.task('default', gulp.series('scripts', 'styles'));
