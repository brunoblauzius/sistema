
<?php 
$i = 0;
foreach($lista as $registro):?>
<div class="col-md-3">
    <div class="form-group">
        <small class="">Nome da Controladora:</small>
        <input type="text" class="form-control" name="Metodo[nome][<?= $i?>]" placeholder="Metodo:" value="<?= $registro?>">
    </div>    
</div>

<div class="col-md-3">
    <div class="form-group">
        <small class="">Nome Link:</small>
        <input type="text" class="form-control" name="Metodo[nome_link][<?= $i?>]" placeholder="Nome Link:">
    </div>       
</div>

<div class="col-md-3">
    <div class="form-group">
        <small class="">Descrição:</small>
        <input type="text" class="form-control" name="Metodo[descricao][<?= $i?>]" placeholder="Descrição:">
    </div>       
</div>

<div class="pull-left">
    <div class="form-group" style="padding-top: 15px; padding-right:10px;">
        <label class="checkbox">
            <input type="hidden" class="" name="Metodo[is_page][<?= $i?>]" value="0">
            <input type="checkbox" class="" name="Metodo[is_page][<?= $i?>]" value="1"> É página.
        </label>
    </div>       
</div>
<div class="pull-left">
    <div class="form-group" style="padding-top: 15px; padding-right:10px;">
        <label class="checkbox">
            <input type="hidden" class="" name="Metodo[menu_primario][<?= $i?>]" value="0">
            <input type="checkbox" class="" name="Metodo[menu_primario][<?= $i?>]" value="1"> Menu 1º.
        </label>
    </div>       
</div>
<div class="pull-left">
    <div class="form-group" style="padding-top: 15px; padding-right:10px;">
        <label class="checkbox">
            <input type="hidden" class="" name="Metodo[menu_secundario][<?= $i?>]" value="0">
            <input type="checkbox" class="" name="Metodo[menu_secundario][<?= $i?>]" value="1"> Menu 2º.
        </label>
    </div>       
</div>
<div class="clearfix"></div>

<?php $i++; endforeach;?>