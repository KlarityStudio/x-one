(function(){
	$(function(){
    carousel();
	hideNav();
  });

	function carousel(){
		$('.owl-carousel').owlCarousel({
		    loop:true,
		    margin:10,
		    responsiveClass:true,
			autoplay:true,
			items:1,
			nav:true,
			navText: [
				"<i class='icon-chevron-left icon-white'></i>",
				"<i class='icon-chevron-right icon-white'></i>"
			],
			center:true,
			dots: true,
			autoHeight:true,
		    responsive:{
		        0:{
		            items:1,
		            nav:false
		        },
		        600:{
		            items:1,
		            nav:true
		        },
		        1000:{
		            items:1,
		            nav:true,
		            loop:true
		        }
		    }
		});

		$('#owl-product-carousel-screen-protectors').owlCarousel({
			loop:true,
			margin:10,
			responsiveClass:true,
			autoplay:false,
			items:4,
			nav:true,
			autoHeight:true,
			navText: [
				"<i class='icon-chevron-left icon-white'></i>",
				"<i class='icon-chevron-right icon-white'></i>"
			],
			center:false,
			responsive:{
				0:{
					items:1,
					nav:false
				},
				425:{
					items:2,
					nav:false
				},
				600:{
					items:2,
					nav:false
				},
				1000:{
					items:4,
					nav:true,
					loop:true
				}
			}
		});
		$('#owl-product-carousel-phone-covers').owlCarousel({
			loop:true,
			margin:10,
			responsiveClass:true,
			autoplay:false,
			items:4,
			nav:true,
			autoHeight:true,
			navText: [
				"<i class='icon-chevron-left icon-white'></i>",
				"<i class='icon-chevron-right icon-white'></i>"
			],
			center:false,
			responsive:{
				0:{
					items:1,
					nav:false
				},
				425:{
					items:2,
					nav:false
				},
				600:{
					items:2,
					nav:true
				},
				1000:{
					items:4,
					nav:true,
					loop:true
				}
			}
		});
		$('#owl-product-carousel-usb-cables').owlCarousel({
			loop:true,
			margin:10,
			responsiveClass:true,
			autoplay:false,
			items:4,
			nav:true,
			autoHeight:true,
			navText: [
				"<i class='icon-chevron-left icon-white'></i>",
				"<i class='icon-chevron-right icon-white'></i>"
			],
			center:false,
			responsive:{
				0:{
					items:1,
					nav:true
				},
				425:{
					items:2,
					nav:true
				},
				600:{
					items:2,
					nav:true
				},
				1000:{
					items:4,
					nav:true,
					loop:true
				}
			}
		});
	}
	function hideNav(){
		$('.category-section').each(function(){

			var $slider = $(this).find('.owl-stage-outer'),
				$indSlide = $(this).find('.owl-stage').children('div').length,
				$slideNav = $slider.siblings('.owl-controls');

			if ($indSlide <= 4) {
				$slideNav.css('display', 'none');
			}

		});
	}
}) (jQuery);
