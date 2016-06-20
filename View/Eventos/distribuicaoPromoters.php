
<h2><?= Utils::getDate($registro['data'])?> - <?= $registro['title']?> <small>: Distribuição para Promoters</small></h2>


<div class="panel">
    <header class="bg-header-primary panel-heading">
        Defina a quantidade para cada promoter
    </header>
    <div class="panel panel-body">
        <div class="row">
            <div class="col-md-12" style="margin-bottom: 10px;">
                <div class="dropdown pull-left">
                    <a class="btn btn-default btn-sm dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        Copiar a distribuição do <strong>evento</strong>
                        <span class="fa fa-bars"></span>
                    </a>
                    
                    <?php if(count($eventos) >= 1 ):?>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                          <?php foreach ($eventos as $evento):?>
                                <?php if( $registro['id'] != $evento['id']):?>
                                    <li><a href="#" class="copiar-distribuicao-eventos" data-eventosidcopy="<?= $evento['id']?>" data-eventosid="<?= $registro['id']?>"><?= ucfirst($evento['title']);?></a></li>
                                <?php endif;?>
                          <?php endforeach;?>
                        </ul>
                    <?php endif;?>
                    
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-2 pddnull marginNull">
                    <?php foreach ( $funcionarios as $funcionario):?>
                        <a class="btn btn-success btn-xs btn-block carregar-lista-funcionario" data-pessoasid="<?= ($funcionario['pessoas_id'])?>" data-eventosid="<?= ($registro['id'])?>" style="margin-bottom:5px;"><?= ucwords($funcionario['nome'])?></a>
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