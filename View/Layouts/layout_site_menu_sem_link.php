<!DOCTYPE html>
<html>
    <head>
        <meta charset="<?= $this->charset; ?>">
        <meta name="google-site-verification" content="twj4fiGGd-FvfYM3ksYunHmzSGDDcsfjLVO3_oaRtuQ" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="<?= $description?>">
        <meta name="author" content="FreelaPHP schuindt">
        <link rel="shortcut icon" href="<?= Router::url(array('View', 'webroot', 'img', 'icone.png')) ?>">

        <script>
            var web_root = '<?= Router::url() ?>';
        </script>

        <title><?= $title_layout; ?></title>

        <!--Core CSS -->
        <?php foreach ($this->css as $style): ?>
            <link href="<?= Router::url('View/webroot/site/') ?><?= $style ?>.css" rel="stylesheet">
        <?php endforeach; ?>
        <link href="<?= Router::url('View/webroot/css/custom') ?>.css" rel="stylesheet">
        
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


        <!-- Placed js at the end of the document so the pages load faster -->

        <!--Start of Zopim Live Chat Script-->
        <script type="text/javascript">
            window.$zopim || (function (d, s) {
                var z = $zopim = function (c) {
                    z._.push(c)
                }, $ = z.s =
                        d.createElement(s), e = d.getElementsByTagName(s)[0];
                z.set = function (o) {
                    z.set.
                            _.push(o)
                };
                z._ = [];
                z.set._ = [];
                $.async = !0;
                $.setAttribute("charset", "utf-8");
                $.src = "//v2.zopim.com/?3N5F2vIkL7Q5kmenGYwMOeRllv3EeaJN";
                z.t = +new Date;
                $.
                        type = "text/javascript";
                e.parentNode.insertBefore($, e)
            })(document, "script");
        </script>
        <!--End of Zopim Live Chat Script-->
        
    </head>

    <body>
<script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

            ga('create', 'UA-77302933-1', 'auto');
            ga('send', 'pageview');

          </script>

        <?= Router::element('header_not_menu' ); ?>



        	<div id="pi-all"><!-- - - - - - - - - - SECTION - - - - - - - - - -->

                    <?= $this->showView(); ?>
                    
                </div>

                <!-- - - - - - - - - - END SECTION - - - - - - - - - -->


        <?= Router::element('footer'); ?>


        <!--Core js-->
        <?php foreach ($this->js as $script): ?>
            <script src="<?= Router::url('View/webroot/site/') . $script ?>.js"></script>
        <?php endforeach; ?> 

    </body>
</html>
