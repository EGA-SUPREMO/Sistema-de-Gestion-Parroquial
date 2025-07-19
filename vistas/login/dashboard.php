<? //php  session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../public/styles.css">


</head>
<body>

    <header class="bg-success text-white text-center py-3">
        <h1 class="mb-0">Bienvenido al Panel de Administración</h1>
    </header>

 <main class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <section class="card shadow-lg border-0 rounded-3">
                <div class="card-body p-4">
                    <h2 class="card-title text-center text-primary fw-bold mb-4">Opciones del Panel</h2>
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <a href="?c=reporte&a=index" class="card text-decoration-none text-dark h-100 lift-effect">
                                <div class="card-body text-center">
                                   
                                    <h5 class="card-title mb-0">Generar Reportes</h5>
                                </div>
                            </a>
                        </div>
                        <div class="col-sm-6">
                            <a href="?c=feligreses&a=index" class="card text-decoration-none text-dark h-100 lift-effect">
                                <div class="card-body text-center">
                                 
                                    <h5 class="card-title mb-0">Gestionar Feligreses</h5>
                                </div>
                            </a>
                        </div>
                        <div class="col-sm-6">
                            <a href="?c=servicios&a=index" class="card text-decoration-none text-dark h-100 lift-effect">
                                <div class="card-body text-center">
                                  
                                    <h5 class="card-title mb-0">Gestionar Servicios</h5>
                                </div>
                            </a>
                        </div>
                        <div class="col-sm-6">
                            <a href="?c=pagos&a=index" class="card text-decoration-none text-dark h-100 lift-effect">
                                <div class="card-body text-center">
                                
                                    <h5 class="card-title mb-0">Gestionar Pagos</h5>
                                </div>
                            </a>
                        </div>
                          <div class="col-sm-6">
                            <a href="?c=metodosP&a=index" class="card text-decoration-none text-dark h-100 lift-effect">
                                <div class="card-body text-center">
                                   
                                    <h5 class="card-title mb-0"> Gestionar <br>Metodos de Pagos</h5>
                                </div>
                            </a>
                        </div>
                           <div class="col-sm-6">
                            <a href="?c=peticiones&a=index" class="card text-decoration-none text-dark h-100 lift-effect">
                                <div class="card-body text-center">
                               
                                    <h5 class="card-title mb-0"> Gestionar <br>Peticiones</h5>
                                </div>
                            </a>
                        </div>
                          <div class="col-sm-6">
                            <a href="?c=login&a=mostrar" class="card text-decoration-none text-dark h-100 lift-effect">
                                <div class="card-body text-center">
                               
                                    <h5 class="card-title mb-0">Administradores</h5>
                                </div>
                            </a>
                        </div>
                        <div class="col-12 mt-4">
                            <a href="?c=login&a=cerrarSesion"  class="btn btn-outline-danger w-100 d-flex align-items-center justify-content-center"
                              onclick="javascript:return confirm('¿Seguro de salir');">
                           
                                Cerrar Sesión
                            </a>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</main>


<style>
    .lift-effect {
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }
    .lift-effect:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }
</style>>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>