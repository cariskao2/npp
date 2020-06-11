var gulp = require('gulp'),
	sass = require('gulp-sass'),
	autoprefixer = require('autoprefixer'),
	sourcemaps = require('gulp-sourcemaps'),
	plumber = require('gulp-plumber'),
	concat = require('gulp-concat'),
	postcss = require('gulp-postcss');

var path = {
	source: './source/',
	public: './public/',
	bower: './bower_components/',
	npm: './node_modules/'
}

gulp.task('sass', function () {
	var processors = [
		autoprefixer({
			browsers: ['last 5 version']
		}) // 使用 autoprefixer，這邊定義最新的五個版本瀏覽器
	];
	return gulp.src(path.source + 'scss/**/*.scss')
		.pipe(plumber())
		.pipe(sourcemaps.init())
		.pipe(sass({
			outputStyle: 'expanded',
			includePaths: [path.npm + 'bootstrap/scss']
		}).on('error', sass.logError))
		.pipe(postcss(processors))
		.pipe(sourcemaps.write('.'))
		.pipe(gulp.dest(path.public + 'css'));
});

gulp.task('concat', function () {
	return gulp.src('./source/js/**/*.js')
		.pipe(sourcemaps.init())
		.pipe(concat('all.js'))
		.pipe(sourcemaps.write('.'))
		.pipe(gulp.dest('./public/js'));
});

gulp.task('watch', function () {
	gulp.watch(path.source + 'scss/**/*.scss', ['sass']);
	gulp.watch('./source/js/**/*.js', ['concat'])
})

gulp.task('default', [
	'sass',
	'concat',
	'watch'
]);