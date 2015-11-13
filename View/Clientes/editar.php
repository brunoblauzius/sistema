<form method="post" action="<?= Router::url(array('Clientes', 'edit'))?>" id="ClienteAddForm">
    <div class="row">
        <div class="form-group col-md-12">
            <small>Nome: <strong class="text text-danger">*</strong></small>
            <input type="text" name="Cliente[nome]" class="form-control rounded" placeholder="Nome:" value="<?= $registro['nome']?>">
        </div>
        <div class="form-group col-md-12">
            <small>E-mail: <strong class="text text-danger">*</strong></small>
            <input type="text" name="Cliente[email]" class="form-control rounded" placeholder="E-mail:" value="<?= $registro['email']?>">
        </div>
        <div class="form-group col-md-12">
            <small>RG: <strong class="text text-danger"></strong></small>
            <input type="text" name="Cliente[rg]" class="form-control rounded" placeholder="RG:" value="<?= $registro['rg']?>">
        </div>
        <div class="form-group col-md-12">
            <small>Telefone: <strong class="text text-danger">*</strong></small>
            <input type="text" name="Cliente[telefone]" class="form-control rounded telefone" placeholder="Telefone:" value="<?= $registro['telefone']?>">
        </div>
        <div class="form-group col-md-12">
            <small>Data Nascimento: <strong class="text text-danger"></strong></small>
            <input type="text" name="Cliente[dt_nascimento]" class="form-control rounded date2" placeholder="Data Nascimento:" value="<?= Utils::convertDataSemHora($registro['dt_nascimento'])?>">
        </div>
        <div class="form-group col-md-12">
            <small>Sexo: <strong class="text text-danger">*</strong></small>
            <select type="text" name="Cliente[sexo]" class="form-control rounded">
                
                <?php 
                
                    $arrayMasc = array( 0  => "FEMININO", 1 => "MASCULINO" );

                    foreach ($arrayMasc as $key => $value):
                        
                       $select = NULL;
                    
                       if( $registro['sexo'] == $key ):
                           $select = 'selected="selected"';
                       endif;
                         
                ?>
                <option value="<?= $key?>" <?php echo $select?> > <?= $value?> </option>
                <?php 
                    endforeach;
                ?>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-12">
            <button class="btn btn-s-md btn-primary btn-rounded btn-block">Alterar</button>
        </div>
    </div>
</form>