<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGDS</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        :root {
            --green-primary: #28a745;
           
            --white: #f8f9fa;
            --white-border-input-text: rgba(255, 255, 255, 0.3);
            --white-input-icon: rgba(255, 255, 255, 0.7);
            --white-placeholder: rgba(255, 255, 255, 0.5);
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(-45deg, #66BB6A); 
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
            font-family: 'Poppins', sans-serif; 
            color: var(--white);
        }

        

        .login-title {
            font-weight: 700;
            color: var(--white);
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }
      
        .login-card {
            padding: 2.5rem;
            background: black;
            border-radius: 1rem;
            border: 1px solid var(--white-border-input-text);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        }

        .form-label {
            color: var(--white);
            font-weight: 500;
        }
        
        .input-group-text {
            background-color: transparent;
            border: none;
            color: var(--white-input-icon);
        }

        .form-control {
            background-color: var(--white-card-bg);
            border: none;
            border-bottom: 2px solid var(--white-border-input-text);
            border-radius: 0;
            color: var(--white);
            transition: border-color 0.3s ease;
        }

        .form-control::placeholder {
            color: var(--white-placeholder);
        }

        .form-control:focus {
            background-color: var(--white-card-bg);
            box-shadow: none;
            border-color: var(--white);
            color: var(--white);
        }
        
        .btn-primary {
            padding: 0.75rem;
            font-weight: 600;
            border-radius: 0.5rem;
            border: none;
            background-color: green;
            color: white;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .btn-primary:hover {
            background-color: green;
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
        }

        .alert-danger {
            background-color: rgba(220, 53, 69, 0.7);
            border-color: rgba(220, 53, 69, 0.8);
            color: white;
        }
    </style>
</head>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>