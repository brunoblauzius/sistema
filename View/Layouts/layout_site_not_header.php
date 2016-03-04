<!DOCTYPE html>
<html>
    <head>
        <meta charset="<?= $this->charset; ?>">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Sistemas de reservas para bares, restaurantes e casas noturnas">
        <meta name="author" content="bruno blauzius schuindt">
        <link rel="shortcut icon" href="<?= Router::url(array('View', 'webroot', 'img', 'icone.png')) ?>">

        <script>
            var web_root = '<?= Router::url() ?>';
        </script>

        <title><?= $title_layout; ?></title>

        <!--Core CSS -->
        <?php foreach ($this->css as $style): ?>
            <link href="<?= Router::url('View/webroot/site/') ?><?= $style ?>.css" rel="stylesheet">
        <?php endforeach; ?>

        <!--Fonts-->
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&amp;subset=latin,cyrillic' rel='stylesheet' type='text/css'/>

        <!-- Just for debugging purposes. Don't actually copy this line! -->
        <!--[if lt IE 9]>
        <script src="<?= $this->urlRoot() ?>View/webroot/js/ie8-responsive-file-warning.js"></script><![endif]-->

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        
    </head>

    <body>


        <?//= Router::element('header_not_menu'); ?>



        	<div id="pi-all"><!-- - - - - - - - - - SECTION - - - - - - - - - -->

                    <?= $this->showView(); ?>
                    
                </div>

                <!-- - - - - - - - - - END SECTION - - - - - - - - - -->


        <?= Router::element('footer'); ?>


        <!--Core js-->
        <?php foreach ($this->js as $script): ?>
            <script src="<?= Router::url('View/webroot/site/') . $script ?>.js"></script>
        <?php endforeach; ?> 
            
            <script src="<?= Router::url('View/webroot/js/ajaxForm.js')?>"></script>
            <script src="<?= Router::url('View/webroot/js/funcoes.js')?>"></script>
            <script src="<?= Router::url('View/webroot/js/scripts.js')?>"></script>

    </body>
</html>
