              
<form method="post" action="<?= Router::url(array('Ambientes', 'edit'))?>" id="AmbienteAddForm">
    <div class="row">
        <div class="form-group col-md-12">
            <small>Salão: <strong class="text text-danger">*</strong></small>
            <select class="form-control rounded" name="Ambiente[saloes_id]">

                <?php if( empty($saloes) ):?>
                    <option> -- Salões -- </option>
                <?php endif;?>

                <?php foreach ($saloes as $salao):?>
                    <?php if( $salao['Salao']['id'] == $registro['saloes_id']):?>
                        <option value="<?= $salao['Salao']['id']?>" selected="selected"> <?= $salao['Salao']['nome']?> </option>
                    <?php else:?>
                        <option value="<?= $salao['Salao']['id']?>"> <?= $salao['Salao']['nome']?> </option>
                    <?php endif;?>

                <?php endforeach;?>
            </select>
        </div>
        <div class="form-group col-md-12">
            <small>Nome: <strong class="text text-danger">*</strong></small>
            <input type="text" name="Ambiente[nome]" class="form-control rounded" placeholder="Descrição:" value="<?= $registro['nome']?>">
        </div>
        <div class="form-group col-md-12">
            <small>Capacidade: <strong class="text text-danger">*</strong></small>
            <input type="text" name="Ambiente[capacidade]" class="form-control rounded" placeholder="Capacidade:" value="<?= $registro['capacidade']?>">
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-12">
            <button class="btn btn-s-md btn-primary btn-rounded btn-block">Alterar</button>

        </div>
    </div>
</form>
