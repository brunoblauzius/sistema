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
            Dados da Empresa.
        </header>
        <div class="panel-body ">
            <section class="row" style="margin-bottom: 20px;" >
                
                <div class="col-sm-4">
                    Razão social: <strong><?= ($empresa['razao'])?></strong>
                </div>
                <div class="col-sm-4">
                    Nome Fantasia: <strong><?= ($empresa['nome_fantasia'])?></strong>
                </div>
                <div class="col-sm-4">
                    Data de Criação da conta: <strong><?= Utils::convertData($contaEmpresa['created'])?></strong>
                </div>                
            </section>
            <section class="row">
                <div class="col-sm-4">
                    CNPJ: <strong><?= Utils::formatarCPFCNPJ($empresa['cnpj'])?></strong>
                </div>
                <div class="col-sm-4">
                    IE: <strong><?= ($empresa['ie'])?></strong>
                </div>
                <div class="col-sm-4">
                    Situação da Empresa: <strong  class="label label-primary"> <?= ($empresa['situacao_empresas'])?></strong>
                </div>
            </section>
        </div>
    </section>
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

<div class="col-md-12">
    <section class="panel panel-success">
        <header class="panel-heading">
           Alterar dados da Conta.
        </header>
        <div class="panel-body ">
            
            <form action="<?= Router::url(array('Empresas', 'alterarConta'))?>" method="post" accept-charset="utf-8" id="EmpresaAlterarContaForm">
                
                <section class="row" style="margin-bottom: 20px;" > 
                    <div class="col-sm-2" style="padding-top:5px;">
                        Tipo de Conta:
                    </div>
                    <div class="col-sm-4 form-group form-group-sm">
                        <select name="TipoConta[id]" class="form-control ">
                            <?php foreach ($TipoContas as $TipoConta) :?>
                                <?php if( $TipoConta['TipoConta']['id'] == $contaEmpresa['contas_empresas_tipos_id'] ):?>
                                    <option value="<?= $TipoConta['TipoConta']['id']?>" selected="selected"><?= $TipoConta['TipoConta']['nome']?></option>
                                <?php else:?>
                                    <option value="<?= $TipoConta['TipoConta']['id']?>"><?= $TipoConta['TipoConta']['nome']?></option>
                                <?php endif;?>
                            <?php endforeach;?>
                        </select>
                    </div>
                </section>
                <section class="row" style="margin-bottom: 20px;" > 
                    <div class="col-sm-2" style="padding-top:5px;">
                        Situação da Empresa:
                    </div>
                    <div class="col-sm-4 form-group form-group-sm">
                        <select name="SituacaoEmpresa[id]" class="form-control ">
                            <?php foreach ($situacaoEmpresas as $situacao) :?>
                                <?php if( $situacao['SituacaoEmpresa']['id'] == $empresa['situacao_empresas_id'] ):?>
                                    <option value="<?= $situacao['SituacaoEmpresa']['id']?>" selected="selected"><?= $situacao['SituacaoEmpresa']['nome']?></option>
                                <?php else:?>
                                    <option value="<?= $situacao['SituacaoEmpresa']['id']?>"><?= $situacao['SituacaoEmpresa']['nome']?></option>
                                <?php endif;?>
                            <?php endforeach;?>
                        </select>
                    </div>
                </section>
                <section class="row" style="margin-bottom: 20px;" > 
                    <div class="col-sm-2" style="padding-top:5px;">
                        Situação da Conta:
                    </div>
                    <div class="col-sm-4 form-group form-group-sm">
                        <select name="SituacaoConta[id]" class="form-control ">
                            <?php foreach ($situacaoContas as $situacaoConta) :?>
                                <?php if( $situacaoConta['SituacaoConta']['id'] == $contaEmpresa['situacao_contas_id'] ):?>
                                    <option value="<?= $situacaoConta['SituacaoConta']['id']?>" selected="selected"><?= $situacaoConta['SituacaoConta']['nome']?></option>
                                <?php else:?>
                                    <option value="<?= $situacaoConta['SituacaoConta']['id']?>"><?= $situacaoConta['SituacaoConta']['nome']?></option>
                                <?php endif;?>
                            <?php endforeach;?>
                        </select>
                    </div>
                </section>
                <section class="row" style="margin-bottom: 20px;" > 
                    <div class="col-sm-2" style="padding-top:5px;">
                        Tipo de Pagamento:
                    </div>
                    <div class="col-sm-4 form-group form-group-sm">
                        <select name="TiposPagamento[id]" class="form-control ">
                            <?php foreach ($tiposPagamentos as $tiposPagamento) :?>
                                <?php if( $tiposPagamento['TiposPagamento']['id'] == $contaEmpresa['tipos_pagamentos_id'] ):?>
                                    <option value="<?= $tiposPagamento['TiposPagamento']['id']?>" selected="selected"><?= $tiposPagamento['TiposPagamento']['nome']?></option>
                                <?php else:?>
                                    <option value="<?= $tiposPagamento['TiposPagamento']['id']?>"><?= $tiposPagamento['TiposPagamento']['nome']?></option>
                                <?php endif;?>
                            <?php endforeach;?>
                        </select>
                    </div>
                </section>
                
                <section class="row" style="margin-bottom: 20px;" > 
                    <div class="col-sm-2">
                        <button class="btn btn-primary">Atualizar Conta</button>
                    </div>
                </section>
                
                
            </form>
        </div>
    </section>
</div>


