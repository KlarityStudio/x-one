(function(){
	$(function(){
		productFilter();
		stickyNav();
		shopBrandMenu();
        cartMenu();
		categoryInfoSlider();
		phoneMakeText();
		dynamicStock();
		materialMenu();
		faq();
		sideBar();
  });

	function productFilter(){

		if ( $('body').hasClass('single-product') ) {
			var $phoneMakes = $('.swatch-wrapper'),
					$phones = $('#pa_phones'),
					$material = $('#picker_pa_material');

			if (($phoneMakes).hasClass('selected')) {
					$phones.css({
					'opacity':'1',
					'pointer-events': 'visible'
				});
			}

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

			$phoneMake.each(function(){
				var $dataAttribute = $(this).attr("data-value");

				$(this).children('a').append("<p>"+$dataAttribute+"</p>");
			});
		}
	}

	function dynamicStock(){
		var $stockAlert = $('.woocommerce-variation-add-to-cart'),
			$staticPrice = $('.entry-summary').children('div').find('.price');

			if ( ( $stockAlert ).hasClass("woocommerce-variation-add-to-cart-enabled") ){
				$staticPrice.hide();
			}else if (( $stockAlert ).hasClass("woocommerce-variation-add-to-cart-disabled")){
				$staticPrice.show();
			}
	}

	function materialMenu(){
		var $materialInputBox = $('#picker_pa_material').parent('.value');

		var $materialColor = $('#picker_pa_material').find(".select-option");

		$materialColor.each(function(){
			var $dataAttribute = $(this).attr("data-value");

			$(this).append("<p>"+$dataAttribute+"</p>");
		});

		$($materialInputBox).on('click',function(){
			$('#picker_pa_material').toggleClass('open');
			$(this).parent('tr').toggleClass('open');
		});
	}

	function faq(){
		var $sidebarList = $('.faq-sidebar').find('ul'),
			$faqArticle = $('.article-container').children('article');

		$sidebarList.children('li').first().addClass('reading');
		$faqArticle.first().addClass('reading');


		$sidebarList.children('li').on('click', function(){
			var $this = $(this),
				$siblings = $this.parent().children(),
				$position = $siblings.index($this);

			$this.siblings('li').removeClass('reading');
			$this.addClass('reading');


			$faqArticle.removeClass('reading').eq($position).addClass('reading');
			$(this).addClass('reading');


		});
	}
	function sideBar(){
		$('#woocommerce_layered_nav-2').children('h2').text("Phone Makes");
		$('#woocommerce_product_categories-2').children('h2').text("Categories");
		$('#woocommerce_layered_nav-3').children('h2').text("Colours");
	}
}) (jQuery);
