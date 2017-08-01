function Validate() {

    var regExr = {
        'CEP': /[0-9]{5}\-[0-9]{3}/g,
        'CNPJ': /[0-9]{2}\.[0-9]{3}\.[0-9]{3}\/[0-9]{4}\-[0-9]{2}/g,
        'CPF': /[0-9]{3}\.[0-9]{3}\.[0-9]{3}\-[a-zA-Z0-9]{2}/g,
        'DATE': /[0-9]{2}\/[0-9]{2}\/[0-9]{4}/g,
        'DDD': /[0-9]{2,3}/g,
        'EMAIL': /[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_-]+([.][a-zA-Z0-9_-]+)*[.][a-zA-Z]{2,4}/g,
        'NUMBER': /[0-9]/g,
        'PHONE': /[0-9]{4,5}\-[0-9]{4}/g,
        'RG': /[0-9]{2}\.[0-9]{3}\.[0-9]{3}\-[a-zA-Z0-9]{1}/g,
        'VOID': '',
        'EQUALS': '=',
        'MIN': 1,
        'MAX': 10
    };

    /*var hit = {
        error: false,
        fields: [],
        messages: ''
    };

    var rules = {
        VOID : function (i, options) {
            if ((value === null) || (value.length < 1)) {
                return {

                }
            }
        }

    };*/




    var errorBorderColor = '#FF0000';

    /**
     * Routine to customize regular expression
     *
     * @param {string} key
     * @param {code} value
     * @returns {undefined}
     */
    this.setRegExr = function (key, value) {
        regExr[key] = value;
    };

    /**
     * @param {string} value
     */
    this.setErrorBorderColor = function (value) {
        errorBorderColor = value;
    };

    /**
     * Routine to validate data entry of type text, based on the parameter "type" .: [CEP, CNPJ, CPF, DATE, DDD, EMAIL, NUMBER, PHONE, RG, VOID]
     * @param {object} options Ex.:
     * {'ELEMENT': {value: $('#ELEMENT').val(), message: 'Required field', type: 'VOID'}}
     *
     * @param options
     * @returns {{error: boolean, messages: string}}
     */
    this.assert = function (options) {
        var response = {isSuccess: true, messages: ''};
        try {
            options = (typeof (options) === 'object') ? options : new Object();
            var isError = false, messages = '', fields = new Array();

            var toError = function (i) {
                isError = true;
                fields[i] = i;
                messages += (options[i].message !== undefined) ? options[i].message : '';
            };

            for (var i in options) {
                var upper = (options[i].type === undefined) ? 'VOID' : options[i].type.toUpperCase();
                var type = (regExr[upper] === undefined) ? 'VOID' : upper;
                var value = $.trim(options[i].value);

                switch (type) {
                    case 'VOID':
                        if ((value === null) || (value.length < 1)) {
                            toError(i);
                        }
                        break;
                    case 'EQUALS':
                        var compareValue = (options[i].compareValue === undefined) ? null : $.trim(options[i].compareValue);
                        if (value !== compareValue) {
                            toError(i);
                        }
                        break;
                    case 'MIN':
                        var min = (options[i].min === undefined) ? regExr.MIN : options[i].min;
                        if (value.length < min) {
                            toError(i);
                        }
                        break;
                    case 'MAX':
                        var max = (options[i].max === undefined) ? regExr.MAX: options[i].max;
                        if (value.length > max) {
                            toError(i);
                        }
                        break;
                    default:
                        if (!(regExr[type].test(value))) {
                            toError(i);
                        }
                        break;
                }

            }

            if (isError) {
                throw {messages: messages, fields: fields};
            }
        } catch (e) {
            for (var i in e.fields) {
                $(i).css({'border-color': errorBorderColor});
            }
            response = {isSuccess: false, messages: e.messages};
        } finally {
            return response;
        }
    };

}

/**
 * Triggers
 */
$(function () {

    var validate = new Validate();

    $('#password-reset-email').submit(function () {
        var response = validate.assert({
            '#email': {value: $('#email').val(), type: 'EMAIL'}
        });
        return response.isSuccess;
    });

    $('input').on('focus', function () {
        $(this).css('border', '');
    });

});