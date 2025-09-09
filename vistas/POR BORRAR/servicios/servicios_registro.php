<body>
<div class="container mt-5">
    <div class="card shadow-sm">
         <header class="bg-success text-white text-center py-3">
        <h1 class="mb-0">Registrar un Nuevo servicio</h1>
    </header>
        <div class="card-header bg-white text-white">
               


        <div class="card-body">
            <form action="index.php?c=servicios&a=Guardar" method="post" autocomplete="off"> <input type="hidden" name="id" value="" />

                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre del Servicio</label> <input
                        type="text"
                        name="nombre"
                        id="nombre"
                        class="form-control"
                        placeholder="Ingrese el nombre del servicio" value=""
                        required
                    />
                </div>

                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción del Servicio</label> <textarea
                        name="descripcion"
                        id="descripcion"
                        class="form-control"
                        placeholder="Ingrese una descripción detallada del servicio" rows="4"
                        required
                    ></textarea> </div>

                <hr />

                <div class="text-left">
                    <a href="index.php?c=servicios" class="btn btn-secondary">Cancelar</a> <button type="submit" class="btn btn-primary">Guardar Servicio</button> </div>
            </form>
        </div>
    </div>
</div>
<script src="public/js/jquery-1.12.4.min.js"></script>
<script src="public/js/generadorFormulario"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>