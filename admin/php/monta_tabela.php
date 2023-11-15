<?php
    include_once('../includes/db.php');
    include_once('../includes/functions.php');
    include_once("../fck/fckeditor.php");

    $msg = "";
    $prod_id = anti_sql($_POST['prod_id']);
    $kit_id = anti_sql($_POST['kit_id']);
    $bloco_id = anti_sql($_POST['bloco_id']);
    $item_id = anti_sql($_POST['item_id']);
    $cod = anti_sql($_POST['cod']);
    $nome = anti_sql($_POST['nome']);    

    $tabela='';
    
     //BUSCA SE EXISTE KIT PARA CADA PRODUTO E KIT
    $sql = "SELECT * FROM kit_prod_bloco WHERE produto_id='$prod_id' AND kit_id='$kit_id' ORDER BY ordem";    
    $itens_kit = query($sql);
    
    
    $existe_bloco=false;
    if(count($itens_kit)>0){        
        foreach($itens_kit as $item){
            //BUSCA SE EXISTE KIT PARA CADA PRODUTO E KIT
            if($item['bloco_id']==$bloco_id){
                $existe_bloco=true;
            }
        }
    }

    //SE EXISTIR ITENS, INSERIR OS DADOS NAS TABELAS
    if((!empty($item_id)) && (!is_null($item_id))){
        if(count($itens_kit)<1 || $existe_bloco==false){
                //SENÃO INSERE OS DADOS DE PRODUTOxKITxBLOCO
                $sql="INSERT INTO kit_prod_bloco(produto_id,kit_id,bloco_id)VALUES('$prod_id','$kit_id','$bloco_id');";                
            $conn = conecta();
            $q = @mysqli_query($conn, $sql);         
            @((is_null($___mysqli_res = mysqli_close($conn))) ? false : $___mysqli_res);
        }
        //verifica se ja existe este item cadastrado para o bloco e kit e produto
        $sql = "SELECT * FROM itens_prod_bloco WHERE produto_id='$prod_id' AND bloco_id='$bloco_id' AND itens_id='$item_id' AND kit_id='$kit_id' ORDER BY ordem";        
        $existe_itens = query($sql);

        if(count($existe_itens)<1){//SE NÃO EXISTE AINDA ITEM PARA O PRODUTO/KIT/BLOCO
            $sql = "SELECT MAX(ordem) as num_ordem FROM itens_prod_bloco WHERE produto_id='$prod_id' AND bloco_id='$bloco_id' AND kit_id='$kit_id'";            
            $maior_ordem_itens = query($sql);

            //SALVA OS ITENS PARA CADA PRODUTO, KIT E BLOCO
            $sql="INSERT INTO itens_prod_bloco(produto_id,bloco_id,itens_id,kit_id,ordem)VALUES('$prod_id','$bloco_id','$item_id','$kit_id','".($maior_ordem_itens[0]['num_ordem']+1)."');";
            $conn = conecta();
            $q = @mysqli_query($conn, $sql);
            if($q==false){
                $erro = $sql;
            }
            @((is_null($___mysqli_res = mysqli_close($conn))) ? false : $___mysqli_res);
        }        
    }else{        
        //INSERE NOVO ITEM        
        if(!is_null($cod) && !is_null($nome)){
            $sql = "SELECT * FROM itens WHERE cod='$cod' AND descricao = '$nome'";            
            $item = query($sql);

            if(count($item)<1){
                $sql="INSERT INTO itens(cod,descricao)VALUES('$cod','$nome');";
                $conn = conecta();
                //var_dump($sql);
                //die();
                $q = @mysqli_query($conn, $sql);
                if($q==false){
                    $erro = $sql;
                }
                @((is_null($___mysqli_res = mysqli_close($conn))) ? false : $___mysqli_res);
            }
        }
    }
    /*//RE-ATUALIZA OS DADOS
    if(!isset($prod_nome_simples)){
        $sql = "SELECT prod_nome_simples FROM kit_prod_bloco WHERE produto_id=$prod_id ORDER BY prod_nome_simples LIMIT 1";
        $prod_nome_simples = query($sql);
    }*/
    
    
    $sql = "SELECT * FROM kit_prod_bloco WHERE produto_id=$prod_id AND kit_id=$kit_id AND bloco_id=$bloco_id ORDER BY ordem";    
    $itens_kit_bloco = query($sql);

    $sql = "SELECT * FROM kit_prod_bloco WHERE produto_id=$prod_id AND kit_id=$kit_id ORDER BY ordem";    
    $itens_kit = query($sql);
    
     $sql = "SELECT i.id, i.nome, i.sigla,ni.prod_nome_simples,ni.observacao FROM idiomas i 
                LEFT JOIN kit_prod_bloco_idioma ni ON(i.id=ni.idioma_id)
             WHERE i.status=1 AND i.id!=1 AND ni.produto_id=$prod_id AND ni.kit_id=$kit_id ORDER BY i.id";

    //var_dump($sql);die();
    $itens_idioma = query($sql);
    
    $sql = "SELECT * FROM idiomas WHERE status=1 AND sigla!='Port'";
    $idiomas = query($sql);

    //BUSCA ITENS
    $sql = "SELECT * FROM itens ORDER BY descricao";
    $itens = query($sql);

    if($itens_kit[0]['permite_curso']==1){
        $checkedNao="";
        $checkedSim="selected";
    }else{
        $checkedNao="selected";
        $checkedSim='';
    }
    if($itens_kit_bloco[0]['obrigatorio_kit']==1){
        $cobNao="";
        $cobSim="selected";
    }else{
        $cobNao="selected";
        $cobSim='';
    }
    
    $tabela .="
        <div id='div_salvou' align='center'></div>        
        <table width='100%' border='0' cellspacing='2' cellpadding='3'>          
          <tr>
            <td width='154' class='titulo_noticias'>Nome simples Português</td>
              <td colspan='2' class='titulo_noticias'><label>
                <input id='nome_simples' name='nome_simples' type='text' value='".$itens_kit[0]['prod_nome_simples']."' onBlur='insereValorCampo(this.value,1)' style='min-width: 250px;'/></label>
              </td>
          </tr>";
          foreach($idiomas as $idioma){              
              $sigla=$idioma['sigla'];
              if(count($itens_idioma)>0){
                  foreach($itens_idioma as $dado){
                      if($idioma['id']==$dado['id']){
                        $prod_nome_simples = $dado['prod_nome_simples'];          
                      }
                  }
              }else{
                  $prod_nome_simples ='';
              }
              $tabela .="
                  <tr>
                    <td width='154' class='titulo_noticias'>Nome simples ".$idioma['nome']."</td>
                      <td colspan='2' class='titulo_noticias'><label>
                        <input id='nome_simples".$sigla."' name='nome_simples".$sigla."' type='text' value='".$prod_nome_simples."' onBlur=\"insereValorCampo(this.value,'$sigla')\" style='min-width: 250px;'/></label>
                  </td>
                </tr>";
          }       
  $tabela .="
          <tr>
            <td width='154' class='titulo_noticias'>Prefixo</td>
            <td colspan='2' class='titulo_noticias'><label>
              <input id='prefixo' name='prefixo' type='text' value='".$itens_kit[0]['prefixo_kit_prod']."' onBlur='insereValorCampo(this.value,2)' style='min-width: 250px;'/></label>
              </td>
          </tr>
          <tr>
            <td width='154' class='titulo_noticias'>Permite curso </td>
            <td colspan='2' class='titulo_noticias' ><label>
                <select id='curso' name='curso' onchange='insereValorCampo(this.value,3)' style='min-width: 250px;'>
                    <option value='0' ".$checkedNao.">Não </option>
                    <option value='1' ".$checkedSim.">Sim </option>
                </select>
                </label>
            </td>
          </tr>          
          <tr>
            <td width='154' class='titulo_noticias'>Ordem do bloco</td>
              <td colspan='2' class='titulo_noticias'><label>
                <input id='ordem' name='ordem' type='text' value='".$itens_kit_bloco[0]['ordem']."' onBlur='insereValorCampo(this.value,5)'/> </label>
              </td>
          </tr>
          <tr>
            <td width='154' class='titulo_noticias'>Obrigatório Kit</td>
              <td colspan='2' class='titulo_noticias'><label>
                    <select id='obrigatorio' name='obrigatorio' onchange='insereValorCampo(this.value,4)' style='min-width: 250px;'>
                        <option value='0' ".$cobNao.">Não </option>
                        <option value='1' ".$cobSim.">Sim </option>
                    </select>
                </label>
                </td>
          </tr>
        </table>
        <table border='0' cellspacing='1' cellpadding='2' width='650'>
              <tr>
                 <td width='250'>
                        <div id='div_select_item' name='div_select_item'>
                             <table>
                                 <tr>
                                     <td height='25' align='left' bgcolor='#FBFBFB'>
                                            Itens
                                            <select name='selectitem' id='selectitem' class='texto_tabela' onChange='montaTabela(document.getElementById(\"selectitem\").value)'>
                                                     <option value=''>Selecione...</option>";
                                            $selected="";
                                            foreach ($itens as $item){
                                                //if()
                                                $tabela .='<option value="'.$item['id'].'" '.$selected.'>'.$item['cod'].' - '.$item['descricao'].'</option>';
                                            }
                                            $tabela .="</select>                                            
                                      </td>";
                            $tabela .='
                                 </tr>
                              </table>
                       </div>
                   </td>                   
                   <td width="300">
                     <a id="ancora" name="ancora" href="javascript:liberaCampo(1)"><img width="22" height="22" border="0" align="absmiddle" title="Cadastrar item" src="./img/incluir.gif"> Cadastrar novo item</a>
                   </td>
                   <td width="300">
                        <div id="div_campo" name="div_campo" style="float:right; display:none;">
                             <table>
                                <tr>
                                    <td width="70" class="titulo_noticias">Código</td>
                                    <td class="titulo_noticias"><label>
                                       <input name="cod" type="text" id="cod" size="12" maxlength="6" class="required">
                                    </label></td>
                                    <td width="70" class="titulo_noticias">Nome</td>
                                    <td class="titulo_noticias"><label>
                                        <input name="nome" type="text" id="nome" size="45"  class="required">
                                        </label>
                                    </td>
                                    <td class="titulo_noticias">
                                       <a href="javascript:insereItem(document.getElementById(\'cod\').value,document.getElementById(\'nome\').value)"><img width="22" height="22" border="0" align="absmiddle" title="Adicionar item" alt="Adicionar item" src="./img/filesave_22x22.png">Salvar</a>
                                    </td>
                                    <td class="titulo_noticias">
                                        <a href="javascript:liberaCampo()"><img width="22" height="22" border="0" align="absmiddle" src="./img/cancel_22x22.png">Cancelar</a>
                                    </td>
                                </tr>
                             </table>
                       </div>
                   </td>
              </tr>
          </table><hr />';

    if(count($itens_kit)>0){        
            //BUSCA SE EXISTE KIT PARA CADA PRODUTO E KIT
            $sql = "SELECT i.*,ipb.ordem FROM itens i LEFT JOIN itens_prod_bloco ipb ON(i.id=ipb.itens_id) WHERE ipb.produto_id=$prod_id AND ipb.kit_id=$kit_id AND ipb.bloco_id=$bloco_id ORDER BY ipb.ordem";
            $itens_itens = query($sql);

            if(count($itens_itens)>0){
                $tabela .= '<table width="740" border="0" align="center" cellpadding="0" cellspacing="0">
                   <tr>
                    <td height="10" align="center">'.$msg.'</td>
                   </tr>
                   <tr>
                    <td align="center" class="titulo_noticias"><div id="div_msg"></div></td>
                   </tr>
                   <tr>
                    <td align="left" class="titulo_noticias">
                    <table width="700" border="0" cellspacing="1" cellpadding="2">
                        <tr style="background-color:#D6D6D6;">
                            <td height="30" width="150" align="center" background="img/btn_agendar/bg_menu_agendar.jpg" class="texto_obs"><strong>Código</strong></td>
                            <td height="30" width="400" align="center" background="img/btn_agendar/bg_menu_agendar.jpg" class="texto_obs"><strong>Descrição</strong></td>
                            <td height="30" width="75" align="center" background="img/btn_agendar/bg_menu_agendar.jpg" class="texto_obs"><strong>Ordem</strong></td>
                            <td height="30" width="75" align="center" background="img/btn_agendar/bg_menu_agendar.jpg" class="texto_obs"><strong>Excluir</strong></td>
                        </tr>';
                $bgCor = '';
                foreach($itens_itens as $item){
                     if($bgCor=='') $bgCor='style=\'background-color:#F8F8F8\''; else $bgCor='';
                     $tabela.= '<tr '.$bgCor.'>
                                <td height="25" align="center">
                                    <span style="font-weight: normal;">'.$item['cod'].'<span/>
                                </td>
                                <td height="25" class="texto_linhas_ebeauty" align="center">
                                    <span style="font-weight: normal;">'.$item['descricao'].'<span/>
                                </td>
                                <td align="center" class="texto_contato" align="center">                                    
                                      <label><input name="ordem'.$item['id'].'" type="text" id="ordem'.$item['id'].'" size="3" value="'.$item['ordem'].'" onBlur="javascript:ordenar('.$item['id'].')"></label>
                                </td>
                                <td align="center" class="texto_contato" align="center">
                                    <a href="javascript:confirmar('.$item['id'].')">
                                      <img src="./img/excluir2.gif" alt="Excluir Item" title="Excluir Item" width="13" height="13" border="0">
                                    </a>
                                    <input type="hidden" id="item_id'.$conta.'" name="item_id'.$conta.'" value="'.$serv_id.'" />
                                </td></tr>';                        

                }
                $tabela.= '</table></td></tr></table>';
            }else{
                $tabela .= "<div style='height:200px text-align:center; padding-top:50px;'></div>";
            }        
    }else{
        $tabela .= "<div style='height:200px text-align:center; padding-top:50px;'></div>";
    }

 echo $tabela."<br /><hr/>
            <div style='background-color:#C5CEFA; width: 100%; text-align: center;'>Observação</div>
     
            <table width='100%' style='200px;' border='0'>   
            <tr>
                <td width='154' class='titulo_noticias'>Português</td>
                <td style='350px;'>";  
                  
                $oFCKeditor = new FCKeditor('observacao') ;
                $oFCKeditor->BasePath = 'fck/' ;
                $oFCKeditor->Height = 150;                                                         
                $oFCKeditor->Value = $itens_kit[0]['observacao'];                
                              
                $text = $oFCKeditor->Create();
                $oFCKeditor->Config['SkinPath'] = 'editor/skins/office2003/';  
 
echo "</td></tr>";
        
     foreach($idiomas as $idioma){              
          $sigla=$idioma['sigla'];
          if(count($itens_idioma)>0){
              foreach($itens_idioma as $dado){
                  if($idioma['id']==$dado['id']){
                    $observacao = $dado['observacao'];          
                  }
              }
          }else{
              $observacao ='';
          }
           echo "            
            <tr>
                <td width='154' class='titulo_noticias'>".$idioma['nome']."</td>
                <td style='350px;'>";  
           
                $oFCKeditor = new FCKeditor('observacao'.$sigla) ;
                $oFCKeditor->BasePath = 'fck/';
                $oFCKeditor->Height = 150;                                                         
                $oFCKeditor->Value = $observacao;                
                              
                $text = $oFCKeditor->Create();
                $oFCKeditor->Config['SkinPath'] = 'editor/skins/office2003/';             
           
              echo "</td></tr>";
      }       
 echo "</table>
                <div style='width:100%; margin-top:15px;'>                 
                    <a href='javascript:enviaForm();' style='width:100%; color:#990000; font-weight:bold;'><img height='22' width='22' border='0' src='./img/filesave_22x22.png'>Salvar observação</a>
               </div>
            </td>
          </tr></table>";
        

?>
        