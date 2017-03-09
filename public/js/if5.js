$(function () {

    $('.modal-delete').on('click', function () {
        $('#form-modal-delete').attr({action: this.rel});
    });

});