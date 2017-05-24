/**
 * Created by will on 17/05/17.
 */


$(function(){

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

    /* Validate user form */
    $("#btn-user-form").on("click", function(){

        if($("#name").val() == ""){
            showMsgAndBorder("#name");
            return false;
        }
        removeBorder("#name");

        var cpfValue = $("#cpf").val().replace(/\./ig, "").replace(/-/ig, "");

        if(cpfValue != ""){

            var testCpf = validateCPF(cpfValue);

            if(!testCpf) {
                alert("CPF invalido!");
                setBorderAndFocus("#cpf");
                return false;
            }
        }else if(cpfValue == ""){
            showMsgAndBorder("#cpf");
            return false;
        }
        removeBorder("#cpf");

        if($("#jobRole").val() == ""){
            showMsgAndBorder("#jobRole");
            return false;
        }
        removeBorder("#jobRole");

        if($("#department").val() == ""){
            showMsgAndBorder("#department");
            return false;
        }
        removeBorder("#department");

        if($("#cellPhone").val() == ""){
            showMsgAndBorder("#cellPhone");
            return false;
        }
        removeBorder("#cellPhone");

        if($("#email").val() == ""){
            showMsgAndBorder("#email");
            return false;
        }
        removeBorder("#email");

        if($("#password").val() == ""){
            showMsgAndBorder("#password");
            return false;
        }
        removeBorder("#password");
    });

    /* Validate company form */
    $("#btn-company-form").on("click", function(){

        if($("#name").val() == ""){
            showMsgAndBorder("#name");
            return false;
        }
        removeBorder("#name");

        if($("#fantasyName").val() == ""){
            showMsgAndBorder("#fantasyName");
            return false;
        }
        removeBorder("#fantasyName");

        if($("#activityBranch").val() == ""){
            showMsgAndBorder("#activityBranch");
            return false;
        }
        removeBorder("#activityBranch");

        var cnpjValue = $("#cnpj").val().replace(/\./ig, "").replace(/\//ig, "").replace(/-/ig, "");

        if(cnpjValue != ""){

            var testCnpj = validateCNPJ(cnpjValue);

            if(!testCnpj){
                alert("CNPJ invalido!");
                setBorderAndFocus("#cnpj");
                return false;
            }
        }else if(cnpjValue == ""){
            showMsgAndBorder("#cnpj");
            return false;
        }
        removeBorder("#cnpj");

        if($("#stateInscription").val() == ""){
            showMsgAndBorder("#stateInscription");
            return false;
        }
        removeBorder("#stateInscription");

        if($("#municipalInscription").val() == ""){
            showMsgAndBorder("#municipalInscription");
            return false;
        }
        removeBorder("#municipalInscription");

        if($("#mainCnae").val() == ""){
            showMsgAndBorder("#mainCnae");
            return false;
        }
        removeBorder("#mainCnae");

        if($("#fax").val() == ""){
            showMsgAndBorder("#fax");
            return false;
        }
        removeBorder("#fax");

        if($("#cep").val() == ""){
            showMsgAndBorder("#cep");
            return false;
        }
        removeBorder("#cep");

        if($("#street").val() == ""){
            showMsgAndBorder("#street");
            return false;
        }
        removeBorder("#street");

        if($("#number").val() == ""){
            showMsgAndBorder("#number");
            return false;
        }
        removeBorder("#number");

        if($("#district").val() == ""){
            showMsgAndBorder("#district");
            return false;
        }
        removeBorder("#district");

        if($("#city").val() == ""){
            showMsgAndBorder("#city");
            return false;
        }
        removeBorder("#city");

        if($("#state").val() == ""){
            showMsgAndBorder("#state");
            return false;
        }
        removeBorder("#state");

        if($("#responsibleName").val() == ""){
            showMsgAndBorder("#responsibleName");
            return false;
        }
        removeBorder("#responsibleName");

        if($("#cellPhone").val() == ""){
            showMsgAndBorder("#cellPhone");
            return false;
        }
        removeBorder("#cellPhone");

        if($("#email").val() == ""){
            showMsgAndBorder("#email");
            return false;
        }
        removeBorder("#email");
    });

    function validateEmail(){
        
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
});