/**
*	Theme main theme Frontend JavaScript file
*/
(function($){
$(document).ready(function() {

	'use strict';

	// iOS buttons style fix
	var platform = navigator.platform;

    if (platform === 'iPad' || platform === 'iPhone' || platform === 'iPod') {
        $('input.button, input[type="text"], input[type="button"], input[type="password"], textarea, input.input-text').css('-webkit-appearance', 'none');
    }

	// Disable animations for touch devices
	if(isTouchDevice()===true) {
	    $("#animations-css").remove();
	}

	// Select restyling
	$("select").select2({
		allowClear: true,
		minimumResultsForSearch: 10
	});

	// Init elements appear animations
	AOS.init({
		once: true
	});

	// Parallax
	$(".inhype-parallax").parallax();

	// Add body class for title header with background
	if($("body.single-post .container-page-item-title.with-bg, body.page .container-page-item-title.with-bg").length > 0) {
		$("body").addClass('blog-post-header-with-bg');
	}

	// Remove embed responsive container from Gutenberg elements, except Video
	$('.wp-block-embed:not(.is-type-video) .embed-container').removeClass('embed-container');

	// Add images backgrounds
	$('.inhype-post-image').each(function( index ) {
		$(this).attr('style', ($(this).attr('data-style')));
	});
	$('.inhype-next-post').each(function( index ) {
		$(this).attr('style', ($(this).attr('data-style')));
	});
	$('.sidebar .widget.widget_inhype_text .inhype-textwidget').each(function( index ) {
		$(this).attr('style', ($(this).attr('data-style')));
	});
	$('.container-page-item-title').each(function( index ) {
		$(this).attr('style', ($(this).attr('data-style')));
	});
	$('.container-page-item-title .page-item-single-image-column').each(function( index ) {
		$(this).attr('style', ($(this).attr('data-style')));
	});
	$('.inhype-featured-categories-wrapper .inhype-featured-category').each(function( index ) {
		$(this).attr('style', ($(this).attr('data-style')));
	});
	$('.inhype-featured-categories-wrapper .inhype-featured-category-bg').each(function( index ) {
		$(this).attr('style', ($(this).attr('data-style')));
	});
	$('.inhype-featured-categories-wrapper .inhype-category-image').each(function( index ) {
		$(this).attr('style', ($(this).attr('data-style')));
	});
	$('.sidebar .widget.widget_inhype_categories .post-categories-image').each(function( index ) {
		$(this).attr('style', ($(this).attr('data-style')));
	});
	$('.sidebar .widget.widget_inhype_categories .post-categories-counter').each(function( index ) {
		$(this).attr('style', ($(this).attr('data-style')));
	});
	$('.sidebar .widget.widget_inhype_categories .post-categories-bg').each(function( index ) {
		$(this).attr('style', ($(this).attr('data-style')));
	});
	$('.inhype-post .post-categories .cat-dot').each(function( index ) {
		$(this).attr('style', ($(this).attr('data-style')));
	});
	$('.footer-html-block').each(function( index ) {
		$(this).attr('style', ($(this).attr('data-style')));
	});
	$('.post-review-block .post-review-criteria-value').each(function( index ) {
		$(this).attr('style', ($(this).attr('data-style')));
	});
	$('.post-review-block .post-review-rating-total').each(function( index ) {
		$(this).attr('style', ($(this).attr('data-style')));
	});
	$('.post-review-block .post-review-button-icon').each(function( index ) {
		$(this).attr('style', ($(this).attr('data-style')));
	});
	$('.post-review-rating-badge').each(function( index ) {
		$(this).attr('style', ($(this).attr('data-style')));
	});
	$('.post-review-block .post-review-image').each(function( index ) {
		$(this).attr('style', ($(this).attr('data-style')));
	});


	// Move WooCommerce sale badge
	$('.woocommerce.single span.onsale').prependTo($('.woocommerce div.product div.images.woocommerce-product-gallery'));


	// Header search form behavior
	var search_opened = false;

	// Sync search fields
	$('body').on('keyup', 'header.sticky-header:not(.fixed) .header-center-search-form .searchform input[type="search"]', function(e){
		$('header.sticky-header.fixed .header-center-search-form .searchform input[type="search"]').val($('header.sticky-header:not(.fixed) .header-center-search-form .searchform input[type="search"]').val());
	});

	$('body').on('keyup', 'header.sticky-header.fixed .header-center-search-form .searchform input[type="search"]', function(e){
		$('header.sticky-header:not(.fixed) .header-center-search-form .searchform input[type="search"]').val($('header.sticky-header.fixed .header-center-search-form .searchform input[type="search"]').val());
	});

	// Init regular search for search expanded in header
	var search_regular = false;

	if($('header[class*="header-layout-menu-below-header-left"] .search-toggle-btn').length && !$('header .header-center-custom-content').length) {
		$('header[class*="header-layout-menu-below-header-left"] .search-toggle-btn').click();
		search_regular = true;
	}

	$('body').on('click', '.search-toggle-wrapper.search-header .search-toggle-btn', function(e){

		if(!search_regular) {
			$(document).keyup(function(e){
			    if(e.keyCode === 27) {
				    if(search_opened) {
				    	search_opened = false;

						$('.header-center-search-form .searchform input[type="search"]').animate({
						    width: 0,
						    opacity: 0
						}, 500, function() {
						    // Animation complete.
						    $('.header-center-search-form').hide();
						});
					}
			    }
			});
		}

		if($('.header-center-search-form .searchform input[type="search"]').val() !== '') {
			$('.header-center-search-form .searchform .submit').click();
		} else {
			if(!search_regular) {
				if(search_opened) {
					search_opened = false;

					$('.header-center-search-form .searchform input[type="search"]').animate({
					    width: 0,
					    opacity: 0
					}, 500, function() {
					    // Animation complete.
					    $('.header-center-search-form').hide();
					});

				} else {
					search_opened = true;

					$('.header-center-search-form').show();
					$('.header-center-search-form .searchform input[type="search"]').animate({
					    width: 230,
					    opacity: 1
					}, 500, function() {
					    // Animation complete.
					    if($('header.sticky-header.fixed').css('display') == 'block') {
							$('header.sticky-header.fixed .header-center-search-form .searchform input[type="search"]').focus();
					    } else {
					    	$('header.sticky-header:not(.fixed) .header-center-search-form .searchform input[type="search"]').focus();
					    }
					});

				}
			}
		}
	});

	// Fullscreen search form behaviour
	$('body').on('click', '.search-toggle-wrapper.search-fullscreen .search-toggle-btn', function(e){

		$(document).keyup(function(e){
		    if(e.keyCode === 27)
		        $('.search-fullscreen-wrapper').fadeOut();
		});

		$('.search-fullscreen-wrapper').fadeIn();
		$('.search-fullscreen-wrapper .search-fullscreen-form input[type="search"]').focus();
		$('.search-fullscreen-wrapper .search-fullscreen-form input[type="search"]').val('');
	});

	$('.search-close-btn').on('click', function(e){
		$('.search-fullscreen-wrapper').fadeOut();
	});

	// Main menu toggle button
	$('header .mainmenu-mobile-toggle').on('click', function(e){
		$('header .navbar-toggle').click();
	});

	// Top mobile menu
	var topmenuopened = 0;
	$( document ).on( "click", ".menu-top-menu-container-toggle", function(e) {
		if(topmenuopened == 0) {
			$(this).next().slideDown();
			topmenuopened = 1;
		} else {
			topmenuopened = 0;
			$(this).next().slideUp();
		}
	});

	// Mobile menu clicks for top and main menus
	$('.nav li > a, .header-menu li > a').on('click', function(e){

		if($(window).width() < 991) {

			// Open dropdown on click
			if ( $(this).next(".sub-menu").length > 0 ) {
				var sm = $(this).next(".sub-menu");

				if(sm.data('open') !== 1) {
					e.preventDefault();
					e.stopPropagation();

					sm.slideDown();

					sm.data('open', 1);

					$(this).parent().addClass('mobile-submenu-opened');

				} else {
					// Close dropdown if no href in link
					if($(this).attr('href') == '#') {
						e.preventDefault();
						e.stopPropagation();

						sm.slideUp();

						sm.data('open', 0);

						$(this).parent().removeClass('mobile-submenu-opened');
					}
				}

			}
		} else {
			// Mobile menu clicks for touch devices
			if(isTouchDevice()===true) {

				if ( $(this).next(".sub-menu").length > 0 ) {
					var sm = $(this).next(".sub-menu");

					if(sm.data('open') !== 1) {
						e.preventDefault();
						e.stopPropagation();

						sm.slideDown();

						sm.data('open', 1);
					}

				}

			}

		}
	});

	// Prevent submenu items dropdowns goes out from screen
	function alignMenuDropdowns() {
		$('.mainmenu .sub-menu, .header-menu .sub-menu').parent().each(function( index ) {
			var menu = $(this).find("ul.sub-menu");
		    var menupos = $(menu).offset();
		    var newpos = $(menu).width();

		    if (menupos.left + menu.width() > $(window).width()) {
		        menu.css({ right: newpos });
		    }

		    if(menupos.left < 0) {
		    	menu.css({ right: -newpos });
		    }
		});
	}

	// Align on load (and later on window resize)
	alignMenuDropdowns();

	// Sidebar menu widget clicks
	$('.sidebar .widget.widget_nav_menu a').on('click', function(e){

			if ( $(this).next(".sub-menu").length > 0 ) {
				var sm = $(this).next(".sub-menu");

				if(sm.data('open') !== 1)
				{
					e.preventDefault();
					e.stopPropagation();
					sm.slideDown();

					sm.data('open', 1);

					$(this).parent().addClass('mobile-submenu-opened');
				}

			}
	});

	// Cookie bar plugin restyle
	if($('#catapult-cookie-bar').length > 0) {
		$('#catapult-cookie-bar button').addClass('btn');
	}

	/**
	*	Scroll related functions
	*/

	// Scroll to top button
	var scrollonscreen = 0;

	$(window).scroll(function () {
		scrollonscreen = $(window).scrollTop() + $(window).height();

		if(scrollonscreen > $(window).height() + 350){
			$('.scroll-to-top').css("bottom", "60px");
		}
		else {
			$('.scroll-to-top').css("bottom", "-60px");
		}

	});

	// Scroll to top animation
	$('.scroll-to-top').on('click', function(e){
		$('body,html').stop().animate({
			scrollTop:0
		},800,'easeOutCubic')
		return false;
	});

	// Sticky header
	if($(window).width() > 991 && !isTouchDevice()) {

		var $stickyheader = $('header.main-header.sticky-header');
		var STICKY_HEADER_OFFSET = 500; // Offest after header to show sticky version

		if($stickyheader.length > 0) {
			var $fixedheader = $stickyheader.clone();
		   	$fixedheader.insertAfter($stickyheader);
		   	$fixedheader.addClass('fixed');

		   	if($("#wpadminbar").length > 0) {
		   		$fixedheader.css('top', $("#wpadminbar").height());
		   	}

			$(window).scroll(function() {

			    if ($(window).scrollTop() > $stickyheader.offset().top + STICKY_HEADER_OFFSET) {
			        $fixedheader.fadeIn();
			    } else {
			        $fixedheader.fadeOut('fast');
			    }
			});
		}
	}

	// Sticky sidebar position for touch devices without fixed header
	if(isTouchDevice()) {
		$('.blog-enable-sticky-sidebar.blog-enable-sticky-header .content-block .sidebar').css('top', '40px');
	}

	/**
	*	Resize events
	*/

	$(window).resize(function () {
		alignMenuDropdowns();
	});

	/**
	*	Other scripts
	*/

	/**
	*	Common functions
	*/

	// Check for touch device
    function isTouchDevice(){
	    return true == ("ontouchstart" in window || window.DocumentTouch && document instanceof DocumentTouch);
	}

});
})(jQuery);

// Global functions
'use strict';

/* Cookie functions */
function setCookie(name,value,days) {
    if (days) {
        var date = new Date();
        date.setTime(date.getTime()+(days*24*60*60*1000));
        var expires = "; expires="+date.toGMTString();
    }
    else var expires = "";
    document.cookie = name+"="+value+expires+"; path=/";
}

function getCookie(name) {
  var value = "; " + document.cookie;
  var parts = value.split("; " + name + "=");
  if (parts.length == 2) return parts.pop().split(";").shift();
}
