
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seleccionar Plantilla</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../public/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>



    <header class="bg-success text-white text-center py-3">
        <h1 class="mb-0">Generar Documento</h1>
    </header>

    <main class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <section class="card shadow-sm">
                <div class="card-body p-4">
                    <h2 class="card-title text-center mb-4">Generar Constancia de Primera Comunión</h2>
                    <form action="?c=primera_comunion&a=comunion" method="post">
                        
                     <input type="hidden" name="constancia" value="primera_comunion">

                        <div class="mb-3">
                            <label for="nombreCiudadano" class="form-label">Nombre completo del ciudadano:</label>
                            <input type="text" class="form-control" id="nombreCiudadano" name="nombreCiudadano" placeholder="Nombre completo del titular de la cédula" required>
                        </div>

                        <div class="mb-3">
                            <label for="cedulaIdentidad" class="form-label">Cédula de Identidad N°:</label>
                            <input type="text" class="form-control" id="cedulaIdentidad" name="cedulaIdentidad" placeholder="Ej: V-12345678 o E-12345678" maxlength="10" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Fecha de la Primera Comunión:</label>
                            <div class="row g-2">
                                <div class="col-4">
                                    <input type="number" class="form-control" id="diaComunion" name="diaComunion" placeholder="Día" min="1" max="31" required>
                                </div>
                                <div class="col-4">
                                    <select class="form-select" id="mesComunion" name="mesComunion" required>
                                        <option value="" disabled selected>Mes</option>
                                        <option value="Enero">Enero</option>
                                        <option value="Febrero">Febrero</option>
                                        <option value="Marzo">Marzo</option>
                                        <option value="Abril">Abril</option>
                                        <option value="Mayo">Mayo</option>
                                        <option value="Junio">Junio</option>
                                        <option value="Julio">Julio</option>
                                        <option value="Agosto">Agosto</option>
                                        <option value="Septiembre">Septiembre</option>
                                        <option value="Octubre">Octubre</option>
                                        <option value="Noviembre">Noviembre</option>
                                        <option value="Diciembre">Diciembre</option>
                                    </select>
                                </div>
                                <div class="col-4">
                                    <input type="number" class="form-control" id="anoComunion" name="anoComunion" placeholder="Año" min="1900" max="<?php echo date('Y'); ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Fecha de Expedición de la Constancia:</label>
                            <div class="row g-2">
                                <div class="col-4">
                                    <input type="number" class="form-control" id="diaExpedicion" name="diaExpedicion" placeholder="Día" min="1" max="31" required>
                                </div>
                                <div class="col-4">
                                    <select class="form-select" id="mesExpedicion" name="mesExpedicion" required>
                                        <option value="" disabled selected>Mes</option>
                                        <option value="Enero">Enero</option>
                                        <option value="Febrero">Febrero</option>
                                        <option value="Marzo">Marzo</option>
                                        <option value="Abril">Abril</option>
                                        <option value="Mayo">Mayo</option>
                                        <option value="Junio">Junio</option>
                                        <option value="Julio">Julio</option>
                                        <option value="Agosto">Agosto</option>
                                        <option value="Septiembre">Septiembre</option>
                                        <option value="Octubre">Octubre</option>
                                        <option value="Noviembre">Noviembre</option>
                                        <option value="Diciembre">Diciembre</option>
                                    </select>
                                </div>
                                <div class="col-4">
                                    <input type="number" class="form-control" id="anoExpedicion" name="anoExpedicion" placeholder="Año" min="1900" max="<?php echo date('Y'); ?>" required>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mt-3">
                            Generar Constancia
                        </button>
                    </form>
                </div>
            </section>
        </div>
    </div>
</main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>