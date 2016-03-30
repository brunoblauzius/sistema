<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Teste</title>
    </head>
    <body style="font-family: Arial; font-size:14px;">
        
        <table style="margin:auto; width:600px;">
            <thead style="background-color:#303030; color:#f7f7f7;">
                <tr>
                    <td  style="padding: 10px;">
                        <img src="http://mynight.com.br/ws/View/webroot/image/logo-base.png" height="70" style="margin-right:30px; vertical-align: middle"> <h3 style="color:#FFF; font-size:26px; float: right"> Cadastro de Empresa</h3>
                    </td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="padding: 20px;">
                        
                        <h4 style="color:#fc9448">Olá <?= ucwords($nome)?>,</h4>
                        <p style="text-align: justify; font-size:13px;">
                            Sua empresa foi cadastrada com sucesso em nosso sistema de reservas para casas noturnas, bares e restaurantes!
                        </p>
                        
                        <div style="background-color:#f9f9f9; padding:10px; font-size:13px;">
                            <table style="width:100%;" cellpadding="3">
                                <tbody>
                                    <tr>
                                        <td colspan="2"><h2 style="color:#fc9448; text-align: center">Dados do cadastro.</h2></td>
                                    </tr>
                                    <tr>
                                        <td style="width:40%">Titular da conta:</td>
                                        <td><strong><?= ucwords($nome)?></strong></td>
                                    </tr>
                                    <tr>
                                        <td>Telefone do titular:</td>
                                        <td><strong><?= $ddd?> <?= $telefone?></strong></td>
                                    </tr>
                                    <tr>
                                        <td>E-mail do titular:</td>
                                        <td><strong><?= $email?></strong></td>
                                    </tr>
                                    <tr>
                                        <td>Nome do Estabelecimento:</td>
                                        <td><strong><?= $fantasia?></strong></td>
                                    </tr>
                                    <tr>
                                        <td>Endereço do Estabelecimento:</td>
                                        <td><strong><?= $cep?> - <?= $logradouro?>, <?= $bairro?>, <?= $cidade?>, <?= $uf?></strong></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align: center; height: 80px;">
                                            <a href="#" style="background-color:#fc9448; text-decoration: none; color:#fff; padding:10px; border-radius:5px; ">
                                                Clique aqui para ativar seu cadastro
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2">
                                            <div style="font-size:12px; margin-top:20px;">
                                                
                                            </div>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr style="background-color:#303030; color:#f7f7f7;">
                    <td style="padding: 10px; text-align:center" >
                        <img src="http://mynight.com.br/ws/View/webroot/image/logo-base.png" height="50" style="margin-right:15px; vertical-align: middle"> © 2015. <span style="color:#fc9448">Sistema de reservas My Night</span>. Todos os direitos reservados.
                    </td>
                </tr>
            </tfoot>
        </table>
        
        
    </body>
</html>
