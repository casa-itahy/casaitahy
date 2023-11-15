<?php
if(!isset($grupo)){//SE O grupo_id VEM no include
    $grupo = $_POST['grupo'];    
    include_once '../includes/db.php';
    $url = "../imagens/banners/grupo";
}else{
    include_once '../includes/db.php';
    $url = "../imagens/banners/grupo";
}

$sql = "SELECT b.id,b.grupo,b.nome,b.ordem,b.src,gb.width,gb.height,b.status FROM banners b LEFT JOIN grupo_banners gb ON(b.grupo = gb.id) WHERE b.grupo='".$grupo."' ORDER BY b.ordem";
$banners = query($sql);

if(count($banners)<1){
	echo "<span class='msg'>Nenhuma imagem!</span>";
}else{
    $pics = array();
        foreach($banners as $banner){
            $nome = htmlspecialchars($banner['nome']);
            $pasta = $url.$banner['grupo'];
            //var_dump($pasta);     die();          
            if (is_dir($pasta)){                   
                $dir = opendir($pasta);
                if (!empty($dir)){              
                        $exp="/jpg|jpeg|JPG|JPEG|bmp|png|gif/";
                    while ($fname = readdir($dir)){
                        if (preg_match($exp,$fname)){
                            $pics[$fname]=$fname;
                            
                        }
                    }
                closedir($dir);
                }
                $tam = count($pics);
           }
        }
        //die();
              $conta=0;
             $html= '<ul id="list2">';
             //$html= '<ul id="gallery">';              
            foreach($banners as $i => $img){
                        $src=$img['src'];
                        /*$mod = $i % 5;
                        if ($mod == 0){
                           echo "</tr><tr>";
                        }*/
                   $conta++;
                   $html.= "<li itemID='".$img['id'].",".$img['grupo']."'><div>
                                <img src='imagens/banners/grupo".$img['grupo']."/".$pics[$src]."' style='max-width:180px; max-height:120px;' />                                
                                      
                                </div>
                                <center style='background-color:#ECE9E2;'>
                                            <a href=javascript:editar(".$img['id'].")>
                                                    <img src='./img/edit_16x16.gif' alt='Editar' title='Editar' width='13' height='13' border='0'>
                                            </a>&nbsp;&nbsp;&nbsp;&nbsp;";

                                                if($img['status']==1){
                                                    $html.= "<a href=javascript:ocultar(".$img['id'].",v=0)> <img id='imgoculto".$img['id']."' src='./img/olho_visivel.gif' alt='Ocultar' title='Ocultar' width='20' height='13' border='0'>";
                                                }else{
                                                    $html.= "<a href=javascript:ocultar(".$img['id'].",v=1)> <img id='imgoculto".$img['id']."' src='./img/olho_oculto.gif' alt='Ativar' title='Ativar' width='20' height='13' border='0'>";
                                                }
                                            $html.= "</a>&nbsp;&nbsp;&nbsp;&nbsp;
                                                <a href=javascript:confirmar(".$img['id'].")>
                                                        <img src='./img/excluir.gif' alt='Excluir' title='Excluir' width='13' height='13' border='0'>
                                                </a>
                                        </center></li>";	
            }
           $html.= '</ul><div style="clear:both;"></div>';
           
        echo $html;
}

?>