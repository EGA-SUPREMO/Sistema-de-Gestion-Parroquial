<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Feligreses</title>
  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <header class="bg-success text-white text-center py-3">
        <h1 class="mb-0">Editar  Feligres</h1>
    </header>
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
           
            <h1 class="h4 mb-0">Datos :</h1>
        </div>
        <div class="card-body">
          
            <form action="index.php?c=feligreses&a=Actualizar" method="post" autocomplete="off">
                
              
                <input type="hidden" name="id"   value="<?php echo $feligres->id;?>"  />
                
              
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre Completo</label>
                    <input 
                        type="text" 
                        name="nombre" 
                        id="nombre"
                        class="form-control" 
                        placeholder="Ingrese el nombre y apellido"
                        value="<?php echo $feligres->nombre;?>" 
                        required 
                    />
                </div>
                
         
                <div class="mb-3">
                    <label for="cedula" class="form-label">Cédula de Identidad</label>
                    <input type="text" id="cedula" name="cedula" class="form-control" placeholder="Ingrese el número de cédula (sin puntos)" pattern="\d{4,10}" maxlength="10" value="<?php echo $feligres->cedula;?>" required>
                </div>
                
                <hr />
                
             
                <div class="text-left">
                    <a href="index.php?c=feligreses" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Actualizar Feligrés</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
