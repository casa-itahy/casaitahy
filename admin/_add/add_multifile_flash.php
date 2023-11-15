<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<?php $id=$_GET['id']; ?>
<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <style type="text/css">@import url(../libs/pupload/css/plupload.queue.css);</style>        

    <script type="text/javascript" src="../libs/pupload/js/jquery.min.js"></script>
    <script type="text/javascript" src="../libs/pupload/js/jsapi.js"></script>
    <!-- Thirdparty intialization scripts, needed for the Google Gears and BrowserPlus runtimes -->
    <script type="text/javascript" src="../libs/pupload/js/gears_init.js"></script>
    <script type="text/javascript" src="../libs/pupload/js/browserplus-min.js"></script>
    <!-- Load plupload and all it's runtimes and finally the jQuery queue widget -->
    <script type="text/javascript" src="../libs/pupload/js/plupload.full.min.js"></script>
    <script type="text/javascript" src="../libs/pupload/js/plupload.flash.js"></script>
    <script type="text/javascript" src="../libs/pupload/js/jquery.plupload.queue.min.js"></script>
        <script type="text/javascript"> 
    $(function() {
        // Flash
        $("#flash_uploader").pluploadQueue({
            // Configurações Gerais
            runtimes : 'flash',
            url : 'upload.php',
            max_file_size : '10mb',
            chunk_size : '1mb',
            unique_names : true,
            multipart:true,
 
            // Redimensiona as imagens do lado do cliente, quando possível
            resize : {width : 320, height : 240, quality : 90},
 
            // Especifica os tipos de arquivos válidos
            filters : [
                {title : "Imagess", extensions : "jpg,gif,png"},
                {title : "Arquivos Zip", extensions : "zip"}
            ],
 
            // Confiruação do Flash
            flash_swf_url : 'plupload.flash.swf'
        });
 
        // Gears
        $("#gears_uploader").pluploadQueue({
            // Configurações Gerais
            runtimes : 'gears',
            url : 'upload.php',
            max_file_size : '10mb',
            chunk_size : '1mb',
            unique_names : true,
            multipart:true,
 			rename:true,

            // Redimensiona as imagens do lado do cliente, quando possível
            resize : {width : 320, height : 240, quality : 90},
 
            // Especifica os tipos de arquivos válidos
            filters : [
                {title : "Imagess", extensions : "jpg,gif,png"},
                {title : "Arquivos Zip", extensions : "zip"}
            ]
        });
 
        // Silverlight
        $("#silverlight_uploader").pluploadQueue({
            // Configurações Gerais
            runtimes : 'silverlight',
            url : 'upload.php',
            max_file_size : '10mb',
            chunk_size : '1mb',
            unique_names : true,
            multipart:true,
 			rename:true,

            // Redimensiona as imagens do lado do cliente, quando possível
            resize : {width : 320, height : 240, quality : 90},
 
            // Especifica os tipos de arquivos válidos
            filters : [
                {title : "Imagess", extensions : "jpg,gif,png"},
                {title : "Arquivos Zip", extensions : "zip"}
            ],
 
            // Configuração do Silverlight
            silverlight_xap_url : 'js/plupload.silverlight.xap'
        });
 
        // BrowserPlus
        $("#browserplus_uploader").pluploadQueue({
            // Configurações Gerais
            runtimes : 'browserplus',
            url : 'upload.php',
            max_file_size : '10mb',
            chunk_size : '1mb',
            unique_names : true,
            multipart:true,
            dragdrop : false,
 			rename:true,

            // Redimensiona as imagens do lado do cliente, quando possível
            resize : {width : 320, height : 240, quality : 90},
 
            // Especifica os tipos de arquivos válidos
            filters : [
                {title : "Imagess", extensions : "jpg,gif,png"},
                {title : "Arquivos Zip", extensions : "zip"}
            ]
        });
 
        // HTML5
        $("#html5_uploader").pluploadQueue({
            // Configurações Gerais
            runtimes : 'html5',
            url : 'upload.php',
            max_file_size : '10mb',
            chunk_size : '1mb',
            unique_names : true,
            multipart:true,
			rename:true,
 
            // Redimensiona as imagens do lado do cliente, quando possível
            resize : {width : 320, height : 240, quality : 90},
 
            // Especifica os tipos de arquivos válidos
            filters : [
                {title : "Imagess", extensions : "jpg,gif,png"},
                {title : "Arquivos Zip", extensions : "zip"}
            ]
        });
 
        // HTML4
        $("#html4_uploader").pluploadQueue({
            // Configurações Gerais
            runtimes : 'html4',
            url : 'upload.php'
        });
    });

	$(function() {
        $("#uploader").pluploadQueue({
            // Configurações Gerais
            runtimes : 'html5,gears,flash,silverlight,browserplus,html4',
            url : 'upload.php',
            max_file_size : '10mb',
            chunk_size : '1mb',
            unique_names : true,
            multipart:true,
 
            // Redimensiona as imagens do lado do cliente, quando possível
            resize : {width : 320, height : 240, quality : 90},
 
            // Especifica os tipos de arquivos válidos
            filters : [
                {title : "Imagens", extensions : "jpg,gif,png"},
                {title : "Arquivos Zip", extensions : "zip"}
            ],
 
            // Flash
            flash_swf_url : 'js/plupload.flash.swf',
 
            // Silverlight
            silverlight_xap_url : 'js/plupload.silverlight.xap',

			// PreInit events, bound before any internal events
		preinit : {
			UploadFile: function(up, file) {
				log('[UploadFile]', file);

				// You can override settings before the file is uploaded
				// up.settings.url = 'upload.php?id=' + file.id;
				up.settings.multipart_params = {param1 : 'value1', param2 : 'value2'};
			}
		},

		// Post init events, bound after the internal events
		init : {
			Refresh: function(up) {
				// Called when upload shim is moved
				log('[Refresh]');
			},

			StateChanged: function(up) {
				// Called when the state of the queue is changed
				log('[StateChanged]', up.state == plupload.STARTED ? "STARTED" : "STOPPED");
			},

			QueueChanged: function(up) {
				// Called when the files in queue are changed by adding/removing files
				log('[QueueChanged]');
			},

			UploadProgress: function(up, file) {
				// Called while a file is being uploaded
				log('[UploadProgress]', 'File:', file, "Total:", up.total);
			},

			FilesAdded: function(up, files) {
				// Callced when files are added to queue
				log('[FilesAdded]');

				plupload.each(files, function(file) {
					log('  File:', file);
				});
			},

			FilesRemoved: function(up, files) {
				// Called when files where removed from queue
				log('[FilesRemoved]');

				plupload.each(files, function(file) {
					log('  File:', file);
				});
			},

			FileUploaded: function(up, file, info) {
				// Called when a file has finished uploading
				log('[FileUploaded] File:', file, "Info:", info);
			},

			ChunkUploaded: function(up, file, info) {
				// Called when a file chunk has finished uploading
				log('[ChunkUploaded] File:', file, "Info:", info);
			},

			Error: function(up, args) {
				// Called when a error has occured
				log('[error] ', args);
			}
		}

        });

    });
</script>
    </head>
    <body>        
        <form>
            <div id="flash_uploader" >  
                <p>Seu navegador é incompativel com upload de multiplos arquivos e poderá ocorrer alguns problemas no processo. <br/>Pedimos que use o navegador http://www.firefox.com ou http://www.google.com/chrome</p>
            </div>
        </form>
    </body>
</html>
