<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="<?= $this->charset;?>">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="bruno blauzius schuindt">
    <link rel="shortcut icon" href="<?= Router::url(array('View', 'webroot', 'img', 'icone.png'))?>">

    <title><?= $title_layout?></title>

    <!--Core CSS -->
    <link href="<?= $this->urlRoot()?>View/webroot/bs3/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= $this->urlRoot()?>View/webroot/css/bootstrap-reset.css" rel="stylesheet">
	<link href="<?= $this->urlRoot()?>View/webroot/css/blue-theme.css" rel="stylesheet">
    <link href="<?= $this->urlRoot()?>View/webroot/font-awesome/css/font-awesome.css" rel="stylesheet" />

    <!-- Custom styles for this template -->
    <link href="<?= $this->urlRoot()?>View/webroot/css/style.css" rel="stylesheet">
    <link href="<?= $this->urlRoot()?>View/webroot/css/style-responsive.css" rel="stylesheet" />

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]>
    <script src="<?= $this->urlRoot()?>View/webroot/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    
    
    <!--Core js-->
    <script src="<?= $this->urlRoot()?>View/webroot/js/jquery.js"></script>
    <script src="<?= $this->urlRoot()?>View/webroot/js/ajaxForm.js"></script>
    <script src="<?= $this->urlRoot()?>View/webroot/bs3/js/bootstrap.min.js"></script>
    <script src='<?= $this->urlRoot()?>View/webroot/js/fullcalendar2.0/lib/moment.min.js'></script>
    <script src='<?= $this->urlRoot()?>View/webroot/js/datatimepicker2.0/bootstrap-datetimepicker.min.js'></script>
    <script>
        
        var web_root = '<?= Router::url() ?>';
        
        $(document).ready(function () {
            
            $('#tipo_pessoa').change(function(){
                var valor = $(this).val();
                if( valor == 1 ){
                    $('#pessoa-fisica').show();
                    $('#pessoa-juridica').hide();
                } else {
                    $('#pessoa-fisica').hide();
                    $('#pessoa-juridica').show();
                }
            });
        });
    </script> 
    
    <script src="<?= $this->urlRoot()?>View/webroot/js/jquery.mask.min.js"></script>
    <script src="<?= $this->urlRoot()?>View/webroot/js/calendar/clndr.js"></script>
    <script src="<?= $this->urlRoot()?>View/webroot/js/calendar/moment-2.2.1.js"></script>
    <script src="<?= $this->urlRoot()?>View/webroot/js/evnt.calendar.init.js"></script>
    <script src="<?= $this->urlRoot()?>View/webroot/js/dashboard.js"></script>
    <script src="<?= $this->urlRoot()?>View/webroot/js/scripts.js"></script>
    <script src="<?= $this->urlRoot()?>View/webroot/js/funcoes.js"></script>
    
    
    
</head>
  <body class="">

    <div class="container">

      <!-- show conteudo -->
      <?= $this->showView(); ?>

    </div>
    
    

    <!-- Placed js at the end of the document so the pages load faster -->

    
  </body>
</html>