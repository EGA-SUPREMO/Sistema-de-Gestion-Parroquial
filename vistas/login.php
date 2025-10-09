<link rel="stylesheet" href="./public/css/login.css">

<body>
    <main class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-5"> 
                
                <header class="text-center mb-4">
                    <h1 class="login-title">Acceso al Sistema (SGDS)</h1>
                </header>
                <div id="error-message-container" style="display:none;"></div>

                <section class="login-card">
                    <form method="post" action="?c=login&a=login">
                        
                        <div class="mb-4">
                            <label for="usuario" class="form-label">Usuario</label>
                            <div class="input-group">
                                <span class="input-group-text">​​👤</span>
                                <input type="text" class="form-control" id="usuario" name="nombre_usuario" placeholder="" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="contrasena" class="form-label">Contraseña</label>
                             <div class="input-group">
                                <span class="input-group-text">🔑​</span>
                                <input type="password" class="form-control" id="contrasena" name="password" placeholder="" required>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2 mt-5">
                            <button type="submit" class="btn btn-primary">Ingresar</button>
                        </div>
                    </form>
                </section>

            </div>
        </div>
    </main>
    <div class="row justify-content-center">
</div>
<script src="public/js/bootstrap.bundle.min.js"></script>
<script src="public/js/jquery-1.12.4.min.js"></script>
<script src="public/js/mostrarError.js"></script>
</body>
</html>