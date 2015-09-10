<div class="row">

    <div class="col-md-10 col-md-offset-1">  
       <h3>Olá <?= ucwords($usuario['Usuario']['nome'])?></h3>
       <p>
           Alterar senha.
       </p>
       <hr>

       <form action="<?= $this->urlRoot();?>Usuarios/alterarSenha" accept-charset="utf-8" name="AlterarSenhaForm" id="AlterarSenhaForm" method="post" >
           <div class="form-group">
               <div class="col-md-6">
                   <small> Senha: <span class="text text-danger">*</span></small>
                   <input type="password" name="Usuario[senha]" class="form-control" placeholder="Digite sua Senha" >
               </div>
               <div class="clearfix"></div>
               <div class="col-md-6">
                   <small> Confirmação de senha: <span class="text text-danger">*</span></small>
                   <input type="password" name="Usuario[confirm_senha]" class="form-control" placeholder="Digite Confirmação de Senha" >
               </div>
               <div class="clearfix"></div>
               <div class="col-md-6" style="margin-top:10px; margin-bottom:20px;">
                   <button class="btn btn-primary">SALVAR NOVA SENHA</button>
               </div>
           </div>
       </form>
       <div class="clearfix"></div>
    </div>
    <br>
    <br>
</div>