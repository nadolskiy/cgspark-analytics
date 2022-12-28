// Data
const
    YEAR_CURRENT            = new Date().getFullYear();

// Pages
const
    PAGE_CURRENT            = getParameterByName('page'),
    PAGE_PLATFORMS          = 'viewport_size',
    PAGE_BROWSERS           = 'viewport_size_browsers',
    PAGE_VIEWPORT           = 'viewport_size_viewport',
    PAGE_ETOROX             = 'viewport_size_etorox';

// Arrays
let listOfActions           = [];

// Actions
const

    // Platforms
    ACTION_TOP_PLATFORM     = 'platform',
    ACTION_PIE_PLATFORM     = 'platform_graph',
    ACTION_LINEAR_PLATFORM  = 'platform_graph_period',
    ACTION_ALL_PLATFORM     = 'platform_all';

    // Browsers
    ACTION_TOP_BROWSER      = 'top_browsers',
    ACTION_PIE_BROWSER      = 'browser_graph',
    ACTION_LINEAR_BROWSER   = 'browser_graph_period',
    ACTION_ALL_BROWSER      = 'browser_all';

    // Viewport
    ACTION_TOP_VIEWPORT     = 'top_3_desktop_width',
    ACTION_PIE_VIEWPORT     = 'width_graph',
    ACTION_LINEAR_VIEWPORT  = 'width_graph_period',
    ACTION_ALL_VIEWPORT     = 'width_all';


// ID
const
    ID_TOP_PLATFORM         = '#top-3-platforms',
    
    // Browsers
    ID_TOP_BROWSER          = '#top-3-browsers',

    ID_PIE_YEAR_BROWSER     = '#currentYear2ForBrowser',
    ID_PIE_GRAPH_BROWSER    = 'graph-browser-by-segment',
    ID_LINEAR_YEAR_BROWSER  = '#currentYearForBrowser',
    ID_LINEAR_GRAPH_BROWSER = 'graph-browser-by-months',
    ID_ALL_BROWSER          = '#browser-data-list';