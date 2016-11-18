(function(){
	$(function(){
		productFilter();
		stickyNav();
		shopBrandMenu();
        cartMenu();
		categoryInfoSlider();
		phoneMakeText();
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

    function cartMenu(){
        var $cart = $('.cart-count');

            $($cart).on({
				mouseenter: function () {
					$(this).children('ul').addClass('active');
				},
				mouseleave: function () {
					$(this).children('ul').removeClass('active');
				}
        });
    }
	function categoryInfoSlider(){
		var $categoryInfo = $('.category');

		$($categoryInfo).on({
			mouseenter: function () {
				$(this).find('.product-information > div').css({
					'background-color': '#23282D',
					'opacity':'0.68',
					'font-size': '12.5px',
					'line-height': '22px',
					'padding': '17px',
					'height':'118px'

				});
			},
			mouseleave: function () {
				$(this).find('.product-information > div').css({
					'opacity':'0',
					'padding': '0',
					'height':'0'
				});
			}
	});
	}

	function phoneMakeText(){
		if ($('body').hasClass('single-product')){

		var $phoneMake = $('#picker_pa_phone-makes').find('.select-option');

			if(($phoneMake).attr("data-attribute")){

				var $dataAttribute = $(this).attr("data-value");
				$(this).each(function(){
					$(this).append($dataAttribute);
				});

				}

		}
	}
}) (jQuery);
