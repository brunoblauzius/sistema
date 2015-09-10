<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Painel Administrativo | Usuario
            <small>usuário master</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= $this->urlRoot()?>Users/painel"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Usuario</a></li>
            <li class="active">Cadastro</li>
        </ol>
    </section>

    <!-- Main content -->
    <div class="content">
        
        <div class="row">
            <div class="col-md-12">
                <form method="post" class="" action="" accept-charset="UTF-8">
                    <div class="col-md-12">
                        <h3>Dados pessoais</h3>
                        <hr>
                        <div class="col-md-6 form-group">
                            <small>Nome <span class="text text-red">*</span></small>
                            <input name="data[Empresa][nome]" class="form-control" placeholder="Nome:" id="" value="">
                        </div>
						<div class="col-md-6 form-group">
                            <small>CPF <span class="text text-red">*</span></small>
                            <input name="data[Empresa][cpf]" class="form-control" placeholder="CPF:" id="" value="">
                        </div>  
						   
                    </div> 
                    <div class="col-md-12">
						<div class="col-md-6 form-group">
                            <small>Data de nascimento <span class="text text-red">*</span></small>
                            <input name="data[Empresa][data-nascimento]" class="form-control" placeholder="Data de nascimento:" id="" value="">
                        </div> 
                        <div class="col-md-6 form-group">
                            <small>Email <span class="text text-red">*</span></small>
                            <input name="data[Empresa][email]" class="form-control" placeholder="Email:" id="" value="">
                        </div> 
                    </div> 
                    <div class="col-md-12">
						<h3>Contato</h3>
                        <hr>
                        <div class="col-md-6 form-group">
                            <small>Telefone fixo <span class="text text-red">*</span></small>
                            <input name="data[Empresa][telefone]" class="form-control" placeholder="Telefone:" id="" value="">
                        </div>    
                        <div class="col-md-6 form-group">
                            <small>Celular <span class="text text-red">*</span></small>
                            <input name="data[Empresa][celular]" class="form-control" placeholder="Celular:" id="" value="">
                        </div>    
                    </div>
                    
                    
                    <div class="clearfix"></div>
                    <div class="col-md-12">
                        <h3>Endereço</h3>
                        <hr>
                            <div class="col-md-12">
                                <div class="col-md-4 form-group">
                                    <small>CEP <span class="text text-red">*</span></small>
                                    <input name="data[Endereco][cep]" class="form-control" placeholder="CEP:" id="" value="">
                                </div>    
                                <div class="col-md-4 form-group">
                                    <small>Logradouro <span class="text text-red">*</span></small>
                                    <input name="data[Endereco][logradouro]" class="form-control" placeholder="Logradouro:" id="" value="">
                                </div> 
                                <div class="col-md-4 form-group">
                                    <small>Bairro <span class="text text-red">*</span></small>
                                    <input name="data[Endereco][bairro]" class="form-control" placeholder="Bairro:" id="" value="">
                                </div> 
                            </div> 
                            <div class="col-md-12">
                                <div class="col-md-4 form-group">
                                    <small>Cidade <span class="text text-red">*</span></small>
                                    <input name="data[Endereco][cidade]" class="form-control" placeholder="Cidade:" id="" value="">
                                </div>    
                                <div class="col-md-4 form-group">
                                    <small>Estado <span class="text text-red">*</span></small>
                                    <input name="data[Endereco][uf]" class="form-control" placeholder="UF:" id="" value="">
                                </div> 
                                <div class="col-md-4 form-group">
                                    <small>Número <span class="text text-red">*</span></small>
                                    <input name="data[Endereco][numero]" class="form-control" placeholder="Número:" id="" value="">
                                </div> 
                            </div> 
                    </div>
					
					
					
					<div class="clearfix"></div>
                    <div class="col-md-12">
                        <h3>Conta</h3>
                        <hr>
                            <div class="col-md-12">
                                <div class="col-md-4 form-group">
                                    <small>Usuário <span class="text text-red">*</span></small>
                                    <input name="data[Endereco][usuario]" class="form-control" placeholder="Usuario:" id="" value="">
                                </div>    
                                <div class="col-md-4 form-group">
                                    <small>Senha <span class="text text-red">*</span></small>
                                    <input name="data[Endereco][senha]" class="form-control" placeholder="Senha:" id="" value="">
                                </div> 
                                <div class="col-md-4 form-group">
                                    <small>Confirmação de senha <span class="text text-red">*</span></small>
                                    <input name="data[Endereco][confirm-senha]" class="form-control" placeholder="Confirmação de senha:" id="" value="">
                                </div> 
                            </div> 
                    </div>
                    
                </form>
            </div>
        </div>
        
    </div><!-- /.content -->
</aside><!-- /.right-side -->
