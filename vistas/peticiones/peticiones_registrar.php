<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Peticiones</title> <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <div class="card shadow-sm">
         <header class="bg-success text-white text-center py-3">
        <h1 class="mb-0">Registrar Peticiones</h1>
    </header>
        <div class="card-body">
            <?php
                if (isset($errorMessage) && !empty($errorMessage)) {
                    echo '<div class="alert alert-danger text-center" role="alert">' . htmlspecialchars($errorMessage) . '</div>';
                }
            ?>
            <form action="index.php?c=peticiones&a=Guardar" method="post" autocomplete="off"> <input type="hidden" name="id" value="" />
                <div class="mb-3">
                    <label for="feligres_id" class="form-label">Feligrés</label>
                    <select name="feligres_id" id="feligres_id" class="form-select" required>
                        <option value="">Seleccione un Feligrés</option>
                        <?php

                        if (!empty($feligres)) {
                            foreach ($feligres as $f) {
                                echo "<option value=\"" . htmlspecialchars($f->id) . "\">" . htmlspecialchars($f->nombre) . " - " . htmlspecialchars($f->cedula) . "</option>";
                            }
                        } else {
                            echo "<option value=\"\">Cargando Feligreses...</option>";
                        }
            ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="servicio_id" class="form-label">Servicio</label>
                    <select name="servicio_id" id="servicio_id" class="form-select" required>
                        <option value="">Seleccione un Servicio</option>
                        <?php

            if (!empty($servicio)) {
                foreach ($servicio as $s) {
                    echo "<option value=\"" . htmlspecialchars($s->id) . "\">" . htmlspecialchars($s->nombre) . "</option>";
                }
            } else {

                echo "<option value=\"\">Cargando Servicios...</option>";
            }
            ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea
                        name="descripcion"
                        id="descripcion"
                        class="form-control"
                        placeholder="Ingrese una descripción detallada de la petición"
                        rows="3"
                        required
                    ></textarea>
                </div>

                <div class="mb-3">
                    <label for="fecha_registro" class="form-label">Fecha de Registro</label>
                    <input
                        type="date"
                        name="fecha_registro"
                        id="fecha_registro"
                        class="form-control"
                        value="<?php echo date('Y-m-d'); ?>"
                        required
                    />
                </div>

                <div class="mb-3">
                    <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
                    <input
                        type="date"
                        name="fecha_inicio"
                        id="fecha_inicio"
                        class="form-control"
                        required
                    />
                </div>

                <div class="mb-3">
                    <label for="fecha_fin" class="form-label">Fecha de Fin</label>
                    <input
                        type="date"
                        name="fecha_fin"
                        id="fecha_fin"
                        class="form-control"
                        required
                    />
                </div>

                <hr />

                <div class="text-left">
                    <a href="index.php?c=peticiones" class="btn btn-secondary">Cancelar</a> <button type="submit" class="btn btn-primary">Guardar Petición</button> </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>