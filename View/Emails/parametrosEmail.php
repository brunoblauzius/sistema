<div class="row">
    <div class="col-md-12">
        <ul class="breadcrumbs-alt">
            <li>
                <a href="<?= Router::url(array('Usuarios', 'painel'))?>"> <i class="fa fa-home"></i> Home</a>
            </li>
            <li>
                <a class="current" href="#">Cadastro</a>
            </li>
        </ul>
    </div>
</div>
<div class="panel">
    <div class="panel-heading">
        <div class="panel-title">Parâmetros de e-mails:</div>
    </div>
    <div class="panel-body">
        
        
        <div class="row">
            <div class="col-md-12">
                
                
                <section class="panel">
                    <div class="panel-body">
                        
                        <div class="form">
                            <form action="<?= Router::url(array('Emails', 'cadastraCorpoErodape'));?>" class="form" accept-charset="UTF-8" method="post" name="EmailAddForm" id="EmailAddForm">
                                <div class="form-group">
                                    
                                    <div class="clearfix"></div>
                                    
                                    <div class="col-md-8" >
                                        
                                        <div style="margin-bottom:20px;">
                                            <select name="Email[coluna]" class="form-control" id="selectCampo">
                                                <option value="corpo_email">Corpo do Email</option>
                                                <option value="rodape_email">Rodapé do Email</option>
                                            </select>
                                        </div>    
                                        <input type="hidden" value="<?= $emailConfirmacao['id']?>" name="Email[emails_sistema_id]">
                                        
                                        <div id="corpo-email">
                                            <textarea class="form-control ckeditor" name="Email[corpo_email]" rows="3"><?= $emailParametros['corpo_email']?></textarea>
                                        </div>
                                        <div id="rodape-email">
                                            <textarea class="form-control ckeditor" name="Email[rodape_email]" rows="3"><?= $emailParametros['rodape_email']?></textarea>
                                        </div>
                                        
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <small class="badge bg-info"> Legenda:</small>
                                        <table class="table table-condensed table-striped" style="font-size:12px;">
                                            <thead>
                                                <tr>
                                                    <th>link</th>
                                                    <th>valor</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>__DATA_INICIO__</td>
                                                    <td>Data que foi agendada a reserva.</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                                <div class="clearfix"></div>
                                <div class="col-md-6" style="margin-top:30px;">
                                    <div class="form-group">
                                        <button class="btn btn-primary">Cadastrar</button>
                                    </div>    
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-info btn-lg pull-right emailModal" data-toggle="modal" data-target="#emailModal">
                                      Preview Email
                                    </button>

                                </div>
                                
                            </form>
                        </div>
                    </div>
                </section>
                
            </div>
        </div>
    </div>
    <div class="panel-footer"></div>
</div>



<!-- Modal -->
<div class="modal fade bs-example-modal-lg" id="emailModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4>Preview</h4>
      </div>
      <div class="modal-body">
        <?= $emailConfirmacao?>
      </div>
      
    </div>
  </div>
</div>


<script>
    
    $(document).ready(function(){
       $('#rodape-email').hide();
       
       $('.emailModal').click(function () {
            $('#emailModal').modal('show');
       });
    });
    
    $(document).on('change', '#selectCampo', function (){
        
        var valor = $(this).val();
        
        if( valor == 'corpo_email' ){
            $('#corpo-email').show();
            $('#rodape-email').hide();
        } else {
            $('#corpo-email').hide();
            $('#rodape-email').show();
        }
    });
    
</script>