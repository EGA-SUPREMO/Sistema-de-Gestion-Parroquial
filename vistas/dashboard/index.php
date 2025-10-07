<body>
    <header class="bg-success text-white text-center py-3">
        <h1 class="mb-0">Bienvenido al Panel de Administración</h1>
    </header>
<main class="container mt-5">
    <div id="error-message-container" style="display:none;"></div>
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <section class="card shadow-lg border-0 rounded-3">
                <div class="card-body p-4">
                    <h2 class="card-title text-center text-primary fw-bold mb-4">Opciones del Panel</h2>
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <a href="?c=formulario&a=guardar&t=intencion" class="card text-decoration-none text-dark h-100 lift-effect">
                                <div class="card-body text-center">
                                    <h5 class="card-title mb-0">Registrar intencion</h5>
                                </div>
                            </a>
                        </div>
                        <div class="col-sm-6">
                            <a href="?c=dashboard&a=constancias" class="card text-decoration-none text-dark h-100 lift-effect">
                                <div class="card-body text-center">
                                    <h5 class="card-title mb-0">Generar Reportes</h5>
                                </div>
                            </a>
                        </div>
                        <div class="col-sm-6">
                            <a href="?c=agenda&a=index" class="card text-decoration-none text-dark h-100 lift-effect">
                                <div class="card-body text-center">
                                    <h5 class="card-title mb-0">Gestionar Agenda</h5>
                                </div>
                            </a>
                        </div>
                        <div class="col-sm-6">
                            <a href="?c=dashboard&a=administracion" class="card text-decoration-none text-dark h-100 lift-effect">
                                <div class="card-body text-center">
                                    <h5 class="card-title mb-0">Administración</h5>
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
<script src="public/js/bootstrap.bundle.min.js"></script>
<script src="public/js/mostrarError.js"></script>
</body>
</html>