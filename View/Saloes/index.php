   
    <section class="m-b-md">
        <h3 class="m-b-none">Salões do estabelecimento</h3>
    </section>

    <div class="col-md-8">

        <div class="panel panel-default">
            <header class="panel-heading">
               Salões : <?= Session::read('Empresa.nome_fantasia')?>
            </header>
            <div class="panel panel-body">

                    <div class="clearfix"></div>

                    <table class="table table-condensed table-hover table-responsive table-striped" id="dynamic-table">
                        <thead>
                            <th class="col-md-1">#</th>
                            <th>NOME</th>
                            <th class="text-center col-md-2">ATIVO</th>
                            <th style="width: 6%"></th>
                        </thead>
                        <tbody>
                            <?php
                                if( !empty($saloes) ):
                                    foreach ($saloes as $salao):
                            ?>
                            <tr>
                                <td><?= $salao['Salao']['id']?></td>
                                <td><?= $salao['Salao']['nome']?></td>                                
                                <td class="text-center">
                                    <?php if($salao['Salao']['status'] ):?>
                                        <a class="btn btn-success btn-xs tooltips ativar-status" data-id="<?= md5($salao['Salao']['id'])?>" data-status="0" data-url="<?= Router::url(array('Saloes', 'alterarStatus'))?>" data-original-title="Desativar Registro" type="button" data-toggle="tooltip" data-placement="top" title="" ><i class="fa fa-check-circle"></i></a>
                                    <?php else:?>
                                        <a class="btn btn-danger btn-xs tooltips ativar-status" data-id="<?= md5($salao['Salao']['id'])?>" data-status="1" data-url="<?= Router::url(array('Saloes', 'alterarStatus'))?>"  data-original-title="Ativar Registro" type="button" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-times-circle"></i></a>
                                    <?php endif;?>
                                </td>
                                <td>
                                    <button class="btn btn-xs btn-info tooltips edit-action  " data-id="<?= $salao['Salao']['id']?>" data-url="<?= Router::url(array('Saloes', 'editar'))?>"  data-original-title="Editar" type="button" data-toggle="tooltip" data-placement="top" ><i class="fa fa-pencil"></i></button>
                                    
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
                Formulário Salões
            </header>
            <div class="panel-body ">
                <div class="painel-edit"></div>
                <div class="painel-cadastro">
                    <form method="post" action="<?= Router::url(array('Saloes', 'add'))?>" id="SalaoAddForm">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <small>Nome: <strong class="text text-danger">*</strong></small>
                                <input type="text" name="Salao[nome]" class="form-control rounded" placeholder="Descrição:">
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
    
