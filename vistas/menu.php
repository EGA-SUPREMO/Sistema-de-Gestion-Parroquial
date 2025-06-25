<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>SGDS</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="./public/css/menu.css">
  <link rel="stylesheet" href="./public/css/bootstrap@5.3.3.css">
</head>

<body>

  <nav class="main-nav">
    <div class="menu-toggle">
      <i aria-hidden="true" >Ξ</i>
    </div>
    <ul class="menu-list">
      <li><a href="?c=login&a=dashboard">Inicio</a></li>
      <li><a href="?c=reporte&a=index">Reportes</a></li>
      <li><a href="?c=servicios&a=index">Servicios</a></li>
      <li><a href="?c=feligreses&a=index">Feligreses</a></li>
      <li><a href="?c=pagos&a=index">Pagos</a></li>
      <li><a href="?c=metodosP&a=index">Metodos de Pago</a></li>
      <li><a href="?c=peticiones&a=index">Peticiones</a></li>
      <li><a href="?c=login&a=mostrar">Administrador</a></li>
      <li> <a href="?c=login&a=cerrarSesion" class="w-100 d-flex align-items-center justify-content-center"
          onclick="javascript:return confirm('¿Seguro de salir');">
          Cerrar Sesión
        </a> </li>
    </ul>
  </nav>


  <script src="./public/js/jquery-1.12.4.min.js"></script>
  <script>
    $(document).ready(function() {
     
      $(".menu-toggle").on('click', function() {
        $(".menu-list").toggle('slow');
      });

   
      $(window).resize(function() {
        if ($(window).width() > 768) {
          $(".menu-list").show(); 
        } else {
        
          if ($(".menu-list").is(":visible") && $(".menu-toggle").css("display") === "block") {
       
          } else if ($(".menu-list").is(":visible") && $(".menu-toggle").css("display") === "none") {
            
            $(".menu-list").hide();
          }
        }
      });

      // Initial check for mobile view on page load
      if ($(window).width() <= 768) {
        $(".menu-list").hide();
      }
    });
  </script>

</body>

</html>