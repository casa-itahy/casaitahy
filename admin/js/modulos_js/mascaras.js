function mascara(o,f){    
    v_obj=o
    v_fun=f
    setTimeout("execmascara()",1)
}

function execmascara(){    
    v_obj.value=v_fun(v_obj.value)
}

function leech(v){
    v=v.replace(/o/gi,"0")
    v=v.replace(/i/gi,"1")
    v=v.replace(/z/gi,"2")
    v=v.replace(/e/gi,"3")
    v=v.replace(/a/gi,"4")
    v=v.replace(/s/gi,"5")
    v=v.replace(/t/gi,"7")
    return v
}

function soNumeros(v){
    return v.replace(/\D/g,"")
}
function hora(v){
    return v.replace(/[^0-9:]/g,"")
}

function valida_horas(edit,e)
{
	var tecla=(window.event)?e.keyCode:e.which;

	if(tecla < 48 || tecla > 58 || tecla == 8 || tecla == 0 )
	{
		mascara(edit,hora);
	}
	if(edit.value.length==2)
	{
		edit.value+=":";
	}

}

function telefone(v){
    v=v.replace(/\D/g,"")
    v=v.replace(/^(\d\d)(\d)/g,"($1) $2")
    v=v.replace(/(\d{4})(\d)/,"$1-$2")
    return v
}

function cpf(v){
    v=v.replace(/\D/g,"")                    //Remove tudo o que não é dígito
    v=v.replace(/(\d{3})(\d)/,"$1.$2")       //Coloca um ponto entre o terceiro e o quarto dígitos
    v=v.replace(/(\d{3})(\d)/,"$1.$2")       //Coloca um ponto entre o terceiro e o quarto dígitos
    v=v.replace(/(\d{3})(\d{1,2})$/,"$1-$2") //Coloca um hífen entre o terceiro e o quarto dígitos
    return v
}

function cep(v){
    v=v.replace(/\D/g,"")                //Remove tudo o que não é dígito
    v=v.replace(/^(\d{5})(\d)/,"$1-$2") //Esse é tão fácil que não merece explicações
    return v
}

function mascaraData(campoData){
    var data = campoData.value;
    if (data.length == 2){
    	data = data + '/';
        document.getElementById('datan').value = data;
	return true;
    }
    if (data.length == 5){
        data = data + '/';
        document.getElementById('datan').value = data;
        return true;
    }
}
