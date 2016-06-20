<div class="row">
    <div class="col-md-12 margin20">
        <div class="col-md-4 pull-right">
            <a class="btn btn-primary" id="criar-novo-evento" data-url="<?= Router::url(array('Eventos', 'cadastro'));?>"><i class="fa fa-plus-circle marginNull"></i> Criar novo Evento</a>
            <a class="btn btn-primary pull-right" href="<?= Router::url(array('Listas', 'index'));?>"><i class="fa fa-plus-circle marginNull"></i> Listas</a>
        </div>
    </div>
</div>

<div class="panel panel-body" >
    <div class="chartJS">
        <canvas id="bar-chart-js" height="250" width="900" ></canvas>
    </div>
</div>

<div class="panel">
    <header class="bg-header-primary panel-heading">
       Eventos : <?= Session::read('Empresa.nome_fantasia')?>
    </header>
    <div class="panel panel-body">
        
            <div class="clearfix"></div>
            <?php foreach ($registros as $registro):?>
                <div class="col-md-3 col-sm-3 col-xs-12 text-center">
                    <h4><?= Utils::getDate($registro['data'])?></h4>
                    <h5 class="marginNull pddnull"><?= $registro['title']?></h5>
                    
                    <p class="btn btn-group-xs btn-group-sm btn-group">
                        <?php if($registro['status'] == 1 ):?>
                            <a class="btn btn-success btn-xs tooltips alterar-status-lista" data-url="<?= Router::url(array('Eventos', 'alterarStatus',  md5($registro['id'])))?>" data-original-title="Desativar Registro" type="button" data-toggle="tooltip" data-placement="top" title="" ><i class="fa fa-check-circle marginNull"></i></a>
                        <?php else:?>
                            <a class="btn btn-danger btn-xs tooltips alterar-status-lista" data-url="<?= Router::url(array('Eventos', 'alterarStatus',  md5($registro['id'])))?>"  data-original-title="Ativar Registro" type="button" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-times-circle marginNull"></i></a>
                        <?php endif;?>
                        <a class="btn btn-xs btn-info tooltips" href="<?= Router::url(array('Eventos', 'editar',  md5($registro['id'])))?>"  data-original-title="Editar" type="button" data-toggle="tooltip" data-placement="top" title="Editar" ><i class="fa fa-pencil marginNull"></i></a>
                        <a class="btn btn-xs btn-warning tooltips" href="<?= Router::url(array('Eventos', 'distribuicao-promoters',  md5($registro['id'])))?>"  data-original-title="Distribuição para Promoters" type="button" data-toggle="tooltip" data-placement="top" title="Distribuição para Promoters" ><i class="fa fa-sitemap marginNull"></i></a>
                        <a class="btn btn-xs btn-primary tooltips" href="<?= Router::url(array('Eventos', 'portaria',  md5($registro['id'])))?>"  data-original-title="Portaria" type="button" data-toggle="tooltip" data-placement="top" title="Portaria" ><i class="fa fa-sign-in marginNull"></i></a>
                        <a class="btn btn-xs btn-primary tooltips" href="<?= Router::url(array('Eventos', 'relatorio',  md5($registro['id'])))?>"  data-original-title="Relatórios" type="button" data-toggle="tooltip" data-placement="top" title="Relatórios" ><i class="fa fa-bar-chart-o marginNull"></i></a>
                        <a class="btn btn-xs btn-warning tooltips" href="<?= Router::url(array('Eventos', 'minha-lista',  md5($registro['id'])))?>"  data-original-title="Adicionar Lista Vip" type="button" data-toggle="tooltip" data-placement="top" title="Minha Lista Vip" ><i class="fa fa-bars marginNull"></i></a>
                    </p>
                </div>
            <?php endforeach;?>
    </div>
</div>


<!-- Modal -->
<div class="modal fade bs-example-modal-lg" id="ModalFormulario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-header-primary">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Eventos</h4>
            </div>
            <div class="modal-body append-body" id="append-body"> </div>  
        </div>
    </div>
</div>