<body>
<main class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <section class="card shadow-lg border-0 rounded-3">
                <div class="card-body p-4">
                    <h2 class="card-title text-center text-primary fw-bold mb-4">Opciones del Panel</h2>
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <a href="?c=peticiones&a=index" class="card text-decoration-none text-dark h-100 lift-effect">
                                <div class="card-body text-center">
                                    <h5 class="card-title mb-0"> Consultar <br>Peticiones</h5>
                                </div>
                            </a>
                        </div>
                          <div class="col-sm-6">
                            <a href="?c=panel&a=index&t=administrador" class="card text-decoration-none text-dark h-100 lift-effect">
                                <div class="card-body text-center">
                                    <h5 class="card-title mb-0"> Gestionar <br> Administradores</h5>
                                </div>
                            </a>
                        </div>
                        <div class="col-sm-6">
                            <a href="?c=dashboard&a=administracion" class="card text-decoration-none text-dark h-100 lift-effect">
                                <div class="card-body text-center">
                                    <h5 class="card-title mb-0">Editar tipos<br>de intención</h5>
                                </div>
                            </a>
                        </div>
                        <div class="col-sm-6">
                            <a href="?c=panel&a=index&t=servicio" class="card text-decoration-none text-dark h-100 lift-effect">
                                <div class="card-body text-center">
                                    <h5 class="card-title mb-0">Gestionar Servicios</h5>
                                </div>
                            </a>
                        </div>
                        <div class="col-sm-6">
                            <a href="?c=panel&a=index&t=categoria_de_servicios" class="card text-decoration-none text-dark h-100 lift-effect">
                                <div class="card-body text-center">
                                    <h5 class="card-title mb-0">Gestionar Categoría de Servicios</h5>
                                </div>
                            </a>
                        </div>
                        <div class="col-sm-6">
                            <a href="?c=panel&a=index&t=sacerdotes" class="card text-decoration-none text-dark h-100 lift-effect">
                                <div class="card-body text-center">
                                    <h5 class="card-title mb-0">Gestionar Sacerdotes</h5>
                                </div>
                            </a>
                        </div>
                        <div class="col-sm-6">
                            <a href="?c=panel&a=index&t=santos" class="card text-decoration-none text-dark h-100 lift-effect">
                                <div class="card-body text-center">
                                    <h5 class="card-title mb-0">Gestionar Santos</h5>
                                </div>
                            </a>
                        </div>
                        <div class="col-sm-6">
                            <a href="?c=panel&a=index&t=feligreses" class="card text-decoration-none text-dark h-100 lift-effect">
                                <div class="card-body text-center">
                                    <h5 class="card-title mb-0">Gestionar Feligreses</h5>
                                </div>
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
</style>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
