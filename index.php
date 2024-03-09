<?php

@session_start();
//session_destroy();
include_once('php/index.php'); ?>

<!DOCTYPE html>
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>

    <script type="application/ld+json">
        {
        "@context": "http://schema.org",
        "@type": "LocalBusiness",
        "address": {
            "@type": "PostalAddress",
            "addressLocality": "<?php echo $config['cidade_dsc']; ?>",
            "addressRegion": "<?php echo $config['estado_sigl']; ?>",
            "postalCode":"<?php echo $config['cep']; ?>",
            "streetAddress": "<?php echo $config['endereco']; ?>"
        },
                "description": "<?php if(!empty($seoDescription)){ echo $seoDescription; } else { echo $mostraSeo[0]['descricao']; } ?>",
                "name": "<?php if (!empty($seoTitle)){ echo $seoTitle; } else { echo $config['titulo']; } ?>",
        "email":"mailto:joaore1000@gmail.com",
        "telephone": "55<?php echo preg_replace('/[^0-9]/', '', $config['fone1']); ?>",
        "logo": "templates/img/logo-casa-itahy.png",
        "image": "templates/img/logo-casa-itahy.png",
        "url": "<?php echo $config['www']; ?>"
        }
    </script>

    <base href="https://<?php echo $base; ?>" />

    <title><?php
            if (!empty($seoTitle)){
                echo $seoTitle;
            } else {
                echo $config['titulo'];
            }
        ?>
    </title>

    <meta name="author" content="Desenvolvedor Web João Ré" />
    <meta name="reply-to" content="joaore1000@gmail.com">

    <link rel="canonical" href="http://<?php echo $base; ?><?php echo $pag; ?>" />

    <meta name="description" content="<?php
        if (!empty($seoDescription)){
            echo $seoDescription;
        } else {
            echo $mostraSeo[0]['descricao'];
        }
    ?>" />

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="br" />

    <link rel="stylesheet" href="templates/css/bootstrap.min.css" crossorigin="anonymous">
    <link href="templates/css/estilo.css?versao=1.01" rel="stylesheet" type="text/css" />

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.js"></script>

    <link rel="apple-touch-icon" sizes="57x57" href="templates/img/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="templates/img/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="templates/img/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="templates/img/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="templates/img/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="templates/img/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="templates/img/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="templates/img/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="templates/img/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png"  href="templates/img/favicon.webp">
    <link rel="manifest" href="templates/img/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#FAA41A">
    <meta name="msapplication-TileImage" content="templates/img/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#FAA41A">

    <!--[if lte IE 8]>
        <script type="text/javascript">
            location.assign('templates/ie/aviso.html');
        </script>
    <![endif]-->
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <?php echo $config['scripts']; ?>

    <!-- Global site tag (gtag.js) - Google Ads: 310718011 -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=AW-310718011"></script>
		<script>
		  window.dataLayer = window.dataLayer || [];
		  function gtag(){dataLayer.push(arguments);}
		  gtag('js', new Date());

		  gtag('config', 'AW-310718011');
		</script>

</head>
<body class="<?php echo $pag; echo ($pag != 'home') ? ' pagina-interna' : ''; ?>">
    <?php echo $config['scripts_body']; ?>
    <div class="fixed-top">
        <nav class="navbar w-100 align-items-center">
            <a class="navbar-brand" href="./" title="<?php echo $config['titulo'];?>">
                <img src="templates/img/logo-casa-itahy.svg" alt="<?php echo $config['titulo'];?>" title="<?php echo $config['titulo'];?>" class="loaded" />
            </a>
            <div class="right-menu">
                <button class="navbar-toggler">
                    <span class="navbar-toggler-name">menu</span>
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="redes-sociais-topo">
                    <?php if($config['rede1']) { ?>
                        <a href="<?php echo $config['rede1']; ?>" target="_blank"><i class="fab fa-facebook-f"></i></a>
                    <?php } ?>
                    <?php if($config['rede2']) { ?>
                        <a href="<?php echo $config['rede2']; ?>" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                    <?php } ?>
                    <?php if($config['rede3']) { ?>
                        <a href="<?php echo $config['rede3']; ?>" target="_blank"><i class="fab fa-instagram"></i></a>
                    <?php } ?>
                    <?php if($config['rede4']) { ?>
                        <a href="<?php echo $config['rede4']; ?>" target="_blank"><i class="fab fa-twitter"></i></a>
                    <?php } ?>
                    <?php if($config['rede5']) { ?>
                        <a href="<?php echo $config['rede5']; ?>" target="_blank"><i class="fab fa-youtube"></i></a>
                    <?php } ?>
                    <?php if($config['rede6']) { ?>
                        <a href="<?php echo $config['rede6']; ?>" target="_blank"><i class="fab fa-pinterest"></i></a>
                    <?php } ?>
                    <?php if (!empty($config['fone1'])): ?>
                        <a href="tel:<?php echo $config['fone1']; ?>" target="_blank"><i class="fas fa-phone"></i></a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="collapse navbar-collapse" id="menu-principal">
                <ul class="navbar-nav">
                    <li class="close-navbar"><i class="fas fa-times"></i></li>
                    <li class="nav-item">
                        <a href="<?php echo $config['www']; ?>" title="Home">Home</a>
                    </li>
                    <?php foreach ($menu as $m): ?>
                        <li class="nav-item">
                            <a href="<?php echo $m['lin_nome']; ?>" title="<?php echo $m['titulo'];?>"><?php echo $m['titulo']; ?></a>
                        </li>
                    <?php endforeach; ?>
                    <li class="espaco-menu"></li>
                    <li class="dados-menu">
                        <?php if (!empty($config['endereco'])): ?>
                            <p><i class="fas fa-map-marker-alt"></i> <?php echo nl2br($config['endereco']); ?></p>
                        <?php endif; ?>
                        <?php if (!empty($config['fone1'])): ?>
                            <a href="tel:<?php echo $config['fone1']; ?>" target="_blank"><i class="fas fa-phone"></i> <?php echo $config['fone1'] ?></a>
                        <?php endif; ?>
                        <a class="email-rodape" href="mailto:<?php echo $config['emailC']; ?>"><i class="fas fa-envelope"></i> <?php echo $config['emailC']; ?></a>
                    </li>
                    <li class="espaco-menu"></li>
                    <li class="redes-sociais-menu">
                        <h3>Siga-nos</h3>
                        <?php if($config['rede1']) { ?>
                            <a href="<?php echo $config['rede1']; ?>" target="_blank"><i class="fab fa-facebook-f"></i></a>
                        <?php } ?>
                        <?php if($config['rede2']) { ?>
                            <a href="<?php echo $config['rede2']; ?>" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                        <?php } ?>
                        <?php if($config['rede3']) { ?>
                            <a href="<?php echo $config['rede3']; ?>" target="_blank"><i class="fab fa-instagram"></i></a>
                        <?php } ?>
                        <?php if($config['rede4']) { ?>
                            <a href="<?php echo $config['rede4']; ?>" target="_blank"><i class="fab fa-twitter"></i></a>
                        <?php } ?>
                        <?php if($config['rede5']) { ?>
                            <a href="<?php echo $config['rede5']; ?>" target="_blank"><i class="fab fa-youtube"></i></a>
                        <?php } ?>
                        <?php if($config['rede6']) { ?>
                            <a href="<?php echo $config['rede6']; ?>" target="_blank"><i class="fab fa-pinterest"></i></a>
                        <?php } ?>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
    <?php include_once($include);
    

    ?>
    <?php if ($texto_rodape[0]['status'] == 1) { ?>
        <div class="bg-cinza">
            <div class="container anime">
                <div class="row align-items-center">
                    <div class="col-md-6 capa-contato">
                        <h2 class="texto-azul"><?php echo $texto_rodape[0]['titulo']; ?></h2>
                        <h2 class="telefone-contato texto-roxo">+55 <?php echo $config['fone1']; ?></h2>
                        <div class="clearfix"></div>
                        <a class="btn btn-outline-dark" href="<?php echo $linkContato; ?>">Fale Conosco</a>
                    </div>
                    <div class="col-md-6">
                        <?php if(!empty($texto_rodape[0]['imagem'])) { ?>
                            <img data-src="<?php echo IMAGENS.'paginas/'.$texto_rodape[0]['imagem']; ?>" alt="<?php echo $texto_rodape[0]['titulo']; ?>" title="<?php echo $texto_rodape[0]['titulo']; ?>" class="imagens-faixa-contato imagem-contato-right" />
                        <?php } ?>
                        <?php if(!empty($texto_rodape[0]['menu_img'])) { ?>
                            <img data-src="<?php echo IMAGENS.'paginas/imagem2/'.$texto_rodape[0]['menu_img']; ?>" alt="<?php echo $texto_rodape[0]['titulo']; ?>" title="<?php echo $texto_rodape[0]['titulo']; ?>" class="imagens-faixa-contato imagem-contato-left" />
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <footer>
        <div class="container anime">
            <div class="row">
                <div class="col-lg-3 footer-box-1 col-md-6">
                    <img class="logo-rodape" src="templates/img/logo-casa-itahy-rodape.svg" alt="<?php echo $config['titulo'] ?>" title="<?php echo $config['titulo'] ?>" />
                    <?php if ($texto_rodape[1]['status'] == 1) { ?>
                        <?php echo $texto_rodape[1]['conteudo']; ?>
                    <?php } ?>
                </div>
                <div class="col-lg-3 footer-menu col-md-6">
                    <h3 class="texto-laranja">Mapa do site</h3>
                    <ul class="menu-rodape">
                        <?php foreach ($menu as $m): ?>
                            <li>
                                <a href="<?php echo $m['lin_nome']; ?>" title="<?php echo $m['titulo'];?>"><?php echo $m['titulo']; ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="col-lg-3 footer-3 col-md-6">
                    <h3 class="texto-azul">Endereço</h3>
                    <?php if (!empty($config['endereco'])): ?>
                        <p class="endereco-rodape"><i class="fas fa-map-marker-alt"></i> <?php echo nl2br($config['endereco']); ?></p>
                    <?php endif; ?>
                    <div class="caixa-redes-sociais">
                        <?php if($config['rede1']) { ?>
                            <a href="<?php echo $config['rede1']; ?>" target="_blank"><i class="fab fa-facebook-f"></i></a>
                        <?php } ?>
                        <?php if($config['rede2']) { ?>
                            <a href="<?php echo $config['rede2']; ?>" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                        <?php } ?>
                        <?php if($config['rede3']) { ?>
                            <a href="<?php echo $config['rede3']; ?>" target="_blank"><i class="fab fa-instagram"></i></a>
                        <?php } ?>
                        <?php if($config['rede4']) { ?>
                            <a href="<?php echo $config['rede4']; ?>" target="_blank"><i class="fab fa-twitter"></i></a>
                        <?php } ?>
                        <?php if($config['rede5']) { ?>
                            <a href="<?php echo $config['rede5']; ?>" target="_blank"><i class="fab fa-youtube"></i></a>
                        <?php } ?>
                        <?php if($config['rede6']) { ?>
                            <a href="<?php echo $config['rede6']; ?>" target="_blank"><i class="fab fa-pinterest"></i></a>
                        <?php } ?>
                    </div>
                </div>
                <div class="col-lg-3 dados-contato col-md-6">
                    <h3 class="texto-roxo">Contato</h3>
                    <?php if (!empty($config['fone1'])): ?>
                        <a href="tel:<?php echo $config['fone1']; ?>" target="_blank" class="telefone-rodape"><i class="fas fa-phone"></i> <?php echo $config['fone1'] ?></a>
                    <?php endif; ?>
                    <a class="email-rodape" href="mailto:<?php echo $config['emailC']; ?>"><i class="fas fa-envelope"></i> <?php echo $config['emailC']; ?></a>
                </div>
            </div>
        </div>
    </footer>
    <div class="rodape-baixo text-center">
        <div class="container">
            <p><?php echo $config['rodape']; ?></p>
            <!-- <a class="maya" rel="external" href="https://www.linkedin.com/in/joao-re/" title="Criação de Sites - João Ré Desenvolvedor" target="_blank">Criação de Sites - João Ré Desenvolvedor</a> -->
        </div>
    </div>

    <?php if (!empty($linkWhatsapp)): ?>
        <a href="<?php echo $linkWhatsapp; ?>" target="_blank" class="whats-fixo"><i class="fab fa-whatsapp"></i> Conversar via Whatsapp</a>
    <?php endif; ?>

    <script language="JavaScript" type="text/javascript" src="js/plugins/mascara.js"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
    <script src="js/bootstrap.min.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="templates/css/plugins/owl.carousel.css">
    <script src="js/plugins/owl.carousel.min.js" language="JavaScript" type="text/javascript"></script>
    <script src="js/plugins/jquery-ui.min.js" language="JavaScript" type="text/javascript"></script>

    <script type="text/javascript" src="js/plugins/jquery.themepunch.plugins.min.js"></script>
    <script type="text/javascript" src="js/plugins/jquery.themepunch.revolution.min.js"></script>
    <link rel="stylesheet" type="text/css" href="templates/css/plugins/settings.css" media="screen" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.1.20/jquery.fancybox.min.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.1.20/jquery.fancybox.min.js"></script>

    <script language="JavaScript" type="text/javascript" src="js/app.js"></script>
    <script language="JavaScript" type="text/javascript" src="js/plugins/lazyload.min.js"></script>
    <script>
        (function () {
            var ll = new LazyLoad({
                threshold: 0
            });
        }());
    </script>

    <?php if(!empty($_GET['msg']) AND $_GET['msg'] = 'Sua mensagem foi encaminhada com sucesso!') { ?>
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body text-center pt-5">
                        <img src="templates/img/logo-casa-itahy.png" alt="<?php echo $config['titulo']; ?>" title="<?php echo $config['titulo']; ?>" class="loaded mb-3" />
                        <p><strong><?php echo $_GET['msg']; ?></strong></p>
                        <!-- Event snippet for Website traffic conversion page -->
						<script>
						  gtag('event', 'conversion', {'send_to': 'AW-310718011/UO7WCL_YgfACELvclJQB'});
						</script>

                    </div>
                    <div class="modal-footer text-center justify-content-center">
                        <button type="button" class="btn btn-primary mb-3" data-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript">
            $(document).ready(function(){
                $('#myModal').modal('show')
            });
        </script>
    <?php } ?>
    <?php if (!empty($pag_id) AND $pag_id == '2') { ?>
        <script type="text/javascript">
            $(window).load(function(){
                // Remove the # from the hash, as different browsers may or may not include it
                var hash = location.hash.replace('#','');
                if(hash != ''){
                    $('html, body').animate({ scrollTop: $('#'+hash).offset().top - 140}, 1000);
                }
            });
       </script>
    <?php } ?>
</body>
</html>