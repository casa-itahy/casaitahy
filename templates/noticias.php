<div class="topo-paginas topo-blog">
    <div class="container text-center">
        <div class="row justify-content-center">
            <div class="col-lg-6 anime">
                <h2><?php echo $conteudo_pagina['titulo']; ?></h2>
                <h1><?php echo $conteudo_pagina['subtitulo']; ?></h1>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="espaco-menor"></div>
    <div class="row">
        <div class="col-lg-9 col-md-8 anime">
            <?php if (!empty($noticias)): ?>
                <?php foreach ($noticias as $key => $nt) { ?>
                    <div class="noticia-individual noticia-interna-individual">
                        <a href="<?php echo $nt['lin_nome']; ?>" class="caixa-imagem-interna">
                            <?php if (!empty($nt['imagem'])) { ?>
                                <img src="<?php echo IMAGENS."noticias/".$nt['imagem'];?>" alt="<?php echo $nt['titulo']; ?>" title="<?php echo $nt['titulo']; ?>" />
                            <?php } ?>
                        </a>
                        <a href="<?php echo $nt['lin_nome']; ?>" class="d-block data-blog text-dark"><?php echo formataData($nt['created']); ?></a>
                        <a href="<?php echo $nt['lin_nome']; ?>"><h3><?php echo $nt['titulo']; ?></h3></a>
                        <a href="<?php echo $nt['lin_nome']; ?>" class="d-block text-dark mb-3"><?php echo $nt['descricao'];?></a>
                        <a href="<?php echo $nt['lin_nome']; ?>" class="btn-underline font-weight-bold">leia mais</a>
                    </div>
                <?php } ?>
                <?php if($total_paginas > 1) { ?>
                    <div class="paginacao-blog">
                        <?php if ($total_paginas > 5): ?>
                            <?php if ($pagina > 1) { ?>
                                <a href="<?php echo $pag; ?>/&pager=<?php echo $pagina-1; ?>"><i class="fas fa-angle-double-left"></i></a>
                            <?php } ?>
                            <?php if ($pagina <= 5): ?>
                                <?php for($i=1; $i <= 6; $i++){ ?>
                                    <a href="<?php echo $pag; ?>/&pager=<?php echo $i; ?>" <?php if($i == $pagina) { ?>class="pager-ativo"<?php } ?>><?php echo $i; ?></a>
                                <?php } ?>
                            <?php else: ?>
                                <?php 
                                    $pagInicio = $pagina - 3;
                                    $pagFinal = $pagina + 3;
                                    if ($pagFinal >= $total_paginas) {
                                        $pagFinal = $total_paginas;
                                    }
                                    
                                ?>
                                <?php for($i=$pagInicio; $i <= $pagFinal; $i++){ ?>
                                    <a href="<?php echo $pag; ?>/&pager=<?php echo $i; ?>" <?php if($i == $pagina) { ?>class="pager-ativo"<?php } ?>><?php echo $i; ?></a>
                                <?php } ?>
                            <?php endif ?>
                        <?php else: ?>
                            <?php for($i=1; $i <= $total_paginas; $i++){ ?>
                                <a href="<?php echo $pag; ?>/&pager=<?php echo $i; ?>" <?php if($i == $pagina) { ?>class="pager-ativo"<?php } ?>><?php echo $i; ?></a>
                            <?php } ?>
                        <?php endif ?>
                        <?php $botaoProximo = $pagina+1;
                            if ($botaoProximo <= $total_paginas) { ?>
                                <a href="<?php echo $pag; ?>/&pager=<?php echo $botaoProximo; ?>"><i class="fas fa-angle-double-right"></i></a>
                        <?php } ?>
                    </div>
                <?php } ?>
            <?php else: ?>
                <div class="alert alert-danger text-center">Nenhuma notícia cadastrada no momento!</div>
            <?php endif ?>
        </div>
        <div class="col-lg-3 col-md-4 blog-direita anime">
            <form id="search" method="post" action="<?php echo $pag; ?>">
                <input type="text" class="text" name="busca" id="busca" placeholder="Buscar" required="required" <?php if (!empty($buscar)): ?>value="<?php echo $buscar; ?>"<?php endif ?> />
                <button type="submit"><i class="fas fa-search"></i></button>
            </form>
            <div class="espaco-blog-direita"></div>
            <h3 class="texto-laranja">Categorias</h3>
            <?php foreach ($categorias as $ct): ?>
                <a href="<?php echo $ct['lin_nome']; ?>"><?php echo $ct['titulo']; ?></a>
            <?php endforeach ?>
            <div class="espaco-blog-direita"></div>
            <?php if (!empty($noticias_destaque)): ?>
                <h3 class="texto-laranja">Artigos em Destaque</h3>
                <?php foreach ($noticias_destaque as $key => $nt) { ?>
                    <div class="noticia-destaque-individual">
                        <a href="<?php echo $nt['lin_nome']; ?>" class="caixa-imagem-destaque">
                            <?php if (!empty($nt['imagem'])) { ?>
                                <img src="<?php echo IMAGENS."noticias/".$nt['imagem'];?>" alt="<?php echo $nt['titulo']; ?>" title="<?php echo $nt['titulo']; ?>" />
                            <?php } ?>
                        </a>
                        <a href="<?php echo $nt['lin_nome']; ?>"><h3><?php echo $nt['titulo']; ?></h3></a>
                    </div>
                <?php } ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<div class="espaco"></div>