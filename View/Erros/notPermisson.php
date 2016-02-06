<section class="panel">
    <div class="panel panel-body">
        <h2 class="text text-danger text-center"><?= $mensagem?></h2>
        
        <div class="clearfix"></div>
        <div class="col-md-12 text-center">
            <a href="<?= Router::url(array('MinhaConta', 'index'))?>" class="btn btn-primary btn-lg">Continuar Utilizando o Sistema</a>
        </div>
    </div>
</section>