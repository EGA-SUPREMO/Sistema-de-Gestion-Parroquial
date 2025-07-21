<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generar Intenciones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../public/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>

    <header class="bg-success text-white text-center py-3">
        <h1 class="mb-0">Generar Documento de Intenciones</h1>
    </header>

    <main class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <section class="card shadow-sm">
                <div class="card-body p-4">
                    <h2 class="card-title text-center mb-4">Ingresar Intenciones</h2> 
                    <form action="?c=intenciones&a=generar" method="post">
                        
                        <input type="hidden" name="plantilla" value="intenciones">

                        <div class="mb-3">
                            <label for="acciondegracias" class="form-label">Acción de Gracias:</label>
                            <textarea class="form-control" id="acciondegracias" name="acciondegracias" rows="3" placeholder="Ingrese las intenciones de acción de gracias"></textarea> 
                        </div>

                        <div class="mb-3">
                            <label for="salud" class="form-label">Salud:</label>
                            <textarea class="form-control" id="salud" name="salud" rows="3" placeholder="Ingrese las peticiones por la salud"></textarea> 
                        </div>

                        <div class="mb-3">
                            <label for="aniversarios" class="form-label">Aniversarios:</label>
                            <textarea class="form-control" id="aniversarios" name="aniversarios" rows="3" placeholder="Ingrese los aniversarios a conmemorar"></textarea> 
                        </div>

                        <div class="mb-3">
                            <label for="difunto" class="form-label">Difuntos:</label>
                            <textarea class="form-control" id="difunto" name="difunto" rows="3" placeholder="Ingrese los nombres de los difuntos"></textarea> 
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mt-3">
                            Generar Documento
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