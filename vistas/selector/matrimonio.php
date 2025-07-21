
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generar Acta de Matrimonio Eclesiástico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../public/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>



    <header class="bg-success text-white text-center py-3">
        <h1 class="mb-0">Generar Reporte</h1>
    </header>

    <main class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <section class="card shadow-sm">
                <div class="card-body p-4">
                    <h2 class="card-title text-center mb-4">Generar <br>Acta de Matrimonio Eclesiástico</h2>
                    <form method="post" action="?c=matrimonio&a=matrimonio">

                        <input type="hidden" name="constancia" value="matrimonio">

                        <h4 class="mb-3">Datos del Acta de Matrimonio</h4>
                        <div class="mb-3">
                            <label for="nombreContrayente1" class="form-label">Nombre completo del Contrayente 1:</label>
                            <input type="text" class="form-control" id="nombreContrayente1" name="nombreContrayente1" placeholder="Nombre Completo" required>
                        </div>
                        <div class="mb-3">
                            <label for="naturalContrayente1" class="form-label">Natural de (Contrayente 1):</label>
                            <input type="text" class="form-control" id="naturalContrayente1" name="naturalContrayente1" placeholder="Ej: Valencia" value="Valencia" required>
                        </div>

                        <div class="mb-3">
                            <label for="nombreContrayente2" class="form-label">Nombre completo del Contrayente 2:</label>
                            <input type="text" class="form-control" id="nombreContrayente2" name="nombreContrayente2" placeholder="Nombre Completo" required>
                        </div>
                        <div class="mb-3">
                            <label for="naturalContrayente2" class="form-label">Natural de (Contrayente 2):</label>
                            <input type="text" class="form-control" id="naturalContrayente2" name="naturalContrayente2" placeholder="Ej: Valencia" value="Valencia" required>
                        </div>
                        
                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                <label for="numeroLibro" class="form-label">Libro N°:</label>
                                <input type="text" class="form-control" id="numeroLibro" name="numeroLibro" placeholder="Ej: 10" required value="10">
                            </div>
                            <div class="col-md-4">
                                <label for="folio" class="form-label">Folio:</label>
                                <input type="text" class="form-control" id="folio" name="folio" placeholder="Ej: 191" required value="191">
                            </div>
                            <div class="col-md-4">
                                <label for="numeroMarginal" class="form-label">N°. Marginal:</label>
                                <input type="text" class="form-control" id="numeroMarginal" name="numeroMarginal" placeholder="Ej: 382" required value="382">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Fecha del Matrimonio:</label>
                            <div class="row g-2">
                                <div class="col-4">
                                    <input type="number" class="form-control" id="diaMatrimonio" name="diaMatrimonio" placeholder="Día" min="1" max="31" required>
                                </div>
                                <div class="col-4">
                                    <select class="form-select" id="mesMatrimonio" name="mesMatrimonio" required>
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
                                    <input type="number" class="form-control" id="anoMatrimonio" name="anoMatrimonio" placeholder="Año" min="1900" max="<?php echo date('Y'); ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="nombreSacerdoteMatrimonio" class="form-label">Nombre del Sacerdote que Presenció el Matrimonio:</label>
                            <input type="text" class="form-control" id="nombreSacerdoteMatrimonio" name="nombreSacerdoteMatrimonio" placeholder="Ej: Pbro. BENITO RAMÍREZ" value="Pbro. BENITO RAMÍREZ" required>
                        </div>
                        
                        <h4 class="mt-4 mb-3">Datos de Expedición</h4>
                        <div class="mb-3">
                            <label class="form-label">Fecha de Expedición de la Certificación:</label>
                            <div class="row g-2">
                                <div class="col-4">
                                    <input type="number" class="form-control" id="diaExpedicion" name="diaExpedicion" placeholder="Día" min="1" max="31" required value="<?php echo date('j'); ?>">
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
                                    <input type="number" class="form-control" id="anoExpedicion" name="anoExpedicion" placeholder="Año" min="1900" max="<?php echo date('Y'); ?>" required value="<?php echo date('Y'); ?>">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="nombreAdministradorParroquial" class="form-label">Nombre del Administrador Parroquial que expide:</label>
                            <input type="text" class="form-control" id="nombreAdministradorParroquial" name="nombreAdministradorParroquial" placeholder="Ej: Pbro. Hedson Brizuela" value="Pbro. Hedson Brizuela" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mt-3">
                            Generar Acta de Matrimonio
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