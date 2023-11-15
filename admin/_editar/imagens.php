<?php 

$id = $_GET['id'];

$pasta = "imagens/".$id;
if (is_dir($pasta)){

$dir = opendir($pasta);

if (!empty($dir))
{
	$pics = array();
	$exp="/jpg|jpeg|JPG|JPEG|bmp|png|gif/";
	while ($fname = readdir($dir)){
	if (preg_match($exp,$fname))
	{
			$pics []=$fname;
	}
}
closedir($dir);

$tam = count ($pics);

echo "<table border=0><tr>";

for ($i=0; $i<$tam; $i++)
{

	$mod = $i % 3;
	if ($mod == 0)
	{
		echo "</tr><tr>";
	}
	
	echo "<td><img src=".$pasta."/".$pics[$i]." width=150><br><center><a href='php/apagarImagemAlbum.php?pasta=".$id."&img=".$pics[$i]."' >Apagar</a></center><br></td>";
	
}
echo "</tr></table>";
/*
$tam = sizeof($pics);


$indice=-1;

foreach ($pics as $fname){
	 $tpl -> newBlock('fotos');
	 $tpl -> assign('pasta', $linha->fotos);
	 $tpl -> assign('foto', $fname);
	 $indice++;
	 $mod=$indice;
	 $mod=$indice%3;
	  if ($mod==0){
	 	 $tpl -> assign('fechaTr', "</tr>");
		 $tpl -> assign('abreTr', "<tr><td>");
	  }
	 $caminho=$pasta."/".$fname;
	 $tpl -> assign('id', $linha->id);
	 $tpl -> assign('nome', $fname);
	}*/
}

}
else
{
	$msg = "Album Vazio!";
	echo "<span class='msg'>".$msg."</span>";
}
?>