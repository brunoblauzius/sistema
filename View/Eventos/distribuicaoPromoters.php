
<div class="panel">
    <header class="bg-header-primary panel-heading">
       Distruibuição para Promoters : <?= Session::read('Empresa.nome_fantasia')?>
    </header>
    <div class="panel panel-body">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-2">
                    <?php foreach ( $funcionarios as $funcionario):?>
                        <a class="btn btn-success btn-xs carregar-lista-funcionario" data-pessoasid="<?= ($funcionario['pessoas_id'])?>" data-eventosid="<?= ($registro['id'])?>" style="margin-bottom:5px;"><?= ucwords($funcionario['nome'])?></a>
                    <?php endforeach;?>
                </div>
                <div class="col-md-10" id="carregar-lista">
                    <div class="alert alert-info">
                        <i class="fa fa-arrow-left"></i>Selecione um Promoter.
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>