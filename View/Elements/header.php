<!-- Header -->
<div class="pi-header">
    <div class="pi-header-sticky">
        <!-- Header row -->
        <div class="pi-section-w pi-section-dark pi-shadow-bottom pi-row-reducible">
            <div class="pi-section pi-row-lg " >
                <!-- Logo -->
                <div class="pi-row-block pi-row-block-logo">
                    <a href="<?= Router::url(); ?>"><img src="<?= Router::url('View/webroot/site/img/logo-base.png'); ?>" alt="Mynight sistemas de reservas" ></a>
                </div>
                <!-- End logo -->
                <!-- Text -->
                <div class="pi-row-block pi-row-block-txt pi-hidden-2xs"></div>
                <!-- End text -->
                <!-- Menu -->
                <div class="pi-row-block pi-pull-right">
                    <ul class="pi-simple-menu pi-has-hover-border pi-full-height pi-hidden-sm">

                        <li class="active"><a href="<?= Router::url(); ?>"><span>Início</span></a></li>
                        <li class=""><a href="<?= Router::url(array('Pages', 'quem-somos')); ?>"><span>Quem Somos</span></a></li>
                        <li class=""><a href="<?= Router::url(array('Pages', 'empresa')); ?>"><span>Empresa</span></a></li>
                        <li class=""><a href="<?= Router::url(array('Pages', 'cliente')); ?>"><span>Cliente</span></a></li>
                        <li class=""><a href="<?= Router::url(array('Pages', 'contato')); ?>"><span>Contato</span></a></li>

                    </ul>
                </div>
                <!-- End menu -->
            </div>
        </div>
    </div>
</div>
<!-- END Header -->
