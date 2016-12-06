<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Actividades Culturales</title>
        <link rel="icon" type="image/png" href="<?php echo base_url(); ?>images/favicon.png" />
        <link type="text/css" href="<?php echo base_url(); ?>css/bootstrap.css" rel="stylesheet" media="screen"/>
        <link type="text/css" href="<?php echo base_url(); ?>css/bootstrap-responsive.css" rel="stylesheet" media="screen"/>
        <link type="text/css" href="<?php echo base_url(); ?>css/bootstrap-multiselect.css" rel="stylesheet" media="screen"/>
        <link type="text/css" href="<?php echo base_url(); ?>css/prettify.css" rel="stylesheet" media="screen"/>
        <link type="text/css" href="<?php echo base_url(); ?>css/default.css" rel="stylesheet" media="screen"/>
        <link type="text/css" href="<?php echo base_url(); ?>css/jquery-ui-1.10.4.custom.min.css" rel="stylesheet" media="screen"/>
        <link type="text/css" href="<?php echo base_url(); ?>css/jquery.qtip.min.css" rel="stylesheet" media="screen"/>
        <link type="text/css" href="<?php echo base_url(); ?>css/fullcalendar.css" rel="stylesheet" media="screen"/>
        <link type="text/css" href="<?php echo base_url(); ?>css/fullcalendar.print.css" rel="stylesheet" media="print"/>
        <link type="text/css" href="<?php echo base_url(); ?>css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen"/>
        <link type="text/css" href="<?php echo base_url(); ?>css/jquery-ui-timepicker-addon.css" rel="stylesheet" media="screen"/>
        <link type="text/css" href="<?php echo base_url(); ?>css/jquery.dataTables.min.css" rel="stylesheet" media="screen"/>
        <link type="text/css" href="<?php echo base_url(); ?>css/jquery.dataTables_themeroller.min.css" rel="stylesheet" media="screen"/>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/jquery-ui-1.10.3.custom.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/jquery.ui.touch-punch.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/jquery-ui-sliderAccess.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/noty/packaged/jquery.noty.packaged.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/jquery-ui-sliderAccess.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/jquery.md5.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/bootstrap.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/bootstrap-multiselect.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/moment-with-langs.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/bootstrap-datetimepicker.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/prettify.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/typeahead.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/fullcalendar.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/jquery.qtip.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/jquery.countDown.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/comun.js"></script>
        <?php
        if (isset($js)) {
            if (is_array($js)) {
                foreach ($js as $j) {
                    ?>
                    <script type="text/javascript" src="<?php echo base_url() . $j; ?>"></script>
                    <?php
                }
            } else {
                ?>
                <script type="text/javascript" src="<?php echo base_url() . $js; ?>"></script>
                <?php
            }
        }
        ?>
        <script type="text/javascript">
            var base_url = "<?php echo base_url(); ?>";
            var usuario_data = {
                user: "<?php echo (get_user()) ? get_user() : ''; ?>",
                name: "<?php echo (get_name()) ? get_name() : ''; ?>",
                type: "<?php echo get_type() ?>"
            };
            var date = new Date("<?php echo date("F d, Y H:i:s"); ?>");
            setInterval(function(){ 
                date.setSeconds(date.getSeconds() + 1);
                $('#hora_sistema .hora').text(( '0' + date.getHours()).slice(-2));
                $('#hora_sistema .minutos').text(('0' + date.getMinutes()).slice(-2));
                $('#hora_sistema .segundos').text(( '0' + date.getSeconds()).slice(-2));    
            }, 1000);
        </script>
    </head>
    <body cz-shortcut-listen="true">
        <div class="container" id="content_main">
            <div class="row images-header">
                <img src="<?php echo base_url() ?>images/logo.png"/>
                <img src="<?php echo base_url() ?>images/logo1.jpg"/>
            </div>
            <div class="row">
                <nav class="navbar navbar-default" role="navigation">
                    <!-- El logotipo y el icono que despliega el menú se agrupan
               para mostrarlos mejor en los dispositivos móviles -->
                    <div class="navbar-header">
                        <a class="navbar-brand" href="<?php echo base_url() ?>inicio.jsp">Extensi&oacute;n Universitaria - FES Arag&oacute;n <strong id="hora_sistema"><span class="hora"><?php echo date('H');?></span>:<span class="minutos"><?php echo date('i');?></span>:<span class="segundos"><?php echo date('s');?></span></strong></a>
                    </div>
                    <!-- Agrupar los enlaces de navegación, los formularios y cualquier
                         otro elemento que se pueda ocultar al minimizar la barra -->
                    <div id="nav_bar_div">
                    </div>
                </nav>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div id="container">