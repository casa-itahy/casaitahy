// JavaScript Document
documentall = document.all;
/*
* funÃ§Ã£o para formataÃ§Ã£o de valores monetÃ¡rios retirada de
*/

function formatamoney(c) {
    var t = this; if(c == undefined) c = 2;		
    var p, d = (t=t.split("."))[1].substr(0, c);
    for(p = (t=t[0]).length; (p-=3) >= 1;) {
	        t = t.substr(0,p) + "." + t.substr(p);
    }
    return t+","+d+Array(c+1-d.length).join(0);
}

String.prototype.formatCurrency=formatamoney

function demaskvalue(valor, currency){
/*
* Se currency Ã© false, retorna o valor sem apenas com os nÃºmeros. Se Ã© true, os dois Ãºltimos caracteres sÃ£o considerados as 
* casas decimais
*/
var val2 = '';
var strCheck = '0123456789';
var len = valor.length;
	if (len== 0){
		return 0.00;
	}

	if (currency ==true){	
		/* Elimina os zeros Ã  esquerda 
		* a variÃ¡vel  <i> passa a ser a localizaÃ§Ã£o do primeiro caractere apÃ³s os zeros e 
		* val2 contÃ©m os caracteres (descontando os zeros Ã  esquerda)
		*/
		
		for(var i = 0; i < len; i++)
			if ((valor.charAt(i) != '0') && (valor.charAt(i) != ',')) break;
		
		for(; i < len; i++){
			if (strCheck.indexOf(valor.charAt(i))!=-1) val2+= valor.charAt(i);
		}

		if(val2.length==0) return "0.00";
		if (val2.length==1)return "0.0" + val2;
		if (val2.length==2)return "0." + val2;
		
		var parte1 = val2.substring(0,val2.length-2);
		var parte2 = val2.substring(val2.length-2);
		var returnvalue = parte1 + "." + parte2;
		return returnvalue;
		
	}
	else{
			/* currency Ã© false: retornamos os valores COM os zeros Ã  esquerda, 
			* sem considerar os Ãºltimos 2 algarismos como casas decimais 
			*/
			val3 ="";
			for(var k=0; k < len; k++){
				if (strCheck.indexOf(valor.charAt(k))!=-1) val3+= valor.charAt(k);
			}			
	return val3;
	}
}

function reais(obj,event){

var whichCode = (window.Event) ? event.which : event.keyCode;
/*
Executa a formataÃ§Ã£o apÃ³s o backspace nos navegadores !document.all
*/
if (whichCode == 8 && !documentall) {	
/*
Previne a aÃ§Ã£o padrÃ£o nos navegadores
*/
	if (event.preventDefault){ //standart browsers
			event.preventDefault();
		}else{ // internet explorer
			event.returnValue = false;
	}
	var valor = obj.value;
	var x = valor.substring(0,valor.length-1);
	obj.value= demaskvalue(x,true).formatCurrency();
	return false;
}
/*
Executa o Formata Reais e faz o format currency novamente apÃ³s o backspace
*/
FormataReais(obj,'.',',',event);
} // end reais


function backspace(obj,event){
/*
Essa funÃ§Ã£o basicamente altera o  backspace nos input com mÃ¡scara reais para os navegadores IE e opera.
O IE nÃ£o detecta o keycode 8 no evento keypress, por isso, tratamos no keydown.
Como o opera suporta o infame document.all, tratamos dele na mesma parte do cÃ³digo.
*/

var whichCode = (window.Event) ? event.which : event.keyCode;
if (whichCode == 8 && documentall) {	
	var valor = obj.value;
	var x = valor.substring(0,valor.length-1);
	var y = demaskvalue(x,true).formatCurrency();

	obj.value =""; //necessÃ¡rio para o opera
	obj.value += y;
	
	if (event.preventDefault){ //standart browsers
			event.preventDefault();
		}else{ // internet explorer
			event.returnValue = false;
	}
	return false;

	}// end if		
}// end backspace

function FormataReais(fld, milSep, decSep, e) {
var sep = 0;
var key = '';
var i = j = 0;
var len = len2 = 0;
var strCheck = '0123456789';
var aux = aux2 = '';
var whichCode = (window.Event) ? e.which : e.keyCode;

//if (whichCode == 8 ) return true; //backspace - estamos tratando disso em outra funÃ§Ã£o no keydown
if (whichCode == 0 ) return true;
if (whichCode == 9 ) return true; //tecla tab
if (whichCode == 13) return true; //tecla enter
if (whichCode == 16) return true; //shift internet explorer
if (whichCode == 17) return true; //control no internet explorer
if (whichCode == 27 ) return true; //tecla esc
if (whichCode == 34 ) return true; //tecla end
if (whichCode == 35 ) return true;//tecla end
if (whichCode == 36 ) return true; //tecla home

/*
O trecho abaixo previne a aÃ§Ã£o padrÃ£o nos navegadores. NÃ£o estamos inserindo o caractere normalmente, mas via script
*/

if (e.preventDefault){ //standart browsers
		e.preventDefault()
	}else{ // internet explorer
		e.returnValue = false
}

var key = String.fromCharCode(whichCode);  // Valor para o cÃ³digo da Chave
if (strCheck.indexOf(key) == -1) return false;  // Chave invÃ¡lida

/*
Concatenamos ao value o keycode de key, se esse for um nÃºmero
*/
fld.value += key;

var len = fld.value.length;
var bodeaux = demaskvalue(fld.value,true).formatCurrency();
fld.value=bodeaux;

/*
Essa parte da funÃ§Ã£o tÃ£o somente move o cursor para o final no opera. Atualmente nÃ£o existe como movÃª-lo no konqueror.
*/
  if (fld.createTextRange) {
    var range = fld.createTextRange();
    range.collapse(false);
    range.select();
  }
  else if (fld.setSelectionRange) {
    fld.focus();
    var length = fld.value.length;
    fld.setSelectionRange(length, length);
  }
  return false;

}
//Fim da Função FormataReais -->