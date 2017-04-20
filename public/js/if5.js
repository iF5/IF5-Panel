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
function Upload(options) {

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
 * Triggers
 */
$(function () {

    //On delete
    $('.modal-delete').on('click', function () {
        $('#form-modal-delete').attr({action: this.rel});
        //$('.alert-message-delete').text(this.rev);
    });

    //On delete
    $('.modal-update').on('click', function () {
        $('#form-modal-update').attr({action: this.rel});
        $('.alert-message-update').text(this.rev);
    });

    //On upload profile image
    $('.modal-image').on('click', function () {
        new Upload({
            formElement: '#dz-modal-upload',
            submitElement: '#dz-modal-submit',
            messageElement: '#dz-modal-message',
            url: this.rel
        });
    });

    $('.modal-document-upload').on('click', function () {
        new Upload({
            formElement: '#dz-modal-upload',
            submitElement: '#dz-modal-submit',
            messageElement: '#dz-modal-message',
            url: this.rel
            //maxFilesize: 500,
            //data: {}
        });
    });

    //Api correios
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

    //Masks
    $('#cnpj').mask('99.999.999/9999-99');
    $('#cpf').mask('999.999.999-99');
    $('#phone').mask('99 9999-9999');
    $('#phone').mask('99 9999-9999');
    $('#cellPhone').mask('99 99999-9999');
    $('#cep').mask('99999-999');
    $('#rg').mask('99.999.999-9');
    $('.dateMask').mask('99/99/9999');
    $('.moneyMask').maskMoney({showSymbol:true, symbol:'R$', decimal:',', thousands:'.'});
});