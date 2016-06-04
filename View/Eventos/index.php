<div class="row">
    <div class="col-md-12 margin20">
        <div class="col-md-4 pull-right">
            <a class="btn btn-primary" id="criar-novo-evento" data-url="<?= Router::url(array('Eventos', 'cadastro'));?>"><i class="fa fa-plus-circle marginNull"></i> Criar novo Evento</a>
            <a class="btn btn-primary pull-right" href="<?= Router::url(array('Listas', 'index'));?>"><i class="fa fa-plus-circle marginNull"></i> Listas</a>
        </div>
    </div>
</div>
<div class="panel panel-body" >
    <div id="graph-area" style="height: 200px;"></div>
</div>

<div class="panel">
    <header class="bg-header-primary panel-heading">
       Eventos : <?= Session::read('Empresa.nome_fantasia')?>
    </header>
    <div class="panel panel-body">
            <div class="clearfix"></div>

            <table class="table table-condensed table-hover table-responsive table-striped" id="data-table-eventos">
                <thead>
                    <th style="width: 30%">TITULO</th>
                    <th style="width: 10%">DATA</th>
                    <th style="width: 10%">LISTA VIP</th>
                    <th class="text-center" style="width: 6%">ATIVO</th>
                    <th style="width: 6%"></th>
                </thead>
                <tbody>
                    <?php foreach ($registros as $registro):?>
                   <tr>
                        <td><?= $registro['title']?></td>
                        <td><?= Utils::getDate($registro['data']);?></td>                                
                        <td>
                            <span style="cursor: pointer">
                                700 clientes - <i class="fa fa-user marginNull"></i>
                            </span>
                        </td>                                
                        <td class="text-center">
                            <?php if($registro['status'] == 1 ):?>
                                <a class="btn btn-success btn-xs tooltips alterar-status-lista" data-url="<?= Router::url(array('Eventos', 'alterarStatus',  md5($registro['id'])))?>" data-original-title="Desativar Registro" type="button" data-toggle="tooltip" data-placement="top" title="" ><i class="fa fa-check-circle marginNull"></i></a>
                            <?php else:?>
                                <a class="btn btn-danger btn-xs tooltips alterar-status-lista" data-url="<?= Router::url(array('Eventos', 'alterarStatus',  md5($registro['id'])))?>"  data-original-title="Ativar Registro" type="button" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-times-circle marginNull"></i></a>
                            <?php endif;?>
                        </td>
                        <td>
                            <a class="btn btn-xs btn-info tooltips" href="<?= Router::url(array('Eventos', 'editar',  md5($registro['id'])))?>"  data-original-title="Editar" type="button" data-toggle="tooltip" data-placement="top" title="Editar" ><i class="fa fa-pencil marginNull"></i></a>
                            <a class="btn btn-xs btn-warning tooltips" href="<?= Router::url(array('Eventos', 'distribuicao-promoters',  md5($registro['id'])))?>"  data-original-title="Editar" type="button" data-toggle="tooltip" data-placement="top" title="Distribuição para Promoters" ><i class="fa fa-sitemap marginNull"></i></a>
                        </td>
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>

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