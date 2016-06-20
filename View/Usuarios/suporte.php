<div class="row">
    <div class="col-md-12">
        <ul class="breadcrumbs-alt">
            <li>
                <a href="<?= Router::url('Usuarios/painel')?>">Home</a>
            </li>
            <li>
                <a class="active-trail active" href="<?= Router::url('Usuarios/index')?>">Usuários</a>
            </li>
            <li>
                <a class="current" href="#">Suporte</a>
            </li>
        </ul>
    </div>
</div>
<div class="panel">
    <div class="panel-heading">
        Suporte Agentus
    </div>
    
    <div class="panel-body">
        <form id="UsuarioSuporteForm" action="<?= Router::url('Usuarios/suporte')?>" method="POST" accept-charset="UTF-8">
            <div class="col-md-12">
                <h3>Formulário de suporte ao usuário.</h3>
                <hr>
                <div class="col-md-6 form-group">
                    <small>Assunto do E-mail: <span class="text text-danger">*</span></small>
                    <select name="Usuario[assunto]" class="form-control">
                        <option value=""> -- Tipo de suporte -- </option>
                        <option value="Alerta sobre erro no sistema"> -- Alerta sobre erro no sistema -- </option>
						<option value="Financeiro"> -- Financeiro -- </option>
						<option value="Opnião para aperfeiçoamento"> -- Opnião para aperfeiçoamento -- </option>
						<option value="Sua conta"> -- Sua conta -- </option>
                    </select>

                </div>
                <div class="clearfix"></div>
            </div> 

            <div class="clearfix"></div>
			<div class="col-md-12">
                            <div class="col-md-12 col-xs-12 col-lg-6">
                                <small>Sua mensagem: <span class="text text-danger">*</span></small>
                                <textarea name="Usuario[mensagem]" class="form-control"  style="height:100px;" placeholder="Deixe sua mensagem e logo retornaremos"></textarea>
                            </div>
				
				<div class="clearfix"></div>
	            <div class="col-md-6" style="margin-top:20px;">
	                <div class="form-group">
	                    <button class="btn btn-primary">Enviar E-mail</button>
	                </div>    
	            </div>
			</div>
            
        </form>
        
    </div>
</div>




