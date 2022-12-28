/* On Page Loaded */
$(function () {

    // Animation
    AOS.init({
        offset: 40,
        duration: 1400
    });

    switch (PAGE_CURRENT) {

        case PAGE_PLATFORMS:
            listOfActions.push(ACTION_TOP_PLATFORM, ACTION_PIE_PLATFORM, ACTION_LINEAR_PLATFORM, ACTION_ALL_PLATFORM);
            break;
        case PAGE_BROWSERS:
            listOfActions.push(ACTION_TOP_BROWSER, ACTION_PIE_BROWSER, ACTION_LINEAR_BROWSER, ACTION_ALL_BROWSER);
            break;
        case PAGE_VIEWPORT:
            listOfActions.push(ACTION_TOP_VIEWPORT, ACTION_PIE_VIEWPORT, ACTION_LINEAR_VIEWPORT, ACTION_ALL_VIEWPORT);
            break;
        case PAGE_ETOROX:
            listOfActions.push(ACTION_TOP_VIEWPORT, ACTION_PIE_VIEWPORT, ACTION_LINEAR_VIEWPORT, ACTION_ALL_VIEWPORT, ACTION_TOP_PLATFORM, ACTION_PIE_PLATFORM, ACTION_LINEAR_PLATFORM, ACTION_ALL_PLATFORM, ACTION_TOP_BROWSER, ACTION_PIE_BROWSER, ACTION_LINEAR_BROWSER, ACTION_ALL_BROWSER);
            break;

        default:
            break;
    }

    listOfActions.forEach(action => {
        getData(action, PAGE_CURRENT);
    });
    // 

}); /* [x] on page loaded */