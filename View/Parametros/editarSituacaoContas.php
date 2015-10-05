<form method="post" action="<?= Router::url(array('Parametros', 'editSituacaoContas'))?>" id="TiposPagamentoAddForm">
    <div class="row">
        <div class="form-group col-md-12">
            <small>Nome: <strong class="text text-danger">*</strong></small>
            <input type="text" name="SituacaoConta[nome]" class="form-control rounded" placeholder="Nome:" value="<?= $registro['nome']?>">
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-12">
            <button class="btn btn-s-md btn-primary btn-rounded btn-block">Cadastrar</button>
        </div>
    </div>
</form>