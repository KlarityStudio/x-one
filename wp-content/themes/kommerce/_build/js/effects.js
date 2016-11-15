(function(){
	$(function(){
    carousel();
  });

	function carousel(){
		$('.owl-carousel').owlCarousel({
			center: true,
			items:1,
			loop:true,
			margin:10,
			autoplay: true,
			responsive:{
				600:{
					items:1
				}
			}
		});
	}

}) (jQuery);
