    <link rel="stylesheet" href="./public/css/login.css">

<body>
    <main class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-5"> 
                
                <header class="text-center mb-4">
                    <h1 class="login-title">Acceso al Sistema (SGDS)</h1>
                </header>

                <section class="login-card">
                    <?php

                    if (isset($errorMessage) && !empty($errorMessage)) {
                        echo '<div class="alert alert-danger text-center" role="alert">' . htmlspecialchars($errorMessage) . '</div>';
                    }
                    ?>
                    <form method="post" action="?c=login&a=login">
                        
                        <div class="mb-4">
                            <label for="usuario" class="form-label">Usuario</label>
                            <div class="input-group">
                                <span class="input-group-text">​​👤</span>
                                <input type="text" class="form-control" id="usuario" name="nombre_usuario" placeholder="Escribe tu usuario" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="contrasena" class="form-label">Contraseña</label>
                             <div class="input-group">
                                <span class="input-group-text">🔑​</span>
                                <input type="password" class="form-control" id="contrasena" name="password" placeholder="Escribe tu contraseña" required>
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
    <div class="col-12 col-md-8 col-lg-5">
        <?php
        if (isset($errorMensaje) && !empty($errorMensaje)) {

            echo '<div class="alert alert-danger text-center col-md-8 mx-auto" role="alert">' . htmlspecialchars($errorMessage) . '</div>';
        }
                    ?>

        </div>
</div>

<script src="public/js/bootstrap.bundle.min.js"></script>
</body>
</html>