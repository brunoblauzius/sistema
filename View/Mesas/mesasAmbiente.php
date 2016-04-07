<h5>Mesas Livres:</h5>
<?php if(empty($mesas)):?>
    <div class="alert alert-warning">
        <p class="text-center"> Não existem mesas disponíveis para esse ambiente!</p>
    </div>
<?php else:?>

    <div class="col-sm-12" id="mesas-ambiente">

        <label class="checkbox">
            <input type="checkbox" name="" value="1" class="check-all"> Selecionar todas.
        </label>

        <?php foreach ($mesas as $mesa) :?>
            <div class="col-sm-4">
                <?php foreach ($mesa as $key => $value) :?>

                    <?php if( array_keys($mesasReservadas, $value)):?>
                        <label class="checkbox">
                            <input type="checkbox" name="Reserva[mesas_id][]" value="<?= $key ?>" checked="checked"> <?= ucwords($value) ?>
                        </label>
                    <?php else:?>
                        <label class="checkbox">
                            <input type="checkbox" name="Reserva[mesas_id][]" value="<?= $key ?>"> <?= ucwords($value) ?>
                        </label>
                    <?php endif;?>
                <?php endforeach;?>
            </div>
        <?php endforeach;?>
    </div>

    <div class="clearfix"></div>
    <hr>
    
<?php endif;?>

