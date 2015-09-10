<!DOCTYPE html>
<html dir="ltr" lang="en-US"><head>
    <meta charset="utf-8">
    <title>Jopacs - <?= $title_layout?></title>
    <meta name="viewport" content="initial-scale = 1.0, maximum-scale = 1.0, user-scalable = no, width = device-width">

    <!-- <link rel="stylesheet" href="<?php //echo $this->urlRoot();?>View/webroot/css/client/style.css" media="screen">
    <link rel="stylesheet" href="<?php //echo $this->urlRoot();?>View/webroot/css/client/style.ie7.css" media="screen" />
    <link rel="stylesheet" href="<?php //echo $this->urlRoot();?>View/webroot/css/client/style.responsive.css" media="all">
    <link rel="stylesheet" href="<?php //echo $this->urlRoot();?>View/webroot/css/client/slides.css" media="screen">-->
    <link rel="stylesheet" href="<?php echo $this->urlRoot();?>View/webroot/css/bootstrap.css" media="screen">
    
    <script src="<?= $this->urlRoot(); ?>View/webroot/js/jquery.js" type="text/javascript"></script>
    <script src="<?= $this->urlRoot(); ?>View/webroot/js/ajaxForm.js" type="text/javascript"></script>
    <script src="<?= $this->urlRoot(); ?>View/webroot/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="<?= $this->urlRoot(); ?>View/webroot/js/funcoes.js" type="text/javascript"></script>
    <script src="<?= $this->urlRoot(); ?>View/webroot/js/jquery.mask.js" type="text/javascript"></script>
    <script src="<?= $this->urlRoot(); ?>View/webroot/js/jquery.mask.min.js" type="text/javascript"></script>

</head>
<body>
<div class="container">
    <div class="col-md-3">
        <img src="<?php echo $this->urlRoot();?>View/webroot/images/logo.png">
    </div>

    <div class="col-md-3 col-md-offset-2" style="padding-top:50px;">
        <img src="<?php echo $this->urlRoot();?>View/webroot/images/object1007760164.png">
    </div>

</div>
    <nav class="bg-menu">
        <div class="container">
            <ul class="">
                <li><a href="<?= $this->urlRoot()?>Pages/" class="active">Início</a></li>
                <li class="ul-links" ><a href="#">Vacinas</a>
                    <ul class="ul-content" style="display: none">
                        <li><a href="<?= $this->urlRoot()?>Pages/informacoes">Informações</a></li>
                        <li><a href="<?= $this->urlRoot()?>Pages/curiosidades">Curiosidades</a></li>
                        <li><a href="<?= $this->urlRoot()?>Pages/duvidas">Dúvidas</a></li>
                    </ul>
                </li>
                <li><a href="<?= $this->urlRoot()?>Pages/noticias">Noticias</a></li>
                <li><a href="<?= $this->urlRoot()?>Pages/cadastro">Cadastro</a></li>
                <li><a href="<?= $this->urlRoot()?>Pages/login">Login</a></li>
                <li><a href="<?= $this->urlRoot()?>Pages/contato">Contato</a></li>
            </ul> 
        </div>
    </nav>
    
    <!-- conteudo -->
    
    <div class="clearfix"></div>
        <div class="estilo-sheet" style="margin:auto; margin-top:10px;">
            <?= $this->showView(); ?>
        </div>
    <!-- conteudo -->
    
    <div class="clearfix"></div>
    <footer class="estilo-footer">
      <div class="estilo-footer-inner">
            <p><span style="font-weight: bold;">Copyright © 2014 Jopacs Controle de Vacinação. Todos os direitos reservados.</span></p>
      </div>
    </footer>
</div>
</body>
</html>