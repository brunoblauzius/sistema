<div class="row">
    <div class="col-md-12">
        <ul class="breadcrumbs-alt">
            <li>
                <a href="<?= $this->urlRoot()?>Usuarios/painel">Home</a>
            </li>
            <li>
                <a class="active-trail active" href="<?= $this->urlRoot()?>Usuarios/index">Usuários</a>
            </li>
            <li>
                <a class="current" href="#">Cadastro</a>
            </li>
        </ul>
    </div>
</div>
<div class="panel">
    <div class="panel-heading">
        Usuário Cadastro
    </div>
    
    <div class="panel-body">
        <form id="UsuarioAddForm" action="<?= $this->urlRoot()?>Usuarios/add" method="POST" accept-charset="UTF-8">
            <div class="col-md-12">
                <h3>Dados pessoais</h3>
                <hr>
                <div class="col-md-6 form-group">
                    <small>Tipo de Usuário <span class="text text-danger">*</span></small>
                    <select name="Usuario[roles_id]" class="form-control">
                        <option value=""> -- Tipo de usuário -- </option>
                        <?php foreach($niveis as $nivel ):?>
                            <option value="<?= $nivel['Grupo']['id']?>"> <?= strtoupper($nivel['Grupo']['nome'])?> </option>
                        <?php endforeach;?>
                    </select>

                </div>
                <div class="clearfix"></div>
                <div class="col-md-6 form-group">
                    <small>Nome <span class="text text-danger">*</span></small>
                    <input name="Fisica[nome]" class="form-control " placeholder="Nome:" id="" value="">
                </div>
                
                <div class="clearfix"></div>
                <div class="col-md-6 form-group">
                    <small>CPF <span class="text text-danger">*</span></small>
                    <input name="Fisica[cpf]" class="form-control cpf" placeholder="CPF:" id="" value="">
                </div>
            </div> 
            <div class="col-md-12">
                <div class="col-md-6 form-group">
                    <small>Email <span class="text text-danger"></span></small>
                    <input name="Email[email]" class="form-control" placeholder="Email:" id="" value="">
                </div> 
            </div>

            <div class="clearfix"></div>
            <div class="col-md-12">
                <h3>Acesso a conta.</h3>
                <hr>
                <div class="col-md-4 form-group">
                    <small>Login <span class="text text-danger">*</span></small>
                    <input type="text" name="Usuario[login]" class="form-control" placeholder="Login de usuário:" id="" value="">
                </div>      
                <div class="clearfix"></div>
                <div class="col-md-4 form-group">
                    <small>Senha <span class="text text-danger">*</span></small>
                    <input type="password" name="Usuario[senha]" class="form-control" placeholder="Senha:" id="" value="">
                </div> 
                <div class="col-md-4 form-group">
                    <small>Confirmação de senha <span class="text text-danger">*</span></small>
                    <input type="password" name="Usuario[confirm_senha]" class="form-control" placeholder="Confirmação de senha:" id="" value="">
                </div> 
            </div>

            <div class="clearfix"></div>
            <div class="col-md-6">
                <div class="form-group">
                    <button class="btn btn-primary">Cadastrar</button>
                </div>    
            </div>
        </form>
        
    </div>
</div>




