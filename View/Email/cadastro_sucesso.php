<h3>Cadastro Usuário</h3>
<hr>
<p>
    Para efetivar seu cadastro clique no link e ative sua conta de usuário...
</p>
<a href="<?= $url?>Pages/ativarConta/<?= $usuario['chave']?>"> Clique aqui para ativar sua conta</a>
<?php //print_r($usuario);?>

<h4>Login:</h4>
<strong><?= $usuario['email']?></strong>
<h4>Senha:</h4>
<strong><?= $usuario['senha']?></strong>

<br>
<br>
Equipe da jopacs agradece!<br>
<br>
<br>
<small>Obs. não responder este e-mail</small>