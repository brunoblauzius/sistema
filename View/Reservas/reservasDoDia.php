<div class="panel panel-primary">
    <div class="panel-heading">Lista de Reservas.</div>
    <div class="panel-body" id="panel-body">

        <table class="table table-condensed " id="dynamic-table">
            <thead>
                <tr>
                    <th style="width:15%">Cliente</th>
                    <th style="width:10%">Ambiente</th>
                    <th style="width:3%">PAX</th>
                    <th style="width:10%">Mesas</th>
                    <th style="width:5%">Total lista</th>
                    <th style="width:5%">Não Confirmados</th>
                    <th style="width:5%">Confirmados</th>
                    <th style="width:5%"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($registros)):
                    foreach ($registros as $registro):
                        ?>
                        <tr>
                            <td ><?= $registro['cliente'] ?></td>
                            <td ><?= $registro['ambiente'] ?></td>
                            <td ><?= $registro['qtde_pessoas'] ?></td>
                            <td ><small><?= $registro['mesas'] ?></small></td>
                            <td class="text-center">
                                <?= $registro['total_pessoas_lista'] ?>
                            </td>
                            <td class="text-center">
                                <?= $registro['nao_confirmado'] ?>
                            </td>
                            <td class="text-center">
                                <?= $registro['confirmado'] ?>
                            </td>
                            <td >
                                <a data-url="<?= Router::url(array('Reservas', 'listarConvidadosHostess', $registro['token'])) ?>" class="lista-convidados-hostess"><i class="fa fa-users"></i> Convidados</a></li>
                            </td>
                        </tr>
                        <?php
                    endforeach;
                endif;
                ?>
            </tbody>
        </table>
    </div>
</div>



<div class="modal fade" id="modal-convidados" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"> Lista de Convidados </h4>
      </div>
        
      <div class="modal-body" id="contend">
        
          
      </div>
        
    </div>
  </div>
</div>



<script>

    $(document).on('click', '.lista-convidados-hostess', function() {
        var url = $(this).data('url');
        chamaListaConvidadosHostess( url );
    });

    $(document).on('click', '.confirma-presenca-hostess',function(){
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
                
                    tratarJSON(json);
                        
           }
        });
    });

</script>  

