   
    <section class="m-b-md">
        <h3 class="m-b-none">Situações de contas do sistema</h3>
    </section>

    <div class="col-md-8">

        <div class="panel panel-default">
            <header class="panel-heading">
               Situações de contas
            </header>
            <div class="panel panel-body">

                    <div class="clearfix"></div>

                    <table class="table table-condensed table-hover table-responsive table-striped" id="dynamic-table">
                        <thead>
                            <th>NOME</th>
                            <th class="text-center col-md-2">ATIVO</th>
                            <th style="width: 6%"></th>
                        </thead>
                        <tbody>
                            <?php
                                if( !empty($registros) ):
                                foreach ($registros as $registro):
                            ?>
                            <tr>
                                <td><?= $registro['SituacaoConta']['nome']?></td>                               
                                <td class="text-center">
                                    <?php if($registro['SituacaoConta']['status'] ):?>
                                        <a class="btn btn-success btn-xs tooltips ativar-status" data-id="<?= md5($registro['SituacaoConta']['id'])?>" data-status="0" data-url="<?= Router::url(array('Clientes', 'alterarStatus'))?>" data-original-title="Desativar Registro" type="button" data-toggle="tooltip" data-placement="top" title="" ><i class="fa fa-check-circle"></i></a>
                                    <?php else:?>
                                        <a class="btn btn-danger btn-xs tooltips ativar-status" data-id="<?= md5($registro['SituacaoConta']['id'])?>" data-status="1" data-url="<?= Router::url(array('Clientes', 'alterarStatus'))?>"  data-original-title="Ativar Registro" type="button" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-times-circle"></i></a>
                                    <?php endif;?>
                                </td>
                                <td>
                                    <button class="btn btn-xs btn-info tooltips edit-action  " data-id="<?= $registro['SituacaoConta']['id']?>" data-url="<?= Router::url(array('Parametros', 'editarSituacaoContas'))?>"  data-original-title="Editar" type="button" data-toggle="tooltip" data-placement="top" ><i class="fa fa-pencil"></i></button>
                                </td>
                            </tr>
                            <?php
                                endforeach;
                                endif;
                            ?>
                        </tbody>
                    </table>

            </div>
        </div>      
    </div>

    <div class="col-md-4">
        <section class="panel">
            <header class="panel-heading">
                Formulário Situação de Conta
            </header>
            <div class="panel-body ">
                <div class="painel-edit"></div>
                <div class="painel-cadastro">
                    <form method="post" action="<?= Router::url(array('Parametros', 'addSituacaoContas'))?>" id="SituacaoContaAddForm">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <small>Nome: <strong class="text text-danger">*</strong></small>
                                <input type="text" name="SituacaoConta[nome]" class="form-control rounded" placeholder="Nome:">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <button class="btn btn-s-md btn-primary btn-rounded btn-block">Cadastrar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        
    </div>
 