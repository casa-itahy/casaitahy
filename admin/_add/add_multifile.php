<?php 

    $id = $_GET['id'];   
    include_once '../includes/db.php';
    
    $pag = $_GET['pag'];
    $modulo = query("SELECT orientacao, tam_principal, tam_thumb FROM modulos WHERE pag_tab_id='".$pag."';");
    
    $orientacao = strtoupper($modulo['0']['orientacao']);
    
    switch (strtoupper($modulo['0']['orientacao'])) {
    	
    	case 'H':
    		$largura = $modulo['0']['tam_principal'];
    		$altura = 0;
    		break;
    	case 'V':
    		$altura = $modulo['0']['tam_principal'];
	    	$largura = 0;
	    	break;
    	case 'N':
    		$largura = 0;
    		$altura = 0;
    		break;
    	case 'M':
    		$largura = $modulo['0']['tam_principal'];
	    	$altura = $modulo['0']['tam_principal'];
	    	break;
    }
    
    
?>
<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">		
		
        <link rel="stylesheet" href="../js/multiupload/jquery.plupload.queue/css/jquery.plupload.queue.css" type="text/css" media="screen" />
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
        <script type="text/javascript" src="http://bp.yahooapis.com/2.4.21/browserplus-min.js"></script>
        <script type="text/javascript" src="../js/multiupload/plupload.js"></script>
        <script type="text/javascript" src="../js/multiupload/plupload.gears.js"></script>
        <script type="text/javascript" src="../js/multiupload/plupload.silverlight.js"></script>
        <script type="text/javascript" src="../js/multiupload/plupload.flash.js"></script>
        <script type="text/javascript" src="../js/multiupload/plupload.browserplus.js"></script>
        <script type="text/javascript" src="../js/multiupload/plupload.html4.js"></script>
        <script type="text/javascript" src="../js/multiupload/plupload.html5.js"></script>
        <script type="text/javascript" src="../js/multiupload/jquery.plupload.queue/jquery.plupload.queue.js"></script>

        <script type="text/javascript">
            $(function(){
                   function log(){
                        var str = "";
                        plupload.each(arguments, function(arg) {
                                var row = "";
                                if (typeof(arg) != "string"){
                                        plupload.each(arg, function(value, key){

                                                if (arg instanceof plupload.File) {
                                                        switch (value) {
                                                                case plupload.QUEUED:
                                                                        value = 'QUEUED';
                                                                        break;

                                                                case plupload.UPLOADING:
                                                                        value = 'UPLOADING';
                                                                        break;

                                                                case plupload.FAILED:
                                                                        value = 'FAILED';
                                                                        break;

                                                                case plupload.DONE:
                                                                        value = 'DONE';
                                                                        break;
                                                        }
                                                }

                                                if (typeof(value) != "function") {
                                                        row += (row ? ', ' : '') + key + '=' + value;
                                                }
                                        });

                                        str += row + " ";
                                } else { 
                                        str += arg + " ";
                                }
                        });

                        $('#log').append(str + "\n");
                } 
                $("#uploader").pluploadQueue({
                    // Configurações Gerais
                    //runtimes : 'html4,html5',
					runtimes: 'html5,flash,gears,browserplus,silverlight,html4',
                    url : '../_update/upload_mult_file.php?id=<?php echo $id ?>&pag=<?php echo $pag ?>',
                    max_file_size : '10mb',
                    chunk_size : '3mb',
                    unique_names : false,
					file_data_name : 'file',

                    //Redimensiona as imagens do lado do cliente, quando possível
                    resize: {width: 900, height: 660, quality: 90},

                    // Especifica os tipos de arquivos válidos
                    filters : [
                        {title : "Imagens", extensions : "jpg,gif,png"},
                        {title : "Arquivos Zip", extensions : "zip"}
                    ],

                    // Flash
                    flash_swf_url : '../js/multiupload/plupload.flash.swf',

                    // Silverlight
                    silverlight_xap_url : '../js/multiupload/plupload.silverlight.xap',               
                                // PreInit events, bound before any internal events
                        preinit : {  
                                Init: function(up, info){
                                        log('[Init]', 'Info:', info, 'Features:', up.features);
                                },
                                UploadFile: function(up, file) {
                                        log('[UploadFile]', file);

                                        up.settings.multipart_params = {param1 : '<?php echo $id; ?>'};
                                }
                        },

                        init : {
                                Refresh: function(up) {
                                        log('[Refresh]');
                                },

                                StateChanged: function(up) {
                                        log('[StateChanged]', up.state == plupload.STARTED ? "STARTED" : "STOPPED");
                                },

                                QueueChanged: function(up) {
                                        log('[QueueChanged]');
                                },

                                UploadProgress: function(up, file) {
                                        log('[UploadProgress]', 'File:', file, "Total:", up.total);
                                },

                                FilesAdded: function(up, files) {
                                        log('[FilesAdded]');

                                        plupload.each(files, function(file) {
                                                log('  File:', file);
                                        });
                                },

                                FilesRemoved: function(up, files) {
                                        log('[FilesRemoved]');

                                        plupload.each(files, function(file) {
                                                log('  File:', file);
                                        });
                                },

                                FileUploaded: function(up, file, info) {
                                        // Called when a file has finished uploading
                                        //log('[FileUploaded] File:', file, "Info:", info);                                        
                                        //window.parent.location.href = window.parent.location.href;
                                        //alert("Clique no botão 'Atualizar conteúdo' para salvar");
                                },

                                ChunkUploaded: function(up, file, info) {
                                        log('[ChunkUploaded] File:', file, "Info:", info);
                                },

                                Error: function(up, args) {
                                        log('[error] ', args);
                                }
                        }

                });
            });
        </script>
    </head>
    <body>            
        <form>            
            <div id="uploader">
                <p>
                Seu navegador é incompativel com upload de multiplos arquivos e poderá ocorrer alguns problemas no processo. <br/>
                Pedimos que use o navegador http://www.firefox.com ou http://www.google.com/chrome
                </p>
            </div>            
        </form>
    </body>
</html>
