<body>
<header class="bg-success text-white text-center py-3">
    <h1 class="mb-0">Generar Constancias</h1>
</header>
 <main class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div id="error-message-container" style="display:none;"></div>
            <section class="card shadow-lg border-0 rounded-3">
                <div class="card-body p-4">
                    <h2 class="card-title text-center text-primary fw-bold mb-4">Opciones disponibles </h2>
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <a href="?c=constancia&a=mostrar&t=constancia_de_bautizo" class="card text-decoration-none text-dark h-100 lift-effect">
                                <div class="card-body text-center">
                                    <h5 class="card-title mb-0">Fe de Bautizo</h5>
                                </div>
                            </a>
                        </div>
                        <div class="col-sm-6">
                            <a href="?c=reporte&a=constancia_c" class="card text-decoration-none text-dark h-100 lift-effect">
                                <div class="card-body text-center">
                                    <h5 class="card-title mb-0">Primera Comunion</h5>
                                </div>
                            </a>
                        </div>
                        <div class="col-sm-6">
                            <a href="?c=constancia&a=mostrar&t=constancia_de_confirmacion" class="card text-decoration-none text-dark h-100 lift-effect">
                                <div class="card-body text-center">
                                    <h5 class="card-title mb-0">Confirmación</h5>
                                </div>
                            </a>
                        </div>
                        <div class="col-sm-6">
                            <a href="?c=reporte&a=acta_matrimonio" class="card text-decoration-none text-dark h-100 lift-effect">
                                <div class="card-body text-center">
                                    <h5 class="card-title mb-0">Acta de matrimonio</h5>
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
</style>

<script src="public/js/bootstrap.bundle.min.js"></script>
<script src="public/js/sweetalert2.all.min.js"></script>
<script src="public/js/mostrarError.js"></script>
</body>
</html>