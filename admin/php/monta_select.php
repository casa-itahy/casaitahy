<?php
header("Content-type: text/html; charset=UTF-8");
	
        if(!isset($id)){
            include_once('../includes/db.php');
            include_once('../includes/functions.php');
            
            $id = anti_sql($_POST['id']);
            $tipo = anti_sql($_POST['tipo']);
            $retiraOnchange = @anti_sql($_POST['retiraOnchange']);
        }

        //PRODUTOS
        if(isset($produto_selected)){
            $tipo=1;
        }
            
        if($tipo==1){                        
            $sql = "SELECT distinct(p.id),p.titulo FROM produtos p
                    LEFT JOIN cat_subcat_nivel csn ON(p.categoria_id = csn.cat_pai_id OR p.categoria_id = csn.cat_filho_id)
                    WHERE status=1 AND (csn.cat_pai_id=".$id." OR csn.cat_filho_id=".$id.")";
            $itens = query($sql);
            
            
            
            if($retiraOnchange==1){
                $retiraOnchange = "";
            }else{
                $retiraOnchange = "onchange='montaSelect(2)'";
            }
            
            if (count($itens) > 0){
                    $select = "<select id='produto' name='produto' $retiraOnchange class='email' style='min-width: 250px;'>";
                    $select .= "<option>Selecione</option>";

                    $selected='';
                    foreach ($itens as $item){
                            if(isset($produto_selected)){
                                if($produto_selected==$item['id']){
                                    $selected='selected';
                                }
                            }
                            $select .= "<option $selected value='".$item['id']."'>".$item['titulo']."</option>";
                            $selected='';
                    }
                    $select .= "</select>";
            }else{
                    $select = "Produto não disponível";
            }
        }else{
            if($tipo==2){
                $sql = "SELECT * FROM kit ORDER BY id";
                $itens = query($sql);
                if (count($itens) > 0){
                        $select = "<select id='kit' name='kit' onchange='montaSelect(3)' class='email' style='min-width: 250px;'>";
                        $select .= "<option>Selecione</option>";

                        foreach ($itens as $item){
                            $select .= "<option value='".$item['id']."'>".$item['descricao']."</option>";
                        }
                        $select .= "</select>";
                }else{
                        $select = "Kit não disponível";
                }
            }else{
                if($tipo==3){
                    $sql = "SELECT * FROM bloco ORDER BY descricao";
                    $itens = query($sql);
                    if (count($itens) > 0){
                            $select = "<select id='bloco' name='bloco' onchange='montaTabela()' class='email' style='min-width: 250px;'>";
                            $select .= "<option>Selecione</option>";

                            foreach ($itens as $item){
                                $select .= "<option value='".$item['id']."'>".$item['descricao']."</option>";
                            }
                            $select .= "</select>";
                    }else{
                            $select = "Bloco não disponível";
                    }
                }
            }
        }	

echo $select;
?>