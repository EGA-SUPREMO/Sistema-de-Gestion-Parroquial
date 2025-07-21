<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Administradores</title>
 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
          
               <header class="bg-success text-white text-center py-3">
                <h1 class="mb-0">
                    Editar Administrador
                </h1>
            </header>
        </div>
        <div class="card-body">
            <?php
                if (isset($errorMessage) && !empty($errorMessage)) {
                    echo '<div class="alert alert-danger text-center" role="alert">' . htmlspecialchars($errorMessage) . '</div>';
                }
            ?>
            <form action="index.php?c=login&a=actualizar" method="post" autocomplete="off">
                
                <input 
                    type="hidden" 
                    name="id_admin" 
                    value="<?= htmlspecialchars($admin->id_admin ?? '', ENT_QUOTES, 'UTF-8'); ?>" 
                />

                <div class="mb-3">
                    <label for="nombre_usuario" class="form-label">Nuevo Nombre de Usuario</label>
                    <input 
                        type="text" 
                        name="nombre_usuario" 
                        id="nombre_usuario"
                        class="form-control" 
                        placeholder="Ingrese el nombre de usuario"
                        value="<?= isset($admin->nombre_usuario) ? htmlspecialchars($admin->nombre_usuario) : '' ?>" 
                        required 
                    />
                </div>
                
                <div class="mb-3">
                    <label for="password" class="form-label">Nueva Contraseña</label>
                    <input 
                        type="password" 
                        name="password"
                        id="password"
                        class="form-control" 
                        placeholder="Ingrese la contraseña"
                        value="" 
                    />
                    <small class="form-text text-muted">Deja este campo vacío si no deseas cambiar la contraseña.</small>
                    </div>
                
                <hr />
                
                <div class="text-left">
                    <a href="index.php?c=login&a=mostrar" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">
                        Actualizar Administrador
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>