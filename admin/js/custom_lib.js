sfHover = function()
    {
       var sfEls = document.getElementById("menu").getElementsByTagName("LI");
       for (var i=0; i<sfEls.length; i++)
       {
          sfEls[i].onmouseover=function()
          {
             this.className+=" sfhover";
          }

          sfEls[i].onmouseout=function()
          {
             this.className=this.className.replace(new RegExp(" sfhover\\b"), "");
          }
       }
    }
    if (window.attachEvent) window.attachEvent("onload", sfHover);
	
		function Onlynumbers(e)
			{
					var tecla=new Number();
					if(window.event) {
							tecla = e.keyCode;
					}
					else if(e.which) {
							tecla = e.which;
					}
					else {
							return true;
					}
					if((tecla >= "97") && (tecla <= "122")){
							return false;
					}
			}
			
		function Onlychars(e)
			{
					var tecla=new Number();
					if(window.event) {
							tecla = e.keyCode;
					}
					else if(e.which) {
							tecla = e.which;
					}
					else {
							return true;
					}
					if((tecla >= "48") && (tecla <= "57")){
							return false;
					}
			}