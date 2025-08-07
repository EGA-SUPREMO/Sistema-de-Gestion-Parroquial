
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
        <h1 class="mb-0">Generar Reporte</h1>
    </header>

    <main class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <section class="card shadow-sm">
                <div class="card-body p-4">
                    <h2 class="card-title text-center mb-4">Generar Fe de Bautizo</h2>
                    <form method="post" action="?c=fe_bautizo&a=fe_bautizo">

                        <!-- Tipo de constancia -->
                        <input type="hidden" name="constancia" value="fe_bautizo">

                        <!-- Datos del Bautizado -->
                        <h4 class="mt-4 mb-3">Datos del Bautizado</h4>
                        <div class="mb-3">
                            <label for="nombreBautizado" class="form-label">Nombre completo del Bautizado:</label>
                            <input type="text" class="form-control" id="nombreBautizado" name="nombreBautizado" placeholder="Nombre completo del bautizado" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Fecha de Nacimiento:</label>
                            <div class="row g-2">
                                <div class="col-4">
                                    <input type="number" class="form-control" id="diaNacimiento" name="diaNacimiento" placeholder="Día" min="1" max="31" required>
                                </div>
                                <div class="col-4">
                                    <select class="form-select" id="mesNacimiento" name="mesNacimiento" required>
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
                                    <input type="number" class="form-control" id="anoNacimiento" name="anoNacimiento" placeholder="Año" min="1900" max="<?php echo date('Y'); ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="lugarNacimiento" class="form-label">Lugar de Nacimiento:</label>
                            <input type="text" class="form-control" id="lugarNacimiento" name="lugarNacimiento" placeholder="Ej: San Diego - Estado Carabobo - País Venezuela" value="San Diego - Estado Carabobo - País Venezuela." required>
                        </div>

                        <!-- Datos de los Padres -->
                        <h4 class="mt-4 mb-3">Datos de los Padres</h4>
                        <div class="mb-3">
                            <label for="nombrePadre" class="form-label">Nombre completo del Padre:</label>
                            <input type="text" class="form-control" id="nombrePadre" name="nombrePadre" placeholder="Nombre completo del padre" required>
                        </div>
                        <div class="mb-3">
                            <label for="nombreMadre" class="form-label">Nombre completo de la Madre:</label>
                            <input type="text" class="form-control" id="nombreMadre" name="nombreMadre" placeholder="Nombre completo de la madre" required>
                        </div>

                        <!-- Datos del Bautismo -->
                        <h4 class="mt-4 mb-3">Datos del Bautismo</h4>
                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                <label for="numeroLibro" class="form-label">Libro N°:</label>
                                <input type="text" class="form-control" id="numeroLibro" name="numeroLibro" placeholder="Ej: 33" value="33" required>
                            </div>
                            <div class="col-md-4">
                                <label for="folio" class="form-label">Folio:</label>
                                <input type="text" class="form-control" id="folio" name="folio" placeholder="Ej: 179" value="179" required>
                            </div>
                            <div class="col-md-4">
                                <label for="numeroMarginal" class="form-label">N°. Marginal:</label>
                                <input type="text" class="form-control" id="numeroMarginal" name="numeroMarginal" placeholder="Ej: 535" value="535" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Fecha de Bautismo:</label>
                            <div class="row g-2">
                                <div class="col-4">
                                    <input type="number" class="form-control" id="diaBautismo" name="diaBautismo" placeholder="Día" min="1" max="31" required>
                                </div>
                                <div class="col-4">
                                    <select class="form-select" id="mesBautismo" name="mesBautismo" required>
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
                                    <input type="number" class="form-control" id="anoBautismo" name="anoBautismo" placeholder="Año" min="1900" max="<?php echo date('Y'); ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="nombreSacerdote" class="form-label">Nombre del Sacerdote que Bautizó:</label>
                            <input type="text" class="form-control" id="nombreSacerdote" name="nombreSacerdote" placeholder="Ej: Pbro. Benito Ramírez" value="Pbro. Benito Ramírez" required>
                        </div>

                        <div class="mb-3">
                            <label for="nombrePadrino" class="form-label">Nombre completo del Padrino:</label>
                            <input type="text" class="form-control" id="nombrePadrino" name="nombrePadrino" placeholder="Nombre completo del padrino" required>
                        </div>

                        <div class="mb-3">
                            <label for="nombreMadrina" class="form-label">Nombre completo de la Madrina:</label>
                            <input type="text" class="form-control" id="nombreMadrina" name="nombreMadrina" placeholder="Nombre completo de la madrina" required>
                        </div>
                        
                      
                        <h4 class="mt-4 mb-3">Datos de Expedición</h4>
                        <div class="mb-3">
                            <label for="propositoCertificacion" class="form-label">Propósito de la Certificación:</label>
                            <input type="text" class="form-control" id="propositoCertificacion" name="propositoCertificacion" placeholder="Ej: Personal" value="Personal" required>
                            <label for="propositoCertificacion" class="form-label">Nota marginal:</label>
                            <input type="text" class="form-control" id="notaMarginal" name="notaMarginal" value="No hay nota marginal." required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Fecha de Expedición de la Constancia:</label>
                            <div class="row g-2">
                                <div class="col-4">
                                    <input type="number" class="form-control" id="diaExpedicion" name="diaExpedicion" placeholder="Día" min="1" max="31" value="<?php echo date('j'); ?>" required>
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
                                    <input type="number" class="form-control" id="anoExpedicion" name="anoExpedicion" placeholder="Año" min="1900" max="<?php echo date('Y'); ?>" value="<?php echo date('Y'); ?>" required>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mt-3">
                           Generar Fe de Bautizo
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