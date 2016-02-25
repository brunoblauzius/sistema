   
    <section class="m-b-md">
        <h3 class="m-b-none">Clientes do estabelecimento</h3>
    </section>

    <div class="col-md-8">

        <div class="panel panel-default">
            <header class="panel-heading">
               Clientes : <?= Session::read('Empresa.nome_fantasia')?>
            </header>
            <div class="panel panel-body">

                    <div class="clearfix"></div>

                    <table class="table table-condensed table-hover table-responsive table-striped" id="dynamic-table">
                        <thead>
                            <th>NOME</th>
                            <th>E-MAIL</th>
                            <th>TELEFONE</th>
                            <th class="text-center col-md-2">ATIVO</th>
                            <th style="width: 6%"></th>
                        </thead>
                        <tbody>
                            <?php
                                if( empty($registros) ):
                                        echo "<tr>
                                                <th colspan='6'>Não contém registros</th>
                                            </tr>";
                                endif;
                                foreach ($registros as $registro):
                            ?>
                            <tr>
                                <td><?= $registro['nome']?></td>
                                <td><?= $registro['email']?></td>                                
                                <td><?= $registro['telefone']?></td>                                
                                <td class="text-center">
                                    <?php if($registro['status'] ):?>
                                        <a class="btn btn-success btn-xs tooltips ativar-status" data-id="<?= md5($registro['id'])?>" data-status="0" data-url="<?= Router::url(array('Clientes', 'alterarStatus'))?>" data-original-title="Desativar Registro" type="button" data-toggle="tooltip" data-placement="top" title="" ><i class="fa fa-check-circle"></i></a>
                                    <?php else:?>
                                        <a class="btn btn-danger btn-xs tooltips ativar-status" data-id="<?= md5($registro['id'])?>" data-status="1" data-url="<?= Router::url(array('Clientes', 'alterarStatus'))?>"  data-original-title="Ativar Registro" type="button" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-times-circle"></i></a>
                                    <?php endif;?>
                                </td>
                                <td>
                                    <button class="btn btn-xs btn-info tooltips edit-action  " data-id="<?= $registro['id']?>" data-url="<?= Router::url(array('Clientes', 'editar'))?>"  data-original-title="Editar" type="button" data-toggle="tooltip" data-placement="top" ><i class="fa fa-pencil"></i></button>
                                </td>
                            </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>

            </div>
        </div>      
    </div>

    <div class="col-md-4">
        <section class="panel">
            <header class="panel-heading">
                Formulário Clientes
            </header>
            <div class="panel-body ">
                <div class="painel-edit"></div>
                <div class="painel-cadastro">
                    <form method="post" action="<?= Router::url(array('Clientes', 'add'))?>" id="ClienteAddForm">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <small>Nome: <strong class="text text-danger">*</strong></small>
                                <input type="text" name="Cliente[nome]" class="form-control rounded" placeholder="Nome:">
                            </div>
                            <div class="form-group col-md-12">
                                <small>E-mail: <strong class="text text-danger"></strong></small>
                                <input type="text" name="Cliente[email]" class="form-control rounded" placeholder="E-mail:">
                            </div>
                            <div class="form-group col-md-12">
                                <small>RG: <strong class="text text-danger"></strong></small>
                                <input type="text" name="Cliente[rg]" class="form-control rounded" placeholder="RG:">
                            </div>
                            <div class="form-group col-md-12">
                                <small>Telefone: <strong class="text text-danger">*</strong></small>
                                <input type="text" name="Cliente[telefone]" class="form-control rounded telefone" placeholder="Telefone:" value="<?= substr($_SESSION['Contato'][0]['telefone'], 0,2)?>">
                            </div>
                            <div class="form-group col-md-12">
                                <small>Data Nascimento: <strong class="text text-danger"></strong></small>
                                <input type="text" name="Cliente[dt_nascimento]" class="form-control rounded date2" placeholder="Data Nascimento:">
                            </div>
                            <div class="form-group col-md-12">
                                <small>Sexo: <strong class="text text-danger">*</strong></small>
                                <select type="text" name="Cliente[sexo]" class="form-control rounded">
                                    <option value="1"> MASCULINO </option>
                                    <option value="0"> FEMININO </option>
                                </select>
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
 