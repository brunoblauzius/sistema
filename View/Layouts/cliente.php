<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="esta pagina é direcionada ao cliente">
    <meta name="author" content="Bruno Blauzius Schuindt">
    <link rel="shortcut icon" href="images/favicon.png">

    <title><?= $title_layout?></title>

    <link rel="shortcut icon" href="<?= Router::url(array('View', 'webroot', 'img', 'icone.png')) ?>">

        <script>
            var web_root = '<?= Router::url() ?>';
        </script>

        <title><?= $title_layout; ?></title>

        <!--Core CSS -->
        <?php foreach ($this->css as $style): ?>
            <link href="<?= Router::url('View/webroot/') ?><?= $style ?>.css" rel="stylesheet">
        <?php endforeach; ?>

        <link href='<?= $this->urlRoot() ?>View/webroot/js/fullcalendar2.0/fullcalendar.print.css' rel='stylesheet' media='print' />

        <!-- <link rel="stylesheet" type="text/css" href="<?//= $this->urlRoot()?>View/webroot/js/bootstrap-datetimepicker/css/datetimepicker.css" /> -->
        <!-- Just for debugging purposes. Don't actually copy this line! -->
        <!--[if lt IE 9]>
        <script src="<?= $this->urlRoot() ?>View/webroot/js/ie8-responsive-file-warning.js"></script><![endif]-->

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->


        <!-- Placed js at the end of the document so the pages load faster -->

        <!--Core js-->
        <?php foreach ($this->js as $script): ?>
            <script src="<?= Router::url('View/webroot/') . $script ?>.js"></script>
        <?php endforeach; ?>    

        <script class="include" src="<?= $this->urlRoot() ?>View/webroot/js/jquery.dcjqaccordion.2.7.js"></script>

        
</head>

  <body class="full-width">

  <section id="container" class="hr-menu">
      <!--header start-->
      <header class="header fixed-top">
          <div class="navbar-header">
              <button type="button" class="navbar-toggle hr-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                  <span class="fa fa-bars"></span>
              </button>

              <!--logo start-->
              <!--logo start-->
              <div class="brand ">
                  <a href="" class="logo">
                        <img src="<?= Router::url('View/webroot/images/logo.png') ?>" alt="" style="width:80%">
                  </a>
              </div>
              <!--logo end-->
              <!--logo end-->
              <div class="horizontal-menu navbar-collapse collapse ">
                  <ul class="nav navbar-nav">
                      
                      <li class="active"><a href="#">Minha Reserva</a></li>
                      
                      <!--li class="dropdown">
                          <a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" href="#">Extra <b class=" fa fa-angle-down"></b></a>
                          <ul class="dropdown-menu">
                              <li><a href="blank.html">Blank Page</a></li>
                              <li><a href="boxed_page.html">Boxed Page</a></li>
                              <li><a href="profile.html">Profile</a></li>
                              <li><a href="404.html">404 Error Page</a></li>
                              <li><a href="500.html">500 Error Page</a></li>
                          </ul>
                      </li-->
                  </ul>

              </div>
              <div class="top-nav hr-top-nav">
                  <ul class="nav pull-right top-menu">
                      
                      <!-- user login dropdown start-->
                      <li class="dropdown">
                          <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                              <img alt="" src="<?= Router::url('View/webroot/img/no-image.jpg') ?>">
                              <span class="username"><?= $cliente['Cliente']['nome']?></span>
                              <b class="caret"></b>
                          </a>
                          <!--ul class="dropdown-menu extended logout">
                              <li><a href="#"><i class=" fa fa-suitcase"></i>Profile</a></li>
                              <li><a href="#"><i class="fa fa-cog"></i> Settings</a></li>
                              <li><a href="#"><i class="fa fa-bell-o"></i> Notification</a></li>
                              <li><a href="login.html"><i class="fa fa-key"></i> Log Out</a></li>
                          </ul-->
                      </li>
                      <!-- user login dropdown end -->
                  </ul>
              </div>

          </div>

      </header>
      <!--header end-->
      <!--sidebar start-->

      <!--sidebar end-->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper">
              <!-- page start-->
              <!-- show conteudo -->
                <?= $this->showView(); ?>
              <!-- page end-->
          </section>
      </section>
      <!--main content end-->
      <!--footer start-->
      <footer class="footer-section">
          <div class="text-center">
              2015 &copy; sistema de reservas - MYNIGHT
          </div>
      </footer>
      <!--footer end-->
  </section>

  <!-- Placed js at the end of the document so the pages load faster -->

  <!--Core js-->
  
  <script src="<?= $this->urlRoot() ?>View/webroot/js/hover-dropdown.js"></script>
  <script src="<?= $this->urlRoot() ?>View/webroot/js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js"></script>
  <script src="<?= $this->urlRoot() ?>View/webroot/js/jquery.nicescroll.js"></script>
  <script src="<?= $this->urlRoot() ?>View/webroot/js/external-dragging-calendar.js"></script>
  

  </body>
</html>
