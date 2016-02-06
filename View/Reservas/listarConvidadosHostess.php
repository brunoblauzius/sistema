
<div class="row">
    <div class="col-sm-8 col-sm-offset-2">
        <div class="panel panel-primary">
            <div class="panel-heading">Lista de Convidados.</div>
            <div class="panel-body" id="panel-body">
                
                <div id="tabela-dinamica">
                    <table class="table table-condensed table-striped" id="dynamic-table" >
                        <thead>
                             <tr>
                                <th style="width:20%">Confirmado</th>
                                <th><strong>Nome do Cliente:</strong></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($listaDeConvidados as $registro):?>
                            <tr>
                                <td>
                                    <?php if($registro['confirmado'] == 0): ?>
                                        <a data-clientesid="<?= $registro['clientes_id']?>" data-reservasid="<?= $registro['reservas_id']?>" class="confirma-presenca-hostess btn btn-xs btn-danger"><span class="fa fa-times"></span></a>
                                    <?php else:?>
                                        <a data-clientesid="<?= $registro['clientes_id']?>" data-reservasid="<?= $registro['reservas_id']?>" class="btn btn-xs btn-success"><span class="fa fa-check"></span></a>
                                    <?php endif;?>
                                </td>
                                <td>
                                    <?= $registro['nome']?>
                                </td>
                            </tr>
                        <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
                <div id="loader-painel"></div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    $('.confirma-presenca-hostess').click(function(){
        var reservas_id = $(this).data('reservasid');
        var clientes_id = $(this).data('clientesid');
        
        $this = $(this);
        
        var url = web_root + 'Reservas/listarConvidadosHostess';
        $('#tabela-dinamica').hide();
        loadingElement('<br>Aguarde um momento, estamos guardando suas informações...', '#loader-painel');
        
        $.ajax({
           url: url,
           data:{
               reservas_id: reservas_id,
               clientes_id: clientes_id
           },
           dataType: 'json',
           type: 'post',
           success: function (json) {
                
                    //$this.addClass('btn-success').removeClass('btn-danger');
                    //$this.find('span').addClass('fa-check').removeClass('fa-times');
                    tratarJSON(json);
                        
           }
        });
          
       
    });
});
</script>

