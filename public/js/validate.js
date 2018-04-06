function Validate() {

    /**
     * @type {{CEP: RegExp, CNPJ: RegExp, CPF: RegExp, DATE: RegExp, DDD: RegExp, EMAIL: RegExp, NUMBER: RegExp, PHONE: RegExp, RG: RegExp, VOID: string, EQUALS: string, MIN: number, MAX: number}}
     */
    var regExr = {
        'CEP': /\d{5}[-]\d{3}/,
        'CNPJ': /[0-9]{2}\.[0-9]{3}\.[0-9]{3}\/[0-9]{4}\-[0-9]{2}/g,
        'CPF': /[0-9]{3}\.[0-9]{3}\.[0-9]{3}\-[a-zA-Z0-9]{2}/g,
        'DATE': /[0-9]{2}\/[0-9]{2}\/[0-9]{4}/g,
        'DDD': /[0-9]{2,3}/g,
        'EMAIL': /^[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$/i,
        'NUMBER': /[0-9]/,
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
        CPF: function (i, options) {
            return isCpf(options[i].value);
        },
        CNPJ: function (i, options) {
            return isCnpj(options[i].value);
        },
        DEFAULT: function (i, options, type) {
            var value = $.trim(options[i].value) || '';
            return (!regExr[type].test(value)) ? false : true;
        }
    };

    /**
     * @param cpf
     * @returns {boolean}
     */
    function isCpf(cpf) {
        cpf = cpf.replace(/[^\d]+/g, '');
        var sum = 0;
        var residue;
        if (cpf == '00000000000') {
            return false;
        }
        for (var i = 1; i <= 9; i++) {
            sum = sum + parseInt(cpf.substring(i - 1, i)) * (11 - i)
        }
        residue = (sum * 10) % 11;
        if ((residue == 10) || (residue == 11)) {
            residue = 0
        }
        if (residue != parseInt(cpf.substring(9, 10))) {
            return false
        }
        sum = 0;
        for (var i = 1; i <= 10; i++) {
            sum = sum + parseInt(cpf.substring(i - 1, i)) * (12 - i)
        }
        residue = (sum * 10) % 11;
        if ((residue == 10) || (residue == 11)) {
            residue = 0
        }
        if (residue != parseInt(cpf.substring(10, 11))) {
            return false
        }
        return true;
    }

    /**
     *
     * @param cnpj
     * @returns {boolean}
     */
    function isCnpj(cnpj) {
        cnpj = cnpj.replace(/[^\d]+/g, '');
        if ((!cnpj) || (cnpj.length != 14) || (
                cnpj == '00000000000000' ||
                cnpj == '11111111111111' ||
                cnpj == '22222222222222' ||
                cnpj == '33333333333333' ||
                cnpj == '44444444444444' ||
                cnpj == '55555555555555' ||
                cnpj == '66666666666666' ||
                cnpj == '77777777777777' ||
                cnpj == '88888888888888' ||
                cnpj == '99999999999999'
            )) {
            return false
        }
        var size = cnpj.length - 2;
        var numbers = cnpj.substring(0, size);
        var digits = cnpj.substring(size);
        var sum = 0;
        var pos = size - 7;
        for (i = size; i >= 1; i--) {
            sum += numbers.charAt(size - i) * pos--;
            if (pos < 2) {
                pos = 9;
            }
        }
        var result = sum % 11 < 2 ? 0 : 11 - sum % 11;
        if (result != digits.charAt(0)) {
            return false;
        }
        size = size + 1;
        numbers = cnpj.substring(0, size);
        sum = 0;
        pos = size - 7;
        for (i = size; i >= 1; i--) {
            sum += numbers.charAt(size - i) * pos--;
            if (pos < 2) {
                pos = 9;
            }
        }
        result = sum % 11 < 2 ? 0 : 11 - sum % 11;
        if (result != digits.charAt(1)) {
            return false;
        }
        return true;
    }

    /**
     * @param element
     */
    function scrollToElement(element) {
        var to = parseInt($(element).offset().top) - 100;
        $('html, body').animate({scrollTop: to}, 300);
    }

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
            var first = true;
            for (var i in e.fields) {
                $(i).css({'border-color': errorBorderColor});
                if (first) {
                    scrollToElement(i);
                    first = false;
                }
            }
            response = {isSuccess: false, messages: e.messages};
        } finally {
            return response;
        }
    };

}