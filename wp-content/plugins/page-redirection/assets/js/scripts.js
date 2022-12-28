/* On Page Loaded */
$(function () {
    AOS.init();
    // Add [PopUp] "Add Redirection"
    const popup = new PopUp();
    popup.init();

    // Show redirections
    update_redirection_table();

    // Show counters
    update_counters();


}); /* [x] on page loaded */

// TODO:
// # counters
// # graphics