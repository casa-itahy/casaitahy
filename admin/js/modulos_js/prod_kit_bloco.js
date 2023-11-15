
function montaSelect(tipo){
    if(tipo=='1'){
        document.getElementById('div_tabela').innerHTML='';
        document.getElementById('div_kit').innerHTML='N/I';
        document.getElementById('div_bloco').innerHTML='N/I';
        loading('div_produto');
        var campo = document.getElementById('categoria').value;
        var div= 'div_produto';
    }else{
        if(tipo=='2'){
            document.getElementById('div_tabela').innerHTML='';
            document.getElementById('div_bloco').innerHTML='N/I';
            loading('div_kit');
            var campo = document.getElementById('produto').value;
            var div= 'div_kit';
        }else{
            if(tipo=='3'){
                document.getElementById('div_tabela').innerHTML='';
                loading('div_bloco');
                var campo = document.getElementById('kit').value;
                var div= 'div_bloco';
            }
        }

    }
    var url = 'php/monta_select.php';
    var pars = 'tipo=' + tipo + '&id=' + campo + '&dummy= ' + new Date().getTime();
    var myAjax = new Ajax.Updater(div,url, {
                    method: 'post',
                    parameters: pars
            });
}

function montaTabela(add_item){
    loading('div_tabela');
    var prod = document.getElementById('produto').value;
    var kit = document.getElementById('kit').value;
    var bloco = document.getElementById('bloco').value;

    /*var ordem_bloco = '';
    if(document.getElementById('ordem')){
        ordem_bloco = '&ordem='+document.getElementById('ordem').value;
    }*/

    var item = '';
    if(add_item){
        item = '&item_id='+add_item;
    }

    if(prod){
        if(kit){
            if(bloco){
                var url = 'php/monta_tabela.php';
                var pars = 'prod_id=' + prod + '&kit_id=' + kit + '&bloco_id=' + bloco + item +'&dummy= ' + new Date().getTime();
                var myAjax = new Ajax.Updater('div_tabela',url, {
                                method: 'post',
                                parameters: pars
                        });
            }else{
                alert('Selecione um bloco!');
            }
        }else{
            alert('Selecione um kit!');
        }
    }else{
        alert('Selecione um produto!');
    }
}

function insereItem(cod,nome){
    if(cod){
        cod = '&cod=' + cod;
        if(nome){
            nome = '&nome=' + nome;
            loading('div_tabela');
            var prod = document.getElementById('produto').value;
            var kit = document.getElementById('kit').value;
            var bloco = document.getElementById('bloco').value;

            if(prod){
                if(kit){
                    if(bloco){
                        var url = 'php/monta_tabela.php';
                        var pars = 'prod_id=' + prod + '&kit_id=' + kit + '&bloco_id=' + bloco + cod + nome + '&dummy= ' + new Date().getTime();
                        var myAjax = new Ajax.Updater('div_tabela',url, {
                                        method: 'post',
                                        parameters: pars
                                });
                    }else{
                        alert('Selecione um bloco!');
                    }
                }else{
                    alert('Selecione um kit!');
                }
            }else{
                alert('Selecione um produto!');
            }
        }else{
            alert('Preencha o nome do novo item!');
        }
    }else{
        alert('Preencha o código do novo item!');
    }
}

function liberaCampo(opcao){
    if(opcao){
            document.getElementById('div_campo').style.display = "block";
            document.getElementById('ancora').style.display = "none";
            document.getElementById('div_select_item').style.display = "none";
    }else{
        document.getElementById('div_campo').style.display = "none";
        document.getElementById('ancora').style.display = "block";
        document.getElementById('div_select_item').style.display = "block";
    }
}

function confirmar(item){
    
    var prod = document.getElementById('produto').value;
    var kit = document.getElementById('kit').value;
    var bloco = document.getElementById('bloco').value;
    if(prod){
        if(kit){
            if(bloco){
                if (confirm("Atenção! Você tem certeza que deseja excluír este registro?")){
                    loading('div_msg');
                    var url = 'php/excluirItens.php';
                    var pars = 'prod_id=' + prod + '&kit_id=' + kit + '&bloco_id=' + bloco + '&item_id=' + item +'&dummy= ' + new Date().getTime();
                    var myAjax = new Ajax.Updater('div_msg',url, {
                                    method: 'post',
                                    parameters: pars,
                                    onSuccess: montaTabela
                            });
                }
            }else{
                alert('Selecione um bloco!');
            }
        }else{
            alert('Selecione um kit!');
        }
    }else{
        alert('Selecione um produto!');
    }
}

function ordenar(item){    
    var prod = document.getElementById('produto').value;
    var kit = document.getElementById('kit').value;
    var bloco = document.getElementById('bloco').value;
    var ordem = document.getElementById('ordem'+item).value;
    if(prod){
        if(kit){
            if(bloco){                
                 if(ordem){
                     if(ordem>0){
                        loading('div_msg');
                        var url = 'php/ordenaKitItens.php';
                        var pars = 'prod_id=' + prod + '&kit_id=' + kit + '&bloco_id=' + bloco + '&ordem=' + ordem + '&item_id=' + item +'&dummy= ' + new Date().getTime();
                        var myAjax = new Ajax.Updater('div_msg',url, {
                                        method: 'post',
                                        parameters: pars,
                                        onSuccess: montaTabela
                                });
                    }else{
                        alert('A ordem deve ser maior que zero(0)!');
                    } 
                }else{
                    alert('Selecione um bloco!');
                }
            }else{
                alert('Selecione um bloco!');
            }
        }else{
            alert('Selecione um kit!');
        }
    }else{
        alert('Selecione um produto!');
    }
}



function loading(div_campo){
	var html = "<img src='img/loading.gif' />"
	document.getElementById(div_campo).innerHTML = html;
}

function insereValorCampo(nome,tipo){
        if(!nome){
          nome='vazio';   
        }    
            nome = '&nome=' + nome;
            loading('div_salvou');
            var prod = document.getElementById('produto').value;
            var kit = document.getElementById('kit').value;
            var bloco = document.getElementById('bloco').value;            

            if(prod){
                if(kit){
                    if(bloco){
                        var url = 'php/salvaCampos.php';
                        var pars = 'prod_id=' + prod + '&kit_id=' + kit + '&bloco_id=' + bloco + '&tipo=' + tipo + nome + '&dummy= ' + new Date().getTime();
                        var myAjax = new Ajax.Updater('div_salvou',url, {
                                        method: 'post',
                                        parameters: pars
                                });
                       }else{
                            alert('Selecione um bloco!');
                       }
                }else{
                    alert('Selecione um kit!');
                }
            }else{
                alert('Selecione um produto!');
            }        
}

function enviaForm(){  
    window.open('Observação salva com sucesso!','Popup','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=yes, width=200, height=200');  
    document.formObs.submit();  
}  