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
                        <img src="http://mynight.com.br/ws/ServidorDeEmails/View/webroot/image/logo-base.png" height="70" style="margin-right:30px; vertical-align: middle"> <h3 style="color:#FFF; font-size:26px; float: right"> Contato do Site </h3>
                    </td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="padding: 20px;">
                        
                        <h4 style="color:#fc9448">Olá Administrador,</h4>
                        <p style="text-align: justify; font-size:13px;">
                            Segue abaixo as informações do contato do site, de <strong><?= $nome?></strong> no dia <strong><?= date('d/m/Y')?></strong> às <strong><?= date('H:i')?></strong> hrs.
                        </p>
                        
                        <div style="background-color:#f9f9f9; padding:10px; font-size:13px;">
                            <table style="width:100%;" cellpadding="3">
                                <tbody>
                                    <tr>
                                        <td style="width:30%">Nome:</td>
                                        <td><strong><?= $nome?></strong></td>
                                    </tr>
                                    <tr>
                                        <td style="width:30%">Assunto:</td>
                                        <td><strong><?= $assunto?></strong></td>
                                    </tr>
                                    <tr>
                                        <td>E-mail:</td>
                                        <td><strong><?= $email?></strong></td>
                                    </tr>
                                    <tr>
                                        <td>Telefone:</td>
                                        <td><strong><?= $ddd?>. <?= $telefone?></strong></td>
                                    </tr>
                                    <tr>
                                        <td>Mensagem:</td>
                                        <td><strong><?= $mensagem?></strong></td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2">
                                            
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
                        <img src="http://mynight.com.br/ws/ServidorDeEmails/View/webroot/image/logo-base.png" height="50" style="margin-right:15px; vertical-align: middle"> © 2015. <span style="color:#fc9448">Sistema de reservas My Night</span>. Todos os direitos reservados.
                    </td>
                </tr>
            </tfoot>
        </table>
        
        
    </body>
</html>
