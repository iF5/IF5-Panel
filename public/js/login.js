/**
 *
 * @param $component
 * @param $message
 */
function displayError($component, $message) {
    $($component).html('<p class="text-danger">' + $message + '</p>')
}

/**
 *
 * @param email
 * @returns {boolean}
 */
function validateEmail(email) {
    var reg = /^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
    return reg.test(email);
}

/**
 * Triggers
 */
$(function () {

    $('#password-reset-email').submit(function () {

        if (!validateEmail($('#email').val())) {
            displayError('.help-block', 'Digite um e-mail v&aacute;lido', true);
            return false;
        }

        return true;

    });


});