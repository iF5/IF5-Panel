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

    //Masks
    $('#cnpj').mask('99.999.999/9999-99');
    $('#cpf').mask('999.999.999-99');
});