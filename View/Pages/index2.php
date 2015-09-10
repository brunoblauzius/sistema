<!-- descricao -->

<!-- formulario -->
<div class="col-md-6 col-md-offset-3">

	<h2 class="col-lg-11"> Cadastre-se e experimente por 15 dias totalmente grátis.</h2>

    <form class="" action="<?= Router::url(array('Pessoas', 'add'))?>" id="PessoaAddForm" method="post" accept-charset="utf-8">
    
    <div class=" col-md-12 pull-right" >
        <h2 class="">Registre-se agora</h2>
        
        <p>Entre com suas informações pessoais</p>
        
        <div class="form-group">
            <select name="Pessoa[tipo_pessoa]" class="form-control" id="tipo_pessoa">
                <option value="2">Pessoa Juridica</option>
                <option value="1">Pessoa Física</option>
            </select>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="Pessoa[nome]" placeholder="Nome" autofocus>
        </div>
        
        <!-- PESSOA FISICA -->
        <div id="pessoa-fisica" style="display: none;">
            <div class="form-group">
                <input type="text" class="form-control cpf" id="cpf" name="Fisica[cpf]" placeholder="CPF" autofocus>
            </div>
        </div>
        <!-- FIM -->
        <!-- PESSOA JURIDICA -->
        <div id="pessoa-juridica">
            <div class="form-group">
                <input type="text" class="form-control" name="Juridica[razao]" placeholder="Razão social" autofocus>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="Juridica[fantasia]" placeholder="Nome Fantasia" autofocus>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="Juridica[ie]" placeholder="Inscrição Estadual" autofocus>
            </div>
            <div class="form-group">
                <input type="text" class="form-control cnpj" id="cnpj" name="Juridica[cnpj]" placeholder="CNPJ" autofocus>
            </div>
        </div>
        <!-- FIM -->
        
        <div class="form-group">
            <input type="text" class="form-control" name="Pessoa[email]" placeholder="E-mail" autofocus>
        </div>
        
        <p> Detalhes da sua conta</p>
        <div class="form-group">
            <input type="password" class="form-control" name="Pessoa[senha]" placeholder="Senha">
        </div>
        <div class="form-group">
            <input type="password" class="form-control" name="Pessoa[confirm_senha]" placeholder="Confimação de senha">
        </div>
        <div class="form-group">
            <label>
                <input type="hidden"    name="Pessoa[termo]" value="0">
                <input type="checkbox"  name="Pessoa[termo]" value="1"> Veja o <a href="#">Termo de condição</a>
            </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Cadastrar</button>

        <div class="registration">
            Já sou cadastrado!
            <a class="" href="<?= $this->urlRoot()?>Pages/login">
                Login
            </a>
        </div>

    </div>
</form>
</div>
