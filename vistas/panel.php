<body class="d-flex flex-column min-vh-100 bg-light">
    <main class="container-fluid my-5 flex-grow-1">
        <div class="row justify-content-center">
            <div class="col-lg-12 col-xl-12">
                <section class="card shadow-lg rounded-4">
                    <div class="card-body p-4 p-md-5" id="contenedor-tabla">
                        <h2 class="card-title text-center mb-4 pb-2 border-bottom display-6 fw-bold text-success" id="subtitulo-tabla"></h2>
                        <div class="d-flex justify-content-end mb-4">
                            <a href="?c=formulario&a=guardar&t=administrador" class="btn btn-primary btn-lg rounded-pill shadow-sm" id="agregar-btn"></a>
                        </div>
                            <div class="table-responsive">
                                <div class="alert alert-info text-center py-4 rounded-3" role="alert" id='sin-registros'>
                                    <i class="bi bi-info-circle-fill me-2"></i> No hay registros aún.
                                    <p class="mt-2" id="sugerencia-sin-registro"></p>
                                </div>
                                <table class="table table-striped table-hover align-middle border rounded-3 overflow-hidden" id='con-registros'>
                                    <thead class="table-success text-white" id="cabeza-tabla">
                                    </thead>
                                    <tbody id="cuerpo-tabla">
                                    </tbody>
                                </table>
                            </div>
                    </div>
                </section>
            </div>
        </div>
    </main>

    <footer class="bg-dark text-white text-center py-3 mt-auto shadow-lg">
        <div class="container">
            <p class="mb-0">&copy; 2025. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script src="public/js/jquery-1.12.4.min.js"></script>
    <script src="public/js/bootstrap.bundle.min.js"></script>
</body>

</html>