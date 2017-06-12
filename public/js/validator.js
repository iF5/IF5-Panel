/**
 * Created by will on 17/05/17.
 */


$(function(){

    /* Validate search report */
    $("#btn-search-report").on("click", function(){
        var validator = new Validator();
        validator.voidIds = [
            "#referenceDateSearch"
        ];

        if(!validator.voidValidate()) {
            return false;
        }
    });

    /* Validate employee form create */
    $("#btn-employee-form").on("click", function(){
        var validator = new Validator();
        validator.voidIds = [
            "#name", "#cpf", "#rg", "#ctps", "#birthDate", "#street",
            "#district", "#city", "#state", "#jobRole", "#salaryCap",
            "#hiringDate", "#pis", "#workingHours",
            "#workRegime", "#companies"
        ];

        if(!validator.voidValidate()) {
            return false;
        }
    });

    /* Validate form search */
    $("#btn-search").on("click", function(){

        var validator = new Validator();
        validator.voidIds = [
            "#keyword"
        ];

        if(!validator.voidValidate()) {
            return false;
        }
    });

    $("#form-provider-associate").on("click", function(event){
        if(!cnpjValidate("#cnpj")){
            return false;
        }
    });

    function sacleanCNPJ(id){
        return $(id).val().replace(/\./ig, "").replace(/\//ig, "").replace(/-/ig, "");
    }

    /* Validate user form */
    $("#btn-user-form").on("click", function(){

        var validator = new Validator();
        validator.voidIds = [
            "#name", "#cpf", "#jobRole", "#department",
            "#cellPhone", "#email", "#password"
        ];

        if(!validator.voidValidate()) {
            return false;
        }

        if(!cpfValidate("#cpf")){
            return false;
        }

        if(!emailValidate("#email")){
            return false;
        }
    });

    /* Validate company form */
    $("#btn-company-form").on("click", function(){

        var validator = new Validator();
        validator.voidIds = [
            "#name", "#fantasyName", "#activityBranch", "#cnpj",
            "#stateInscription", "#municipalInscription", "#mainCnae",
            "#fax", "#cep", "#street", "#number", "#district", "#city",
            "#state", "#responsibleName", "#cellPhone", "#email"
        ];

        if(!validator.voidValidate()) {
            return false;
        }

        if(!cnpjValidate("#cnpj")){
            return false;
        }

        if(!emailValidate("#email")){
            return false;
        }
    });

    /* Validate provider form */
    $("#btn-provider-form").on("click", function(){
        var validator = new Validator();
        validator.voidIds = [
            "#name", "#fantasyName", "#activityBranch",
            "#cnpj", "#stateInscription", "#municipalInscription",
            "#mainCnae", "#cep", "#street", "#number", "#district",
            "#city", "#state", "#responsibleName", "#cellPhone",
            "#email"
        ];

        if(!validator.voidValidate()) {
            return false;
        }

        if(!cnpjValidate("#cnpj")){
            return false;
        }

        if(!emailValidate("#email")){
            return false;
        }
    });

    function cpfValidate(id){
        var validator = new Validator();
        validator.cpfId = id;
        return validator.cpfValidate();
    }

    function cnpjValidate(id){
        var validator = new Validator();
        validator.cnpjId = id;
        return validator.cnpjValidate();
    }

    function emailValidate(id){
        var validator = new Validator();
        validator.emailId = id;
        return validator.validateEmail();
    }
});

function Validator(){
    var voidIds = [];
    var cpfId = "";
    var cnpjId = "";
    var emailId = "";

    this.voidValidate = function(){
        if(this.voidIds != []){
            var elId = "";
            for(id in this.voidIds){
                elId = this.voidIds[id];
                if($(elId).val() == ""){
                    showMsgAndBorder(elId);
                    return false;
                }
                removeBorder(elId);
            }
            return true;
        }
        return false;
    };

    this.cpfValidate = function(){
        if(this.cpfId != ""){
            var cpfValue = cleanCPF(this.cpfId);
            if(cpfValue != ""){
                var testCpf = validateCPF(cpfValue);
                if(!testCpf) {
                    alert("CPF invalido!");
                    setBorderAndFocus(this.cpfId);
                    return false;
                }
            }else if(cpfValue == ""){
                showMsgAndBorder(this.cpfId);
                return false;
            }
            removeBorder(this.cpfId);
            return true;
        }
        return false;
    }

    this.cnpjValidate = function(){
        if(this.cnpjId != ""){
            var value = cleanCNPJ(this.cnpjId);
            if(value != ""){
                var test = validateCNPJ(value);
                if(!test) {
                    alert("CNPJ invalido!");
                    setBorderAndFocus(this.cnpjId);
                    return false;
                }
            }else if(value == ""){
                showMsgAndBorder(this.cnpjId);
                return false;
            }
            removeBorder(this.cnpjId);
            return true;
        }
        return false;
    }

    this.validateEmail = function(){
        if(this.emailId != "") {
            var str = $(this.emailId).val();
            if (str == "") {
                showMsgAndBorder(this.emailId);
                return false;
            } else {
                var validate = email(str);
                if (!validate) {
                    alert("Email invalido!");
                    setBorderAndFocus(this.emailId);
                    return false;
                }
            }
            removeBorder(this.emailId);
            return true;
        }
        return false;
    };

    function cleanCNPJ(id){
        return $(id).val().replace(/\./ig, "").replace(/\//ig, "").replace(/-/ig, "");
    }

    function cleanCPF(id){
        return $(id).val().replace(/\./ig, "").replace(/-/ig, "");
    }

    function email(str){
        var pattern = /(.*?)@(.*?)\.[a-z]{2}/;
        return pattern.test(str);
    }

    function showMsgAndBorder(id){
        msgAlert();
        setBorderAndFocus(id);
    }

    function msgAlert(){
        alert("Este campo deve ser preenchido");
    }

    function setBorderAndFocus(id){
        $(id).focus();
        $(id).css({border: '1px solid #FF0000'});
    }

    function removeBorder(id){
        $(id).css({border: ''});
    }

    function validateCPF(strCPF) {
        var Soma;
        var Resto;
        Soma = 0;
        if (strCPF == "00000000000") return false;

        for (i=1; i<=9; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (11 - i);
        Resto = (Soma * 10) % 11;

        if ((Resto == 10) || (Resto == 11))  Resto = 0;
        if (Resto != parseInt(strCPF.substring(9, 10)) ) return false;

        Soma = 0;
        for (i = 1; i <= 10; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (12 - i);
        Resto = (Soma * 10) % 11;

        if ((Resto == 10) || (Resto == 11))  Resto = 0;
        if (Resto != parseInt(strCPF.substring(10, 11) ) ) return false;
        return true;
    }

    function validateCNPJ(cnpj) {

        cnpj = cnpj.replace(/[^\d]+/g,'');

        if(cnpj == '') return false;

        if (cnpj.length != 14)
            return false;

        // Elimina CNPJs invalidos conhecidos
        if (cnpj == "00000000000000" ||
            cnpj == "11111111111111" ||
            cnpj == "22222222222222" ||
            cnpj == "33333333333333" ||
            cnpj == "44444444444444" ||
            cnpj == "55555555555555" ||
            cnpj == "66666666666666" ||
            cnpj == "77777777777777" ||
            cnpj == "88888888888888" ||
            cnpj == "99999999999999")
            return false;

        // Valida DVs
        tamanho = cnpj.length - 2
        numeros = cnpj.substring(0,tamanho);
        digitos = cnpj.substring(tamanho);
        soma = 0;
        pos = tamanho - 7;
        for (i = tamanho; i >= 1; i--) {
            soma += numeros.charAt(tamanho - i) * pos--;
            if (pos < 2)
                pos = 9;
        }
        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado != digitos.charAt(0))
            return false;

        tamanho = tamanho + 1;
        numeros = cnpj.substring(0,tamanho);
        soma = 0;
        pos = tamanho - 7;
        for (i = tamanho; i >= 1; i--) {
            soma += numeros.charAt(tamanho - i) * pos--;
            if (pos < 2)
                pos = 9;
        }
        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado != digitos.charAt(1))
            return false;

        return true;

    }
}