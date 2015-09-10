<div class="row">
    <div class="col-md-12">
        <ul class="breadcrumbs-alt">
            <li>
                <a href="<?= $this->urlRoot()?>Usuarios/painel"> <i class="fa fa-home"></i> Home</a>
            </li>
            <li>
                <a class="current" href="<?= Router::url();?>Emails/index">E-mails</a>
            </li>
            <li>
                <a class="active-trail active" href="<?= Router::url() . 'Emails/cadastro'?>">Cadastro</a>
            </li>
        </ul>
    </div>
</div>

<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">Modelos de e-mail do sistema</h3>
    </div>
    <div class="panel-body">
        
        <a class="btn btn-primary" href="<?= Router::url() . 'Emails/cadastro'?>">Cadastrar <i class="fa fa-plus"></i></a><br><br>
            <div class="clearfix"></div>
        <?php foreach ($obejct as $registro) :?>
            <div class="row">
                <div class="panel col-md-6">
                    <div class="panel-heading">
                        <div class="panel-title">tag: <?= $registro->getTag();?></div>
                    </div>
                    <div class="panel-body">
                        <?=   $registro->getCorpoEmail() ;?>
                    </div>
                    <div class="panel-footer">
                        <div class="btn-group btn-group-xs">
                            <a href="<?= Router::url().'Emails/editar/' . $registro->getId()?>" class="btn btn-primary">Editar</a>
                            <a data-url="<?= Router::url().'Emails/deletar'. $registro->getId()?>" class="btn btn-danger action-deleta">Excluir</a>
                        </div>
                    </div>
                    
                    <hr>
                    
                </div>
            </div>            
        <?php endforeach;?>
        
    </div>
    <div class="panel-footer"></div>
    
</div>