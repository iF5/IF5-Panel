$(function () {

    //On delete
    $('.modal-delete').on('click', function () {
        $('#form-modal-delete').attr({action: this.rel});
    });

    //Masks
    $('#cnpj').mask('99.999.999/9999-99');
    $('#cpf').mask('999.999.999-99');

});