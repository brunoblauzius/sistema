<div class="row">
    <div class="col-md-12">
        <ul class="breadcrumbs-alt">
            <li>
                <a href="<?= Router::url('Usuarios/painel')?>"> <i class="fa fa-home"></i> Painel</a>
            </li>
            <li>
                <a class="active-trail active" href="<?= Router::url(array('Empresas/empresasRelacionadas', md5($contaEmpresa['empresas_id'])));?>">Empresas Relacionadas</a>
            </li>
            <li>
                <a class="current" href="">Conta Empresa</a>
            </li>
        </ul>
    </div>
</div>

<div class="col-md-12">
    <section class="panel panel-success">
        <header class="panel-heading">
            Conta Empresa
        </header>
        <div class="panel-body ">
            <section class="row" style="margin-bottom: 20px;" >
                
                <div class="col-sm-4">
                    Tipo de conta: <strong><?= ($contaEmpresa['tipo_conta'])?></strong>
                </div>
                <div class="col-sm-4">
                    Data de Criação da conta: <strong><?= Utils::convertData($contaEmpresa['created'])?></strong>
                </div>
                <div class="col-sm-4">
                    Duração do contrato: <strong><?= ($contaEmpresa['duracao_contrato'])?> Dias</strong>
                </div>
                
            </section>
            <section class="row">
                <div class="col-sm-4">
                    Situação da Conta: <strong class="label label-default"><?= ($contaEmpresa['situacao_conta'])?></strong>
                </div>
                <div class="col-sm-4">
                    Tipo de pagamento efetuado: <strong><?= ($contaEmpresa['tipo_pagamento'])?></strong>
                </div>
                <div class="col-sm-4">
                    Valor mensal: <strong>R$ <?= Utils::real($contaEmpresa['valor'])?></strong>
                </div>
            </section>
        </div>
    </section>
</div>