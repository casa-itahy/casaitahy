function atualizaCidade(urlFora){
    //loading('div_resp');
    var url = './php/busca_cidade.php';
    if(urlFora)url='./admin/php/busca_cidade.php';

    var estado_id = document.getElementById('estado').value;
    
    var pars = 'estado_id=' + estado_id + '&dummy= ' + new Date().getTime();
    var myAjax = new Ajax.Request(
        url,{
            method: 'get',
            parameters: pars,
            onComplete: atualizaCampoCidade
        });
}

function atualizaCampoCidade(resposta){
    document.getElementById('div_cidade').innerHTML = resposta.responseText.toString();
}