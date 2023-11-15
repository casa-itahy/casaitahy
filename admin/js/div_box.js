//
// global variables
//
var isMozilla;
var objDiv = null;
var originalDivHTML = "";
var DivID = "";
var over = false;


//
// dinamically add a div to 
// dim all the page
//
function buildDimmerDiv(){
    document.write('<div id="dimmer" class="dimmer" style="width:'+ window.screen.width + 'px; height:' + window.screen.height +'px"></div>');
}

function displayFloatingDiv(divId, title, width, height, left, top){
    DivID = divId;

    document.getElementById('dimmer').style.visibility = "visible";
    document.getElementById(divId).style.width = width + 'px';
    document.getElementById(divId).style.height = height + 'px';
    document.getElementById(divId).style.left = left + 'px';
    document.getElementById(divId).style.top = top + 'px';
	
    var addHeader;
	
    if (originalDivHTML == "")
	    originalDivHTML = document.getElementById(divId).innerHTML;
	
    addHeader = '<table style="width:' + width + 'px" class="floatingHeader">' +
	            '<tr><td ondblclick="void(0);" onmouseover="over=true;" onmouseout="over=false;" style="cursor:move;height:30px; text-align:left; padding-left:10px; font-size:12px;">' + title + '</td></tr></table>';
	            
	

    // add to your div an header	
	document.getElementById(divId).innerHTML = addHeader + originalDivHTML;
	
	document.getElementById(divId).className = 'dimming';
	document.getElementById(divId).style.visibility = "visible";
}


//
//
//
function hiddenFloatingDiv(divId) 
{
	document.getElementById(divId).innerHTML = originalDivHTML;
	document.getElementById(divId).style.visibility='hidden';
	document.getElementById('dimmer').style.visibility = 'hidden';
	
	DivID = "";
}

//
//
//
function MouseDown(e) 
{
    if (over)
    {
        if (isMozilla) {
            objDiv = document.getElementById(DivID);
            X = e.layerX;
            Y = e.layerY;
            return false;
        }
        else {
            objDiv = document.getElementById(DivID);
            objDiv = objDiv.style;
            X = event.offsetX;
            Y = event.offsetY;
        }
    }
}


//
//
//
function MouseMove(e) 
{
    if (objDiv) {
        if (isMozilla) {
            objDiv.style.top = (e.pageY-Y) + 'px';
            objDiv.style.left = (e.pageX-X) + 'px';
            return false;
        }
        else 
        {
            objDiv.pixelLeft = event.clientX-X + document.body.scrollLeft;
            objDiv.pixelTop = event.clientY-Y + document.body.scrollTop;
            return false;
        }
    }
}

//
//
//
function MouseUp() 
{
    objDiv = null;
}


//
//
//
function init(){
    // check browser
    isMozilla = (document.all) ? 0 : 1;


    if (isMozilla) 
    {
        document.captureEvents(Event.MOUSEDOWN | Event.MOUSEMOVE | Event.MOUSEUP);
    }

    document.onmousedown = MouseDown;
    document.onmousemove = MouseMove;
    document.onmouseup = MouseUp;

    // add the div
    // used to dim the page
	buildDimmerDiv();

}

// call init
init();

function displayWindow(){
    document.getElementById('windowcontent').style.display = "block";
    
    
    var w, h, l, t;
    w = 620;
    h = 320;
    l = (screen.width/2)-(w/2);
    top = 180;//screen.height;
    // no title		        
            // displayFloatingDiv('windowcontent', '', w, h, l, t);
    // with title		        
            displayFloatingDiv('windowcontent', '<strong>Incluir/Editar configurações de imagem</strong>', w, h, l, top);
}
