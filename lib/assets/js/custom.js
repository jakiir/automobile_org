/* ---------------------------------------------------------------------
 READY FUNCTION
--------------------------------------------------------------------- */
jQuery(document).ready(function() {



    $('#list').click(function(event){event.preventDefault();$('#products .item').addClass('list-group-item');});
    $('#grid').click(function(event){event.preventDefault();$('#products .item').removeClass('list-group-item');$('#products .item').addClass('grid-group-item');});


//	/* --------------------------------------------
//	 ACTIVE NAVIGATION
//	-------------------------------------------- */
//		jQuery(function() {
//			jQuery('body').scrollspy({
//				target: '#topnav',
//				offset: 95
//			});
//		});
//
//	/* --------------------------------------------
//	 MENU HIDE AFTER CLICK --  mobile devices
//	-------------------------------------------- */
//		jQuery('.nav li a').click(function () {
//			jQuery('.navbar-collapse').removeClass('in');
//		});
//
//	/* --------------------------------------------
//	 FIXED MENU ON SCROLL
//	-------------------------------------------- */
//		jQuery(function() {
//			jQuery("#sticky-section").sticky({topSpacing:0});
//		});
//
//	/* --------------------------------------------
//	 FILTERS / PORTFOLIO SCRIPT
//	-------------------------------------------- */
//		var $proJects = jQuery('#projects').isotope();
//			// filter items on button click
//			jQuery('#filters').on( 'click', 'li', function() {
//			jQuery(this).parent().find('li.active').removeClass('active');
//			jQuery(this).addClass('active');
//				var filterValue = jQuery(this).attr('data-filter');
//					$proJects.isotope({
//					filter: filterValue
//			});
//		});
//	/* --------------------------------------------
//	 ANIMATED ITEMS
//	-------------------------------------------- */
//		jQuery('.animated').appear(function() {
//			var elem = jQuery(this);
//				var animation = elem.data('animation');
//					if ( !elem.hasClass('visible') ) {
//					var animationDelay = elem.data('animation-delay');
//						if ( animationDelay ) {
//							setTimeout(function(){
//								elem.addClass( animation + " visible" );
//							}, animationDelay);
//						} else {
//					elem.addClass( animation + " visible" );
//				}
//			}
//		});
//
//	/* --------------------------------------------
//	 LIGHT BOX
//	-------------------------------------------- */
//		jQuery(function() {
//			jQuery("a[data-rel^='prettyPhoto']").prettyPhoto({
//				theme: "light_square",
//			});
//		});
//
//	/* --------------------------------------------
//	 EFFECT OVERLAY
//	-------------------------------------------- */
//		jQuery(function() {
//			if (Modernizr.touch) {
//				// show the close overlay button
//				jQuery(".close-overlay").removeClass("hidden");
//				// handle the adding of hover class when clicked
//				jQuery(".img").click(function(e){
//					if (!jQuery(this).hasClass("hover")) {
//						jQuery(this).addClass("hover");
//					}
//				});
//				// handle the closing of the overlay
//				jQuery(".close-overlay").click(function(e){
//					e.preventDefault();
//					e.stopPropagation();
//					if (jQuery(this).closest(".img").hasClass("hover")) {
//						jQuery(this).closest(".img").removeClass("hover");
//					}
//				});
//			} else {
//				// handle the mouseenter functionality
//				jQuery(".img").mouseenter(function(){
//					jQuery(this).addClass("hover");
//				})
//				// handle the mouseleave functionality
//				.mouseleave(function(){
//					jQuery(this).removeClass("hover");
//				});
//			}
//		});
//
//
//
//
//});
///* ---------------------------------------------------------------------
// READY FUNCTION ENDS
//--------------------------------------------------------------------- */
//
///* ---------------------------------------------------------------------
// LOAD FUNCTION
//--------------------------------------------------------------------- */
//jQuery(window).load(function() {
//
//	/* --------------------------------------------
//	 PAGE LOADER
//	-------------------------------------------- */
//		jQuery(".loader-item").delay(700).fadeOut();
//		jQuery("#pageloader").delay(800).fadeOut("slow");
//
//	/* --------------------------------------------
//	 HOME PAGE TEXT SLIDER
//	-------------------------------------------- */
//		jQuery('.text-slider').flexslider({
//			animation: "slide",
//			selector: ".slide-text li",
//			controlNav: false,
//			directionNav: false,
//			slideshowSpeed: 4000,
//			touch: true,
//			useCSS: false,
//			direction: "vertical",
//			before: function(slider){
//				var height = jQuery('.text-slider').find('.flex-viewport').innerHeight();
//				jQuery('.text-slider').find('li').css({ height: height + 'px' });
//			}
//		});
//
//	/* --------------------------------------------
//	 SPECIAL PACKAGE FLEX SLIDER
//	-------------------------------------------- */
//		jQuery(function() {
//			jQuery('#carousel').flexslider({
//				animation: "slide",
//				controlNav: false,
//				animationLoop: true,
//				slideshow: false,
//				itemWidth: 240,
//				itemMargin: 4,
//				asNavFor: '#slider'
//			});
//
//			jQuery('#slider').flexslider({
//				animation: "slide",
//				controlNav: false,
//				animationLoop: true,
//				slideshow: false,
//				directionNav: false,
//				sync: "#carousel",
//			});
//		});
//
//	/* --------------------------------------------
//	 PORTFOLIO SCRIPTS
//	-------------------------------------------- */
//		jQuery(function() {
//			jQuery('.gallery-col-4').imagesLoaded( function() {
//				jQuery('.gallery-col-4').isotope({
//					layoutMode: 'masonry',
//					itemSelector: '.gallery-items',
//					transformsEnabled: false,
//					resizesContainer: true
//				});
//			});
//
//			jQuery(window).resize(function() {
//				jQuery('.gallery-col-4').imagesLoaded( function() {
//					jQuery('.gallery-col-4').isotope({
//					layoutMode: 'masonry',
//					itemSelector: '.gallery-items',
//					transformsEnabled: false,
//					resizesContainer: true
//					});
//				});
//			});
//		});
//
//
//	/* --------------------------------------------
//	 CLIENT
//	-------------------------------------------- */
//		jQuery("#flexiselDemo").flexisel({
//			visibleItems: 6,
//			animationSpeed: 1000,
//			autoPlay: true,
//			autoPlaySpeed: 3000,
//			pauseOnHover: false,
//			enableResponsiveBreakpoints: true,
//			responsiveBreakpoints: {
//				portrait: {
//				changePoint:480,
//				visibleItems: 6
//				},
//				landscape: {
//				changePoint:640,
//				visibleItems: 2
//				},
//				tablet: {
//				changePoint:768,
//				visibleItems: 3
//				}
//			}
//		});
//
//	/* --------------------------------------------
//	 VIEW GALLERY SECTION
//	-------------------------------------------- */
//		jQuery("#show").click(function(){
//			jQuery("#food-gallery").show();
//			jQuery('#projects').isotope('layout');
//		});



});
/* ---------------------------------------------------------------------
 LOAD FUNCTION ENDS
--------------------------------------------------------------------- */
