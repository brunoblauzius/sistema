
<div class="row">
    
    <div class="col-md-12">
        <h1 class="pgtitulo">Fale conosco:</h1>
    </div>

    <div class="col-md-6">
        <h3>Dúvidas, criticas ou sugestões?</h3>
        <p>Deixe sua dúvida, critica ou sugestão aqui. Responderemos o mais rápido possível.</p>
        <p><strong>Telefone:</strong> (00) 0000.0000</p>
        <small><strong>Endereço:</strong>  Rua nome da rua tal 0000, Cidade / UF. CEP: 00.000-0000</small>
    </div>
    
    <div class="col-md-6">
        <div class="well ">
                <form name="contato" action="<?= $this->urlRoot()?>Pages/sendContato" method="post" accept-charset="UTF-8" id="ContatoForm">
                        <fieldset>
                        <legend>Entre em contato:</legend>
                        <div class="form-group">
                            <small>Nome: <span class="text text-danger">*</span></small>
                            <input type="text" name="Contato[nome]" class="form-control input-sm" value="">
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group">
                            <small>E-mail: <span class="text text-danger">*</span></small>
                            <input type="text" name="Contato[email]" class="form-control input-sm" value="">
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group">
                            <small>Assunto: <span class="text text-danger">*</span></small>
                            <input type="text" name="Contato[assunto]" class="form-control input-sm" value="">
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group">
                            <small>Mensagem: <span class="text text-danger">*</span></small>
                            <textarea name="Contato[mensagem]" class="form-control input-sm"></textarea>
                        </div>
                        
                        <div class="form-group" style="margin-bottom:20px;">
                            <div class="col-md-5 form-group" style="padding-left:0px;">
                                <div style="width:200px; height:100px;">
                                    <img src="<?= $this->urlRoot().'Captchas/displayAction'?>" width="200" style="margin-bottom:5px;" id="captcha">
                                    <a class="btn btn-info btn-xs pull-right atualiza-captcha"><i class="glyphicon glyphicon-refresh"></i></a>
                                </div>
                                <input type="text" name="Contato[code]" value="" class="form-control">
                            </div>
                        </div>
                    
                        
                    </fieldset>
                    <div class="clearfix"></div>
                    <div class="form-group">
                        <button class="btn btn-primary sendform btn-sm">Enviar Contato</button>
                        <a class="btn btn-danger btn-sm limparCampos"> Limpar Campos </a>
                    </div>
                </form>
        </div>
    </div>
    <!-- fim div centralizador -->   
</div><!-- /form -->
<script>
$(document).ready(function(){
    $('.limparCampos').click(function(){
        $('.form-control').val(null);
    });
    $('.atualiza-captcha').click(function(){
        $('#captcha').attr('src', "<?= $this->urlRoot().'Captchas/displayAction'?>");
    });
});
</script>
