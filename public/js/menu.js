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
