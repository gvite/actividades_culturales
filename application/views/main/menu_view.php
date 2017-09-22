    <?php
    if (!isset($no_menu)) {
        if (!isset($active)) {
            $active = '';
        }
        ?>
        <li class="<?php echo ($active === 'inicio') ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>inicio" data-name="inicio"><span class="glyphicon glyphicon-home"></span> Inicio</a></li>
        <li class="<?php echo ($active === 'eventos') ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>eventos" data-name="eventos"><span class="glyphicon glyphicon-briefcase"></span> Eventos</a></li>
        <?php if(get_type() != 1){?>
        <li class="<?php echo ($active === 'talento') ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>talento" data-name="talento"><span class="glyphicon glyphicon-briefcase"></span> Talento Aragones</a></li>
        <?php }else{ ?>
            <li class="<?php echo ($active === 'talento') ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/talento" data-name="talento"><span class="glyphicon glyphicon-briefcase"></span> Talento Aragones</a></li>
        <?php } ?>
        <?php
        if (isset($semestre_actual) && $semestre_actual) {
            ?>
            <li class="<?php echo ($active === 'horarios') ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>horarios" data-name="horarios"><span class="glyphicon glyphicon-calendar"></span> Horarios</a></li>
            <?php
        }
        switch (get_type()) {
            case 1:
                ?>
            <li class="<?php echo ($active === 'actividades') ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/talleres" data-name="actividades"><span class="glyphicon glyphicon-book"></span> Registro de actividades</a></li>
                <?php if (isset($puede_inscribir) && !$puede_inscribir) { ?>
                <li class="<?php echo ($active === 'inscribir') ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/inscribir" data-name="inscribir"><span class="glyphicon glyphicon-pencil"></span> Inscripci&oacute;n</a></li>
                <?php } ?>
                <li class="<?php echo ($active === 'validacion') ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/validacion" data-name="validacion"><span class="glyphicon glyphicon-check"></span> Validaci&oacute;n</a></li>
                <li class="<?php echo ($active === 'listas') ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/listas" data-name="listas"><span class="glyphicon glyphicon-list"></span> Listas</a></li>
                <!--<li class="<?php echo ($active === 'alumnos') ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/alumnos" data-name="alumnos"><span class="glyphicon glyphicon-user"></span> Alumnos</a></li>-->
                <li class="<?php echo ($active === 'reportes') ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/reportes/carrera" data-name="reportes"><span class="glyphicon glyphicon-file"></span> Reportes</a></li>
                <li class="<?php echo ($active === 'sliders') ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/sliders" data-name="sliders"><span class="glyphicon glyphicon-bullhorn"></span> Avisos</a></li>
                <!--<li class="<?php echo ($active === 'usuarios') ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/usuarios" data-name="reportes"><span class="glyphicon glyphicon-file"></span> Usuarios</a></li>-->
                <?php
                
                ?>
                    <!--<li class="<?php echo ($active === 'usuarios') ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/usuarios" data-name="usuarios"><span class="glyphicon glyphicon-user"></span>Usuarios</a></li>-->
                <?php
                    
                        ?>
                        <li class="<?php echo ($active === 'inscripcion') ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>alumnos/inscripcion" data-name="inscripcion"><span class="glyphicon glyphicon-pencil"></span> Inscripci&oacute;n Prueba<br /></a></li>
                        <li class="<?php echo ($active === 'limpiar') ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/limpiar" data-name="inscripcion"><span class="glyphicon glyphicon-pencil"></span> Limpiar Inscripci&oacute;n<br /></a></li>
                    <?php
                    
                break;
            case 2:
                if (isset($puede_inscribir) && $puede_inscribir) {
                    ?>
                    <li class="<?php echo ($active === 'inscripcion') ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>alumnos/inscripcion" data-name="inscripcion"><span class="glyphicon glyphicon-pencil"></span> Inscripci&oacute;n<br /><span class="glyphicon glyphicon-list-alt"></span> Comprobantes</a></li>
                <?php
                }
                break;
        }
    }
    ?>