<?php

$sql="SELECT * FROM banners WHERE id=".$_POST['id'];
$banners = query($sql);

if (count($grupo)<1){	
	echo "<span class='msg'>Nenhuma imagem salva para o grupo selecionado!</span>";
        die();
}else{
    $pics = array();
        foreach($banners as $banner){//$pasta
	$pasta = "imagens/grupo".$banner['grupo'];
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

	echo "<table border=0 align=center><tr>";
        
        foreach($imagens as $i => $img){
             //for ($i=0; $i<$tam; $i++){
                    //if($img['src']==$pics[$i]){
                        $src=$img['src'];
                        $mod = $i % 5;
                        if ($mod == 0){
                           echo "</tr><tr>";
                        }
                        echo "
                            <td>
                                <img src='imagens/".$img['pasta']."/thumb/".$pics[$src]."' >
                                <br>
                                <center style='background-color:#ECE9E2;'>
                                        <a href=javascript:mudaPosicao(".$img['id'].",".$id.",'s') >
                                                    <span class='valor_prod'> <img src='./img/left_16.png' alt='Posicionar para esquerda' width='16' height='16' border='0'> </span>
                                        </a>&nbsp;
                                        <a href=javascript:mudaPosicao(".$img['id'].",".$id.",'d') >
                                                    <span class='valor_prod'> <img src='./img/right_16.png' alt='Posicionar para direita' width='16' height='16' border='0'> </span>
                                        </a>&nbsp;&nbsp;&nbsp;&nbsp;";
                                if($pics[$src]=='') $srcImg=$src; else $srcImg=$pics[$src];
                                
                         echo   "<a href=javascript:confirmar('php/apagarImagemProd.php?id=".$id."&pasta=".$img['pasta']."&img=".$srcImg."&pag=".$paginas['pag_tab_id']."') >
                                                <img src='./img/excluir.gif' alt='Excluir' width='13' height='13' border='0'>
                                        </a>
                                </center>
                                <br>
                        </td>";
                    //}
            //}
        }
	echo "</tr></table>";	
}		

/*
$num = $_GET[num];

for ($i=0; $i!=$num; $i++)
{
	$form .= "<input type='file' name='imagem[".$i."]' id='imagem[".$i."]' /><br>";
}
$form .= "<input type='hidden' id='altura' name='altura' value='500'>";
$form .= "<input type='hidden' id='largura' name='largura' value='500'>";
$form .= "<br /> <input type='submit' value='Gravar' />";

echo $form;*/
?>