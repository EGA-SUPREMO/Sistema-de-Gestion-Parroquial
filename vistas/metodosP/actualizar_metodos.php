<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Métodos de Pago</title> <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <header class="bg-success text-white text-center py-3">
        <h1 class="mb-0">Editar Método de Pago</h1> </header>
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
            <h1 class="h4 mb-0">Datos del Método de Pago:</h1> </div>
        <div class="card-body">
            <form action="index.php?c=metodosP&a=Actualizar" method="post" autocomplete="off"> <input type="hidden" name="id" value="<?php echo htmlspecialchars($metodoPago->id ?? ''); ?>" /> <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre del Método de Pago</label> <input
                        type="text"
                        name="nombre"
                        id="nombre"
                        class="form-control"
                        placeholder="Ingrese el nombre del método de pago" value="<?php echo htmlspecialchars($metodoPago->nombre ?? ''); ?>" required
                    />
                </div>

                <hr />

                <div class="text-left">
                    <a href="index.php?c=metodos_pago" class="btn btn-secondary">Cancelar</a> <button type="submit" class="btn btn-primary">Actualizar Método de Pago</button> </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>