<?php 
 
    $id = $_GET['id'];
    include_once '../../includes/db.php';
    
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
<link rel="stylesheet" href="jquery.plupload.queue/css/jquery.plupload.queue.css" type="text/css" media="screen" />
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
<script type="text/javascript" src="https://bp.yahooapis.com/2.4.21/browserplus-min.js"></script>
<script type="text/javascript" src="plupload.js"></script>
<script type="text/javascript" src="plupload.gears.js"></script>
<script type="text/javascript" src="plupload.silverlight.js"></script>
<script type="text/javascript" src="plupload.flash.js"></script>
<script type="text/javascript" src="plupload.browserplus.js"></script>
<script type="text/javascript" src="plupload.html4.js"></script>
<script type="text/javascript" src="plupload.html5.js"></script>
<script type="text/javascript" src="jquery.plupload.queue/jquery.plupload.queue.js"></script>


<div id="uploader" style="width: 100%; height: 350px;">Your browser doesn't support upload.</div>

<script type="text/javascript">
$(function() {
	function log() {
		var str = "";

		plupload.each(arguments, function(arg) {
			var row = "";

			if (typeof(arg) != "string") {
				plupload.each(arg, function(value, key) {
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
						row += (row ? ', ': '') + key + '=' + value;
					}
				});

				str += row + " ";
			} else { 
				str += arg + " ";
			}
		});

		$('#log').val($('#log').val() + str + "\r\n");
	}

	$("#uploader").pluploadQueue({
		// General settings
		runtimes: 'html5,flash,gears,browserplus,silverlight,html4',
		url : '../../_update/produtos_upload.php?id=<?php echo $id ?>&pag=<?php echo $pag ?>',
		max_file_size: '10mb',
		
		unique_names: false,
		file_data_name : 'arquivo',

		// Resize images on clientside if we can
		resize: {width: false, height: false, quality: false},
//		resize: {width: 900, height: 660, quality: 90},

		// Specify what files to browse for
		filters: [
			{title: "Image files", extensions: "jpg,jpeg,png"}
		],

		// Flash/Silverlight paths
		flash_swf_url: 'plupload.flash.swf',
		silverlight_xap_url: 'plupload.silverlight.xap',

		// PreInit events, bound before any internal events
		preinit: {
			Init: function(up, info) {
				log('[Init]', 'Info:', info, 'Features:', up.features);
			},

			UploadFile: function(up, file) {
				log('[UploadFile]', file);

				// You can override settings before the file is uploaded
				// up.settings.url = 'upload.php?id=' + file.id;
				// up.settings.multipart_params = {param1: 'value1', param2: 'value2'};
			}
		},

		// Post init events, bound after the internal events
		init: {
			Refresh: function(up) {
				// Called when upload shim is moved
				log('[Refresh]');
			},

			StateChanged: function(up) {
				// Called when the state of the queue is changed
				log('[StateChanged]', up.state == plupload.STARTED ? "STARTED": "STOPPED");
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

				// Handle file specific error and general error
				if (args.file) {
					log('[error]', args, "File:", args.file);
				} else {
					log('[error]', args);
				}
			}
		}
	});

});
</script>