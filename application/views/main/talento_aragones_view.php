<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
?>
<div class="row talento-aragones-content">
    <div class="col-md-8 col-md-offset-2">
        <form class="form-signin form-horizontal" id="registro_form" action="<?php echo base_url(); ?>talento/imprimir" method="POST">
            <h3>PROGRAMA  DE TALENTO ARAGONÉS</h3>
            
            <div class="control-group">
                <label class="control-label" for="nombre">*Nombre Completo</label>
                <div class="controls">
                    <input type="text" value="" id="nombre" class="form-control" name="nombre" placeholder="Nombre" required/>
                </div>
            </div>
            <div class="row">
                <div class="control-group col-md-4">
                    <label class="control-label" for="carrera">*Carrera</label>
                    <div class="controls">
                        <select name="carrera" id="carrera" class="form-control" required>
                            <option value="">Elige Carrera</option>
                            <?php foreach($carreras as $carrera) {?>
                            <option value="<?php echo $carrera['carrera'];?>"><?php echo $carrera['carrera'];?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="control-group col-md-4">
                    <label class="control-label" for="semestre">*Semestre</label>
                    <div class="controls">
                        <input type="text" value="" id="semestre" class="form-control" name="semestre" placeholder="Semestre" required/>
                    </div>
                </div>
                <div class="control-group col-md-4">
                    <label class="control-label" for="no_cta">*Número de Cuenta</label>
                    <div class="controls">
                        <input type="text" value="" id="no_cta" class="form-control" name="no_cta" placeholder="Número de cuenta" required/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="control-group col-md-4">
                    <label class="control-label" for="email">*Correo electrónico:</label>
                    <div class="controls">
                        <input type="email" value="" id="email" class="form-control" name="email" placeholder="Correo electrónico" required/>
                    </div>
                </div>
                <div class="control-group col-md-4">
                    <label class="control-label" for="celular">*Teléfono Celular:</label>
                    <div class="controls">
                        <input type="text" value="" id="celular" class="form-control" name="celular" placeholder="Teléfono Celular" required/>
                    </div>
                </div>

                <div class="control-group col-md-4">
                    <label class="control-label" for="telefono">Teléfono Casa:</label>
                    <div class="controls">
                        <input type="text" value="" id="telefono" class="form-control" name="telefono" placeholder="Teléfono Casa"/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="control-group col-md-6">
                    <label class="control-label" for="artes">*Artes</label>
                    <div class="controls">
                        <select name="artes" id="artes" class="form-control" required>
                            <option value="">Elige Arte</option>
                            <option value="Artes escénicas">Artes escénicas</option>
                            <option value="Artes musicales">Artes musicales</option>
                            
                        </select>
                    </div>
                </div>
                <div class="control-group col-md-6">
                    <label class="control-label" for="actividad_artistica">*Actividad artística:</label>
                    <div class="controls">
                        <input type="text" value="" id="actividad_artistica" class="form-control" name="actividad_artistica" placeholder="Actividad artística" required/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="control-group col-md-6">
                    <label class="control-label" for="nombre_grupo">*Nombre del grupo/solista:</label>
                    <div class="controls">
                        <input type="text" value="" id="nombre_grupo" class="form-control" name="nombre_grupo" placeholder="Nombre del grupo/solista" required/>
                    </div>
                </div>
                <div class="control-group col-md-6">
                    <label class="control-label" for="genero">*Género:</label>
                    <div class="controls">
                        <input type="text" value="" id="genero" class="form-control" name="genero" placeholder="Género" required/>
                    </div>
                </div>
            </div>
            <h3>Integrantes</h3>
            <div class="row">
                <div class="control-group col-md-6">
                    <label class="control-label" for="integrante">Agregar:</label>
                    <div class="controls">
                        <div class="input-group">
                            <input type="text" value="" id="integrante" class="form-control" name="integrante" placeholder="Integrante"/>
                            <span class="input-group-btn">
                                <button class="btn btn-default" id="agregar_btn" type="button">Agregar</button>
                            </span>
                        </div><!-- /input-group -->
                        
                    </div>
                </div>
                <div class="control-group col-md-6">
                    <ul id="lista_integrantes"></ul>
                </div>
            </div>

            <h2>Área Técnica</h2>
            <div class="row">
                <div class="col-md-12">
                <label class="control-label" for="duracion">*Duración de la presentación (Mínimo 30 minutos y máximo 60 minutos):</label>
                </div>
                <div class="control-group col-md-6">
                    <div class="controls">
                        <input type="number" value="" min="30" max="60" id="duracion" class="form-control" name="duracion" placeholder="Duración de la presentación" required/>
                    </div>
                </div>
            </div>
            <h3>Lista de equipo</h3>
            <div class="row">
                <div class="col-md-12">
                <label class="control-label" for="equipo">Equipo/instrumento (propiedad del participante) a utilizar en la presentación (Llenar solamente si eres banda):</label>
                </div>
                <div class="control-group col-md-6">
                    
                    <div class="controls">
                        <div class="input-group">
                            <input type="text" value="" id="equipo" class="form-control" name="equipo" placeholder="Equipo"/>
                            <span class="input-group-btn">
                                <button class="btn btn-default" id="equipo_btn" type="button">Agregar</button>
                            </span>
                        </div><!-- /input-group -->
                    </div>
                </div>
                <div class="control-group col-md-6">
                    <ul id="lista_equipo"></ul>
                </div>
            </div>
            
            <div class="row">
                <div class="control-group col-md-12">
                    <label class="control-label" for="escenografia">Escenografía:</label>
                    <div class="controls">
                        <textarea value="" id="escenografia" class="form-control" name="escenografia" placeholder="Poner especificaciones"></textarea>
                    </div>
                </div>
            </div>
            <div class="alert alert-warning" role="alert">El Departamento de Actividades Culturales no proporciona ningún tipo de escenografía</div>
            <div class="row">
                <div class="control-group col-md-6">
                    <label class="control-label" for="iluminacion">Iluminación:</label>
                    <div class="controls">
                        <input type="text" value="" id="iluminacion" class="form-control" name="iluminacion" placeholder="Iluminación"/>
                    </div>
                </div>
                <div class="control-group col-md-6">
                    <label class="control-label" for="audio_video">Audio y video:</label>
                    <div class="controls">
                        <input type="text" value="" id="audio_video" class="form-control" name="audio_video" placeholder="Audio y video"/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="control-group col-md-6">
                    <label class="control-label" for="duracion_montaje">Montaje:</label>
                    <div class="controls">
                        <input type="number" value="" min="0" max="20" id="duracion_montaje" class="form-control" name="duracion_montaje" placeholder="Duración de montaje"/>
                    </div>
                </div>
                <div class="control-group col-md-6">
                    <label class="control-label" for="duracion_desmontaje">Desmontaje:</label>
                    <div class="controls">
                        <input type="number" value="" min="0" max="20" id="duracion_desmontaje" class="form-control" name="duracion_desmontaje" placeholder="Duración de desmontaje"/>
                    </div>
                </div>
            </div>
            
            <h2>Consideraciones</h2>
            <div class="alert alert-info" role="alert">El Departamento de Actividades Culturales unicamente prestará microfonos para la presentación de las actividades artisticas a realizar en el teatro</div>
            <div class="alert alert-info" role="alert">Presentarse 2 horas antes de la hora indicada de su presentación</div>
            <div class="alert alert-info" role="alert">No habrá ensayos previos a la presentación</div>
            <div class="text-center">
                <button type="submit" class="btn btn-success">Imprimir</button>
                <button id="limpiar" type="button" class="btn btn-success">Limpiar</button>
            </div>
        </form>
    </div>
</div>