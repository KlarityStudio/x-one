(function(){
	$(function(){
		productFilter();
		stickyNav();
  });

	function productFilter(){

		if ( $('body').hasClass('single-product') ) {
			var $phoneMakes = $('.swatch-wrapper'),
					$phones = $('#pa_phones'),
					$material = $('#picker_pa_material');

			if ( ! $phoneMakes.hasClass('selected') ) {
				$phones.css({
					'opacity':'0.3',
					'pointer-events': 'none'
				});
			}

			$phoneMakes.on('click', function(){
					$phones.css({
					'opacity':'1',
					'pointer-events': 'visible'
				});
			});

			if (! $phones.hasClass('selected') ) {
				$material.css({
					'opacity':'0.3',
					'pointer-events': 'none'
				});
			}

			$phones.on('click', function(){
				$(this).addClass('selected');
				$material.css({
					'opacity':'1',
					'pointer-events': 'visible'
				});
			});
		}

	}

	function stickyNav(){
		$(window).scroll(function() {
			if ($(this).scrollTop() > 1){
			    $('nav').addClass("sticky");
			  }
			  else{
			    $('nav').removeClass("sticky");
			  }
			});
	}
}) (jQuery);
