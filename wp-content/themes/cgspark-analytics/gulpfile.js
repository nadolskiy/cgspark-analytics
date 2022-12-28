/* Disable ESLint for gulpfile */
/* eslint-disable */

/* -------- Domain Const -------- */
const serverDomain = 'localhost:10035';
// const serverDomain = 'etorox.local';

const preprocessor = 'scss'; // Syntax: sass or scss;
const filesWatch   = 'html,htm,txt,json,md,woff2';
const imagesWatch  = 'jpg,jpeg,png,webp,svg';

const { src, dest, parallel, series, watch } = require('gulp');
const sass          = require('gulp-sass');
const browserSync   = require('browser-sync').create();
const concat        = require('gulp-concat');
const uglify        = require('gulp-uglify-es').default;
const cleancss      = require('gulp-clean-css');
const rename        = require('gulp-rename');
const autoprefixer  = require('gulp-autoprefixer');
const notify        = require('gulp-notify');
const newer         = require('gulp-newer');
const imagemin      = require('gulp-imagemin');
const gcmq          = require('gulp-group-css-media-queries');
const rsync         = require('gulp-rsync');
const del           = require('del');
const php           = require('gulp-connect-php');
const localServer   = new php();
const sourcemaps    = require('gulp-sourcemaps');
const responsiveImg = require('gulp-responsive');
const responsiveConfig = require('./gulp/configs/image-responsive-config.js');

const scriptsByPage = require('./gulp/scripts-by-page.js');

/* ---------- Json Interface ---------- */
// It's example of object for scripts.

// const homePage = {
//   'home-page': {
//     name: 'home',
//     source: 'sources/js/home/source-home.js',
//     libs: [
//       'sources/libs/test.js',
//       'sources/libs/libs.js',
//     ],
//   },
// };

function scripts(done) {
    const scripts = scriptsByPage;

    Object.keys(scripts).map((key) => {
      return src([...scripts[key].libs, scripts[key].source])
      .pipe(newer('assets/js'))
      .pipe(sourcemaps.init())
      .pipe(concat(`${scripts[key].name}.js`))
      // If need unmin version
      // .pipe(dest(`assets/js/${scripts[key].name}`))
      .pipe(uglify())
      .pipe(rename({
        suffix: '.min'
      }))
      .pipe(sourcemaps.write('.'))
      .pipe(dest(`assets/js/${scripts[key].name}`));
    });
    done();
};

function styles() {
  return src(`sources/${preprocessor}/**/*.${preprocessor}`)
    .pipe(sass({
      outputStyle: 'expanded'
    }).on('error', notify.onError()))
    .pipe(autoprefixer({
      overrideBrowserslist: ['last 10 versions'],
      grid: true
    }))
    .pipe(sourcemaps.init())
    // If you need also a unmin css file
    // .pipe(dest('sources/css'))
    .pipe(gcmq())
    .pipe(cleancss({
      level: {
        1: {
          specialComments: 0
        }
      }
    }))
    .pipe(rename({
      suffix: '.min',
    }))
    .pipe(sourcemaps.write('.'))
    .pipe(dest('assets/css'))
};

function images() {
	return src('sources/images/**/*')
  .pipe(newer('assets/images'))
  .pipe(responsiveImg({
    '**/background-*.{jpg,png,jpeg}': responsiveConfig.backgroundImages,
    '**/asset-*.{jpg,png,jpeg}': responsiveConfig.assetsIcons,
    '**/*.{jpg,png,jpeg}': responsiveConfig.allImages,
  }, {
    errorOnUnusedConfig: false,
    errorOnEnlargement: false,
    withMetadata: false,
    skipOnEnlargement: true,
    errorOnUnusedConfig: false,
    errorOnUnusedImage: false,
    silent: true
  }))
	.pipe(imagemin())
	.pipe(dest('assets/images'));
};

function cleanImg() {
	return del('assets/images/**/*', { force: true })
};

function deploy() {
	return src('app/')
	.pipe(rsync({
		root: 'app/',
		hostname: 'username@yousite.com',
		destination: 'yousite/public_html/',
		// include: ['*.htaccess'], // Included files
		exclude: ['**/Thumbs.db', '**/*.DS_Store'], // Excluded files
		recursive: true,
		archive: true,
		silent: false,
		compress: true
	}))
}

function fonts() {
  return src('sources/fonts/**/*')
  .pipe(dest('assets/fonts'))
}

/* ---------- Watchers ---------- */

function watchPHP() {
  localServer.server({
    stdio: 'ignore'
  }, () => {
    console.log('');
    console.log('\x1b[32m', 'PHP Development Server Connected. Have an amazing day! 😄');
    console.log('');

    browserSync.init({
      proxy: serverDomain,
      notify: false,
      logFileChanges: false
    });
  });

  watch(['./**/*.php']).on('change', () => {
    browserSync.reload();
  });
}

function watchSass() {
  watch(`sources/${preprocessor}/**/*`, parallel('styles')).on('change', browserSync.reload);
}

function watchImages() {
  watch([`sources/**/*.{${imagesWatch}}`], parallel('images'));
}

function watchFiles() {
  watch([`sources/**/*.{${filesWatch}}`]).on('change', browserSync.reload);
}

function watchJS() {
  watch(['sources/**/*.js'], parallel('scripts')).on('change', browserSync.reload);
}

function startWatch() {
  watchPHP();
  watchSass();
  watchImages();
  watchFiles();
  watchJS();
}

exports.styles    = styles;
exports.fonts     = fonts;
exports.scripts   = scripts;
exports.cleanImg  = cleanImg;
exports.images    = images;
exports.deploy    = deploy;

exports.assets = series(
  cleanImg, 
  styles, 
  images,
  scripts,
  fonts,
);

exports.default = parallel(
  styles, 
  images,
  scripts, 
  startWatch,
  fonts
);

