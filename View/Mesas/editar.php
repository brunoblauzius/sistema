<form method="post" action="<?= Router::url(array('Mesas', 'edit'))?>" id="MesaAddForm">
    <div class="row">
        <div class="form-group col-md-12">
            <small>Nome: <strong class="text text-danger">*</strong></small>
            <input type="text" name="Mesa[nome]" class="form-control rounded" placeholder="Descrição:" value="<?= $registro['nome']?>">
        </div>

        <div class="form-group col-md-12">
            <small>Ambiente: <strong class="text text-danger">*</strong></small>
            <select class="form-control rounded" name="Mesa[ambientes_id]">
                <?php if( empty($ambientes) ):?>
                    <option value=""> -- Mesas -- </option>
                <?php endif;?>

                <?php foreach ($ambientes as $ambiente):?>
                    <?php if( $ambientes['Ambiente']['id'] == $registro['ambientes_id']):?>
                        <option value="<?= $ambiente['Ambiente']['id']?>" selected="selected"> <?= $ambiente['Ambiente']['nome']?> </option>
                    <?php else:?>
                        <option value="<?= $ambiente['Ambiente']['id']?>"> <?= $ambiente['Ambiente']['nome']?> </option>
                    <?php endif;?>
                <?php endforeach;?>
            </select>
        </div>


    </div>
    <div class="row">
        <div class="form-group col-md-12">
            <button class="btn btn-s-md btn-primary btn-rounded btn-block">Cadastrar</button>

        </div>
    </div>
</form>