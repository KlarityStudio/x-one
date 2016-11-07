(function(){
	$(function(){
		productFilter();
		stickyNav();
		shopBrandMenu();
  });

	function productFilter(){

		if ( $('body').hasClass('single-product') ) {
			var $phoneMakes = $('.swatch-wrapper'),
					$phones = $('#pa_phones'),
					$material = $('#picker_pa_material');

			$phoneMakes.on('click', function(){
					$phones.css({
					'opacity':'1',
					'pointer-events': 'visible'
				});
			});

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

	function shopBrandMenu(){
		var $shopNavLinks = $('#mega-menu-primary').find('a'),
				$menuFirstChilds = $('#mega-menu-item-132').children('.mega-sub-menu'),
				$link = $menuFirstChilds.children('li');

		$shopNavLinks.on('click', function(e){
			if ($(this).text().indexOf('Shop') !== -1) {
				e.preventDefault();
			}
		});

		$link .children('a').on('click', function(e){
			window.console.log('click');
			e.preventDefault();
		});
	}

}) (jQuery);
