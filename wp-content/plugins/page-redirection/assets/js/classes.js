/** ************************************************************************** *
 * [POPUP] ADD NEW REDIRECTION                                                 *
 ** ************************************************************************* */
class PopUp {

    constructor(title, source_url, target_url) {
        this.title = title;
        this.source_url = source_url;
        this.target_url = target_url;
    }

    // Init
    init() {

        // Add Button to the top menu
        $(`#${ID_WP_ADMIN_PANEL_BAR_TOP}`).append(LI_BTN_ADD_REDIRECTION);

        // Show/Hide POPUP
        $(`#${ID_BTN_ADD_REDIRECTION}`).on('click', () => {
            this.showHide();
        });

        // Hide POPUP
        $(`#${ID_BTN_CLOSE_POPUP}`).on('click', () => {
            this.showHide();
        });

        $(`#rp-remove-rule-block-close`).on('click', () => {
            this.showHideRemoveWindow();
        });

       

        // Check if rule not exist
        $('#rp-source-url').on('focusout', () => {
            if (this.checkField('source')) {

                this.ifUniqueSourceURL();
            }
        });

        // On Submit button clicked
        $(`#${ID_POPUP_BTN_SUBMIT}`).on('click', () => {


            let isSourceGood = this.checkField('source'),
                isTargetGood = this.checkField('target');

            // Checking if all data entered
            if (isSourceGood && isTargetGood) {

                let isUnique = this.ifUniqueSourceURL();
                if (isUnique) {
                    asyncCall({
                            action: "add",
                            source_url: $('#rp-source-url').val(),
                            target_url: $('#rp-target-url').val(),
                            query_parameter: $('input[name=query-parameters]:checked').val(),
                            error: "Cant add the new redirection",
                        },
                        "db"
                    );
                    this.showHide();
                }

            }

        });

    } // [x] init() { ... }

    // Show / Hide PopUp
    showHide() {

        this.clear();

        if ($(`#${ID_BTN_ADD_REDIRECTION}`).hasClass('color-red')) {
            $(`#${ID_POPUP_REDIRECTION}`).hide('slow');
            $(`#${ID_POPUP_BTN_SYMBOL}`).text('+');
            $(`#${ID_POPUP_BTN_TEXT}`).text(BUTTON_OPEN_POPUP_REDIRECTION_BUTTON_TEXT);
        } else {
            $(`#${ID_POPUP_REDIRECTION}`).show('slow');
            $(`#${ID_POPUP_BTN_SYMBOL}`).text('');
            $(`#${ID_POPUP_BTN_TEXT}`).text(BUTTON_CLOSE_POPUP_REDIRECTION_BUTTON_TEXT);
        }

        $(`#${ID_BTN_ADD_REDIRECTION}`).toggleClass('color-red');

    } // [x] showHide() { ... }

    // Show / Hide Remove PopUp
    showHideRemoveWindow() {


        if ($(`#pop-up-remove-redirection`).is(":hidden")) {
            $(`#pop-up-remove-redirection`).show('slow');
        } else {
            $(`#pop-up-remove-redirection`).hide('slow');
        }

    }

    // Check Field
    checkField(field) {

        let value = field === 'source' ? $('#rp-source-url').val().trim() : $('#rp-target-url').val().trim();

        if (value) {
            $('#' + field + '_error').hide();
            $('#' + field + '_good').show();
            $('#' + field + '_good').parent().css('color', '#505353');
            return true;
        } else {
            $('#' + field + '_good').hide();
            $('#' + field + '_error').show();
            $('#' + field + '_error').parent().css('color', '#FF0000');
            return false;
        }

    } // [x] checkField(fieldName) { ... }


    // Check if source URL is unique
    ifUniqueSourceURL() {

        let source_url = $('#rp-source-url').val().trim();
        let result = true;

        $('.pr-redirect-source-url').each(function (i, obj) {
            console.log(i, obj, $(obj).text());
            if ($(obj).text().trim() === source_url) {
                console.log('EXIST');
                $('#source_good').hide();
                $('#source_error').show();
                $('#source_error').parent().css('color', '#FF0000');
                $('#error-source-exist').show();
                result = false;
            }
        });

        if (result) {
            $('#error-source-exist').hide();
        }
        return result;

    } // [x] ifUniqueSourceURL() { ... }

    // Clear fields and hide errors
    clear() {
        $('#source_good').parent().css('color', '#505353');
        $('#target_error').parent().css('color', '#505353');
        $('#source_error').hide();
        $('#source_good').hide();
        $('#target_good').hide();
        $('#target_error').hide();
        $('#rp-source-url').val('');
        $('#rp-target-url').val('');
    } // [x] clear() { ... }

    // Show / Hide Delete Message
    delete() {

        $('#rp-remove-text').html(`Do you want to remove this redirection? <br><br><small>Source:</small> <span>${document.location.origin}/${this.source_url}</span> <br><small>Target:</small>&nbsp;<span>${this.target_url}</span>`);

        this.showHideRemoveWindow();

        $('#rp-submit-remove-new-icon').on('click', () => {
            console.log('Clicked, '+ this.source_url);
            asyncCall({
                    action: "remove",
                    source_url: this.source_url,
                    error: "Redirection was not deleted",
                },
                "db"
            );
            this.showHideRemoveWindow();
        });

    }

} // [x] class PopUp() {...}