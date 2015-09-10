<!DOCTYPE html>
<html dir="ltr" lang="en-US"><head>
    <meta charset="utf-8">
    <title>Jopacs - <?= $title_layout?></title>
    <meta name="viewport" content="initial-scale = 1.0, maximum-scale = 1.0, user-scalable = no, width = device-width">

    <link rel="stylesheet" href="<?php echo $this->urlRoot();?>View/webroot/css/bootstrap.css" media="screen">


    <script src="<?= $this->urlRoot(); ?>View/webroot/js/jquery.js" type="text/javascript"></script>
    <script src="<?= $this->urlRoot(); ?>View/webroot/js/ajaxForm.js" type="text/javascript"></script>
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
                <li><a href="<?= $this->urlRoot()?>Usuarios/painelAdmin">Home</a></li>
                <li><a href="<?= $this->urlRoot()?>Usuarios/mudarDados">Meus dados</a></li>
                <li><a href="<?= $this->urlRoot()?>Usuarios/minhasVacinas">Vacinas</a></li>
                <li><a href="<?= $this->urlRoot()?>Usuarios/logout">Logout</a></li>
            </ul> 
        </div>
    </nav>
    
    <!-- conteudo -->
    
    <div class="clearfix"></div>
        <div class="estilo-sheet container">
            <?= $this->showView(); ?>
        </div>
    <!-- conteudo -->

    <footer class="estilo-footer clearfix">
      <div class="estilo-footer-inner">
            <p><span style="font-weight: bold;">Copyright © 2014 Jopacs Controle de Vacinação. Todos os direitos reservados.</span></p>
      </div>
    </footer>
</div>
</body>
</html>