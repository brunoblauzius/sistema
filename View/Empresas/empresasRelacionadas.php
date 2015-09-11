<div class="row">
    <div class="col-md-12">
        <ul class="breadcrumbs-alt">
            <li>
                <a href="<?= Router::url('Usuarios/painel')?>"> <i class="fa fa-home"></i> Painel</a>
            </li>
            <li>
                <a class="current" href="">Empresas Relacionadas</a>
            </li>
        </ul>
    </div>
</div>
<section class="row">
    <div class="col-sm-12">
        <div class="panel panel-success">
            <header class="panel-heading">
                Empresas Relacionadas
            </header>
            <div class="panel panel-body">
                
                <div class="col-md-12">
                    <a href="<?= Router::url( array( 'Empresas', 'cadastro', md5($proprietario['Fisica']['pessoas_id'])) )?>" class="pull-right btn btn-success btn-sm">Adicionar Mais Empresas</a>
                </div>
                <div class="clearfix"></div><hr>
                
                <table class="table table-condensed table-striped table-hover" id="dynamic-table"> 
                    <thead>
                        <th class="text-center"></th>
                        <th>Razão</th>
                        <th>Nome Fantasia</th>
                        <th>CNPJ</th>
                        <th>Status</th>
                        <th>Data Criação</th>
                        <th style="width: 10%"></th>
                    </thead>
                    <tbody>
                        <?php foreach ($empresas as $empresa):?>
                            <tr>
                                <td class="text-center">
                                    <?php if( !empty($empresa['logo']) ):?>
                                        <img src="<?= Router::url('View/webroot/img/logos/'.$empresa['logo'] )?>" class="img-circle img-rounded img-thumbnail" style="height:60px">
                                    <?php else:?>
                                        <img src="<?= Router::url('View/webroot/img/no-image.jpg')?>" class="img-circle img-rounded img-thumbnail" style="height:60px">
                                    <?php endif;?>
                                </td>
                                <td><?= $empresa['razao']?></td>
                                <td><?= $empresa['nome_fantasia']?></td>
                                <td><?= Utils::formatarCPFCNPJ($empresa['cnpj'])?></td>
                                <td><?= $empresa['status']?></td>
                                <td><?= Utils::convertData($empresa['created'])?></td>
                                <td>
                                    <div class="btn-group btn-group-xs">
                                        <!--a href="<?= Router::url( array( 'Empresas', 'editar', md5($empresa['empresas_id'])) )?>" class="btn btn-primary btn-xs" title="Editar Empresa">Editar</a-->
                                        <a href="<?= Router::url( array( 'Empresas', 'contaEmpresa', md5($empresa['empresas_id'])) )?>" class="btn btn-warning btn-xs" title="Situação da Conta">Conta</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>
            
            
        </div>
    </div>
</section>