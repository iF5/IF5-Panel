/**
 * Triggers
 */
$(function () {

    var validate = new Validate();

    /**
     * Form validate login
     */
    $('#form-login').submit(function () {
        var response = validate.assert({
            '#login': {value: $('#login').val(), type: 'EMAIL'},
            '#password': {value: $('#password').val(), type: 'VOID'}
        });

        return response.isSuccess;
    });

    /**
     * Form validate password email
     */
    $('#form-password-email').submit(function () {
        var response = validate.assert({
            '#email': {value: $('#email').val(), type: 'EMAIL'}
        });

        return response.isSuccess;
    });


    /**
     * Form validate password reset
     */
    $('#form-password-reset').submit(function () {
        var response = validate.assert({
            '#password': {value: $('#password').val(), type: 'MIN', min: 6},
            '#passwordConfirm': {value: $('#password').val(), compareValue: $('#passwordConfirm').val(), type: 'EQUALS'}
        });

        return response.isSuccess;
    });

    /**
     * Reset input border color
     */
    $('input').on('focus', function () {
        $(this).css('border', '');
    });

});