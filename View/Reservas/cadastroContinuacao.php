<div class="col-sm-6">
    <div class="form-group">
        <small>Número Pessoas: <strong class="text text-danger">*</strong></small>
        <input type='text' class="form-control" name="Reserva[qtde_pessoas]" id="qtde_pessoas"/>
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group">
        <small>Assentos: <strong class="text text-danger">*</strong></small>
        <input type='text' class="form-control" name="Reserva[assentos]" id="assentos"/>
    </div>
</div>
<div class="clearfix"></div>
<div class="col-sm-6">
    <div class="form-group">
        <small>Salões: <strong class="text text-danger">*</strong></small>
        <select name="Reserva[saloes_id]" class="form-control rounded" id="SalaoId">
            <option value=""> -- selecione -- </option>
            <?php foreach ($saloes as $salao):?>
                <option value="<?= $salao['Salao']['id']?>"> <?= $salao['Salao']['nome']?> </option>
            <?php endforeach;?>
        </select>
    </div>
</div>

<div class="col-sm-6">
    <div class="form-group">
        <small>Ambiente: <strong class="text text-danger">*</strong></small>
        <select name="Reserva[ambientes_id]" class="form-control rounded" id="AmbienteId">
            <option value=""> selecione o salão </option>
        </select>
    </div>
</div>

<div class="col-sm-12" id="mesas-cadastro">
    <h5>Mesas Livre:</h5>
    
    <div class="clearfix"></div>
    <hr>
</div>

<div class="form-group">
    <div class="col-md-12">
        <small>Observação interna:</small>
        <textarea name="Reserva[descricao_interna]" id="descricao" class="form-control" rows="4"></textarea>
    </div>
    <div class="col-md-12">
        <small>Observação Cliente:</small>
        <textarea name="Reserva[descricao_cliente]" id="descricao" class="form-control" rows="4"></textarea>
    </div>
</div>
<div class="clearfix"></div>

<div class="form-group">
    <input type="hidden" name="Reserva[color]" id="cor" value="#1fb5ad" class="form-control">
    <input type="hidden" name="Reserva[title]" id="title"  class="form-control">
    <input type="hidden" name="Reserva[textColor]" id="textColor" value="#FFFFFF" class="form-control">
</div>

</div>
<div class="clearfix"></div>
<div class="modal-footer" style="margin-top:20px;">
    <button class="btn btn-primary enviaForm">Cadastrar</button>
    <a class="btn btn-default" data-dismiss="modal">Cancelar</a>
    <input type="hidden" id="id" value="">
    <input type="hidden" id="acao" value="cadastrar">
</div>