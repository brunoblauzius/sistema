<div class="container">
    <div class="row">
        <section class="panel">
            <header class="panel-heading">
                reserva
              <span class="tools pull-right">
                  <a href="javascript:;" class="fa fa-chevron-down"></a>
               </span>
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
                            <!--td style="width:20%"><strong>Contato:</strong></td>
                            <td style="width:30%"><?= ($reserva['Reserva']['qtde_pessoas'])?></td-->
                        </tr>
                        <tr>
                            <td><strong>Endereço:</strong></td>
                            <td colspan="4"><?= $enderecoEmpresa?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
</div>
</div>