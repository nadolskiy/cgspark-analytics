/**
 * Get Page URL value by parameter name
 * @param {string} name parameter name
 * @param {string} url url from where need to det the parameter, if empty - will take the current url
 * @returns parameter value
 */
function getParameterByName(name, url = window.location.href) {
    name = name.replace(/[\[\]]/g, '\\$&');
    var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, ' '));
} /* [x] getParameterByName() */


/**
 * Async Call to PHP functions
 * @param {object} argsObject list of variables
 * @param {*} php_file_name   name of .php file
 * @returns {*} data from .php function
 */
function asyncCall(argsObject, php_file_name) {

    // Check for arguments
    if (argsObject && typeof argsObject != "object") {
        console.log("This function get only arguments object.");
        return;
    } // [x] if (argsObject && typeof argsObject != "object") { ... }

    // AJAX
    $.ajax({
        url: document.location.origin +
            "/wp-content/plugins/viewport-size/functions/" +
            php_file_name +
            ".php",
        method: "GET",
        contentType: "application/json; charset=utf-8",
        data: argsObject,

        // Success
        success: (data) => {
            dataProcessing(argsObject, data);
        }, // success

        // Error
        error: () => {
            // Show error msg if exist
            if (argsObject.error) {
                console.error("Error: " + argsObject.error);
            } // [x] if (argsObject.error) { ... }

            console.error("Something wrong in asyncCall() function. 😔");
        }, // [x] error
    }); // [x] ajax
} // [x] function asyncCall(argsObject, php_file_name) { ... }