<!DOCTYPE html>
<html>
    <head>
        <meta charset="<?= $this->charset; ?>">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Sistema de gestão financeira para pequenas empresas e autonomos...">
        <meta name="author" content="bruno blauzius schuindt">
        <link rel="shortcut icon" href="<?= Router::url(array('View', 'webroot', 'img', 'icone.png')) ?>">

        <script>
            var web_root = '<?= Router::url() ?>';
            var empresas_id = '<?= Session::read('Empresa.empresas_id')?>';
            var roles_id    = '<?= Session::read('Usuario.roles_id')?>';
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

        <!--Start of Zopim Live Chat Script-->
        <script type="text/javascript">
        window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
        d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
        _.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute("charset","utf-8");
        $.src="//v2.zopim.com/?3N5F2vIkL7Q5kmenGYwMOeRllv3EeaJN";z.t=+new Date;$.
        type="text/javascript";e.parentNode.insertBefore($,e)})(document,"script");
        </script>
        <!--End of Zopim Live Chat Script-->
    </head>

    <body>
        

        
        
        <div id="loading">
            <div id="loading-center">
                <div id="loading-center-absolute">
                    <div class="object" id="object_one"></div>
                    <div class="object" id="object_two"></div>
                    <div class="object" id="object_three"></div>
                    <div class="object" id="object_four"></div>
                </div>
            </div>
        </div>

        <section id="container" >
            <!--header start-->
            <header class="header fixed-top clearfix">
                <!--logo start-->
                <div class="brand">

                    <a href="<?= Router::url('Usuarios/painel') ?>" class="logo">
                        <img src="<?= Router::url('View/webroot/images/logo.png') ?>" alt="" style="width:80%">
                    </a>
                    <div class="sidebar-toggle-box">
                        <div class="fa fa-bars"></div>
                    </div>
                </div>
                <!--logo end-->

                <div class="nav notify-row" id="top_menu">
                    <!--  notification start -->
                    <ul class="nav top-menu">


                        <!-- notification dropdown start-->
                        <!--li id="header_notification_bar" class="dropdown">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                
                                <i class="fa fa-bell-o"></i>
                                <span class="badge bg-warning">3</span>
                            </a>
                            <ul class="dropdown-menu extended notification">
                                <li>
                                    <p>Notifications</p>
                                </li>
                                <li>
                                    <div class="alert alert-info clearfix">
                                        <span class="alert-icon"><i class="fa fa-bolt"></i></span>
                                        <div class="noti-info">
                                            <a href="#"> Server #1 overloaded.</a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="alert alert-danger clearfix">
                                        <span class="alert-icon"><i class="fa fa-bolt"></i></span>
                                        <div class="noti-info">
                                            <a href="#"> Server #2 overloaded.</a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="alert alert-success clearfix">
                                        <span class="alert-icon"><i class="fa fa-bolt"></i></span>
                                        <div class="noti-info">
                                            <a href="#"> Server #3 overloaded.</a>
                                        </div>
                                    </div>
                                </li>
                
                            </ul>
                        </li-->
                        <!-- notification dropdown end -->
                        

                    </ul>
                    <!--  notification end -->
                </div>
                <div class="top-nav clearfix">
                    <!--search & user info start-->
                    
                    <ul class="nav pull-right top-menu">
                        <li>
                            <?php if (!empty($empresasRelacionadas)): ?>
                                <select class="form-control round-input input-sm" id="SelectEmpresa">
                                    <?php if (!Session::check('Empresa')): ?>
                                        <option value=""> -- selecione uma empresa -- </option>
                                    <?php endif; ?>

                                    <?php foreach ($empresasRelacionadas as $empresa): ?>
                                        <?php if (Session::read('Empresa.empresas_id') == $empresa['empresas_id']): ?>
                                            <option selected="selected" value="<?= $empresa['empresas_id'] ?>"> <?= $empresa['nome_fantasia'] ?></option>
                                        <?php else: ?>
                                            <option value="<?= $empresa['empresas_id'] ?>"> <?= $empresa['nome_fantasia'] ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            <?php endif; ?>

                        </li>
                        <!-- user login dropdown start-->
                        <li class="dropdown">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <?php if (isset($_SESSION['Usuario']['imagem_perfil'])): ?>
                                    <img alt="" src="<?= Router::url('View/webroot/img/thumb/' . Session::read('Usuario.imagem_perfil')) ?>">
                                <?php else: ?>
                                    <img alt="" src="<?= Router::url('View/webroot/img/no-image.jpg') ?>">
                                <?php endif; ?>
                                    <span class="username"><?= Session::read('Usuario.nome') ?> - <strong class="text text-primary"><?= Session::read('Usuario.nivel_usuario') ?></strong></span>
                                <b class="caret"></b>
                            </a>

                            <ul class="dropdown-menu extended logout">
                                <!--<li><a href="#"><i class=" fa fa-suitcase"></i>Profile</a></li>-->
                                <?php if (in_array(Session::read('Usuario.roles_id'), array(3, 4))): ?>
                                    <li><a href="<?= Router::url(array('Usuarios', 'configuracoes')) ?>"><i class="fa fa-cog"></i>Config. Empresa</a></li>
                                <?php endif; ?>
                                <li><a href="<?= Router::url('Usuarios/mudarSenha') ?>"><i class="fa fa-key"></i> Alterar Senha</a></li>
                                <li><a href="<?= Router::url('Usuarios/editar') ?>"><i class="fa fa-user"></i> Config. Usuário</a></li>
                                <li><a href="<?= Router::url(array('Usuarios', 'logout')) ?>"><i class="fa fa-power-off"></i> Sair</a></li>
                                <div class="divider"></div>
                                <li><a style="font-size:10px;" class="text text-success">Versao do sistema 1.0</a></li>
                            </ul>

                        </li>
                        <!-- user login dropdown end -->
                    </ul>
                    <!--search & user info end-->
                </div>
            </header>
            <!--header end-->
            <aside>
                <div id="sidebar" class="nav-collapse">
                    <!-- sidebar menu start-->            
                    <div class="leftside-navigation">
                        <ul class="sidebar-menu" id="nav-accordion">
                            <?php if (Session::check('Empresa')): ?>
                                <li style="padding-top:0px; margin-bottom:15px; border-bottom:none">
                                    <div class="" >
                                        <div class="">
                                            <div class="col-sm-5">
                                                <?php if ((Session::read('Usuario.roles_id') != 5)): ?>
                                                    <?php if (Session::check('Empresa') && (Session::read('Empresa.logo') != NULL)): ?>
                                                        <img src="<?= Router::url(array('View/webroot/img/logos', Session::read('Empresa.logo'))) ?>" class="" style="width:70px; "/>
                                                    <?php else: ?>
                                                        <img src="<?= Router::url(array('View/webroot/img/no-image.jpg')) ?>" class="img-thumbnail" style="width:80px; "/>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </div>
                                            <div class="col-sm-7" style="color:#CCC;">
                                                <small>Nome Fantasia:</small><br>
                                                <strong class="text text-warning"> <?= Session::read('Empresa.nome_fantasia') ?> </strong>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </li>
                            <?php endif; ?>
                            <li><a href="<?= Router::url('Usuarios/painel') ?>"><i class="fa fa-home"></i> Página Inicial </a></li>

                            <?php
                            $lista = $this->createListMenu();
                            foreach ($lista as $menu) :
                                ?>
                                <li class="sub-menu">
                                    <a href="javascript:;">
                                        <!--<i class="fa fa-users"></i>-->
                                        <span><i class="fa <?= $menu['icon']?>"></i> <?= ucfirst($menu['link_name']) ?></span>
                                    </a>
                                    <ul class="sub">
                                        <?php foreach ($menu['links'] as $subMenu): ?>
                                        <li><a href="<?= Router::url($menu['controller'] . '/' . $subMenu['action']) ?>"><i class="fa fa-circle" style="font-size:10px;"></i> <?= $subMenu['nome_link'] ?></a></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </li>
                            <?php endforeach; ?>

                            <?php //if( Session::read('Usuario.roles_id') == 3 ):?>
    <!-- li><a href="<?= Router::url('Carrinhos/index') ?>"><i class="fa fa-bar-chart-o"></i> Minha Conta </a></li-->
                            <?php //endif; ?>
                            <?php if (in_array(Session::read('Usuario.roles_id'), array(2, 3, 4))): ?>
                                <li><a href="<?= Router::url('Usuarios/suporte') ?>"><i class="fa fa-comments "></i> Suporte </a></li>
                            <?php endif; ?>

                        </ul>
                    </div>        
                    <!-- sidebar menu end-->
                </div>
            </aside>
            <!--sidebar end-->
            <!--main content start-->
            <section id="main-content">
                <section class="wrapper">
                    <!-- page start-->

                    <div class="row">
                        <div class="col-sm-12">

                            <!-- show conteudo -->
                            <?= $this->showView(); ?>
                            <!-- Modal -->
                            <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content" id="modal-content">




                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- page end-->
                </section>
            </section>
            <!--main content end-->

        </section>
        <script src="<?= $this->urlRoot() ?>View/webroot/js/external-dragging-calendar.js"></script>


    </body>
</html>
