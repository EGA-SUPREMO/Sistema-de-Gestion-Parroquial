<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Pago</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <div class="card shadow-sm">
         <header class="bg-success text-white text-center py-3">
        <h1 class="mb-0">Registrar Pago</h1>
    </header>
    
        <div class="card-body">
            <form action="index.php?c=pagos&a=Guardar" method="post" autocomplete="off">

                <input type="hidden" name="id" value="" />

               <div class="mb-3">
                    <label for="peticion_id" class="form-label">Peticiones</label>
                    <select name="peticion_id" id="peticion_id" class="form-select" required>
                        <option value="">Seleccione una peticion</option>
                        <?php
                
                        if (!empty($peticion)) {
                            foreach ($peticion as $p) {
                                echo "<option value=\"" . htmlspecialchars($p->id) . "\">" . htmlspecialchars($p->feligres_nombre) .  " - " . 
                                htmlspecialchars($p->servicio_nombre) . " - " . htmlspecialchars($p->peticion_descripcion) .
                                "</option>";
                            }
                        } else {
                          
                             echo "<option value=\"\">Cargando peticiones...</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="feligres_id" class="form-label">Feligrés</label>
                    <select name="feligres_id" id="feligres_id" class="form-select" required>
                        <option value="">Seleccione un Feligrés</option>
                        <?php
                
                        if (!empty($feligres)) {
                            foreach ($feligres as $f) {
                                echo "<option value=\"" . htmlspecialchars($f->id) . "\">" . htmlspecialchars($f->nombre) . "</option>";
                            }
                        } else {
                          
                             echo "<option value=\"\">Cargando Feligreses...</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="metodo_pago_id" class="form-label">Metodo de Pago</label>
                    <select name="metodo_pago_id" id="metodo_pago_id" class="form-select" required>
                        <option value="">Seleccione el metodo de pago</option>
                        <?php
                
                        if (!empty($metodos)) {
                            foreach ($metodos as $m) {
                                echo "<option value=\"" . htmlspecialchars($m->id) . "\">" . htmlspecialchars($m->nombre) . "</option>";
                            }
                        } else {
                          
                             echo "<option value=\"\">Cargando Metodo de pago...</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="monto_usd" class="form-label">Monto</label>
                    <input
                        type="number"
                        step="0.01"
                        name="monto_usd"
                        id="monto_usd"
                        class="form-control"
                        placeholder="Ingrese el monto en USD"
                        value=""
                        required
                    />
                </div>

                <div class="mb-3">
                    <label for="referencia_pago" class="form-label">Referencia de Pago</label>
                    <input
                        type="text"
                        name="referencia_pago"
                        id="referencia_pago"
                        class="form-control"
                        placeholder="Ingrese la referencia del pago"
                        value=""
                        required
                    />
                </div>

                <div class="mb-3">
                    <label for="fecha_pago" class="form-label">Fecha de Pago</label>
                    <input
                        type="date"
                        name="fecha_pago"
                        id="fecha_pago"
                        class="form-control"
                        value=""
                        required
                    />
                </div>

                <hr />

                <div class="text-left">
                    <a href="index.php?c=pagos" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Guardar Pago</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>