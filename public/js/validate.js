function Validate() {

    /**
     * @type {{CEP: RegExp, CNPJ: RegExp, CPF: RegExp, DATE: RegExp, DDD: RegExp, EMAIL: RegExp, NUMBER: RegExp, PHONE: RegExp, RG: RegExp, VOID: string, EQUALS: string, MIN: number, MAX: number}}
     */
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

    var errorBorderColor = '#FF0000';

    /**
     * @type {{VOID: rules.VOID, EQUALS: rules.EQUALS, MIN: rules.MIN, MAX: rules.MAX, DEFAULT: rules.DEFAULT}}
     */
    var rules = {
        VOID: function (i, options) {
            var value = $.trim(options[i].value) || '';
            return ((value === null) || (value.length < 1)) ? false : true;
        },
        EQUALS: function (i, options) {
            var value = $.trim(options[i].value) || '';
            var compareValue = $.trim(options[i].compareValue) || '';
            return (value !== compareValue) ? false : true;
        },
        MIN: function (i, options) {
            var value = $.trim(options[i].value) || '';
            var min = parseInt(options[i].min) || 1;
            return (value.length < min) ? false : true;
        },
        MAX: function (i, options) {
            var value = $.trim(options[i].value) || '';
            var max = parseInt(options[i].max) || 10;
            return (value.length > max) ? false : true;
        },
        DEFAULT: function (i, options, type) {
            var value = $.trim(options[i].value) || '';
            return (!regExr[type].test(value)) ? false : true;
        }
    };

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
            options = (typeof (options) === 'object') ? options : {};
            var isError = false, messages = '', fields = [];
            var toError = function (i) {
                isError = true;
                fields[i] = i;
                messages += (options[i].message !== undefined) ? options[i].message : '';
            };

            for (var i in options) {
                var upper = (options[i].type === undefined) ? 'VOID' : options[i].type.toUpperCase();
                var type = (regExr[upper] === undefined) ? 'VOID' : upper;

                if (rules[type] === undefined) {
                    if (!rules.DEFAULT(i, options, type)) {
                        toError(i);
                    }
                } else {
                    if (!rules[type](i, options)) {
                        toError(i);
                    }
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