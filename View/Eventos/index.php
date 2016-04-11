<div class="row">
    <div class="col-md-12 margin20">
       <a class="btn btn-default btn-xs pull-right" id="criar-novo-evento" data-url="<?= Router::url(array('Eventos', 'cadastro'));?>"><i class="fa fa-plus-circle marginNull"></i> Criar novo Evento</a>
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

            <table class="table table-condensed table-hover table-responsive table-striped" id="dynamic-table">
                <thead>
                    <th style="width: 30%">TITULO</th>
                    <th style="width: 10%">DATA</th>
                    <th style="width: 10%">LISTA VIP</th>
                    <th class="text-center" style="width: 6%">ATIVO</th>
                    <th style="width: 6%"></th>
                </thead>
                <tbody>
                   <tr>
                        <td>Evento 1</td>
                        <td>19/07/1999</td>                                
                        <td>
                            <span style="cursor: pointer">
                                700 clientes - <i class="fa fa-user marginNull"></i>
                            </span>
                        </td>                                
                        <td class="text-center">
                            <a class="btn btn-success btn-xs tooltips " data-id="" data-status="0" data-url="<?= Router::url(array('Clientes', 'alterarStatus'))?>" data-original-title="Desativar Registro" type="button" data-toggle="tooltip" data-placement="top" title="" ><i class="fa fa-check-circle marginNull"></i></a>
                            <a class="btn btn-danger btn-xs tooltips " data-id="" data-status="1" data-url="<?= Router::url(array('Clientes', 'alterarStatus'))?>"  data-original-title="Ativar Registro" type="button" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-times-circle marginNull"></i></a>
                        </td>
                        <td>
                            <button class="btn btn-xs btn-info tooltips " data-id="" data-url="<?= Router::url(array('Clientes', 'editar'))?>"  data-original-title="Editar" type="button" data-toggle="tooltip" data-placement="top" ><i class="fa fa-pencil marginNull"></i></button>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>Evento 2</td>
                        <td>20/07/1999</td>                                
                        <td>
                            <span style="cursor: pointer">
                                1000 clientes - <i class="fa fa-user marginNull"></i>
                            </span>
                        </td>                                
                        <td class="text-center">
                            <a class="btn btn-success btn-xs tooltips " data-id="" data-status="0" data-url="<?= Router::url(array('Clientes', 'alterarStatus'))?>" data-original-title="Desativar Registro" type="button" data-toggle="tooltip" data-placement="top" title="" ><i class="fa fa-check-circle marginNull"></i></a>
                            <a class="btn btn-danger btn-xs tooltips " data-id="" data-status="1" data-url="<?= Router::url(array('Clientes', 'alterarStatus'))?>"  data-original-title="Ativar Registro" type="button" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-times-circle marginNull"></i></a>
                        </td>
                        <td>
                            <button class="btn btn-xs btn-info tooltips " data-id="" data-url="<?= Router::url(array('Clientes', 'editar'))?>"  data-original-title="Editar" type="button" data-toggle="tooltip" data-placement="top" ><i class="fa fa-pencil marginNull"></i></button>
                        </td>
                    </tr>
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