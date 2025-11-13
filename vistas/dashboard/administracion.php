<body>
<main class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div id="error-message-container" style="display:none;"></div>
            <section class="card shadow-lg border-0 rounded-3">
                <div class="card-body p-4">
                    <h2 class="card-title text-center text-primary fw-bold mb-4">Opciones del Panel</h2>
                    <div class="row g-3">
                          <div class="col-sm-6">
                            <a href="?c=panel&a=index&t=administrador" class="card text-decoration-none text-dark h-100 lift-effect">
                                <div class="card-body text-center">
                                    <h5 class="card-title mb-0"> Gestionar <br> Administradores</h5>
                                </div>
                            </a>
                        </div>
                        <div class="col-sm-6">
                            <a href="?c=panel&a=index&t=sacerdote" class="card text-decoration-none text-dark h-100 lift-effect">
                                <div class="card-body text-center">
                                    <h5 class="card-title mb-0">Gestionar Sacerdotes</h5>
                                </div>
                            </a>
                        </div>
                        <div class="col-sm-6">
                            <a href="?c=panel&a=index&t=feligres" class="card text-decoration-none text-dark h-100 lift-effect">
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
<script src="public/js/bootstrap.bundle.min.js"></script>
<script src="public/js/sweetalert2.all.min.js"></script>
<script src="public/js/mostrarError.js"></script>
</body>
</html>
