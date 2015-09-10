
<div class="row">
    
    <div class="col-md-12">
        <h1 class="pgtitulo">Participe:</h1>
    </div>

    <div class="col-md-6">
    	<h3>Cadastre-se e participe!</h3>
        <p>Sendo um usuário cadastrado você será capaz de ter um maior Controle de suas vacinas.</p>
        <p>Além de participar da rede e poder ter informações de todas as vacinas existentes, você poderá também gerenciar seu perfil conforme desejado!</p>
        <p><strong>Cadastre-se agora mesmo!</strong></p>
        <p>Tenha acesso ao melhor portal de controle de vacinação da internet!</p>
        
    </div><!-- //left -->
    
        <div class="col-md-6" style="padding:10px;">
            <div class="well">
                <form id="UsuarioAddForm" action="<?= $this->urlRoot()?>Pages/addUsuario" method="post">
                <fieldset>
                    <legend>Identificação:</legend>
                    <div class="form-group">
                        <small>Nome completo: <span class="text text-danger"> *</span></small>
                        <input type="text" name="Usuario[nome]" value="" class="form-control input-sm">
                    </div>
                    <div class="form-group">
                        <small>CPF ou DMV <span class="text text-muted">(para usuários que não possuem CPF. Este documento pode ser encontrado na certidão de Nascimento.)</span>: <span class="text text-danger"> *</span></small>
                        <input type="text" name="Usuario[cpf]" value="" class="form-control input-sm ">
                    </div>
                    <div class="form-group">
                        <small>Data de Nascimento: <span class="text text-danger"> *</span></small>
                        <input type="text" name="Usuario[dataNascimento]" value="" class="form-control input-sm data">
                    </div>
                    <div class="form-group">
                        <small>E-mail: <span class="text text-danger"> *</span></small>
                        <input type="text" name="Usuario[email]" value="" class="form-control input-sm">
                    </div>
                </fieldset>
            
                <fieldset>
                    <legend>Contato:</legend>
                        <div class="form-group">
                            <small>Telefone Fixo: <span class="text text-danger"> </span></small>
                            <input type="text" name="Usuario[telefoneFixo]" value="" class="form-control fone input-sm">
                        </div>
                        <div class="form-group">
                            <small>Telefone Celular: <span class="text text-danger"> </span></small>
                            <input type="text" name="Usuario[telefoneCelular]" value="" class="form-control fone input-sm">
                        </div>
                </fieldset>
            
                <fieldset>
                    <legend>Conta:</legend>
                    <div class="form-group">
                        <small>Senha: <span class="text text-danger"> *</span></small>
                        <input type="password" name="Usuario[senha]" value="" class="form-control input-sm">
                    </div>
                    <div class="form-group">
                        <small>Confirme a senha: <span class="text text-danger"> *</span></small>
                        <input type="password" name="Usuario[confirm_senha]" value="" class="form-control input-sm">
                    </div>
                    
                    <div class="form-group" style="margin-bottom:20px;">
                        <div class="col-md-5 form-group" style="padding-left:0px;">
                            <div style="width:200px; height:100px;">
                                <img src="<?= $this->urlRoot().'Captchas/displayAction'?>" width="200" style="margin-bottom:5px;" id="captcha">
                                <a class="btn btn-info btn-xs pull-right atualiza-captcha"><i class="glyphicon glyphicon-refresh"></i></a>
                            </div>
                            <input type="text" name="Usuario[code]" value="" class="form-control">
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    
                    <label>
                        <br/>
                        <span class="tt">* Campos Obrigatórios</span>
                    </label>
                </fieldset>
                    
                
                
                <button type="submit" class="btn btn-primary btn-sm">Cadastrar meus dados</button>
                <a value="" class="btn btn-danger btn-sm limparCampos">Limpar Campos</a>
                <input type="hidden" name="Usuario[role_id]" value="2">
            </form>
            </div>
        </div>
    
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
