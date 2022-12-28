const homePage = {
  'home-page': {
    name: 'home',
    source: 'sources/js/home/source-home.js',
    libs: [],
  },
};

const aboutUs = {
  'about-us': {
    name: 'about-us',
    source: 'sources/js/about-us-page/source-about-us.js',
    libs: [],
  },
};

module.exports = { ...homePage, ...aboutUs };
