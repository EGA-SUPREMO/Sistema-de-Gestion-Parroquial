<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Pagos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <header class="bg-success text-white text-center py-3">
        <h1 class="mb-0">Editar Pago</h1>
    </header>
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white">
                <h1 class="h4 mb-0">Datos del Pago:</h1>
            </div>
            <div class="card-body">
                <form action="index.php?c=pagos&a=Actualizar" method="post" autocomplete="off">

                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($pago->id ?? ''); ?>" />

                    <div class="mb-3">
                        <label for="feligres_id" class="form-label">Feligrés</label>
                        <select name="feligres_id" id="feligres_id" class="form-select" required>
                        <option value="">Seleccione un Feligrés</option>
                        <?php
                
                        if (!empty($feligres)) {
                            foreach ($feligres as $f) {
                                $selected = ($pago->feligres_id == $f->id) ? 'selected' : '';
                                echo "<option value=\"" . htmlspecialchars($f->id) . "\" $selected>" . htmlspecialchars($f->nombre) . " - " . htmlspecialchars($f->cedula) . "</option>";
                            }
                        } else {
                             echo "<option value=\"\">Cargando Feligreses...</option>";
                        }
                        ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="metodo_pago_id" class="form-label">Método de Pago</label>
                        <select name="metodo_pago_id" id="metodo_pago_id" class="form-select" required>
                            <option value="">Seleccione un método</option>
                            <?php
                            if (!empty($metodos)) {
                                foreach ($metodos as $m) {
                                    $selected = ($pago->metodo_pago_id == $m->id) ? 'selected' : '';
                                    echo "<option value=\"" . htmlspecialchars($m->id) . "\" $selected>" .
                                        htmlspecialchars($m->nombre) . "</option>";
                                }
                            } else {
                                echo "<option value=\"\">No hay métodos disponibles</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="peticion_id" class="form-label">Petición</label>
                        <select name="peticion_id" id="peticion_id" class="form-select" required>
                            <option value="">Seleccione una petición</option>
                            <?php
                            if (!empty($peticion)) {
                                foreach ($peticion as $p) {
                                    $selected = ($pago->peticion_id == $p->id) ? 'selected' : '';
                                    echo "<option value=\"" . htmlspecialchars($p->id) . "\" $selected>" .
                                        htmlspecialchars($p->feligres_nombre) . " - " .
                                        htmlspecialchars($p->servicio_nombre) . " - " .
                                        htmlspecialchars($p->peticion_descripcion) .
                                        "</option>";
                                }
                            } else {
                                echo "<option value=\"\">No hay peticiones disponibles</option>";
                            }
                            ?>
                        </select>
                    </div>


                    <div class="mb-3">
                        <label for="monto_usd" class="form-label">Monto (USD)</label>
                        <input
                            type="number"
                            step="0.01"
                            name="monto_usd"
                            id="monto_usd"
                            class="form-control"
                            placeholder="Ingrese el monto en USD"
                            value="<?php echo htmlspecialchars($pago->monto_usd ?? ''); ?>"
                            required />
                    </div>

                    <div class="mb-3">
                        <label for="referencia_pago" class="form-label">Referencia de Pago</label>
                        <input
                            type="text"
                            name="referencia_pago"
                            id="referencia_pago"
                            class="form-control"
                            placeholder="Ingrese la referencia del pago"
                            value="<?php echo htmlspecialchars($pago->referencia_pago ?? ''); ?>"
                            required />
                    </div>

                    <div class="mb-3">
                        <label for="fecha_pago" class="form-label">Fecha de Pago</label>
                        <input
                            type="date"
                            name="fecha_pago"
                            id="fecha_pago"
                            class="form-control"
                            value="<?php echo htmlspecialchars($pago->fecha_pago ?? ''); ?>"
                            required />
                    </div>

                    <hr />

                    <div class="text-left">
                        <a href="index.php?c=pagos" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Actualizar Pago</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>