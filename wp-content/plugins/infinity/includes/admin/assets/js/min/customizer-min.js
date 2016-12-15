(function ($) {
	$(document).ready(function() {

	/* First we add the functions we need */

	function hideElements(el) {
		el.addClass('hidden');
	}

	//Hide invisible builder toggle
	function hideInvisible(element) {
		$(element)
			.html('')
			.html('<span href="#" class="display-hidden-toggle">Showing <strong>active parts</strong> <span><a href="">excluding</a> disabled</span></span>')
			.addClass('invisible-hidden')
			.nextAll('li.invisible')
			.hide();
	}
	//Show invisible builder toggle
	function showInvisible(element) {
		$(element)
			.html('')
			.html('<span href="#" class="display-hidden-toggle">Showing <strong>all parts</strong> <span><a href="">including</a> disabled</span></span>')
			.removeClass('invisible-hidden')
			.nextAll('li.invisible')
			.show();
	}

	function coverBuilder(el) {

		var tabs = $('<ul id="image-builder-tabs"><li class="icons"><span class="dashicons dashicons-forms"></span></li><li class="content"><span class="dashicons dashicons-schedule"></span></li><li class="show-hide-cover"><span class="dashicons dashicons-visibility"></span></li></ul>');

		//builderHeading.insertBefore($(el).find($("li[id*=customize-control-builder-options_image-icon-type-effect]")))
		if ( $("#image-builder-tabs").length !== 1 ) {
			tabs.insertBefore($(el).find($("li[id*=customize-control-builder-options_image-parts-content-type]")));
		}

		var coverToggle = $(el).find('li[id*=customize-control-builder-options_image-show-cover]').addClass('hidden');

		/***** modify icon builder *****/
		$(el).find($("li[id*=customize-control-builder-options_image-icon-type-]"))
			.wrapAll('<ul id="image-icon-options" class="clearfix"></ul>');

		var iconSortable = $(el).find('li[id*=customize-control-builder-options_image-cover-icon-type]');

		$(el).find('#image-icon-options')
			.addClass('image-options-wrapper')
			.appendTo(iconSortable);

		iconSortable.find('> label > .customize-control-title').remove();
		iconSortable.find('p.description').remove();

		/***** modify content builder *****/
		$(el).find($("li[id*=customize-control-builder-options_image-content-type-]"))
			.wrapAll('<ul id="image-content-options" class="clearfix"></ul>');

		var contentSortable = $(el).find('li[id*=customize-control-builder-options_image-parts-content-type]');

		$(el).find('#image-content-options')
			.addClass('image-options-wrapper')
			.appendTo(contentSortable);

		contentSortable.find('> label > .customize-control-title').remove();
		contentSortable.find('p.description').remove();

		var coverLi = $(el).find('li[id*=customize-control-builder-options_thumb-cover-type]');
		var coverSelect = coverLi.find('select');

		//toggle on click
		if ( coverToggle.find('input').prop('checked') === true ) {

			$('.show-hide-cover').removeClass('active');
			$('.disabled-line').remove();
			coverToggle.find('input').prop('checked', true).val(1).trigger('change');
			contentSortable.add(tabs.find('li.icons')).add(tabs.find('li.content')).add(iconSortable).removeClass('cover-disabled');
			$('.show-hide-cover').attr('data-toggled','off');

		} else  {

			$('.show-hide-cover').addClass('active');
			coverToggle.find('input').prop('checked', false).val(0).trigger('change');
			contentSortable.add(iconSortable).append('<div class="disabled-line"></div>');
			contentSortable.add(tabs.find('li.icons')).add(tabs.find('li.content')).add(iconSortable).addClass('cover-disabled');
			$('.show-hide-cover').attr('data-toggled','on');

		}

		tabs.find('li').click(function() {

			if ($(this).attr('class') === 'icons') {

				tabs.find('li').removeClass('active');
				$(this).addClass('active');
				coverSelect.val('icons').trigger('change');
				iconSortable.removeClass('hidden');
				contentSortable.addClass('hidden');

			} else if ($(this).attr('class') === 'content') {

				tabs.find('li').removeClass('active');
				$(this).addClass('active');
				coverSelect.val('content').trigger('change');
				iconSortable.addClass('hidden');
				contentSortable.removeClass('hidden');

			} else if ($(this).hasClass('show-hide-cover')) {

				if (!$(this).attr('data-toggled') || $(this).attr('data-toggled') === 'off') {

					$(this).addClass('active');
					coverToggle.find('input').prop('checked', false).val(0).trigger('change');
					contentSortable.add(iconSortable).append('<div class="disabled-line"></div>');
					contentSortable.add(tabs.find('li.icons')).add(tabs.find('li.content')).add(iconSortable).addClass('cover-disabled');
					$(this).attr('data-toggled','on');

				}
				else if ($(this).attr('data-toggled') === 'on') {

					$(this).removeClass('active');
					$('.disabled-line').remove();
					coverToggle.find('input').prop('checked', true).val(1).trigger('change');
					contentSortable.add(tabs.find('li.icons')).add(tabs.find('li.content')).add(iconSortable).removeClass('cover-disabled');
					$(this).attr('data-toggled','off');

				}

			}

		});

	}

	function showBuilder(el) {

			var tabs = $(el).find('#image-builder-tabs');
			var iconSortable = $(el).find('li[id*=customize-control-builder-options_image-cover-icon-type]');
			var contentSortable = $(el).find('li[id*=customize-control-builder-options_image-parts-content-type]');
			var coverLi = $(el).find('li[id*=customize-control-builder-options_thumb-cover-type]');
			var coverSelect = coverLi.find('select');

			if (coverSelect.val() === 'icons') {

				tabs.find('li.icons').addClass('active');
				iconSortable.removeClass('hidden');
				contentSortable.addClass('hidden');

			} else if (coverSelect.val() === 'content') {

				tabs.find('li.content').addClass('active');
				iconSortable.addClass('hidden');
				contentSortable.removeClass('hidden');

			}

	}

	function toggleSections(el) {

		/* Toggle heading sections - On Load */
		el.find($("li[id*=toggle-heading-]")).each(function() {

			$(this).nextUntil($("li[id*=toggle-heading-]")).addClass('hidden');
			$(this).append('<span class="dashicons dashicons-plus"></span>');
			//$(this).nextUntil($("li[id*=toggle-heading-]")).addClass('hidden');

		});

		/* Toggle heading sections - On Load */
		el.find($("li[id*=toggle-heading-]")).toggle(function() {

			//show
			$(this).find('.dashicons').removeClass('dashicons-plus').addClass('dashicons-minus');
			$(this).addClass('open').nextUntil($("li[id*=toggle-heading-]")).removeClass('hidden');
			hideElements($(this).siblings('li[id*=-hide-]'));
			if ( $(this).is('li[id*=customize-control-builder-options_toggle-heading-build-cover]') ) {
				showBuilder($(el));
			}

		}, function() {

			//hide
			$(this).find('.dashicons').removeClass('dashicons-minus').addClass('dashicons-plus');
			$(this).removeClass('open').nextUntil($("li[id*=toggle-heading-]")).addClass('hidden');

		});

	}

	var image_types = [
		"btn1",
		"btn2",
		"btn3",
		"btn4"
	];

	setTimeout(function(){

	//image icon options modifications
	$("li[id*=accordion-section-builder]").each(function(index, el) {

		$.each(image_types, function(index, image) {

			$(el).find($("li[id*=customize-control-builder-options_" + image + "-option-]"))
				.addClass('control-section accordion-section')
				.wrapAll('<ul id="' + image + '-options" class="clearfix"></ul>');

			var imageSortable = $(el).find($("li[id*=customize-control-builder-options_image-cover-icon-type-icons-] li." + image + ""));

			$(el).find('#' + image + '-options')
				.addClass('image-options builder-options')
				.appendTo(imageSortable)
				.hide();

			imageSortable.find('.dashicons-admin-generic').on( 'click', function() {

				if (!$(this).attr('data-toggled') || $(this).attr('data-toggled') === 'off'){
					$(this).addClass('active');
					$(this).attr('data-toggled','on').nextAll('.image-options').fadeIn();
				}
				else if ($(this).attr('data-toggled') === 'on'){
					$(this).removeClass('active');
					$(this).attr('data-toggled','off').nextAll('.image-options').fadeOut();
				}

			});

		});

	});

	//parts options modifications
	$("li[id*=accordion-section-builder]").each(function(index, el) {



		//add heading to toolbar
		//var str = $(this).attr('id');
		// //replace - with spaces
		// str = str.replace(/-/g, " ");
		// //return last words to get title
		// str = str.split(/\s+/).slice(3,20).join(" ");
		// var headingText = str;

		//create top toolbar with post display settings
		var postsToolbar = $('<ul id="posts-toolbar-options-'+ $(this).attr('id') +'" class="customizer-toolbar top"></ul>');
		postsToolbar.prependTo('.wp-full-overlay').hide();

		$(this).find("li[id*=customize-control-builder-options_postopts]").each(function() {
			$(this).appendTo(postsToolbar);
		});

		//create bottom toolbar with pagination settings
		var paginationToolbar = $('<ul id="pagination-toolbar-options-'+ $(this).attr('id') +'" class="customizer-toolbar bottom"></ul>');
		paginationToolbar.appendTo('.wp-full-overlay').hide();

		$(this).find("li[id*=customize-control-builder-options_pagination]").each(function() {
			$(this).prependTo(paginationToolbar);
		});

		$('.customizer-toolbar li').hover(function() {
			var desc = $(this).find('.description').not('.customize-control-description');
			if ( desc.text() !== '' ) {
				desc.show().addClass('vb-tooltip');
			}
		}, function() {
			var desc = $(this).find('.description').not('.customize-control-description');
			desc.hide().removeClass('vb-tooltip');
		});

		function toggleOrderingMetaVal(toggler, toolbar) {

			var input = toggler.find('select');

			if ( input.val() === 'meta_value' || input.val() === 'meta_value_num' ) {

				$(toggler).siblings("li[id*=customize-control-builder-options_postopts-order-meta-key-]").removeClass('hidden');

			} else {

				$(toggler).siblings("li[id*=customize-control-builder-options_postopts-order-meta-key-]").addClass('hidden');

			}

		}

		function toggleOnToolbarLoad(toggler, toolbar, toggleEl) {

			var input = toggler.find('.active input');

			if ( input.val() === 'carousel' || input.val() === 'grid' || input.val() === 'simple-masonry' ) {

				toolbar.find(toggleEl).removeClass('hidden');

			} else {

				toolbar.find(toggleEl).addClass('hidden');

			}

		}

		function inspectorHover(el) {

			var id = $(el).find('li[id*=customize-control-builder-options_id-hide-] .description').text();
			var previewDiv = $('#customize-preview');

			$(el).hover(
				function() {
					var title = $(this).find('li[id*=customize-control-builder-options_id-hide-] h3').text();
					previewDiv.children('iframe').contents().find('#view-'+id).prepend('<div class="hover-inspector inspector-view"><div class="inspector-info">'+ title +'</div></div>');
				}, function() {
					//previewDiv.children('iframe').contents().find('#view-'+id).find('.hover-inspector').remove();
				}
			);

		}

		inspectorHover($(this));

		var id = $(el).find('li[id*=customize-control-builder-options_id-hide-] .description').text();
		var previewDiv = $('#customize-preview');

		$(el).find("li[id*=customize-control-builder-options_builder_parts] li").hover(function() {
			var part = $(this).attr('data-value');
			part = part.replace(/-/g, " ");
			previewDiv.children('iframe').contents().find('#view-'+id+' .'+ part +'-part').addClass('hover-inspector part').prepend('<div class="inspector-info part">'+ part +'</div>');
		}, function() {
			previewDiv.children('iframe').contents().find('#view-'+id+' .vb-part').removeClass('hover-inspector').find('.inspector-info').remove();
		});

		//show toolbars on click
		$(this).click(function() {

			$('.customizer-toolbar').hide();

			hideElements($(this).find('li[id*=-hide-]'));

			$('#posts-toolbar-options-'+ $(this).attr('id') +'').show();
			var postsToolbarHeight = $('#posts-toolbar-options-'+ $(this).attr('id') +'').outerHeight();
			$('#customize-preview').css('marginTop', postsToolbarHeight);

			$('#pagination-toolbar-options-'+ $(this).attr('id') +'').show();
			var paginationToolbarHeight = $('#posts-toolbar-options-'+ $(this).attr('id') +'').outerHeight();
			$('#customize-preview iframe').contents().find('html').css('paddingBottom', paginationToolbarHeight+10);

			var toolbar = $('#posts-toolbar-options-'+ $(this).attr('id') +'');

			var orderByEl = $('#posts-toolbar-options-'+ $(this).attr('id') +'').find("li[id*=customize-control-builder-options_postopts-order-by]");
			toggleOrderingMetaVal( orderByEl, toolbar );

			var viewLayout = $(this).find("li[id*=customize-control-builder-options_view-layout]");
			var columns = $("li[id*=customize-control-builder-options_postopts-columns]");
			toggleOnToolbarLoad( viewLayout, toolbar, columns );

		});

		$("li[id*=customize-control-builder-options_postopts-order-by]").change(function() {

			toggleOrderingMetaVal($(this));

		});

		$("li[id*=customize-control-builder-options_postopts-post-categories] .customize-control-title").toggle(function() {

			if ( $("li[id*=customize-control-builder-options_postopts-post-categories] .tf-multicheck-container").find('p:first').find('input').prop('checked') === true ) {
				$("li[id*=customize-control-builder-options_postopts-post-categories] .tf-multicheck-container").find('p:first').nextAll().addClass('hidden');
			}
			$(this).addClass('active').next('.tf-multicheck-container').removeClass('hidden');

		}, function() {

			$(this).removeClass('active').next('.tf-multicheck-container').addClass('hidden');

		});


		//hide other options if all categories is checked
		$("li[id*=customize-control-builder-options_postopts-post-categories] .tf-multicheck-container p").first().find('input').change(function() {
			if ( $(this).prop('checked') === true ) {
				$("li[id*=customize-control-builder-options_postopts-post-categories] .tf-multicheck-container").find('p:first').nextAll().addClass('hidden');
			} else{
				$("li[id*=customize-control-builder-options_postopts-post-categories] .tf-multicheck-container").find('p:first').nextAll().removeClass('hidden');
			}
		});

		coverBuilder($(el));

		//add show/hide button to show or hide invisible elements
		var builderSortablesList = $(el).find($("li[id*=customize-control-builder-options_builder_parts] .infinity-sortable"));
		// builderSortablesList.prepend('
		// 	<span href="#" class="display-hidden-toggle">Showing <strong>all parts</strong> <span><a href="">including</a> disabled</span></span>
		// ');
		var overlayBuilderSortablesList = $(el).find($("li[id*=customize-control-builder-options_image-parts] .infinity-sortable"));
		// overlayBuilderSortablesList.prepend('
		// 	<span href="#" class="display-hidden-toggle">Showing <strong>all parts</strong> <span><a href="">including</a> disabled</span></span>
		// ');
		var instanceID = $(el).attr('id');
		var status = localStorage.getItem('show-hide-invisible#'+instanceID);//showing or hidden
		var displayToggle = $(el).find('.display-hidden-toggle');

		if (status == 'hidden') {
			hideInvisible(displayToggle);
		}

		$(el).find('.display-hidden-toggle').click(function(el) {
			if ( $(this).hasClass('invisible-hidden' || status == 'hidden') ) {
				localStorage.setItem('show-hide-invisible#'+instanceID,'showing');
				showInvisible($(this));
			} else {
				localStorage.setItem('show-hide-invisible#'+instanceID,'hidden');
				hideInvisible($(this));
			}
			el.preventDefault();
		});


		//create part types array from sortables data-value
		var builderSortables = $(el).find($("li[id*=customize-control-builder-options_builder_parts] .infinity-sortable li"));

		part_types = [];

		builderSortables.each(function() {
			part_types.push($(this).attr('data-value'));
		});

		$.each(part_types, function(index, part_type) {

			//setup part options
			$(el).find($("li[id*=customize-control-builder-options_" + part_type + "-option-]"))
				.addClass('control-section accordion-section')
				.wrapAll('<ul id="' + part_type + '-options" class="clearfix"></ul>');

			var builderSortable = $(el).find($("li[id*=customize-control-builder-options_builder_parts] li." + part_type + ""));
			var coverbuilderSortable = $(el).find($("li[id*=customize-control-builder-options_image-parts] li." + part_type + ""));

			$(el).find('#' + part_type + '-options')
				.addClass('part-options builder-options')
				.appendTo(builderSortable)
				.hide();

			builderSortable.find('.dashicons-admin-generic').on( 'click', function() {

				if (!$(this).attr('data-toggled') || $(this).attr('data-toggled') === 'off') {
					builderSortable.find('.style-options').fadeOut();
					$(this).siblings('.dashicons-admin-appearance').removeAttr('data-toggled').removeClass('active');
					$(this).addClass('active');
					$(this).attr('data-toggled','on');
					$(el).find('#' + part_type + '-options')
						.show()
						.appendTo(builderSortable);
					coverbuilderSortable.find('.dashicons-admin-generic').attr('data-toggled','off').removeClass('active');
				}
				else if ($(this).attr('data-toggled') === 'on') {
					$(this).removeClass('active');
					$(this).attr('data-toggled','off').nextAll('.part-options').fadeOut();
				}

			});

			var coverbuilderSortable = $(el).find($("li[id*=customize-control-builder-options_image-parts] li." + part_type + ""));

			coverbuilderSortable.find('.dashicons-admin-generic').on( 'click', function() {

				if (!$(this).attr('data-toggled') || $(this).attr('data-toggled') === 'off') {
					coverbuilderSortable.find('.style-options').fadeOut();
					$(this).siblings('.dashicons-admin-appearance').removeAttr('data-toggled').removeClass('active');
					$(this).addClass('active');
					$(this).attr('data-toggled','on');
					$(el).find('#' + part_type + '-options')
						.show()
						.addClass('part-options builder-options')
						.appendTo(coverbuilderSortable);
					builderSortable.find('.dashicons-admin-generic').attr('data-toggled','off').removeClass('active');
				}
				else if ($(this).attr('data-toggled') === 'on') {
					$(this).removeClass('active');
					$(this).attr('data-toggled','off');
					$(el).find('#' + part_type + '-options').hide();
				}

			});


			//setup part styling options
			$(el).find($("li[id*=customize-control-builder-options_" + part_type + "-styles-]"))
				.addClass('control-section accordion-section')
				.wrapAll('<ul id="' + part_type + '-styles" class="clearfix"></ul>');

			$(el).find('#' + part_type + '-styles')
				.addClass('style-options builder-options')
				.appendTo(builderSortable)
				.hide();

			builderSortable.find('.dashicons-admin-appearance').on( 'click', function() {

				if (!$(this).attr('data-toggled') || $(this).attr('data-toggled') === 'off') {
					builderSortable.find('.part-options').fadeOut();
					$(this).siblings('.dashicons-admin-generic').removeAttr('data-toggled').removeClass('active');
					$(this).addClass('active');
					$(this).attr('data-toggled','on').nextAll('.style-options').fadeIn();
				}
				else if ($(this).attr('data-toggled') === 'on'){
					$(this).removeClass('active');
					$(this).attr('data-toggled','off').nextAll('.style-options').fadeOut();
				}

			});

		});//end each

		$(this).find("li[id*=customize-control-builder-options_view-layout]").find('.tf-radio-image').each(function() {
			if ($(this).find('input').attr('checked')) {
				$(this).addClass('active');
			}
			$(this).click(function() {
				var layout = $(this).find('input').val();
				var id = $(this).parents('.accordion-section').attr('id');
				if ( layout == 'carousel' || layout == 'grid' || layout == 'simple-masonry' ) {
					$("#posts-toolbar-options-" + id + " li[id*=customize-control-builder-options_postopts-columns]").removeClass('hidden');
				} else {
					$("#posts-toolbar-options-" + id + " li[id*=customize-control-builder-options_postopts-columns]").addClass('hidden');
				}
				$(this).siblings('.tf-radio-image').removeClass('active');
				$(this).addClass('active');
			});
		});

		toggleSections($(this));


	});//end parts options modifications

	}, 3000);

	});
})(jQuery);


;(function($) {

    "use strict";





    // Separator
    window.separator = ' ';

    // After main page load, go to loading iframe.
    window.onload = function() {
        setTimeout(function() {
            var s = $("#iframe").attr("data-href");
            $("#iframe").attr("src", s);
        }, 5);
    }

    // All Yellow Pencil Functions.
    window.yellow_pencil_main = function() {

            // onscreen plugin.
            $.expr[":"].onScreenFrame = function(n) {
                var t = $(document),
                    o = t.scrollTop(),
                    r = t.height(),
                    c = o + r,
                    f = $(document).find(n),
                    i = f.offset().top,
                    h = f.height(),
                    u = i + h;
                return i >= o && c > i || u > o && c >= u || h > r && o >= i && u >= c;
            }

            // Don't load again.
            if ($("body").hasClass("yp-yellow-pencil-loaded")) {
                return false;
            }

            // for custom selector
            window.setSelector = false;

            // Seting popular variables.
            var iframe = $($('#iframe').contents().get(0));
            var iframeBody = iframe.find("body");
            var body = $(document.body).add(iframeBody);
            var mainDocument = $(document).add(iframe);

            // Lite Version Modal Close
            $(".yp-info-modal-close").click(function() {
                $(this).parent().parent().hide();
                $(".yp-popup-background").hide();
            });

            // Background uploader Popup Close.
            $(".yp-popup-background").click(function() {
                $(this).hide();
                $(".yp-info-modal").hide();
            });

            $(".yp-selector-mode").click(function() {
                if ($(this).hasClass("active") == true && $(".yp-sharp-selector-btn.active").length > 0) {
                    $(".yp-sharp-selector-btn").removeClass("active");
                }
                body.toggleClass("yp-body-selector-mode-active");
                yp_clean();
            })

            // cache
            window.scroll_width = yp_get_scroll_bar_width();

            function yp_draw_responsive_handler() {

                if ($("body").hasClass("yp-responsive-device-mode") == false) {
                    return false;
                }

                // variables
                var iframeElement = $("#iframe");

                var offset = iframeElement.offset();
                var leftOffset = offset.left;
                var topOffset = offset.top;

                var w = iframeElement.width();
                var h = iframeElement.height();

                var left = leftOffset + w;
                var top = topOffset + h;

                $(".responsive-right-handle").css("left", left);
                $(".responsive-right-handle").css("top", topOffset - 2);
                $(".responsive-right-handle").css("height", h + 2);

                $(".responsive-bottom-handle").css("left", leftOffset);
                $(".responsive-bottom-handle").css("top", top);
                $(".responsive-bottom-handle").css("width", w);

            }

            // right
            window.responsiveModeRMDown = false;
            window.SelectorDisableResizeRight = false;
            window.rulerWasActive = false

            $(".responsive-right-handle").on("mousedown", function(e) {
                window.responsiveModeRMDown = true;
                body.addClass("yp-clean-look yp-responsive-resizing yp-responsive-resizing-right yp-hide-borders-now");

                if ($(".yp-ruler-btn").hasClass("active")) {
                    window.rulerWasActive = true;
                } else {
                    window.rulerWasActive = false;
                    $(".yp-ruler-btn").trigger("click");
                }

                if ($(".yp-selector-mode").hasClass("active") == true && body.hasClass("yp-content-selected") == false) {
                    $(".yp-selector-mode").trigger("click");
                    window.SelectorDisableResizeRight = true;
                }

            });

            mainDocument.on("mousemove", function(e) {
                if (window.responsiveModeRMDown == true) {

                    if (body.hasClass("yp-css-editor-active") == true && $(this).find("#iframe").length == 0) {
                        e.pageX = e.pageX - 10;
                    } else if (body.hasClass("yp-css-editor-active") == true && $(this).find("#iframe").length > 0) {
                        e.pageX = e.pageX - 460;
                    } else if ($(this).find("#iframe").length > 0) {
                        e.pageX = e.pageX - 54;
                    } else {
                        e.pageX = e.pageX - 20;
                    }

                    // Min 320
                    if (e.pageX < 320) {
                        e.pageX = 320;
                    }

                    // Max full-80 W
                    if (body.hasClass("yp-css-editor-active")) {
                        if (e.pageX > $(window).width() - 80 - 450 && $(this).find("#iframe").length > 0) {
                            e.pageX = $(window).width() - 80 - 450;
                        }
                    } else {
                        if (e.pageX > $(window).width() - 80 - 44 && $(this).find("#iframe").length > 0) {
                            e.pageX = $(window).width() - 80 - 44;
                        }
                    }

                    // Max full-80 W
                    if (e.pageX > $(window).width() - 80 && $(this).find("#iframe").length == 0) {
                        e.pageX = $(window).width() - 80;
                    }

                    $("#iframe").width(e.pageX);
                    yp_draw_responsive_handler();

                    yp_update_sizes();

                }
            });

            mainDocument.on("mouseup", function() {

                if (window.responsiveModeRMDown == true) {
                    window.responsiveModeRMDown = false;

                    if (window.SelectorDisableResizeBottom == false) {
                        yp_draw();
                    }

                    body.removeClass("yp-clean-look yp-responsive-resizing yp-responsive-resizing-right");

                    setTimeout(function() {
                        body.removeClass("yp-hide-borders-now");
                    }, 25);

                    if (window.SelectorDisableResizeRight == true) {
                        $(".yp-selector-mode").trigger("click");
                        window.SelectorDisableResizeRight = false;
                    }

                    if (window.rulerWasActive == false) {
                        $(".yp-ruler-btn").trigger("click");
                    }

                    // Update options
                    yp_insert_default_options();

                    setTimeout(function() {
                        $(".eye-enable").removeClass("eye-enable");
                    }, 10);

                }

            });

            // bottom
            window.responsiveModeBMDown = false;
            window.SelectorDisableResizeBottom = false;

            $(".responsive-bottom-handle").on("mousedown", function(e) {
                window.responsiveModeBMDown = true;
                body.addClass("yp-clean-look yp-responsive-resizing yp-responsive-resizing-bottom yp-hide-borders-now");

                if ($(".yp-ruler-btn").hasClass("active")) {
                    window.rulerWasActive = true;
                } else {
                    window.rulerWasActive = false;
                    $(".yp-ruler-btn").trigger("click");
                }

                if ($(".yp-selector-mode").hasClass("active") == true && body.hasClass("yp-content-selected") == false) {
                    $(".yp-selector-mode").trigger("click");
                    window.SelectorDisableResizeBottom = true;
                }

            });

            mainDocument.on("mousemove", function(e) {
                if (window.responsiveModeBMDown == true) {

                    if ($(this).find("#iframe").length > 0) {
                        e.pageY = e.pageY - 41;
                    } else {
                        e.pageY = e.pageY - 20;
                    }

                    // Min 320
                    if (e.pageY < 320) {
                        e.pageY = 320;
                    }

                    // Max full-80 H
                    if (e.pageY > $(window).height() - 80 - 31 && $(this).find("#iframe").length > 0) {
                        e.pageY = $(window).height() - 80 - 31;
                    }

                    // Max full-80 H
                    if (e.pageY > $(window).height() - 80 && $(this).find("#iframe").length == 0) {
                        e.pageY = $(window).height() - 80;
                    }

                    $("#iframe").height(e.pageY);
                    yp_draw_responsive_handler();

                    yp_update_sizes();

                }
            });

            mainDocument.on("mouseup", function() {

                if (window.responsiveModeBMDown == true) {
                    window.responsiveModeBMDown = false;

                    if (window.SelectorDisableResizeBottom == false) {
                        yp_draw();
                    }

                    body.removeClass("yp-clean-look yp-responsive-resizing yp-responsive-resizing-bottom");

                    setTimeout(function() {
                        body.removeClass("yp-hide-borders-now");
                    }, 25);

                    if (window.SelectorDisableResizeBottom == true) {
                        $(".yp-selector-mode").trigger("click");
                        window.SelectorDisableResizeBottom = false;
                    }

                    if (window.rulerWasActive == false) {
                        $(".yp-ruler-btn").trigger("click");
                    }

                    // Update options
                    yp_insert_default_options();

                    setTimeout(function() {
                        $(".eye-enable").removeClass("eye-enable");
                    }, 10);

                }

            });

            // Setting Shortcuts.
            mainDocument.on("keydown", function(e) {

                // Getting current tag name.
                var tag = e.target.tagName.toLowerCase();

                // Getting Keycode.
                var code = e.keyCode || e.which;

                // Control
                var ctrlKey = 0;
                var tagType = 0;

                // Stop If CTRL Keys hold.
                if ((e.ctrlKey === true || e.metaKey === true)) {
                    ctrlKey = 1;
                }

                // ESC for custom selector.
                if (code == 27 && ctrlKey == 0 && tagType == 0) {
                    if (!$(".yp-button-target.active").length > 0) {
                        $("#yp-button-target-input").val("");
                        $(".yp-button-target").trigger("click");
                        return false;
                    }
                }

                // Stop if this target is input or textarea.
                if (tag == 'input' || tag == 'textarea') {
                    tagType = 1;
                }

                if (code == 13 && ctrlKey == 0) {
                    if ($(e.target).is("#yp-set-animation-name")) {
                        $(".yp-animation-creator-start").trigger("click");
                    }
                }

                // Z Key
                if (code == 90 && ctrlKey == 1 && tagType == 0) {
                    e.preventDefault();

                    if ($("body").hasClass("yp-anim-creator")) {
                        alert(l18_cantUndo);
                        return false;
                    }

                    body.addClass("undo-clicked");

                    editor.commands.exec("undo", editor);

                    var element = iframe.find(yp_get_current_selector());

                    if (element.length > 0) {

                        if (element.css("position") == "static" && element.hasClass("ready-for-drag") == false) {
                            element.addClass("ready-for-drag");
                        }

                    }

                    body.addClass("yp-css-data-trigger");
                    $("#cssData").trigger("keyup");
                    yp_draw();
                    setTimeout(function() {
                        yp_draw();
                    }, 20);

                    return false;
                }

                // Y Key
                if (code == 89 && ctrlKey == 1 && tagType == 0) {
                    e.preventDefault();

                    if ($("body").hasClass("yp-anim-creator")) {
                        alert(l18_cantUndo);
                        return false;
                    }

                    editor.commands.exec("redo", editor);

                    var element = iframe.find(yp_get_current_selector());

                    if (element.length > 0) {
                        if (element.css("position") == "static" && element.hasClass("ready-for-drag") == false) {
                            element.addClass("ready-for-drag");
                        }

                    }

                    body.addClass("yp-css-data-trigger");
                    $("#cssData").trigger("keyup");
                    yp_draw();
                    setTimeout(function() {
                        yp_draw();
                    }, 20);

                    return false;
                }

                // ESC
                if (code == 27 && ctrlKey == 0 && tagType == 0) {

                    e.preventDefault();

                    if ($("body").hasClass("autocomplete-active") == false && $(".iris-picker:visible").length == 0) {

                        if (!$("body").hasClass("css-editor-close-by-editor")) {
                            if ($("#cssEditorBar").css("display") == 'block') {
                                if (body.hasClass("yp-fullscreen-editor")) {
                                    body.removeClass("yp-fullscreen-editor");
                                }
                                $(".css-editor-btn").trigger("click");
                                return false;
                            } else if ($("body").hasClass("yp-contextmenuopen")) {
                                iframe.trigger("scroll");
                                $("body").removeClass("yp-contextmenuopen");
                                return false;
                            } else if ($("body").hasClass("yp-content-selected")) {
                                yp_clean();
                                yp_resize();
                                return false;
                            }

                        } else {
                            $("body").removeClass("css-editor-close-by-editor");
                            return false;
                        }

                    } else {
                        body.removeClass("yp-select-open");
                    }

                }

                // Space key go to selected element
                if (code == 32 && ctrlKey == 0 && tagType == 0) {

                    e.preventDefault();

                    var element = iframe.find(".yp-selected");

                    if (iframe.find(".yp-selected-tooltip").hasClass("yp-fixed-tooltip") == true || iframe.find(".yp-selected-tooltip").hasClass("yp-fixed-tooltip-bottom") == true) {
                        var height = parseInt($(window).height() / 2);
                        var selectedHeight = parseInt(element.height() / 2);
                        var scrollPosition = selectedHeight + element.offset().top - height;
                        iframe.scrollTop(scrollPosition);
                    }

                    return false;

                }

                // R Key
                if (code == 82 && ctrlKey == 0 && tagType == 0) {
                    e.preventDefault();
                    $(".yp-ruler-btn").trigger("click");
                    return false;
                }

                // H Key
                if (code == 72 && ctrlKey == 0 && tagType == 0) {
                    e.preventDefault();
                    yp_toggle_hide();
                    return false;
                }

                // L Key
                if (code == 76 && ctrlKey == 0 && tagType == 0) {
                    e.preventDefault();
                    body.toggleClass("yp-hide-borders-now");
                    return false;
                }

                // " Key
                if (code == 162 && ctrlKey == 0 && tagType == 0 && $("body").hasClass("process-by-code-editor") == false) {
                    e.preventDefault();

                    if ($("body").hasClass("yp-anim-creator")) {
                        alert(l18_cantEditor);
                        return false;
                    }

                    $(".css-editor-btn").trigger("click");
                    return false;
                }

                // " For Chrome Key
                if (code == 192 && ctrlKey == 0 && tagType == 0 && $("body").hasClass("process-by-code-editor") == false) {
                    e.preventDefault();

                    if ($("body").hasClass("yp-anim-creator")) {
                        alert(l18_cantEditor);
                        return false;
                    }

                    $(".css-editor-btn").trigger("click");
                    return false;
                }

                // F Key
                if (code == 70 && ctrlKey == 0 && tagType == 0) {
                    e.preventDefault();
                    $(".yp-button-target").trigger("click");
                    return false;
                }

            });

            // Arrow Keys Up/Down The Value.
            $(".yp-after-css-val").keydown(function(e) {

                var code = e.keyCode || e.which;

                if (code == 38) {
                    $(this).val(parseFloat($(this).val()) + parseFloat(1));
                }

                if (code == 40) {
                    $(this).val(parseFloat($(this).val()) - parseFloat(1));
                }

            });

            // Arrow Keys Up/Down The Value.
            $(".yp-after-prefix").keydown(function(e) {

                var code = e.keyCode || e.which;

                if (code == 40 || code == 38) {

                    // em -> % -> px
                    if ($(this).val() == 'em') {
                        $(this).val("%");
                    } else if ($(this).val() == '%') {
                        $(this).val("px");
                    } else if ($(this).val() == 'px') {
                        $(this).val("em");
                    }

                }

            });

            // Close Shortcut for editor.
            editor.commands.addCommand({

                name: 'close',
                bindKey: {
                    win: 'ESC',
                    mac: 'ESC'
                },
                exec: function(editor) {

                    if (body.hasClass("yp-fullscreen-editor")) {
                        body.removeClass("yp-fullscreen-editor");
                    }

                    $(".css-editor-btn").trigger("click");
                    $("body").removeClass("process-by-code-editor");
                    $("body").addClass("css-editor-close-by-editor");

                },

                readOnly: false

            });

            // Disable forms in iframe.
            iframe.find("form").submit(function(e) {
                e.preventDefault();
                return false;
            });

            // Keyup: Custom Slider Value
            $(".yp-after-css").keyup(function(e) {

                yp_slide_action($(this).parent().parent().find(".wqNoUi-target"), $(this).parent().parent().find(".wqNoUi-target").attr("id").replace("yp-", ""), false);

            });

            $(".yp-ruler-btn").click(function() {
                body.toggleClass("yp-metric-disable");
                yp_resize();

                // Disable selector mode.
                if ($(this).hasClass("active") == false) {
                    if ($(".yp-selector-mode.active").length > 0) {
                        window.SelectorModeWasActive = true;
                        $(".yp-selector-mode").removeClass("active");
                    }
                } else {
                    $(".yp-selector-mode").addClass("active");
                }

                return false;
            });

            // Single selector
            $(".yp-sharp-selector-btn").click(function() {
                body.toggleClass("yp-sharp-selector-mode-active");
                if ($(".yp-selector-mode.active").length == 0) {
                    $(".yp-selector-mode").trigger("click");
                }
            });

            // Update on Enter Key.
            $(".yp-after-css-val").keydown(function(e) {

                switch (e.which) {
                    case 13:
                        $(this).trigger("blur");
                        return false;
                        break;
                }

            });

            // Getting ID.
            function yp_id_hammer(element) {
                return $(element).attr("id").replace("-group", "");
            }

            $.fn.cssImportant = function(rule, value) {

                // Set default CSS.
                this.css(rule, value);

                // add important
                $(this).attr("style", this.attr("style").replace(rule + ": " + value, rule + ": " + value + " !important"));

            };

            $(".yp-button-live").click(function() {

                var el = $(this);
                var href = el.attr("data-href");
                el.addClass("live-btn-loading");

                if ($("body").hasClass("yp-yellow-pencil-demo-mode")) {
                    alert(l18_live_preview);
                    el.removeClass("live-btn-loading");
                    return false;
                }

                var posting = $.post(ajaxurl, {

                    action: "yp_preview_data_save",
                    yp_data: yp_get_clean_css(true),
                });

                // Done.
                posting.complete(function(data) {
                    el.removeClass("live-btn-loading");
                    window.open(href, href);
                    return false;
                });

            });

            /* ---------------------------------------------------- */
            /* YP_SET_SELECTOR                                      */
            /*                                                      */
            /* Creating tooltip, borders. Set as selected element.  */
            /* ---------------------------------------------------- */
            function yp_set_selector(selector) {

                yp_clean();

                window.setSelector = selector;

                var element = iframe.find(selector.replace(":hover", "").replace(":focus", ""));

                body.attr("data-clickable-select", selector);

                if (iframe.find(".yp-will-selected").length > 0) {
                    iframe.find(".yp-will-selected").trigger("mouseover").trigger("click");
                    iframe.find(".yp-will-selected").removeClass("yp-will-selected");
                } else {
                    element.first().trigger("mouseover").trigger("click");
                }

                if (element.length > 1) {
                    element.addClass("yp-selected-others");
                    iframe.find(".yp-selected").removeClass("yp-selected-others");
                }

                body.addClass("yp-content-selected");

                var tooltip = iframe.find(".yp-selected-tooltip");
                tooltip.html("<small>" + iframe.find(".yp-selected-tooltip small").html() + "</small> " + selector);

                if (selector.match(/:hover/g)) {

                    body.addClass("yp-selector-hover");
                    body.attr("data-yp-selector", ":hover");
                    $(".yp-contextmenu-hover").addClass("yp-active-contextmenu");
                    iframe.find(".yp-selected-tooltip span").remove();
                    selector = selector.replace(":hover", "");

                }

                if (selector.match(/:focus/g)) {

                    body.addClass("yp-selector-focus");
                    body.attr("data-yp-selector", ":focus");
                    $(".yp-contextmenu-focus").addClass("yp-active-contextmenu");
                    iframe.find(".yp-selected-tooltip span").remove();
                    selector = selector.replace(":focus", "");

                }

                yp_toggle_hide(true); // show if hide

                body.attr("data-clickable-select", selector);

                yp_insert_default_options();

                yp_resize();

                yp_draw();

                window.setSelector = false;

            }

            // Get All Data and set to editor.
            editor.setValue(yp_get_clean_css(true));

            // Tooltip
            $('[data-toggle="tooltip"]').tooltip({
                animation: false,
                container: ".yp-select-bar",
                html: true
            });
            $('[data-toggle="tooltip-left"]').tooltip({
                animation: false,
                placement: 'bottom',
                container: ".yp-select-bar"
            });
            $('[data-toggle="popover"]').popover({
                animation: false,
                trigger: 'hover',
                container: ".yp-select-bar"
            });
            $(".yp-none-btn").tooltip({
                animation: false,
                container: '.yp-select-bar',
                title: l18_none
            });
            $(".yp-element-picker").tooltip({
                animation: false,
                placement: 'bottom',
                container: '.yp-select-bar',
                title: l18_picker
            });

            // CSSEngine is javascript based jquery
            // plugin by WaspThemes Team.
            $(document).CallCSSEngine(yp_get_clean_css(true));

            // Set Class to Body.
            body.addClass("yp-yellow-pencil");
            body.addClass("yp-yellow-pencil-loaded");

            // Draggable editor area
            $(".yp-select-bar").draggable({
                axis: "x",
                containment: "parent",
                handle: ".yp-editor-top"
            });

            $(".anim-bar").draggable({
                handle: ".anim-bar-title",
                stop: function() {
                    $(".anim-bar").addClass("anim-bar-dragged");
                }
            });

            $("#yp-set-animation-name").keyup(function() {
                $(this).val(yp_id($(this).val()).replace(/\d+/g, ''));
            });

            // Fullscreen Editor
            $(".yp-css-fullscreen-btn").click(function() {

                // Fullscreen class
                body.toggleClass("yp-fullscreen-editor");

                editor.focus();
                editor.execCommand("gotolineend");
                editor.resize();

            });

            // If There not have any selected item
            // and if mouseover on options, so hide borders.
            $(".top-area-btn-group,.yp-select-bar,.metric").hover(function() {
                if (body.hasClass("yp-content-selected") == false) {
                    yp_clean();
                }
            });

            function yp_anim_scene_resize() {
                if (!$(".anim-bar").hasClass("anim-bar-dragged")) {
                    $(".anim-bar").css("left", parseFloat($(window).width() / 2) - ($(".anim-bar").width() / 2));
                }
            }

            // Only number
            $(document).on('keydown', '.scenes .scene input', function(e) {
                -1 !== $.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) || /65|67|86|88/.test(e.keyCode) && (!0 === e.ctrlKey || !0 === e.metaKey) || 35 <= e.keyCode && 40 >= e.keyCode || (e.shiftKey || 48 > e.keyCode || 57 < e.keyCode) && (96 > e.keyCode || 105 < e.keyCode) && e.preventDefault()
            });

            // Max 100, min 0
            $(document).on('blur', '.scenes .scene input', function(e) {

                if (parseFloat($(this).val()) > 100) {
                    $(this).val('100');
                }

                if (parseFloat($(this).val()) < 0) {
                    $(this).val('0');
                }

            });

            // Last scene always 100
            $(document).on('blur', '.scenes .scene:not(.scene-add):last input', function(e) {

                $(this).val('100');

            });

            // First scene always 0
            $(document).on('blur', '.scenes .scene:first-child input', function(e) {

                $(this).val('0');

            });

            function yp_create_anim() {

                if (iframe.find(".yp-anim-scenes style").length == 0) {
                    alert(l18_allScenesEmpty);
                    return false;
                }

                // Variables
                var total = $(".scenes .scene").length;
                var scenesData = '';

                // Create animation from data.
                for (var i = 1; i < total; i++) {

                    //if(iframe.find(".yp-anim-scenes").find(".style-scene-"+i).length > 0 || i == 1){

                    scenesData = scenesData + $(".scenes .scene-" + i + " input").val() + "% {";

                    iframe.find(".yp-anim-scenes").find(".style-scene-" + i).each(function() {
                        scenesData = scenesData + (($(this).html().match(/\{(.*?)\}/g)).toString().replace("{", "").replace("}", "")) + ";";
                    });

                    scenesData = scenesData + "}";

                    //}

                }

                // Remove webkit prefix.
                scenesData = scenesData.replace(/-webkit-(.*?);/g, '');

                var scenesDataReverse = scenesData.replace(/\}/g, "}YKSYXA");
                var scenesDataReverseArray = scenesDataReverse.split("YKSYXA").reverse();

                // wait
                var watingForAdd = [];
                var added = '{';

                for (var i = 1; i < scenesDataReverseArray.length; i++) {

                    // Anim part example data.
                    var lineData = $.trim(scenesDataReverseArray[i]);
                    lineData = lineData.split("{")[1].split("}")[0];

                    // If is last ie first. ie 0%, no need.
                    if (scenesDataReverseArray.length - 1 == i) {

                        //$(".scenes .scene-1").trigger("click");

                        for (var k = 0; k < watingForAdd.length; k++) {

                            var countT = 0;

                            // Search in before
                            if (added.match("{" + watingForAdd[k] + ":") != null) {
                                countT = parseInt(added.match("{" + watingForAdd[k] + ":").length);
                            }

                            if (added.match(";" + watingForAdd[k] + ":") != null) {
                                countT = countT + parseInt(added.match(";" + watingForAdd[k] + ":").length);
                            }

                            if (countT == 0) {

                                var el = iframe.find(".yp-selected");
                                var val = el.css(watingForAdd[k]);

                                if (watingForAdd[k] == 'top' && val == 'auto') {
                                    val = "0px";
                                }

                                if (watingForAdd[k] == 'left' && val == 'auto') {
                                    val = "0px";
                                }

                                if (watingForAdd[k] == 'width' && val == 'auto') {
                                    val = el.width();
                                }

                                if (watingForAdd[k] == 'height' && val == 'auto') {
                                    val = el.height();
                                }

                                if (watingForAdd[k] == 'opacity' && val == 'auto') {
                                    val = "1";
                                }

                                if (watingForAdd[k] != 'right' && val != 'auto') {
                                    if (watingForAdd[k] != 'bottom' && val != 'auto') {
                                        var all = watingForAdd[k] + ":" + val + ";";
                                        scenesData = scenesData.replace("0% {", "0% {" + all);
                                        added = added + all;
                                    }
                                }

                            }

                        }

                    }

                    // Rules of this part.
                    var rules = lineData.split(";");

                    // get only rules names.
                    for (var x = 0; x < rules.length; x++) {
                        if (rules[x].split(":")[0] != '') {

                            var founded = rules[x].split(":")[0];
                            var count = 0;

                            // Search in before
                            if (scenesData.match("{" + founded + ":") != null) {
                                count = parseInt(scenesData.match("{" + founded + ":").length);
                            }

                            if (scenesData.match(";" + founded + ":") != null) {
                                count = count + parseInt(scenesData.match(";" + founded + ":").length);
                            }

                            if (count < parseInt(total - 1)) {
                                watingForAdd.push(founded);
                            }

                        }
                    }

                }

                /* Adding current line data to next line datas. */
                var scenesDataNormal = scenesData.replace(/\}/g, "}TYQA");
                var scenesDataNormalArray = scenesDataNormal.split("TYQA");

                var rulesNames = [];
                var rulesValues = [];

                for (var i = 0; i < scenesDataNormalArray.length; i++) {

                    // Anim part example data.
                    var lineData = $.trim(scenesDataNormalArray[i]);

                    if (lineData != '' && lineData != ' ') {

                        lineData = lineData.split("{")[1].split("}")[0];

                        // Rules of this part.
                        var rules = lineData.split(";");

                        // Each all rules
                        for (var x = 0; x < rules.length; x++) {
                            if (rules[x].split(":")[0] != '') {

                                // Get rule name
                                var foundedName = rules[x].split(":")[0];
                                var foundedValue = rules[x].split(":")[1].split(";");

                                // Get rule value
                                if (foundedValue == null || foundedValue == undefined) {
                                    foundedValue = rules[x].split(":")[1].split("}");
                                }

                                // Clean important prefix.
                                foundedValue = $.trim(foundedValue).replace(/!important/g, "");

                                // If same rule have in rulesNames, get index.
                                var index = rulesNames.indexOf(foundedName);

                                // Delete ex rule data.
                                if (index != -1) {
                                    rulesNames.splice(index, 1);
                                    rulesValues.splice(index, 1);
                                }

                                // Update with new rules.
                                rulesNames.push(foundedName);
                                rulesValues.push(foundedValue);

                            }

                        }

                        var updatedLine = "{" + lineData;

                        for (var t = 0; t < rulesNames.length; t++) {

                            var current = rulesNames[t];
                            var currentVal = rulesValues[t];

                            var countT = 0;

                            // Search in this line
                            if (updatedLine.match("{" + current + ":") != null) {
                                countT = parseInt(updatedLine.match("{" + current + ":").length);
                            }

                            if (updatedLine.match(";" + current + ":") != null) {
                                countT = count + parseInt(updatedLine.match(";" + current + ":").length);
                            }

                            // If any rule have in rulesnames and not have in this line,
                            // so add this rule to this line.
                            if (countT < 1) {
                                updatedLine = "{" + current + ":" + currentVal + ";" + updatedLine.replace("{", "");
                            }

                        }

                        // update return value.
                        var pre = $.trim(scenesDataNormalArray[i]).split("{")[0] + "{" + lineData.replace("{", "") + "}";
                        var upNew = $.trim(scenesDataNormalArray[i]).split("{")[0] + "{" + updatedLine.replace("{", "") + "}";
                        scenesData = scenesData.replace(pre, upNew);

                    }

                }

                // Current total scenes
                total = scenesData.match(/\{/g).length;

                // Add animation name.
                scenesData = "@keyframes " + $("#yp-set-animation-name").val() + "{\r" + scenesData + "\r}";

                scenesData = scenesData.replace(/\}/g, "}\r");

                return scenesData;

            }

            // Play/stop control
            $(document).on("click", ".yp-animation-player,.yp-anim-play", function() {

                var element = $(this);

                var willActive = 1;

                $(".scenes .scene").each(function(i) {

                    if ($(this).hasClass("scene-active")) {
                        willActive = (i + 1);
                    }

                });

                // first scene default.
                $(".scenes .scene-1").trigger("click");

                var anim = yp_create_anim();

                if (anim == false) {
                    return false;
                }

                body.addClass("yp-hide-borders-now");

                // Clean scene classes.
                var newClassList = $.trim($("body").attr("class").replace(/yp-scene-[0-9]/g, ''));
                $("body").attr("class", newClassList);

                var newClassList = $.trim(iframeBody.attr("class").replace(/yp-scene-[0-9]/g, ''));
                iframeBody.attr("class", newClassList);

                // AddClass
                body.addClass("yp-animate-test-playing");

                // Clean
                iframe.find(".animate-test-drive").empty();

                // Animate
                iframe.find(".animate-test-drive").append("<style>" + anim + "</style>");

                // Getting duration.
                if ($('#animation-duration-value').val().indexOf(".") != -1) {
                    var delay = $('#animation-duration-value').val().split(".")[0];
                } else {
                    var delay = $('#animation-duration-value').val();
                }

                if ($('#animation-duration-after').val() == 's') {
                    var delayWait = delay * 1000; // second to milisecond.
                } else {
                    var delayWait = delay; //milisecond
                }

                delayWait = delayWait - 10;

                delay = delay + $('#animation-duration-after').val();

                // Play.
                iframe.find(".animate-test-drive").append("<style>body.yp-animate-test-playing .yp-selected,body.yp-animate-test-playing .yp-selected-others{animation-name:" + $("#yp-set-animation-name").val() + " !important;animation-duration:" + delay + " !important;animation-iteration-count:1 !important;}</style>");

                // playing.
                element.text("Playing");
                $(".anim-play").text("Playing");

                // Wait until finish. END.
                setTimeout(function() {

                    element.text("Play");
                    $(".anim-play").text("Play");
                    body.removeClass("yp-animate-test-playing");
                    iframe.find(".animate-test-drive").empty();
                    body.removeClass("yp-hide-borders-now");

                    $(".scenes .scene-" + willActive + "").trigger("click");

                    yp_draw();

                }, delayWait);

            });

            // Start animation creator.
            $(".yp-animation-creator-start,.yp-anim-save").click(function() {

                var text = $('.yp-animation-creator-start').text();

                // Save Section
                if (text == l18_save) {

                    // first scene default.
                    $(".scenes .scene-1").trigger("click");

                    var animName = $("#yp-set-animation-name").val();
                    var anim = yp_create_anim();

                    if (anim == false) {
                        return false;
                    }

                    $(".yp-animation-creator-start").text(text == l18_create ? l18_save : l18_create);
                    $(".yp-anim-save").text($(".yp-animation-creator-start").text());

                    var posting = $.post(ajaxurl, {

                        action: "yp_add_animation",
                        yp_anim_data: anim,
                        yp_anim_name: animName

                    });

                    // Done.
                    posting.complete(function(data) {
                        //Saved.
                    });

                    // Add animation name
                    $("#yp-animation-name-data").append("<option data-text='" + animName + "' value='" + animName + "'>" + animName + "</option>");

                    // Get data by select
                    var data = [];
                    $("#yp-animation-name-data option").each(function() {
                        data.push($(this).text());
                    });

                    // Autocomplete script
                    $("#yp-animation-name").autocomplete({
                        source: data
                    });

                    // Append style
                    iframe.find(".yp-animate-data").append("<style id='" + $("#yp-set-animation-name").val() + "style'>" + anim + "</style>");
                    iframe.find(".yp-animate-data").append("<style id='webkit-" + $("#yp-set-animation-name").val() + "style'>" + anim.replace("@keyframes", "@-webkit-keyframes") + "</style>");

                    yp_anim_cancel();

                    // Set animation name
                    setTimeout(function() {
                        yp_insert_rule(yp_get_current_selector(), "animation-name", animName, '');
                        $("li.animation-option").removeAttr("data-loaded");
                        $("#yp-animation-name").val(animName).trigger("blur");
                    }, 300);

                    return false;

                }

                // Warning.
                if ($("#yp-set-animation-name").val().length == 0) {
                    $("#set-animation-name-group").popover({
                        title: l18_warning,
                        content: l18_setAnimName,
                        trigger: 'click',
                        placement: "left",
                        container: ".yp-select-bar"
                    }).popover("show");
                    return false;
                } else {
                    $("#set-animation-name-group").popover("destroy");
                }

                if ($("#yp-animation-name-data option[value='" + $("#yp-set-animation-name").val() + "']").length > 0) {
                    $("#set-animation-name-group").popover({
                        title: l18_warning,
                        content: l18_animExits,
                        trigger: 'click',
                        placement: "left",
                        container: ".yp-select-bar"
                    }).popover("show");
                    return false;
                } else {
                    $("#set-animation-name-group").popover("destroy");
                }

                // append anim data area.
                if (iframe.find(".yp-anim-scenes").length == 0) {

                    // Append style area.
                    if (!iframe.find(".yp-styles-area").length > 0) {
                        iframeBody.append("<div class='yp-styles-area'></div>");
                    }

                    // Append anim style area.
                    iframe.find(".yp-styles-area").after('<div class="yp-anim-scenes"><div class="scene-1"></div><div class="scene-2"></div><div class="scene-3"></div><div class="scene-4"></div><div class="scene-5"></div><div class="scene-6"></div></div><div class="animate-test-drive"></div>');

                }

                // close css editor
                if ($("body").hasClass("yp-css-editor-active")) {
                    $(".yp-css-close-btn").trigger("click");
                }

                // Start
                body.addClass("yp-anim-creator");

                body.addClass("yp-scene-1");
                body.attr("data-anim-scene", "scene-1");

                $(".scene-active").removeClass("scene-active");

                $(".scenes .scene:first-child").addClass("scene-active");

                // Resize scenes area.
                yp_anim_scene_resize();

                // Back to list.
                $(".animation-option.active > h3").trigger("click");

                $(this).text(text == l18_create ? l18_save : l18_create);
                $(".yp-anim-save").text($(".yp-animation-creator-start").text());

            });

            function yp_anim_cancel() {

                // Save to create.
                $(".yp-animation-creator-start").text(l18_create);

                // Clean classes.
                body.removeClass("yp-anim-creator");
                body.removeAttr("data-anim-scene");
                body.removeClass("yp-anim-link-toggle");
                body.removeClass("yp-animate-test-playing");

                body.removeAttr("data-anim-scene");

                // Clean scene classes.
                var newClassList = $.trim($("body").attr("class").replace(/yp-scene-[0-9]/g, ''));
                $("body").attr("class", newClassList);

                var newClassList = $.trim(iframeBody.attr("class").replace(/yp-scene-[0-9]/g, ''));
                iframeBody.attr("class", newClassList);

                // Clean all scene data.
                iframe.find(".yp-anim-scenes .scene-1").empty();
                iframe.find(".yp-anim-scenes .scene-2").empty();
                iframe.find(".yp-anim-scenes .scene-3").empty();
                iframe.find(".yp-anim-scenes .scene-4").empty();
                iframe.find(".yp-anim-scenes .scene-5").empty();
                iframe.find(".yp-anim-scenes .scene-6").empty();

                if ($(".yp-anim-cancel-link").length > 0) {
                    $(".yp-anim-cancel-link").trigger("click");
                }

                // Set default data again.
                yp_insert_default_options();

                // Delete 3,4,5,6scenes.
                $(".anim-bar .scenes .scene-6 .scene-delete").trigger("click");
                $(".anim-bar .scenes .scene-5 .scene-delete").trigger("click");
                $(".anim-bar .scenes .scene-4 .scene-delete").trigger("click");
                $(".anim-bar .scenes .scene-3 .scene-delete").trigger("click");

                // delete test data
                iframe.find(".animate-test-drive").empty();

                yp_resize();
                yp_draw();

            }

            $(document).on("click", ".scenes .scene .scene-delete", function() {

                var current = $(this).parent().attr("data-scene").replace("scene-", "");
                var next = $(".scenes .scene").length - 1;

                // delete all
                $(".scenes .scene:not('.scene-add')").remove();

                for (var i = 1; i < next; i++) {
                    $(".scene-add").trigger("click");
                }

                if (next == 6) {
                    $(".scene-add").show();
                    yp_anim_scene_resize();
                }

                // Delete all styles for this scene.
                iframe.find(".yp-anim-scenes .scene-" + current + "").empty();

                // prev active
                $(".scenes .scene-" + (current - 1) + "").trigger("click");

                return false;

            });

            $(document).on("click", ".scenes .scene", function() {

                // Not scene add.
                if ($(this).hasClass("scene-add")) {
                    var next = $(".scenes .scene").length;

                    $(".scenes .scene-let-delete").removeClass("scene-let-delete");

                    $(".scene-add").before('<div class="scene-let-delete scene scene-' + next + '" data-scene="scene-' + next + '"><span class="dashicons dashicons-trash scene-delete"></span><p>' + l18_scene + ' ' + next + '<span><input type="text" value="100" /></span></p></div>');

                    // select added scene.
                    $(".scenes .scene-" + next + "").trigger("click");

                    $(".scene-1 input").val("0");
                    $(".scene-2 input").val("100");

                    if (next == 3) {
                        $(".scene-1 input").val("0");
                        $(".scene-2 input").val("50");
                        $(".scene-3 input").val("100");
                    }

                    if (next == 4) {
                        $(".scene-1 input").val("0");
                        $(".scene-2 input").val("33.3");
                        $(".scene-3 input").val("66.6");
                        $(".scene-4 input").val("100");
                    }

                    if (next == 5) {
                        $(".scene-1 input").val("0");
                        $(".scene-2 input").val("25");
                        $(".scene-3 input").val("50");
                        $(".scene-4 input").val("75");
                        $(".scene-5 input").val("100");
                    }

                    if (next == 6) {
                        $(".scene-1 input").val("0");
                        $(".scene-2 input").val("20");
                        $(".scene-3 input").val("40");
                        $(".scene-4 input").val("60");
                        $(".scene-5 input").val("80");
                        $(".scene-6 input").val("100");
                    }

                    if (next == 6) {
                        $(".scene-add").hide();
                    }
                    yp_anim_scene_resize();
                    return false;
                }

                // Set active class
                $(".scene-active").removeClass("scene-active");
                $(this).addClass("scene-active");

                // Update current scene.
                body.attr("data-anim-scene", $(this).attr("data-scene"));

                // Delete ex scene classes.
                var newClassList = $.trim($("body").attr("class").replace(/yp-scene-[0-9]/g, ''));
                $("body").attr("class", newClassList);

                var newClassList = $.trim(iframeBody.attr("class").replace(/yp-scene-[0-9]/g, ''));
                iframeBody.attr("class", newClassList);

                // Add new scene class.
                body.addClass("yp-" + $(this).attr("data-scene"));

                // Current
                var currentVal = parseInt($(this).attr("data-scene").replace("scene-", ""));

                for (currentVal > 1; currentVal--;) {
                    if (currentVal != 0) {
                        body.addClass("yp-scene-" + currentVal);
                    }
                }

                yp_insert_default_options();
                $(".yp-disable-btn.active").trigger("click");

                yp_draw();

            });

            $(".yp-anim-cancel").click(function() {
                $(".yp-anim-cancel-link").trigger("click");
            });

            // Yellow Pencil Toggle Advanced Boxes. Used For Parallax, Transform.
            $(".yp-advanced-link").click(function() {

                if ($(this).hasClass("yp-add-animation-link")) {
                    body.toggleClass("yp-anim-link-toggle");
                    $(this).toggleClass("yp-anim-cancel-link");

                    if (!$(this).hasClass("yp-anim-cancel-link")) {
                        yp_anim_cancel();
                    }

                    if ($("#animation-duration-value").val() == '0' || $("#animation-duration-value").val() == '0.00') {
                        $("#animation-duration-value").val("1");
                        $("#animation-duration-value").trigger("blur");
                        $("#yp-set-animation-name").trigger("focus");
                    }

                    var text = $('.yp-add-animation-link').text();
                    $('.yp-add-animation-link').text(text == l18_CreateAnimate ? l18_cancel : l18_CreateAnimate);

                    yp_resize();
                    return false;
                }

                $(".yp-on").not(this).removeClass("yp-on");

                $(".yp-advanced-option").not($(this).next(".yp-advanced-option")).hide(0);

                $(this).next(".yp-advanced-option").toggle(0);

                $(this).toggleClass("yp-on");

                yp_resize();

            });

            // Background Assents Set Active Click.
            $(".yp-bg-img-btn").click(function() {

                $(this).toggleClass("active");
                $(".yp_background_assets").toggle();

                yp_resize();

            });

            // Active Class For undo, redo, CSS Editor buttons.
            $(".top-area-btn:not(.undo-btn):not(.redo-btn):not(.css-editor-btn)").click(function() {
                $(this).toggleClass("active");
                $(this).tooltip("hide");
            });

            // Fullscreen
            $(".fullscreen-btn").click(function() {
                yp_toggle_full_screen(document.body);
            });

            // Undo
            $(".undo-btn").click(function() {
                editor.commands.exec("undo", editor);
                body.addClass("yp-css-data-trigger undo-clicked");
                $("#cssData").trigger("keyup");
                yp_draw();
                setTimeout(function() {
                    yp_draw();
                }, 20);
            });

            // Redo
            $(".redo-btn").click(function() {
                editor.commands.exec("redo", editor);
                body.addClass("yp-css-data-trigger");
                $("#cssData").trigger("keyup");
                yp_draw();
                setTimeout(function() {
                    yp_draw();
                }, 20);
            });

            // Background Assents Loading On Scrolling.
            $(".yp_background_assets").scroll(function() {

                $(".yp_bg_assets").filter(":onScreenFrame").each(function() {
                    var $d = $(this).data("url");
                    $(this).css("background-image", "url(" + $(this).data("url") + ")");
                });

            });

            // Set Background Assents
            $(".yp-bg-img-btn:not(.yp-first-clicked)").click(function() {

                $(this).addClass("yp-first-clicked");

                $(".yp_bg_assets").filter(":onScreenFrame").each(function() {
                    var $d = $(this).data("url");
                    $(this).css("background-image", "url(" + $(this).data("url") + ")");
                });

            });

            // Flat color helper toggle
            $(".yp-flat-colors").click(function() {

                $(this).toggleClass("active");
                $(this).parent().find(".yp_flat_colors_area").toggle();

                yp_resize();

            });

            // Meterial color helper toggle
            $(".yp-meterial-colors").click(function() {

                $(this).toggleClass("active");
                $(this).parent().find(".yp_meterial_colors_area").toggle();

                yp_resize();

            });

            // Nice color helper toggle.
            $(".yp-nice-colors").click(function() {

                $(this).parent().find(".yp_nice_colors_area").toggle();
                $(this).toggleClass("active");

                yp_resize();

            });

            // Image Uploader
            $(".yp-upload-btn").click(function() {

                $('#image_uploader iframe').attr('src', function(i, val) {
                    return val;
                });

                window.send_to_editor = function(output) {

                    var imgurl = output.match(/src="(.*?)"/g);

                    imgurl = imgurl.toString().replace('src="', '').replace('"', '');

                    // Always get full size.
                    if (imgurl != '') {

                        var y = imgurl.split("-").length - 1;
                        var imgNew = '';

                        if (imgurl.split("-")[y].match(/(.*?)x(.*?)\./g) !== null) {

                            imgNew = imgurl.replace("-" + imgurl.split("-")[y], '');

                            // format
                            if (imgurl.split("-")[y].indexOf(".") != -1) {
                                imgNew = imgNew + "." + imgurl.split("-")[y].split(".")[1];
                            }

                        } else {
                            imgNew = imgurl;
                        }

                    }

                    $("#yp-background-image").val(imgNew).trigger("keyup");

                    window.send_to_editor = window.restore_send_to_editor;

                    $("#image_uploader").toggle();
                    $("#image_uploader_background").toggle();

                }

                $("#image_uploader").toggle();
                $("#image_uploader_background").toggle();

            });

            // Image Uploader close
            $("#image_uploader_background").click(function() {
                $("#image_uploader").toggle();
                $("#image_uploader_background").toggle();
                $('#image_uploader iframe').attr('src', function(i, val) {
                    return val;
                });
            });

            // Uploader callback
            window.restore_send_to_editor = window.send_to_editor;

            window.send_to_editor = function(html) {

                var imgurl = $('img', html).attr('src');
                $("#yp-background-image").val(imgurl);

                window.send_to_editor = window.restore_send_to_editor;

                $("#image_uploader").toggle();
                $("#image_uploader_background").toggle();
                $('#image_uploader iframe').attr('src', function(i, val) {
                    return val;
                });

            }

            // Trigger Options Update.
            yp_option_update();

            // The title
            $("title").html("Yellow Pencil: " + iframe.find("title").html());

            // Check before exit page.
            window.onbeforeunload = yp_confirm_exit;

            // exit confirm
            function yp_confirm_exit() {

                if ($(".yp-save-btn").hasClass("waiting-for-save")) {
                    return confirm(l18_sure);
                }

            }

            // Save Button
            $(".yp-save-btn").on("click", function() {

                // If all changes already saved, So Stop.
                if ($(this).hasClass("yp-disabled")) {
                    return false;
                }

                // Getting Customized page id.
                var id = window.location.href.split("&yp_id=");

                if (typeof id[1] !== typeof undefined && id[1] !== false) {
                    id = id[1].split("&");
                    id = id[0];
                } else {
                    id = undefined;
                }

                // Getting Customized Post Type
                var type = window.location.href.split("&yp_type=");
                if (typeof type[1] !== typeof undefined && type[1] !== false) {
                    type = type[1].split("&");
                    type = type[0];
                } else {
                    type = undefined;
                }

                // Send Ajax If Not Demo Mode.
                if (!$("body").hasClass("yp-yellow-pencil-demo-mode")) {

                    var data = yp_get_clean_css(true);

                    // Lite Version Checking.
                    var status = true;

                    if ($("body").hasClass("wtfv")) {

                        // if (
                        //     data.indexOf("font-family:") != -1 ||
                        //     data.indexOf("text-shadow:") != -1 ||
                        //     data.indexOf("text-transform:") != -1 ||
                        //     data.indexOf("background-color:") != -1 ||
                        //     data.indexOf("background-image:") != -1 ||
                        //     data.indexOf("animation-name:") != -1 ||
                        //     data.indexOf("filter:") != -1 ||
                        //     data.indexOf("opacity:") != -1 ||
                        //     data.indexOf("background-parallax:") != -1 ||
                        //     data.indexOf("     width:") != -1 ||
                        //     data.indexOf("     height:") != -1 ||
                        //     data.indexOf("     color:") != -1) {
                        //     status = false;
												//
                        //     $(".wt-save-btn").html(l18_save).removeClass("waiting-for-save").removeClass("wt-disabled");
												//
                        //     $(".yp-info-modal,.yp-popup-background").show();
												//
                        // } else {
												//
                        //     // BeforeSend
                        //     $(".yp-save-btn").html(l18_saving).addClass("yp-disabled");
												//
                        // }

                    } else {

                        // BeforeSend
                        $(".yp-save-btn").html(l18_saving).addClass("yp-disabled");

                    }

                    // Convert CSS To Data and save.
                    if (body.hasClass("yp-need-to-process")) {

                        if (status) {
                            yp_process(false, id, type);
                        }

                    } else {

                        if (status) {

                            var posting = $.post(ajaxurl, {

                                action: "yp_ajax_save",
                                yp_id: id,
                                yp_stype: type,
                                yp_data: data,
                                yp_editor_data: yp_get_styles_area()

                            });

                            var postingPre = $.post(ajaxurl, {

                                action: "yp_preview_data_save",
                                yp_data: data

                            });


                            // Done.
                            posting.complete(function(data) {
                                $(".yp-save-btn").html(l18_saved).addClass("yp-disabled").removeClass("waiting-for-save");
                            });

                        }

                    }

                } else {

                    alert(l18_demo_alert);
                    $(".yp-save-btn").html(l18_saved).addClass("yp-disabled").removeClass("waiting-for-save");

                }

            });

            function yp_check_with_parents(element, css, value, comparison) {
                var checkElements = element.add(element.parents());
                var isVal = false;
                checkElements.each(function() {
                    if (comparison == 'equal') {
                        if ($(this).css(css) === value) {
                            isVal = true;
                            return false;
                        }
                    } else {
                        if ($(this).css(css) !== value) {
                            isVal = true;
                            return false;
                        }
                    }
                });
                return isVal;
            }

            // Hide contextmenu on scroll.
            iframe.scroll(function() {

                if (iframe.find(".context-menu-active").length > 0) {
                    iframe.find(".yp-selected").contextMenu("hide");
                }

                if (yp_check_with_parents(iframe.find(".yp-selected"), "position", "fixed", "equal") == true) {

                    if (!body.hasClass("yp-has-transform")) { // if not have.
                        body.addClass("yp-has-transform"); // add
                        window.addedOutline = true;
                    }

                }

            });

            // update borders when scroll start
            iframe.on("scrollstart", iframe, function(evt) {

                body.addClass("yp-scolling");

                if (body.hasClass("yp-content-selected")) {
                    if (yp_check_with_parents(iframe.find(".yp-selected"), "position", "fixed", "equal") == false) { // element not fixed
                        yp_draw();
                    }
                }

                setTimeout(function() {
                    yp_draw_tooltip();
                }, 200);

                setTimeout(function() {
                    yp_draw_tooltip();
                }, 500);

            });

            // Update borders when scroll stop.
            iframe.on("scrollstop", iframe, function(evt) {

                body.removeClass("yp-scolling");

                yp_draw();

                if (window.addedOutline == true) {
                    body.removeClass("yp-has-transform");
                }

                window.addedOutline = false;

            });

            // Resize Callback.
            // Draw again borders and tooltip while resize.
            $(window).resize(function() {

                yp_draw();
                yp_resize();

            });

            // Set As Background Image
            $(".yp_background_assets div").click(function() {
                $(".yp_background_assets div.active").removeClass("active");
                $(this).parent().parent().find(".yp-input").val($(this).data("url")).trigger("keyup");
                $(this).addClass("active");
                $("#background-repeat-group .yp-none-btn:not(.active),#background-size-group .yp-none-btn:not(.active)").trigger("click");
            });

            // Set Color
            $(".yp_flat_colors_area div,.yp_meterial_colors_area div,.yp_nice_colors_area div").click(function() {

                var element = $(this);
                var elementParent = element.parent();

                elementParent.find(".active").removeClass("active");
                elementParent.parent().parent().parent().find(".wqcolorpicker").val($(this).data("color")).trigger("change");
                $(this).addClass("active");

            });

            // Custom Blur Callback
            $(document).click(function(event) {

                var evenTarget = $(event.target);

                if (evenTarget.is(".wqcolorpicker")) {
                    yp_resize();
                }

                if (evenTarget.is(".iris-picker") == false && evenTarget.is(".iris-square-inner") == false && evenTarget.is(".iris-square-handle") == false && evenTarget.is(".iris-slider-offset") == false && evenTarget.is(".iris-slider-offset .ui-slider-handle") == false && evenTarget.is(".iris-picker-inner") == false && evenTarget.is(".wqcolorpicker") == false) {
                    $(".iris-picker").hide();
                    yp_resize();
                }

                if (evenTarget.is('.yp_bg_assets') == false && evenTarget.is('.yp-none-btn') == false && evenTarget.is('.yp-bg-img-btn') == false && $(".yp_background_assets:visible").length > 0) {
                    $(".yp_background_assets").hide();
                    $(".yp-bg-img-btn").removeClass("active");
                    yp_resize();
                }

                if (evenTarget.is('.yp-flat-c') == false && evenTarget.is('.yp-flat-colors') == false && $(".yp_flat_colors_area:visible").length > 0) {
                    $(".yp_flat_colors_area").hide();
                    $(".yp-flat-colors").removeClass("active");
                    yp_resize();
                }

                if (evenTarget.is('.yp-meterial-c') == false && evenTarget.is('.yp-meterial-colors') == false && $(".yp_meterial_colors_area:visible").length > 0) {
                    $(".yp_meterial_colors_area").hide();
                    $(".yp-meterial-colors").removeClass("active");
                    yp_resize();
                }

                if (evenTarget.is('.yp-nice-c') == false && evenTarget.is('.yp-nice-colors') == false && $(".yp_nice_colors_area:visible").length > 0) {
                    $(".yp_nice_colors_area").hide();
                    $(".yp-nice-colors").removeClass("active");
                    yp_resize();
                }

            });

            $("#yp-target-dropdown").on("click", function(e) {
                if (e.target !== this) {
                    return;
                }

                $("#target_background").trigger("click");
            });

            function yp_add_similar_selectors(selector) {

                if (selector == '' || selector == '.' || selector == '#' || selector == ' ' || selector == '  ' || selector == yp_get_current_selector() || selector == $("#yp-button-target-input").val()) {
                    return false;
                }

                if ($("#yp-target-dropdown li").length < 10) {

                    if (iframe.find(selector).length == 0) {
                        return false;
                    }

                    if ($("#" + yp_id(selector)).length > 0) {
                        return false;
                    }

                    var selectorOrginal = selector;

                    if (selector.indexOf("::") != -1) {
                        var selectorParts = selector.split("::");
                        selector = selectorParts[0] + "<b>::" + selectorParts[1] + "</b>";
                    } else if (selector.indexOf(":") != -1) {
                        var selectorParts = selector.split(":");
                        selector = selectorParts[0] + "<b>:" + selectorParts[1] + "</b>";
                    }

                    if (selector.indexOf(" > ") != -1) {
                        var role = ' > ';
                    } else {
                        var role = ' ';
                    }

                    selector = "<span style=\"color:#D70669\">" + selector.replace(new RegExp(role, "g"), '</span>' + role + '<span style="color:#D70669">') + "</span>";
                    selector = selector.replace(/<span style=\"(.*?)\">\#(.*?)<\/span>/g, '<span style="color:#6300FF">\#$2<\/span>');

                    var tagName = iframe.find(selectorOrginal)[0].nodeName;

                    $("#yp-target-dropdown").append("<li id='" + yp_id(selectorOrginal) + "'>" + selector + " | " + yp_tag_info(tagName, selectorOrginal) + "</li>");

                }

            }

            function yp_toggle_hide(status) {

                if (status == true) {

                    if ($("body").hasClass("yp-css-editor-active")) {
                        $(".yp-css-close-btn").trigger("click");
                    }
                    $("body").removeClass("yp-clean-look");

                } else {
                    $("body").toggleClass("yp-clean-look");
                    if ($("body").hasClass("yp-css-editor-active")) {
                        $("body").removeClass("yp-css-editor-active");
                        $("#leftAreaEditor").hide();
                    }
                    yp_resize();
                }

            }

            function yp_create_similar_selectors() {

                $("#yp-target-dropdown li").remove();

                if ($("#yp-button-target-input").val() == '') {

                    var selector = yp_get_current_selector();

                } else {

                    var selector = $("#yp-button-target-input").val();

                }

                var findBlank = true;

                if (selector == undefined) {
                    return false;
                }

                selector = $.trim(selector);

                var max = 10;

                // adding all ids
                if (selector == '#') {
                    iframe.find("[id]").not('head, script, style, [class^="yp-"], [class*=" yellow-pencil-"], link, meta, title, noscript').each(function(i, v) {
                        if (i < max) {
                            yp_add_similar_selectors("#" + $(this).attr('id'));
                        }
                    });
                    return false;
                }

                // adding all classes
                if (selector == '.') {
                    iframe.find("[class]").not('head, script, style, [class^="yp-"], [class*=" yellow-pencil-"], link, meta, title, noscript').each(function(i, v) {
                        if (i < max) {
                            yp_add_similar_selectors("." + $(this).attr('class'));
                        }
                    });
                    return false;
                }

                selector = $.trim(selector.replace(/\.+$/, '').replace(/\#+$/, ''));

                if (selector.indexOf("::") > -1) {
                    selector = selector.split("::")[0];
                } else if (selector.indexOf(":") > -1) {
                    selector = selector.split(":")[0];
                }

                if (selector == '  ' || selector == ' ' || selector == '') {
                    return false;
                }

                // Using prefix
                if (selector.split(" ").length > 0) {
                    var last = null;
                    var lastPart = selector.split(" ")[(selector.split(" ").length - 1)];
                    if (lastPart.indexOf(" ") == -1) {
                        last = lastPart;
                    }

                    if (last != null) {

                        // For Classes
                        if (last.indexOf(".") != -1) {

                            var e = iframe.find("[class^='" + last.replace(/\./g, '') + "']").not('head, script, style, [class^="yp-"], [class*=" yellow-pencil-"], link, meta, title, noscript');

                            if (e.length > 0) {

                                var classes = e.attr('class').split(' ');

                                for (var i = 0; i < max; i++) {

                                    var rex = new RegExp("^" + last.replace(/\./g, '') + "(.+)");

                                    var matches = rex.exec(classes[i]);

                                    if (matches != null) {
                                        var Foundclass = matches[1];
                                        yp_add_similar_selectors(selector + Foundclass);
                                    }

                                }

                            }

                        }

                        // For ID
                        if (last.indexOf("#") != -1) {

                            var e = iframe.find("[id^='" + last.replace(/\#/g, '') + "']").not('head, script, style, [class^="yp-"], [class*=" yellow-pencil-"], link, meta, title, noscript');

                            if (e.length > 0) {

                                var classes = e.attr('id').split(' ');

                                for (var i = 0; i < max; i++) {

                                    var rex = new RegExp("^" + last.replace(/\#/g, '') + "(.+)");

                                    var matches = rex.exec(classes[i]);

                                    if (matches != null) {
                                        var Foundclass = matches[1];
                                        yp_add_similar_selectors(selector + Foundclass);
                                    }

                                }

                            }

                        }

                    }
                }

                // Adding childrens.
                var childrens = iframe.find(selector).find("*").not('head, script, style, [class^="yp-"], [class*=" yellow-pencil-"], link, meta, title, noscript');

                if (childrens.length == 0) {
                    return false;
                }

                childrens.each(function() {
                    yp_add_similar_selectors(selector + " " + yp_get_best_class($(this)));
                });

            }

            $(document).on("click", "#yp-target-dropdown li", function() {

                $("#yp-button-target-input").val($(this).text().split(" |")[0]).trigger("keyup").trigger("focus");

                $(".yp-button-target").trigger("click");

            });

            // Custom Selector
            $(".yp-button-target").click(function(e) {

                if ($(e.target).hasClass("yp-button-target-input")) {
                    return false;
                }

                if ($("body").hasClass("yp-anim-creator")) {
                    if (!confirm(l18_closeAnim)) {
                        return false;
                    }
                }

                if (iframe.find(".context-menu-active").length > 0) {
                    iframe.find(".yp-selected").contextMenu("hide");
                }

                var element = $(this);

                if (!element.hasClass("active")) {

                    body.addClass("yp-target-active");
                    element.removeClass("active");

                    var selector = yp_get_current_selector();

                    if (body.attr("data-yp-selector") == ':hover') {
                        selector = selector + ":hover";
                    }

                    if (body.attr("data-yp-selector") == ':focus') {
                        selector = selector + ":focus";
                    }

                    if (selector == undefined || selector == '') {
                        selector = '.';
                    }

                    $("#yp-button-target-input").trigger("focus").val(selector).trigger("keyup");

                    yp_create_similar_selectors();

                } else {

                    var selector = $("#yp-button-target-input").val();

                    if (selector == '' || selector == ' ') {
                        element.addClass("active");
                        body.removeClass("yp-target-active");
                    }

                    if (selector.match(/:hover/g)) {
                        var selectorNew = selector.replace(/:hover/g, '');
                    } else if (selector.match(/:focus/g)) {
                        var selectorNew = selector.replace(/:focus/g, '');
                    } else {
                        var selectorNew = selector;
                    }

                    if (iframe.find(selectorNew).length > 0 && selectorNew != '*') {

                        if (iframe.find(selector).hasClass("yp-selected")) {
                            iframe.find(".yp-selected").addClass("yp-will-selected");
                        }

                        yp_set_selector(selector);

                        // selected element
                        var selectedElement = iframe.find(selectorNew);

                        // scroll to element if not visible on screen.
                        if (iframe.find(".yp-selected-tooltip").hasClass("yp-fixed-tooltip")) {
                            var height = parseInt($(window).height() / 2);
                            var selectedHeight = parseInt(selectedElement.height() / 2);
                            if (selectedHeight < height) {
                                var scrollPosition = selectedHeight + selectedElement.offset().top - height;
                                iframe.scrollTop(scrollPosition);
                            }
                        }

                        element.addClass("active");
                        body.removeClass("yp-target-active");

                    } else if (selectorNew != '' && selectorNew != ' ') {

                        $("#yp-button-target-input").css("color", "red");

                    }

                }

            });

            // Custom Selector Close.
            $("#target_background").click(function() {

                body.removeClass("yp-target-active");
                $("#yp-button-target-input").val("");
                $(".yp-button-target").trigger("click");

            });

            // Custom Selector Keyup
            $("#yp-button-target-input").keyup(function(e) {

                yp_create_similar_selectors();

                $(this).attr("style", "");

                // Enter
                if (e.keyCode == 13) {
                    $(".yp-button-target").trigger("click");
                    return false;
                }

            });

            // Selector Color Red Remove.
            $("#yp-button-target-input").keydown(function() {

                $(this).attr("style", "");

            });

            var wIris = 237;
            if ($(window).width() < 1367) {
                wIris = 210;
            }

            // iris plugin.
            $('.yp-select-bar > ul > li > div > div > div > div > .wqcolorpicker').iris({

                hide: true,

                width: wIris,

                change: function(event, ui) {
                    $(this).parent().find(".wqminicolors-swatch-color").css("background-color", ui.color.toString());
                }

            });

            // iris plugin.
            $('.yp-select-bar .yp-advanced-option .wqcolorpicker').iris({

                hide: true,

                width: wIris,

                change: function(event, ui) {
                    $(this).parent().find(".wqminicolors-swatch-color").css("background-color", ui.color.toString());
                }

            });

            // Update responsive note
            function yp_update_sizes() {

                if ($("body").hasClass("yp-responsive-device-mode") == false) {
                    return false;
                }

                var s = $("#iframe").width();
                var device = '';

                // Set device size.
                $(".device-size").text(s);

                if ($(".media-control").attr("data-code") == 'max-width') {

                    device = '(phones)';

                    if (s >= 375) {
                        device = '(Large phones)';
                    }

                    if (s >= 414) {
                        device = '(tablets & landscape phones)';
                    }

                    if (s >= 736) {
                        device = '(tablets)';
                    }

                    if (s >= 768) {
                        device = '(small desktops & tablets and phones)';
                    }

                    if (s >= 992) {
                        device = '(medium desktops & tablets and phones)';
                    }

                    if (s >= 1200) {
                        device = '(large desktops & tablets and phones)';
                    }

                } else {

                    device = '(phones & tablets and desktops)';

                    if (s >= 375) {
                        device = '(phones & tablets and desktops)';
                    }

                    if (s >= 414) {
                        device = '(large phones & tablets and desktops)';
                    }

                    // Not mobile.
                    if (s >= 736) {
                        device = '(landscape phones & tablets and desktops)';
                    }

                    // Not tablet
                    if (s >= 768) {
                        device = '(desktops)';
                    }

                    // Not small desktop
                    if (s >= 992) {
                        device = '(medium & large desktops)';
                    }

                    // Not medium desktop
                    if (s >= 1200) {
                        device = '(large desktops)';
                    }

                }

                // Set device name
                $(".device-name").text(device);

            }

            // Smart insert default values for options.
            function yp_insert_default_options() {

                if ($("body").hasClass("yp-content-selected") == false) {
                    return false;
                }

                // current options
                var options = $(".yp-editor-list > li.active:not(.yp-li-about) .yp-option-group");

                // delete all cached data.
                $("li[data-loaded]").removeAttr("data-loaded");

                // UpData current active values.
                if (options.length > 0) {
                    options.each(function() {

                        if ($(this).attr("id") != "background-parallax-group" && $(this).attr("id") != "background-parallax-speed-group" && $(this).attr("id") != "background-parallax-x-group" && $(this).attr("id") != "background-position-group") {

                            var check = 1;

                            if ($(this).attr("id") == 'animation-duration-group') {
                                if ($("body").hasClass("yp-anim-creator") == true) {
                                    check = 0;
                                }
                            }

                            if (check == 1) {
                                yp_set_default(".yp-selected", yp_id_hammer(this), false);
                            }

                        }
                    });
                }

                // cache to loaded data.
                options.parent().attr("data-loaded", "true");

            }

            $(".input-autocomplete").each(function() {

                // Get data by select
                var data = [];
                $(this).parent().find("select option").each(function() {
                    data.push($(this).text());
                });

                var id = $(this).parent().parent().attr("data-css");

                // Autocomplete script
                $(this).autocomplete({
                    source: data,
                    delay: 0,
                    minLength: 0,
                    autoFocus: true,
                    close: function(event, ui) {

                        $(".active-autocomplete-item").removeClass("active-autocomplete-item");
                        $(this).removeClass("active");
                        $("body").removeClass("autocomplete-active");

                        if ($(this).parent().find('select option:contains(' + $(this).val() + ')').length) {
                            $(this).val($(this).parent().find('select option:contains(' + $(this).val() + ')').val());
                        }

                    },
                    open: function(event, ui) {

                        window.openVal = $(this).val();

                        $(this).addClass("active");
                        $("body").addClass("autocomplete-active");

                        var current = $(this).val();

                        var fontGoogle = null;

                        // Getting first font family and set active if yp has this font family.
                        if (id == 'font-family') {
                            if (current.indexOf(",") != -1) {
                                var currentFont = $.trim(current.split(",")[0]);
                                currentFont = currentFont.replace(/'/g, "").replace(/"/g, "").replace(/ /g, "").toLowerCase();

                                if ($('#yp-' + id + '-data option[data-text="' + currentFont + '"]').length > 0) {
                                    fontGoogle = $('#yp-' + id + '-data option[data-text="' + currentFont + '"]').text();
                                }

                            }
                        }

                        if (fontGoogle == null) {
                            if ($('#yp-' + id + '-data option[value="' + current + '"]').length > 0) {
                                current = $('#yp-' + id + '-data option[value="' + current + '"]').text();
                            }
                        } else {
                            current = fontGoogle;
                        }

                        if ($(this).parent().find(".autocomplete-div").find('li').filter(function() {
                                return $.text([this]) === current;
                            }).length == 1) {

                            $(".active-autocomplete-item").removeClass("active-autocomplete-item");
                            if ($(".active-autocomplete-item").length == 0) {

                                $(this).parent().find(".autocomplete-div").find('li').filter(function() {
                                    return $.text([this]) === current;
                                }).addClass("active-autocomplete-item");

                            }

                        }

                        // Scroll
                        if ($(".active-autocomplete-item").length > 0) {
                            $(this).parent().find(".autocomplete-div").find('li.ui-state-focus').removeClass("ui-state-focus");
                            var parentDiv = $(this).parent().find(".autocomplete-div li.active-autocomplete-item").parent();
                            var activeEl = $(this).parent().find(".autocomplete-div li.active-autocomplete-item");

                            parentDiv.scrollTop(parentDiv.scrollTop() + activeEl.position().top - parentDiv.height() / 2 + activeEl.height() / 2);
                        }

                        // Update font-weight family
                        $("#yp-autocomplete-place-font-weight ul li").css("font-family", $("#yp-font-family").val());

                        // Text shadow
                        if (id == 'text-shadow') {

                            $(".autocomplete-div li").each(function() {

                                if ($(this).text() == 'Basic Shadow') {
                                    $(this).css("text-shadow", 'rgba(0, 0, 0, 0.3) 0px 1px 1px');
                                }

                                if ($(this).text() == 'Shadow Multiple') {
                                    $(this).css("text-shadow", 'rgb(255, 255, 255) 1px 1px 0px, rgb(170, 170, 170) 2px 2px 0px');
                                }

                                if ($(this).text() == 'Anaglyph') {
                                    $(this).css("text-shadow", 'rgb(255, 0, 0) -1px 0px 0px, rgb(0, 255, 255) 1px 0px 0px');
                                }

                                if ($(this).text() == 'Emboss') {
                                    $(this).css("text-shadow", 'rgb(255, 255, 255) 0px 1px 1px, rgb(0, 0, 0) 0px -1px 1px');
                                }

                                if ($(this).text() == 'Neon') {
                                    $(this).css("text-shadow", 'rgb(255, 255, 255) 0px 0px 2px, rgb(255, 255, 255) 0px 0px 4px, rgb(255, 255, 255) 0px 0px 6px, rgb(255, 119, 255) 0px 0px 8px, rgb(255, 0, 255) 0px 0px 12px, rgb(255, 0, 255) 0px 0px 16px, rgb(255, 0, 255) 0px 0px 20px, rgb(255, 0, 255) 0px 0px 24px');
                                }

                                if ($(this).text() == 'Outline') {
                                    $(this).css("text-shadow", 'rgb(0, 0, 0) 0px 1px 1px, rgb(0, 0, 0) 0px -1px 1px, rgb(0, 0, 0) 1px 0px 1px, rgb(0, 0, 0) -1px 0px 1px');
                                }

                            });

                        }

                    },

                    appendTo: "#yp-autocomplete-place-" + $(this).parent().parent().attr("id").replace("-group", "").toString()
                }).click(function() {
                    $(this).autocomplete("search", "");
                });

            });

            $(".yp-responsive-btn").click(function() {
                if ($("body").hasClass("yp-css-editor-active")) {
                    $(".yp-css-close-btn").trigger("click");
                }
            });

            // Responsive Helper: tablet
            $(".yp-responsive-btn").click(function() {

                if ($(this).hasClass("active")) {
                    body.removeClass("yp-responsive-device-mode");
                    $(this).addClass("active");
                    $("#iframe").removeAttr("style");
                    yp_insert_default_options();
                    yp_update_sizes();
                    yp_draw();
                } else {
                    body.addClass("yp-responsive-device-mode");
                    $(this).removeClass("active");
                    yp_insert_default_options();
                    yp_update_sizes();
                    yp_draw();
                }

            });

            // Reset Button
            $(".yp-button-reset").click(function() {

                if ($("body").hasClass("yp-anim-creator")) {
                    if (!confirm(l18_closeAnim)) {
                        return false;
                    } else {
                        yp_anim_cancel();
                    }
                }

                if ($(".yp-ul-all-pages-list").find(".active").length > 0) {
                    l18_reset = "You want reset all customizes on this page?";
                } else if ($(".yp-ul-single-list").find(".active").length > 0) {
                    l18_reset = "You want reset all customizes on this template?";
                } else {
                    l18_reset = "You want reset all global options?";
                }

                if (confirm(l18_reset)) {

                    iframe.find(".yp_current_styles").remove();

                    // Clean Editor Value.
                    editor.setValue('');

                    // Clean CSS Data
                    iframe.find("#yp-css-data-full").html("");

                    // Reset Parallax.
                    iframe.find(".yp-parallax-disabled").removeClass("yp-parallax-disabled");

                    // Update Changes.
                    if (body.hasClass("yp-content-selected")) {

                        yp_insert_default_options();

                        var element = iframe.find(yp_get_current_selector());

                        setTimeout(function() {
                            if (element.length > 0) {
                                if (element.css("position") == "static" && element.hasClass("ready-for-drag") == false) {
                                    element.addClass("ready-for-drag");
                                }
                            }
                        }, 50);

                        yp_draw();

                    }

                    // Option Changed
                    yp_option_change();

                }

            });

            // Install All Options Types.
            // Installing and setting default value to all.
            $(".yp-slider-option").each(function() {
                yp_slider_option(yp_id_hammer(this), $(this).data("decimals"), $(this).data("pxv"), $(this).data("pcv"), $(this).data("emv"));
            });

            $(".yp-radio-option").each(function() {
                yp_radio_option(yp_id_hammer(this));
            });

            $(".yp-color-option").each(function() {
                yp_color_option(yp_id_hammer(this));
            });

            $(".yp-input-option").each(function() {
                yp_input_option(yp_id_hammer(this));
            });

            // Updating slider by input value.
            function yp_update_slide_by_input(element) {

                element = $(element);
                var elementParent = element.parent().parent().parent();

                var value = element.val();
                var prefix = element.parent().find(".yp-after-prefix").val();
                var slide = element.parent().parent().find(".wqNoUi-target");

                // Update PX
                if (prefix == 'px') {
                    var range = elementParent.data("px-range").split(",");
                }

                // Update %.
                if (prefix == '%') {
                    var range = elementParent.data("pc-range").split(",");
                }

                // Update EM.
                if (prefix == 'em') {
                    var range = elementParent.data("em-range").split(",");
                }

                // Update S.
                if (prefix == 's' || prefix == '.s') {
                    var range = elementParent.data("em-range").split(",");
                }

                // min and max values
                if (typeof range == typeof undefined || range == false) {
                    return false;
                }

                var min = parseInt(range[0]);
                var max = parseInt(range[1]);

                if (value < min) {
                    min = value;
                }

                if (value > max) {
                    max = value;
                }

                if (isNaN(parseInt(min)) == false && isNaN(parseInt(max)) == false && isNaN(parseInt(value)) == false) {

                    slide.wqNoUiSlider({
                        range: {
                            'min': parseInt(min),
                            'max': parseInt(max)
                        },

                        start: value
                    }, true);

                }

            }

            // process CSS before open CSS editor.
            $("body:not(.yp-css-editor-active) .css-editor-btn").hover(function() {
                if (!$("body").hasClass("yp-css-editor-active")) {
                    yp_process(false, false, false);
                }
            });

            // Hide CSS Editor.
            $(".css-editor-btn,.yp-css-close-btn").click(function() {

                // delete fullscreen editor
                if (body.hasClass("yp-fullscreen-editor")) {
                    body.removeClass("yp-fullscreen-editor");
                }

                if ($("#leftAreaEditor").css("display") == 'none') {

                    // No selected
                    if (!body.hasClass("yp-content-selected")) {
                        editor.setValue(yp_get_clean_css(true));
                        editor.focus();
                        editor.execCommand("gotolineend");
                    } else {
                        yp_insert_rule(yp_get_current_selector(), 'a', 'a', '');
                        var cssData = yp_get_clean_css(false);
                        var goToLine = cssData.split("a:a")[0].split(/\r\n|\r|\n/).length;
                        cssData = cssData.replace(/a:a !important;/g, "");
                        cssData = cssData.replace(/a:a;/g, "");
                        editor.setValue(cssData);
                        editor.resize(true);
                        editor.scrollToLine(goToLine, true, true);
                        editor.focus();
                        if ($("body").hasClass("yp-responsive-device-mode")) {
                            editor.gotoLine(goToLine, 2, true);
                        } else {
                            editor.gotoLine(goToLine, 1, true);
                        }
                    }

                    $("#cssData,#cssEditorBar,#leftAreaEditor").show();
                    $("body").addClass("yp-css-editor-active");
                    iframeBody.trigger("scroll");

                } else {

                    // CSS To data
                    yp_process(true, false, false);

                }

                // Update All.
                yp_draw();

            });

            // Blur: Custom Slider Value
            $(".yp-after-css-val").blur(function() {

                yp_update_slide_by_input(this);

            });

            // Keyup format.
            $(".yp-after-prefix").keyup(function() {

                yp_update_slide_by_input(this);

            });

            // Call function.
            yp_resize();

            // select only single element
            function yp_single_selector(selector) {

                if (selector.indexOf(" > ") != -1) {
                    var role = ' > ';
                    var roleLength = 3;
                } else {
                    var role = ' ';
                    var roleLength = 1;
                }

                var selectorArray = selector.split(role);
                var i = 0;
                var indexOf = 0;
                var selectorPlus = '';

                for (i = 0; i < selectorArray.length; i++) {

                    if (i > 0) {
                        selectorPlus += role + selectorArray[i];
                    } else {
                        selectorPlus += selectorArray[i];
                    }

                    if (iframe.find(selectorPlus).length > 1) {

                        iframe.find(selectorPlus).each(function() {

                            if (selectorPlus.substr(selectorPlus.length - 1) != ')') {

                                if ($(this).parent().length > 0) {

                                    indexOf = 0;

                                    $(this).parent().children().each(function() {

                                        indexOf++;

                                        if ($(this).find(".yp-selected").length > 0 || $(this).hasClass("yp-selected") == true) {

                                            selectorPlus = selectorPlus + ":nth-child(" + indexOf + ")";

                                        }

                                    });

                                }

                            }

                        });

                    }

                }

                if (iframe.find($.trim(selectorPlus)).length > 1 && $.trim(selectorPlus).indexOf(" > ") == -1) {

                    var selectorAll = '';
                    var selectorPlusD = $.trim(selectorPlus).split(" ");
                    var i = 0;
                    for (i = 0; i < selectorPlusD.length; i++) {
                        if (selectorPlusD[i].indexOf(":nth-child") != -1) {
                            selectorAll = selectorAll + " > " + selectorPlusD[i];
                        } else {
                            selectorAll = selectorAll + " " + selectorPlusD[i];
                        }
                    }

                    selectorPlus = selectorAll;

                }

                return $.trim(selectorPlus);

            }

            /* ---------------------------------------------------- */
            /* Set context menu options.                            */
            /* ---------------------------------------------------- */
            $.contextMenu({

                events: {

                    // Draw Again Borders, Tooltip After Contextmenu Hide.
                    hide: function(opt) {

                        body.removeClass("yp-contextmenuopen");

                        yp_draw();

                    },

                    // if contextmenu show; update some options.
                    show: function() {

                        // Disable contextmenu on animate creator.
                        if ($("body").hasClass("yp-anim-creator")) {
                            iframe.find(".yp-selected").contextMenu("hide");
                        }

                        var selector = yp_get_current_selector();

                        var elementP = iframe.find(selector).parent();

                        if (elementP.length > 0 && elementP[0].nodeName.toLowerCase() != "html") {
                            $(".yp-contextmenu-parent").removeClass("yp-disable-contextmenu");
                        } else {
                            $(".yp-contextmenu-parent").addClass("yp-disable-contextmenu");
                        }

                        body.addClass("yp-contextmenuopen");

                    }

                },

                // Open context menu only if a element selected.
                selector: 'body.yp-content-selected .yp-selected,body.yp-content-selected.yp-selected',
                callback: function(key, options) {

                    var element = iframe.find(selector);

                    body.removeClass("yp-contextmenuopen");

                    var selector = yp_get_current_selector();

                    // Context Menu: Parent
                    if (key == "parent") {

                        // If Disable, Stop.
                        if ($(".yp-contextmenu-parent").hasClass("yp-disable-contextmenu")) {
                            return false;
                        }

                        // add class to parent.
                        iframe.find(".yp-selected").parent().addClass("yp-will-selected");

                        // clean
                        yp_clean();

                        // Get parent selector.
                        var parentSelector = $.trim(yp_get_parents(iframe.find(".yp-will-selected"), "default"));

                        // Set Selector
                        yp_set_selector(parentSelector);

                    }

                    // Context Menu: Hover
                    if (key == "hover" || key == "focus") {

                        if (key == 'hover') {
                            var keyOther = 'focus';
                        } else {
                            var keyOther = 'hover';
                        }

                        var selector = yp_get_current_selector();

                        if (!$(".yp-contextmenu-" + key).hasClass("yp-active-contextmenu")) {
                            if (selector.indexOf(":") == -1) {
                                selector = selector + ":" + key;
                            } else {
                                selector = selector.split(":")[0] + ":" + key;
                            }
                        } else {
                            selector = selector.split(":")[0];
                        }

                        iframe.find(".yp-selected").addClass("yp-will-selected");

                        yp_set_selector(selector);

                    }

                    if (key == "writeCSS") {

                        if (body.hasClass("yp-css-editor-active")) {
                            $(".css-editor-btn").trigger("click");
                        }

                        $(".css-editor-btn").trigger("click");

                    }

                    // Select Just It
                    if (key == 'selectjustit') {

                        $("body").addClass("yp-select-just-it");

                        selector = yp_get_parents(iframe.find(".yp-selected"), "sharp");

                        var selectorPlus = yp_single_selector(selector);

                        if (iframe.find(selectorPlus).length != 0) {
                            yp_set_selector(selectorPlus);
                        }

                        body.removeClass("yp-select-just-it");

                    }
                    /* Select just it functions end here */

                    // leave Selected element.
                    if (key == 'close') {
                        yp_clean();
                        yp_resize();
                    }

                    // toggle selector editor.
                    if (key == "editselector") {
                        $(".yp-button-target").trigger("click");
                    }

                },

                // Content menu elements.
                items: {
                    "hover": {
                        name: ":Hover",
                        className: "yp-contextmenu-hover"
                    },
                    "focus": {
                        name: ":Focus",
                        className: "yp-contextmenu-focus"
                    },
                    "sep1": "---------",
                    "parent": {
                        name: "Parent Element",
                        className: "yp-contextmenu-parent"
                    },
                    "editselector": {
                        name: "Edit Selector",
                        className: "yp-contextmenu-selector-edit"
                    },
                    "writeCSS": {
                        name: "Write CSS",
                        className: "yp-contextmenu-type-css"
                    },
                    "selectjustit": {
                        name: "Select just it",
                        className: "yp-contextmenu-select-it"
                    },
                    "close": {
                        name: "Leave",
                        className: "yp-contextmenu-close"
                    }
                }

            });

            /* ---------------------------------------------------- */
            /* Resize.                                              */
            /* Dynamic resize yellow pencil panel                   */
            /* ---------------------------------------------------- */
            function yp_resize() {

                // update.
                window.scroll_width = yp_get_scroll_bar_width();

                // top margin for matgin.
                var topMargin = 0;
                if ($("body").hasClass("yp-metric-disable") == false || $("body").hasClass("yp-responsive-device-mode") == true) {
                    topMargin = 31;
                }

                // Right menu fix.
                if (iframe.height() > $(window).height() && $("body").hasClass("yp-responsive-device-mode") == false) {
                    $(".yp-select-bar").css("margin-right", 8 + window.scroll_width + "px");
                } else if (topMargin == 0) {
                    $(".yp-select-bar").css("margin-right", "8px");
                } else if (topMargin > 0 && iframe.height() + topMargin > $(window).height()) {
                    $(".yp-select-bar").css("margin-right", 8 + window.scroll_width + "px");
                }

                // Maximum Height.
                var maximumHeight = $(window).height() - 24 - topMargin;

                // Difference size for 790 and more height.
                if ($(window).height() > 790) {
                    var topBarHeight = 46;
                } else {
                    var topBarHeight = 43;
                }

                // Resize. If no selected menu showing.
                if ($(".yp-no-selected").css("display") == "block") {

                    var height = $(".yp-no-selected").height() + 140;

                    if (height <= maximumHeight) {
                        $(".yp-select-bar").height(height);
                        $(".yp-editor-list").height(height - 45);
                    } else {
                        $(".yp-select-bar").height(maximumHeight);
                        $(".yp-editor-list").height(maximumHeight - 45);
                    }

                    // If any options showing.
                } else if ($(".yp-this-content:visible").length > 0) {

                    var height = $(".yp-this-content:visible").parent().height();

                    if (height <= maximumHeight) {
                        if (window.chrome) {
                            height = height + 114;
                        } else {
                            height = height + 116;
                        }
                        var heightLitte = height - 45;
                    }

                    if ($(window).height() < 700) {
                        height = height - 3;
                    }

                    if (height <= maximumHeight) {
                        $(".yp-select-bar").height(height);
                        $(".yp-editor-list").height(heightLitte);
                    } else {
                        $(".yp-select-bar").height(maximumHeight);
                        $(".yp-editor-list").height(maximumHeight - 45);
                    }

                } else { // If Features list showing.

                    if ($(window).height() > 790) {
                        var footerHeight = 104;
                    } else if ($(window).height() > 700) {
                        var footerHeight = 114;
                    } else {
                        var footerHeight = 33;
                    }

                    var topPadding = (($(".yp-editor-list > li").length - 2) * topBarHeight) + footerHeight;

                    var topHeightBar = $(".yp-editor-top").height() + topPadding;

                    if (topHeightBar <= maximumHeight) {
                        $(".yp-select-bar").height(topHeightBar);
                        $(".yp-editor-list").height(topPadding);
                    } else {
                        $(".yp-select-bar").height(maximumHeight);
                        $(".yp-editor-list").height(topPadding);
                    }

                }

            }

            // Element Picker Helper
            $(".yp-element-picker").click(function() {
                $("body").toggleClass("yp-element-picker-active");
                $(this).toggleClass("active");
            });

            // ruler helper.
            mainDocument.on("mousemove mousedown", function(e) {

                if ($("body").hasClass("yp-metric-disable") == false) {

                    if ($("body").hasClass("yp-responsive-resizing")) {
                        e.pageY = e.pageY - 10;
                        e.pageX = e.pageX - 10;
                        e.clientX = e.clientX - 10;
                        e.clientY = e.clientY - 10;
                    }

                    if ($(this).find("#iframe").length > 0) {

                        if (body.hasClass("yp-responsive-device-mode") == true) {

                            if ($("body").hasClass("yp-responsive-resizing") == true) {

                                // Min 320 W
                                if (e.clientX < 320 + 44) {
                                    e.clientX = 320 + 44;
                                }

                                // Max full-80 W
                                if (e.clientX > $(window).width() - 80) {
                                    e.clientX = $(window).width() - 80;
                                }

                                // Min 320 H
                                if (e.clientY < 320 + 31) {
                                    e.clientY = 320 + 31;
                                }

                                // Max full-80 H
                                if (e.clientY > $(window).height() - 80) {
                                    e.clientY = $(window).height() - 80;
                                }

                            }

                            $(".metric-top-border").attr("style", "left:" + e.clientX + "px !important;display:block;margin-left:-1px !important;");
                            $(".metric-left-border").attr("style", "top:" + e.clientY + "px !important;");
                            $(".metric-top-tooltip").attr("style", "top:" + e.clientY + "px !important;display:block;");

                            $(".metric-left-tooltip").attr("style", "left:" + e.clientX + "px !important;display:block;margin-left:1px !important;");

                            if ($("body").hasClass("yp-responsive-resizing")) {
                                $(".metric-left-tooltip span").text(e.pageX + 10);
                                $(".metric-top-tooltip span").text(e.pageY + 10);
                            } else {
                                $(".metric-left-tooltip span").text(e.pageX);
                                $(".metric-top-tooltip span").text(e.pageY);
                            }

                        }

                    }

                    if ($(this).find("#iframe").length == 0) {

                        if ($("body").hasClass("yp-responsive-resizing") == true) {

                            // Min 320 W
                            if (e.clientX < 320) {
                                e.clientX = 320;
                            }

                            // Max full W
                            if (e.clientX > $(window).width()) {
                                e.clientX = $(window).width();
                            }

                            // Min 320 H
                            if (e.clientY < 320) {
                                e.clientY = 320;
                            }

                            // Max full H
                            if (e.clientY > $(window).height()) {
                                e.clientY = $(window).height();
                            }

                        }

                        $(".metric-top-border").attr("style", "left:" + e.clientX + "px !important;display:block;");
                        $(".metric-left-border").attr("style", "top:" + e.clientY + "px !important;margin-top:30px;");
                        $(".metric-top-tooltip").attr("style", "top:" + e.clientY + "px !important;display:block;margin-top:32px;");
                        $(".metric-left-tooltip").attr("style", "left:" + e.clientX + "px !important;display:block;");

                        if ($("body").hasClass("yp-responsive-resizing") == true) {
                            $(".metric-top-tooltip span").text(e.pageY + 10);
                            $(".metric-left-tooltip span").text(e.pageX + 10);
                        } else {
                            $(".metric-top-tooltip span").text(e.pageY);
                            $(".metric-left-tooltip span").text(e.pageX);
                        }

                    }

                }

            });

            iframe.on("mousemove", function(e) {

                console.log($("#cssData").find('textarea').val);

                if ($("body").hasClass("yp-metric-disable") == false) {

                    var element = $(e.target);

                    if (element.hasClass("yp-selected-tooltip") || element.hasClass("yp-selected-boxed-top") || element.hasClass("yp-selected-boxed-left") || element.hasClass("yp-selected-boxed-right") || element.hasClass("yp-selected-boxed-bottom") || element.hasClass("yp-edit-menu") || element.parent().hasClass("yp-selected-tooltip")) {
                        element = iframe.find(".yp-selected");
                    }

                    // CREATE SIMPLE BOX
                    var element_offset = element.offset();

                    if (element_offset != undefined) {

                        var topBoxesI = element_offset.top;
                        var leftBoxesI = element_offset.left;

                        if (leftBoxesI < 0) {
                            leftBoxesI = 0;
                        }

                        var widthBoxesI = element.outerWidth(false);
                        var heightBoxesI = element.outerHeight(false);

                        // Dynamic Box
                        if (iframe.find(".hover-info-box").length == 0) {
                            iframeBody.append("<div class='hover-info-box'></div>");
                        }

                        iframe.find(".hover-info-box").css("width", widthBoxesI).css("height", heightBoxesI).css("top", topBoxesI).css("left", leftBoxesI);

                    }
                    // Create box end.

                    if (body.hasClass("yp-element-resizing")) {
                        element = iframe.find(".yp-selected");
                    }

                    var element_offset = element.offset();

                    if (element_offset == undefined) {
                        return false;
                    }

                    var topBoxes = element_offset.top;
                    var leftBoxes = element_offset.left;

                    if (leftBoxes < 0) {
                        leftBoxes = 0;
                    }

                    var widthBoxes = element.outerWidth(false);
                    var heightBoxes = element.outerHeight(false);

                    var bottomBoxes = topBoxes + heightBoxes;

                    if (iframe.find(".yp-size-handle").length == 0) {
                        iframeBody.append("<div class='yp-size-handle'>W : <span class='ypdw'></span> px<br>H : <span class='ypdh'></span> px</div>");
                    }

                    var w = element.width();
                    var h = element.height();

                    iframe.find(".yp-size-handle .ypdw").text(w);
                    iframe.find(".yp-size-handle .ypdh").text(h);

                    leftBoxes = leftBoxes + (widthBoxes / 2);

                    iframe.find(".yp-size-handle").css("top", bottomBoxes).css("bottom", "auto").css("left", leftBoxes).css("position", "absolute");

                    if (parseFloat(bottomBoxes) > (parseFloat($("body #iframe").height()) + parseFloat(iframe.scrollTop())) + 40) {

                        iframe.find(".yp-size-handle").css("bottom", "10px").css("top", "auto").css("left", leftBoxes).css("position", "fixed");

                    }

                }

            });

            /* ---------------------------------------------------- */
            /* Element Selector Box Function                        */
            /* ---------------------------------------------------- */
            iframe.on("mouseover mouseout", iframe, function(evt) {

                if ($(".yp-selector-mode.active").length > 0 && $("body").hasClass("yp-metric-disable") == true) {

                    // Element
                    var element = $(evt.target);

                    var elementClasses = element.attr("class");

                    if (element.hasClass("yp-selected")) {
                        return false;
                    }

                    if (body.hasClass("yp-content-selected") == false) {
                        if (element.hasClass("yp-selected-tooltip") == true) {
                            yp_clean();
                            return false;
                        }

                        if (element.parent().length > 0) {
                            if (element.parent().hasClass("yp-selected-tooltip")) {
                                yp_clean();
                                return false;
                            }
                        }
                    }

                    // If not any yellow pencil element.
                    if (typeof elementClasses !== typeof undefined && elementClasses !== false) {
                        if (elementClasses.indexOf("yp-selected-boxed-") > -1) {
                            return false;
                        }
                    }

                    // If colorpicker stop.
                    if ($("body").hasClass("yp-element-picker-active") == true) {

                        window.pickerColor = element.css("background-color");

                        if (window.pickerColor == '' || window.pickerColor == 'transparent') {

                            element.parents().each(function() {

                                if ($(this).css("background-color") != 'transparent' && $(this).css("background-color") != '' && $(this).css("background-color") != null) {
                                    window.pickerColor = $(this).css("background-color");
                                    return false;
                                }

                            });

                        }

                        var color = window.pickerColor.toString();

                        $(".yp-element-picker.active").parent().parent().find(".wqcolorpicker").val(yp_color_converter(color)).trigger("change");

                        if (window.pickerColor == '' || window.pickerColor == 'transparent') {
                            var id_prt = $(".yp-element-picker.active").parent().parent();
                            id_prt.find(".yp-disable-btn.active").trigger("click");
                            id_prt.find(".yp-none-btn:not(.active)").trigger("click");
                            id_prt.find(".wqminicolors-swatch-color").css("background-image", "url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOwAAADsAQMAAABNHdhXAAAABlBMVEW/v7////+Zw/90AAAAUElEQVRYw+3RIQ4AIAwDwAbD/3+KRPKDGQQQbpUzbS6zF0lLeSffqYr3cXHzzd3PivHmzZs3b968efPmzZs3b968efPmzZs3b968efP+03sBF7TBCROHcrMAAAAASUVORK5CYII=)");
                        }

                    }

                    var nodeName = element[0].nodeName;

                    // If element already selected, stop.
                    if (body.hasClass("yp-content-selected")) {
                        return false;
                    }

                    // Not show if p tag and is empty.
                    if (element.html() == '&nbsp;' && element[0].nodeName == 'P') {
                        return false;
                    }

                    if (nodeName.toLowerCase() == 'html') {
                        return false;
                    }

                    // if Not Null continue.
                    if (element === null) {
                        return false;
                    }

                    // stop if not have
                    if (element.length == 0) {
                        return false;
                    }

                    // If selector disable stop.
                    if (body.hasClass("yp-selector-disabled")) {
                        return false;
                    }

                    // Cache
                    window.styleData = element.attr("style");

                    if (body.hasClass("yp-content-selected") == false) {

                        // Remove all ex data.
                        yp_clean();

                        // Hover it
                        element.addClass("yp-selected");

                    }

                    // Geting selector.
                    if (window.setSelector == false) {
                        var selector = yp_get_parents(element, "default");
                    } else {
                        var selector = window.setSelector;
                    }

                    // Be sure this is visible on screen (For parent)
                    if (yp_check_with_parents(element, "display", "none", "equal") == true || yp_check_with_parents(element, "visibility", "hidden", "equal") == true || yp_check_with_parents(element, "opacity", "0", "equal") == true) {
                        return false;
                    }

                    evt.stopPropagation();
                    evt.preventDefault();

                    if (body.hasClass("yp-content-selected") == false) {

                        // transform.
                        if (yp_check_with_parents(element, "transform", "none", "notequal") == true) {
                            body.addClass("yp-has-transform");
                        }

                        // For tooltip
                        var tagName = nodeName;

                        yp_draw_box(evt.target, 'yp-selected-boxed');

                        var selectorView = selector.replace(/ > /g, ' ');

                        if (body.hasClass("yp-sharp-selector-mode-active") == false) {
                            var i = 0;
                            for (i = 0; i < 8; i++) {
                                if (selectorView.length > 90) {
                                    if (selectorView.indexOf(" > ") == -1) {
                                        var role = ' ';
                                    } else {
                                        var role = ' > ';
                                    }
                                    selectorView = (selectorView.substr(selectorView.indexOf(role) + 1)).toString();
                                }
                            }
                        }

                        if (body.hasClass("yp-sharp-selector-mode-active") == true) {
                            var i = 0;
                            for (i = 0; i < 8; i++) {
                                if (selectorView.length > 90) {
                                    selectorView = (selectorView.substr(selectorView.indexOf(" ") + 1)).toString();
                                }
                            }
                        }

                        var selectorTag = selector.replace(/>/g, '').replace(/  /g, ' ').replace(/\:nth-child\((.*?)\)/g, '');

                        // Element Tooltip  |  Append setting icon.
                        iframeBody.append("<div class='yp-selected-tooltip'><small>" + yp_tag_info(tagName, selectorTag) + "</small> " + $.trim(selectorView) + "</div><div class='yp-edit-menu'></div>");

                        // Select Others.
                        iframe.find(selector + ":not(.yp-selected)").each(function(i) {

                            $(this).addClass("yp-selected-others");
                            yp_draw_box_other(this, 'yp-selected-others', i);

                        });

                        yp_draw_tooltip();

                    }

                }

            });

            /* ---------------------------------------------------- */
            /* Doing update the draw.                               */
            /* ---------------------------------------------------- */
            function yp_draw() {

                // If not visible stop.
                if (iframe.find(".yp-selected").css("display") == 'none') {
                    return false;
                }

                // selected boxed.
                yp_draw_box(".yp-selected", 'yp-selected-boxed');

                // Select Others.
                iframe.find(".yp-selected-others").each(function(i) {
                    yp_draw_box_other(this, 'yp-selected-others', i);
                });

                // Dragger update.
                yp_get_handler();

                // For responsive
                yp_draw_responsive_handler();

                setTimeout(function() {

                    // If not visible stop.
                    if (iframe.find(".yp-selected").css("display") == 'none') {
                        return false;
                    }

                    // selected boxed.
                    yp_draw_box(".yp-selected", 'yp-selected-boxed');

                    // Select Others.
                    iframe.find(".yp-selected-others").each(function(i) {
                        yp_draw_box_other(this, 'yp-selected-others', i);
                    });

                    // Tooltip
                    yp_draw_tooltip();

                    // Dragger update.
                    yp_get_handler();

                }, 10);

            }


            // Resort media query by media numbers.
            function yp_resort_styles(){

                var styleArea = iframe.find('.yp-styles-area');

                // Sort element by selector because Created CSS Will keep all css rules in one selector.
                styleArea.find("style").each(function(){

                    var that = $(this);

                    // Check if not resorted.
                    if(that.hasClass("yp-resorted") == false){

                        // addClass for not sort again.
                        that.addClass("yp-resorted");

                        // Get this selector.
                        var style = that.attr("data-style");

                        // check if there next styles that has same selector.
                        if(styleArea.find("[data-style="+style+"]").length > 1){

                            // Find all next styles that has same selector
                            styleArea.find("[data-style="+style+"]").not(this).each(function(){

                                // Cache
                                var element = $(this);

                                if(element.hasClass("yp-resorted") == false){

                                    // move from dom.
                                    that.append(element);

                                    // add class
                                    element.addClass("yp-resorted");

                                }

                            });

                        }

                    }

                });

                // max-width == 9 > 1
                styleArea.find("style[data-size-mode^='(max-width:']").not("[data-size-mode*=and]").sort(function (a,b){
                    return +parseInt(b.getAttribute('data-size-mode').replace(/\D/g,'')) - +parseInt(a.getAttribute('data-size-mode').replace(/\D/g,''));
                }).appendTo(styleArea);

                // min-width == 1 > 9
                styleArea.find("style[data-size-mode^='(min-width:']").not("[data-size-mode*=and]").sort(function (a,b){
                    return +parseInt(a.getAttribute('data-size-mode').replace(/\D/g,'')) - +parseInt(b.getAttribute('data-size-mode').replace(/\D/g,''));
                }).appendTo(styleArea);

            }


            function yp_create_media_query_before() {

                if ($("body").hasClass("yp-css-converter")) {
                    if ($("body").attr("data-responsive-type") != undefined && $("body").attr("data-responsive-type") != false && $("body").attr("data-responsive-type") != 'desktop') {
                        return $("body").attr("data-responsive-type");
                    } else {
                        return '';
                    }
                }

                if ($("body").hasClass("yp-responsive-device-mode")) {
                    var w = $("#iframe").width();
                    var format = $(".media-control").attr("data-code");
                    return '@media (' + format + ':' + w + 'px){';
                } else {
                    return '';
                }

            }

            function yp_create_media_query_after() {
                if ($("body").hasClass("yp-responsive-device-mode")) {
                    return '}';
                } else {
                    return '';
                }
            }

            $(".media-control").click(function() {
                var c = $(this).attr("data-code");

                if (c == 'max-width') {
                    $(this).attr("data-code", "min-width");
                    $(this).text("above");
                }

                if (c == 'min-width') {
                    $(this).attr("data-code", "max-width");
                    $(this).text("below");
                }

                yp_update_sizes();

            });

            /* ---------------------------------------------------- */
            /* use important if CSS not working without important   */
            /* ---------------------------------------------------- */
            function yp_insert_important_rule(selector, id, value, prefix, size) {

                if (size == undefined || size == false) {
                    if ($("body").hasClass("yp-responsive-device-mode")) {
                        var frameW = $("#iframe").width();
                        var format = $(".media-control").attr("data-code");
                        size = '(' + format + ':' + frameW + 'px)';
                    } else {
                        size = 'desktop';
                    }
                }

                body.addClass("yp-inserting");

                var css = id;

                // Clean value
                value = value.replace(/ !important/g, "").replace(/!important/g, "");

                // Remove Style Without important.
                iframe.find("." + yp_id(selector) + '-' + id + '-style[data-size-mode="' + size + '"]').remove();

                // Append Style Area If Not Have.
                if (!iframe.find(".yp-styles-area").length > 0) {
                    iframeBody.append("<div class='yp-styles-area'></div>");
                }

                // Checking.
                if (value == 'disable' || value == '' || value == 'undefined' || value == null) {
                    body.removeClass("yp-inserting");
                    return false;
                }

                // Append.
                if (yp_id(selector) != '') {

                    if (body.hasClass("yp-anim-creator") == true && id != 'position') {

                        iframe.find("." + yp_id(body.attr("data-anim-scene") + css)).remove();

                        iframe.find(".yp-anim-scenes ." + body.attr('data-anim-scene') + "").append('<style data-rule="' + css + '" class="style-' + body.attr("data-anim-scene") + ' scenes-' + yp_id(css) + '-style">' + selector + '{' + css + ':' + value + prefix + ' !important}</style>');

                    } else {

                        // Responsive Settings
                        var mediaBefore = yp_create_media_query_before();
                        var mediaAfter = yp_create_media_query_after();

                        iframe.find(".yp-styles-area").append('<style data-rule="' + css + '" data-size-mode="' + size + '" data-style="' + yp_id(selector) + '" class="' + yp_id(selector) + '-' + id + '-style yp_current_styles">' + mediaBefore + '' + '' + selector + '{' + css + ':' + value + prefix + ' !important}' + '' + mediaAfter + '</style>');

                        yp_resort_styles();

                    }

                }

                body.removeClass("yp-inserting");

            }

            //setup before functions
            var typingTimer;

            // Keyup bind For CSS Editor.
            $("#cssData").on("keyup", function() {

                if (body.hasClass("yp-selectors-hide") == false && body.hasClass("yp-css-data-trigger") == false) {

                    body.addClass("yp-selectors-hide");

                    // Opacity Selector
                    if (iframe.find(".context-menu-active").length > 0) {
                        iframe.find(".yp-selected").contextMenu("hide");
                    }

                    yp_hide_selects_with_animation();

                }

                body.removeClass("yp-css-data-trigger");

                clearTimeout(typingTimer);
                if ($("#cssData").val) {
                    typingTimer = setTimeout(function() {

                        if (body.hasClass("yp-selectors-hide") == true && $(".wqNoUi-active").length == 0 && $("body").hasClass("autocomplete-active") == false && $(".yp-select-bar .tooltip").length == 0) {

                            body.removeClass("yp-selectors-hide");

                            yp_show_selects_with_animation();

                        }

                        yp_insert_default_options();
                        return false;

                    }, 1000);
                }

                // Append all css to iframe.
                if (iframe.find("#yp-css-data-full").length == 0) {
                    iframe.find('.yp-styles-area').after("<style id='yp-css-data-full'></style>");
                }

                // Need to process.
                body.addClass("yp-need-to-process");

                // Update css source.
                iframe.find("#yp-css-data-full").html(editor.getValue());

                // Empty data.
                iframe.find(".yp-styles-area").empty();

                // Remove ex.
                iframe.find(".yp-live-css").remove();
                //yp_clean();

                // Update
                $(".yp-save-btn").html(l18_save).removeClass("yp-disabled").addClass("waiting-for-save");

                // Update sceen.
                yp_resize();

            });

            // Return to data again.
            $(".yp-select-bar").on("mouseover mouseout", function() {

                if (body.hasClass("yp-need-to-process") == true) {

                    // CSS To Data.
                    yp_process(false, false);

                }

            });

            window.yp_elements = ".yp-selected-handle,.yp-selected-tooltip,.yp-selected-boxed-margin-top,.yp-selected-boxed-margin-bottom,.yp-selected-boxed-margin-left,.yp-selected-boxed-margin-right,.yp-selected-boxed-top,.yp-selected-boxed-bottom,.yp-selected-boxed-left,.yp-selected-boxed-right,.yp-selected-others-top,.yp-selected-others-bottom,.yp-selected-others-left,.yp-selected-others-right,.yp-edit-menu,.yp-selected-boxed-padding-top,.yp-selected-boxed-padding-bottom,.yp-selected-boxed-padding-left,.yp-selected-boxed-padding-right";

            // Hide Slowly
            function yp_hide_selects_with_animation() {

                if (!body.hasClass("yp-content-selected")) {
                    return false;
                }

                if (iframe.find(".yp-selected-boxed-top").css("opacity") != 1) {
                    return false;
                }

                yp_draw();

                iframe.find(window.yp_elements).stop().animate({
                    opacity: 0
                }, 200);

            }

            // Show Slowly.
            function yp_show_selects_with_animation() {

                if (!body.hasClass("yp-content-selected")) {
                    return false;
                }

                if (iframe.find(".yp-selected-boxed-top").css("opacity") != 0) {
                    return false;
                }

                yp_draw();

                iframe.find(window.yp_elements).stop().animate({
                    opacity: 1
                }, 200);

            }

            // Hide borders while editing.
            $(".yp-this-content,.anim-bar").bind({
                mouseenter: function() {

                    if (body.hasClass("yp-selectors-hide") == false) {

                        body.addClass("yp-selectors-hide");

                        // Opacity Selector
                        if (iframe.find(".context-menu-active").length > 0) {
                            iframe.find(".yp-selected").contextMenu("hide");
                        }

                        yp_hide_selects_with_animation();

                    }

                },
                mouseleave: function() {

                    if (body.hasClass("yp-selectors-hide") == true && $(".wqNoUi-active").length == 0 && $("body").hasClass("autocomplete-active") == false && $(".yp-select-bar .tooltip").length == 0) {

                        body.removeClass("yp-selectors-hide");

                        yp_show_selects_with_animation();

                    }

                }
            });

            // If on iframe, always show borders.
            iframe.on("mousemove", iframe, function() {

                if ($(".wqNoUi-active").length == 0 && $("body").hasClass("autocomplete-active") == false && $(".yp-select-bar .tooltip").length == 0) {

                    yp_show_selects_with_animation();

                }

            });

            // YP bar leave: show.
            iframe.on("mouseleave", ".yp-select-bar", function() {

                if (body.hasClass("yp-selectors-hide") == true && $(".wqNoUi-active").length == 0 && $("body").hasClass("autocomplete-active") == false && $(".yp-select-bar .tooltip").length == 0) {

                    body.removeClass("yp-selectors-hide");

                    yp_show_selects_with_animation();

                }

            });

            function mediaAttr(a) {
                return a.toString().replace(/\{/g, '').replace(/@media /g, '').replace(/@media/g, '');
            }

            // CSS To Yellow Pencil Data.
            function yp_cssToData(type) {

                body.addClass("process-by-code-editor");

                // Source.
                var source = editor.getValue();

                // Nth child
                source = source.replace(/:nth-child\((.*?)\)/g, '\.nth-child\.$1\.');

                // Not
                source = source.replace(/:not\((.*?)\)/g, '\.notYP$1YP');

                // Clean.
                source = source.replace(/(\r\n|\n|\r)/g, "").replace(/\t/g, '');

                // Don't care rules in comment.
                source = source.replace(/\/\*(.*?)\*\//g, "");

                // clean.
                source = source.replace(/\}\s+\}/g, '}}').replace(/\s+\{/g, '{');

                // clean.
                source = source.replace(/\s+\}/g, '}').replace(/\{\s+/g, '{');

                // If responsive
                if (type != 'desktop') {

                    // Media query regex. Clean everything about media.
                    var regexType = $.trim(type.replace(/\)/g, "\\)").replace(/\(/g, "\\("));
                    var re = new RegExp(regexType + "(.*?)\}\}", "g");
                    var reQ = new RegExp(regexType, "g");
                    source = source.match(re).toString();

                    source = source.replace(reQ, "");
                    source = source.toString().replace(/\}\}/g, "}");

                } else {

                    // Don't care rules in media query in non-media mode.
                    source = source.replace(/@media(.*?)\}\}/g, '');

                }

                // if no source, stop.
                if (source == '') {
                    return false;
                }

                // if have a problem in source, stop.
                if (source.split('{').length != source.split('}').length) {
                    alert("CSS Editor: Parse Error.");
                    return false;
                }

                var CSSRules;
                var selector;

                // IF Desktop; Remove All Rules. (because first call by desktop)
                if (type == 'desktop') {
                    iframe.find(".yp-styles-area").empty();
                }

                source = source.toString().replace(/\}\,/g, "}");

                // Getting All CSS Selectors.
                var allSelectors = yp_cleanArray(source.replace(/\{(.*?)\}/g, '|BREAK|').split("|BREAK|"));

                // Each All Selectors
                for (var i = 0; i < allSelectors.length; i++) {

                    // Get Selector.
                    selector = $.trim(allSelectors[i]);

                    if (selector != '}' && selector != '}}' && selector != '{' && selector != '' && selector != ' ' && selector != '  ' && selector != '     ') {

                        var selectorRegex = selector.replace(/\[/g, "\\[").replace(/\]/g, "\\]");

                        source = "}" + source;

                        // Getting CSS Rules by selector.
                        CSSRules = source.match(new RegExp("\}" + selectorRegex + '{(.*?)}', 'g'));

                        selector = selector.replace(/\.nth-child\.(.*?)\./g, ':nth-child($1)');

                        selector = selector.replace(/\.notYP(.*?)YP/g, ':not($1)');

                        if (CSSRules != null && CSSRules != '') {

                            // Clean.
                            CSSRules = CSSRules.toString().match(/\{(.*?)\}/g).toString().replace(/\}\,\{/g, ';').replace(/\{/g, '').replace(/\}/g, '').replace(/\;\;/g, ';').split(";");

                            // Variables.
                            var ruleAll;
                            var ruleName;
                            var ruleVal;

                            // Each CSSRules.
                            for (var iq = 0; iq < CSSRules.length; iq++) {

                                ruleAll = $.trim(CSSRules[iq]);

                                if (typeof ruleAll != undefined && ruleAll.length >= 3 && ruleAll.indexOf(":") != -1) {

                                    ruleName = ruleAll.split(":")[0];

                                    if (ruleName != '') {

                                        ruleVal = ruleAll.split(':').slice(1).join(':');

                                        ruleVal = ruleVal;

                                        if (ruleVal != '' && ruleName.indexOf("-webkit-filter") === -1 && ruleName.indexOf("-webkit-transform") === -1) {

                                            if ($(".yp_debug").css(ruleName) != undefined || ruleName != 'background-parallax' || ruleName != 'background-parallax-speed' || ruleName != 'background-parallax-x') {

                                                $(".yp_debug").removeAttr("style");

                                                // for not use important tag.
                                                body.addClass("yp-css-converter");

                                                // for know what is media query.
                                                body.attr("data-responsive-type", type);

                                                // Adding classes.
                                                iframe.find(selector).addClass("yp_selected").addClass("yp_onscreen").addClass("yp_hover").addClass("yp_focus").addClass("yp_click");

                                                // Update
                                                yp_insert_rule(selector, ruleName, ruleVal, '', mediaAttr(type));

                                                // remove class after update.
                                                body.removeClass("yp-css-converter");

                                                // remove attr
                                                body.removeAttr("data-responsive-type");

                                                // Removing classes.
                                                iframe.find(selector).removeClass("yp_selected").removeClass("yp_onscreen").removeClass("yp_hover").removeClass("yp_focus").removeClass("yp_click");

                                            }

                                        }

                                    }

                                }

                            }

                        }

                    }

                }

            }

            /* ---------------------------------------------------- */
            /* Appy CSS To theme for demo                           */
            /* ---------------------------------------------------- */
            function yp_insert_rule(selector, id, value, prefix, size) {

                if (size == undefined || size == false) {
                    if ($("body").hasClass("yp-responsive-device-mode")) {
                        var frameW = $("#iframe").width();
                        var format = $(".media-control").attr("data-code");
                        size = '(' + format + ':' + frameW + 'px)';
                    } else {
                        size = 'desktop';
                    }
                }

                prefix = $.trim(prefix);

                if (prefix == '.s') {
                    prefix = 's';
                }

                if (prefix.indexOf("px") != -1) {
                    prefix = 'px';
                }

                var css = id;

                // adding class
                body.addClass("yp-inserting");

                // Delete basic CSS.
                yp_clean_live_css(id, false);

                // delete live css.
                iframe.find(".yp-live-css").remove();

                // stop if empty
                if (value == '' || value == ' ') {
                    body.removeClass("yp-inserting");
                    return false;
                }

                // toLowerCase
                id = id.toString().toLowerCase();
                css = css.toString().toLowerCase();
                prefix = prefix.toString().toLowerCase();

                // Clean extra zero.
                value = value.replace(/\.00000$/g, "").replace(/\.0000$/g, "").replace(/\.000$/g, "").replace(/\.00$/g, "").replace(/\.0$/g, "");

                // Value always loweCase.
                if (id != 'font-family' && id != 'background-image' && id != 'animation-name' && id != 'animation-play' && id != 'filter' && id != '-webkit-filter' && id != '-webkit-transform') {
                    value = value.toString().toLowerCase();
                }

                // Anim selector.
                if (body.hasClass("yp-anim-creator") == true && id != 'position') {

                    selector = $.trim(selector.replace(/body.yp-scene-[0-9]/g, ''));
                    selector = yp_add_class_to_body(selector, "yp-" + body.attr("data-anim-scene"));

                    // Dont add any animation rule.
                    if (id.indexOf('animation') != -1) {
                        body.removeClass("yp-inserting");
                        return false;
                    }

                }

                // Stop.
                if (css == 'set-animation-name') {
                    body.removeClass("yp-inserting");
                    return false;
                }

                if (id == 'background-color' || id == 'color' || id == 'border-color' || id == 'border-left-color' || id == 'border-right-color' || id == 'border-top-color' || id == 'border-bottom-color') {

                    var valueCheck = $.trim(value).replace("#", '').replace("!important", '');

                    if (valueCheck == 'red') {
                        value = '#FF0000';
                    }

                    if (valueCheck == 'white') {
                        value = '#FFFFFF';
                    }

                    if (valueCheck == 'blue') {
                        value = '#0000FF';
                    }

                    if (valueCheck == 'orange') {
                        value = '#FFA500';
                    }

                    if (valueCheck == 'green') {
                        value = '#008000';
                    }

                    if (valueCheck == 'purple') {
                        value = '#800080';
                    }

                    if (valueCheck == 'pink') {
                        value = '#FFC0CB';
                    }

                    if (valueCheck == 'black') {
                        value = '#000000';
                    }

                    if (valueCheck == 'brown') {
                        value = '#A52A2A';
                    }

                    if (valueCheck == 'yellow') {
                        value = '#FFFF00';
                    }

                    if (valueCheck == 'gray') {
                        value = '#808080';
                    }

                }

                // Animation name play.
                if (id == 'animation-name' || id == 'animation-play' || id == 'animation-iteration' || id == 'animation-duration') {

                    var delay = parseInt($("#animation-duration-value").val() * 1000) + 150;

                    // Add class.
                    body.addClass("yp-hide-borders-now");
                    clearTimeout(tBh);

                    var tBh = setTimeout(function() {

                        // remove class.
                        body.removeClass("yp-hide-borders-now");

                        // Update.
                        yp_draw();

                    }, delay);

                }

                // If has style attr. // USE IMPORTANT
                if (css != 'top' && css != 'bottom' && css != 'left' && css != 'right' && css != 'height' && css != 'width') {

                    var element = iframe.find(".yp-selected");

                    if (typeof element.attr("style") !== typeof undefined && element.attr("style") !== false) {

                        // if more then one rule
                        if ($.trim(element.attr("style")).split(";").length > 0) {

                            var obj = element.attr("style").split(";");

                            for (var item in obj) {
                                if ($.trim(obj[item].split(":")[0]) == css) {

                                    // Use important.
                                    if (css != 'position' && value != 'relative') {
                                        yp_insert_important_rule(selector, id, value, prefix, size);
                                        body.removeClass("yp-inserting");
                                        return false;
                                    }

                                }
                            }

                        } else {
                            if ($.trim(element.attr("style")).split(":")[0] == css) {

                                if (css != 'position' && value != 'relative') {
                                    yp_insert_important_rule(selector, id, value, prefix, size);
                                    body.removeClass("yp-inserting");
                                    return false;
                                }

                            }
                        }

                    }
                }

                // border style.
                if (id == 'border-style') {
                    yp_insert_rule(selector, 'border-left-style', value, prefix, size);
                    yp_insert_rule(selector, 'border-right-style', value, prefix, size);
                    yp_insert_rule(selector, 'border-top-style', value, prefix, size);
                    yp_insert_rule(selector, 'border-bottom-style', value, prefix, size);
                    body.removeClass("yp-inserting");
                    return false;
                }

                // border width.
                if (id == 'border-width') {
                    yp_insert_rule(selector, 'border-left-width', value, prefix, size);
                    yp_insert_rule(selector, 'border-right-width', value, prefix, size);
                    yp_insert_rule(selector, 'border-top-width', value, prefix, size);
                    yp_insert_rule(selector, 'border-bottom-width', value, prefix, size);
                    body.removeClass("yp-inserting");
                    return false;
                }

                // border color.
                if (id == 'border-color') {
                    yp_insert_rule(selector, 'border-left-color', value, prefix, size);
                    yp_insert_rule(selector, 'border-right-color', value, prefix, size);
                    yp_insert_rule(selector, 'border-top-color', value, prefix, size);
                    yp_insert_rule(selector, 'border-bottom-color', value, prefix, size);
                    body.removeClass("yp-inserting");
                    return false;
                }

                // Background image fix.
                if (id == 'background-image' && value != 'disable' && value != 'none' && value != '') {
                    if (value.replace(/\s/g, "") == 'url()' || value.indexOf("//") == -1) {
                        value = 'disable';
                    }
                }

                // adding automatic relative.
                if (id == 'top' || id == 'bottom' || id == 'left' || id == 'right') {

                    //iframe.find(selector).removeClass("ready-for-drag");

                    setTimeout(function() {
                        if ($("#position-static").parent().hasClass("active")){
                            $("#position-relative").trigger("click");
                            //iframe.find(selector).addClass("ready-for-drag");
                        }
                    }, 5);

                }

                // Background color
                if (id == 'background-color') {
                    if ($("#yp-background-image").val() != 'none' && $("#yp-background-image").val() != '') {
                        yp_insert_important_rule(selector, id, value, prefix, size);
                        body.removeClass("yp-inserting");
                        return false;
                    }
                }

                if (id == 'animation-name') {
                    yp_set_default(".yp-selected", yp_id_hammer($("#animation-duration-group")), false);
                }

                // Animation Name Settings.
                if (body.hasClass("process-by-code-editor") == false) {

                    if (id == 'animation-name' || id == 'animation-duration') {

                        selector = selector.replace(/\.yp_onscreen/g, '').replace(/\.yp_hover/g, '').replace(/\.yp_focus/g, '').replace(/\.yp_click/g, '');

                        var selectorNew = selector.split(":");
                        var play = "." + $("#yp-animation-play").val();

                        if (selectorNew[1] != undefined) {
                            selector = selectorNew[0] + play + ":" + selectorNew[1];
                        } else {
                            selector = selectorNew[0] + play;
                        }

                    }

                }

                // Selection settings.
                var selection = $('body').attr('data-yp-selector');

                if (typeof selection === typeof undefined || selection === false) {

                    var selection = '';

                } else {

                    selector = yp_add_class_to_body(selector, 'yp-selector-' + selection.replace(':', ''));

                    selector = selector.replace('body.yp-selector-' + selection.replace(':', '') + ' body.yp-selector-' + selection.replace(':', '') + ' ', 'body.yp-selector-' + selection.replace(':', '') + ' ');

                }

                // Delete same data.
                var exStyle = iframe.find("." + yp_id(selector) + '-' + id + '-style[data-size-mode="' + size + '"]');
                if (exStyle.length > 0) {
                    if (exStyle.html().split(":")[1].split("}")[0] == value) {
                        body.removeClass("yp-inserting");
                        return false;
                    } else {
                        exStyle.remove(); // else remove.
                    }
                }

                // Delete same data for anim.
                if ($("body").hasClass("yp-anim-creator")) {
                    var exStyle = iframe.find(".yp-anim-scenes ." + $('body').attr('data-anim-scene') + " .scenes-" + yp_id(id) + "-style");
                    if (exStyle.length > 0) {
                        if (exStyle.html().split(":")[1].split("}")[0] == value) {
                            body.removeClass("yp-inserting");
                            return false;
                        } else {
                            exStyle.remove(); // else remove.
                        }
                    }
                }

                // Delete same data for filter and transform -webkit- prefix.
                var exStyle = iframe.find("." + yp_id(selector) + '-' + "-webkit-" + id + '-style[data-size-mode="' + size + '"]');
                if (exStyle.length > 0) {
                    if (exStyle.html().split(":")[1].split("}")[0] == value) {
                        body.removeClass("yp-inserting");
                        return false;
                    } else {
                        exStyle.remove(); // else remove.
                    }
                }

                // Delete same data for filter and transform -webkit- prefix on anim scenes.
                if ($("body").hasClass("yp-anim-creator")) {
                    var exStyle = iframe.find(".yp-anim-scenes ." + $('body').attr('data-anim-scene') + " .scenes-webkit" + yp_id(id) + "-style");
                    if (exStyle.length > 0) {
                        if (exStyle.html().split(":")[1].split("}")[0] == value) {
                            body.removeClass("yp-inserting");
                            return false;
                        } else {
                            exStyle.remove(); // else remove.
                        }
                    }
                }

                // Filter
                if (id == 'filter' || id == 'transform') {

                    if (value != 'disable' && value != '' && value != 'undefined' && value != null) {
                        yp_insert_rule(selector, "-webkit-" + id, value, prefix, size);
                    }

                }

                // Append style area.
                if (!iframe.find(".yp-styles-area").length > 0) {
                    iframeBody.append("<div class='yp-styles-area'></div>");
                }

                // No px em etc for this options.
                if (id == 'z-index' || id == 'opacity' || id == 'background-parallax-speed' || id == 'background-parallax-x' || id == 'blur-filter' || id == 'grayscale-filter' || id == 'brightness-filter' || id == 'contrast-filter' || id == 'hue-rotate-filter' || id == 'saturate-filter' || id == 'sepia-filter' || id.indexOf("-transform") != -1) {
                    if (id != 'text-transform' && id != '-webkit-transform') {
                        value = yp_num(value);
                        prefix = '';
                    }
                }

                // Filter Default options.
                if (id == 'blur-filter' || id == 'grayscale-filter' || id == 'brightness-filter' || id == 'contrast-filter' || id == 'hue-rotate-filter' || id == 'saturate-filter' || id == 'sepia-filter') {

                    // Getting all other options.
                    var blur = "blur(" + $.trim($("#blur-filter-value").val()) + "px)";
                    var grayscale = "grayscale(" + $.trim($("#grayscale-filter-value").val()) + ")";
                    var brightness = "brightness(" + $.trim($("#brightness-filter-value").val()) + ")";
                    var contrast = "contrast(" + $.trim($("#contrast-filter-value").val()) + ")";
                    var hueRotate = "hue-rotate(" + $.trim($("#hue-rotate-filter-value").val()) + "deg)";
                    var saturate = "saturate(" + $.trim($("#saturate-filter-value").val()) + ")";
                    var sepia = "sepia(" + $.trim($("#sepia-filter-value").val()) + ")";

                    // Check if disable or not
                    if ($("#blur-filter-group .yp-disable-btn").hasClass("active")) {
                        blur = '';
                    }

                    if ($("#grayscale-filter-group .yp-disable-btn").hasClass("active")) {
                        grayscale = '';
                    }

                    if ($("#brightness-filter-group .yp-disable-btn").hasClass("active")) {
                        brightness = '';
                    }

                    if ($("#contrast-filter-group .yp-disable-btn").hasClass("active")) {
                        contrast = '';
                    }

                    if ($("#hue-rotate-filter-group .yp-disable-btn").hasClass("active")) {
                        hueRotate = '';
                    }

                    if ($("#saturate-filter-group .yp-disable-btn").hasClass("active")) {
                        saturate = '';
                    }

                    if ($("#sepia-filter-group .yp-disable-btn").hasClass("active")) {
                        sepia = '';
                    }

                    // Dont insert if no data.
                    if (blur == 'blur(px)' || $("#blur-filter-group").hasClass("eye-enable") == false) {

                        if (body.hasClass("yp-anim-creator") == false) {
                            blur = '';
                        } else {
                            blur = 'blur(0px)';
                        }

                    }

                    if (grayscale == 'grayscale()' || $("#grayscale-filter-group").hasClass("eye-enable") == false) {

                        if (body.hasClass("yp-anim-creator") == false) {
                            grayscale = '';
                        } else {
                            grayscale = 'grayscale(0)';
                        }

                    }

                    if (brightness == 'brightness()' || $("#brightness-filter-group").hasClass("eye-enable") == false) {

                        if (body.hasClass("yp-anim-creator") == false) {
                            brightness = '';
                        } else {
                            brightness = 'brightness(1)';
                        }

                    }

                    if (contrast == 'contrast()' || $("#contrast-filter-group").hasClass("eye-enable") == false) {

                        if (body.hasClass("yp-anim-creator") == false) {
                            contrast = '';
                        } else {
                            contrast = 'contrast(1)';
                        }

                    }

                    if (hueRotate == 'hue-rotate(deg)' || $("#hue-rotate-filter-group").hasClass("eye-enable") == false) {

                        if (body.hasClass("yp-anim-creator") == false) {
                            hueRotate = '';
                        } else {
                            hueRotate = 'hue-rotate(0deg)';
                        }

                    }

                    if (saturate == 'saturate()' || $("#saturate-filter-group").hasClass("eye-enable") == false) {

                        if (body.hasClass("yp-anim-creator") == false) {
                            saturate = '';
                        } else {
                            saturate = 'saturate(0)';
                        }

                    }

                    if (sepia == 'sepia()' || $("#sepia-filter-group").hasClass("eye-enable") == false) {

                        if (body.hasClass("yp-anim-creator") == false) {
                            sepia = '';
                        } else {
                            sepia = 'sepia(0)';
                        }

                    }

                    // All data.
                    var filterData = $.trim(blur + " " + brightness + " " + contrast + " " + grayscale + " " + hueRotate + " " + saturate + " " + sepia);

                    if (filterData == '' || filterData == ' ') {
                        filterData = 'disable';
                    }

                    yp_insert_rule(selector, 'filter', filterData, '', size);
                    body.removeClass("yp-inserting");
                    return false;

                }
                // Filter options end

                // Transform Settings
                if (id.indexOf("-transform") != -1 && id != 'text-transform' && id != '-webkit-transform') {

                    body.addClass("yp-has-transform");

                    // Getting all other options.
                    var scale = "scale(" + $.trim($("#scale-transform-value").val()) + ")";
                    var rotate = "rotate(" + $.trim($("#rotate-transform-value").val()) + "deg)";
                    var translateX = "translatex(" + $.trim($("#translate-x-transform-value").val()) + "px)";
                    var translateY = "translatey(" + $.trim($("#translate-y-transform-value").val()) + "px)";
                    var skewX = "skewx(" + $.trim($("#skew-x-transform-value").val()) + "deg)";
                    var skewY = "skewy(" + $.trim($("#skew-y-transform-value").val()) + "deg)";

                    // Check if disable or not
                    if ($("#scale-transform-group .yp-disable-btn").hasClass("active")) {
                        scale = '';
                    }

                    if ($("#rotate-transform-group .yp-disable-btn").hasClass("active")) {
                        rotate = '';
                    }

                    if ($("#translate-x-transform-group .yp-disable-btn").hasClass("active")) {
                        translateX = '';
                    }

                    if ($("#translate-y-transform-group .yp-disable-btn").hasClass("active")) {
                        translateY = '';
                    }

                    if ($("#skew-x-transform-group .yp-disable-btn").hasClass("active")) {
                        skewX = '';
                    }

                    if ($("#skew-y-transform-group .yp-disable-btn").hasClass("active")) {
                        skewY = '';
                    }

                    // Dont insert if no data.
                    if (scale == 'scale()' || $("#scale-transform-group").hasClass("eye-enable") == false) {

                        if (body.hasClass("yp-anim-creator") == false) {
                            scale = '';
                        } else {
                            scale = 'scale(1)';
                        }

                    }

                    if (rotate == 'rotate(deg)' || $("#rotate-transform-group").hasClass("eye-enable") == false) {

                        if (body.hasClass("yp-anim-creator") == false) {
                            rotate = '';
                        } else {
                            rotate = 'rotate(0deg)';
                        }

                    }

                    if (translateX == 'translatex(px)' || $("#translate-x-transform-group").hasClass("eye-enable") == false) {

                        if (body.hasClass("yp-anim-creator") == false) {
                            translateX = '';
                        } else {
                            translateX = 'translatex(0px)';
                        }

                    }

                    if (translateY == 'translatey(px)' || $("#translate-y-transform-group").hasClass("eye-enable") == false) {

                        if (body.hasClass("yp-anim-creator") == false) {
                            translateX = '';
                        } else {
                            translateX = 'translatey(0px)';
                        }

                    }

                    if (skewX == 'skewx(deg)' || $("#skew-x-transform-group").hasClass("eye-enable") == false) {

                        if (body.hasClass("yp-anim-creator") == false) {
                            skewX = '';
                        } else {
                            skewX = 'skewx(0deg)';
                        }

                    }

                    if (skewY == 'skewy(deg)' || $("#skew-y-transform-group").hasClass("eye-enable") == false) {

                        if (body.hasClass("yp-anim-creator") == false) {
                            skewY = '';
                        } else {
                            skewY = 'skewy(0deg)';
                        }

                    }

                    // All data.
                    var translateData = $.trim(scale + " " + rotate + " " + translateX + " " + translateY + " " + skewX + " " + skewY);

                    if (translateData == '' || translateData == ' ') {
                        translateData = 'disable';
                    }

                    yp_insert_rule(selector, 'transform', translateData, '', size);
                    body.removeClass("yp-inserting");
                    return false;

                }
                // Transform options end

                // Box Shadow
                if (id == 'box-shadow-inset' || id == 'box-shadow-color' || id == 'box-shadow-vertical' || id == 'box-shadow-blur-radius' || id == 'box-shadow-spread' || id == 'box-shadow-horizontal') {

                    // Get inset option
                    if ($("#box-shadow-inset-inset").parent().hasClass("active")) {
                        var inset = 'inset';
                    } else {
                        var inset = '';
                    }

                    // Getting all other options.
                    var color = $.trim($("#yp-box-shadow-color").val());
                    var vertical = $.trim($("#box-shadow-vertical-value").val());
                    var radius = $.trim($("#box-shadow-blur-radius-value").val());
                    var spread = $.trim($("#box-shadow-spread-value").val());
                    var horizontal = $.trim($("#box-shadow-horizontal-value").val());

                    if ($("#box-shadow-color-group .yp-disable-btn").hasClass("active")) {
                        color = 'transparent';
                    }

                    if ($("#box-shadow-vertical-group .yp-disable-btn").hasClass("active")) {
                        vertical = '0';
                    }

                    if ($("#box-shadow-blur-radius-group .yp-disable-btn").hasClass("active")) {
                        radius = '0';
                    }

                    if ($("#box-shadow-spread-group .yp-disable-btn").hasClass("active")) {
                        spread = '0';
                    }

                    if ($("#box-shadow-horizontal-group .yp-disable-btn").hasClass("active")) {
                        horizontal = '0';
                    }

                    var shadowData = $.trim(horizontal + "px " + vertical + "px " + radius + "px " + spread + "px " + color + " " + inset);

                    yp_insert_rule(selector, 'box-shadow', shadowData, '', size);
                    body.removeClass("yp-inserting");
                    return false;

                }
                // Box shadow options end

                // Animation options
                if (id == 'animation-play') {

                    iframe.find("[data-style]").each(function() {

                        var classes = null;
                        var $style = null;
                        var data = null;

                        // onscreen
                        if ($(this).data("style") == yp_id(selector) + "yp_onscreen") {
                            $(this).remove();
                        }

                        // hover
                        if ($(this).data("style") == yp_id(selector) + "yp_hover") {
                            $(this).remove();
                        }

                        // click
                        if ($(this).data("style") == yp_id(selector) + "yp_click") {
                            $(this).remove();
                        }

                        // click
                        if ($(this).data("style") == yp_id(selector) + "yp_focus") {
                            $(this).remove();
                        }

                    });

                    yp_insert_rule(selector, 'animation-name', $("#yp-animation-name").val(), prefix, size);

                    body.removeClass("yp-inserting");
                    return false;

                }

                // Animation name
                if (id == 'animation-name') {

                    if (value != 'disable' && value != 'none') {

                        // Get duration from CSS
                        var duration = parseFloat(iframe.find(".yp-selected").css("animation-duration"));

                        // If selected element;
                        if (selector.replace(".yp_click", "").replace(".yp_hover", "").replace(".yp_focus", "").replace(".yp_onscreen", "") == yp_get_current_selector()) {
                            var duration = parseFloat($("#animation-duration-value").val());
                            if (duration == 0) {
                                duration = 1;
                            }

                            yp_insert_rule(selector, 'animation-fill-mode', 'both', prefix, size);
                            yp_insert_rule(selector, 'animation-duration', duration + 's', prefix, size);
                        }

                    }

                    if (value == 'bounce') {

                        if (value != 'disable' && value != 'none') {
                            yp_insert_rule(selector, 'transform-origin', 'center bottom', prefix, size);
                        } else {
                            yp_insert_rule(selector, 'transform-origin', value, prefix, size);
                        }

                    } else if (value == 'swing') {

                        if (value != 'disable' && value != 'none') {
                            yp_insert_rule(selector, 'transform-origin', 'top center', prefix, size);
                        } else {
                            yp_insert_rule(selector, 'transform-origin', value, prefix, size);
                        }

                    } else if (value == 'jello') {

                        if (value != 'disable' && value != 'none') {
                            yp_insert_rule(selector, 'transform-origin', 'center', prefix, size);
                        } else {
                            yp_insert_rule(selector, 'transform-origin', value, prefix, size);
                        }

                    } else {
                        yp_insert_rule(selector, 'transform-origin', 'disable', prefix, size);
                    }

                    if (value == 'flipInX') {
                        yp_insert_rule(selector, 'backface-visibility', 'visible', prefix, size);
                    } else {
                        yp_insert_rule(selector, 'backface-visibility', 'disable', prefix, size);
                    }

                }


                // Checking.
                if (value == 'disable' || value == '' || value == 'undefined' || value == null) {
                    body.removeClass("yp-inserting");
                    return false;
                }

                // New Value
                var current = value + prefix;

                // Clean.
                if (body.hasClass("yp-css-converter") == false) {
                    current = current.replace(/ !important/g, "").replace(/!important/g, "");
                }

                // Append default value.
                if (yp_id(selector) != '') {

                    var dpt = ':';

                    if (body.hasClass("yp-anim-creator") == true && id != 'position') {

                        iframe.find("." + yp_id(body.attr("data-anim-scene") + css)).remove();

                        iframe.find(".yp-anim-scenes ." + body.attr("data-anim-scene") + "").append('<style data-rule="' + css + '" class="style-' + body.attr("data-anim-scene") + ' scenes-' + yp_id(css) + '-style">' + selector + '{' + css + dpt + current + '}</style>');

                    } else {

                        // Responsive setting
                        var mediaBefore = yp_create_media_query_before();
                        var mediaAfter = yp_create_media_query_after();

                        iframe.find(".yp-styles-area").append('<style data-rule="' + css + '" data-size-mode="' + size + '" data-style="' + yp_id(selector) + '" class="' + yp_id(selector) + '-' + id + '-style yp_current_styles">' + mediaBefore + '' + '' + selector + '{' + css + dpt + current + '}' + '' + mediaAfter + '</style>');

                        yp_resort_styles();

                    }

                    if (!body.hasClass("yp-css-converter")) {
                        yp_draw();
                    }

                }

                // If CSS converter, stop here.
                if (body.hasClass("yp-css-converter")) {
                    body.removeClass("yp-inserting");
                    return false;
                }

                // No need to important for text-shadow.
                if (id == 'text-shadow') {
                    body.removeClass("yp-inserting");
                    return false;
                }

                var needToImportant = null;

                // Each all selected element and check if need to use important.
                iframe.find(".yp-selected,.yp-selected-others").each(function(){

                    // Default true.
                    needToImportant = true;

                    // Current Value
                    var isValue = $(this).css(css);

                    // If current value not undefined
                    if (isValue !== undefined && isValue !== null) {

                        // for color
                        if (isValue.indexOf("rgb") != -1 && id != 'box-shadow') {

                            // Convert to hex.
                            isValue = yp_color_converter(isValue);

                        } else if (isValue.indexOf("rgb") != -1 && id == 'box-shadow') {

                            // for box shadow.
                            var justRgb = isValue.match(/rgb(.*?)\((.*?)\)/g).toString();
                            var valueNoColor = isValue.replace(/rgb(.*?)\((.*?)\)/g, "");
                            isValue = valueNoColor + " " + yp_color_converter(justRgb);

                        }

                        // Clean
                        isValue = isValue.replace(" ", "");

                    }

                    // Clean
                    current = current.replace(" ", "");

                    // If date mean same thing: stop.
                    if (yp_id(current) == 'length' && yp_id(isValue) == 'autoauto') {
                        needToImportant = false;
                    }

                    if (yp_id(current) == 'inherit' && yp_id(isValue) == 'normal') {
                        needToImportant = false;
                    }

                    // No need important for parallax and filter.
                    if (id == 'background-parallax' || id == 'background-parallax-x' || id == 'background-parallax-speed' || id == 'filter' || id == '-webkit-filter' || id == '-webkit-transform') {
                        needToImportant = false;
                    }

                    if (isValue == undefined) {
                        needToImportant = false;
                    }

                    // if value is same, stop.
                    if (current == isValue && iframe.find(".yp-selected-others").length == 0) {
                        needToImportant = false;
                    }

                    // font-family bug.
                    if ((current.replace(/'/g, '"').replace(/, /g, ",")) == isValue) {
                        needToImportant = false;
                    }

                    // background position fix.
                    if (id == 'background-position') {

                        if (current == 'lefttop' && isValue == '0%0%') {
                            needToImportant = false;
                        }

                        if (current == 'leftcenter' && isValue == '0%50%') {
                            needToImportant = false;
                        }

                        if (current == 'leftbottom' && isValue == '0%100%') {
                            needToImportant = false;
                        }

                        if (current == 'righttop' && isValue == '100%0%') {
                            needToImportant = false;
                        }

                        if (current == 'rightcenter' && isValue == '100%50%') {
                            needToImportant = false;
                        }

                        if (current == 'rightbottom' && isValue == '100%100%') {
                            needToImportant = false;
                        }

                        if (current == 'centertop' && isValue == '50%0%') {
                            needToImportant = false;
                        }

                        if (current == 'centercenter' && isValue == '50%50%') {
                            needToImportant = false;
                        }

                        if (current == 'centercenter' && isValue == '50%50%') {
                            needToImportant = false;
                        }

                        if (current == 'centerbottom' && isValue == '50%100%') {
                            needToImportant = false;
                        }

                        if (current == 'centerbottom' && isValue == '50%100%') {
                            needToImportant = false;
                        }

                    }

                    if (id == 'width' || id == 'min-width' || id == 'max-width' || id == 'height' || id == 'min-height' || id == 'max-height' || id == 'font-size' || id == 'line-height' || id == 'letter-spacing' || id == 'word-spacing' || id == 'margin-top' || id == 'margin-left' || id == 'margin-right' || id == 'margin-bottom' || id == 'padding-top' || id == 'padding-left' || id == 'padding-right' || id == 'padding-bottom' || id == 'border-left-width' || id == 'border-right-width' || id == 'border-top-width' || id == 'border-bottom-width' || id == 'border-top-left-radius' || id == 'border-top-right-radius' || id == 'border-bottom-left-radius' || id == 'border-bottom-right-radius') {

                        // If value is similar.
                        if (yp_num(current.replace(/\.00$/g, "").replace(/\.0$/g, "")) !== '' && yp_num(current.replace(/\.00$/g, "").replace(/\.0$/g, "")) !== ' ' && yp_num(current.replace(/\.00$/g, "").replace(/\.0$/g, "")) == yp_num(isValue.replace(/\.00$/g, "").replace(/\.0$/g, ""))) {
                            needToImportant = false;
                        }

                        // Browser always return in px format, custom check for %, em.
                        if (current.indexOf("%") != -1 && isValue.indexOf("px") != -1) {

                            iframe.find(".yp-selected").addClass("yp-full-width");
                            var fullWidth = iframe.find(".yp-full-width").css("width");
                            iframe.find(".yp-selected").removeClass("yp-full-width");

                            if (parseInt(parseInt(fullWidth) * parseInt(current) / 100) == parseInt(isValue)) {
                                needToImportant = false;
                            }

                        }

                        // smart important not available for em format
                        if (current.indexOf("em") != -1 && isValue.indexOf("px") != -1) {
                            needToImportant = false;
                        }

                    }

                    // not use important, if browser return value with matrix.
                    if (id == "transform") {
                        if (isValue.indexOf("matrix") != -1) {
                            needToImportant = false;
                        }
                    }

                    // not use important, If value is inherit.
                    if (current == "inherit" || current == "auto") {
                        needToImportant = false;
                    }

                    if(needToImportant == true){
                        return false;
                    }

                }); // Each end.

                if(needToImportant == false){
                    body.removeClass("yp-inserting");
                    return false;
                }

                // Use important.
                yp_insert_important_rule(selector, id, value, prefix, size);

                // Update
                yp_draw();

                body.removeClass("yp-inserting");

            }

            // border style disable toggerher.
            $("#border-style-group .yp-disable-btn").on("click", function(e) {

                if (e.originalEvent) {

                    $("#border-top-style-group,#border-left-style-group,#border-right-style-group,#border-bottom-style-group").addClass("eye-enable");

                    if ($(this).hasClass("active") == true) {

                        $("#border-top-style-group .yp-disable-btn,#border-right-style-group .yp-disable-btn,#border-left-style-group .yp-disable-btn,#border-bottom-style-group .yp-disable-btn,#border-top-style-group .yp-disable-btn").addClass("active").trigger("click");

                    } else {

                        $("#border-top-style-group .yp-disable-btn,#border-right-style-group .yp-disable-btn,#border-left-style-group .yp-disable-btn,#border-bottom-style-group .yp-disable-btn,#border-top-style-group .yp-disable-btn").removeClass("active").trigger("click");

                    }

                }

            });

            // border width disable toggerher.
            $("#border-width-group .yp-disable-btn").on("click", function(e) {

                if (e.originalEvent) {

                    $("#border-top-width-group,#border-left-width-group,#border-right-width-group,#border-bottom-width-group").addClass("eye-enable");

                    if ($(this).hasClass("active") == true) {

                        $("#border-top-width-group .yp-disable-btn,#border-right-width-group .yp-disable-btn,#border-left-width-group .yp-disable-btn,#border-bottom-width-group .yp-disable-btn,#border-top-width-group .yp-disable-btn").addClass("active").trigger("click");

                    } else {

                        $("#border-top-width-group .yp-disable-btn,#border-right-width-group .yp-disable-btn,#border-left-width-group .yp-disable-btn,#border-bottom-width-group .yp-disable-btn,#border-top-width-group .yp-disable-btn").removeClass("active").trigger("click");

                    }

                }

            });

            // border color disable toggerher.
            $("#border-color-group .yp-disable-btn").on("click", function(e) {

                if (e.originalEvent) {

                    $("#border-top-color-group,#border-left-color-group,#border-right-color-group,#border-bottom-color-group").addClass("eye-enable");

                    if ($(this).hasClass("active") == true) {

                        $("#border-top-color-group .yp-disable-btn,#border-right-color-group .yp-disable-btn,#border-left-color-group .yp-disable-btn,#border-bottom-color-group .yp-disable-btn,#border-top-color-group .yp-disable-btn").addClass("active").trigger("click");

                    } else {

                        $("#border-top-color-group .yp-disable-btn,#border-right-color-group .yp-disable-btn,#border-left-color-group .yp-disable-btn,#border-bottom-color-group .yp-disable-btn,#border-top-color-group .yp-disable-btn").removeClass("active").trigger("click");

                    }

                }

            });

            // Border style none toggle
            $("#border-style-group .yp-none-btn").on("click", function() {

                if (!$(this).hasClass("active")) {
                    $("#border-bottom-style-group .yp-none-btn,#border-right-style-group .yp-none-btn,#border-left-style-group .yp-none-btn,#border-top-style-group .yp-none-btn").removeClass("active");
                } else {
                    $("#border-bottom-style-group .yp-none-btn,#border-right-style-group .yp-none-btn,#border-left-style-group .yp-none-btn,#border-top-style-group .yp-none-btn").addClass("active");
                }

                $("#border-bottom-style-group .yp-none-btn,#border-right-style-group .yp-none-btn,#border-left-style-group .yp-none-btn,#border-top-style-group .yp-none-btn").trigger("click");

            });

            // Border color none toggle
            $("#border-color-group .yp-none-btn").on("click", function() {

                if (!$(this).hasClass("active")) {
                    $("#border-bottom-color-group .yp-none-btn,#border-right-color-group .yp-none-btn,#border-left-color-group .yp-none-btn,#border-top-color-group .yp-none-btn").removeClass("active");
                } else {
                    $("#border-bottom-color-group .yp-none-btn,#border-right-color-group .yp-none-btn,#border-left-color-group .yp-none-btn,#border-top-color-group .yp-none-btn").addClass("active");
                }

                $("#border-bottom-color-group .yp-none-btn,#border-right-color-group .yp-none-btn,#border-left-color-group .yp-none-btn,#border-top-color-group .yp-none-btn").trigger("click");

            });

            /* ---------------------------------------------------- */
            /* Setup Slider Option                                  */
            /* ---------------------------------------------------- */
            function yp_slider_option(id, decimals, pxv, pcv, emv) {

                // Set Maximum and minimum values for custom prefixs.
                $("#" + id + "-group").data("px-range", pxv);
                $("#" + id + "-group").data("pc-range", pcv);
                $("#" + id + "-group").data("em-range", emv);

                // Default PX
                var range = $("#" + id + "-group").data("px-range").split(",");

                // Update PX.
                if ($("#" + id + "-group .yp-after-prefix").val() == 'px') {
                    var range = $("#" + id + "-group").data("px-range").split(",");
                }

                // Update %.
                if ($("#" + id + "-group .yp-after-prefix").val() == '%') {
                    var range = $("#" + id + "-group").data("pc-range").split(",");
                }

                // Update EM.
                if ($("#" + id + "-group .yp-after-prefix").val() == 'em') {
                    var range = $("#" + id + "-group").data("em-range").split(",");
                }

                // Update s.
                if ($("#" + id + "-group .yp-after-prefix").val() == 's') {
                    var range = $("#" + id + "-group").data("em-range").split(",");
                }

                // Setup slider.
                $('#yp-' + id).wqNoUiSlider({

                    start: [0],

                    range: {
                        'min': parseInt(range[0]),
                        'max': parseInt(range[1])
                    },

                    format: wNumb({
                        mark: '.',
                        decimals: decimals
                    })

                }).on('change', function() {

                    yp_slide_action($(this), id, true);

                }).on('slide', function() {

                    // Update the input.
                    $('#' + id + '-value').val($(this).val());

                    // some rules not support live css, so we check some rules.
                    if (id != 'background-parallax-speed' && id != 'background-parallax-x' && id != 'blur-filter' && id != 'grayscale-filter' && id != 'brightness-filter' && id != 'contrast-filter' && id != 'hue-rotate-filter' && id != 'saturate-filter' && id != 'sepia-filter' && id.indexOf("box-shadow-") == -1) {

                        // if transfrom
                        if (id.indexOf("-transform") != -1 && id != 'text-transform' && id != '-webkit-transform') {

                            yp_slide_action($(this), id, true);

                        } else { // if not

                            var val = $(this).val();
                            var prefix = $(this).parent().find("#" + id + "-after").val();
                            yp_clean_live_css(id, false);
                            yp_live_css(id, val + prefix, false);

                        }

                    } else { // for make it as live, inserting css to data.
                        yp_slide_action($(this), id, true);
                    }

                });

            }

            /* ---------------------------------------------------- */
            /* Slider Event                                         */
            /* ---------------------------------------------------- */
            function yp_slide_action(element, id, $slider) {

                var css = element.parent().parent().data("css");
                element.parent().parent().addClass("eye-enable");

                if ($slider == true) {

                    var val = element.val();

                    // If active, disable it.
                    element.parent().parent().find(".yp-btn-action.active").trigger("click");

                } else {

                    var val = element.parent().find("#" + css + "-value").val();

                }

                var selector = yp_get_current_selector();
                var css_after = element.parent().find("#" + css + "-after").val();

                // Border Width Fix
                if (id == 'border-width') {

                    // Set border width to all top, right..
                    if (css_after != $("#border-top-width-after").val()) {
                        $("#border-top-width-after").val(css_after).trigger("keyup");
                    }
                    if (css_after != $("#border-right-width-after").val()) {
                        $("#border-right-width-after").val(css_after).trigger("keyup");
                    }
                    if (css_after != $("#border-bottom-width-after").val()) {
                        $("#border-bottom-width-after").val(css_after).trigger("keyup");
                    }
                    if (css_after != $("#border-right-width-after").val()) {
                        $("#border-right-width-after").val(css_after).trigger("keyup");
                    }

                    // Value
                    $("#yp-border-top-width,#yp-border-bottom-width,#yp-border-left-width,#yp-border-right-width").val(val);

                    // disable
                    $("#border-top-width-group .yp-disable-btn.active,#border-right-width-group .yp-disable-btn.active,#border-bottom-width-group .yp-disable-btn.active,#border-left-width-group .yp-disable-btn.active").trigger("click");

                    // set solid for default.
                    if ($('input[name="border-style"]:checked').val() == 'none' || $('input[name="border-style"]:checked').val() === undefined || $('input[name="border-style"]:checked').val() == 'hidden') {
                        $("#border-style-solid").trigger("click");
                    }

                    // update CSS
                    yp_insert_rule(selector, 'border-top-width', val, css_after);
                    yp_insert_rule(selector, 'border-bottom-width', val, css_after);
                    yp_insert_rule(selector, 'border-left-width', val, css_after);
                    yp_insert_rule(selector, 'border-right-width', val, css_after);

                    // add eye icon
                    $("#border-top-width-group,#border-left-width-group,#border-right-width-group,#border-bottom-width-group").addClass("eye-enable");

                }

                if (id != 'border-width') {

                    // Set for demo
                    yp_insert_rule(selector, id, val, css_after);

                }

                // Option Changed
                yp_option_change();

            }

            function yp_escape(s) {
                return ('' + s) /* Forces the conversion to string. */
                    .replace(/\\/g, '\\\\') /* This MUST be the 1st replacement. */
                    .replace(/\t/g, '\\t') /* These 2 replacements protect whitespaces. */
                    .replace(/\n/g, '\\n')
                    .replace(/\u00A0/g, '\\u00A0') /* Useful but not absolutely necessary. */
                    .replace(/&/g, '\\x26') /* These 5 replacements protect from HTML/XML. */
                    .replace(/'/g, '\\x27')
                    .replace(/"/g, '\\x22')
                    .replace(/</g, '\\x3C')
                    .replace(/>/g, '\\x3E');
            }

            /* ---------------------------------------------------- */
            /* Getting radio val.                                   */
            /* ---------------------------------------------------- */
            function yp_radio_value(the_id, $n, data) {

                var id_prt = the_id.parent().parent();

                // for none btn
                id_prt.find(".yp-btn-action.active").trigger("click");

                if (data == id_prt.find(".yp-none-btn").text()) {
                    id_prt.find(".yp-none-btn").trigger("click");
                }

                if (data == 'auto auto') {
                    data = 'auto';
                }

                if (data != '' && typeof data != 'undefined') {

                    if (data.match(/\bauto\b/g)) {
                        data = 'auto';
                    }

                    if (data.match(/\bnone\b/g)) {
                        data = 'none';
                    }

                    if ($("input[name=" + $n + "][value=" + yp_escape(data) + "]").length > 0) {

                        the_id.find(".active").removeClass("active");

                        $("input[name=" + $n + "][value=" + yp_escape(data) + "]").prop('checked', true).parent().addClass("active");

                    } else {

                        the_id.find(".active").removeClass("active");

                        // Disable all.
                        $("input[name=" + $n + "]").each(function() {

                            $(this).prop('checked', false);

                        });

                        id_prt.find(".yp-none-btn:not(.active)").trigger("click");

                    }

                }

            }

            /* ---------------------------------------------------- */
            /* Radio Event                                          */
            /* ---------------------------------------------------- */
            function yp_radio_option(id) {

                $("#yp-" + id + " label").on('click', function() {

                    if ($(this).parent().hasClass("active")) {
                        return false;
                    }

                    var selector = yp_get_current_selector();
                    var css = $(this).parent().parent().parent().parent().data("css");

                    // Disable none.
                    $(this).parent().parent().parent().parent().find(".yp-btn-action.active").removeClass("active");
                    $(this).parent().parent().parent().parent().addClass("eye-enable").css("opacity", 1);

                    $("#yp-" + id).find(".active").removeClass("active");

                    $(this).parent().addClass("active");

                    $("#" + $(this).attr("data-for")).prop('checked', true);

                    var val = $("input[name=" + id + "]:checked").val();

                    // Border style fix.
                    if (id == 'border-style') {

                        yp_radio_value($("#yp-border-top-style"), 'border-top-style', val);
                        yp_radio_value($("#yp-border-bottom-style"), 'border-bottom-style', val);
                        yp_radio_value($("#yp-border-left-style"), 'border-left-style', val);
                        yp_radio_value($("#yp-border-right-style"), 'border-right-style', val);

                        // Update
                        yp_insert_rule(selector, 'border-top-style', val, '');
                        yp_insert_rule(selector, 'border-bottom-style', val, '');
                        yp_insert_rule(selector, 'border-left-style', val, '');
                        yp_insert_rule(selector, 'border-right-style', val, '');

                        // add eye icon
                        $("#border-top-style-group,#border-left-style-group,#border-right-style-group,#border-bottom-style-group").addClass("eye-enable");

                    }

                    if (id != 'border-style') {

                        // Set for demo
                        yp_insert_rule(selector, id, val, '');

                    }

                    // Option Changed
                    yp_option_change();

                });

            }

            /* ---------------------------------------------------- */
            /* Check if is safe font family.                        */
            /* ---------------------------------------------------- */
            function yp_safe_fonts(a) {

                if (a == 'Arial') {
                    return true;
                } else if (a == 'Arial Black') {
                    return true;
                } else if (a == 'Arial Narrow') {
                    return true;
                } else if (a == 'Arial Rounded MT Bold') {
                    return true;
                } else if (a == 'Avant Garde') {
                    return true;
                } else if (a == 'Calibri') {
                    return true;
                } else if (a == 'Candara') {
                    return true;
                } else if (a == 'Century Gothic') {
                    return true;
                } else if (a == 'Franklin Gothic Medium') {
                    return true;
                } else if (a == 'Futura') {
                    return true;
                } else if (a == 'Geneva') {
                    return true;
                } else if (a == 'Gill Sans') {
                    return true;
                } else if (a == 'Helvetica Neue') {
                    return true;
                } else if (a == 'Impact') {
                    return true;
                } else if (a == 'Lucida Grande') {
                    return true;
                } else if (a == 'Optima') {
                    return true;
                } else if (a == 'Segoe UI') {
                    return true;
                } else if (a == 'Tahoma') {
                    return true;
                } else if (a == 'Trebuchet MS') {
                    return true;
                } else if (a == 'Verdana') {
                    return true;
                } else if (a == 'Big Caslon') {
                    return true;
                } else if (a == 'Bodoni MT') {
                    return true;
                } else if (a == 'Book Antiqua') {
                    return true;
                } else if (a == 'Calisto MT') {
                    return true;
                } else if (a == 'Cambria') {
                    return true;
                } else if (a == 'Didot') {
                    return true;
                } else if (a == 'Garamond') {
                    return true;
                } else if (a == 'Georgia') {
                    return true;
                } else if (a == 'Goudy Old Style') {
                    return true;
                } else if (a == 'Hoefler Text') {
                    return true;
                } else if (a == 'Lucida Bright') {
                    return true;
                } else if (a == 'Palatino') {
                    return true;
                } else if (a == 'Perpetua') {
                    return true;
                } else if (a == 'Rockwell') {
                    return true;
                } else if (a == 'Rockwell Extra Bold') {
                    return true;
                } else if (a == 'Baskerville') {
                    return true;
                } else if (a == 'Times New Roman') {
                    return true;
                } else if (a == 'Consolas') {
                    return true;
                } else if (a == 'Courier New') {
                    return true;
                } else if (a == 'Lucida Console') {
                    return true;
                } else if (a == 'HelveticaNeue') {
                    return true;
                } else {
                    return false;
                }

            }

            /* ---------------------------------------------------- */
            /* Warning System                                       */
            /* ---------------------------------------------------- */

            /* For animations and display inline. */
            $(document).on("change", "#yp-animation-name-group,#yp-animation-play-group,#yp-animation-iteration-count-group", function(e) {

                if (!e.originalEvent) {
                    return false;
                }

                if (iframe.find(".yp-selected").css("display") == "inline") {
                    $(this).popover({
                        title: l18_warning,
                        content: l18_animation_notice,
                        trigger: 'click',
                        placement: "left",
                        container: ".yp-select-bar"
                    }).popover("show");
                } else {
                    $(this).popover("destroy");
                }

            });

            // Margin not working because display inline.
            $("#margin-left-group,#margin-right-group,#margin-top-group,#margin-bottom-group").on("mouseenter click", function(e) {

                if (!e.originalEvent) {
                    return false;
                }

                if (iframe.find(".yp-selected").css("display") == "inline" || iframe.find(".yp-selected").css("display") == "table-cell") {
                    $(this).popover({
                        title: l18_notice,
                        content: l18_margin_notice,
                        trigger: 'hover',
                        placement: "left",
                        container: ".yp-select-bar"
                    }).popover("show");
                } else {
                    $(this).popover("destroy");
                }

            });

            // Padding maybe not working, because display inline.
            $("#padding-left-group,#padding-right-group,#padding-top-group,#padding-bottom-group").on("mouseenter click", function(e) {

                if (!e.originalEvent) {
                    return false;
                }

                if (iframe.find(".yp-selected").css("display") == "inline") {
                    $(this).popover({
                        title: l18_notice,
                        content: l18_padding_notice,
                        trigger: 'hover',
                        placement: "left",
                        container: ".yp-select-bar"
                    }).popover("show");
                } else {
                    $(this).popover("destroy");
                }

            });

            // Border with must minimum 1px
            $("#border-width-group").on("mouseenter click", function(e) {

                if (!e.originalEvent) {
                    return false;
                }

                if (parseInt($("#border-width-value").val()) <= 0) {
                    $(this).popover({
                        title: l18_notice,
                        content: l18_border_width_notice,
                        trigger: 'hover',
                        placement: "left",
                        container: ".yp-select-bar"
                    }).popover("show");
                } else {
                    $(this).popover("destroy");
                }

            });

            // There is background image, maybe background color not work
            $("#background-color-group").on("mouseenter click", function(e) {

                if (!e.originalEvent) {
                    return false;
                }

                if ($("#yp-background-image").val() != '') {
                    $(this).popover({
                        title: l18_notice,
                        content: l18_bg_img_notice,
                        trigger: 'hover',
                        placement: "left",
                        container: ".yp-select-bar"
                    }).popover("show");
                } else {
                    $(this).popover("destroy");
                }

            });

            // There not have background image, parallax not work without background image.
            $(".background-parallax-div,#background-size-group,#background-repeat-group,#background-attachment-group,#background-position-group").on("mouseenter click", function(e) {

                if (!e.originalEvent) {
                    return false;
                }

                if ($("#yp-background-image").val() == '') {
                    $(this).popover({
                        title: l18_notice,
                        content: l18_bg_img_notice_two,
                        trigger: 'hover',
                        placement: "left",
                        container: ".yp-select-bar"
                    }).popover("show");
                } else {
                    $(this).popover("destroy");
                }

            });

            // Box shadow need to any color.
            $("#box-shadow-color-group").on("mouseenter click", function(e) {

                if (!e.originalEvent) {
                    return false;
                }

                if ($("#yp-box-shadow-color").val() == '') {
                    $(this).popover({
                        title: l18_notice,
                        content: l18_shadow_notice,
                        trigger: 'hover',
                        placement: "left",
                        container: ".yp-select-bar"
                    }).popover("show");
                } else {
                    $(this).popover("destroy");
                }

            });

            // Need border style set.
            $("#border-style-group").on("mouseenter click", function(e) {

                if (!e.originalEvent) {
                    return false;
                }

                if ($("#yp-border-style input:checked").val() == 'hidden' || $("#yp-border-style input:checked").val() == 'none' || $("#yp-border-style input:checked").val() == undefined) {
                    $(this).popover({
                        title: l18_notice,
                        content: l18_border_style_notice,
                        trigger: 'hover',
                        placement: "left",
                        container: ".yp-select-bar"
                    }).popover("show");
                } else {
                    $(this).popover("destroy");
                }

            });

            /* ---------------------------------------------------- */
            /* Select li hover                                      */
            /* ---------------------------------------------------- */

            $(".input-autocomplete").keydown(function(e) {

                var code = e.keyCode || e.which;

                if (code == 38 || code == 40) {

                    $(this).parent().find(".autocomplete-div .ui-state-focus").prev().trigger("mouseout");
                    $(this).parent().find(".autocomplete-div .ui-state-focus").trigger("mouseover");

                }

                // enter
                if (code == 13) {

                    $(this).blur();

                }

            });

            // Blur select after select.
            $(document).on("click", ".autocomplete-div ul li", function() {
                $(this).parent().parent().parent().find(".ui-autocomplete-input").trigger("blur");
            });

            $(".input-autocomplete").on("blur", function(e) {

                if (window.openVal == $(this).val()) {
                    return false;
                }

            });

            $(".input-autocomplete").on("blur keyup", function(e) {

                var id = $(this).parent().parent().data("css");

                $(".active-autocomplete-item").removeClass("active-autocomplete-item");
                $(this).removeClass("active");
                $("body").removeClass("autocomplete-active");

                yp_clean_live_css(id, "#yp-" + id + "-test-style");

                var selector = yp_get_current_selector();

                // Disable
                $(this).parent().parent().find(".yp-btn-action.active").trigger("click");
                $("#" + id + "-group").addClass("eye-enable");

                // Import google font
                if (id == 'font-family' && $(this).val() != null && $("body").hasClass("autocomplete-active") == true) {

                    if ($("#" + yp_id($(this).val())).length == 0) {

                        // Check if its not a safe font.
                        if (!yp_safe_fonts($(this).val())) {

                            // be sure font not available.
                            if (!yp_is_font_available($(this).text())) {

                                // be sure its google font.
                                if (yp_is_google_font($(this).text())) {

                                    // Append font to DOM.
                                    iframeBody.append("<link rel='stylesheet' class='yp-font-link' id='" + yp_id($(this).val()) + "' href='https://fonts.googleapis.com/css?family=" + $.trim($(this).val().replace(/ /g, '+')) + ":300italic,300,400,400italic,500,500italic,600,600italic,700,700italic' type='text/css' media='all' />");

                                }

                            }

                            yp_clean_live_css("font-family", "#yp-font-test-style");

                            // Check if font loaded.
                            var clearFix = setInterval(function() {

                                // Send Update
                                yp_draw();

                            }, 150);

                            setTimeout(function() {

                                // clear.
                                clearInterval(clearFix);

                            }, 2000);

                        }

                    }

                }

                // Font weight.
                if (id == 'font-weight') {
                    $("#yp-font-weight").css(id, $(this).val()).css("font-family", $("#yp-font-family").val());
                }

                // Font family
                if (id == 'font-family') {
                    $("#yp-font-family").css(id, $(this).val());
                    $("#yp-font-weight").css("font-family", $("#yp-font-family").val());
                }

                // delete visual data.
                yp_clean_live_css(id, "#yp-" + id + "-test-style");

                var val = $(this).val();

                if (id == 'font-family') {
                    if (val.indexOf(",") == -1 && val.indexOf("'") == -1 && val.indexOf('"') == -1) {
                        val = "'" + val + "'";
                    }
                }

                // Set for data
                yp_insert_rule(selector, id, val, '');

                yp_option_change();

            });

            var timerL;
            var delay = 160;
            $(document).on("mouseover", ".autocomplete-div li", function() {

                var element = $(this);

                $(".active-autocomplete-item").removeClass("active-autocomplete-item");

                var id = element.parent().parent().attr("id").replace("yp-autocomplete-place-", "");

                timerL = setTimeout(function() {

                    // If not current.
                    if (!element.hasClass("ui-state-focus")) {
                        return false;
                    }

                    // If not undefined.
                    if (typeof element.parent().attr("id") == 'undefined') {
                        return false;
                    }

                    // Font weight
                    if (id == 'font-weight') {

                        yp_clean_live_css("font-weight", "#yp-font-weight-test-style");
                        yp_live_css("font-weight", yp_num(element.text()).replace("-", ""), "#yp-font-weight-test-style");

                    }

                    // Font family
                    if (id == 'font-family') {

                        var $activeFont = iframe.find(".yp-font-test-style").data("family");

                        yp_clean_live_css("font-family", "#yp-font-test-style");

                        var $fid = yp_id($.trim(element.text().replace(/ /g, '+')));

                        if (yp_safe_fonts(element.text()) == false && iframe.find(".yp-font-test-" + $fid).length == 0 && $activeFont != element.text()) {

                            if (!yp_is_font_available(element.text())) {
                                iframeBody.append("<link rel='stylesheet' class='yp-font-test-" + $fid + "'  href='https://fonts.googleapis.com/css?family=" + $.trim(element.text().replace(/ /g, '+')) + ":300italic,300,400,400italic,500,500italic,600,600italic,700,700italic' type='text/css' media='all' />");
                            }

                            // Append always to body.
                            body.append("<link rel='stylesheet' class='yp-font-test-" + $fid + "'  href='https://fonts.googleapis.com/css?family=" + $.trim(element.text().replace(/ /g, '+')) + ":300italic,300,400,400italic,500,500italic,600,600italic,700,700italic' type='text/css' media='all' />");

                        }

                        // Append test font family.
                        yp_live_css('font-family', "'" + element.text() + "'", "#yp-font-test-style");

                        // Check font loaded.
                        var clearFix = setInterval(function() {

                            // Send Update
                            yp_draw();

                        }, 150);

                        setTimeout(function() {

                            // clear.
                            clearInterval(clearFix);

                        }, 2000);

                        element.css("font-family", element.text());

                    }

                }, delay);

                // Font Weight
                if (id == 'font-weight') {

                    $(".autocomplete-div li").each(function() {
                        element.css("font-weight", yp_num(element.text()).replace(/-/g, ''));
                    });

                    $(".autocomplete-div li").css("font-family", $("#yp-font-family").val());
                }

            });

            // If mouseout, stop clear time out.
            $(document).on("mouseout", ".autocomplete-div li", function() {

                clearTimeout(timerL);

            });

            // Toggle options.
            $(".wf-close-btn-link").click(function(e) {
                if ($(".yp-editor-list > li.active:not(.yp-li-about):not(.yp-li-footer)").length > 0) {
                    e.preventDefault();
                    $(".yp-editor-list > li.active:not(.yp-li-about):not(.yp-li-footer) > h3").trigger("click");
                }
            });

            /* Creating live CSS for color, slider and font-family and weight. */
            function yp_live_css(id, val, custom) {

                // Responsive helper
                var mediaBefore = yp_create_media_query_before();
                var mediaAfter = yp_create_media_query_after();

                // Style id
                if (custom != false) {
                    var styleId = custom;
                } else {
                    var styleId = "#" + id + "-live-css";
                }

                //Element
                var element = iframe.find(styleId);

                // Check
                if (element.length == 0) {

                    var idAttr = styleId.replace('#', '').replace('.', '');

                    var customAttr = '';

                    // For font family.
                    if (id == 'font-family') {
                        var customAttr = "data-family='" + val + "'";
                    }

                    // not use prefix (px,em,% etc)
                    if (id == 'z-index' || id == 'opacity') {
                        val = parseFloat(val);
                    }

                    // Append
                    iframeBody.append("<style class='" + idAttr + " yp-live-css' id='" + idAttr + "' " + customAttr + ">" + mediaBefore + ".yp-selected,.yp-selected-others," + yp_get_current_selector() + "{" + id + ":" + val + " !important;}" + mediaAfter + "</style>");

                }

            }

            /* Removing created live CSS */
            function yp_clean_live_css(id, custom) {

                // Style id
                if (custom != false) {
                    var styleId = custom;
                } else {
                    var styleId = "#" + id + "-live-css";
                }

                var element = iframe.find(styleId);

                if (element.length > 0) {
                    element.remove();
                }

            }

            // Iris color picker creating live css on mousemove
            mainDocument.on("mousemove", function() {

                if ($(".iris-dragging").length > 0) {

                    var element = $(".iris-dragging").parents(".yp-option-group");

                    var css = element.data("css");
                    var val = element.find(".wqcolorpicker").val();

                    if (css.indexOf("box-shadow-color") == -1) {

                        yp_clean_live_css(css, false);
                        yp_live_css(css, val, false);

                    } else {

                        element.find(".wqcolorpicker").trigger("change");

                    }

                }

                if ($(".iris-slider").find(".ui-state-active").length > 0) {

                    var element = $(".iris-slider").find(".ui-state-active").parents(".yp-option-group");

                    var css = element.data("css");
                    var val = element.find(".wqcolorpicker").val();

                    yp_clean_live_css(css, false);
                    yp_live_css(css, val, false);

                }

            });

            // Iris color picker click update.
            $(".iris-square-handle").on("mouseup", function() {

                var element = $(this).parents(".yp-option-group");

                element.find(".wqcolorpicker").trigger("change");

            });

            // Iris color picker creating YP Data.
            mainDocument.on("mouseup", function() {

                if ($(document).find(".iris-dragging").length > 0) {

                    var element = $(".iris-dragging").parents(".yp-option-group");

                    element.find(".wqcolorpicker").trigger("change");

                } else if ($(document).find(".iris-slider .ui-state-active").length > 0) {

                    var element = $(".ui-state-active").parents(".yp-option-group");

                    element.find(".wqcolorpicker").trigger("change");

                }

            });

            /* ---------------------------------------------------- */
            /* Color Event                                          */
            /* ---------------------------------------------------- */
            function yp_color_option(id) {

                // Color picker on blur
                $("#yp-" + id).on("blur", function() {

                    // If empty, set disable.
                    if ($(this).val() == '') {
                        return false;
                    }

                });

                // Show picker on click
                $("#yp-" + id).on("click", function() {

                    $(this).parent().parent().find(".iris-picker").show();
                    $(this).parent().parent().parent().css("opacity", 1);

                });

                // disable to true.
                $("#" + id + "-group").find(".yp-after a").on("click", function() {
                    $(this).parent().parent().parent().css("opacity", 1);
                });

                // Update on keyup
                $("#yp-" + id).on("keydown keyup", function() {
                    $(this).parent().find(".wqminicolors-swatch-color").css("background-color", $(this).val());
                });

                // Color picker on change
                $("#yp-" + id).on('change', function() {

                    var selector = yp_get_current_selector();
                    var css = $(this).parent().parent().parent().data("css");
                    $(this).parent().parent().parent().addClass("eye-enable");
                    var val = $(this).val();

                    if (val.indexOf("#") == -1) {
                        val = "#" + val;
                    }

                    // Disable
                    $(this).parent().parent().find(".yp-btn-action.active").trigger("click");
                    $(this).parent().parent().find(".yp-after-disable,.yp-after-disable-disable").hide();

                    if (val.length < 3) {
                        val = 'transparent';
                        $(this).parent().parent().find(".yp-none-btn:not(.active)").trigger("click");
                    }

                    // Border Color Fix
                    if (id == 'border-color') {

                        $("#yp-border-top-color").val(val);
                        $("#yp-border-bottom-color").val(val);
                        $("#yp-border-left-color").val(val);
                        $("#yp-border-right-color").val(val);

                        // set color
                        $("#border-top-color-group .wqminicolors-swatch-color,#border-bottom-color-group .wqminicolors-swatch-color,#border-left-color-group .wqminicolors-swatch-color,#border-right-color-group .wqminicolors-swatch-color").css("background-color", val);

                        // disable
                        $("#border-top-color-group .yp-disable-btn.active,#border-right-color-group .yp-disable-btn.active,#border-bottom-color-group .yp-disable-btn.active,#border-left-color-group .yp-disable-btn.active").trigger("click");

                        // none
                        $("#border-top-color-group .yp-none-btn.active,#border-right-color-group .yp-none-btn.active,#border-bottom-color-group .yp-none-btn.active,#border-left-color-group .yp-none-btn.active").trigger("click");

                        // Update
                        yp_insert_rule(selector, 'border-top-color', val, '');
                        yp_insert_rule(selector, 'border-bottom-color', val, '');
                        yp_insert_rule(selector, 'border-left-color', val, '');
                        yp_insert_rule(selector, 'border-right-color', val, '');

                        // add eye icon
                        $("#border-top-color-group,#border-left-color-group,#border-right-color-group,#border-bottom-color-group").addClass("eye-enable");

                    }

                    // If not border color.
                    if (id != 'border-color') {

                        // Set for demo
                        yp_clean_live_css(css, false);

                        yp_insert_rule(selector, id, val, '');

                    }

                    // Update.
                    $(this).parent().find(".wqminicolors-swatch-color").css("background-image", "none");

                    // Option Changed
                    yp_option_change();

                });

            }

            /* ---------------------------------------------------- */
            /* Input Event                                          */
            /* ---------------------------------------------------- */
            function yp_input_option(id) {

                // Keyup
                $("#yp-" + id).on('keyup', function() {

                    $(this).parent().parent().addClass("eye-enable");

                    var selector = yp_get_current_selector();
                    var css = $(this).parent().parent().data("css");
                    var val = $(this).val();

                    // Disable
                    $(this).parent().find(".yp-btn-action.active").trigger("click");

                    if (val == 'none') {
                        $(this).parent().parent().find(".yp-none-btn").not(".active").trigger("click");
                        $(this).val('');
                    }

                    if (val == 'disable') {
                        $(this).parent().parent().find(".yp-disable-btn").not(".active").trigger("click");
                        $(this).val('');
                    }

                    val = val.replace(/\)/g, '').replace(/\url\(/g, '');

                    $(this).val(val);

                    if (id == 'background-image') {

                        val = 'url(' + val + ')';

                        $(".yp-background-image-show").remove();
                        var imgSrc = val.replace(/"/g, "").replace(/'/g, "").replace(/url\(/g, "").replace(/\)/g, "");

                        if (val.indexOf("yellow-pencil") == -1) {

                            if (imgSrc.indexOf("//") != -1 && imgSrc != '' && imgSrc.indexOf(".") != -1) {
                                $("#yp-background-image").after("<img src='" + imgSrc + "' class='yp-background-image-show' />");
                            }

                        }

                    }

                    // Set for demo

                    yp_insert_rule(selector, id, val, '');

                    // Option Changed
                    yp_option_change();

                });

            }

            /* ---------------------------------------------------- */
            /* Remove data                                          */
            /* ---------------------------------------------------- */
            function yp_clean() {

                var bodyX = $("body");

                if (body.hasClass("yp-dragging")){
                    return false;
                }

                // Clean popovers.
                if($("body").hasClass("yp-content-selected")){
                    $("#set-animation-name-group,#margin-left-group,#margin-right-group,#margin-top-group,#margin-bottom-group,#padding-left-group,#padding-right-group,#padding-top-group,#padding-bottom-group,#border-width-group,#background-color-group,.background-parallax-div,#background-size-group,#background-repeat-group,#background-attachment-group,#background-position-group,#box-shadow-color-group,#border-style-group,#yp-animation-name-group,#yp-animation-play-group,#yp-animation-iteration-count-group").popover("destroy");
                }

                $(".yp-editor-list > li.active:not(.yp-li-about) > h3").trigger("click");

                // destroy ex element draggable feature.
                if (body.hasClass("yp-content-selected") && iframe.find(".yp-selected.ui-draggable").length > 0) {
                    iframe.find(".yp-selected").draggable("destroy");
                }

                iframe.find(".yp-selected,.yp-selected-others").removeClass("ui-draggable ui-draggable-handle ui-draggable-handle");

                /* this function remove selected element */
                if (iframe.find(".context-menu-active").length > 0) {
                    iframe.find(".yp-selected").contextMenu("hide");
                }

                body.removeAttr("data-clickable-select").removeAttr("data-yp-selector").removeClass("yp-selector-focus yp-selector-hover yp-left-selected-resizeable yp-css-data-trigger yp-contextmenuopen yp-content-selected yp-body-select-just-it yp-has-transform");

                iframe.find(".yp-selected-others,.yp-selected").removeClass("yp-selected-others").removeClass("yp-selected");

                iframe.find(".ready-for-drag").removeClass("ready-for-drag");

                iframe.find(".yp-edit-menu,.yp-selected-handle,.yp-selected-others-top,.yp-selected-others-left,.yp-selected-others-right,.yp-selected-others-bottom,.yp-selected-tooltip,.yp-selected-boxed-top,.yp-selected-boxed-left,.yp-selected-boxed-right,.yp-selected-boxed-bottom,.yp-selected-boxed-margin-top,.yp-selected-boxed-margin-left,.yp-selected-boxed-margin-right,.yp-selected-boxed-margin-bottom,.selected-just-it-span,.yp-selected-boxed-padding-top,.yp-selected-boxed-padding-left,.yp-selected-boxed-padding-right,.yp-selected-boxed-padding-bottom,.yp-live-css").remove();

                iframe.find(".yp_onscreen,.yp_hover,.yp_click,.yp_focus").removeClass("yp_onscreen yp_hover yp_click yp_focus");

                body.removeClass("yp-element-resizing yp-element-resizing-height-top yp-element-resizing-height-bottom yp-element-resizing-width-left yp-element-resizing-width-right");

                $(".eye-enable").removeClass("eye-enable");

                $(".yp-option-group").css("opacity", "1");
                $(".yp-after").css("display", "block");

                // delete ex cache data.
                $("li[data-loaded]").removeAttr("data-loaded");

                // copied by iframe click select section.
                $(".yp-editor-list > li.active > h3").not(".yp-li-about").not(".yp-li-footer").trigger("click");

                $(".input-autocomplete").removeAttr("style");

                $(".yp-disable-contextmenu").removeClass("yp-disable-contextmenu");
                $(".yp-active-contextmenu").removeClass("yp-active-contextmenu");

                iframe.find(".yp-selected-tooltip span").remove();

                if(!bodyX.hasClass("yp-select-just-it")){
                    window.selectorClean = null;
                }

                if(bodyX.hasClass("yp-anim-creator") || bodyX.hasClass("yp-anim-link-toggle")){
                    yp_anim_cancel();
                }

            }

            /* ---------------------------------------------------- */
            /* Getting Stylizer data                                */
            /* ---------------------------------------------------- */
            function yp_get_styles_area() {
                var data = iframe.find(".yp-styles-area").html();
                data = data.replace(/</g, 'YP|@');
                data = data.replace(/>/g, 'YP@|');
                return data;
            }

            /* ---------------------------------------------------- */
            /* Getting CSS data                                     */
            /* ---------------------------------------------------- */
            function yp_get_clean_css(a) {


                var data = yp_get_css_data('desktop');

                // Adding break
                data = data.replace(/\)\{/g, "){\r").replace(/\)\{/g, "){\r");

                // Clean spaces for nth-child and not.
                data = data.replace(/nth-child\((.*?)\)\{\r\r/g, "nth-child\($1\)\{");
                data = data.replace(/not\((.*?)\)\{\r\r/g, "not\($1\)\{");

                if (iframe.find(".yp_current_styles").length > 0) {

                    var mediaArray = [];

                    iframe.find(".yp_current_styles").each(function() {
                        var v = $(this).attr("data-size-mode");

                        if ($.inArray(v, mediaArray) === -1 && v != 'desktop') {
                            mediaArray.push(v);
                        }
                    })

                    $.each(mediaArray, function(i, v) {

                        var q = yp_get_css_data(v);

                        // Add extra tab for media query content.
                        q = "\t" + q.replace(/\r/g, '\r\t').replace(/\t$/g, '').replace(/\t$/g, '');

                        if (v == 'tablet') {
                            v = '(min-width: 768px) and (max-width: 991px)';
                        }

                        if (v == 'mobile') {
                            v = '(max-width:767px)';
                        }

                        data = data + "\r\r@media " + v + "{\r\r" + q + "}";

                    });

                }

                if (a == true) {
                    data = data.replace(/\r\ta:a !important;/g, "");
                    data = data.replace(/a:a !important;/g, "");
                    data = data.replace(/a:a;/g, "");
                }

                // Clean first empty lines.
                data = data.replace(/^\r/g, '').replace(/^\r/g, '');

                data = data.replace(/\}\r\r\r\r@media/g, '}\r\r@media');

                return data;

            }

            /* ---------------------------------------------------- */
            /* Create All Css Codes For current selector            */
            /* ---------------------------------------------------- */
            function yp_get_css_data(size) {

                if (iframe.find(".yp_current_styles").length <= 0) {
                    return '';
                }

                var totalCreated, classes, selector;

                totalCreated = '';

                iframe.find(".yp_current_styles:not(.yp_step_end)[data-size-mode='" + size + "']").each(function() {

                    if (!$(this).hasClass("yp_step_end")) {

                        if ($(this).first().html().indexOf("@media") != -1) {
                            var data = $(this).first().html().split("{")[1] + "{" + $(this).first().html().split("{")[2].replace("}}", "}");
                        } else {
                            var data = $(this).first().html();
                        }

                        selector = data.split("{")[0];

                        totalCreated += selector + "{\r";

                        classes = $(this).data("style");

                        iframe.find("style[data-style=" + classes + "][data-size-mode='" + size + "']").each(function() {

                            if ($(this).first().html().indexOf("@media") != -1) {
                                var datai = $(this).first().html().split("{")[1] + "{" + $(this).first().html().split("{")[2].replace("}}", "}");
                            } else {
                                var datai = $(this).first().html();
                            }

                            totalCreated += "\t" + datai.split("{")[1].split("}")[0] + ';\r';

                            $(this).addClass("yp_step_end");

                        });

                        totalCreated += "}\r\r";

                        $(this).addClass("yp_step_end");

                    }

                });

                iframe.find(".yp_step_end").removeClass("yp_step_end");

                return totalCreated;

            }

            // toggle created background image.
            $("#background-image-group .yp-none-btn,#background-image-group .yp-disable-btn").click(function() {
                $("#background-image-group .yp-background-image-show").toggle();
            });

            /* ---------------------------------------------------- */
            /* Set Default Option Data                              */
            /* ---------------------------------------------------- */
            function yp_set_default(evt, $n, evt_status) {

                // element
                if (evt_status == true) {
                    var eventTarget = iframe.find(evt.target);
                } else {
                    var eventTarget = iframe.find(evt);
                }

                // Remove Active colors:
                $(".yp-nice-c.active,.yp-flat-c.active,.yp-meterial-c.active").removeClass("active");

                // Adding animation helper classes
                if ($n == 'animation-name' || $n == 'animation-iteration-count' || $n == 'animation-fill-mode' || $n == 'animation-duration' || $n == 'animation-iteration-count') {
                    iframe.find(".yp-selected,.yp-selected-others").addClass("yp_onscreen").addClass("yp_hover").addClass("yp_click").addClass("yp_focus");
                }

                setTimeout(function() {

                    var elementID = yp_id($("body").attr("data-clickable-select"));

                    // There is any css
                    if (iframe.find('.' + elementID + "-" + $n + "-style").length > 0) {
                        $("#" + $n + "-group").addClass("eye-enable");
                    }

                    // add disable eye icon for border style
                    if ($n == "border-style") {
                        if (iframe.find('.' + elementID + "-border-top-style-style").length > 0 && iframe.find('.' + elementID + "-border-bottom-style-style").length > 0 && iframe.find('.' + elementID + "-border-left-style-style").length > 0 && iframe.find('.' + elementID + "-border-right-style-style").length > 0) {
                            $("#" + $n + "-group").addClass("eye-enable");
                        }
                    }

                    // add disable eye icon for border style
                    if ($n == "border-width") {
                        if (iframe.find('.' + elementID + "-border-top-width-style").length > 0 && iframe.find('.' + elementID + "-border-bottom-width-style").length > 0 && iframe.find('.' + elementID + "-border-left-width-style").length > 0 && iframe.find('.' + elementID + "-border-right-width-style").length > 0) {
                            $("#" + $n + "-group").addClass("eye-enable");
                        }
                    }

                    // add disable eye icon for border style
                    if ($n == "border-color") {
                        if (iframe.find('.' + elementID + "-border-top-color-style").length > 0 && iframe.find('.' + elementID + "-border-bottom-color-style").length > 0 && iframe.find('.' + elementID + "-border-left-color-style").length > 0 && iframe.find('.' + elementID + "-border-right-color-style").length > 0) {
                            $("#" + $n + "-group").addClass("eye-enable");
                        }
                    }

                    // data is default value
                    if ($n != 'animation-play') {
                        var data = eventTarget.css($n);
                    }

                    // Chome return "rgba(0,0,0,0)" if no background color,
                    // its is chrome hack.
                    if ($n == 'background-color') {
                        if (data == 'rgba(0, 0, 0, 0)') {
                            data = 'transparent';
                        }
                    }

                    // Animation name play.
                    if ($n == 'animation-name' && data != 'none') {

                        // Add class.
                        body.addClass("yp-hide-borders-now");

                        var time = $("#animation-duration-value").val();

                        if (time == null || time == undefined) {
                            time = '1200';
                        } else {
                            time = time.replace("ms", ""); // ms delete
                            time = time.replace("s", "000");
                        }

                        time = parseInt(time) + 150;

                        setTimeout(function() {

                            // Update.
                            yp_draw();

                            // remove class.
                            body.removeClass("yp-hide-borders-now");

                        }, time);

                    }

                    // animation helpers: because need special data for animation rules.
                    if ($n == 'animation-play') {

                        // Default
                        var data = 'yp_onscreen';

                        if (iframe.find('[data-style="' + elementID + 'yp_onscreen"]').length > 0) {
                            data = 'yp_onscreen';
                        }

                        if (iframe.find('[data-style="' + elementID + 'yp_click"]').length > 0) {
                            data = 'yp_click';
                        }

                        if (iframe.find('[data-style="' + elementID + 'yp_hover"]').length > 0) {
                            data = 'yp_hover';
                        }

                        if (iframe.find('[data-style="' + elementID + 'yp_focus"]').length > 0) {
                            data = 'yp_focus';
                        }

                        if ($("body").hasClass("yp-selector-hover")) {
                            data = 'yp_hover';
                        }

                        if ($("body").hasClass("yp-selector-focus")) {
                            data = 'yp_focus';
                        }

                        if (data === undefined || data === null) {
                            return false;
                        }

                    }

                    // Num: numberic data
                    var $num = yp_num(eventTarget.css($n));

                    // filter = data of filter css rule.
                    if ($n.indexOf("-filter") != -1) {

                        var filter = eventTarget.css("filter");
                        if (filter == null || filter == 'none' || filter == undefined) {
                            filter = eventTarget.css("-webkit-filter"); // for chrome.
                        }

                        // Special default values for filter css rule.
                        if (filter != 'none' && filter !== null && filter !== undefined && $n.indexOf("-filter") != -1) {

                            if ($n == 'blur-filter') {
                                data = filter.match(/blur\((.*?)\)/g);
                            }

                            if ($n == 'brightness-filter') {
                                data = filter.match(/brightness\((.*?)\)/g);
                            }

                            if ($n == 'grayscale-filter') {
                                data = filter.match(/grayscale\((.*?)\)/g);
                            }

                            if ($n == 'contrast-filter') {
                                data = filter.match(/contrast\((.*?)\)/g);
                            }

                            if ($n == 'hue-rotate-filter') {
                                data = filter.match(/hue-rotate\((.*?)\)/g);

                                if (data !== null) {
                                    data = (data.toString().replace("deg", "").replace("hue-rotate(", "").replace(")", ""));
                                }

                            }

                            if ($n == 'saturate-filter') {
                                data = filter.match(/saturate\((.*?)\)/g);
                            }

                            if ($n == 'sepia-filter') {
                                data = filter.match(/sepia\((.*?)\)/g);
                            }

                            if (data !== undefined && data !== null) {
                                data = yp_num(data.toString());
                                $num = data;
                            } else {
                                $num = 0;
                                data = 'disable';
                            }

                        }

                        // Special default values for brightness and contrast.
                        if ($n.indexOf("-filter") != -1) {
                            if (filter == 'none' || filter == null || filter == undefined) {
                                data = 'disable';
                                $num = 0;

                                if ($n == 'brightness-filter') {
                                    $num = 1;
                                }

                                if ($n == 'contrast-filter') {
                                    $num = 1;
                                }

                            }
                        }

                    }

                    // Font weight fix.
                    if ($n == 'font-weight') {
                        if (data == 'bold') {
                            data = '600'
                        }
                        if (data == 'normal') {
                            data = '600'
                        }
                    }

                    if ($n.indexOf("-transform") != -1 && $n != 'text-transform') {

                        var transform = 'none';

                        // Getting transform value from HTML Source ANIM.
                        if ($("body").hasClass("yp-anim-creator")) {

                            var currentScene = $("body").attr("data-anim-scene").replace("scene-", "");

                            var ht = '';
                            var transform = '';

                            // Check scenes by scenes for get transfrom data.
                            if (iframe.find('.scene-' + (currentScene) + ' .scenes-transform-style').length > 0) {

                                ht = iframe.find('.scene-' + (currentScene) + ' .scenes-transform-style').last().html();
                                transform = ht.split(":")[1].split("}")[0];

                            } else if (iframe.find('.scene-' + (currentScene - 1) + ' .scenes-transform-style').length > 0) {

                                ht = iframe.find('.scene-' + (currentScene - 1) + ' .scenes-transform-style').last().html();
                                transform = ht.split(":")[1].split("}")[0];

                            } else if (iframe.find('.scene-' + (currentScene - 2) + ' .scenes-transform-style').length > 0) {

                                ht = iframe.find('.scene-' + (currentScene - 2) + ' .scenes-transform-style').last().html();
                                transform = ht.split(":")[1].split("}")[0];

                            } else if (iframe.find('.scene-' + (currentScene - 3) + ' .scenes-transform-style').length > 0) {

                                ht = iframe.find('.scene-' + (currentScene - 3) + ' .scenes-transform-style').last().html();
                                transform = ht.split(":")[1].split("}")[0];

                            } else if (iframe.find('.scene-' + (currentScene - 4) + ' .scenes-transform-style').length > 0) {

                                ht = iframe.find('.scene-' + (currentScene - 4) + ' .scenes-transform-style').last().html();
                                transform = ht.split(":")[1].split("}")[0];

                            } else if (iframe.find('.scene-' + (currentScene - 5) + ' .scenes-transform-style').length > 0) {

                                ht = iframe.find('.scene-' + (currentScene - 5) + ' .scenes-transform-style').last().html();
                                transform = ht.split(":")[1].split("}")[0];

                            } else {
                                var transform = 'none;'
                            }

                        }

                        // Getting transform value from HTML Source.
                        if (transform == 'none') {
                            if (iframe.find('.' + elementID + '-' + 'transform-style').length > 0) {
                                var ht = iframe.find('.' + elementID + '-' + 'transform-style').html();
                                var transform = ht.split(":")[1].split("}")[0];
                            } else {
                                var transform = 'none';
                            }
                        }

                        // Special Default Transform css rule value.
                        if (transform != 'none' && transform !== null && transform !== undefined && $n.indexOf("-transform") != -1 && $n != 'text-transform') {

                            if ($n == 'scale-transform') {
                                data = transform.match(/scale\((.*?)\)/g);
                            }

                            if ($n == 'rotate-transform') {
                                data = transform.match(/rotate\((.*?)\)/g);
                            }

                            if ($n == 'translate-x-transform') {
                                data = transform.match(/translatex\((.*?)\)/g);
                            }

                            if ($n == 'translate-y-transform') {
                                data = transform.match(/translatey\((.*?)\)/g);
                            }

                            if ($n == 'skew-x-transform') {
                                data = transform.match(/skewx\((.*?)\)/g);
                            }

                            if ($n == 'skew-y-transform') {
                                data = transform.match(/skewy\((.*?)\)/g);
                            }

                            if (data !== undefined && data !== null) {
                                data = yp_num(data.toString());
                                $num = data;
                            } else {
                                $num = 0;
                                data = 'disable';

                                if ($n == 'scale-transform') {
                                    $num = 1;
                                }

                            }

                        }

                    }

                    if ($n == "animation-duration" && $("body").hasClass("yp-anim-creator") == true) {
                        if (data == '0s' || data == '0ms') {
                            return false;
                        }
                    }

                    if ($n == 'position' && eventTarget.hasClass("ready-for-drag") == true) {
                        data = 'static';
                    }

                    if (window.styleData == undefined || window.styleData == 'undefined') {
                        window.styleData = '';
                    }

                    var styleData = eventTarget.attr("style");

                    if (styleData == undefined || styleData == 'undefined') {
                        styleData = '';
                    }

                    if ($n == 'position' && window.styleData.indexOf("relative") == -1 && styleData.indexOf("relative") != -1) {
                        data = 'static';
                    }

                    if ($n == 'bottom') {

                        if (parseFloat(eventTarget.css("top")) + parseFloat(eventTarget.css("bottom")) == 0) {
                            data = 'auto';
                            $("#bottom-group .yp-after").hide();
                        }
                    }

                    if ($n == 'right') {
                        if (parseFloat(eventTarget.css("left")) + parseFloat(eventTarget.css("right")) == 0) {
                            data = 'auto';
                            $("#right-group .yp-after").hide();
                        }
                    }

                    // Box Shadow.
                    if ($n.indexOf("box-shadow-") != -1 && eventTarget.css("box-shadow") != 'none' && eventTarget.css("box-shadow") !== null && eventTarget.css("box-shadow") !== undefined) {

                        // Box shadow color default value.
                        if ($n == 'box-shadow-color') {

                            // Hex
                            if (eventTarget.css("box-shadow").indexOf("#") != -1) {
                                if (eventTarget.css("box-shadow").split("#")[1].indexOf("inset") == -1) {
                                    data = $.trim(eventTarget.css("box-shadow").split("#")[1]);
                                } else {
                                    data = $.trim(eventTarget.css("box-shadow").split("#")[1].split(' ')[0]);
                                }
                            } else {
                                if (eventTarget.css("box-shadow").indexOf("rgb") != -1) {
                                    data = eventTarget.css("box-shadow").match(/rgb(.*?)\((.*?)\)/g).toString();
                                }
                            }

                        }

                        // split all box-shadow data.
                        var numbericBox = eventTarget.css("box-shadow").replace(/rgb(.*?)\((.*?)\) /g, '').replace(/ rgb(.*?)\((.*?)\)/g, '').replace(/inset /g, '').replace(/ inset/g, '');

                        // shadow horizontal value.

                        if ($n == 'box-shadow-horizontal') {
                            data = numbericBox.split(" ")[0];
                            $num = yp_num(data);
                        }

                        // shadow vertical value.
                        if ($n == 'box-shadow-vertical') {
                            data = numbericBox.split(" ")[1];
                            $num = yp_num(data);
                        }

                        // Shadow blur radius value.
                        if ($n == 'box-shadow-blur-radius') {
                            data = numbericBox.split(" ")[2];
                            $num = yp_num(data);
                        }

                        // Shadow spread value.
                        if ($n == 'box-shadow-spread') {
                            data = numbericBox.split(" ")[3];
                            $num = yp_num(data);
                        }

                    }

                    // if no info about inset, default is no.
                    if ($n == 'box-shadow-inset') {

                        if (eventTarget.css("box-shadow") === undefined) {

                            data = 'no';

                        } else {

                            if (eventTarget.css("box-shadow").indexOf("inset") == -1) {
                                data = 'no';
                            } else {
                                data = 'inset';
                            }

                        }

                    }

                    // box shadow notice
                    if (eventTarget.css("box-shadow") != 'none' && eventTarget.css("box-shadow") != 'undefined' && eventTarget.css("box-shadow") != undefined && eventTarget.css("box-shadow") != '') {
                        $(".yp-has-box-shadow").show();
                    } else {
                        $(".yp-has-box-shadow").hide();
                    }

                    // Getting format: px, em, etc.
                    var $format = yp_alfa(eventTarget.css($n)).replace("-", "");

                    // option element.
                    var the_id = $("#yp-" + $n);

                    // option element parent of parent.
                    var id_prt = the_id.parent().parent();

                    // option element parent.
                    var id_prtz = the_id.parent();

                    // if special CSS, get css by CSS data.
                    // ie for parallax. parallax not a css rule.
                    // yellow pencil using css engine for parallax Property.
                    if (eventTarget.css($n) == undefined && iframe.find('.' + elementID + '-' + $n + '-style').length > 0) {

                        data = iframe.find('.' + elementID + '-' + $n + '-style').html().split(":")[1].split('}')[0].replace(/;/g, '').replace(/!important/g, '');
                        $num = yp_num(data);

                    } else if (eventTarget.css($n) == undefined) { // if no data, use "disable" for default.

                        if ($n == 'background-parallax') {
                            data = 'disable';
                        }

                        if ($n == 'background-parallax-speed') {
                            data = 'disable';
                        }

                        if ($n == 'background-parallax-x') {
                            data = 'disable';
                        }

                    }

                    var element = iframe.find(".yp-selected");

                    // IF THIS IS A SLIDER
                    if (the_id.hasClass("wqNoUi-target")) {

                        // Border width Fix
                        if ($n == 'border-width') {

                            var element = iframe.find(".yp-selected");

                            if (element.css("border-top-width") == element.css("border-bottom-width")) {

                                if (element.css("border-left-width") == element.css("border-right-width")) {

                                    if (element.css("border-top-width") == element.css("border-left-width")) {

                                        $num = yp_num(element.css("border-top-width"));
                                        $format = yp_alfa(element.css("border-top-width"));

                                    }

                                }

                            }

                        } // border width end.

                        // if no data, active none option.
                        if (data == 'none' || data == 'auto') {
                            id_prt.find(".yp-none-btn").not(".active").trigger("click");
                            $format = 'px';
                        } else {
                            id_prt.find(".yp-none-btn.active").trigger("click"); // else disable none option.
                        }

                        $format = $.trim($format);

                        // be sure format is valid.
                        if ($format == '' || $format == 'px .px' || $format == 'px px') {
                            $format = 'px';
                        }

                        // be sure format is valid.
                        if ($format.indexOf("px") != -1) {
                            $format = 'px';
                        }

                        // Default value is 1 for transform scale.
                        if ($num == '' && $n == 'scale-transform') {
                            $num = 1;
                        }

                        // default value is 1 for opacity.
                        if ($num == '' && $n == 'opacity') {
                            $num = 1;
                        }

                        // If no data, set zero value.
                        if ($num == '') {
                            $num = 0;
                        }

                        var range = id_prt.data("px-range").split(",");

                        var $min = parseInt(range[0]); // mininum value
                        var $max = parseInt(range[1]); // maximum value

                        // Check values.
                        if ($num < $min) {
                            $min = $num;
                        }

                        if ($num > $max) {
                            $max = $num;
                        }

                        // Speacial max and min limits for CSS size rules.
                        if ($n == 'width' || $n == 'max-width' || $n == 'min-width' || $n == 'height' || $n == 'min-height' || $n == 'max-height') {
                            $max = parseInt($max) + (parseInt($max) * 1.5);
                            $min = parseInt($min) + (parseInt($min) * 1.5);
                        }

                        // if width is same with windows width, so set 100%!
                        // Note: browsers always return value in PX format.
                        if (eventTarget.css("display") == 'block' || eventTarget.css("display") == 'inline-block') {

                            if ($n == 'width' && parseInt($(window).innerWidth()) == parseInt($num)) {
                                $num = '100';
                                $format = '%';
                            }

                            if (eventTarget.parent().length > 0) {

                                // if  width is same with parent width, so set 100%!
                                if ($n == 'width' && parseInt(eventTarget.parent().innerWidth()) == parseInt($num)) {
                                    $num = '100';
                                    $format = '%';
                                }

                                // if  width is 50% of parent width, so set 50%!
                                if ($n == 'width' && parseInt(eventTarget.parent().innerWidth()) == (parseInt($num) * 2)) {
                                    $num = '50';
                                    $format = '%';
                                }

                                // if  width is 25% of parent width, so set 25%!
                                if ($n == 'width' && parseInt(eventTarget.parent().innerWidth()) == (parseInt($num) * 4)) {
                                    $num = '25';
                                    $format = '%';
                                }

                                // if  width is 20% of parent width, so set 20%!
                                if ($n == 'width' && parseInt(eventTarget.parent().innerWidth()) == (parseInt($num) * 5)) {
                                    $num = '20';
                                    $format = '%';
                                }

                            }

                        }

                        // max and min for %.
                        if ($format == '%') {
                            $min = 0;
                            $max = 200;
                        }

                        // Okay now set nouislider.
                        var slider = the_id.wqNoUiSlider({
                            range: {
                                'min': parseInt($min),
                                'max': parseInt($max)
                            },
                            start: parseFloat($num)
                        }, true);

                        // Set new value.
                        the_id.val($num);

                        // Update the input.
                        $('#' + $n + '-value').val($num);

                        // set format of value. px, em etc.
                        $("#" + $n + "-after").val($format);

                        return false;

                        // IF THIS IS A SELECT TAG
                    } else if (the_id.hasClass("input-autocomplete")) {

                        // Checking font family settings.
                        if ($n == 'font-family' && typeof data != 'undefined') {

                            if (data.indexOf(",") >= 0) {

                                data = data.split(",");

                                var founded = false;

                                $.each(data, function(i, v) {
                                    if (founded == false) {
                                        data = $.trim(data[i].replace(/"/g, "").replace(/'/g, ""));
                                        founded = true;
                                    }
                                });

                            }

                        }

                        if (data !== undefined && data !== 'undefined' && data !== '' && data !== null) {

                            // Set CSS For this selected value. example: set font-family for this option.
                            id_prt.find("#yp-" + $n).css($n, data);

                            // Append default font family to body. only for select font family.
                            if ($(".yp-font-test-" + yp_id($.trim(data.replace(/ /g, '+')))).length == 0 && $n == 'font-family') {

                                // If safe font, stop.
                                if (yp_safe_fonts(data) == false) {

                                    // Be sure its google font.
                                    if (yp_is_google_font(data)) {

                                        // Append always to body.
                                        body.append("<link rel='stylesheet' class='yp-font-test-" + yp_id($.trim(data.replace(/ /g, '+'))) + "'  href='https://fonts.googleapis.com/css?family=" + $.trim(data.replace(/ /g, '+')) + ":300italic,300,400,400italic,500,500italic,600,600italic,700,700italic' type='text/css' media='all' />");

                                    }

                                }

                            }

                            // If have data, so set!
                            if ($n == 'font-family' && data.indexOf(",") == -1) {

                                // Getting value
                                var value = $("#yp-font-family-data option").filter(function() {
                                    return $(this).text() === data;
                                }).first().attr("value");

                                // Select by value.
                                if (value != undefined) {

                                    value = value.toLowerCase().replace(/\b[a-z]/g, function(letter) {
                                        return letter.toUpperCase();
                                    });

                                    the_id.val(value);
                                } else {

                                    data = data.toLowerCase().replace(/\b[a-z]/g, function(letter) {
                                        return letter.toUpperCase();
                                    });

                                    the_id.val(data);
                                }

                            } else if ($n == 'font-family' && data.indexOf(",") != -1) {

                                the_id.val(data);

                            } else {

                                // set value.
                                the_id.val(data);

                            }

                            if ($n == 'font-family') {
                                $("#yp-font-family,#yp-font-weight").each(function() {
                                    $(this).css("font-family", data);
                                });
                            }

                        }

                        // Active none button.
                        id_prt.find(".yp-btn-action.active").trigger("click");

                        // If data is none, auto etc, so active none button.
                        if (data == id_prt.find(".yp-none-btn").text()) {
                            id_prt.find(".yp-none-btn").trigger("click");
                        }

                        // If not have this data in select options, insert this data.
                        if (the_id.val() == null && data != id_prt.find(".yp-none-btn").text() && data !== undefined) {
                            the_id.val(data);
                        }

                        return false;

                        // IF THIS IS A RADIO TAG
                    } else if (the_id.hasClass("yp-radio-content")) {

                        // Border style Fix
                        if ($n == 'border-style' && data == '') {

                            if (element.css("border-top-style") == element.css("border-bottom-style")) {

                                if (element.css("border-left-style") == element.css("border-right-style")) {

                                    if (element.css("border-top-style") == element.css("border-left-style")) {

                                        data = element.css("border-top-style");

                                    }

                                }

                            }

                        }

                        // Fix background size rule.
                        if ($n == 'background-size') {
                            if (data == 'auto' || data == '' || data == ' ' || data == 'auto auto') {
                                data = 'auto auto';
                            }
                        }

                        // If disable, active disable button.
                        if (data == 'disable' && $n != 'background-parallax') {
                            id_prt.find(".yp-disable-btn").not(".active").trigger("click");
                        } else {
                            yp_radio_value(the_id, $n, data); // else Set radio value.
                        }

                        return false;

                        // IF THIS IS COLORPICKER
                    } else if (the_id.hasClass("wqcolorpicker")) {

                        // Border color Fix
                        if ($n == 'border-color' && data == '') {

                            if (element.css("border-top-color") == element.css("border-bottom-color")) {

                                if (element.css("border-left-color") == element.css("border-right-color")) {

                                    if (element.css("border-top-color") == element.css("border-left-color")) {

                                        data = element.css("border-top-color");

                                    }

                                }

                            }

                        }

                        if ($n == 'box-shadow-color') {
                            if (data === undefined || data == false || data == 'none' || data == '') {
                                data = eventTarget.css("color");
                            }
                        }

                        // Convert to rgb and set value.
                        if (data !== undefined && data !== false) {
                            if (data.indexOf("#") == -1) {
                                var rgbd = yp_color_converter(data);
                            }
                        }

                        // browsers return value always in rgb format.
                        the_id.val(rgbd);

                        the_id.iris('color', data);

                        // Set current color on small area.
                        the_id.parent().find(".wqminicolors-swatch-color").css("background-color", rgbd).css("background-image", "none");

                        // If transparent
                        if (data == 'transparent' || data == '') {
                            id_prt.find(".yp-disable-btn.active").trigger("click");
                            id_prt.find(".yp-none-btn:not(.active)").trigger("click");
                            the_id.parent().find(".wqminicolors-swatch-color").css("background-image", "url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOwAAADsAQMAAABNHdhXAAAABlBMVEW/v7////+Zw/90AAAAUElEQVRYw+3RIQ4AIAwDwAbD/3+KRPKDGQQQbpUzbS6zF0lLeSffqYr3cXHzzd3PivHmzZs3b968efPmzZs3b968efPmzZs3b968efP+03sBF7TBCROHcrMAAAAASUVORK5CYII=)");
                        } else {
                            id_prt.find(".yp-none-btn.active").trigger("click");
                        }

                        if ($n == 'box-shadow-color') {
                            $("#box-shadow-color-group .wqminicolors-swatch-color").css("background-color", data);
                        }

                        return false;

                        // IF THIS IS INPUT OR TEXTAREA
                    } else if (the_id.hasClass("yp-input") == true || the_id.hasClass("yp-textarea")) {

                        // clean URL() prefix for background image.
                        if (typeof data != 'undefined' && data != 'disable' && $n == "background-image" && data != window.location.href) {

                            // If background-image is empty.
                            var a = $(document).find("#iframe").attr("src");
                            var b = data.replace(/"/g, "").replace(/'/g, "").replace(/url\(/g, "").replace(/\)/g, "");
                            if (a == b) {
                                data = '';
                            }

                            the_id.val(data.replace(/"/g, "").replace(/'/g, "").replace(/url\(/g, "").replace(/\)/g, ""));

                            if (data.indexOf("yellow-pencil") > -1) {
                                $(".yp_bg_assets").removeClass("active");
                                $(".yp_bg_assets[data-url='" + data.replace(/"/g, "").replace(/'/g, "").replace(/url\(/g, "").replace(/\)/g, "") + "']").addClass("active");
                            } else {
                                $(".yp-background-image-show").remove();
                                var imgSrc = data.replace(/"/g, "").replace(/'/g, "").replace(/url\(/g, "").replace(/\)/g, "");
                                if (imgSrc.indexOf("//") != -1 && imgSrc != '' && imgSrc.indexOf(".") != -1) {
                                    $("#yp-background-image").after("<img src='" + imgSrc + "' class='yp-background-image-show' />");
                                }
                            }

                        } else {
                            $(".yp-background-image-show").remove();
                        }

                        // If no data, active none button.
                        if (data == 'none') {
                            id_prtz.find(".yp-none-btn").not(".active").trigger("click");
                            the_id.val(''); // clean value.
                        } else {
                            id_prtz.find(".yp-none-btn.active").trigger("click"); // else disable.
                        }

                        // If no data, active disable button.
                        if (data == 'disable') {
                            id_prtz.find(".yp-disable-btn").not(".active").trigger("click");
                            the_id.val('');
                        } else {
                            id_prtz.find(".yp-disable-btn.active").trigger("click"); // else disable.
                        }

                        return false;

                    }

                }, 2);

            }

            function yp_is_google_font(font) {

                var status = false;
                $('select#yp-font-family-data option').each(function() {
                    if ($(this).text() == font) {
                        status = true;
                        return true;
                    }
                });

                return status;

            }

            function yp_nonuseful_classes(value) {

                value = value.replace(/-/g, "W06lXW");
                value = value.replace(/\./g, '').replace(/</g, '').replace(/>/g, '').replace(/  /g, ' ');

                value = value.replace(/\bdismissable(\w+)\b/g, ''); //dismissable+
                value = value.replace(/\b(\w+)dismissable\b/g, ''); //+dismissable
                value = value.replace(/\bhasW06lXW(\w+)\b/g, ''); //has-+
                value = value.replace(/\b(\w+)W06lXWhas\b/g, ''); //+-has

                return $.trim(value);

            }

            /* ---------------------------------------------------- */
            /* Get Best Class Name                                  */
            /* ---------------------------------------------------- */
            /*
                 the most important function in yellow pencil scripts
                  this functions try to find most important class name
                  in classes.

                  If no class, using ID else using tag name.
             */
            function yp_get_best_class($element) {

                // Cache
                var element = $($element);

                // Element Classes
                var classes = element.attr("class");

                // Clean Yellow Pencil Classes
                if (classes != undefined && classes != null) {
                    classes = yp_classes_clean(classes);
                }

                // Cache id and tagname.
                var id = element.attr("id");
                var tag = element[0].nodeName.toLowerCase();

                if (tag == 'body' || tag == 'html') {
                    return tag;
                }

                // Default
                var best_classes = '';
                var nummeric_class = '';
                var the_best = '';

                // Use tag name with class.
                var ClassNameTag = '';
                if (tag != 'div' && tag != undefined && tag != null) {
                    ClassNameTag = tag;
                }

                // If Element has ID, Return ID.
                if (typeof id != 'undefined') {

                    if ($.trim(id).substring(0, 4) == "fws_") {
                        id = '';
                    }

                    if (element.hasClass("widget") == true) {
                        id = '';
                    }

                    if ($.trim(id).indexOf("menu-item-") != -1) {
                        id = '';
                    }

                    if ($.trim(id).indexOf("comment-") != -1) {
                        id = '';
                    }

                    if ($.trim(id).indexOf("post-") != -1) {
                        id = '';
                    }

                    if ($.trim(id).indexOf("li-comment-") != -1) {
                        id = '';
                    }

                    if ($.trim(id) != '' && $.trim(the_best) == '') {
                        return ClassNameTag + '#' + id;
                    }

                }

                // If has classes.
                if (classes != undefined && classes != null) {

                    // Column class is second plan if
                    // has small, large, medium classes.
                    if (classes.indexOf("columns") != -1 && classes.indexOf("small-") != -1) {
                        classes = classes.replace(/\bcolumns\b/g, '');
                    }

                    if (classes.indexOf("columns") != -1 && classes.indexOf("medium-") != -1) {
                        classes = classes.replace(/\bcolumns\b/g, '');
                    }

                    if (classes.indexOf("columns") != -1 && classes.indexOf("large-") != -1) {
                        classes = classes.replace(/\bcolumns\b/g, '');
                    }

                    // Classes to array.
                    var ArrayClasses = classes.split(" ");

                    // Foreach classes.
                    // If has normal classes and nunmmeric classes,
                    // Find normal classes and cache to best_classes variable.
                    $(ArrayClasses).each(function(i, v) {

                        if (v.match(/\d+/g)) {
                            nummeric_class = v;
                        } else {
                            best_classes += ' ' + v;
                        }

                    });

                }

                // we want never use some class names. so disabling this classes.
                best_classes = yp_nonuseful_classes(best_classes.toString());

                // If Has Best Classes
                if ($.trim(best_classes) != '') {

                    // Make as array.
                    the_best = $.trim(best_classes).split(" ");

                    // Replace significant classes and keep best classes.
                    var significant_classes = $.trim($.trim(best_classes).replace(/-/g, "W06lXW").replace(/\brow\b/g, '').replace(/\bvc_row\b/g, '').replace(/\bcolW06lXW(\w+)W06lXW[0W06lXW9]\b/g, '').replace(/\bcolW06lXW(\w+)W06lXWoffsetW06lXW[0W06lXW9]\b/g, '').replace(/\bspan[0W06lXW9]\b/g, '').replace(/\blsW06lXWlW06lXW1\b/g, '').replace(/\bsmallW06lXW[0W06lXW9]\b/g, '').replace(/\bmediumW06lXW[0W06lXW9]\b/g, '').replace(/\blargeW06lXW[0W06lXW9]\b/g, '').replace(/\bsmallW06lXWpushW06lXW[0W06lXW9]\b/g, '').replace(/\bsmallW06lXWpullW06lXW[0W06lXW9]\b/g, '').replace(/\bmediumW06lXWpushW06lXW[0W06lXW9]\b/g, '').replace(/\bmediumW06lXWpullW06lXW[0W06lXW9]\b/g, '').replace(/\blargeW06lXWpushW06lXW[0W06lXW9]\b/g, '').replace(/\blargeW06lXWpullW06lXW[0W06lXW9]\b/g, '').replace(/\bclearfix\b/g, '').replace(/\bclear\b/g, '').replace(/\bpullW06lXWleft\b/g, '').replace(/\bpullW06lXWright\b/g, '').replace(/\bstatusW06lXWpublish\b/g, '').replace(/\btypeW06lXWpage\b/g, '').replace(/\bhentry\b/g, '').replace(/\bpage_item\b/g, "").replace(/\bthreadW06lXWeven\b/g, "").replace(/\bthreadW06lXWodd\b/g, "").replace(/\bthreadW06lXWalt\b/g, "").replace(/\bmenuW06lXWitemW06lXWtypeW06lXWpost_type\b/g, "").replace(/\bmenuW06lXWitemW06lXWobjectW06lXWpage\b/g, "").replace(/\bmenuW06lXWitemW06lXWobjectW06lXWcustom\b/g, "").replace(/\bmenuW06lXWitemW06lXWtypeW06lXWcustom\b/g, "").replace(/\bfirst\b/g, "").replace(/\blast\b/g, "").replace(/\bnoW06lXWjs\b/g, "").replace(/\bloggedW06lXWin\b/g, "").replace(/\bvisibleW06lXW(\w+)W06lXWblock\b/g, '').replace(/\bvisibleW06lXW(\w+)W06lXWinlineW06lXWblock\b/g, '').replace(/\bvisibleW06lXW(\w+)W06lXWinline\b/g, '').replace(/\bpureW06lXW(\w+)W06lXWuW06lXW[0W06lXW9]W06lXW[0W06lXW9]\b/g, '').replace(/\bhiddenW06lXWlg\b/g, '').replace(/\bhiddenW06lXWmd\b/g, '').replace(/\bhiddenW06lXWsm\b/g, '').replace(/\bhiddenW06lXWxs\b/g, '').replace(/\bhiddenW06lXWprint\b/g, '').replace(/\bvisibleW06lXWprintW06lXWblock\b/g, '').replace(/\bvisibleW06lXWprintW06lXWinlineW06lXWblock\b/g, '').replace(/\bvisibleW06lXWprintW06lXWblock\b/g, '').replace(/\btextW06lXWleft\b/g, '').replace(/\btextW06lXWcenter\b/g, '').replace(/\btextW06lXWright\b/g, '').replace(/\btextW06lXWjustify\b/g, '').replace(/\bshowW06lXWforW06lXW(\w+)\b/g, '').replace(/\bhideW06lXWforW06lXW(\w+)\b/g, '').replace(/\bmediumW06lXW[0W06lXW9]\b/g, '').replace(/\blargeW06lXW[0W06lXW9]\b/g, '').replace(/\bsmallW06lXW[0W06lXW9]\b/g, '').replace(/\bmediumW06lXW(\w+)W06lXW[0W06lXW9]\b/g, '').replace(/\blargeW06lXW(\w+)W06lXW[0W06lXW9]\b/g, '').replace(/\bsmallW06lXW(\w+)W06lXW[0W06lXW9]\b/g, '').replace(/\btypeW06lXW(\w+)\b/g, '').replace(/\b(\w+)W06lXWtype\b/g, '').replace(/\bstatusW06lXW(\w+)\b/g, '').replace(/\b(\w+)W06lXWstatus\b/g, '').replace(/\bformatW06lXW(\w+)\b/g, '').replace(/\b(\w+)W06lXWformat\b/g, '').replace(/\breadyW06lXW(\w+)\b/g, '').replace(/\b(\w+)W06lXWready\b/g, '').replace(/\bsingleW06lXWnoW06lXWmedia\b/g, '').replace(/\balign(\w+)\b/g, '').replace(/\b(\w+)align\b/g, '').replace(/\bhidden(\w+)\b/g, '').replace(/\b(\w+)hidden\b/g, '').replace(/\bvisibility(\w+)\b/g, '').replace(/\b(\w+)visibility\b/g, '').replace(/\bblock(\w+)\b/g, '').replace(/\b(\w+)block\b/g, '').replace(/\bleft\b/g, '').replace(/\bnoW06lXWjs\b/g, '').replace(/\bright\b/g, '').replace(/\brequired\b/g, '').replace(/\bsf-js-enabled\b/g, '').replace(/\b(\w+)closed\b/g, '')).replace(/W06lXW/g, "-");

                    // Important classes, current-menu-item etc
                    // If has this any classes, keep this more important.
                    var i;
                    var return_the_best = '';
                    for (i = 0; i < the_best.length; i++) {

                        if (the_best[i] == 'current-menu-item' || the_best[i] == 'active' || the_best[i] == 'current' || the_best[i] == 'post' || the_best[i] == 'widget' || the_best[i] == 'sticky' || the_best[i] == 'wp-post-image' || the_best[i] == 'entry-title' || the_best[i] == 'entry-content' || the_best[i] == 'entry-meta' || the_best[i] == 'comment-author-admin' || the_best[i] == 'item' || the_best[i] == 'widget-title' || the_best[i] == 'widgettitle') {
                            if (body.hasClass("yp-sharp-selector-mode-active") == true) {
                                if (the_best[i] != 'current' && the_best[i] != 'active') {
                                    return_the_best = the_best[i];
                                }
                            } else {
                                return_the_best = the_best[i];
                            }
                        }

                        if (return_the_best == '' && body.hasClass("yp-sharp-selector-mode-active") == false) {
                            if (the_best[i].indexOf("active") != -1 || the_best[i].indexOf("current") != -1) {
                                return_the_best = the_best[i];
                            }
                        }

                    }

                    // If no best and has class menu item, use it.
                    if (return_the_best == '' && element.hasClass("menu-item")) {
                        return_the_best = 'menu-item';
                    }

                    // Image selection
                    if (return_the_best == '' && nummeric_class.indexOf("wp-image-") > -1 && tag == 'img') {
                        return_the_best = $.trim(nummeric_class.match(/wp-image-[0-9]+/g).toString());
                    }

                    // Some element selecting by tag names.
                    var tagFounded = false;

                    // If there not have any best class.
                    if (return_the_best == '') {

                        // select img by tagname if no id or best class.
                        if (tag == 'li' && typeof id == 'undefined') {
                            tagFounded = true;
                            the_best = tag;
                        }

                        // select img by tagname if no id or best class.
                        if (tag == 'img' && typeof id == 'undefined') {
                            tagFounded = true;
                            the_best = tag;
                        }

                        // Use article for this tag.
                        if (tag == 'article' && element.hasClass("comment") == true) {
                            tagFounded = true;
                            the_best = tag;
                        }

                    }

                    // If the best classes is there, return.
                    if (return_the_best != '') {

                        the_best = '.' + return_the_best;

                        // If can't find best classes, use significant classes.
                    } else if (significant_classes != '' && tagFounded == false) {

                        // Convert to array.
                        significant_classes = significant_classes.split(" ");

                        var current = null;
                        for (i = 0; i < significant_classes.length; i++) { // item item-odd iten-even

                            // If has "even", not have "odd" and there is more classes then 1.
                            if (significant_classes[i].indexOf("even") != -1 && significant_classes[i].indexOf("odd") == -1 && significant_classes.length > 1) {
                                current = significant_classes[i];
                                significant_classes = $.trim(significant_classes.join(" ").toString().replace(current, "")).split(" ");
                                break;
                            }

                            // If has "odd", not have "even" and there is more classes then 1.
                            if (significant_classes[i].indexOf("odd") != -1 && significant_classes[i].indexOf("even") == -1 && significant_classes.length > 1) {
                                current = significant_classes[i];
                                significant_classes = $.trim(significant_classes.join(" ").toString().replace(current, "")).split(" ");
                                break;
                            }

                        }

                        // Find most long classes.
                        var maxlengh = significant_classes.sort(function(a, b) {
                            return b.length - a.length
                        });

                        // If finded, find classes with this char "-"
                        if (maxlengh[0] != 'undefined') {

                            // Finded.
                            var maxChar = significant_classes.sort(function(a, b) {
                                return b.indexOf("-") - a.indexOf("-")
                            });

                            // First prefer max class with "-" char.
                            if (maxChar[0] != 'undefined') {
                                the_best = '.' + maxChar[0];
                            } else if (maxlengh[0] != 'undefined') { // else try most long classes.
                                the_best = '.' + maxlengh[0];
                            }

                        } else {
                            // Get first class.
                            the_best = '.' + significant_classes[0];
                        }

                    } else if (tagFounded == false) {
                        the_best = '.' + the_best[0];
                    }

                } else {

                    // If has any class
                    if ($.trim(nummeric_class) != '') {
                        the_best = '.' + nummeric_class;
                    }

                    // If has an id
                    if ($.trim(id) != '' && $.trim(the_best) == '') {
                        the_best = ClassNameTag + '#' + id;
                    }

                    // If Nothing, Use tag name.
                    if ($.trim(tag) != '' && $.trim(the_best) == '') {
                        the_best = tag;
                    }

                }

                return $.trim(the_best.replace(/W06lXW/g, "-"));

            }

            /* ---------------------------------------------------- */
            /* Get All Current Parents                              */
            /* ---------------------------------------------------- */
            function yp_get_current_selector() {

                var parentsv = body.attr("data-clickable-select");

                if (typeof parentsv !== typeof undefined && parentsv !== false) {
                    return parentsv;
                } else {
                    yp_get_parents(iframe.find(".yp-selected"), "default");
                }

            }

            // A simple trim function
            function yp_left_trim(str, chr) {
                var rgxtrim = (!chr) ? new RegExp('^\\s+') : new RegExp('^' + chr + '+');
                return str.replace(rgxtrim, '');
            }

            /* ---------------------------------------------------- */
            /* Get All Parents                                      */
            /* ---------------------------------------------------- */
            function yp_get_parents(a, status) {

                // If parent already has.
                var parentsv = body.attr("data-clickable-select");

                // If status default, return current data.
                if (status == 'default') {
                    if (typeof parentsv !== typeof undefined && parentsv !== false) {
                        return parentsv;
                    }
                }

                // Be sure this item is valid.
                if (a[0] === undefined || a[0] === false || a[0] === null) {
                    return false;
                }

                // If body, return.
                if (a[0].tagName.toLowerCase() == 'body') {
                    return 'body';
                }

                // If body, return.
                if (a[0].tagName.toLowerCase() == 'html') {
                    return false;
                }

                // Getting item parents.
                var parents = a.parents(document);

                // Empy variable.
                var selector = '';

                // Foreach all loops.
                for (var i = parents.length - 1; i >= 0; i--) {

                    // If Last Selector Item
                    if (i == parents.length - 1) {

                        selector += yp_get_best_class(parents[i]);

                    } else { // If not.

                        // Get Selector name.
                        var thisSelector = yp_get_best_class(parents[i]);

                        // Check if this Class.
                        // Reset past selector names if current selector already one in document.
                        if (thisSelector.indexOf(".") != -1 && iframe.find(thisSelector).length == 1) {

                            if (status != 'sharp' && body.hasClass("yp-sharp-selector-mode-active") == false) {
                                selector = thisSelector + window.separator; // Reset
                            }

                            if (status == 'sharp' || body.hasClass("yp-sharp-selector-mode-active") == true) {
                                if (yp_single_selector(selector).indexOf(" > ") == -1) {
                                    selector = thisSelector + window.separator; // Reset
                                }
                            }

                        } else {

                            selector += thisSelector + window.separator; // add new

                        }

                    }

                }

                // Clean selector.
                selector = $.trim(selector);

                if (status == 'sharp' || body.hasClass("yp-sharp-selector-mode-active") == true) {
                    selector = yp_left_trim(selector, "htmlbody ");
                    selector = yp_left_trim(selector, "html ");
                    selector = yp_left_trim(selector, "body ");
                }

                // Adding Last Element selector.
                if (a[0].tagName == 'INPUT') { // if input,use tag name.

                    var type = a.attr("type");

                    selector += window.separator + 'input[type=' + type + ']';

                } else { // else find the best class.
                    selector += window.separator + yp_get_best_class(a);
                }

                // Google map fix
                if (selector.indexOf(".gm-style") >= 0) {
                    selector = selector.split(window.separator + ".gm-style");
                    selector = selector[0];
                }

                // Selector clean.
                selector = selector.replace("htmlbody", "body");

                if (body.hasClass("yp-sharp-selector-mode-active") == true) {
                    return yp_single_selector(selector);
                }

                if (status == 'sharp') {
                    return $.trim(selector);
                }

                if (selector.indexOf("#") >= 0 && selector.indexOf("yp-") == -1) {
                    var before = selector.split("#")[0];
                    if (before.split(window.separator).length == 0) {
                        before = before;
                    } else {
                        before = before.split(window.separator)[before.split(window.separator).length - 1];
                    }
                    selector = selector.split("#");
                    selector = selector[(selector.length - 1)];
                    if (before.length < 4) {
                        selector = before + "#" + selector;
                    } else {
                        selector = "#" + selector;
                    }
                }

                // NEW
                if (selector != undefined) {

                    var array = selector.split(window.separator);

                    var q = 0;
                    for (q = 0; q < array.length - 2; q++) {

                        if (a.parents(array[q]).length == 1) {
                            delete array[q + 1];
                        }

                    }

                    var selectorNew = $.trim(array.join(window.separator)).replace(/  /g, ' ');
                    if (iframe.find(selector).length == iframe.find(selectorNew).length) {
                        selector = selectorNew;
                    }

                }

                // Return result.
                return selector;

            }

            /* ---------------------------------------------------- */
            /* Draw Tooltip and borders.                            */
            /* ---------------------------------------------------- */
            function yp_draw_box(element, classes) {

                if (typeof $(element) === 'undefined') {
                    var element_p = $(element);
                } else {
                    var element_p = iframe.find(element);
                }

                // Be sure this element have.
                if (element_p.length > 0) {

                    var marginTop = element_p.css("margin-top");
                    var marginBottom = element_p.css("margin-bottom");
                    var marginLeft = element_p.css("margin-left");
                    var marginRight = element_p.css("margin-right");

                    var paddingTop = element_p.css("padding-top");
                    var paddingBottom = element_p.css("padding-bottom");
                    var paddingLeft = element_p.css("padding-left");
                    var paddingRight = element_p.css("padding-right");

                    //Dynamic boxes variables
                    var element_offset = element_p.offset();
                    var topBoxes = element_offset.top;
                    var leftBoxes = element_offset.left;
                    if (leftBoxes < 0) {
                        leftBoxes = 0;
                    }
                    var widthBoxes = element_p.outerWidth(false);
                    var heightBoxes = element_p.outerHeight(false);
                    var widthBoxesMargin = element_p.outerWidth(true);
                    var heightBoxesMargin = element_p.outerHeight(true);

                    var bottomBoxes = topBoxes + heightBoxes;

                    if (body.hasClass("yp-content-selected")) {
                        var rightExtra = 2;
                        var rightS = 2;
                    } else {
                        var rightExtra = 1;
                        var rightS = 1;
                    }

                    var rightBoxes = leftBoxes + widthBoxes - rightExtra;

                    var windowWidth = $(window).width();
                    var documentHeight = $(document).height();

                    // If right border left is more then screen
                    if (rightBoxes > (windowWidth - window.scroll_width - rightS)) {
                        rightBoxes = windowWidth - window.scroll_width - rightS;
                    }

                    // If bottom border left is more then screen
                    if ((leftBoxes + widthBoxes) > windowWidth) {
                        widthBoxes = windowWidth - leftBoxes - 1;
                    }

                    if (heightBoxes > 1 && widthBoxes > 1) {

                        // Dynamic Box
                        if (iframe.find("." + classes + "-top").length == 0) {
                            iframeBody.append("<div class='" + classes + "-top'></div><div class='" + classes + "-bottom'></div><div class='" + classes + "-left'></div><div class='" + classes + "-right'></div>");
                        }

                        // Margin append
                        if (iframe.find("." + classes + "-margin-top").length == 0) {
                            iframeBody.append("<div class='" + classes + "-margin-top'></div><div class='" + classes + "-margin-bottom'></div><div class='" + classes + "-margin-left'></div><div class='" + classes + "-margin-right'></div>");
                        }

                        // Padding append.
                        if (iframe.find("." + classes + "-padding-top").length == 0) {
                            iframeBody.append("<div class='" + classes + "-padding-top'></div><div class='" + classes + "-padding-bottom'></div><div class='" + classes + "-padding-left'></div><div class='" + classes + "-padding-right'></div>");
                        }

                        // Dynamic Boxes position
                        iframe.find("." + classes + "-top").css("top", topBoxes).css("left", leftBoxes).css("width", widthBoxes);

                        iframe.find("." + classes + "-bottom").css("top", bottomBoxes).css("left", leftBoxes).css("width", widthBoxes);

                        iframe.find("." + classes + "-left").css("top", topBoxes).css("left", leftBoxes).css("height", heightBoxes);

                        iframe.find("." + classes + "-right").css("top", topBoxes).css("left", rightBoxes).css("height", heightBoxes);

                        // Top Margin
                        iframe.find("." + classes + "-margin-top").css("top", parseFloat(topBoxes) - parseFloat(marginTop)).css("left", parseFloat(leftBoxes) - parseFloat(marginLeft)).css("width", parseFloat(widthBoxes) + parseFloat(marginRight) + parseFloat(marginLeft)).css("height", marginTop);

                        // Bottom Margin
                        iframe.find("." + classes + "-margin-bottom").css("top", bottomBoxes).css("left", parseFloat(leftBoxes) - parseFloat(marginLeft)).css("width", parseFloat(widthBoxes) + parseFloat(marginRight) + parseFloat(marginLeft)).css("height", marginBottom);

                        // Left Margin
                        iframe.find("." + classes + "-margin-left").css("top", topBoxes).css("left", parseFloat(leftBoxes) - parseFloat(marginLeft)).css("height", heightBoxes).css("width", marginLeft);

                        // Right Margin
                        iframe.find("." + classes + "-margin-right").css("top", topBoxes).css("left", rightBoxes).css("height", heightBoxes).css("width", marginRight);

                        // Top Padding
                        iframe.find("." + classes + "-padding-top").css("top", parseFloat(topBoxes)).css("left", parseFloat(leftBoxes)).css("width", parseFloat(widthBoxes / 2)).css("height", paddingTop);

                        // Bottom Padding
                        iframe.find("." + classes + "-padding-bottom").css("top", bottomBoxes - parseFloat(paddingBottom)).css("left", parseFloat(leftBoxes)).css("width", parseFloat(widthBoxes / 2)).css("height", paddingBottom);

                        // Left Padding
                        iframe.find("." + classes + "-padding-left").css("top", topBoxes).css("left", parseFloat(leftBoxes)).css("height", heightBoxes / 2).css("width", paddingLeft);

                        // Right Padding
                        iframe.find("." + classes + "-padding-right").css("top", topBoxes).css("left", rightBoxes - parseFloat(paddingRight)).css("height", heightBoxes / 2).css("width", paddingRight);

                        iframe.find(".yp-selected-handle").css("left", iframe.find(".yp-selected-boxed-right").css("left"));
                        iframe.find(".yp-selected-handle").css("top", iframe.find(".yp-selected-boxed-bottom").css("top"));

                    }

                }

            }

            // From Alexandre Gomes Blog
            function yp_get_scroll_bar_width() {

                // no need on responsive mode.
                if ($("body").hasClass("yp-responsive-device-mode")) {
                    return 0;
                }

                // If no scrollbar, return zero.
                if (iframe.height() <= $(window).height() && $("body").hasClass("yp-metric-disable") == true) {
                    return 0;
                }

                var inner = document.createElement('p');
                inner.style.width = "100%";
                inner.style.height = "200px";

                var outer = document.createElement('div');
                outer.style.position = "absolute";
                outer.style.top = "0px";
                outer.style.left = "0px";
                outer.style.visibility = "hidden";
                outer.style.width = "200px";
                outer.style.height = "150px";
                outer.style.overflow = "hidden";
                outer.appendChild(inner);

                document.body.appendChild(outer);
                var w1 = inner.offsetWidth;
                outer.style.overflow = 'scroll';
                var w2 = inner.offsetWidth;
                if (w1 == w2) w2 = outer.clientWidth;

                document.body.removeChild(outer);

                return (w1 - w2);
            };

            /* ---------------------------------------------------- */
            /* Draw Tooltip and borders.                            */
            /* ---------------------------------------------------- */
            function yp_draw_box_other(element, classes, $i) {

                var element_p = $(element);

                if (element_p === null) {
                    return false;
                }

                if (element_p[0].nodeName == "HTML" || element_p[0].nodeName == "BODY") {
                    return false;
                }

                if (element_p.length == 0) {
                    return false;
                }

                // Be sure this is visible on screen
                if (element_p.css("display") == 'none' || element_p.css("visibility") == 'hidden' || element_p.css("opacity") == '0') {
                    return false;
                }

                // Not show if p tag and is empty.
                if (element_p.html() == '&nbsp;' && element_p.prop("tagName") == 'P') {
                    return false;
                }

                // Be sure this is visible on screen (For parent)
                if (yp_check_with_parents(element_p, "display", "none", "equal") == true || yp_check_with_parents(element_p, "visibility", "hidden", "equal") == true || yp_check_with_parents(element_p, "opacity", "0", "equal") == true) {
                    return false;
                }

                //Dynamic boxes variables
                var element_offset = element_p.offset();
                var topBoxes = element_offset.top;
                var leftBoxes = element_offset.left;
                var widthBoxes = element_p.outerWidth(false);
                var heightBoxes = element_p.outerHeight(false);
                var widthBoxesMargin = element_p.outerWidth(true);
                var heightBoxesMargin = element_p.outerHeight(true);

                var bottomBoxes = topBoxes + heightBoxes;

                if (heightBoxes > 1 && widthBoxes > 1) {

                    // Dynamic Box
                    if (iframe.find("." + classes + "-" + $i + "-top").length == 0) {
                        iframeBody.append("<div class='" + classes + "-top " + classes + "-" + $i + "-top'></div><div class='" + classes + "-bottom " + classes + "-" + $i + "-bottom'></div><div class='" + classes + "-left " + classes + "-" + $i + "-left'></div><div class='" + classes + "-right " + classes + "-" + $i + "-right'></div>");
                    }

                    // Dynamic Boxes position
                    iframe.find("." + classes + "-" + $i + "-top").css("top", topBoxes).css("left", leftBoxes).css("width", widthBoxes);
                    iframe.find("." + classes + "-" + $i + "-bottom").css("top", bottomBoxes).css("left", leftBoxes).css("width", widthBoxes);
                    iframe.find("." + classes + "-" + $i + "-left").css("top", topBoxes).css("left", leftBoxes).css("height", heightBoxes);
                    iframe.find("." + classes + "-" + $i + "-right").css("top", topBoxes).css("left", leftBoxes + widthBoxes).css("height", heightBoxes);

                }

            }

            /* ---------------------------------------------------- */
            /* Visible Height in scroll.                            */
            /* ---------------------------------------------------- */
            function yp_visible_height(t) {
                var top = t.offset().top;
                var windowHeight = iframe.height();
                var scrollTop = iframe.scrollTop();
                var height = t.outerHeight();

                if (top < scrollTop) {
                    return height - (scrollTop - top);
                } else {
                    return height;
                }

            }

            /* ---------------------------------------------------- */
            /* Draw Tooltip and borders.                            */
            /* ---------------------------------------------------- */
            function yp_draw_tooltip() {

                if (iframe.find(".yp-selected-tooltip").length <= 0) {
                    return false;
                }

                var tooltip = iframe.find(".yp-selected-tooltip");
                var tooltipMenu = iframe.find(".yp-edit-menu");

                // Hide until set position to tooltip if element still not selected.
                if (!body.hasClass("yp-content-selected")) {
                    tooltip.css("visibility", "hidden");
                    tooltipMenu.css("visibility", "hidden");
                }

                var element = iframe.find(".yp-selected");

                var element_offset = element.offset();

                if (element_offset == undefined) {
                    return false;
                }

                tooltip.removeClass("yp-tooltip-bottom-outside");

                var topElement = parseFloat(element_offset.top) - 24;

                var leftElement = parseFloat(element_offset.left);

                if (leftElement == 0) {
                    leftElement = parseFloat(iframe.find(".yp-selected-boxed-top").offset().left);
                }

                tooltip.css("top", topElement).css("left", leftElement);
                tooltipMenu.css("top", topElement).css("left", leftElement);

                // If outside of bottom, show.
                if (topElement >= ($(window).height() + iframe.scrollTop() - 24)) {

                    if (!tooltip.hasClass("yp-fixed-tooltip")) {
                        tooltip.addClass("yp-fixed-tooltip");
                    }

                    // Update
                    topElement = ($(window).height() + iframe.scrollTop() - 24);

                    tooltip.addClass("yp-fixed-tooltip-bottom");

                } else {

                    if (tooltip.hasClass("yp-fixed-tooltip")) {
                        tooltip.removeClass("yp-fixed-tooltip");
                    }

                    tooltip.removeClass("yp-fixed-tooltip-bottom");

                }

                // If out of top, show.
                if (topElement < 2 || topElement < (iframe.scrollTop() + 2)) {

                    var bottomBorder = iframe.find(".yp-selected-boxed-bottom");

                    topElement = parseFloat(bottomBorder.css("top")) - parseFloat(yp_visible_height(element));

                    tooltip.css("top", topElement);
                    tooltipMenu.css("top", topElement);

                    tooltip.addClass("yp-fixed-tooltip");

                    var tooltipRatio = (tooltip.outerHeight() * 100 / yp_visible_height(element));

                    if (tooltipRatio > 10) {
                        tooltip.addClass("yp-tooltip-bottom-outside");
                        topElement = parseFloat(bottomBorder.css("top")) - parseFloat(tooltip.outerHeight()) + tooltip.outerHeight();

                        tooltip.css("top", topElement);
                        tooltipMenu.css("top", topElement);

                    } else {
                        tooltip.removeClass("yp-tooltip-bottom-outside");
                    }

                } else {
                    tooltip.removeClass("yp-fixed-tooltip");
                }

                if (tooltipRatio < 11) {
                    tooltip.removeClass("yp-tooltip-bottom-outside");
                }

                if (tooltip.hasClass("yp-fixed-tooltip") == true && tooltip.hasClass("yp-tooltip-bottom-outside") == false) {
                    tooltipMenu.addClass("yp-fixed-edit-menu");
                } else {
                    tooltipMenu.removeClass("yp-fixed-edit-menu");
                }

                if (tooltip.hasClass("yp-tooltip-bottom-outside") == true) {
                    tooltipMenu.addClass("yp-bottom-outside-edit-menu");
                } else {
                    tooltipMenu.removeClass("yp-bottom-outside-edit-menu");
                }

                if (tooltip.hasClass("yp-fixed-tooltip-bottom")) {
                    tooltipMenu.addClass("yp-fixed-bottom-edit-menu");
                } else {
                    tooltipMenu.removeClass("yp-fixed-bottom-edit-menu");
                }

                tooltip.css("visibility", "visible");
                tooltipMenu.css("visibility", "visible");

                // Fix tooltip height problem.
                setTimeout(function() {

                    // auto height.
                    if (tooltip.css("visibility") != "hidden") {

                        // If high
                        if (tooltip.height() > 24) {

                            // simple tooltip.
                            tooltip.addClass("yp-small-tooltip");

                        } else { // If not high

                            // if already simple tooltip
                            if (tooltip.hasClass("yp-small-tooltip")) {

                                // return to default.
                                tooltip.removeClass("yp-small-tooltip");

                                // check again if need to be simple
                                if (tooltip.height() > 24) {

                                    // make it simple.
                                    tooltip.addClass("yp-small-tooltip");

                                }

                            }

                        }

                    }

                }, 2);

            }

            /* ---------------------------------------------------- */
            /* fix select2 bug.                                     */
            /* ---------------------------------------------------- */
            $("html").click(function(e) {

                if (e.target.nodeName == 'HTML' && $("body").hasClass("autocomplete-active") == false && $(".iris-picker:visible").length === 0) {
                    yp_clean();
                }

                if ($("body").hasClass("autocomplete-active") == true && e.target.nodeName == 'HTML') {

                    $(".input-autocomplete").each(function() {
                        $(this).autocomplete("close");
                    });

                }

            });

            // if mouseup on iframe, trigger for document.
            iframe.on("mouseup", iframe, function() {

                $(document).trigger("mouseup");

            });

            /* ---------------------------------------------------- */
            /* Get Handler                                          */
            /* ---------------------------------------------------- */
            function yp_get_handler() {

                // Element selected?
                if (!$("body").hasClass("yp-content-selected")) {
                    return false;
                }

                // element
                var element = iframe.find(".yp-selected");

                // If already have.
                if (iframe.find(".yp-selected-handle").length > 0) {
                    return false;
                }

                // If static, use relative.
                if (element.css("position") == 'static' && element.hasClass("ready-for-drag") == false) {
                    element.addClass("ready-for-drag");
                }

                // Clean ex
                iframe.find(".yp-selected-handle").remove();

                // Add new
                if (element.height() > 20 && element.width() > 60) {
                    iframeBody.append("<span class='yp-selected-handle'></span>");
                }

                iframe.find(".yp-selected-handle").css("left", iframe.find(".yp-selected-boxed-right").css("left"));
                iframe.find(".yp-selected-handle").css("top", iframe.find(".yp-selected-boxed-bottom").css("top"));

            }

            window.mouseisDown = false;
            window.styleAttrBeforeChange = null;
            window.visualResizingType = null;
            window.ResizeSelectedBorder = null;
            window.elementOffsetLeft = null;
            window.elementOffsetRight = null;

            function yp_get_host(url) {
                var domain;
                if (url.indexOf("://") > -1) {
                    domain = url.split('/')[2];
                } else {
                    domain = url.split('/')[0];
                }
                domain = domain.split(':')[0];
                return $.trim(domain);
            }

            iframe.find('a[href]').on("click", iframe, function(evt) {

                $(this).attr("target", "_self");

                // if aim mode disable.
                if ($(".yp-selector-mode.active").length == 0) {

                    var href = $(this).attr("href");

                    if (href == '') {
                        return false;
                    }

                    if (href.indexOf("#noAiming") > -1) {
                        alert("This link is not an wordpress page. You can't edit this page.");
                        return false;
                    }

                    if (href != null && href != '' && href.charAt(0) != '#' && href.indexOf("javascript:") == -1 && href.indexOf("yellow_pencil=true") == -1) {

                        var link_host = yp_get_host(href);
                        var main_host = window.location.hostname;

                        if (link_host != main_host) {
                            alert("This is external link. You can't edit this page.");
                            return false;
                        }

                        if (href.indexOf(siteurl.split("://")[1]) == -1) {
                            alert("This link is not an wordpress page. You can't edit this page.");
                            return false;
                        }

                        // https to http
                        if (location.protocol == 'http:' && href.indexOf('https:') != -1 && href.indexOf('http:') == -1) {
                            href = href.replace("https:", "http:");
                            $(this).attr("href", href);
                        }

                        // Http to https
                        if (location.protocol == 'https:' && href.indexOf('http:') != -1 && href.indexOf('https:') == -1) {
                            href = href.replace("http:", "https:");
                            $(this).attr("href", href);
                        }

                        // if selector mode not active and need to save.
                        if ($(".yp-save-btn").hasClass("waiting-for-save") == true) {
                            if (confirm(l18_sure) == true) {
                                $(".waiting-for-save").removeClass("waiting-for-save");
                            } else {
                                return false;
                            }
                        }

                    } else {
                        return false;
                    }

                    $("body").hide();

                    // Get parent url
                    var parentURL = window.location;

                    //delete after href.
                    parentURL = parentURL.toString().split("href=")[0] + "href=";

                    // get iframe url
                    var newURL = href;
                    if (newURL.substring(0, 6) == 'about:') {
                        $(this).show();
                        return false;
                    }

                    newURL = newURL.replace(/.*?:\/\//g, ""); // delete protocol

                    newURL = newURL.replace("&yellow_pencil_frame=true", "").replace("?yellow_pencil_frame=true", "");

                    newURL = encodeURIComponent(newURL); // encode url

                    parentURL = parentURL + newURL; // update parent URL

                    window.location = parentURL;

                }

            });

            /* ---------------------------------------------------- */
            /* Cancel Selected El. And Select The Element Function  */
            /* ---------------------------------------------------- */
            iframe.on("click", iframe, function(evt) {

                if ($(".yp-selector-mode.active").length > 0 && $("body").hasClass("yp-metric-disable") == true) {

                    if (evt.which == 1 || evt.which == undefined) {
                        evt.stopPropagation();
                        evt.preventDefault();
                    }

                    // Resized
                    if (body.hasClass("yp-element-resized")) {
                        body.removeClass("yp-element-resized");
                        return false;
                    }

                    // Colorpicker for all elements.
                    if ($("body").hasClass("yp-element-picker-active")) {
                        $(".yp-element-picker-active").removeClass("yp-element-picker-active");
                        $(".yp-element-picker.active").removeClass("active");
                        return false;
                    }

                    if ($(".yp_flat_colors_area:visible").length != 0) {

                        $(".yp-flat-colors.active").each(function() {
                            $(this).trigger("click");
                        });

                        return false;

                    }

                    if ($(".yp_meterial_colors_area:visible").length != 0) {

                        $(".yp-meterial-colors.active").each(function() {
                            $(this).trigger("click");
                        });

                        return false;

                    }

                    if ($(".yp_nice_colors_area:visible").length != 0) {

                        $(".yp-nice-colors.active").each(function() {
                            $(this).trigger("click");
                        });

                        return false;

                    }

                    if ($(".iris-picker:visible").length != 0) {

                        $(".iris-picker:visible").each(function() {
                            $(this).hide();
                        });

                        return false;

                    }

                    if ($(".yp_background_assets:visible").length != 0) {

                        $(".yp-bg-img-btn.active").each(function() {
                            $(this).trigger("click");
                        });

                        return false;

                    }

                    if ($("body").hasClass("autocomplete-active") == true) {

                        $(".input-autocomplete").each(function() {
                            $(this).autocomplete("close");
                        });

                        return false;

                    }

                    if ($("body").hasClass("yp-content-selected") == true) {

                        // CSS To Data.
                        if (body.hasClass("yp-need-to-process") == true) {
                            yp_process(false, false);
                            return false;
                        }

                        if (iframe.find(".context-menu-active").length > 0) {
                            iframe.find(".yp-selected").contextMenu("hide");
                            return false;
                        }

                    }

                    var element = $(evt.target);

                    if (evt.which == undefined || evt.which == 1) {

                        if (body.hasClass("yp-content-selected") == true) {

                            if (element.hasClass("yp-edit-menu") == true && element.hasClass("yp-content-selected") == false) {
                                var element_offset = element.offset();
                                var x = element_offset.left;
                                if (x == 0) {
                                    x = 1;
                                }
                                var y = element_offset.top + 26;
                                iframe.find(".yp-selected").contextMenu({
                                    x: x,
                                    y: y
                                });
                                return false;
                            }

                            if (element.hasClass("yp-selected-tooltip") == true) {
                                $(".yp-button-target").trigger("click");
                                return false;
                            } else if (element.parent().length > 0) {
                                if (element.parent().hasClass("yp-selected-tooltip")) {
                                    $(".yp-button-target").trigger("click");
                                    return false;
                                }
                            }

                        }

                    }

                    if (body.hasClass("yp-selector-disabled")) {
                        return false;
                    }

                    if (body.hasClass("yp-disable-disable-yp")) {
                        return false;
                    }

                    var selector = yp_get_parents(element, "default");

                    if ($("body").hasClass("autocomplete-active") == true && selector == 'body') {
                        return false;
                    }

                    if (evt.which == 1 || evt.which == undefined) {

                        if (element.hasClass("yp-selected") == false) {

                            if (body.hasClass("yp-content-selected") == true && element.parents(".yp-selected").length != 1) {

                                if ($("body").hasClass("yp-anim-creator")) {
                                    if (!confirm(l18_closeAnim)) {
                                        return false;
                                    } else {
                                        yp_anim_cancel();
                                        return false;
                                    }
                                }

                                // remove ex
                                yp_clean();

                                // Quick update
                                iframe.find(evt.target).trigger("mouseover");

                            }

                        } else {

                            if (body.hasClass("yp-content-selected") == false) {

                                if (yp_check_with_parents(element, "transform", "none", "notequal") == true && yp_check_with_parents(element, "transform", "inherit", "notequal") == true && yp_check_with_parents(element, "transform", "", "notequal") == true) {
                                    body.addClass("yp-has-transform");
                                }

                                // Set selector as  body attr.
                                body.attr("data-clickable-select", selector);

                                // Add drag support
                                if (iframe.find(".yp-selected").length > 0 && selector != 'body' && selector != 'html') {

                                    element.draggable({

                                        containment: iframeBody,
                                        delay: 100,
                                        start: function() {

                                            if (body.hasClass("yp-css-editor-active")) {
                                                $(".css-editor-btn").trigger("click");
                                            }

                                            if (!body.hasClass("yp-content-selected")) {
                                                return false;
                                            }

                                            // Close contextmenu
                                            if (iframe.find(".context-menu-active").length > 0) {
                                                iframe.find(".yp-selected").contextMenu("hide");
                                            }

                                            iframe.find(".yp-selected").removeClass("yp_onscreen yp_hover yp_click yp_focus");

                                            // Get Element Style attr.
                                            window.styleAttr = element.attr("style");

                                            // Remove static fixer class & Hide.
                                            element.removeClass("ready-for-drag").css("visibility", "hidden");

                                            // Wait 2ms
                                            setTimeout(function() {

                                                // Get element style.
                                                window.stylePositionType = element.css("position");

                                                // If static element, add ready-for-drag class.
                                                if (window.stylePositionType == 'static') {
                                                    element.addClass("ready-for-drag");
                                                }

                                                // Show now.
                                                element.css("visibility", "visible");

                                            }, 2);

                                            // Add some classes
                                            body.addClass("yp-clean-look yp-dragging yp-hide-borders-now");

                                        },
                                        stop: function() {

                                            window.styleData = 'relative';

                                            var delay = 1;

                                            // CSS To Data.
                                            if (body.hasClass("yp-need-to-process") == true) {
                                                yp_process(false, false);
                                                delay = 70;
                                            }

                                            // Draw tooltip qiuckly
                                            yp_draw_tooltip();

                                            // Wait for process.
                                            setTimeout(function() {

                                                // Insert new data.
                                                yp_insert_rule(yp_get_current_selector(), "top", element.css("top"), '');
                                                yp_insert_rule(yp_get_current_selector(), "left", element.css("left"), '');

                                                if (parseFloat(element.css("top")) + parseFloat(element.css("bottom")) != 0) {
                                                    yp_insert_rule(yp_get_current_selector(), "bottom", "auto", '');
                                                }

                                                if (parseFloat(element.css("left")) + parseFloat(element.css("right")) != 0) {
                                                    yp_insert_rule(yp_get_current_selector(), "right", "auto", '');
                                                }

                                                if (element.attr("style").indexOf("relative") != -1 && window.stylePositionType != 'fixed' && window.stylePositionType != 'absolute') {
                                                    window.stylePositionType = 'static';
                                                }

                                                if ($("#position-static").parent().hasClass("active")) {
                                                    $("#position-relative").trigger("click");
                                                }

                                                // Set default values for top and left options.
                                                if ($("li.position-option.active").length > 0) {
                                                    $("#top-group,#left-group").each(function() {
                                                        yp_set_default(".yp-selected", yp_id_hammer(this), false);
                                                    });
                                                } else {
                                                    $("li.position-option").removeAttr("data-loaded"); // delete cached data.
                                                }

                                                // Back To Orginal Style Attr.
                                                if (typeof window.styleAttr !== typeof undefined && window.styleAttr !== false) {
                                                    element.attr("style", window.styleAttr);
                                                } else {
                                                    element.removeAttr("style");
                                                }

                                                // Remove
                                                iframe.find(".yp-selected,.yp-selected-others").removeClass("ui-draggable ui-draggable-handle ui-draggable-handle");

                                                // Adding styles
                                                if (window.stylePositionType == 'static') {
                                                    yp_insert_rule(yp_get_current_selector(), "position", "relative", '');
                                                } else if (element.hasClass("ready-for-drag") == true) {
                                                    yp_insert_rule(yp_get_current_selector(), "position", "relative", '');
                                                }

                                                // Remove Class.
                                                element.removeClass("ready-for-drag");

                                                // Update css.
                                                yp_option_change();

                                                body.removeClass("yp-clean-look yp-dragging yp-hide-borders-now");

                                                yp_draw();

                                                yp_resize();

                                            }, delay);

                                        }

                                    });

                                }

                                // RESIZE ELEMENTS
                                window.visualResizingType = 'width';
                                window.ResizeSelectedBorder = "right";
                                window.styleAttrBeforeChange = element.attr("style");

                                var element_offset = element.offset();
                                window.elementOffsetLeft = element_offset.left;
                                window.elementOffsetRight = element_offset.right;

                                element.width(parseFloat(element.width() + 10));

                                if (window.elementOffsetLeft == element_offset.left && window.elementOffsetRight != element_offset.right) {

                                    window.ResizeSelectedBorder = "right";

                                } else if (window.elementOffsetLeft != element_offset.left && window.elementOffsetRight == element_offset.right && element.css("text-align") != 'center') {
                                    window.ResizeSelectedBorder = "left";
                                    body.addClass("yp-left-selected-resizeable");
                                } else {
                                    window.ResizeSelectedBorder = "right";
                                }

                                if (typeof window.styleAttrBeforeChange !== typeof undefined && window.styleAttrBeforeChange !== false) {
                                    element.attr("style", window.styleAttrBeforeChange);
                                } else {
                                    element.removeAttr("style");
                                    window.styleAttrBeforeChange = null;
                                }

                                // element selected
                                body.addClass("yp-content-selected");
                                yp_toggle_hide(true); // show if hide

                                // Disable focus style after clicked.
                                element.blur();

                            }

                        }

                    } else {

                        var hrefAttr = $(evt.target).attr("href");

                        // If has href
                        if (typeof hrefAttr !== typeof undefined && hrefAttr !== false) {

                            if (evt.which == 1 || evt.which == undefined) {
                                evt.stopPropagation();
                                evt.preventDefault();
                            }

                            return false;

                        }

                    }

                    yp_draw();
                    yp_resize();

                }

            });

            // Width Change visual.
            iframe.on("mousedown", '.yp-selected-boxed-left,.yp-selected-boxed-right', function() {

                if (body.hasClass("yp-content-selected") == false) {
                    return false;
                }

                if ($(this).hasClass(".yp-selected-boxed-left") && window.ResizeSelectedBorder == 'right') {
                    return false;
                }

                window.visualResizingType = 'width';

                if (body.hasClass("yp-left-selected-resizeable")) {
                    window.ResizeSelectedBorder = "left";
                } else {
                    window.ResizeSelectedBorder = "right";
                }

                window.mouseisDown = true;

                body.addClass("yp-element-resizing");

                // Close contextmenu
                if (iframe.find(".context-menu-active").length > 0) {
                    iframe.find(".yp-selected").contextMenu("hide");
                }

            });

            // Height Change visual.
            iframe.on("mousedown", '.yp-selected-boxed-bottom', function() {

                if (body.hasClass("yp-content-selected") == false) {
                    return false;
                }

                // Update variables
                window.mouseisDown = true;

                window.visualResizingType = 'height';
                window.ResizeSelectedBorder = "bottom";

                body.addClass("yp-element-resizing");

                // Close contextmenu
                if (iframe.find(".context-menu-active").length > 0) {
                    iframe.find(".yp-selected").contextMenu("hide");
                }

                // Removing classes.
                iframe.find(yp_get_current_selector()).removeClass("yp_selected").removeClass("yp_onscreen").removeClass("yp_hover").removeClass("yp_focus").removeClass("yp_click");
            });

            // Visual resizer
            iframe.on("mousemove", iframe, function(event) {

                // Show border on iframe mousemove
                if (body.hasClass("yp-selectors-hide") == true && $(".wqNoUi-active").length == 0 && $("body").hasClass("autocomplete-active") == false && $(".yp-select-bar .tooltip").length == 0) {

                    body.removeClass("yp-selectors-hide");

                    yp_show_selects_with_animation();

                }

                // Record mousemoves after element selected.
                window.lastTarget = event.target;

                if (window.mouseisDown == true) {

                    event = event || window.event;

                    // cache
                    var element = iframe.find(".yp-selected");

                    // Convert display inline to inline-block.
                    if (element.css("display") == 'inline') {
                        yp_insert_rule(yp_get_current_selector(), "display", "inline-block", "");
                    }

                    // If width
                    if (window.visualResizingType == "width") {

                        if (window.ResizeSelectedBorder == 'right') {
                            var otherPos = 'left';
                            var width = parseFloat(event.pageX) - parseFloat(iframe.find(".yp-selected-boxed-" + otherPos).css("left"));
                        } else {
                            var otherPos = 'right';
                            var width = parseFloat(iframe.find(".yp-selected-boxed-" + otherPos).css("left")) - parseFloat(event.pageX);
                        }

                        // Min 4px
                        if (width > 4) {

                            if (element.css("box-sizing") == 'content-box') {
                                width = width - parseFloat(element.css("padding-left")) - parseFloat(element.css("padding-right"));
                            }

                            element.cssImportant("width", width + "px");

                            yp_draw();

                        }

                        body.addClass("yp-element-resizing-width-" + window.ResizeSelectedBorder);

                    } else if (window.visualResizingType == "height") { // else height

                        if (window.ResizeSelectedBorder == 'top') {
                            var otherPos = 'bottom';
                        } else {
                            var otherPos = 'top';
                        }

                        // Total width
                        var height = parseFloat(event.pageY) - parseFloat(element.offset().top);

                        // Min 4px
                        if (height > 4) {

                            if (element.css("box-sizing") == 'content-box') {
                                height = height - parseFloat(element.css("padding-top")) - parseFloat(element.css("padding-bottom"));
                            }

                            element.cssImportant("height", height + "px");

                            yp_draw();

                        }

                        body.addClass("yp-element-resizing-height-" + window.ResizeSelectedBorder);

                    }

                }

            });

            // End visual resizer now
            iframe.on("mouseup", iframe, function() {

                if (body.hasClass("yp-element-resizing")) {

                    body.addClass("yp-element-resized");

                    var delay = 1;

                    // CSS To Data.
                    if (body.hasClass("yp-need-to-process") == true) {
                        yp_process(false, false);
                        delay = 70;
                    }

                    // Wait for process.
                    setTimeout(function() {

                        // cache
                        var element = iframe.find(".yp-selected");

                        // get result
                        var width = parseFloat(element.css(window.visualResizingType)).toString();
                        var format = 'px';

                        // width 100% for screen
                        if (window.visualResizingType == 'width') {
                            if (parseFloat(width) + parseFloat(1) == $(window).width() || parseFloat(width) + parseFloat(1) + parseFloat(element.css("padding-left")) + parseFloat(element.css("padding-right")) == $(window).width()) {
                                width = "100";
                                format = '%';
                            }
                        }

                        //return to default
                        if (typeof window.styleAttrBeforeChange !== typeof undefined || window.styleAttrBeforeChange !== false) {
                            element.attr("style", window.styleAttrBeforeChange);
                        } else {
                            element.removeAttr("style");
                        }

                        // insert to data.
                        yp_insert_rule(yp_get_current_selector(), window.visualResizingType, width, format);

                        // Update
                        yp_option_change();

                        // Set default values for top and left options.
                        if ($("li.size-option.active").length > 0) {

                            if (body.hasClass("yp-element-resizing-height-bottom")) {
                                yp_set_default(".yp-selected", yp_id_hammer($("#height-group")), false);
                            } else {
                                yp_set_default(".yp-selected", yp_id_hammer($("#width-group")), false);
                            }

                        } else {
                            $("li.size-option").removeAttr("data-loaded"); // delete cached data.
                        }

                        setTimeout(function() {

                            yp_draw();

                            body.removeClass("yp-element-resizing").removeClass("yp-element-resizing-height-bottom").removeClass("yp-element-resizing-width-left").removeClass("yp-element-resizing-width-right");

                        }, 5);

                        window.mouseisDown = false;

                    }, delay);

                    setTimeout(function() {
                        body.removeClass("yp-element-resized");
                    }, 100);

                }

            });

            // Load default value after setting pane hover
            // because I not want load ":hover" values.
            body.on('mousedown', '.yp-editor-list > li:not(.yp-li-footer):not(.yp-li-about):not(.active)', function() {

                if (body.hasClass("yp-content-selected") == true) {

                    // Get data
                    var data = $(this).attr("data-loaded");

                    // If no data, so set.
                    if (typeof data == typeof undefined || data == false) {

                        // Set default values
                        $(this).find(".yp-option-group").each(function() {
                            yp_set_default(".yp-selected", yp_id_hammer(this), false);
                        });

                        // cache to loaded data.
                        $(this).attr("data-loaded", "true");

                    }

                }

            });

            // Update boxes while mouse over and out selected elements.
            iframe.on("mouseout mouseover", '.yp-selected,.yp-selected-others', function() {

                if (body.hasClass("yp-content-selected")) {
                    setTimeout(function() {
                        yp_draw();
                    }, 5);
                }

            });

            /* ---------------------------------------------------- */
            /* Option None / Disable Buttons                        */
            /* ---------------------------------------------------- */
            /*
                  none and disable button api.
            */
            $(".yp-btn-action").click(function(e) {

                var elementPP = $(this).parent().parent().parent();

                // inherit, none etc.
                if ($(this).hasClass("yp-none-btn")) {

                    if (elementPP.find(".yp-disable-btn.active").length >= 0) {
                        elementPP.find(".yp-disable-btn.active").trigger("click");

                        if (e.originalEvent) {
                            elementPP.addClass("eye-enable");
                        }

                    }

                    var prefix = '';

                    // If slider
                    if (elementPP.hasClass("yp-slider-option")) {

                        var id = elementPP.attr("id").replace("-group", "");

                        if ($(this).hasClass("active")) {

                            $(this).removeClass("active");

                            // Show
                            elementPP.find(".yp-after").show();

                            // Is Enable
                            elementPP.find(".yp-after-disable").hide();

                            // Value
                            var value = $("#yp-" + id).val();
                            var prefix = $("#" + id + "-after").val();

                        } else {

                            $(this).addClass("active");

                            // Hide
                            elementPP.find(".yp-after").hide();

                            // Is Disable
                            elementPP.find(".yp-after-disable").show();

                            // Value
                            var value = elementPP.find(".yp-none-btn").text();

                        }

                        // If is radio
                    } else if (elementPP.find(".yp-radio-content").length > 0) {

                        var id = elementPP.attr("id").replace("-group", "");

                        if ($(this).hasClass("active")) {

                            $(this).removeClass("active");

                            // Value
                            var value = $("input[name=" + id + "]:checked").val();

                            $("input[name=" + id + "]:checked").parent().addClass("active");

                        } else {

                            $(this).addClass("active");

                            elementPP.find(".yp-radio.active").removeClass("active");

                            // Value
                            var value = elementPP.find(".yp-none-btn").text();

                        }

                        // If is select
                    } else if (elementPP.find("select").length > 0) {

                        var id = elementPP.attr("id").replace("-group", "");

                        if ($(this).hasClass("active")) {

                            $(this).removeClass("active");

                            // Is Enable
                            elementPP.find(".yp-after-disable").hide();

                            // Value
                            var value = $("#yp-" + id).val();

                        } else {

                            $(this).addClass("active");

                            // Is Enable
                            elementPP.find(".yp-after-disable").show();

                            // Value
                            var value = elementPP.find(".yp-none-btn").text();

                        }

                    } else {

                        var id = elementPP.attr("id").replace("-group", "");

                        if ($(this).hasClass("active")) {

                            $(this).removeClass("active");

                            // Is Disable
                            elementPP.find(".yp-after-disable").hide();

                            // Value
                            var value = $("#yp-" + id).val();

                        } else {

                            $(this).addClass("active");

                            // Is Enable
                            elementPP.find(".yp-after-disable").show();

                            // Value
                            var value = 'transparent';

                        }

                    }

                    var selector = yp_get_current_selector();
                    var css = $("#" + id + "-group").data("css");

                    if (id == 'background-image') {

                        if (value.indexOf("//") != -1) {
                            value = "url(" + value + ")";
                        }

                        if (value == 'transparent') {
                            value = 'none';
                        }

                    }

                    if (e.originalEvent) {

                        yp_insert_rule(selector, id, value, prefix);
                        yp_option_change();

                    } else if (id == 'background-repeat' || id == 'background-size') {

                        if ($(".yp_background_assets:visible").length > 0) {
                            yp_insert_rule(selector, id, value, prefix);
                            yp_option_change();
                        }

                    }

                } else { // disable this option

                    // Prefix.
                    var prefix = '';

                    // If slider
                    if (elementPP.hasClass("yp-slider-option")) {

                        var id = elementPP.attr("id").replace("-group", "");

                        if ($(this).hasClass("active")) {

                            $(this).removeClass("active");
                            elementPP.css("opacity", 1);

                            // Show
                            elementPP.find(".yp-after").show();

                            // Is Enable
                            elementPP.find(".yp-after-disable-disable").hide();

                            // Value
                            if (!elementPP.find(".yp-none-btn").hasClass("active")) {
                                var value = $("#yp-" + id).val();
                                var prefix = $("#" + id + "-after").val();
                            } else {
                                var value = elementPP.find(".yp-none-btn").text();
                            }

                        } else {

                            $(this).addClass("active");
                            elementPP.css("opacity", 0.5);

                            // Hide
                            elementPP.find(".yp-after").hide();

                            // Is Disable
                            elementPP.find(".yp-after-disable-disable").show();

                            // Value
                            var value = 'disable';

                        }

                        // If is radio
                    } else if (elementPP.find(".yp-radio-content").length > 0) {

                        var id = elementPP.attr("id").replace("-group", "");

                        if ($(this).hasClass("active")) {

                            $(this).removeClass("active");
                            elementPP.css("opacity", 1);

                            // Value
                            if (!elementPP.find(".yp-none-btn").hasClass("active")) {
                                var value = $("input[name=" + id + "]:checked").val();
                            } else {
                                var value = elementPP.find(".yp-none-btn").text();
                            }

                        } else {

                            $(this).addClass("active");
                            elementPP.css("opacity", 0.5);

                            // Value
                            var value = 'disable';

                        }

                        // If is select
                    } else if (elementPP.find("select").length > 0) {

                        var id = elementPP.attr("id").replace("-group", "");

                        if ($(this).hasClass("active")) {

                            $(this).removeClass("active");
                            elementPP.css("opacity", 1);

                            // Is Enable
                            elementPP.find(".yp-after-disable-disable").hide();

                            // Value
                            if (!elementPP.find(".yp-none-btn").hasClass("active")) {
                                var value = $("#yp-" + id).val();
                            } else {
                                var value = elementPP.find(".yp-none-btn").text();
                            }

                        } else {

                            $(this).addClass("active");
                            elementPP.css("opacity", 0.5);

                            // Is Enable
                            elementPP.find(".yp-after-disable-disable").show();

                            // Value
                            var value = 'disable';

                        }

                    } else {

                        var id = elementPP.attr("id").replace("-group", "");

                        if ($(this).hasClass("active")) {

                            $(this).removeClass("active");
                            elementPP.css("opacity", 1);

                            // Is Disable
                            elementPP.find(".yp-after-disable-disable").hide();

                            // Value
                            if (!elementPP.find(".yp-none-btn").hasClass("active")) {
                                var value = $("#yp-" + id).val();
                            } else {
                                var value = elementPP.find(".yp-none-btn").text();
                            }

                        } else {

                            $(this).addClass("active");
                            elementPP.css("opacity", 0.5);

                            // Is Enable
                            elementPP.find(".yp-after-disable-disable").show();

                            // Value
                            var value = 'disable';

                        }

                        if (id == 'background-image') {

                            if (value.indexOf("//") != -1) {
                                value = "url(" + value + ")";
                            }

                            if (value == 'transparent') {
                                value = 'none';
                            }

                        }

                    }

                    var selector = yp_get_current_selector();
                    var css = $("#" + id + "-group").data("css");

                    if (e.originalEvent) {

                        yp_insert_rule(selector, id, value, prefix);

                    }

                    yp_draw();

                    if (e.originalEvent) {
                        yp_option_change();
                    }

                }

                yp_resize();

            });

            /* ---------------------------------------------------- */
            /* Collapse List                                        */
            /* ---------------------------------------------------- */
            $(".yp-editor-list > li > h3").click(function() {

                if ($(this).parent().hasClass("yp-li-about") || $(this).parent().hasClass("yp-li-footer")) {
                    return '';
                }

                $(this).parent().addClass("current");

                // Disable.
                $(".yp-editor-list > li.active:not(.current)").each(function() {

                    $(".yp-editor-list > li").show(0);
                    $(this).find(".yp-this-content").hide(0).parent().removeClass("active");

                });

                if ($(this).parent().hasClass("active")) {
                    $(this).parent().removeClass("active");
                } else {
                    $(this).parent().addClass("active");
                    $(".yp-editor-list > li:not(.active)").hide(0);
                }

                $(this).parent().find(".yp-this-content").toggle(0);
                $(this).parent().removeClass("current");

                if ($(".yp-close-btn.dashicons-menu").length > 0) {
                    $(".yp-close-btn").removeClass("dashicons-menu").addClass("dashicons-no-alt");
                    $(".yp-close-btn").tooltip('hide').attr('data-original-title', l18_close_editor).tooltip('fixTitle');
                }

                if ($(".yp-editor-list > li.active:not(.yp-li-about):not(.yp-li-footer) > h3").length > 0) {
                    $(".yp-close-btn").removeClass("dashicons-no-alt").addClass("dashicons-menu");
                    $(".yp-close-btn").tooltip('hide').attr('data-original-title', l18_back_to_menu).tooltip('fixTitle');

                }

                $('.yp-editor-list').scrollTop(0);

                yp_resize();

            });

            /* ---------------------------------------------------- */
            /* Filters                                              */
            /* ---------------------------------------------------- */
            function yp_num(a) {
                if (typeof a !== "undefined" && a != '') {
                    if (a.replace(/[^\d.-]/g, '') === null || a.replace(/[^\d.-]/g, '') === undefined) {
                        return 0;
                    } else {
                        return a.replace(/[^\d.-]/g, '');
                    }
                } else {
                    return 0;
                }
            }

            function yp_alfa(a) {
                if (typeof a !== "undefined" && a != '') {
                    return a.replace(/\d/g, '').replace(".px", "px");
                } else {
                    return '';
                }
            }

            var yp_id = function(str) {
                if (typeof str !== "undefined" && str != '') {
                    str = str.replace(/\W+/g, "");
                    return str;
                } else {
                    return '';
                }
            }

            function yp_cleanArray(actual) {

                var uniqueArray = [];
                $.each(actual, function(i, el) {
                    if ($.inArray(el, uniqueArray) === -1) uniqueArray.push(el);
                });

                return uniqueArray;

            }

            /* ---------------------------------------------------- */
            /* Info About class or tagName                          */
            /* ---------------------------------------------------- */
            function yp_tag_info(a, selector) {

                if (selector.split(":").length > 0) {
                    selector = selector.split(":")[0];
                }

                // length
                var length = selector.split(window.separator).length - 1;

                // Names
                var n = selector.split(window.separator)[length].toUpperCase();
                if (n.indexOf(".") != -1) {
                    n = n.split(".")[1].replace(/[^\w\s]/gi, '');
                }

                // Class Names
                var className = $.trim(selector.split(window.separator)[length]);
                if (className.indexOf(".") != -1) {
                    className = className.split(".")[1];
                }

                // ID
                var id = iframe.find(".yp-selected").attr("id");

                if (typeof id !== typeof undefined && id !== false) {
                    id = id.toUpperCase().replace(/[^\w\s]/gi, '');
                }

                // Parents 1
                if (length > 1) {
                    var Pname = selector.split(window.separator)[length - 1].toUpperCase();
                    if (Pname.indexOf(".") != -1) {
                        Pname = Pname.split(".")[1].replace(/[^\w\s]/gi, '');
                    }
                } else {
                    var Pname = '';
                }

                // Parents 2
                if (length > 2) {
                    var Pname = selector.split(window.separator)[length - 2].toUpperCase();
                    if (Pname.indexOf(".") != -1) {
                        Pname = Pname.split(".")[1].replace(/[^\w\s]/gi, '');
                    }
                } else {
                    var PPname = '';
                }

                // ID
                if (id == 'TOPBAR') {
                    return l18_topbar;
                } else if (id == 'HEADER') {
                    return l18_header;
                } else if (id == 'FOOTER') {
                    return l18_footer;
                } else if (id == 'CONTENT') {
                    return l18_content;
                }

                // Parrents Class
                if (PPname == 'LOGO' || PPname == 'SITETITLE' || Pname == 'LOGO' || Pname == 'SITETITLE') {
                    return l18_logo;
                } else if (n == 'MAPCANVAS') {
                    return l18_google_map;
                } else if (Pname == 'ENTRYTITLE' && a == 'A') {
                    return l18_entry_title_link;
                } else if (Pname == 'CATLINKS' && a == 'A') {
                    return l18_category_link;
                } else if (Pname == 'TAGSLINKS' && a == 'A') {
                    return l18_tag_link;
                }

                // Current Classes
                if (n == 'WIDGET') {
                    return l18_widget;
                } else if (n == 'FA' || selector.split(window.separator)[length].toUpperCase().indexOf("FA-") >= 0) {
                    return l18_font_awesome_icon;
                } else if (n == 'SUBMIT' && a == 'INPUT') {
                    return l18_submit_button;
                } else if (n == 'MENUITEM') {
                    return l18_menu_item;
                } else if (n == 'ENTRYMETA' || n == 'ENTRYMETABOX' || n == 'POSTMETABOX') {
                    return l18_post_meta_division;
                } else if (n == 'COMMENTREPLYTITLE') {
                    return l18_comment_reply_title;
                } else if (n == 'LOGGEDINAS') {
                    return l18_login_info;
                } else if (n == 'FORMALLOWEDTAGS') {
                    return l18_allowed_tags;
                } else if (n == 'LOGO') {
                    return l18_logo;
                } else if (n == 'ENTRYTITLE' || n == 'POSTTITLE') {
                    return l18_post_title;
                } else if (n == 'COMMENTFORM') {
                    return l18_comment_form;
                } else if (n == 'WIDGETTITLE') {
                    return l18_widget_title;
                } else if (n == 'TAGCLOUD') {
                    return l18_tag_cloud;
                } else if (n == 'ROW' || n == 'VCROW') {
                    return l18_row;
                } else if (n == 'BUTTON') {
                    return l18_button;
                } else if (n == 'BTN') {
                    return l18_button;
                } else if (n == 'LEAD') {
                    return l18_lead;
                } else if (n == 'WELL') {
                    return l18_well;
                } else if (n == 'ACCORDIONTOGGLE') {
                    return l18_accordion_toggle;
                } else if (n == 'PANELBODY') {
                    return l18_accordion_content;
                } else if (n == 'ALERT') {
                    return l18_alert_division;
                } else if (n == 'FOOTERCONTENT') {
                    return l18_footer_content;
                } else if (n == 'GLOBALSECTION' || n == 'VCSSECTION') {
                    return l18_global_section;
                } else if (n == 'MORELINK') {
                    return l18_show_more_link;
                } else if (n == 'CONTAINER' || n == 'WRAPPER') {
                    return l18_wrapper;
                } else if (n == 'DEFAULTTITLE') {
                    return l18_article_title;
                } else if (n == 'MENULINK' || n == 'MENUICON' || n == 'MENUBTN' || n == 'MENUBUTTON') {
                    return l18_menu_link;
                } else if (n == 'SUBMENU') {
                    return l18_submenu;

                    // Bootstrap Columns
                } else if (n.indexOf('COLMD1') != -1 || n == 'MEDIUM1' || n == 'LARGE1' || n == 'SMALL1') {
                    return l18_column + ' 1/12';
                } else if (n.indexOf('COLMD2') != -1 || n == 'MEDIUM2' || n == 'LARGE2' || n == 'SMALL2') {
                    return l18_column + ' 2/12';
                } else if (n.indexOf('COLMD3') != -1 || n == 'MEDIUM3' || n == 'LARGE3' || n == 'SMALL3') {
                    return l18_column + ' 3/12';
                } else if (n.indexOf('COLMD4') != -1 || n == 'MEDIUM4' || n == 'LARGE4' || n == 'SMALL4') {
                    return l18_column + ' 4/12';
                } else if (n.indexOf('COLMD5') != -1 || n == 'MEDIUM5' || n == 'LARGE5' || n == 'SMALL5') {
                    return l18_column + ' 5/12';
                } else if (n.indexOf('COLMD6') != -1 || n == 'MEDIUM6' || n == 'LARGE6' || n == 'SMALL6') {
                    return l18_column + ' 6/12';
                } else if (n.indexOf('COLMD7') != -1 || n == 'MEDIUM7' || n == 'LARGE7' || n == 'SMALL7') {
                    return l18_column + ' 7/12';
                } else if (n.indexOf('COLMD8') != -1 || n == 'MEDIUM8' || n == 'LARGE8' || n == 'SMALL8') {
                    return l18_column + ' 8/12';
                } else if (n.indexOf('COLMD9') != -1 || n == 'MEDIUM9' || n == 'LARGE9' || n == 'SMALL9') {
                    return l18_column + ' 9/12';
                } else if (n.indexOf('COLMD10') != -1 || n == 'MEDIUM10' || n == 'LARGE10' || n == 'SMALL10') {
                    return l18_column + ' 10/12';
                } else if (n.indexOf('COLMD11') != -1 || n == 'MEDIUM11' || n == 'LARGE11' || n == 'SMALL11') {
                    return l18_column + ' 11/12';
                } else if (n.indexOf('COLMD12') != -1 || n == 'MEDIUM12' || n == 'LARGE12' || n == 'SMALL12') {
                    return l18_column + ' 12/12';
                } else if (n.indexOf('COLXS1') != -1) {
                    return l18_column + ' 1/12';
                } else if (n.indexOf('COLXS2') != -1) {
                    return l18_column + ' 2/12';
                } else if (n.indexOf('COLXS3') != -1) {
                    return l18_column + ' 3/12';
                } else if (n.indexOf('COLXS4') != -1) {
                    return l18_column + ' 4/12';
                } else if (n.indexOf('COLXS5') != -1) {
                    return l18_column + ' 5/12';
                } else if (n.indexOf('COLXS6') != -1) {
                    return l18_column + ' 6/12';
                } else if (n.indexOf('COLXS7') != -1) {
                    return l18_column + ' 7/12';
                } else if (n.indexOf('COLXS8') != -1) {
                    return l18_column + ' 8/12';
                } else if (n.indexOf('COLXS9') != -1) {
                    return l18_column + ' 9/12';
                } else if (n.indexOf('COLXS10') != -1) {
                    return l18_column + ' 10/12';
                } else if (n.indexOf('COLXS11') != -1) {
                    return l18_column + ' 11/12';
                } else if (n.indexOf('COLXS12') != -1) {
                    return l18_column + ' 12/12';
                } else if (n.indexOf('COLSM1') != -1) {
                    return l18_column + ' 1/12';
                } else if (n.indexOf('COLSM2') != -1) {
                    return l18_column + ' 2/12';
                } else if (n.indexOf('COLSM3') != -1) {
                    return l18_column + ' 3/12';
                } else if (n.indexOf('COLSM4') != -1) {
                    return l18_column + ' 4/12';
                } else if (n.indexOf('COLSM5') != -1) {
                    return l18_column + ' 5/12';
                } else if (n.indexOf('COLSM6') != -1) {
                    return l18_column + ' 6/12';
                } else if (n.indexOf('COLSM7') != -1) {
                    return l18_column + ' 7/12';
                } else if (n.indexOf('COLSM8') != -1) {
                    return l18_column + ' 8/12';
                } else if (n.indexOf('COLSM9') != -1) {
                    return l18_column + ' 9/12';
                } else if (n.indexOf('COLSM10') != -1) {
                    return l18_column + ' 10/12';
                } else if (n.indexOf('COLSM11') != -1) {
                    return l18_column + ' 11/12';
                } else if (n.indexOf('COLSM12') != -1) {
                    return l18_column + ' 12/12';
                } else if (n.indexOf('COLLG1') != -1) {
                    return l18_column + ' 1/12';
                } else if (n.indexOf('COLLG2') != -1) {
                    return l18_column + ' 2/12';
                } else if (n.indexOf('COLLG3') != -1) {
                    return l18_column + ' 3/12';
                } else if (n.indexOf('COLLG4') != -1) {
                    return l18_column + ' 4/12';
                } else if (n.indexOf('COLLG5') != -1) {
                    return l18_column + ' 5/12';
                } else if (n.indexOf('COLLG6') != -1) {
                    return l18_column + ' 6/12';
                } else if (n.indexOf('COLLG7') != -1) {
                    return l18_column + ' 7/12';
                } else if (n.indexOf('COLLG8') != -1) {
                    return l18_column + ' 8/12';
                } else if (n.indexOf('COLLG9') != -1) {
                    return l18_column + ' 9/12';
                } else if (n.indexOf('COLLG10') != -1) {
                    return l18_column + ' 10/12';
                } else if (n.indexOf('COLLG11') != -1) {
                    return l18_column + ' 11/12';
                } else if (n.indexOf('COLLG12') != -1) {
                    return l18_column + ' 12/12';
                } else if (n == 'POSTBODY') {
                    return l18_post_division;
                } else if (n == 'POST') {
                    return l18_post_division;
                } else if (n == 'CONTENT' || n == 'DEFAULTCONTENT') {
                    return l18_content_division;
                } else if (n == 'ENTRYTITLE') {
                    return l18_entry_title;
                } else if (n == 'ENTRYCONTENT') {
                    return l18_entry_content;
                } else if (n == 'ENTRYFOOTER') {
                    return l18_entry_footer;
                } else if (n == 'ENTRYHEADER') {
                    return l18_entry_header;
                } else if (n == 'ENTRYTIME') {
                    return l18_entry_time;
                } else if (n == 'POSTEDITLINK') {
                    return l18_post_edit_link;
                } else if (n == 'POSTTHUMBNAIL') {
                    return l18_post_thumbnail;
                } else if (n == 'THUMBNAIL') {
                    return l18_thumbnail;
                } else if (n.indexOf("ATTACHMENT") >= 0) {
                    return l18_thumbnail_image;
                } else if (n == 'EDITLINK') {
                    return l18_edit_link;
                } else if (n == 'COMMENTSLINK') {
                    return l18_comments_link_division;
                } else if (n == 'SITEDESCRIPTION') {
                    return l18_site_description;
                } else if (n == 'POSTCLEAR' || n == 'POSTBREAK') {
                    return l18_post_break;
                }

                // Smart For ID
                if (yp_smart_name(id) != false) {
                    return yp_smart_name(id);
                }

                // Smart For Class
                if (yp_smart_name(className) != false) {
                    return yp_smart_name(className);
                }

                // If not have name found, use clear.
                if (n.indexOf("CLEARFIX") != -1 || n.indexOf("CLEARBOTH") != -1 || n == "CLEAR") {
                    return l18_clear;
                }

                // TAG NAME START
                if (a == 'P') {
                    return l18_paragraph;
                } else if (a == 'BR') {
                    return l18_line_break;
                } else if (a == 'HR') {
                    return l18_horizontal_rule;
                } else if (a == 'A') {
                    return l18_link;
                } else if (a == 'LI') {
                    return l18_list_item;
                } else if (a == 'UL') {
                    return l18_unorganized_list;
                } else if (a == 'OL') {
                    return l18_unorganized_list;
                } else if (a == 'IMG') {
                    return l18_image;
                } else if (a == 'B') {
                    return l18_bold_tag;
                } else if (a == 'I') {
                    return l18_italic_tag;
                } else if (a == 'STRONG') {
                    return l18_strong_tag;
                } else if (a == 'Em') {
                    return l18_italic_tag;
                } else if (a == 'BLOCKQUOTE') {
                    return l18_blockquote;
                } else if (a == 'PRE') {
                    return l18_preformatted;
                } else if (a == 'TABLE') {
                    return l18_table;
                } else if (a == 'TR') {
                    return l18_table_row;
                } else if (a == 'TD') {
                    return l18_table_data;
                } else if (a == 'HEADER' || n == 'HEADER') {
                    return l18_header_division;
                } else if (a == 'FOOTER' || n == 'FOOTER') {
                    return l18_footer_division;
                } else if (a == 'SECTION' || n == 'SECTION') {
                    return l18_section;
                } else if (a == 'FORM') {
                    return l18_form_division;
                } else if (a == 'BUTTON') {
                    return l18_button;
                } else if (a == 'CENTER') {
                    return l18_centred_block;
                } else if (a == 'DL') {
                    return l18_definition_list;
                } else if (a == 'DT') {
                    return l18_definition_term;
                } else if (a == 'DD') {
                    return l18_definition_description;
                } else if (a == 'H1') {
                    return l18_header + ' (' + l18_level + ' 1)';
                } else if (a == 'H2') {
                    return l18_header + ' (' + l18_level + ' 2)';
                } else if (a == 'H3') {
                    return l18_header + ' (' + l18_level + ' 3)';
                } else if (a == 'H4') {
                    return l18_header + ' (' + l18_level + ' 4)';
                } else if (a == 'H5') {
                    return l18_header + ' (' + l18_level + ' 5)';
                } else if (a == 'H6') {
                    return l18_header + ' (' + l18_level + ' 6)';
                } else if (a == 'SMALL') {
                    return l18_smaller_text;
                } else if (a == 'TEXTAREA') {
                    return l18_text_area;
                } else if (a == 'TBODY') {
                    return l18_body_of_table;
                } else if (a == 'THEAD') {
                    return l18_head_of_table;
                } else if (a == 'TFOOT') {
                    return l18_foot_of_table;
                } else if (a == 'U') {
                    return l18_underline_text;
                } else if (a == 'SPAN') {
                    return l18_span;
                } else if (a == 'Q') {
                    return l18_quotation;
                } else if (a == 'CITE') {
                    return l18_citation;
                } else if (a == 'CODE') {
                    return l18_expract_of_code;
                } else if (a == 'NAV' || n == 'NAVIGATION' || n == 'NAVIGATIONCONTENT') {
                    return l18_navigation;
                } else if (a == 'LABEL') {
                    return l18_label;
                } else if (a == 'TIME') {
                    return l18_time;
                } else if (a == 'DIV') {
                    return l18_division;
                } else if (a == 'CAPTION') {
                    return l18_caption_of_table;
                } else if (a == 'INPUT') {
                    return l18_input;
                } else {
                    return a.toLowerCase();
                }

            }

            function yp_letter_repeat(str) {
                var reg = /^([a-z])\1+$/;
                var d = reg.test(str);
                return d;
            }

            function titleCase(string) {
                return string.charAt(0).toUpperCase() + string.slice(1);
            }
            // http://www.corelangs.com/js/string/cap.html#sthash.vke6OlCk.dpuf

            function yp_smart_name(className) {

                if (typeof className == typeof undefined || className === false) {
                    return false;
                }

                // RegExp
                var upperCase = new RegExp('[A-Z]');
                var numbers = new RegExp('[0-9]');

                // Only - or _
                if (className.match(/_/g) && className.match(/-/g)) {
                    return false;
                }

                // max 3 -
                if (className.match(/-/g)) {
                    if (className.match(/-/g).length >= 3) {
                        return false;
                    }
                }

                // max 3 _
                if (className.match(/_/g)) {
                    if (className.match(/_/g).length >= 3) {
                        return false;
                    }
                }

                // Clean
                className = className.replace(/_/g, ' ').replace(/-/g, ' ');

                var classNames = className.split(" ");

                var i = 0;
                for (i = 0; i < classNames.length; i++) {
                    if (classNames[i].length < 4 || classNames[i].length > 12) {
                        return false;
                    }
                }

                // if all lowerCase
                // if not any number
                // if minimum 3 and max 20
                if (className.match(upperCase) || className.match(numbers) || className.length < 5 || className.length > 20) {
                    return false;
                }

                if (yp_letter_repeat(className)) {
                    return false;
                }

                // For id.
                className = className.replace("#", "");

                return titleCase(className);

            }

            // disable jquery plugins. // Parallax.
            $("#yp-background-parallax .yp-radio").click(function() {

                var v = $(this).find("input").val();

                if (v == 'disable') {
                    iframe.find(yp_get_current_selector()).addClass("yp-parallax-disabled");
                } else {
                    iframe.find(yp_get_current_selector()).removeClass("yp-parallax-disabled");
                }

            });

            // Update saved btn
            function yp_option_change() {

                $(".yp-save-btn").html(l18_save).removeClass("yp-disabled").addClass("waiting-for-save");

                var caller = setTimeout(function() {

                    // Call CSS Engine.
                    $(document).CallCSSEngine(yp_get_clean_css(true));

                }, 200);

                setTimeout(function() {
                    editor.setValue(yp_get_clean_css(true));
                }, 200);

            }

            // Update saved btn
            function yp_option_update() {
                $(".yp-save-btn").html(l18_saved).addClass("yp-disabled").removeClass("waiting-for-save");
            }

            // Wait until CSS process.
            function yp_process(close, id, type) {

                // close css editor with process..
                if (close == true) {

                    iframe.find(".yp-styles-area style[data-rule='a']").remove();

                    $("#cssData,#cssEditorBar,#leftAreaEditor").hide();
                    iframeBody.trigger("scroll");
                    $("body").removeClass("yp-css-editor-active");

                    // Update All.
                    yp_draw();

                }

                // IF not need to process, stop here.
                if (body.hasClass("yp-need-to-process") == false) {
                    return false;
                }

                // Remove class.
                body.removeClass("yp-need-to-process");

                // Processing.
                if (body.find(".yp-processing").length == 0) {
                    body.addClass("yp-processing-now");
                    body.append("<div class='yp-processing'><span></span><p>" + l18_process + "</p></div>");
                } else {
                    body.addClass("yp-processing-now");
                }

                if (editor.getValue().length > 800) {
                    body.find(".yp-processing").show();
                }

                setTimeout(function() {

                    yp_cssToData('desktop');

                    if (editor.getValue().toString().indexOf("@media") != -1) {

                        var mediaTotal = editor.getValue().toString().match(/@media(.*?){/g);

                        // Search medias and convert to Yellow Pencil Data
                        $.each(mediaTotal, function(index, value) {

                            value = value.replace(/(\r\n|\n|\r)/g, "").replace(/\t/g, '');
                            value = value.replace(/\/\*(.*?)\*\//g, "");
                            value = value.replace(/\}\s+\}/g, '}}').replace(/\s+\{/g, '{');
                            value = value.replace(/\s+\}/g, '}').replace(/\{\s+/g, '{');

                            yp_cssToData(value);
                        });

                    }

                    iframe.find("#yp-css-data-full").remove();

                    body.removeClass("process-by-code-editor");

                    setTimeout(function() {
                        body.removeClass("yp-processing-now");
                        body.find(".yp-processing").hide();
                        editor.setValue(yp_get_clean_css(true));
                    }, 5);

                    // Save
                    if (id != false) {

                        var posting = $.post(ajaxurl, {
                            action: "yp_ajax_save",
                            yp_id: id,
                            yp_stype: type,
                            yp_data: yp_get_clean_css(true),
                            yp_editor_data: yp_get_styles_area()
                        });

                        var postingPre = $.post(ajaxurl, {

                                action: "yp_preview_data_save",
                                yp_data: data

                            });

                        // Done.
                        posting.complete(function(data) {
                            $(".yp-save-btn").html(l18_saved).addClass("yp-disabled").removeClass("waiting-for-save");
                        });

                    }

                }, 50);

            }

            //Function to convert hex format to a rgb color
            function yp_color_converter(rgb) {
                if (typeof rgb !== 'undefined') {
                    rgb = rgb.match(/^rgba?[\s+]?\([\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?/i);
                    return (rgb && rgb.length === 4) ? "#" + ("0" + parseInt(rgb[1], 10).toString(16)).slice(-2) + ("0" + parseInt(rgb[2], 10).toString(16)).slice(-2) + ("0" + parseInt(rgb[3], 10).toString(16)).slice(-2) : '';
                } else {
                    return '';
                }
            }

            // Check if font available
            function yp_is_font_available(font) {
                var testString = '~iomwIOMW';
                var containerId = 'is-font-available-container';

                var fontArray = font instanceof Array;

                if (!fontArray) {
                    font = [font];
                }

                var fontAvailability = [];

                var containerSel = '#' + containerId;
                var spanSel = containerSel + ' span';

                var familySansSerif = 'sans-serif';
                var familyMonospace = 'monospace, monospace';
                // Why monospace twice? It's a bug in the Mozilla and Webkit rendering engines:
                // http://www.undermyhat.org/blog/2009/09/css-font-family-monospace-renders-inconsistently-in-firefox-and-chrome/

                // DOM:
                iframeBody.append('<div id="' + containerId + '"></div>');
                iframe.find(containerSel).append('<span></span>');
                iframe.find(spanSel).append(document.createTextNode(testString));

                // CSS:
                iframe.find(containerSel).css('visibility', 'hidden');
                iframe.find(containerSel).css('position', 'absolute');
                iframe.find(containerSel).css('left', '-9999px');
                iframe.find(containerSel).css('top', '0');
                iframe.find(containerSel).css('font-weight', 'bold');
                iframe.find(containerSel).css('font-size', '200px !important');

                jQuery.each(font, function(i, v) {
                    iframe.find(spanSel).css('font-family', v + ',' + familyMonospace);
                    var monospaceFallbackWidth = iframe.find(spanSel).width();
                    var monospaceFallbackHeight = iframe.find(spanSel).height();

                    iframe.find(spanSel).css('font-family', v + ',' + familySansSerif);
                    var sansSerifFallbackWidth = iframe.find(spanSel).width();
                    var sansSerifFallbackHeight = iframe.find(spanSel).height();

                    fontAvailability[i] = true &&
                        monospaceFallbackWidth == sansSerifFallbackWidth &&
                        monospaceFallbackHeight == sansSerifFallbackHeight;
                });

                iframe.find(containerSel).remove();

                if (!fontArray && fontAvailability.length == 1) {
                    fontAvailability = fontAvailability[0];
                }

                return fontAvailability;
            }

            // Clean classes by yellow pencil control classes.
            function yp_classes_clean(data) {

                if (data == undefined || data == false) {
                    return '';
                }

                return data.replace(/yp-scene-1|yp-sharp-selector-mode-active|yp-scene-2|yp-scene-3|yp-scene-4|yp-scene-5|yp-scene-6|yp-anim-creator|data-anim-scene|yp-anim-link-toggle|yp-animate-test-playing|ui-draggable-handle|yp-css-data-trigger|yp-yellow-pencil-demo-mode|yp-yellow-pencil-loaded|yp-element-resized|yp-selected-handle|yp-parallax-disabled|ready-for-drag|yp_onscreen|yp_hover|yp_click|yp_focus|yp-selected-others|yp-selected|yp-demo-link|yp-live-editor-link|yp-yellow-pencil|wt-yellow-pencil|yp-content-selected|yp-hide-borders-now|ui-draggable|yp-target-active|yp-yellow-pencil-disable-links|yp-closed|yp-responsive-device-mode|yp-metric-disable|yp-css-editor-active|wtfv|yp-clean-look|yp-has-transform|yp-will-selected|yp-selected|yp-fullscreen-editor|context-menu-active|yp-element-resizing|yp-element-resizing-width-left|yp-element-resizing-width-right|yp-element-resizing-height-top|yp-element-resizing-height-bottom|context-menu-active|yp-left-selected-resizeable|yp-selectors-hide|yp-contextmenuopen/gi, '');
            }

            // This function add to class to body tag.
            // ex input: .element1 .element2
            // ex output: body.custom-class .element1 element2
            function yp_add_class_to_body(selector, prefix) {

                // Basic
                if (selector == 'body') {
                    selector = selector + "." + prefix;
                }

                // If class added, return.
                if (selector.indexOf("body." + prefix) != -1) {
                    return selector;
                }

                if (selector.split(" ").length > 0) {

                    var firstHTML = '';
                    var firstSelector = $.trim(selector.split(" ")[0]);

                    if (firstSelector.toLowerCase() == 'html') {
                        firstHTML = firstSelector;
                    }

                    if (iframe.find(firstSelector).length > 0) {
                        if (firstSelector.indexOf("#") != -1) {
                            if (iframe.find(firstSelector)[0].nodeName == 'HTML') {
                                firstHTML = firstSelector;
                            }
                        }

                        if (firstSelector.indexOf(".") != -1) {
                            if (iframe.find(firstSelector)[0].nodeName == 'HTML') {
                                firstHTML = firstSelector;
                            }
                        }
                    }

                    if (firstHTML != '') {
                        selector = $.trim(selector.split(" ")[1]);
                    }

                }

                // find body tag
                selector = selector.replace(/\bbody\./g, 'body.' + prefix + ".");
                selector = selector.replace(' body ', ' body.' + prefix + " ");

                // If class added, return.
                if (selector.indexOf("body." + prefix) != -1) {
                    if (firstHTML != '') {
                        selector = firstHTML + " " + selector;
                    }

                    return selector;
                }

                // Get all body classes.
                if (iframeBody.attr("class") != undefined && iframeBody.attr("class") != null) {
                    var bodyClasses = iframeBody.attr("class").split(" ");

                    // Adding to next to classes.
                    for (var i = 0; i < bodyClasses.length; i++) {
                        selector = selector.replace("." + bodyClasses[i] + " ", "." + bodyClasses[i] + "." + prefix + " ");

                        if (selector.split(" ").length == 1 && bodyClasses[i] == selector.replace(".", "")) {
                            selector = selector + "." + prefix;
                        }

                    }
                }

                // If class added, return.
                if (selector.indexOf("." + prefix + " ") != -1) {
                    if (firstHTML != '') {
                        selector = firstHTML + " " + selector;
                    }

                    return selector;
                }

                // If class added, return.
                if (selector.indexOf("." + prefix) != -1 && selector.split(" ").length == 1) {
                    if (firstHTML != '') {
                        selector = firstHTML + " " + selector;
                    }

                    return selector;
                }

                // Get body id.
                var bodyID = iframeBody.attr("id");

                selector = selector.replace("#" + bodyID + " ", "#" + bodyID + "." + prefix + " ");

                // If class added, return.
                if (selector.indexOf("." + prefix + " ") != -1) {
                    if (firstHTML != '') {
                        selector = firstHTML + " " + selector;
                    }

                    return selector;
                }

                selector = "YPIREFIX" + selector;
                selector = selector.replace(/YPIREFIXbody /g, 'body.' + prefix + " ");
                selector = selector.replace("YPIREFIX", "");

                // If class added, return.
                if (selector.indexOf("body." + prefix + " ") != -1) {
                    if (firstHTML != '') {
                        selector = firstHTML + " " + selector;
                    }

                    return selector;
                }

                if (selector.indexOf(" body ") == -1 || selector.indexOf(" body.") == -1) {
                    selector = "body." + prefix + " " + selector;
                }

                if (firstHTML != '') {
                    selector = firstHTML + " " + selector;
                }

                return selector;

            }

            // Browser fullscreen
            function yp_toggle_full_screen(elem) {
                // ## The below if statement seems to work better ## if ((document.fullScreenElement && document.fullScreenElement !== null) || (document.msfullscreenElement && document.msfullscreenElement !== null) || (!document.mozFullScreen && !document.webkitIsFullScreen)) {
                if ((document.fullScreenElement !== undefined && document.fullScreenElement === null) || (document.msFullscreenElement !== undefined && document.msFullscreenElement === null) || (document.mozFullScreen !== undefined && !document.mozFullScreen) || (document.webkitIsFullScreen !== undefined && !document.webkitIsFullScreen)) {
                    if (elem.requestFullScreen) {
                        elem.requestFullScreen();
                    } else if (elem.mozRequestFullScreen) {
                        elem.mozRequestFullScreen();
                    } else if (elem.webkitRequestFullScreen) {
                        elem.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
                    } else if (elem.msRequestFullscreen) {
                        elem.msRequestFullscreen();
                    }
                    body.addClass("yp-fullscreen");
                } else {
                    if (document.cancelFullScreen) {
                        document.cancelFullScreen();
                    } else if (document.mozCancelFullScreen) {
                        document.mozCancelFullScreen();
                    } else if (document.webkitCancelFullScreen) {
                        document.webkitCancelFullScreen();
                    } else if (document.msExitFullscreen) {
                        document.msExitFullscreen();
                    }
                    body.removeClass("yp-fullscreen");
                }
            }

            $(document).bind('webkitfullscreenchange mozfullscreenchange fullscreenchange', function(e) {
                var state = document.fullScreen || document.mozFullScreen || document.webkitIsFullScreen;
                var event = state ? 'FullscreenOn' : 'FullscreenOff';

                if (event == 'FullscreenOff') {
                    $(".fullscreen-btn").removeClass("active");
                    body.removeClass("yp-fullscreen");
                }

            });

        } // Yellow Pencil main function.

}(jQuery));
