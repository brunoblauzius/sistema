<?php if(count($cliente) == 0 ):?>
<div class="col-sm-12 form-group-sm">
    <form method="post" action="<?= Router::url(array('Clientes', 'addReserva'))?>" id="ClienteAddForm">
    <table class="table table-condensed">
        <tbody>
            <tr>
                <td>
                    <div class="form-group ">
                        <small>Nome: <strong class="text text-danger">*</strong></small>
                        <input type="text" name="Cliente[nome]" class="form-control rounded" placeholder="Nome:">
                    </div>
                </td>
                <td>
                    <div class="form-group ">
                        <small>E-mail: <strong class="text text-danger">*</strong></small>
                        <input type="text" name="Cliente[email]" class="form-control rounded" placeholder="E-mail:">
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="form-group ">
                        <small>RG: <strong class="text text-danger"></strong></small>
                        <input type="text" name="Cliente[rg]" class="form-control rounded" placeholder="RG:">
                    </div>
                </td>
                <td>
                    <div class="form-group ">
                        <small>Telefone: <strong class="text text-danger">*</strong></small>
                        <input type="text" name="Cliente[telefone]" class="form-control rounded telefone" placeholder="Telefone:">
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <small>Sexo: <strong class="text text-danger">*</strong></small>
                    <select type="text" name="Cliente[sexo]" class="form-control rounded">
                        <option value="1"> MASCULINO </option>
                        <option value="0"> FEMININO </option>
                    </select>
                </td>
                <td>
                    <div class="form-group ">
                        <small>Data Nascimento: <strong class="text text-danger"></strong></small>
                        <input type="text" name="Cliente[dt_nascimento]" class="form-control rounded date2" placeholder="Data Nascimento:">
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
        
         <div>
            <button class="btn btn-primary btn-xs pull-right" > Cadastrar e incluir na lista </button>
        </div>
        
    </form>
   
</div>

<?php elseif ( count($cliente) == 1 ):?>
<div class="col-sm-12 form-group-sm">
    <table class="table table-condensed">
        <tbody>
            <tr>
                <td>
                    <small>Nome:</small>
                    <input type="text"  class="form-control" value="<?= $cliente[0]['nome']?>" disabled="true">
                </td>
                <td>
                    <small>E-mail:</small>
                    <input type="text" class="form-control" value="<?= $cliente[0]['email']?>" disabled="true">
                </td>
            </tr>
            <tr>
                <td>
                    <small>Rg:</small>
                    <input type="text"  class="form-control" value="<?= $cliente[0]['rg']?>" disabled="true">
                </td>
                <td>
                    <small>Telefone:</small>
                    <input type="text"  class="form-control" value="<?= $cliente[0]['telefone']?>" disabled="true">
                </td>
            </tr>
        </tbody>
    </table>
    <div>
        <a class="btn btn-primary btn-xs pull-right" id="continuar-reserva" > Continuar a reserva </a>
        <input type="hidden" name="Reserva[clientes_id]" class="form-control" value="<?= md5($cliente[0]['id'])?>">
    </div>
    
</div>

<?php elseif ( count($cliente) > 1 ):?>
<div class="col-sm-12" style="overflow-y:auto; height:200px;" >
    <table class="table table-condensed table-striped table-responsive">
        <thead>
            <th>Nome</th>
            <th>E-mail</th>
            <th>Telefone</th>
            <th></th>
        </thead>
        <tbody>
            <?php foreach ($cliente as $pessoa):?>
                <tr>
                    <td><?= $pessoa['nome']?></td>
                    <td><?= $pessoa['email']?></td>
                    <td><?= $pessoa['telefone']?></td>
                    <td>
                        <a class="btn btn-primary btn-xs encontratId" data-id="<?= md5($pessoa['id'])?>"><i class="fa fa-sign-in"></i></a>
                    </td>
                </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</div>
<script>
    $('.encontratId').click(function(){
        var url   = web_root + 'Clientes/procurarCliente/' + $(this).data('id');
        $('#loading').fadeIn(500);
        // iniciar o loader
        $.ajax({
            url: url,
            data:{},
            dataType: 'html',
            type: 'get',
            success: function (html) {
                // encerrar loader
                $('#loading').fadeOut(500);  
                // dados
                $('#dados-cliente').html(html);
                $('#dados-reserva').empty();
            }
        });
    });
</script>
<?php endif; ?>
