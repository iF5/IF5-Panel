/**
 * Disable automatic dropzone
 * @type {boolean}
 */
Dropzone.autoDiscover = false;

/**
 * Custom upload dropzone
 *
 * @param options
 * @constructor
 */
function If5Upload(options) {

    var _options = {
        formElement: options.formElement || null,
        messageElement: options.messageElement || null,
        submitElement: options.submitElement || null,
        url: options.url || '/upload',
        autoProcessQueue: options.autoProcessQueue || false,
        uploadMultiple: options.uploadMultiple || false,
        maxFilesize: options.maxFilesize || 256,
        maxFiles: options.maxFiles || 1,
        data: typeof(options.data) === 'object' ? options.data : {}
    };

    new Dropzone(_options.formElement, {

        url: _options.url,
        autoProcessQueue: _options.autoProcessQueue,
        uploadMultiple: _options.uploadMultiple,
        maxFilesize: _options.maxFilesize,
        maxFiles: _options.maxFiles,

        init: function () {

            var submitElement = document.querySelector(_options.submitElement);
            var messageElement = document.querySelector(_options.messageElement);
            var dz = this;

            submitElement.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                dz.processQueue();
            });

            this.on('sending', function (file, xhr, formData) {
                for (var i in _options.data) {
                    formData.append(i, _options.data[i]);
                }
            });

            this.on('addedfile', function (file) {
                var removeButton = Dropzone.createElement(
                    '<button class="btn btn-danger btn-xs" style="cursor: pointer;"><span class="glyphicon glyphicon-trash"></span></button>'
                );
                var _this = this;

                removeButton.addEventListener('click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    _this.removeFile(file);
                });

                file.previewElement.appendChild(removeButton);
                messageElement.innerHTML = ''
            });

            this.on('complete', function (file) {
                dz.removeFile(file);
            });

            this.on('success', function (file, serverResponse) {
                var response = JSON.parse(JSON.stringify(serverResponse));
                messageElement.innerHTML = response.message;
            });
        }

    });
}

/**
 * Custom modal
 *
 * @constructor
 */
function If5Modal() {

    /**
     * @param message
     */
    this.alert = function (message) {
        var alert = $('#modal-alert');
        if (message !== undefined) {
            alert.find('.modal-body').html(message);
        }
        alert.modal('show');
    };

    /**
     * @param message
     */
    this.confirm = function (message) {
        var alert = $('#modal-confirm');
        if (message !== undefined) {
            alert.find('.modal-body').html(message);
        }
        alert.modal('show');
    };

}


/**
 * Custom form
 *
 * @constructor
 */
function If5Form() {

    var vClasses = {
        'v-void': 'VOID',
        'v-cep': 'CEP',
        'v-cnpj': 'CNPJ',
        'v-cpf': 'CPF',
        'v-date': 'DATE',
        'v-ddd': 'DDD',
        'v-email': 'EMAIL',
        'v-number': 'NUMBER',
        'v-phone': 'PHONE',
        'v-rg': 'RG'
    };

    var fields = 'input,select,textarea';

    /**
     * Reset fields border color
     */
    function fieldReset() {
        $(fields).on('focus', function () {
            $(this).css('border', '');
        });
    }

    /**
     * On validate all form by class apply
     *
     * @param vObject
     */
    this.onValidate = function (vObject) {
        /**
         * Submit the form event
         */
        $('.v-form').on('submit', function (e) {
            var hasType = function (id) {
                for (var i in vClasses) {
                    if ($('#' + id).hasClass(i)) {
                        return vClasses[i];
                    }
                }
                return false;
            };

            var options = {};
            $(this).find(fields).each(function (index, item) {
                var type = hasType(item.id);
                if (item.id && type) {
                    options['#' + item.id] = {value: item.value, type: type};
                }
            });

            var response = vObject.assert(options);
            if (!response.isSuccess) {
                e.preventDefault();
            }
        });
        //
        fieldReset();
    };

    /**
     * @param form
     * @param queryString
     * @param type
     */
    this.addInput = function (form, queryString, type) {
        var all = queryString.split('&');
        for (var i = 0; all.length; i++) {
            var row = all[i].split('=');
            var input = $('<input>').attr({
                'type': (type === undefined) ? 'hidden' : type,
                'name': row[0],
                'value': row[1]
            });
            $(form).append(input);
        }
    };

    /**
     * Masks reload
     */
    this.masks = function () {
        $('#cnpj').mask('99.999.999/9999-99');
        $('#cpf').mask('999.999.999-99');
        $('#phone').mask('99 9999-9999');
        $('#phone').mask('99 9999-9999');
        $('#cellPhone').mask('99 99999-9999');
        $('#cep').mask('99999-999');
        //$('#rg').mask('99.999.999-9');
        $('.dateMask').mask('99/99/9999');
        $('.moneyMask').maskMoney({showSymbol: false, symbol: 'R$', decimal: ',', thousands: '.'});
        $('#pis').mask('999.99999.99-9');
        $('#referenceDateSearch').mask('99/9999');
        fieldReset();
    };
}

function If5Employee() {

    this.children = function () {

        var tbody = $('#chlidrenTable > tbody');

        /**
         * @returns {string}
         */
        function makeRow() {
            var index = Math.floor((Math.random() + Math.random()) * 100);
            return '<tr>\
                <td> \
                    <input type="text" id="name' + index + '" name="chlidren[name][]" class="form-control v-void"/> \
                </td> \
                <td> \
                    <input type="text" id="birthDate' + index + '" name="chlidren[birthDate][]" \
                    class="form-control dateMask v-void" size="3"/> \
                </td> \
                <td align="right"> \
                    <a href="" class="btn btn-danger btn-xs chlidren-remove" title="Excluir"> \
                    <span class="glyphicon glyphicon-remove"></span></a> \
                </td> \
                </tr>';
        }

        /**
         *
         */
        $('.has-children').on('click', function () {
            if ((parseInt(this.value))) {
                $('#childrenWarningNot').hide();
                $('#chlidrenDiv').slideDown(300);
                if (tbody.children('tr').size() < 1) {
                    tbody.html(makeRow());
                }
                new If5Form().masks();
            } else {
                $('#chlidrenDiv').slideUp(300);
                if (tbody.children('tr').size() >= 1) {
                    $('#childrenWarningNot').fadeIn(500);
                }
            }
        });

        /**
         *
         */
        $('.children-add').on('click', function (e) {
            e.preventDefault();
            tbody.prepend(makeRow());
            new If5Form().masks();
        });

        /**
         *
         */
        $(document).on('click', '.chlidren-remove', function (e) {
            e.preventDefault();
            $(this).closest('tr').remove();
        });
    };

}


/**
 * Triggers
 */
$(function () {

    var validate = new Validate();
    var if5Modal = new If5Modal();
    //var if5Form = new If5Form();
    var if5Employee = new If5Employee();

    /**
     * Form masks
     */
    //if5Form.masks();

    /**
     * Form validation
     */
    //if5Form.onValidate(validate);

    /**
     * Form children
     */
    if5Employee.children();

    /**
     * On delete
     */
    $('.modal-delete').on('click', function () {
        $('#form-modal-delete').attr({action: this.rel});
        //$('.alert-message-delete').text(this.rev);
    });

    /**
     * On delete
     */
    $('.modal-update').on('click', function () {
        $('#form-modal-update').attr({action: this.rel});
        $('.alert-message-update').text(this.rev);
    });

    /**
     * On upload profile image
     */
    $('.modal-image').on('click', function () {
        new If5Upload({
            formElement: '#dz-modal-upload',
            submitElement: '#dz-modal-submit',
            messageElement: '#dz-modal-message',
            url: this.rel
        });
    });

    /**
     * On upload report
     */
    $('.modal-report-upload').on('click', function (e) {
        e.preventDefault();
        new If5Upload({
            formElement: '#dz-modal-upload',
            submitElement: '#dz-modal-submit',
            messageElement: '#dz-modal-message',
            url: this.href
        });
    });

    /**
     * On upload documents
     */
    $('.modal-document-upload').on('click', function (e) {
        e.preventDefault();
        var month = '#month' + this.rel;
        var validity = '#validity' + this.rel;
        var data = {};
        data[month] = {value: $(month).val(), type: 'VOID'};
        data[validity] = {value: $(validity).val(), type: 'NUMBER'};
        var response = validate.assert(data);

        if (!response.isSuccess) {
            //if5Modal.alert();
            return false;
        }

        $('#upload').modal('show');
        new If5Upload({
            formElement: '#dz-modal-upload',
            submitElement: '#dz-modal-submit',
            messageElement: '#dz-modal-message',
            url: this.href,
            data: {
                periodicity: $('#periodicity').val(),
                documentId: this.rel,
                year: $('#year' + this.rel).val(),
                month: $(month).val(),
                validity: $(validity).val()
            }
        });
    });

    /**
     * On checklist disapprove
     */
    $('.checklist-approve').on('click', function (e) {
        e.preventDefault();
        if5Modal.confirm('Tem certeza que deseja aprovar esse documento?');
        var form = $('#form-modal-confirm').attr({'action': this.href});
        if5Form.addInput(form, $('#queryStringData').val());
        form.submit();
    });

    /**
     * On checklist disapprove
     */
    $('.checklist-disapprove').on('click', function (e) {
        e.preventDefault();
        $('#modal-observation').modal('show');
        var form = $('#form-modal-observation').attr({'action': this.href});
        if5Form.addInput(form, $('#queryStringData').val());
        form.submit();
    });

    /**
     *
     */
    $('input.typeahead').typeahead({
        source: function (query, process) {
            return $.get("//" + hostName() + '/cnae/' + query, {query: query}, function (data) {
                return process(data);
            });
        }
    });

    /**
     *
     * @returns {*}
     */
    function hostName() {
        var hostname = $(location).attr('hostname');
        if (hostname == "localhost") {
            return hostname + ":4545/public/";
        }
        return hostname;
    }

    /**
     * Api correios
     */
    $('#cep').on('blur', function () {
        var cep = this.value.replace('-', '');
        $.ajax({
            url: 'http://correiosapi.apphb.com/cep/' + cep,
            dataType: 'jsonp',
            crossDomain: true,
            contentType: 'application/json',
            success: function (data) {
                $('#street').val(data.logradouro);
                $('#district').val(data.bairro);
                $('#city').val(data.cidade);
                $('#state').val(data.estado);
            }
        });
    });

    /**
     * On read more
     */
    $('.btn-read-more').on('click', function (e) {
        e.preventDefault();
        $(this).siblings('.text-read-more').slideToggle(400);
    });

    /**
     * On selected all checkbox
     */
    $('.checkbox-on-all').on('click', function () {
        $(this).closest('div').siblings('div').find(':checkbox').prop('checked', this.checked);
    });

});

