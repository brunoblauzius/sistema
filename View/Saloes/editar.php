
<form method="post" action="<?= Router::url(array('Saloes', 'edit'))?>" id="SalaoAddForm">
    <div class="row">
        <div class="form-group col-md-12">
            <small>Nome: <strong class="text text-danger">*</strong></small>
            <input type="text" name="Salao[nome]" class="form-control rounded" placeholder="Descrição:" value="<?= $salao['nome']?>">
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-12">
            <button class="btn btn-s-md btn-primary btn-rounded btn-block">Editar</button>
        </div>
    </div>
</form>
