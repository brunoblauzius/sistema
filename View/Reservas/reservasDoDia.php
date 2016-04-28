<div class="panel panel-primary">
    <div class="panel-heading">Lista de Reservas.</div>
    <div class="panel-body" id="panel-body">

        <div class="col-md-12 col-sm-12 col-xs-12 " style="margin-bottom: 20px;">
            <div class="col-md-6 pull-right">
                <div class="col-md-8 col-sm-6 col-xs-6">
                    <input type="text" placeholder="Nome do convidado" class="form-control input-sm" id="nome-convidado">
                </div>
                <div class="col-md-4 col-sm-6  col-xs-6">
                    <button class="btn btn-primary btn-sm btn-block" id="btn-filtrar">Filtrar</button>
                </div>
            </div>
        </div>
        
        <div class="clearfix"></div>
        
        <div id="filtro-resultados">
            
            <?= Render::element('reservas_hostess', array('registros' => $registros))?>
            
        </div>
        
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

    $(document).on('click', '#btn-filtrar', function() {
        var nome = $('#nome-convidado').val();
        filtrarListaDeConvidadosHostess( nome );
    });

    $('#nome-convidado').on('keypress',  function( event ) {
        var nome = $(this).val();
        if( event.which === 13 &&  nome.length >= 3 ){
            filtrarListaDeConvidadosHostess( nome );
        }
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

