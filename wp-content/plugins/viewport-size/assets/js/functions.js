function getData(data, page) {
  asyncCall({
      action: page,
      function: data,
      error: "Can't get the list of all redirects",
    },
    "db"
  );
}

/**
 * 
 * @param {*} requestArguments 
 * @param {*} receivedData 
 */
function dataProcessing(requestArguments, receivedData) {
  

  // Platmorms
  if (requestArguments.action === 'viewport_size') {
    if (requestArguments.function === 'platform') {
      $('#top-3-platforms').html(receivedData);
    } else if (requestArguments.function === 'platform_graph') {
      drawPieGraph(JSON.parse(receivedData), 'graph-platform-by-segment');
      $('#currentYear2').html(new Date().getFullYear());
    } else if (requestArguments.function === 'platform_graph_period') {
      drawLineGraph(JSON.parse(receivedData), 'graph-platform-by-months');
      $('#currentYear').html(new Date().getFullYear());
    } else if (requestArguments.function === 'platform_all') {
      $('#platform-data-list').html(receivedData);
    }

    // EtoroX
  } else if (requestArguments.action === 'viewport_size_etorox') {
    if (requestArguments.function === 'platform') {
      $('#top-3-platforms').html(receivedData);
    } else if (requestArguments.function === 'platform_graph') {
      drawPieGraph(JSON.parse(receivedData), 'graph-platform-by-segment');
      $('#currentYear2').html(new Date().getFullYear());
    } else if (requestArguments.function === 'platform_graph_period') {
      drawLineGraph(JSON.parse(receivedData), 'graph-platform-by-months');
      $('#currentYear').html(new Date().getFullYear());
    } else if (requestArguments.function === 'platform_all') {
      $('#platform-data-list').html(receivedData);
    } else if (requestArguments.function === 'top_browsers') {
      $('#top-3-browsers').html(receivedData);
    } else if (requestArguments.function === 'browser_graph') {
      drawPieGraph(JSON.parse(receivedData), 'graph-browser-by-segment');
      $('#currentYear2ForBrowser').html(new Date().getFullYear());
    } else if (requestArguments.function === 'browser_graph_period') {
      drawLineGraph(JSON.parse(receivedData), 'graph-browser-by-months');
      $('#currentYearForBrowser').html(new Date().getFullYear());
    } else if (requestArguments.function === 'browser_all') {
      $('#browser-data-list').html(receivedData);
      onPointerClick();
    }

    /* *** * ViewPort * *** */
    // Top 3 window width
    else if (requestArguments.function === 'top_3_desktop_width') {
      $('#top-3-viewport--desktop-width').html(receivedData);
    }

    // Pie Graph
    if (requestArguments.function === 'width_graph') {
      drawPieGraph(JSON.parse(receivedData), 'graph-viewport-by-months');
      $('#pieYear').html(new Date().getFullYear());
    }

    // Period Graph
    else if (requestArguments.function === 'width_graph_period') {
      drawLineGraph(JSON.parse(receivedData), 'graph-viewport-by-segment');
      $('#monthYear').html(new Date().getFullYear());
    }



  } // [x] eToroX

  // Browsers 
  else if (requestArguments.action === PAGE_BROWSERS) {

    switch (requestArguments.function) {
      case ACTION_TOP_BROWSER:
        $(ID_TOP_BROWSER).html(receivedData);
        break;
      
      case ACTION_PIE_BROWSER:
        drawPieGraph(JSON.parse(receivedData), ID_PIE_GRAPH_BROWSER);
        $(ID_PIE_YEAR_BROWSER).html(YEAR_CURRENT);
        break;

      case ACTION_LINEAR_BROWSER:
         drawLineGraph(JSON.parse(receivedData), ID_LINEAR_GRAPH_BROWSER);
         $(ID_LINEAR_YEAR_BROWSER).html(new Date().getFullYear());
        break;

      case ACTION_ALL_BROWSER:
         $(ID_ALL_BROWSER).html(receivedData);
         onPointerClick();
        break;
    
      default:
        break;
    } // [x] switch (requestArguments.function) {...}

  } // [x] browsers 

  // ViewPort
  else if (requestArguments.action === 'viewport_size_viewport') {

    // Top 3 window width
    if (requestArguments.function === 'top_3_desktop_width') {
      $('#top-3-viewport--desktop-width').html(receivedData);
    }

    // Pie Graph
    else if (requestArguments.function === 'width_graph') {
      drawPieGraph(JSON.parse(receivedData), 'graph-viewport-by-months');
      $('#pieYear').html(new Date().getFullYear());
    }

    // Period Graph
    else if (requestArguments.function === 'width_graph_period') {
      drawLineGraph(JSON.parse(receivedData), 'graph-viewport-by-segment');
      $('#monthYear').html(new Date().getFullYear());
    }

    // All width
    else if (requestArguments.function === 'width_all') {
      $('#width-data-list').html(receivedData);
      onPointerClick();
    }

  } // [x] viewPort


}




function drawPieGraph(graphJSON, id) {
  let platform_labels = [];
  let platform_data = [];
  let platform_bg_color = [];
  Object.keys(graphJSON).forEach(key => {
    platform_bg_color.push(getColoHexColor(key));
    platform_labels.push(key);
    platform_data.push(graphJSON[key]);
  });
  const graphData = {
    labels: platform_labels,
    datasets: [{
      label: 'My First Dataset',
      data: platform_data,
      backgroundColor: platform_bg_color,
    }]
  };
  const config = {
    type: 'doughnut',
    data: graphData,
    options: {
      plugins: {
        legend: {
          // display: false
          labels: {
            // This more specific font property overrides the global property
            font: {
              size: 11,
              family: "'Roboto', sans-serif"
            }
          }
          // }
        },

      },
    },
  };


  const myChart = new Chart(document.getElementById(id), config);
}

function drawLineGraph(graphJSON, id) {

  let platformLabels = [];
  // Get  platforms
  Object.keys(graphJSON).forEach(monthNumber => {
    Object.keys(graphJSON[monthNumber]).forEach(platformName => {
      platformLabels.indexOf(platformName) === -1 ? platformLabels.push(platformName) : '';
    });
  });

  let platformCount = platformLabels.length;
  platformLabels.sort();
  // console.log(platformCount, platformLabels);

  let dataSetArray = [];

  platformLabels.forEach(element => {

    let elementColor = getColoHexColor(element, true, 20);

    let color = elementColor.color;
    let bgColor = elementColor.backgroundColor;

    // Get Data
    let dataArray = [NaN, NaN, NaN, NaN, NaN, NaN, NaN, NaN, NaN, NaN, NaN, NaN];
    Object.keys(graphJSON).forEach(monthNumber => {
      Object.keys(graphJSON[monthNumber]).forEach(platformName => {

        if (element === platformName) {
          dataArray[monthNumber - 1] = graphJSON[monthNumber][platformName];
          // console.log(element + " [" + monthNumber + "] : " + graphJSON[monthNumber][platformName]);
        }

      });
    });

    dataSetArray.push({
      label: element,
      data: dataArray,
      borderColor: color,
      backgroundColor: bgColor,
      fill: false,
      cubicInterpolationMode: 'monotone',
      tension: 0.2
    });
  });

  const labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
  const data = {
    labels: labels,
    datasets: dataSetArray
  };


  const config = {
    type: 'line',
    data: data,
    options: {
      responsive: true,
      plugins: {
        title: {
          display: false,
          text: 'Type some title here'
        },
        legend: {
          // display: false
          labels: {
            // This more specific font property overrides the global property
            font: {
              size: 11,
              family: "'Roboto', sans-serif"
            }
          }
          // }
        },
        tooltips: {
          // enabled: false
        }
      },
      interaction: {
        intersect: false,
      },
      scales: {
        x: {
          display: true,
          title: {
            display: true
          }
        },
        y: {
          display: true,
          title: {
            display: false,
            text: 'Value'
          },
          // suggestedMin: -10,
          // suggestedMax: 200
        }
      }
    },
  };
  const myChart = new Chart(document.getElementById(id), config);
}


function onPointerClick() {
  $('.pointer').on('click', (element) => {
    let id = $(element.currentTarget).attr('data-id');
    $('.child-id-' + id).toggleClass('d-none');
  });
}

/**
 * Get element color by name.
 * @param {string}  element name of the platform/browser etc.
 * @param {boolean} backGroundColor is needed to get background color.
 * @param {int}     backgroundColorOpacity is needed to change background color opacity.
 * 
 * @returns {string} hex color in format #C1C1C1
 * @returns {JSON} hex color in format #C1C1C1, and background color in format #C1C1C120
 */
function getColoHexColor(element, backGroundColor = false, backgroundColorOpacity = 20) {
  element = element.toLowerCase();
  let color = '#000000';

  // Windows versions
  if (element.includes('windows')) {
    element = 'windows';
  }

  // Android versions
  else if (element.includes('android')) {
    element = 'android';
  }

  switch (element) {

    // Windows
    case 'windows':
      color = '#0b62cc';
      break;

    case 'edge':
      color = '#0D559D';
      break;

      // Linux
    case 'linux':
      color = '#dd4814';
      break;

      // Google
    case 'android':
      color = '#3DDC84';
      break;

    case 'google chrome':
      color = '#0E9D58';
      break;

      // Apple
    case 'mac':
      color = '#A2AAAD';
      break;

    case 'ipad':
      color = '#fad6b0';
      break;

    case 'safari':
      color = '#1982EF';
      break;

    case 'safari mobile':
      color = '#0ABBEA';
      break;

    case 'iphone':
      color = '#B00D23';
      break;

    case 'other':
      color = '#9e7bb5';
      break;

    case 'firefox':
      color = '#9157FD';
      break;

    case 'opera':
      color = '#C6081C';
      break;

    case 'ibrowse':
      color = '#D0CA5E';
      break;

    case 'ucbrowser':
      color = '#F99834';
      break;

      //  Samsung
    case 'samsung':
      color = '#034EA2';
      break;

    case 'samsung browser':
      color = '#7882FF';
      break;

      // Xiaomi 
    case 'redmi':
      color = '#FF6700';
      break;

    case 'huawei browser':
      color = '#1370EB';
      break;

    default:
      color = '#' + Math.floor(Math.random() * 16777215).toString(16);
      break;
  }

  color = color.toUpperCase();

  if (backGroundColor) {
    return {
      color: color.toUpperCase(),
      backgroundColor: color + backgroundColorOpacity
    };
  } else {
    return color;
  }


}; // function getColoHexColor(element){ ... }