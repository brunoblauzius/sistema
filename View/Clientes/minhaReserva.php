<div class="container">
    <div class="row">
        <section class="panel">
            <header class="panel-heading">
                dados da reserva
              <!--span class="tools pull-right">
                  <a href="javascript:;" class="fa fa-chevron-down"></a>
               </span-->
            </header>
            <div class="panel-body">
                
                <div class="alert alert-success">
                    <h4>
                        Sua reserva foi confirmada com sucesso! 
                    </h4>
                </div>
                
                    <div class="col-sm-2">
                        <?php if ( !empty($empresa['logo']) && ($empresa['logo'] != NULL )): ?>
                            <img src="<?= Router::url(array('View/webroot/img/logos', $empresa['logo'])) ?>" class="" style="width:130px; "/>
                        <?php else: ?>
                            <img src="<?= Router::url(array('View/webroot/img/no-image.jpg')) ?>" class="img-thumbnail" style="width:80px; "/>
                        <?php endif; ?>
                    </div>
                    <div class="col-sm-10">
                        <table class="table table-condensed table-striped">
                            <tbody>
                            <tr>
                                <td style="width:15%"><strong>Data Reserva:</strong></td>
                                <td style="width:35%"><?= Utils::convertData($reserva['Reserva']['start'])?></td>
                                <td style="width:20%"><strong>Quantidade de Pessoas:</strong></td>
                                <td style="width:30%"><?= ($reserva['Reserva']['qtde_pessoas'])?></td>
                            </tr>
                            <tr>
                                <td><strong>Cliente Reserva:</strong></td>
                                <td><?= $cliente['Cliente']['nome']?></td>
                                <td><strong>Salão - Ambiente:</strong></td>
                                <td><?= $dadoEmailReserva[0]['salao']?> - <?= $dadoEmailReserva[0]['ambiente']?></td>
                            </tr>
                            <tr>
                                <td><strong>Mesas:</strong></td>
                                <td><?= $mesas?></td>
                                <td><strong>Código da Reserva:</strong></td>
                                <th class="text text-info"><?= ($reserva['Reserva']['token'])?></th>
                            </tr>
                            </tbody>
                        </table>

                        <div class="clearfix"></div>
                        <hr>
                        <table class="table table-condensed table-striped">
                            <tbody>
                            <tr>
                                <td style="width:15%"><strong>Empresa:</strong></td>
                                <td style="width:35%" colspan="4"><?= $empresa['nome_fantasia']?></td>
                                <td style="width:20%"><strong>Reserva para:</strong></td>
                                <td style="width:30%"><?= ($reserva['Reserva']['qtde_pessoas'])?> Pessoas</td>
                            </tr>
                            <tr>
                                <td><strong>Endereço:</strong></td>
                                <td colspan="5"><?= $enderecoEmpresa?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="clearfix"></div>
            </div>
        </section>
</div>
    
    <div class="row">
        <div class="col-sm-8 col-md-8">
            <section class="panel">
                <header class="panel-heading">
                    Lista de convidados
                </header>
                <div class="panel-body ">
                    <div class="painel-edit"></div>
                    <div class="painel-cadastro">
                        <table class="table table-condensed table-striped"  >
                            <thead>
                                 <tr>
                                    <th><strong>Nome:</strong></th>
                                    <th><strong>E-mail:</strong></th>
                                    <th><strong>Telefone:</strong></th>
                                    <th style="width: 7%"></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($convidados as $registro):?>
                            <tr>
                                <td>
                                    <?= $registro['nome']?>
                                </td>
                                <td>
                                    <?= strtoupper($registro['email'])?>
                                </td>
                                <td>
                                    <?= Utils::formatarTelefone($registro['telefone'])?>
                                </td>
                                <td>
                                    <div class="btn-group-xs">
                                        <a data-clienteId='<?= md5($registro['id'])?>' data-token="<?= $reserva['Reserva']['token']?>" class="btn btn-danger btn-xs excluir-convidado"><i class="fa fa-times-circle"></i> Excluir</a>
                                    </div> 
                                </td>
                            </tr>
                            <?php endforeach;?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
        
        <div class="col-sm-4 col-md-4">
            <section class="panel">
                <header class="panel-heading">
                    Cadastrar Convidado
                </header>
                <div class="panel-body ">
                    <div class="painel-edit"></div>
                    <div class="painel-cadastro">
                        <form method="post" action="<?= Router::url(array('Reservas', 'adicionarConvidados'))?>" id="ClienteAddForm">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <small>Nome: <strong class="text text-danger">*</strong></small>
                                    <input type="text" name="Cliente[nome]" class="form-control input-sm rounded" placeholder="Nome:">
                                </div>
                                <div class="form-group col-md-12">
                                    <small>E-mail: <strong class="text text-danger">*</strong></small>
                                    <input type="text" name="Cliente[email]" class="form-control input-sm rounded" placeholder="E-mail:">
                                </div>
                                <div class="form-group col-md-12">
                                    <small>RG: <strong class="text text-danger"></strong></small>
                                    <input type="text" name="Cliente[rg]" class="form-control input-sm rounded" placeholder="RG:">
                                </div>
                                <div class="form-group col-md-12">
                                    <small>Telefone: <strong class="text text-danger">*</strong></small>
                                    <input type="text" name="Cliente[telefone]" class="form-control input-sm  rounded telefone" placeholder="Telefone:">
                                    <input type="hidden" name="Reserva[token]" value="<?= ($reserva['Reserva']['token'])?>">
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
    </div>
</div>