<h3>Recuperar Senha</h3>
<hr>
<p>
    Para efetivar sua alteração de senha clique no link e cadestre a nova senha de usuário
</p>
<a href="<?= $url?>Pages/recuperarSenha/<?= $usuario['chave']?>"> Clique aqui para recuperar a senha</a>
<?php //print_r($usuario);?>

<h4>Email:</h4>
<strong><?= $usuario['email']?></strong>
<h4>Nome usuário:</h4>
<strong><?= $usuario['nome']?></strong>

<br>
<br>
Equipe da jopacs agradece!<br>
<br>
<br>
<small>Obs. não responder este e-mail</small>