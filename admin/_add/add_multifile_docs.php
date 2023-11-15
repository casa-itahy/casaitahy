<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<?php 
    $id=$_GET['id'];   
    include_once '../includes/db.php';
    
    $tamImgMax = query("SELECT tam_img_max,tipo_tam_img FROM config LIMIT 1");
    if($tamImgMax[0]['tipo_tam_img']==2){              
       //if($tamImgMax[0]['tam_largura_fixa']!=null){           
           $altura = 0;
           //$largura=$tamImgMax[0]['tam_largura_fixa'];  
           $largura = $tamImgMax[0]['tam_img_max'];
      /* }else{
           $largura = $tamImgMax[0]['tam_img_max'];
           $altura=0;
       }*/
    }else{
        if($tamImgMax[0]['tipo_tam_img']==3){
            $altura = $tamImgMax[0]['tam_img_max'];
            if($tamImgMax[0]['tam_altura_fixa']==1){
                $largura=$tamImgMax[0]['tam_img_max']+100;//$tamImgMax[0]['tam_altura_fixa'];
            }else{
                $largura=0;//$tamImgMax[0]['tam_largura_fixa'];                
            }
        }else{
            $largura = $tamImgMax[0]['tam_img_max'];
            $altura = $tamImgMax[0]['tam_img_max'];
        }
    }    
    
?>
<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <style type="text/css">@import url(../libs/pupload/css/plupload.queue.css);</style>
        <script type="text/javascript" src="../libs/pupload/js/jsapi.js"></script>
        <script type="text/javascript" src="../libs/pupload/js/jquery.min.js"></script>
        <!-- Thirdparty intialization scripts, needed for the Google Gears and BrowserPlus runtimes -->
        <script type="text/javascript" src="../libs/pupload/js/gears_init.js"></script>
        <script type="text/javascript" src="../libs/pupload/js/browserplus-min.js"></script>
        <!-- Load plupload and all it's runtimes and finally the jQuery queue widget -->
        <script type="text/javascript" src="../libs/pupload/js/plupload.full.min.js"></script>
        <script type="text/javascript" src="../libs/pupload/js/jquery.plupload.queue.min.js"></script>
        <script type="text/javascript">
            $(function(){
                   function log(){
                        var str = "";
                        plupload.each(arguments, function(arg) {
                                var row = "";
                                if (typeof(arg) != "string"){
                                        plupload.each(arg, function(value, key){
                                                // Convert items in File objects to human readable form
                                                if (arg instanceof plupload.File) {
                                                        // Convert status to human readable
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
                    runtimes : 'html4,html5,gears,flash,silverlight,browserplus',
                    //runtimes : 'html5,html4',
                    url : '../_update/upload_mult_file_docs.php',
                    max_file_size : '10mb',
                    chunk_size : '3mb',
                    unique_names : true,
                    multipart: true,

                    //Redimensiona as imagens do lado do cliente, quando possível
                    resize : {width: <?php echo $largura.', height: '.$altura; ?> , quality : 100},

                    // Especifica os tipos de arquivos válidos
                    filters : [
                        {title : "Imagens", extensions : "jpg,gif,png"},
                        {title : "Arquivos Zip", extensions : "zip"},
                        {title : "Activity documents", extensions : "jpg,jpeg,gif,png,doc,docx,xls,xlsx,ppt,pptx,pdf,rtf"}
                    ],

                    // Flash
                    flash_swf_url : './libs/pupload/js/plupload.flash.swf',

                    // Silverlight
                    silverlight_xap_url : './libs/pupload/js/plupload.silverlight.xap',               
                                // PreInit events, bound before any internal events
                        preinit : {  
                                Init: function(up, info){
                                        log('[Init]', 'Info:', info, 'Features:', up.features);
                                },
                                UploadFile: function(up, file) {
                                        log('[UploadFile]', file);

                                        // You can override settings before the file is uploaded
                                        // up.settings.url = 'upload.php?id=' + file.id;
                                        //up.settings.multipart_params = {param1 : 'value1', param2 : 'value2'};                                        
                                        up.settings.multipart_params = {param1 : '<?php echo $id; ?>'};
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
                                        //log('[FileUploaded] File:', file, "Info:", info);                                        
                                        //window.location.assign("./index.php?pag=4&tipo=e&id=<?php echo $id; ?>");
                                        //window.parent.location.href = window.parent.location.href;
                                        //alert("Clique no botão 'Atualizar conteúdo' para salvar");
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
            <div id="uploader">
                <p>Seu navegador é incompativel com upload de multiplos arquivos e poderá ocorrer alguns problemas no processo. <br/>Pedimos que use o navegador http://www.firefox.com ou http://www.google.com/chrome</p>
            </div>            
        </form>
    </body>
</html>
