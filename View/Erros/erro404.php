<?php
    $link = $this->urlRoot();
    if( !empty($_SERVER['HTTP_REFERER'])):
        $link = $_SERVER['HTTP_REFERER'];
    endif;
?>
<div class="error-head"> </div>

<div class="container ">

  <section class="error-wrapper text-center">
      <h1 class="block">
          <img src="<?= $this->urlRoot()?>View/webroot/images/404.png" alt="">
      </h1>
      <div style="margin-top: 50px;">
          <h2>Página não encontrada!</h2>
          <p class="nrml-txt">esta página não existe, favor voltar ao sistema!</p>
      </div>
      <a href="<?= $link?>" class="btn btn-success"><i class="fa fa-home"></i> Voltar</a>
  </section>

</div>
