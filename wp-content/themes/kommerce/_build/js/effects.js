(function(){
	$(function(){
    carousel();
  });
  function carousel(){
    window.console.log('home');
    $("#slider").owlCarousel({
        items : 4,
        itemsDesktop : [1199,3],
        itemsDesktopSmall : [979,3],
    });
  }
}) (jQuery);
