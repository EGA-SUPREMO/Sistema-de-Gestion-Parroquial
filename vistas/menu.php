<body>

  <nav class="main-nav">
    <div class="menu-toggle">
      <i aria-hidden="true" >Ξ</i>
    </div>
    <ul class="menu-list">
      <li><a href="?c=dashboard&a=index">Inicio</a></li>
      <li><a href="?c=formulario&a=guardar&t=intencion">Intenciones</a></li>
      <li><a href="?c=dashboard&a=constancias">Constancia</a></li>
      <li><a href="?c=login&a=mostrar">Agenda</a></li>
      <li><a href="?c=dashboard&a=administracion">Administración</a></li>
      <li> <a href="?c=login&a=cerrarSesion" class="w-100 d-flex align-items-center justify-content-center"
          onclick="javascript:return confirm('¿Seguro de salir?');">
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