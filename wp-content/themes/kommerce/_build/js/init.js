(function(){
	$(function(){
		productFilter();
		stickyNav();
		shopBrandMenu();
        cartMenu();
		categoryInfoSlider();
		phoneMakeText();
		dynamicStock();
		// materialMenu();
		// colourMenu();
		faq();
		sideBar();
		modalAjax();
		socialAnimation();
		revealPosts();
		tagFilter();
		navToggle();
		breadcrumbFix();
		accountDisplay();
		phoneIcon();
		variablePrice();
		variablePriceInfinity();
  });

	function navToggle(){
	  $('#nav-toggle').on('click', function(){
		  $('#nav-toggle').toggleClass('active');

		  $('.menu-container').toggleClass('active');
		//   if ($('.menu-container').hasClass('active')) {
		// 	  $('.menu-container').show(200);
		//   }else {
		// 	  $('.menu-container').hide(200);
		//   }
	  });
	}

	function productFilter(){

		if ( $('body').hasClass('single-product') ) {
			var $phoneMakes = $('.swatch-wrapper'),
					$phones = $('#pa_phones'),
					$material = $('#picker_pa_material'),
					$colour = $('#picker_pa_colour');

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
				$colour.$material.css({
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

	// function materialMenu(){
	// 	var $materialInputBox = $('#picker_pa_material').parent('.value');
	//
	// 	var $materialColor = $('#picker_pa_material').find(".select-option");
	//
	// 	$materialColor.each(function(){
	// 		var $dataAttribute = $(this).attr("data-value");
	//
	// 		$(this).append("<p>"+$dataAttribute+"</p>");
	// 	});
	//
	// 	$($materialInputBox).on('click',function(){
	// 		$('#picker_pa_material').toggleClass('open');
	// 		$(this).parent('tr').toggleClass('open');
	// 	});
	// }
	//
	// function colourMenu(){
	// 	var $materialInputBox = $('#picker_pa_colour').parent('.value');
	//
	// 	var $materialColor = $('#picker_pa_colour').find(".select-option");
	//
	// 	$materialColor.each(function(){
	// 		var $dataAttribute = $(this).attr("data-value");
	//
	// 		$(this).append("<p>"+$dataAttribute+"</p>");
	// 	});
	//
	// 	$($materialInputBox).on('click',function(){
	// 		$('#picker_pa_colour').toggleClass('open');
	// 		$(this).parent('tr').toggleClass('open');
	// 	});
	// }

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
		$('.woocommerce-FormRow').children('label[for="username"]').text("Username or Email");
	}
	function modalAjax(){

		var $readButton = $('.post-footer').find('#read-more'),
			$ajaxLoad = $('.loading-gif');

		$($readButton).on("click", function(event) {

			event.preventDefault();
			$ajaxLoad.show();
			var $id = $(this).data('post'),
				$ajaxUrl = $(this).attr('data-url');

			$.ajax({
				type: 'POST',
				url: $ajaxUrl,
				context: this,
				data: {'action': 'post_modal', id: $id },
				success: function(response) {
					$ajaxLoad.hide();
					$('.modal-wrapper').html(response);
					window.console.log('open');
					$('.modal-wrapper').addClass('open');
					$('.modal-wrapper').fadeIn('slow');
					$('body').addClass('modal-open');
					return false;
				}
			});
		});
	}

	function tagFilter(){
		$('.tax-filter').on('click', function(event) {

			// Prevent default action - opening tag page
			if (event.preventDefault) {
				event.preventDefault();
			} else {
				event.returnValue = false;
			}
			// Get tag slug from title attirbute
			var $selecetd_taxonomy = $(this).attr('title'),
				$ajaxUrl = $('.tag-filter').attr('data-url');

			// After user click on tag, fade out list of posts
			$('.reveal').fadeOut();

			$.ajax({
				type: 'POST',
				url: $ajaxUrl,
				context: this,
				data: {'action': 'filter_posts', taxonomy: $selecetd_taxonomy},
				success: function(response) {
					$('.section-wrapper').html(response);
					$('.section-wrapper').fadeIn('slow');

					return false;
				}
			});

		});
	}

	function socialAnimation(){
		var $socialContainer = $('.social-wrapper'),
			$socialIcons = $('.social-container');

		$socialContainer
			.mouseover(function() {
				$(this).children($socialIcons).find('a').each(function(i){
					var $li = $(this);
					setTimeout(function() {
					  $li.addClass('show');
				  }, i*200);

				});
			})
			.mouseout(function() {
				$(this).children($socialIcons).find('a').each(function(i){
					var $li = $(this);
					setTimeout(function() {
					  $li.removeClass('show');
				  }, i*200);

				});
			});
	}

	function revealPosts(){
		if ($('body').hasClass('page-press-release')) {

			var $posts = $('article:not(.reveal)'),
				$i = 0 ;

			setInterval( function(){

				if( $i >= $posts.length ) {
					return false;
				}

				var $el = $posts[$i];
				$($el).addClass('reveal');
				$i++;

			}, 500 );
		}
	}
	function breadcrumbFix(){
		if ( $('body').hasClass('woocommerce-account')){
			var $breadCrumb = $('.woocommerce-breadcrumb');

			if ( $breadCrumb.children().length >= 2 ){
				$breadCrumb.children('a').last().text('My Account');
			}
		}
	}
	function accountDisplay(){
		var $bodyClass = $('body').hasClass('logged-in'),
			$accountNav = $('#mega-menu-primary').children('li');
		if ( $bodyClass ){
			$accountNav.find('a[href*="my-account"]').text('My Account');
		}else{
			$accountNav.find('a[href*="my-account"]').text('Login');
		}
	}

	function phoneIcon(){
		var $selectField = $('#picker_pa_phone-makes').children('.swatch-wrapper'),
			$selected = $('#picker_pa_phone-makes').children('.selected'),
			$selectValue = $selected.attr('data-value'),
			$icon = $('.icon-container').children('.icon');
			
		$icon.addClass($selectValue);

		$selectField.on('click', function(){
			var $selectValue = $(this).attr('data-value');
				$icon.removeClass('iphone');
				$icon.removeClass('samsung');
				$icon.addClass($selectValue);
		});
	}

	function variablePrice(){
		var priceText = $('.entry-summary').find('.price');

		if (priceText.children().length === 2){
			var price =  priceText.children().first().text();
			priceText.html('From <span>' + price + '</span>');
		}
	}

	function variablePriceInfinity(){
		$('.price-part').each(function() {
			var price = $(this).find('.price-text span').eq(0).text();
			$(this).find('.price-text').html('<span>' + price + '</span>');
		});
	}
}) (jQuery);
