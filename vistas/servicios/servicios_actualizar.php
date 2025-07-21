<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Servicios</title> <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <header class="bg-success text-white text-center py-3">
        <h1 class="mb-0">Editar Servicio</h1> </header>
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
            <h1 class="h4 mb-0">Datos del Servicio:</h1> </div>
        <div class="card-body">
            <form action="index.php?c=servicios&a=Actualizar" method="post" autocomplete="off"> <input type="hidden" name="id" value="<?php echo htmlspecialchars($servicio->id ?? ''); ?>" /> <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre del Servicio</label> <input
                        type="text"
                        name="nombre"
                        id="nombre"
                        class="form-control"
                        placeholder="Ingrese el nombre del servicio" value="<?php echo htmlspecialchars($servicio->nombre ?? ''); ?>" required
                    />
                </div>

                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción del Servicio</label> <textarea
                        name="descripcion"
                        id="descripcion"
                        class="form-control"
                        placeholder="Ingrese la descripción del servicio" rows="4"
                        required
                    ><?php echo htmlspecialchars($servicio->descripcion ?? ''); ?></textarea> </div>

                <hr />

                <div class="text-left">
                    <a href="index.php?c=servicios" class="btn btn-secondary">Cancelar</a> <button type="submit" class="btn btn-primary">Actualizar Servicio</button> </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>