<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <section style="width:600px; padding:10px; margin: auto; background-color: #e5fff9">
            <h3><?= $assunto?></h3>
            
            <p style="color: #00cc99;">
                <?php echo $nome?>
            </p>

            <p style=" color:#008060">
                <?php echo $email?>
            </p>

            <p style=" color:#008060">
                <?php echo nl2br($mensagem)?>
            </p>
            
            <p>
                <small><?php echo 'enviado em '.date('d/m/Y'). ' as ' . date('H:i:s'); ?></small>
            </p>
        </section>
    </body>
</html>
