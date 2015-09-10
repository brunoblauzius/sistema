

<section class="row">
    <div class="col-sm-12">
        <div class="panel panel-success">
            <div class="panel panel-heading">Proprietários de Empresas</div>
            
            <div class="panel panel-body">
                
                <table class="table table-condensed table-striped table-hover" id="dynamic-table">
                    <thead>
                        <th>Nome</th>
                        <th>Cpf</th>
                        <th>E-mail</th>
                        <th>Login</th>
                        <th style="width: 220px"></th>
                    </thead>
                    <tbody>
                        <?php foreach ($proprietarios as $proprietario):?>
                            <tr>
                                <td><?= $proprietario['nome']?></td>
                                <td><?= Utils::formatarCPFCNPJ($proprietario['cpf'])?></td>
                                <td><?= $proprietario['email']?></td>
                                <td><?= $proprietario['login']?></td>
                                <td>
                                    <div class="btn-group btn-group-xs">
                                        <a href="<?= Router::url( array( 'Empresas', 'empresasRelacionadas', md5($proprietario['pessoas_id'])) )?>" class="btn btn-primary btn-xs" title="Empresas Relacionadas">Empresas</a>
                                        <a href="<?= Router::url( array( 'Pessoas',  'perfil', md5($proprietario['pessoas_id'])) )?>" class="btn btn-info btn-xs" title="Dados pessoais do proprietário">Dados Pessoais</a>
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