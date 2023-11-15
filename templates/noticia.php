<?php if ($noticia) { ?>
    <div class="topo-paginas topo-blog">
        <div class="container text-center">
            <div class="row justify-content-center">
                <div class="col-lg-6 anime">
                    <h2>Blog</h2>
                    <h1><?php echo $noticia['titulo']; ?></h1>
                </div>
            </div>
        </div>
    </div>
    <div class="container anime">
        <div class="espaco-menor"></div>
        <div class="texto-simples">
            <?php if(!empty($noticia['imagem'])) { ?>
                <img src="<?php echo IMAGENS.'noticias/'.$noticia['imagem']; ?>" alt="<?php echo $noticia['titulo']; ?>" title="<?php echo $noticia['titulo']; ?>" class="imagem-principal-noticia" />
            <?php } ?>
            <?php echo $noticia['conteudo']; ?>
        </div>
        <div class="clearfix"></div>
        <div class="text-right">
            <strong>Compartilhar:</strong>
            <div class="compartilhar-individual">
                <b:if cond='data:blog.pageType == "item"'>
                <div align="center"><a href="<?php echo $config['www']; ?>/<?php echo $pag; ?>" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent('<?php echo $config['www']; ?>/<?php echo $pag; ?>'), 'facebook-share-dialog', 'width=626,height=436'); return false;"><i class="fab fa-facebook-f"></i></a></div>
                </b:if> 
            </div>
            <a target="new" href="http://twitter.com/share?text=<?php echo $noticia['titulo']; ?> - &url=<?php echo $config['www']; ?>/<?php echo $pag; ?>" class="compartilhar-individual">
                <i class="fab fa-twitter"></i>
            </a>
        </div>
    </div>
    <div class="espaco"></div>
<?php } ?>