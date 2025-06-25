<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Peticiones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../public/styles.css">
</head>

<body class="d-flex flex-column min-vh-100 bg-light">

    <header class="bg-success text-white text-center py-3">
        <h1 class="mb-0">Gestión de Peticiones</h1>
    </header>

    <main class="container my-5 flex-grow-1">
        <div class="row justify-content-center">
            <section class="card shadow-lg rounded-4">
                <div class="card-body p-4 p-md-5">
                    <h2 class="card-title text-center mb-4 pb-2 border-bottom display-6 fw-bold text-success">
                        Listado de Peticiones </h2>

                    <div class="d-flex justify-content-end mb-4">
                        <a href="?c=peticiones&a=Registro" class="btn btn-primary btn-lg rounded-pill shadow-sm">
                             Añadir Nueva Petición </a>
                    </div>

                    <?php if (empty($peticiones)): ?>
                        <div class="alert alert-info text-center py-4 rounded-3" role="alert">
                            <i class="bi bi-info-circle-fill me-2"></i> No hay peticiones registradas aún. <p class="mt-2">¡Haz clic en "Añadir Nueva Petición" para empezar!</p>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover align-middle border rounded-3 overflow-hidden">
                                <thead class="table-success text-white">
                                    <tr>
                                        <th scope="col" class="py-3 px-4">ID Petición</th>
                                        <th scope="col" class="py-3 px-4">Feligrés</th>
                                        <th scope="col" class="py-3 px-4">Servicio</th>
                                        <th scope="col" class="py-3 px-4">Descripción</th>
                                        <th scope="col" class="py-3 px-4">Fecha Registro</th>
                                        <th scope="col" class="py-3 px-4">Fecha Inicio</th>
                                        <th scope="col" class="py-3 px-4">Fecha Fin</th>
                                        <th scope="col" class="py-3 px-4 text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($peticiones as $p): ?>
                                        <tr>
                                            <th scope="row" class="px-4"><?= htmlspecialchars($p->id) ?></th>
                                            <td class="px-4"><?= htmlspecialchars($p->feligres_nombre) ?></td>
                                            <td class="px-4"><?= htmlspecialchars($p->servicio_nombre) ?></td>
                                            <td class="px-4"><?= htmlspecialchars($p->peticion_descripcion) ?></td>
                                            <td class="px-4"><?= htmlspecialchars($p->fecha_registro) ?></td>
                                            <td class="px-4"><?= htmlspecialchars($p->fecha_inicio) ?></td>
                                            <td class="px-4"><?= htmlspecialchars($p->fecha_fin) ?></td>
                                            <td class="text-center px-4">
                                                <a href="?c=peticiones&a=Editar&id=<?= htmlspecialchars($p->id) ?>" class="btn btn-sm btn-warning me-2 rounded-pill shadow-sm">
                                                    Editar
                                                </a>

                                                <a class="btn btn-danger zoom-out rounded-pill shadow-sm"
                                                    onclick="javascript:return confirm('¿Seguro de eliminar la petición ID: <?= htmlspecialchars($p->id) ?>?');" href="?c=peticiones&a=Eliminar&id=<?= htmlspecialchars($p->id) ?>">
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
    </main>

    <footer class="bg-dark text-white text-center py-3 mt-auto shadow-lg">
        <div class="container">
            <p class="mb-0">&copy; 2025 Gestión Parroquial. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>