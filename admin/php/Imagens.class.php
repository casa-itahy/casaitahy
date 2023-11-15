<?php
/**
*	ATUALIZA
*
*	@author Haroldo tibério
*	@copyright GPL � 2010, artwebdigita.com.br
*	@version ATUALIZA 2.0
*	@created 24/10/2011
*	@modified 24/10/2010
*
*/
include_once("../includes/db.php");
include_once("../php/funcoes.php");
include_once("../php/class.upload.php");
include_once("../php/sessao.php");
session_write_close();

class Imagens{
    protected $resultado='';
    protected $tabela='';
    protected $pasta='';
    protected $FILES='';
    protected $foto_principal='';

    function __construct($tabela,$FILES){
        $this->tabela=$tabela;
        $this->FILES=$FILES;
    }

    public function salvaImgPrinc($largura=540,$alturaThumb=120,$larguraThumb=120){
        $imagemUP = $this->FILES;
        if ($imagemUP['error'] == 0){
                $tam_img = getimagesize($imagemUP['tmp_name']);
                $destino = "../imagens/$this->tabela";
                $nomeImagem = date("dmYhis");
                $handle = new Upload($imagemUP);

                #----- Gera Thumb -----#
                if ($tam_img[0] < $largura){
                        $handle->image_resize = false;
                }else{
                        $handle->image_resize = true;
                }
                $handle->image_ratio_x = false;
                $handle->image_ratio_y = true;
                $handle->image_x = $alturaThumb;
                $handle->image_y = $larguraThumb;
                $handle->file_new_name_body = "thumb_".$nomeImagem;
                $handle->Process($destino);

                #---- Gera imagem maior -----#
                $tamanho = 	"540";
                if ($tam_img[0] < $tamanho){
                        $handle->image_resize = false;
                }else{
                        $handle->image_resize = true;
                }
                $handle->file_new_name_body	= $nomeImagem;
                $handle->image_ratio_x = false;
                $handle->image_ratio_y = true;
                $handle->mime_check = true;
                $handle->image_x = $tamanho;
                $handle->Process($destino);
                $foto_principal=$handle->file_dst_name;
                $handle-> Clean();
        }
    }

  /*array(5) {
  ["name"]=>
  array(2) {
    [0]=>
    string(22) "_04723032011064403.jpg"
    [1]=>
    string(23) "foto_20100819180301.jpg"
  }
  ["type"]=>
  array(2) {
    [0]=>
    string(10) "image/jpeg"
    [1]=>
    string(10) "image/jpeg"
  }
  ["tmp_name"]=>
  array(2) {
    [0]=>
    string(23) "C:\ms4w\tmp\php7BF8.tmp"
    [1]=>
    string(23) "C:\ms4w\tmp\php7C28.tmp"
  }
  ["error"]=>
  array(2) {
    [0]=>
    int(0)
    [1]=>
    int(0)
  }
  ["size"]=>
  array(2) {
    [0]=>
    int(30020)
    [1]=>
    int(637561)
  }
}
array(2) {
  [0]=>
  string(7) "titulo1"
  [1]=>
  string(7) "titulo2"
}
   CASO VENHA UM ARRAY DE IMAGENS FILES
*/
    public function salvaImagens(){
            $this->pasta = date("dmYhis");
            $destino = "../imagens/$this->pasta";
            $tamanho = 540;

            $files = array();
              foreach ($this->FILES as $k => $l) {
                      foreach ($l as $i => $v) {
                             if (!array_key_exists($i, $files))
                                     $files[$i] = array();
                              $files[$i][$k] = $v;
                      }
              }

            //haroldo
            $imagens = array();
            //fim
            foreach ($files as $indice => $file){
                    $tam_img = getimagesize($file['tmp_name']);
                    $width = $tam_img[0]; //largura-width
                    $height = $tam_img[1];

                    $handle = new Upload($file);

                    if ($handle->uploaded){
                            $nomeImagem = date("dmYhis");
                            $handle->image_resize = true;
                            $handle->image_ratio_x = true;

                            if($height>450){
                                    $handle->image_y = 450;
                            }else{
                                    $handle->image_y = $height;
                                    $handle->image_x = $width;
                            }

                            $handle->file_name_body_add =$nomeImagem;
                            $handle->Process($destino);
                            //haroldo
                                $imagens[] = array($handle->file_dst_name_body.'.'.$handle->file_dst_name_ext,$handle->image_dst_x,$handle->image_dst_y,$legenda[$indice]);
                            //fim
                            $handle->image_resize = true;
                            $handle->image_ratio_y = true;
                            $handle->image_x = $largura;
                            $handle->image_contrast = 10;
                            $handle->jpeg_quality = 70;
                            $handle->file_name_body_add = $nomeImagem;
                            $handle->Process($destino."/thumb");
                    }
                    $handle-> Clean();
            }
    }

  /*array(5) {
  ["name"]=>
  array(2) {
    [0]=>
    string(22) "_04723032011064403.jpg"
    [1]=>
    string(23) "foto_20100819180301.jpg"
  }
  ["type"]=>
  array(2) {
    [0]=>
    string(10) "image/jpeg"
    [1]=>
    string(10) "image/jpeg"
  }
  ["tmp_name"]=>
  array(2) {
    [0]=>
    string(23) "C:\ms4w\tmp\php7BF8.tmp"
    [1]=>
    string(23) "C:\ms4w\tmp\php7C28.tmp"
  }
  ["error"]=>
  array(2) {
    [0]=>
    int(0)
    [1]=>
    int(0)
  }
  ["size"]=>
  array(2) {
    [0]=>
    int(30020)
    [1]=>
    int(637561)
  }
}
array(2) {
  [0]=>
  string(7) "titulo1"
  [1]=>
  string(7) "titulo2"
}
   CASO VENHA UM INDICE DO ARRAY DE IMAGENS FILES
   * EXEMPLO
   *         $pdfs=$_FILES['arquivo'];
   *         for($x=0;$x<(count($pdfs['tmp_name'])-1);$x++){
   *              foreach($pdfs as $arquivo){
   *                    $imagem = new Imagens('docs', $FILES);
   *                     $imagem->salvaImgPorIndice($x,$legenda);
   *              }
   *         }
*/
    public function salvaImgPorIndice($indice,$alturaThumb=120,$larguraThumb=120){//Ja usando em gravar/docs.php
        $imagemUP = $this->FILES;
        //var_dump($imagemUP['error'][$x],$imagemUP);
        //die();
        if ($imagemUP['error'][$indice]==0 || is_null($imagemUP['error'][$indice])){                 
                $tam_img = getimagesize($imagemUP['tmp_name'][$indice]);
                $destino = "../imagens/$this->tabela";
                $nomeImagem = date("dmYhis");
                $objImagem["name"]=$imagemUP["name"][$indice];
                $objImagem["type"]=$imagemUP["type"][$indice];
                $objImagem["tmp_name"]=$imagemUP["tmp_name"][$indice];
                $objImagem["error"]=$imagemUP["error"][$indice];
                $objImagem["size"]=$imagemUP["size"][$indice];
                $handle = new Upload($objImagem);
                //var_dump($imagemUP["size"][$indice]);
                //die();
                
                #----- Gera Thumb -----#
                if ($tam_img[0] < $largura){
                        $handle->image_resize = false;
                }else{
                        $handle->image_resize = true;
                }
                $handle->image_ratio_x = false;
                $handle->image_ratio_y = true;
                $handle->image_x = $alturaThumb;
                $handle->image_y = $larguraThumb;
                $handle->file_new_name_body = "thumb_".$nomeImagem;                
                $handle->Process($destino);
                $res = $handle->file_dst_name_body.'.'.$handle->file_dst_name_ext;                
                $handle->Clean();                
        }
        if($res=='' || $res==null){
            $res = false;
        }
        return $res;
        
    }

    protected function insertImgPrinc(){
        /* Procura a ultima posi��o */
        $posicao = ultimaPosicao($this->tabela);
        $posicao = $posicao + 1;

        $titulo = ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $titulo) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));
        $texto= ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $texto) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));

        $sql="INSERT INTO $this->tabela (titulo, conteudo, posicao, imagem, created, modified)VALUES('$titulo','$texto','$posicao','$foto_principal',NOW(),NOW())";
        $conn = conecta();
        $q = mysqli_query($conn, $sql);
        @((is_null($___mysqli_res = mysqli_close($conn))) ? false : $___mysqli_res);
        $resultado=true;
        if($q == false){
           $resultado = "Erro ao realizar a operação! cod 1";
        }
        return $resultado;
    }


     protected function insertImagens($imagens){
       $resultado=true;
       if(count($imagens)>0){
            $sql='';
            $ultimo_id = ((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);
            $posicao=0;
            foreach($imagens as $item){
                 $posicao++;
                 $sql="INSERT INTO img_pasta_albuns(albuns_id,pasta,src,posicao,legenda,width,height)VALUES('$ultimo_id','$this->pasta','$item[0]','$posicao','$item[3]','$item[1]','$item[2]');";
                 $q = @mysqli_query($conn, $sql);
                 if($q == false) break;
            }
            @((is_null($___mysqli_res = mysqli_close($conn))) ? false : $___mysqli_res);
            if($q == false){
                $resultado = "Erro ao realizar a operação! cod 2";
            }            
       }
       return $resultado;
     }
}

?>
