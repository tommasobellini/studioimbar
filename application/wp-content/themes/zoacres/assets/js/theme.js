/*
 * Zoacres Theme Js 
 */ 

(function( $ ) {

	"use strict";
		  
	$( document ).ready(function() {
	
		/* Page Loader */
		$( window ).load(function() {
			$(".page-loader").fadeOut("slow");
		});
		
		/* Set Header Height */
		var $window = $(window);
		var $header_cont = $('.portfolio-single-wrapper .portfolio-single-slide .item');
		$header_cont.height( $window.height() );
		$window.resize(function() {
			$header_cont.height( $window.height() );
		});
		
		/* Shortcode CSS Append */
		var css_out = '';
		$( ".zoacres-inline-css" ).each(function() {
			var shortcode = $( this );
			var shortcode_css = shortcode.attr("data-css");		
			css_out += shortcode_css ? ($).parseJSON( shortcode_css ) : '';
			shortcode.removeAttr("data-css");
		});
		
		/* VC Row Custom Style */
		$( ".zoacres-vc-row" ).each(function() {
			var shortcode = $( this );
			var row_class = shortcode.attr("data-class");
			if( shortcode.attr("data-color") ){
				var row_color = shortcode.attr("data-color");		
				css_out += "." + row_class + "{ color:" + row_color + ";}"; 
				shortcode.removeAttr("data-color");
			}
			if( shortcode.attr("data-bg-overlay") ){
				var row_overlay = shortcode.attr("data-bg-overlay");
				css_out += "." + row_class + "{ position: relative; }";
				css_out += "." + row_class + " > span.row-overlay { background-color:" + row_overlay + ";}";
				shortcode.removeAttr("data-bg-overlay");				
			}
			shortcode.removeAttr("data-class");
		});
		if( css_out != '' ){
			$('head').append( '<style id="zoacres-shortcode-styles">'+ css_out +'</style>' );
		}
		
		
		

		/* Secondary Toggle */
		$( document ).on( "click", ".secondary-space-toggle", function() {
			$('.secondary-space-toggle').toggleClass('active');
			$('body').toggleClass('secondary-active');
			var sec_width = $( ".secondary-menu-area" ).width();
			var sec_pos = $( ".secondary-menu-area" ).data('pos') ? $( ".secondary-menu-area" ).data('pos') : 'left';
			
			if( sec_pos == 'overlay' ){
				$( ".secondary-menu-area" ).fadeToggle(500);
			}else if( $('body').hasClass('secondary-active') ){
				if( sec_pos == 'left' ){
					if( $( ".secondary-menu-area" ).hasClass('left-overlay') ){
						$( ".secondary-menu-area" ).animate( { left : "0" }, { duration: 500, specialEasing: { left: "easeInOutExpo" } } );
					}else{
						$('body').toggleClass('secondary-push-actived');
						$( ".secondary-menu-area" ).animate( { left : "0" }, { duration: 500 } );
						$( "body" ).css('overflow','hidden');
						$( "body .zoacres-wrapper" ).animate( { left : sec_width +"px" }, 500 );
						if( $( ".sticky-outer" ).length ) {
							$( ".sticky-outer .header-sticky, .sticky-outer .show-menu" ).animate( { left : sec_width +"px", right: "-" + sec_width +"px" }, 500 );
						}
					}
				}else{
					if( $( ".secondary-menu-area" ).hasClass('right-overlay') ){
						$( ".secondary-menu-area" ).animate( { right : "0" }, { duration: 500, specialEasing: { right: "easeInOutExpo" } } );
					}else{
						$('body').toggleClass('secondary-push-actived');
						$( ".secondary-menu-area" ).animate( { right : "0" }, { duration: 500 } );
						$( "body" ).css('overflow','hidden');
						$( "body .zoacres-wrapper" ).animate( { right : sec_width +"px" }, 500 );
						if( $( ".sticky-outer" ).length ){
							$( ".sticky-outer .header-sticky, .sticky-outer .show-menu" ).animate( { right : sec_width +"px", left : "-" + sec_width +"px" }, 500 );
						}
					}
				}
			}else{
				if( sec_pos == 'left' ){
					if( $( ".secondary-menu-area" ).hasClass('left-overlay') ){
						$( ".secondary-menu-area" ).animate( { left : "-"+ sec_width +"px" }, { duration: 500, specialEasing: { left: "easeInOutExpo" } } );
					}else{
						$('body').toggleClass('secondary-push-actived');
						$( ".secondary-menu-area" ).animate( { left : "-"+ sec_width +"px" }, { duration: 500 } );
						$( "body .zoacres-wrapper" ).animate( { left : 0 }, 500, function(){ $( "body" ).css('overflow-y','scroll'); } );
						if( $( ".sticky-outer" ).length ){
							$( ".sticky-outer .header-sticky, .sticky-outer .show-menu" ).animate( { left : 0, right: 0 }, 500 );
						}
					}
				}else{
					if( $( ".secondary-menu-area" ).hasClass('right-overlay') ){
						$( ".secondary-menu-area" ).animate( { right : "-"+ sec_width +"px" }, { duration: 500, specialEasing: { right: "easeInOutExpo" } } );
					}else{
						$('body').toggleClass('secondary-push-actived');
						$( ".secondary-menu-area" ).animate( { right : "-"+ sec_width +"px" }, { duration: 500 } );
						$( "body .zoacres-wrapper" ).animate( { right : 0 }, 500, function(){ $( "body" ).css('overflow-y','scroll'); } );
						if( $( ".sticky-outer" ).length ){
							$( ".sticky-outer .header-sticky, .sticky-outer .show-menu" ).animate( { right: 0, left : 0 }, 500 );
						}
					}
				}
			}
			
			/* Slider Revolution Issue Fixed */
			if( $(".rev_slider_wrapper").length ){
				$(".rev_slider_wrapper").css("left" , "inherit");    
			}
			
			return false;
		});		
		
		/* Header Bar Center Item Margin Fun */
		setTimeout( zoacresCenterMenuMargin, 300 );
		
		/* Set Sticky Height for Menu Bars */
		zoacresSetStickyOuterHeight();
		
		/* Sticky Menu */
		if($('.header-inner .sticky-head').length){
			zoacresStickyPart( '.header-inner' );
		}
		
		/* Scroll Sticky */
		if($('.header-inner .sticky-scroll').length){
			zoacresStickyScrollUpPart( '.header-inner', 'header' );
		}
		
		/* Mobile Header Sticky Menu */
		if($('.mobile-header-inner .sticky-head').length){
			zoacresStickyPart( '.mobile-header-inner' );
		}
		
		/* Mobile Header Scroll Sticky */
		if($('.mobile-header-inner .sticky-scroll').length){
			zoacresStickyScrollUpPart( '.mobile-header-inner', '.mobile-header' );
		}
		
		/* Sticky Header Space Menu to Modern Toggle Menu Convert */
		if( $('.sticky-header-space').length ){
			
			//Add toggle dropdown icon
			$( ".sticky-header-space .zoacres-main-menu" ).find('.menu-item-has-children').append( '<span class="zmm-dropdown-toggle fa fa-plus"></span>' );
			$( ".sticky-header-space .zoacres-main-menu" ).find('.sub-menu').slideToggle();
			
			//zmm dropdown toggle
			$( ".sticky-header-space .zmm-dropdown-toggle" ).on( "click", function() {
				var parent = $( this ).parent('li').children('.sub-menu');
				$( this ).parent('li').children('.sub-menu').slideToggle();
				$( this ).toggleClass('fa-minus');
				if( $( parent ).find('.sub-menu').length ){
					$( parent ).find('.sub-menu').slideUp();
					$( parent ).find('.zmm-dropdown-toggle').removeClass('fa-minus');
				}
			});
			
		}
		
		/* Full Search Toggle */
		$( document ).on( "click", ".full-search-toggle", function() {
			$('.full-search-wrapper').toggleClass("search-wrapper-opened");
			$('.full-search-wrapper').fadeToggle(500);
			var search_in = $('.search-wrapper-opened').find("input.form-control");
			search_in.focus();			
			return false;
		});	
		
		/* Mobile Bar Animate Toggle */
		$( document ).on( "click", ".mobile-bar-toggle", function() {
			$( ".mobile-bar" ).toggleClass('active');
			$( "body" ).toggleClass('mobile-bar-active');
			if( $( ".mobile-bar" ).hasClass('animate-from-left') ){
				if( $( ".mobile-bar" ).hasClass('active') )
					$( ".mobile-bar" ).animate( { left : 0 }, { duration: 500, specialEasing: { left: "easeInOutExpo" } } );
				else
					$( ".mobile-bar" ).animate( { left : "-100%" }, { duration: 500, specialEasing: { left: "easeInOutExpo" } } );
			}
			if( $( ".mobile-bar" ).hasClass('animate-from-right') ){
				if( $( ".mobile-bar" ).hasClass('active') )
					$( ".mobile-bar" ).animate( { right : 0 }, { duration: 500, specialEasing: { right: "easeInOutExpo" } } );
				else
					$( ".mobile-bar" ).animate( { right : "-100%" }, { duration: 500, specialEasing: { right: "easeInOutExpo" } } );
			}
			if( $( ".mobile-bar" ).hasClass('animate-from-top') ){
				if( $( ".mobile-bar" ).hasClass('active') )
					$( ".mobile-bar" ).animate( { top : 0 }, { duration: 500, specialEasing: { top: "easeInOutExpo" } } );
				else
					$( ".mobile-bar" ).animate( { top : "-100%" }, { duration: 500, specialEasing: { top: "easeInOutExpo" } } );
			}
			if( $( ".mobile-bar" ).hasClass('animate-from-bottom') ){
				if( $( ".mobile-bar" ).hasClass('active') )
					$( ".mobile-bar" ).animate( { bottom : 0 }, { duration: 500, specialEasing: { bottom: "easeInOutExpo" } } );
				else
					$( ".mobile-bar" ).animate( { bottom : "-100%" }, { duration: 500, specialEasing: { bottom: "easeInOutExpo" } } );
			}
			return false;
		});
		
		/* Mobile Bar Menu to Modern Toggle Menu Convert */
		if( $('.mobile-bar').length ){
			
			if( $( ".zoacres-main-menu" ).length || $( ".secondary-menu-area-inner ul.menu" ).length ){
			
				var main_menu = ".zoacres-main-menu";
				if( !$( ".zoacres-main-menu" ).length ){
					$( ".secondary-menu-area-inner ul.menu" ).addClass( "zoacres-main-menu" );
				}
				
				var mobile_menu = ".mobile-bar .zoacres-mobile-main-menu";
				var find_classes = ".dropdown, .mega-dropdown, .dropdown-toggle, .dropdown-menu, .mega-dropdown-menu, .mega-child-heading, .mega-child-dropdown, .mega-child-dropdown-menu, .hidden-xs-up, .row, .mega-sub-dropdown, .mega-sub-dropdown-menu, .mega-sub-child, .mega-sub-child-inner, .left-side";
				var removable_classes = "dropdown mega-dropdown dropdown-toggle dropdown-menu mega-dropdown-menu mega-child-heading mega-child-dropdown mega-child-dropdown-menu hidden-xs-up row mega-sub-dropdown mega-sub-dropdown-menu mega-sub-child mega-sub-child-inner left-side";
				
				//Mobile menu copy from main menu
				$(main_menu).clone().appendTo( mobile_menu );
				
				//Add main class name
				$( mobile_menu + " " + main_menu ).addClass( "flex-column" );
				
				//Remove unwanted item from mobile menu
				$( mobile_menu + " .mega-child-widget" ).parent( "li.menu-item" ).remove();
				$( mobile_menu + " .mega-child-divider" ).remove();
				$( mobile_menu + " .menu-item-logo" ).remove();
				$( mobile_menu + " li.menu-item" ).removeClass (function (index, css) {
					return ( css.match (/\bcol-\S+/g) || [] ).join(' ');

				});
				$( mobile_menu + " li.menu-item" ).removeClass (function (index, css) {
					return ( css.match (/\bmax-col-\S+/g) || [] ).join(' ');
				});
				
				//Change class name
				$( mobile_menu ).find( ".dropdown-menu, .mega-child-dropdown-menu, .mega-sub-child-inner" ).toggleClass( "sub-menu" );
				
				//Content reform
				$( mobile_menu + " .mega-child-item-disabled" ).replaceWith( "<a class='nav-link' href='#'>" + $( mobile_menu + " .mega-child-item-disabled" ).html() + "</a>" );
				
				//Remove unwanted classes
				$( mobile_menu ).find( find_classes ).removeClass( removable_classes );
				
				//Remove Background
				$( mobile_menu + " .sub-menu" ).css('background','none');
				
				//Add toggle dropdown icon
				$( ".mobile-bar " + main_menu ).find('.menu-item-has-children').append( '<span class="zmm-dropdown-toggle fa fa-plus"></span>' );
				$( ".mobile-bar " + main_menu ).find('.sub-menu').slideToggle();
				
				$( ".mobile-bar " + main_menu ).removeClass('zoacres-main-menu').addClass('zoacres-mobile-menu');
				
				//dropdown toggle
				$( ".mobile-bar .zmm-dropdown-toggle" ).on( "click", function() {
					var parent = $( this ).parent('li').children('.sub-menu');
					$( this ).parent('li').children('.sub-menu').slideToggle();
					$( this ).toggleClass('fa-minus');
					if( $( parent ).find('.sub-menu').length ){
						$( parent ).find('.sub-menu').slideUp();
						$( parent ).find('.zmm-dropdown-toggle').removeClass('fa-minus');
					}
				});
			}// check page have main menu or not
			
		}
		
		/* Mobile Bar Menu to Modern Toggle Menu Convert */
		if( $('.secondary-menu-area-inner ul.menu').length ){
				
				var sec_menu = ".secondary-menu-area-inner ul.menu";
				//Add main class name
				$( sec_menu ).addClass( "flex-column" );
				
				//Add toggle dropdown icon
				$( sec_menu ).find('.menu-item-has-children').append( '<span class="zmm-dropdown-toggle fa fa-plus"></span>' );
				$( sec_menu ).find('.sub-menu').slideToggle();
				
				//dropdown toggle
				$( sec_menu + " .zmm-dropdown-toggle" ).on( "click", function() {
					var parent = $( this ).parent('li').children('.sub-menu');
					$( this ).parent('li').children('.sub-menu').slideToggle();
					$( this ).toggleClass('fa-minus');
					if( $( parent ).find('.sub-menu').length ){
						$( parent ).find('.sub-menu').slideUp();
						$( parent ).find('.zmm-dropdown-toggle').removeClass('fa-minus');
					}
				});
			
		}
		
		/* Twitter Widget Slider(newsticker) */
		if( $( ".twitter-slider" ).length ){
			$( ".twitter-slider" ).each(function() {
				var twit_slider = $(this);	
				var slide = twit_slider.attr( "data-show" );
				twit_slider.easyTicker({
					direction: 'up',
					visible: parseInt(slide),
					easing: 'swing',
					interval: 4000
				});
			});
		}
		
		/* Menu Scroll */
		var cur_offset = 0;
		
		var o_stat = 0; // One Page Menu Status
		$( '.zoacres-main-menu li.menu-item, .zoacres-mobile-menu li.menu-item' ).each(function( index ) {
			var cur_item = this;
			var target = $(cur_item).children("a").attr("href");
			if( target && target.indexOf("#section-") != -1 ){
				o_stat = 1;
				var res = target.split("#");
				if( res.length == 2 ){
					$(cur_item).children("a").attr("data-target", res[0]);
					$(cur_item).children("a").attr("href", "#"+res[1]);
				}	
			}
		});
		
		if( o_stat ){
		
			if( $('.zoacres-main-menu .menu-item').find('a[href="#section-top"]').length ){
				$("body").attr("id","section-top");
			}
			
			$( '.zoacres-main-menu li.menu-item, .zoacres-mobile-menu li.menu-item' ).removeClass("current-menu-item");
			
			$(window).bind('scroll', function () {
				var minus_height = $("#wpadminbar").length ? $("#wpadminbar").outerHeight() : 0;
				minus_height += $(".zoacres-header .sticky-outer").length ? $(".zoacres-header .sticky-outer").outerHeight() : 0;
				minus_height += 10;
				$('.vc_row[id*="section-"], body').each(function () {
					var anchored = $(this).attr("id"),
						targetOffset = $(this).offset().top - minus_height;
						
					if ($(window).scrollTop() > targetOffset) {
						$('.zoacres-main-menu .menu-item').find("a").removeClass("active");
						$('.zoacres-main-menu .menu-item').find('a[href="#'+ anchored +'"]').addClass("active");
						
						//Mobile menu scroll spy active
						$('.zoacres-mobile-menu .menu-item').find("a").removeClass("active");
						$('.zoacres-mobile-menu .menu-item').find('a[href="#'+ anchored +'"]').addClass("active");
					}
				});
			});
			
			$( '.zoacres-main-menu .menu-item > a[href^="#section-"], .zoacres-mobile-main-menu .menu-item > a[href^="#section-"]' ).on('click',function (e) {
				
				var cur_item = this;
				var target = $(cur_item).attr("href");
				
				if( $(cur_item).parents(".zoacres-mobile-main-menu").length ) {
					$(".mobile-bar-toggle.close").trigger( "click" );
				}
				if( $( ".secondary-menu-area" ) ){
					$( ".secondary-menu-area .secondary-space-toggle.active" ).trigger( "click" );
				}
				
				var target_id = target.slice( target.indexOf("#"), ( target.length ) );
				var cur_url = location.protocol + '//' + location.host + location.pathname; //window.location.href;
				var data_targ = $(cur_item).attr("data-target");
				var another_page = false;
				if( target_id == '#section-top' && data_targ != '' ){
					if( cur_url != data_targ ){
						another_page = true;
					}
				}
				
				if( $( target_id ).length && !another_page ){
					var offs = $(target_id).offset().top;
					
					var hght_ele;
					if( $(".mobile-header").height() ){
						hght_ele = $(".mobile-header .sticky-head");
					}else {
						hght_ele = $(".zoacres-header .sticky-head");
					}
					
					var sticky_head_hgt = hght_ele.outerHeight();
					if( hght_ele.length ){
						offs = offs - parseInt( sticky_head_hgt );
					}
					if( $( "#wpadminbar" ).length ) offs = offs - parseInt( $( "#wpadminbar" ).outerHeight() );
					
					var sec_ani_call = 1;
					if( target_id == '#section-top' ){
						sec_ani_call = 1;
						offs = 0;
					}
					
					$('html,body').animate({ 'scrollTop': offs }, 1000, 'easeInOutExpo', function() {
						if( sticky_head_hgt != hght_ele.outerHeight() && sec_ani_call ){
							sec_ani_call = 0;
							var n_hgth = sticky_head_hgt - hght_ele.outerHeight();
							offs += n_hgth;
							$('html,body').animate({ 'scrollTop': offs }, 100, 'easeInOutExpo' );
						}
					 });
					return false;
				}else{
						if( target_id == '#section-top' && cur_url == data_targ ){
						$('html,body').animate({ 'scrollTop': 0 }, 1000, 'easeInOutExpo' );
						return false;
					}else{
						if( cur_url != data_targ && target_id != '#' ){
							window.location.href = data_targ + target;
						}else{
							window.location.href = target;
						}
					}
				}
			
			});		
			
		}
		
		/*Back to top*/
		if( $( ".back-to-top" ).length ){
			$( document ).on('click', '#back-to-top', function(){
				$('html,body').animate({ 'scrollTop': 0 }, 1000, 'easeInOutExpo' );
				return false;
			});
			$( document ).scroll(function() {
				var y = $( this ).scrollTop();
				if ( y > 300 )
					$( '#back-to-top' ).fadeIn();
				else
					$( '#back-to-top' ).fadeOut();
			});
		}
		
		/*Woo Cart Item Remove Through Ajax*/
		if( $('.mini-cart-items').length ){
			$( document ).on('click', '.remove-cart-item', function(){
				var product_id = $(this).attr("data-product_id");
				var loader_url = $(this).attr("data-url");
				var main_parent = $(this).parents('li.menu-item.dropdown');
				var parent_li = $(this).parents('li.cart-item');
				parent_li.find('.product-thumbnail > .remove-item-overlay').css({'display':'block'});
				$.ajax({
					type: 'post',
					dataType: 'json',
					url: zoacres_ajax_var.admin_ajax_url,
					data: { action: "zoacres_product_remove", 
							product_id: product_id
					},success: function(data){
						main_parent.html( data["mini_cart"] );
						$( document.body ).trigger( 'wc_fragment_refresh' );
						
						if( $(".mobile-header-items").find(".cart-bar-toggle").length ){
							var mini_cat_updt = $( data["mini_cart"] );
							var mobile_cart_txt = $(mini_cat_updt).find(".cart-contents").html();
							$(".mobile-header-items").find(".cart-bar-toggle").html(mobile_cart_txt);
						}
						
					},error: function(xhr, status, error) {
						$('.mini-cart-items').children('ul.cart-dropdown-menu').html('<li class="cart-item"><p class="cart-update-pbm text-center">'+ zoacres_ajax_var.cart_update_pbm +'</p></li>');
					}
				});
				return false;
			});	
		}
		
		/* Top Sliding Bar */
		if( $( ".top-sliding-bar" ).length ){
			$( document ).on('click', '.top-sliding-toggle', function(){
				$( ".top-sliding-bar-inner" ).slideToggle();
				$( ".top-sliding-toggle" ).toggleClass( "fa-minus" );
				return false;
			});
		}
		
		/* Sticky Header Space */
		if( $('.sticky-header-space').length ){
			var elem_pos = $('.sticky-header-space').hasClass('left-sticky') ? 'left' : 'right';
			var elem_width = $('.sticky-header-space').outerWidth();
			
			zoacresStickyHeaderAdjust(elem_pos, elem_width);
			$( window ).resize(function() {
				zoacresStickyHeaderAdjust(elem_pos, elem_width);
			});
		}
		
		/* Toggle Search Modal Triggers */
		if( $( ".textbox-search-toggle" ).length ){
			$( document ).on('click', '.textbox-search-toggle', function(){
				$(this).parents('.search-toggle-wrap').toggleClass('active');
				return false;
			});
		}else if( $( ".full-bar-search-toggle" ).length ){
			$( document ).on('click', '.full-bar-search-toggle', function(){
				$('.full-bar-search-wrap').toggleClass('active');
				return false;
			});
		}else if( $( ".bottom-search-toggle" ).length ){
			$( document ).on('click', '.bottom-search-toggle', function(){
				$(this).parents('.search-toggle-wrap').toggleClass('active');
				return false;
			});
		}
		
		/* Sticky Footer */
		if( $( ".footer-fixed" ).length ){
			if( $( window ).width() > 1023 ){
				$( ".zoacres-wrapper" ).css({ 'margin-bottom' : $( ".footer-fixed" ).outerHeight() + 'px' });
			}else{
				$( ".zoacres-wrapper" ).css({ 'margin-bottom' : '0' });
			}
		}else if( $( ".footer-bottom-fixed" ).length ){
			if( $( window ).width() > 1023 ){
				$( ".zoacres-wrapper" ).css({ 'margin-bottom' : $( ".footer-bottom-fixed" ).outerHeight() + 'px' });
			}else{
				$( ".zoacres-wrapper" ).css({ 'margin-bottom' : '0' });
			}
		}
		$( window ).resize(function() {
			if( $( ".footer-fixed" ).length ){
				if( $( window ).width() > 1023 ){
					$( ".zoacres-wrapper" ).css({ 'margin-bottom' : $( ".footer-fixed" ).outerHeight() + 'px' });
				}else{
					$( ".zoacres-wrapper" ).css({ 'margin-bottom' : '0' });
				}
			}else if( $( ".footer-bottom-fixed" ).length ){
				if( $( window ).width() > 1023 ){
					$( ".zoacres-wrapper" ).css({ 'margin-bottom' : $( ".footer-bottom-fixed" ).outerHeight() + 'px' });
				}else{
					$( ".zoacres-wrapper" ).css({ 'margin-bottom' : '0' });
				}
			}
		});							
		
		/* Stellar Parallax */
		$.stellar({
			horizontalScrolling: false,
			verticalOffset: 40
		});
		
		/* Bootstrap Tooltip */
		if( $('[data-toggle="tooltip"]').length ){
			$('[data-toggle="tooltip"]').tooltip();
		}
		
		/* Post Like */
		$( document ).on( 'click', ".post-like, .post-dislike", function( event) {
	
			var current = $(this);
			var like_stat = current.data("stat");
			var post_id = current.data("id");
			var parent = current.parents('.post-like-wrap');

			//return false;
			if( like_stat != '' ){
				
				if( like_stat == '1' ){
					parent.find('.post-disliked').removeClass('fa-thumbs-down post-disliked').addClass('fa-thumbs-o-down post-dislike');
					current.removeClass('fa-thumbs-o-up post-like').addClass('fa-thumbs-up post-liked');
				}else{
					parent.find('.post-liked').removeClass('fa-thumbs-up post-liked').addClass('fa-thumbs-o-up post-like');
					current.removeClass('fa-thumbs-o-down post-dislike').addClass('fa-thumbs-down post-disliked');
				}
				
				// Ajax call
				$.ajax({
					type: "post",
					url: zoacres_ajax_var.admin_ajax_url,
					data: "action=post_like_act&nonce="+zoacres_ajax_var.like_nonce+"&like_stat="+like_stat+"&post_id="+post_id,
					success: function(res){
						$( parent ).html(res);
						$('body').tooltip({
							container: 'body',
							trigger: 'hover',
							html: true,
							animation: false,
							selector: '[data-toggle="tooltip"]'
						});
					},
					error: function (jqXHR, exception) {
						console.log(jqXHR);
					}
				});
			}
			return false;
		});
		$( document ).on( 'click', ".post-liked, .post-disliked, .post-fav-done", function( event) {
			return false;
		});															 
																		 
		
		/* Post Favourite */
		$( document ).on( 'click', ".post-favourite", function( event) {
	
			var current = $(this);
			var post_id = current.data("id");
			var parent = current.parents('.post-fav-wrap');

			if( post_id != '' ){
				parent.find('.post-favourite').removeClass('fa-heart-o post-favourite').addClass('fa-heart');
				// Ajax call
				$.ajax({
					type: "post",
					url: zoacres_ajax_var.admin_ajax_url,
					data: "action=post_fav_act&nonce="+zoacres_ajax_var.fav_nonce+"&post_id="+post_id,
					success: function(res){
						$( parent ).html(res);
						$('body').tooltip({
							container: 'body',
							trigger: 'hover',
							html: true,
							animation: false,
							selector: '[data-toggle="tooltip"]'
						});
					},
					error: function (jqXHR, exception) {
						console.log(jqXHR);
					}
				});
			}
			return false;
		});

		/* Magnific Zoom Gallery Code */
		if( $('.zoom-gallery').length ){
			$( '.zoom-gallery' ).each(function( index ) {
				$(this).magnificPopup({
					delegate: 'a',
					type: 'image',
					closeOnContentClick: false,
					closeBtnInside: false,
					mainClass: 'mfp-with-zoom mfp-img-mobile',
					gallery: {
						enabled: true
					},
					zoom: {
						enabled: true,
						duration: 300, // don't foget to change the duration also in CSS
						opener: function(element) {
							return element.find('img');
						}
					}
				});
			});
		}
		
		if( $('.image-gallery').length ){
			$( '.image-gallery' ).each(function( index ) {
				$(this).magnificPopup({
					delegate: '.image-gallery-link',
					type: 'image',
					closeOnContentClick: false,
					closeBtnInside: false,
					mainClass: 'mfp-with-zoom mfp-img-mobile',
					gallery: {
						enabled: true
					},
				});
			});
		}
		
			
		/* Magnific Popup Code */
		if( $('.popup-video-post').length ){
			$( '.popup-video-post' ).each(function( index ) {
				$(this).magnificPopup({
					disableOn: 700,
					type: 'iframe',
					mainClass: 'mfp-fade',
					removalDelay: 160,
					preloader: false,
					fixedContentPos: false
				});
			});
		}
		
		if( $('.popup-with-zoom-anim').length ){
			$( '.popup-with-zoom-anim' ).each(function( index ) {
				$(this).magnificPopup({
					disableOn: 700,
					type: 'inline',
					mainClass: 'mfp-fade',
					removalDelay: 160,
					preloader: false,
					fixedContentPos: false,
					callbacks: {
					open: function() {
						// Play video on open:
						if( !$( this.content ).find('video').length ){
							var parent = $( this.content ).parent( "post-video-wrap" );
							var url = $( this.content ).find('span').data( "url" );
							var video = '<video width="100%" height="450" preload="true" style="max-width:100%;" autoplay="true"><source src="'+ url +'" type="video/mp4"></video>';
							$( this.content ).find('span').replaceWith( video );
							var video = $( this.content ).find('video');

						}else{
							$(this.content).find('video')[0].load();
						}
					},
					close: function() {
						// Reset video on close:
						$(this.content).find('video')[0].pause();
			
					}
				}
				});
			});
		}
		
		/* Set Blockquote Background */
		$( ".post-quote-wrap, .post-link-wrap" ).each(function() {
			var img_url = $(this).data('url');
			if( img_url ){
				$(this).css( 'background-image','url('+ img_url +')' );	
			}
		});
		
		/* Set Background Image */
		$( ".set-bg-img" ).each(function() {
			var img_url = $(this).data('src');
			if( img_url ){
				$(this).css( 'background-image','url('+ img_url +')' );	
			}
		});
		
		$(document).on( "click", "a.onclick-video-post", function(){

			var parent = $(this).parent('.post-video-wrap');
			var frame = '<iframe src="'+ $(this).attr("href") +'?autoplay=1" width="100%" height="'+ parent.height() +'" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
			$(this).fadeOut(300);
			$(this).replaceWith( frame );
			return false;
		});
		
		$(document).on( "click", ".onclick-custom-video", function(){
	
			var parent = $(this).parent('.post-video-wrap');
			var video = '<video width="100%" height="'+ parent.height() +'" preload="true" style="max-width:100%;" autoplay="true"><source src="'+ $(this).data("url") +'" type="video/mp4"></video>';
			$(this).fadeOut(300);
			$(this).replaceWith( video );

			return false;
			
		});
		
		/* Page Title Background Video */
		if( $( "#page-title-bg .page-title-wrap-inner" ).length ){
			$( "#page-title-bg .page-title-wrap-inner" ).YTPlayer();
		}
		
		/* Comments Like/Dislike */
		$( document ).on( 'click', ".fa-thumbs-o-up.comment-like, .fa-thumbs-o-down.comment-like", function( event) {
	
			var cmt_cur = $(this);
			var cmt_meta = cmt_cur.data('id');
			var cmt_id = cmt_cur.data('cmt-id');
			var parent = cmt_cur.parents('.comment-like-wrapper');
			if( cmt_meta == '1' ){
				cmt_cur.parents('.list-inline').find('.comment-liked').removeClass('fa-thumbs-down comment-liked').addClass('fa-thumbs-o-down comment-like');
				cmt_cur.removeClass('fa-thumbs-o-up comment-like').addClass('fa-thumbs-up comment-liked');
			}else{
				cmt_cur.parents('.list-inline').find('.comment-liked').removeClass('fa-thumbs-up comment-liked').addClass('fa-thumbs-o-up comment-like');
				cmt_cur.removeClass('fa-thumbs-o-down comment-like').addClass('fa-thumbs-down comment-liked');	
			}
			
			if( cmt_id != '' && cmt_meta != '' ){
				// Ajax call
				(jQuery).ajax({
					type: "post",
					url: zoacres_ajax_var.admin_ajax_url,
					data: "action=comment_like&nonce="+zoacres_ajax_var.cmt_nonce+"&cmt_id="+cmt_id+"&cmt_meta="+cmt_meta,
					success: function(res){
						$( parent ).html(res);
					},
					error: function (jqXHR, exception) {
						console.log(jqXHR);
					}
				});
			}
			return false;
		});
		
		/*Mailchimp Code*/
		if( $('.zozo-mc').length ){
			$('.zozo-mc').live( "click", function () {
				
				var c_btn = $(this);
				var mc_wrap = $( this ).parents('.mailchimp-wrapper');
				var mc_form = $( this ).parents('.zozo-mc-form');
				
				if( mc_form.find('input[name="zozo_mc_email"]').val() == '' ){
					mc_wrap.find('.mc-notice-msg').text( zoacres_ajax_var.must_fill );
				}else{
					c_btn.attr( "disabled", "disabled" );
					$.ajax({
						type: "POST",
						url: zoacres_ajax_var.admin_ajax_url,
						data: 'action=zozo-mc&nonce='+zoacres_ajax_var.mc_nounce+'&'+mc_form.serialize(),
						success: function (data) {
							//Success
							c_btn.removeAttr( "disabled" );
							if( data == 'success' || data == 'already' ){
								mc_wrap.find('.mc-notice-msg').text( mc_wrap.find('.mc-notice-group').attr('data-success') );
							}else{
								mc_wrap.find('.mc-notice-msg').text( mc_wrap.find('.mc-notice-group').attr('data-fail') );
							}
						},error: function(xhr, status, error) {
							c_btn.removeAttr( "disabled" );
							mc_wrap.find('.mc-notice-msg').text( mc_wrap.find('.mc-notice-group').attr('data-fail') );
						}
					});
				}
			});
		} // if mailchimp exists
		
		/* Facbook Comment Width Resize */
		if( $( '.fb-comments-wrapper' ).length ){
			$( window ).resize(function() {
				setTimeout(function(){
					if($( window ).width() <= 768 ){
						$( ".fb-comments-wrapper iframe" ).width( $( ".content-area" ).width() );
					}else{
						$( ".fb-comments-wrapper iframe" ).width( $( ".content-area .fb-comments" ).data('width') );
					}
				}, 200);
			});
		}
		
		if( $('#morg_compute').length ){
			$('#morg_compute').on("click", function() {
			
				var intPayPer  = 0;
				var intMthPay  = 0;
				var intMthInt  = 0;
				var intPerFin  = 0;
				var intAmtFin  = 0;
				var intIntRate = 0;
				var intAnnCost = 0;
				var intVal     = 0;
				var salePrice  = 0;

				salePrice = $('#sale_price').val();
				intPerFin = $('#percent_down').val() / 100;

				intAmtFin = salePrice - salePrice * intPerFin;
				intPayPer =  parseInt ($('#term_years').val(),10) * 12;
				intIntRate = parseFloat ($('#interest_rate').val(),10);
				intMthInt = intIntRate / (12 * 100);
				intVal = raisePower(1 + intMthInt, -intPayPer);
				intMthPay = intAmtFin * (intMthInt / (1 - intVal));
				intAnnCost = intMthPay * 12;

				$('#am_fin').html("<strong>"+zoacres_ajax_var.finance+"</strong><br> " + (Math.round(intAmtFin * 100)) / 100 + " ");
				$('#morgage_pay').html("<strong>"+zoacres_ajax_var.mortgage_pay+"</strong><br> " + (Math.round(intMthPay * 100)) / 100 + " ");
				$('#anual_pay').html("<strong>"+zoacres_ajax_var.cost_of_loan+"</strong><br> " + (Math.round(intAnnCost * 100)) / 100 + " ");
				$('#morg_results').show();
				$('.mortgage_calculator_div').css('height',532+'px');
			});
		}
		
		if( $('#zoacres-panorama').length ){
			var img_src = $('#zoacres-panorama').attr("data-src");
			pannellum.viewer('zoacres-panorama', {
				"type": "equirectangular",
				"panorama": img_src
			});
			$(".pnlm-load-button").trigger("click");
		}

	}); // doc ready end
	
	
	$( window ).load(function() {
		
		/* Grid Layout Set Width for Owl and Isotope */
		if( $( ".grid-layout.grid-normal" ).length ){
			$( ".grid-layout.grid-normal" ).each(function() {
			
				var c_elem = $( this );
				var parent_width = c_elem.width();
				var gutter_size = c_elem.data( "gutter" );
				var grid_cols = c_elem.data( "cols" );
				
				var net_width = Math.floor( ( parent_width - ( gutter_size * ( grid_cols - 1 ) ) ) / grid_cols );
				c_elem.find( "article" ).css({'width':net_width+'px', 'margin-bottom':gutter_size+'px'});
				
				c_elem.find( ".top-standard-post article" ).css({'width':'auto'});
			
			});	// each end		
		} // .grid-layout

		/* Media Element Js */
		if( $('video, audio').length ){
			$( "video, audio" ).each(function( index ) {

			});
		}

		/* Theme Owl Carousel Code */
		$( ".owl-carousel" ).each(function() {
			if( !$( this ).parents( ".isotope" ).length ){
				zoacresOwlSettings( $( this ) );
			}
		});
		
		//Property archive slick slide
		if( $('.property-archive-gallery').length ){
			var rtl = $( "body.rtl" ).length ? true : false;
			$('.property-archive-gallery').slick({
				dots: false,
				slidesToShow: 1,
				slidesToScroll: 1,
				rtl: rtl,
				prevArrow: "<i class='icon-arrow-left icons'></i>",
				nextArrow: "<i class='icon-arrow-right icons'></i>"
			});
		}
		
		/* Normal Grid Layout */
		if( $( ".grid-layout.grid-normal" ).length ){
			$( ".grid-layout.grid-normal" ).each(function() {
			
				var c_elem = $( this );
				var parent_width = c_elem.width();
				var gutter_size = c_elem.data( "gutter" );
				var grid_cols = c_elem.data( "cols" );
				
				if( $(window).width() < 768 ) grid_cols = 1;
				
				var net_width = Math.floor( ( parent_width - ( gutter_size * ( grid_cols - 1 ) ) ) / grid_cols );
				c_elem.find( "article" ).css({'width':net_width+'px', 'margin-right':gutter_size+'px', 'margin-bottom':gutter_size+'px'});
				c_elem.find(".grid-parent").css({ 'margin-right' : '-' + gutter_size + 'px' });
				
				c_elem.find( ".top-standard-post article" ).css({'width':'auto'});
				
				$( window ).resize(function() {

					setTimeout(function(){ 
			
						parent_width = c_elem.width();
						grid_cols = c_elem.data( "cols" );
						
						if( $(window).width() < 768 ) grid_cols = 1;
						
						net_width = Math.floor( ( parent_width - ( gutter_size * ( grid_cols - 1 ) ) ) / grid_cols );
						c_elem.find( "article" ).css({'width':net_width+'px', 'margin-right':gutter_size+'px', 'margin-bottom':gutter_size+'px'});
						
						c_elem.find( "audio, video" ).each(function( index ) {
							$( this )[0].play();
							$( this )[0].pause();
						});
								
					}, 200);
					
				});	
			});	// each end
		}
		
		/* Isotope Grid Layout */
		if( $( ".grid-layout > .isotope" ).length ){

			$( ".grid-layout > .isotope" ).each(function() {
			
				var c_elem = $( this );
				var parent_width = c_elem.width();
				var gutter_size = c_elem.data( "gutter" );
				var grid_cols = c_elem.data( "cols" );

				var layoutmode = c_elem.is('[data-layout]') ? c_elem.data( "layout" ) : '';
				
				layoutmode = layoutmode ? layoutmode : 'masonry';
				
				if( $(window).width() < 768 ) grid_cols = 1;
				
				var net_width = Math.floor( ( parent_width - ( gutter_size * ( grid_cols - 1 ) ) ) / grid_cols );
				c_elem.find( "article" ).css({'width':net_width+'px', 'margin-bottom':gutter_size+'px'});
				if( $( ".top-standard-post" ).length ){
					$( ".top-standard-post article" ).css({'margin-bottom':gutter_size+'px'});	
				}
				
				c_elem.find( ".owl-carousel" ).each(function() {
					zoacresOwlSettings( $( this ) );
				});
				
				c_elem.find( "audio" ).each(function( index ) {
				});
				
				c_elem.find( "video" ).each(function( index ) {
					$( this ).attr( "src", $( this ).find( "source" ).attr( "src" ) );
					$( this ).css({ 'height':'200px' });
				});
				
				var filter = "*";
				var isot_parent = c_elem.parent(".grid-layout");
				if( $( isot_parent ).attr("data-filter-stat") == 0 ){
					filter = $( isot_parent ).attr("data-first-cat") ? "." + $( isot_parent ).attr("data-first-cat") : '*';
				}
				
				c_elem.imagesLoaded( function(){
					c_elem.isotope({
						itemSelector: 'article',
						layoutMode: layoutmode,
						filter: filter,
						masonry: {
							gutter: gutter_size
						},
						fitRows: {
						  gutter: gutter_size
						}
					});
				});
				
				c_elem.children("article.post").addClass("show-opacity");
				
				/* Portfolio Filter Item */
				if( $(".portfolio-filter").length ){
					$( ".portfolio-filter-item" ).on( 'click', function() {
						$( this ).parents("ul.nav").find("li").removeClass("active");
						$( this ).parent("li").addClass("active");
						var filterValue = $( this ).attr( "data-filter" );
						c_elem = $( this ).parents( ".portfolio-wrapper" ).find( ".grid-layout .isotope" );
						c_elem.isotope({ 
							filter: filterValue
						});
						return false;
					});
				}

				$( window ).smartresize(function() {

					setTimeout(function(){ 
						grid_cols = c_elem.data( "cols" );
						if( $(window).width() < 768 ) grid_cols = 1;
						
						var parent_width = c_elem.width();
						net_width = Math.floor( ( parent_width - ( gutter_size * ( grid_cols - 1 ) ) ) / grid_cols );
						c_elem.find( "article" ).css({'width':net_width+'px'});
					}, 500);						
					setTimeout(function(){ 
						c_elem.imagesLoaded( function(){
							var $isot = c_elem.isotope({
								itemSelector: 'article',
								masonry: {
									gutter: gutter_size
								}
							});
							$isot.on( 'arrangeComplete', isotopeArrange );
						});
					}, 1000);
					
				});	
				
				// Isotope Grid Infinite
				if( c_elem.data( "infinite" ) == 1 && $(".post-pagination").length ){

					c_elem.infinitescroll({
						navSelector  : '.post-pagination',//'#page_nav',    // selector for the paged navigation 
						nextSelector : 'a.next-page',//'#page_nav a',  // selector for the NEXT link (to page 2)
						itemSelector : 'article',     // selector for all items you'll retrieve
						loading: {
							msgText : zoacres_ajax_var.load_posts,
							finishedMsg: zoacres_ajax_var.no_posts,
							img: zoacres_ajax_var.infinite_loader
						}
					},
					// call Isotope as a callback
					function( newElements ) {
						
						var elems = $(newElements);
						
						var net_width = Math.floor( ( parent_width - ( gutter_size * ( grid_cols - 1 ) ) ) / grid_cols );
						c_elem.find( "article" ).css({'width':net_width+'px', 'margin-bottom':gutter_size+'px'});
						if( $( ".top-standard-post" ).length ){
							$( ".top-standard-post article" ).css({'margin-bottom':gutter_size+'px'});	
						}
						
						c_elem.find( ".owl-carousel" ).each(function() {
							zoacresOwlSettings( $( this ) );
						});
						

						
						elems.find( "video" ).each(function( index ) {
							$( this ).attr( "src", $( this ).find( "source" ).attr( "src" ) );
							$( this ).css({ 'height':'200px' });

						});
						
						elems.imagesLoaded( function(){
							c_elem.isotope( 'appended', elems );
						});

					});
				}
			}); // each end
		}

		/* Related Slider Empty Post Image Height Set */
		if( $( ".related-slider .empty-post-image" ).length ){
			if( $( ".related-slider .item .wp-post-image" ).length ){
				$( ".related-slider .item .empty-post-image" ).height( $( ".related-slider .item .wp-post-image" ).height() );	
			}
		}
		
		/* Featured Slider Empty Post Image Height Set */
		if( $( ".featured-slider .empty-post-image" ).length ){
			if( $( ".featured-slider .item .wp-post-image" ).length ){
				$( ".featured-slider .item .empty-post-image" ).height( $( ".featured-slider .item .wp-post-image" ).height() );	
			}
		}
		
		/* Sticky Sidebar */
		var $sticky_sidebars = $( ".zoacres-sticky-obj" );
		if( $( window ).width() > 767 ) {
			$sticky_sidebars.stick_in_parent();
		}
		$( window ).resize(function() {
			if( $( window ).width() > 767 ) {
				$sticky_sidebars.trigger( "sticky_kit:detach" );	
				$sticky_sidebars.stick_in_parent();
				$sticky_sidebars.trigger( "sticky_kit:recalc" );
			}else{
				$sticky_sidebars.trigger( "sticky_kit:detach" );
			}
		});
		
		/* Counter Script */
		var counterUp = $( ".counter-up" );
		counterUp.appear(function() {
			var $this = $(this),
			countTo = $this.attr( "data-count" );
			$({ countNum: $this.text()}).animate({
					countNum: countTo
				},
				{
				duration: 1000,
				easing: 'linear',
				step: function() {
					$this.text( Math.floor( this.countNum ) );
				},
				complete: function() {
					$this.text( this.countNum );
				}
			});  
		});
		

		/* Circle Counter Shortcode Script */
		if( $( '.circle-progress-circle' ).length ){
			var circle = $( '.circle-progress-circle' );
			circle.appear(function() {
							  
				var c_circle = $( this );
				var c_value = c_circle.attr( "data-value" );
				var c_size = c_circle.attr( "data-size" );
				var c_thickness = c_circle.attr( "data-thickness" );
				var c_duration = c_circle.attr( "data-duration" );
				var c_empty = c_circle.attr( "data-empty" ) != '' ? c_circle.attr( "data-empty" ) : 'transparent';
				var c_scolor = c_circle.attr( "data-scolor" );
				var c_ecolor = c_circle.attr( "data-ecolor" ) != '' ? c_circle.attr( "data-ecolor" ) : c_scolor;
									
				c_circle.circleProgress({
					value: Math.floor( c_value ) / 100,
					size: Math.floor( c_size ),
					thickness: Math.floor( c_thickness ),
					emptyFill: c_empty,
					animation: {
						duration: Math.floor( c_duration )
					},
					lineCap: 'round',
					fill: {
						gradient: [c_scolor, c_ecolor]
					}
				}).on( 'circle-animation-progress', function( event, progress ) {
					$( this ).find( '.progress-value' ).html( Math.round( c_value * progress ) + '%' );
				});
			});
		}
		
		/* Day Counter Shortcode Script */
		if( $( '.day-counter' ).length ){
			$( '.day-counter' ).each(function() {
				var day_counter = $( this );
				var c_date = day_counter.attr('data-date');
				day_counter.countdown( c_date, function(event) {
					if( day_counter.find('.counter-day').length ){
						day_counter.find('.counter-day h3').text( event.strftime('%D') );
					}
					if( day_counter.find('.counter-hour').length ){
						day_counter.find('.counter-hour h3').text( event.strftime('%H') );
					}
					if( day_counter.find('.counter-min').length ){
						day_counter.find('.counter-min h3').text( event.strftime('%M') );
					}
					if( day_counter.find('.counter-sec').length ){
						day_counter.find('.counter-sec h3').text( event.strftime('%S') );
					}
					if( day_counter.find('.counter-week').length ){
						day_counter.find('.counter-week h3').text( event.strftime('%w') );
					}
				});
			});
		}
		
		/* Page Load Modal Script */
		if( $('.modal-popup-wrapper.page-load-modal').length ){
			var modal_id = $('.modal-popup-wrapper.page-load-modal .modal').attr("id");
			$('#'+modal_id).modal('show');
		}
		
		/* Canvas Shapes */
		if( $(".canvas_agon").length ){
			$( '.canvas_agon' ).each(function() {
				zoacresAgon( $(this) );
			});
		}
		
		if( $(".post-pagination-wrap").length ){
			$(".post-pagination-wrap").addClass("show-opacity");
		}
		
		/* Rain Drops */
		if( $(".section-rain-drops").length ){
			$(".section-rain-drops").raindrops({ color: zoacres_ajax_var.theme_color, positionBottom: "100%", canvasHeight: 70  });
		}

	});
	
	var win_width = $(window).width();
	
	// Using window smartresize instead of resize function
	$( window ).smartresize(function() {
		
		/* Mobile Bar Toggle  */
		if( win_width != $(window).width() ){
			win_width = $(window).width();
			setTimeout( function(){ $(".mobile-bar.active").length ?  $( ".mobile-header .mobile-bar-toggle" ).trigger( "click" ) : ''; }, 100 );
		}
				
		/* Pull Center Reset  */
		setTimeout( zoacresCenterMenuMargin, 300 );
		
		/* Sticky Menu */
		if($('.header-inner .sticky-head').length){
			setTimeout( zoacresStickyPart( '.header-inner' ), 100 ); 
		}
		
		/* Scroll Sticky */
		if($('.header-inner .sticky-scroll').length){
			setTimeout( zoacresStickyScrollUpPart( '.header-inner', 'header' ), 100 ); 
		}
		
		/* Mobile Header Sticky Menu */
		if($('.mobile-header-inner .sticky-head').length){
			setTimeout( zoacresStickyPart( '.mobile-header-inner' ), 100 ); 
		}
		
		/* Mobile Header Scroll Sticky */
		if($('.mobile-header-inner .sticky-scroll').length){
			setTimeout( zoacresStickyScrollUpPart( '.mobile-header-inner', '.mobile-header' ), 100 ); 
		}
		
	});
	

	$( window ).load(function() {
		if( $(".owl-carousel.skrollable").length ){
			setTimeout(function(){ skrollr.get().refresh(); }, 300);
		}
	});
	
	function raisePower(x, y) {
		return Math.pow(x, y);
	} 
	
	
	function isotopeArrange() {
		$( ".grid-layout > .isotope" ).find( "audio, video" ).each(function( index ) {
			$( this )[0].play();
			$( this )[0].pause();
		});
	}
	
	function zoacresStickyHeaderAdjust(elem_pos, elem_width){
		var win_width = $(window).width();
		var compare_wdth;
		if( $('.zoacres-header .header-inner.hidden-md-land-down' ).length ){
			compare_wdth = 1024;
		}else{
			compare_wdth = 991;
		}
		if( win_width <= compare_wdth ){
			if( elem_pos == 'left' ){
				$('.sticky-header-space').css( 'left', '-'+ elem_width +'px' );
				$('body, .top-sliding-bar').css( 'padding-left', '0' );
			}else{
				$('.sticky-header-space').css( 'right', '-'+ elem_width +'px' );
				$('body, .top-sliding-bar').css( 'padding-right', '0' );
			}
		}else{
			if( elem_pos == 'left' ){
				$('.sticky-header-space').css( 'left', 0 );
				$('body, .top-sliding-bar').css( 'padding-left', elem_width +'px' );
			}else{
				$('.sticky-header-space').css( 'right', 0 );
				$('body, .top-sliding-bar').css( 'padding-right', elem_width +'px' );
			}	
		}	
	}

	function zoacresCenterMenuMargin(){
		//Center item margin fixing
		$.each([ 'topbar', 'logobar', 'navbar', 'mobile-header', 'footer-bottom' ], function( index, margin_key ) {
			
			var left_width = 0,
				right_width = 0,
				center_width = 0,
				margin_left = 0,
				parent_width = 0;

			if( $('.'+ margin_key +' .'+ margin_key +'-inner').length ){
			
				if( margin_key == 'mobile-header' )
					parent_width = $('.'+ margin_key +' .'+ margin_key +'-inner .container').width();
				else
					parent_width = $('.'+ margin_key +' .'+ margin_key +'-inner').width();
				
				if( $('.'+ margin_key +' .'+ margin_key +'-inner .'+ margin_key +'-items.pull-left').length ){
					left_width = $('.'+ margin_key +' .'+ margin_key +'-inner .'+ margin_key +'-items.pull-left').width();
				}
				if( $('.'+ margin_key +' .'+ margin_key +'-inner .'+ margin_key +'-items.pull-right').length ){
					right_width = $('.'+ margin_key +' .'+ margin_key +'-inner .'+ margin_key +'-items.pull-right').width();
				}
				if( $('.'+ margin_key +' .'+ margin_key +'-inner .'+ margin_key +'-items.pull-center').length ){
					center_width = $('.'+ margin_key +' .'+ margin_key +'-inner .'+ margin_key +'-items.pull-center').width();
				}
					
				if( left_width + center_width + right_width ){
				
					if( margin_key == 'mobile-header' ){
						parent_width -= ( left_width + center_width + right_width );
						margin_left = parent_width / 2; 
					}else{
						parent_width = ( parent_width / 2 ) - ( center_width / 2 );
						margin_left = Math.floor( parent_width - left_width );
					}
					
					if( !$( "body.rtl" ).length ){
						$('.'+ margin_key +' .'+ margin_key +'-inner .'+ margin_key +'-items.pull-center').css( 'margin-left', margin_left+'px' );
					}else{
						$('.'+ margin_key +' .'+ margin_key +'-inner .'+ margin_key +'-items.pull-center').css( 'margin-right', margin_left+'px' );
					}
					
					$('.'+ margin_key +' .'+ margin_key +'-inner .'+ margin_key +'-items.pull-center').addClass("show-opacity");
					
				}
			}
		});
	}
	
	function zoacresStickyPart( main_class ){

		var outer_class = '.sticky-outer';	
		var lastScrollTop = 0;
		var header_top = 0;

		$(main_class + ' ' + outer_class).css( 'height', $(main_class + ' ' + outer_class).data( "height" ) );
		header_top = $(main_class + ' ' + outer_class).offset().top;

		$(window).scroll(function(event){
			
			var st = $(this).scrollTop();
			if( st > header_top ){
				$(main_class + ' .sticky-head').addClass('header-sticky');
			}else{
				$(main_class + ' .sticky-head').removeClass('header-sticky');
			}
			
			if( st == 0 ){
				$(main_class + ' .sticky-head').removeClass('header-sticky');
			}
			
			lastScrollTop = st;
		});	
	}
	
	function zoacresStickyScrollUpPart( main_class, sticky_div ){
		
		var outer_class = '.sticky-outer';	
		var out_height = '';
		var lastScrollTop = 0;
		var header_top = 0;
	
		$(main_class + ' ' + outer_class).css( 'height', $(main_class + ' ' + outer_class).data( "height" ) );
		out_height = '-' + $(main_class + ' ' + outer_class).outerHeight() + 'px';
		header_top = $(main_class + ' ' + outer_class).offset().top;
		sticky_div = $(sticky_div).height();
		
		$(window).scroll(function(event){

			var st = $(this).scrollTop();
			
			if( st < lastScrollTop && header_top < lastScrollTop ){
				// upscroll code
				$(main_class + ' .sticky-scroll').addClass('show-menu');
				$(main_class + ' .sticky-scroll.show-menu').css({'transform': 'translate3d(0px, 0px, 0px)'});
			}else{
				// downscroll code
				if( st < sticky_div ){
					$(main_class + ' .sticky-scroll').css({'transform': ''});
					$(main_class + ' .sticky-scroll.show-menu').removeClass('show-menu');
				}else{
					$(main_class + ' .sticky-scroll').css({'transform': 'translate3d(0px, '+ out_height +', 0px)'});
				}
			}
			
			if( st == 0 ){
				$(main_class + ' .sticky-scroll').css({'transform': ''});
				$(main_class + ' .sticky-scroll.show-menu').removeClass('show-menu');
			}
			
			lastScrollTop = st;
		});
		
	}
	
	function zoacresSetStickyOuterHeight(){
		$( ".sticky-outer" ).each(function() {

			var class_name = '';
			if( $( this ).parent( "div" ).hasClass( "mobile-header-inner" ) ){
				class_name = $( this ).parent( "div" ).attr("class");
				$( this ).parent( "div" ).attr("class", "");
			}
			
			if( $( this ).parent( "div" ).is('[class*=hidden-]') ){
				class_name = $( this ).parent( "div" ).attr("class");
				$( this ).parent( "div" ).attr("class", "");
			}
			
			$( this ).css({ 'position':'absolute', 'visibility':'hidden', 'display':'block', 'height':'auto' });
			$( this ).attr( "data-height", $( this ).outerHeight() );

			if( class_name != '' ){
				$( this ).parent( "div" ).attr("class", class_name);
			}
			$( this ).css({ 'position':'', 'visibility':'', 'display':'', 'height': $( this ).data( "height" ) });

		});
	}
	
	function zoacresAgon( canvas_ele ){
		var canvas = document.getElementById("canvas_agon");
		var cxt = canvas.getContext("2d");
		var agon_size = canvas_ele.attr( "data-size" );
		var agon_side = canvas_ele.attr( "data-side" );
		var div_val = 1;

		switch( parseInt( agon_side ) ){
			case 3:
				div_val = 6;
			break;
			case 4:
				div_val = 4;
			break;
			case 5:
				div_val = 3.3;
			break;
			case 6:
				div_val = 3;
			break;
			case 7:
				div_val = 2.8;
			break;
			case 8:
				div_val = 2.7;
			break;
			case 9:
				div_val = 2.6;
			break;
			case 10:
				div_val = 2.5;
			break;
		}

		// hexagon
		var numberOfSides = parseInt( agon_side ),
			size = parseInt( agon_size ),
			Xcenter = parseInt( agon_size ),
			Ycenter = parseInt( agon_size ),
			step  = 2 * Math.PI / numberOfSides,//Precalculate step value
			shift = (Math.PI / div_val);//(Math.PI / 180.0);// * 44;//Quick fix ;)

		cxt.beginPath();

		for (var i = 0; i <= numberOfSides;i++) {
			var curStep = i * step + shift;
		   cxt.lineTo (Xcenter + size * Math.cos(curStep), Ycenter + size * Math.sin(curStep));
		}

		/* Direct Output */
		cxt.fillStyle = '#333';
		cxt.fill();
	}
	
	function zoacresOwlSettings(c_owlCarousel){
		// Data Properties
		var loop = c_owlCarousel.data( "loop" );
		var margin = c_owlCarousel.data( "margin" );
		var center = c_owlCarousel.data( "center" );
		var nav = c_owlCarousel.data( "nav" );
		var dots_ = c_owlCarousel.data( "dots" );
		var items = c_owlCarousel.data( "items" );
		var items_tab = c_owlCarousel.data( "items-tab" );
		var items_mob = c_owlCarousel.data( "items-mob" );
		var duration = c_owlCarousel.data( "duration" );
		var smartspeed = c_owlCarousel.data( "smartspeed" );
		var scrollby = c_owlCarousel.data( "scrollby" );
		var autoheight = c_owlCarousel.data( "autoheight" );
		var autoplay = c_owlCarousel.data( "autoplay" );
		var rtl = $( "body.rtl" ).length ? true : false;

		$( c_owlCarousel ).owlCarousel({
			rtl : rtl,
			loop	: loop,
			autoplayTimeout	: duration,
			smartSpeed	: smartspeed,
			center: center,
			margin	: margin,
			nav		: nav,
			dots	: dots_,
			autoplay	: autoplay,
			autoheight	: autoheight,
			slideBy		: scrollby,
			responsive:{
				0:{
					items: items_mob
				},
				544:{
					items: items_tab
				},
				992:{
					items: items
				}
			},
			navText : ["<i class='icon-arrow-left icons'></i>","<i class='icon-arrow-right icons'></i>"]
		});	
	}
	
	
	
	function hideAllInfoWindows(markers, map) {
		markers.forEach(function(marker) {
			marker.infowindow.close(map, marker);
		}); 
	}
	function normalIcon() {
      return {
        url: 'http://localhost/zoacres/wp-content/uploads/2018/02/Map_marker.png'
      };
    }
    function highlightedIcon() {
      return {
        url: 'http://localhost/zoacres/wp-content/uploads/2018/02/Map_marker_1.png'
      };
    }

})( jQuery );
