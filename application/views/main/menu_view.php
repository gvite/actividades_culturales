    <?php
    if (!isset($no_menu)) {
        if (!isset($active)) {
            $active = '';
        }
        ?>
        <li class="<?php echo ($active === 'inicio') ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>inicio.jsp" data-name="inicio"><span class="glyphicon glyphicon-home"></span> Inicio</a></li>
        <?php
        if (isset($semestre_actual) && $semestre_actual) {
            ?>
            <li class="<?php echo ($active === 'horarios') ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>horarios.jsp" data-name="horarios"><span class="glyphicon glyphicon-calendar"></span> Horarios</a></li>
            <?php
        }
        switch (get_type()) {
            case 1:
                ?>
            <li class="<?php echo ($active === 'actividades') ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/talleres.jsp" data-name="actividades"><span class="glyphicon glyphicon-book"></span> Registro de actividades</a></li>
                <?php if (isset($puede_inscribir) && !$puede_inscribir) { ?>
                <li class="<?php echo ($active === 'inscribir') ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/inscribir.jsp" data-name="inscribir"><span class="glyphicon glyphicon-pencil"></span> Inscripci&oacute;n</a></li>
                <?php } ?>
                <li class="<?php echo ($active === 'validacion') ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/validacion.jsp" data-name="validacion"><span class="glyphicon glyphicon-check"></span> Validaci&oacute;n</a></li>
                <li class="<?php echo ($active === 'listas') ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/listas.jsp" data-name="listas"><span class="glyphicon glyphicon-list"></span> Listas</a></li>
                <li class="<?php echo ($active === 'alumnos') ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/alumnos.jsp" data-name="alumnos"><span class="glyphicon glyphicon-user"></span> Alumnos</a></li>
                <li class="<?php echo ($active === 'reportes') ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/reportes/carrera.jsp" data-name="reportes"><span class="glyphicon glyphicon-file"></span> Reportes</a></li>
                <?php
                if(get_type_user() == 1){
                ?>
                    <!--<li class="<?php echo ($active === 'usuarios') ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/usuarios.jsp" data-name="usuarios"><span class="glyphicon glyphicon-user"></span>Usuarios</a></li>-->
                <?php
                    if (isset($puede_inscribir) && $puede_inscribir) {
                        ?>
                        <li class="<?php echo ($active === 'inscripcion') ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>alumnos/inscripcion.jsp" data-name="inscripcion"><span class="glyphicon glyphicon-pencil"></span> Inscripci&oacute;n Prueba<br /></a></li>
                        <li class="<?php echo ($active === 'limpiar') ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>admin/limpiar.jsp" data-name="inscripcion"><span class="glyphicon glyphicon-pencil"></span> Limpiar Inscripci&oacute;n<br /></a></li>
                    <?php
                    }
                }
                break;
            case 2:
                if (isset($puede_inscribir) && $puede_inscribir) {
                    ?>
                    <li class="<?php echo ($active === 'inscripcion') ? 'active' : ''; ?>"><a href="<?php echo base_url() ?>alumnos/inscripcion.jsp" data-name="inscripcion"><span class="glyphicon glyphicon-pencil"></span> Inscripci&oacute;n<br /><span class="glyphicon glyphicon-list-alt"></span> Comprobantes</a></li>
                <?php
                }
                break;
        }
    }
    ?>