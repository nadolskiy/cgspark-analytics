const backgroundImages = [
  {
    width: 1200,
    rename: {
      suffix: '-1200',
      extname: '.jpg',
    },
  },
  {
    width: 1200,
    rename: {
      suffix: '-1200',
      extname: '.webp',
    },
  },
  {
    width: 960,
    rename: {
      suffix: '-960',
      extname: '.jpg',
    },
  },
  {
    width: 960,
    rename: {
      suffix: '-960',
      extname: '.webp',
    },
  },
  {
    width: 640,
    rename: {
      suffix: '-640',
      extname: '.jpg',
    },
  },
  {
    width: 640,
    rename: {
      suffix: '-640',
      extname: '.webp',
    },
  },
  {
    width: 480,
    rename: {
      suffix: '-480',
      extname: '.jpg',
    },
  },
  {
    width: 480,
    rename: {
      suffix: '-480',
      extname: '.webp',
    },
  },
];

const assetsIcons = [
  {
    width: '100%',
    withoutEnlargement: true,
  },
  {
    width: 35,
    rename: {
      suffix: '-35',
      extname: '.png',
    },
  },
  {
    width: 35,
    rename: {
      suffix: '-35',
      extname: '.webp',
    },
  },
  {
    width: 70,
    rename: {
      suffix: '-70',
      extname: '.png',
    },
  },
  {
    width: 70,
    rename: {
      suffix: '-70',
      extname: '.webp',
    },
  },
];

const allImages = [
  {
    width: '100%',
    withoutEnlargement: true,
  },
  {
    width: '100%',
    rename: {
      extname: '.webp',
    },
    withoutEnlargement: true,
  },
];

module.exports = {
  backgroundImages,
  allImages,
  assetsIcons,
};
