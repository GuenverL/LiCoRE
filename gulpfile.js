'use strict';

var gulp = require('gulp');
var sass = require('gulp-sass');
var cleanCSS = require('gulp-clean-css');
var uglify = require('gulp-uglify');
var concat = require('gulp-concat');

gulp.task('compress', function() {
  return gulp.src('./js/*.js')
    .pipe(uglify().on('error', console.log))
    .pipe(concat('bundle.min.js'))
    .pipe(gulp.dest('./dist'));
});

gulp.task('sass-minify', function() {
  return gulp.src('./css/**/*.scss')
    .pipe(sass.sync().on('error', sass.logError))
    .pipe(cleanCSS({
      compatibility: 'ie8',
    }))
    .pipe(gulp.dest('./dist'));
});

gulp.task('sass:watch', function() {
  gulp.watch('./css/**/*.scss', ['sass']);
});

gulp.task('default', ['compress', 'sass-minify']);
