<h5>Mesas Livres:</h5>
<?php if(empty($mesas)):?>
    <div class="alert alert-warning">
        <p class="text-center"> Não existem mesas disponíveis para esse ambiente!</p>
    </div>
<?php endif;?>

<div class="col-sm-12">
    <?php foreach ($mesas as $mesa) :?>
        <div class="col-sm-4">
            <?php foreach ($mesa as $key => $value) :?>
                <label class="checkbox">
                    <input type="checkbox" name="Reserva[mesas_id][]" value="<?= $key ?>"> <?= ucwords($value) ?>
                </label>
            <?php endforeach;?>
        </div>
    <?php endforeach;?>
</div>

<div class="clearfix"></div>
<hr>