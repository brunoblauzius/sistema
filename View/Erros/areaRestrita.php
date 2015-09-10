<style>
    .block{
        color: #1FB5AD;
        font-size: 40px;
    }
</style>


<div class="error-head"> </div>

<div class="container ">

  <section class="error-wrapper text-center">
      <h1 class="block">
          <i class="fa fa-thumbs-down"></i> ÁREA RESTRITA!
          <!--<img src="<?//= $this->urlRoot()?>View/webroot/images/404.png" alt="">-->
      </h1>
      <div style="margin-top: 50px;">
          <h2>Você não tem acesso a esta área.</h2>
          <p class="nrml-txt">Por favor logar-se ou adquira sua licença para utilizar o sistema.</p>
      </div>
      <a href="<?= Router::url(array('Pages', 'login'))?>" class="btn btn-success"><i class="fa fa-home"></i> Voltar a página login</a>
  </section>

</div>
