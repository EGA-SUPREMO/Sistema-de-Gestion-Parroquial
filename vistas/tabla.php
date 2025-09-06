<body class="d-flex flex-column min-vh-100 bg-light">
    <main class="container my-5 flex-grow-1">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-8">
                <section class="card shadow-lg rounded-4">
                    <div class="card-body p-4 p-md-5" id="contenedor-tabla">
                        <h2 class="card-title text-center mb-4 pb-2 border-bottom display-6 fw-bold text-success">
                            Listado de Administradores
                        </h2>

                        <div class="d-flex justify-content-end mb-4">
                            <a href="?c=formulario&a=guardar&t=administrador" class="btn btn-primary btn-lg rounded-pill shadow-sm">
                                Añadir Nuevo Administrador
                            </a>
                        </div>

                        <?php if (empty($administradores)):
                            ?>
                            <div class="alert alert-info text-center py-4 rounded-3" role="alert">
                                <i class="bi bi-info-circle-fill me-2"></i> No hay administradores registrados aún.
                                <p class="mt-2">¡Haz clic en "Añadir Nuevo Administrador" para empezar!</p>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover align-middle border rounded-3 overflow-hidden">
                                    <thead class="table-success text-white">
                                        <tr>
                                            
                                            <th scope="col" class="py-3 px-4">Nombre de Usuario</th>
                                            <th scope="col" class="py-3 px-4">Acciones</th>
                                       
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($administradores as $admin):
                                            ?>
                                            <tr>
                                                <?php htmlspecialchars($admin->getIdAdmin()) ?>
                                                <td class="px-4"><?= htmlspecialchars($admin->getNombreUsuario()) ?></td>
                                                <td class="px-4"> 
                                                      <a href="?c=formulario&a=guardar&t=administrador&id=<?= htmlspecialchars($admin->getIdAdmin()) ?>" class="btn btn-sm btn-warning me-2 rounded-pill shadow-sm">
                                                       Editar
                                                    </a>
                                                    <a class="btn btn-danger zoom-out rounded-pill shadow-sm"
                                                        onclick="javascript:return confirm('¿Seguro de eliminar el administrador: <?= htmlspecialchars($admin->getNombreUsuario()) ?>?');" href="?c=login&a=eliminar&id_admin=<?= htmlspecialchars($admin->getIdAdmin()) ?>">
                                                        Eliminar
                                                    </a>
                                              </td>
                                              
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </section>
            </div>
        </div>
    </main>

    <footer class="bg-dark text-white text-center py-3 mt-auto shadow-lg">
        <div class="container">
            <p class="mb-0">&copy; 2025 Gestión de Administradores. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>