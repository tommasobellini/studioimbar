/*
 * Zoacres Functional JS
 */ 

(function( $ ) {

	"use strict";
		  
	$( document ).ready(function() {
		
		//Area filter function
		$( ".all-areas-search .bts-select-menu" ).on( "filter", function( event, city_id ) {
		
			var filr_ul = $(this);
			filr_ul.parents(".all-areas-search").children(".bts-select-toggle").html(zoacres_ajax_var.all_areas);
			filr_ul.html('<li><img src="'+ zoacres_ajax_var.search_load +'" /></li>');

			var filter_data = {
				'action' : 'filter-area',
				'nonce' : zoacres_ajax_var.filter_area,
				'filter_city_id' : city_id
			};
			
			$.ajax({
				type: "post",
				url: zoacres_ajax_var.admin_ajax_url,
				dataType: 'JSON',				
				data: filter_data,
				success: function (data) {
					var area_res = data["area_json"];
					
					if( area_res ){
						filr_ul.html( area_res );
					}else{
						filr_ul.html('<li>'+ zoacres_ajax_var.all_areas +'</li>');
					}
					
				},error: function(xhr, status, error) {
					filr_ul.html('<li>'+ zoacres_ajax_var.try_again +'</li>');
				}
			});
			
		});
		 
		//Area filter event
		$( document ).on( "click", ".advance-search-wrap .all-cities-search .bts-select-menu li", function() {
			var filr_srch = $(this);
			var city_id = filr_srch.data('id') ? filr_srch.data('id') : '';
			$( ".all-areas-search .bts-select-menu" ).trigger( "filter", [ city_id ] );
		});

		//City filter function
		$( ".all-cities-search .bts-select-menu" ).on( "filter", function( event, state_id ) {
		
			var filr_ul = $(this);
			filr_ul.parents(".all-cities-search").children(".bts-select-toggle").html(zoacres_ajax_var.all_cities);
			filr_ul.html('<li><img src="'+ zoacres_ajax_var.search_load +'" /></li>');
			
			var filter_data = {
				'action' : 'filter-city',
				'nonce' : zoacres_ajax_var.adv_search,
				'filter_state_id' : state_id
			};

			$.ajax({
				type: "post",
				url: zoacres_ajax_var.admin_ajax_url,
				dataType: 'JSON',				
				data: filter_data,
				success: function (data) {
					var city_res = data["city_json"];
					
					if( city_res ){
						filr_ul.html( city_res );
					}else{
						filr_ul.html('<li>'+ zoacres_ajax_var.all_cities +'</li>');
					}
					
				},error: function(xhr, status, error) {
					filr_ul.html('<li>'+ zoacres_ajax_var.try_again +'</li>');
				}
			});
			
		});
		 
		//City filter event
		$( document ).on( "click", ".advance-search-wrap .all-state-search .bts-select-menu li", function() {
			var filr_srch = $(this);
			var state_id = filr_srch.data('id') ? filr_srch.data('id') : '';
			$( ".all-cities-search .bts-select-menu" ).trigger( "filter", [ state_id ] );
		});
		
		//Advance search drop down label
		if( $( ".bts-select-dropdown" ).length ){
			$( document ).on( "click", ".advance-search-wrap .bts-select-menu li", function() {
				var cur = $(this);
				cur.parents(".bts-select").children(".bts-select-toggle").html(cur.text());

				var hid = cur.parents(".bts-select").find(".search-hidd-id");
				var sid = cur.attr("data-id") ? cur.attr("data-id") : 'all';
				if( cur.parents(".all-cities-search").length ){
					$(".search-area-id").val( "all" );
				}
				hid.val(sid);
				
				if( !$(this).parents(".search-form-redirect").length || $(this).parents(".search-form-part-redirect").length ){
					if( $( ".map-property-list" ).length ){
						zoacresPropertySearch("property", cur);
					}
					if( $( ".zoacres-property-map" ).length ){
						zoacresPropertySearch("map", cur);
					}
				}
				
			});

		}
		
		//Half map ajax search
		if( $( ".bts-ajax-search .ajax-search-box:not(.ajax-key-search)" ).length ){

			var typingTimer;                //timer identifier
			var doneTypingInterval = 600;  //time in ms, 5 second for example
			var input_box = $( ".bts-ajax-search .ajax-search-box:not(.half-map-ajax-box)" );
			var input_box = $( ".bts-ajax-search .ajax-search-box.half-map-ajax-box" );
			
			input_box.on('keyup', function ( e ) {
				clearTimeout(typingTimer);
				typingTimer = setTimeout( doneHalfMapSearch, doneTypingInterval, e, this );
			});
			
			input_box.on('keydown', function ( e ) {
				clearTimeout( typingTimer );
			});

		}
		
		if( $( "#property-customer-schedule-date" ).length ){
			$("#property-customer-schedule-date").datepicker({
				dateFormat: 'yy-mm-dd'
			});
		}
		
		//Ajax Keyword search
		if( $( ".bts-ajax-search .ajax-search-box.ajax-key-search" ).length ){
					
			var typingTimer;                //timer identifier
			var doneTypingInterval = 600;  //time in ms, 5 second for example
			//var input_box = $( ".bts-ajax-search .ajax-search-box:not(.half-map-ajax-box)" );
			var input_box = $( ".bts-ajax-search .ajax-search-box.ajax-key-search" );

			input_box.on('keyup', function ( e ) {
				clearTimeout(typingTimer);
				typingTimer = setTimeout( doneKeySearch, doneTypingInterval, e, this );
			});
			
			input_box.on('keydown', function ( e ) {
				clearTimeout( typingTimer );
			});
			
			// Property  load more
			$( document ).on( "click", ".ajax-search-more", function( e ) {
				
				var ele = $(this);
				var paged = ele.data("page");		
						
				var key_val = ele.parents(".advance-search-wrap").find(".ajax-search-box").val();
				var srch_dropdown = ele.parents(".ajax-search-dropdown").children(".property-search-list");

				if( key_val ){
					
					var more_parent = ele.parent(".ajax-search-more-wrap");
					more_parent.html('<img class="property-loader" src="'+ zoacres_ajax_var.search_load +'" />');
			
					var search_data = {
						'action' : 'key_search',
						'nonce' : zoacres_ajax_var.key_search,
						'key_val' : key_val,
						'paged'	: 	paged
					};
					
					$.ajax({
						type: "post",
						url: zoacres_ajax_var.admin_ajax_url,
						dataType: 'JSON',				
						data: search_data,
						success: function (data) {
							var prop_res = data["property_json"];
							more_parent.remove();
							if( prop_res ){
								srch_dropdown.append( prop_res );
							}else{
								srch_dropdown.append('<li>'+ zoacres_ajax_var.prop_not_found +'</li>');
							}
							
						},error: function(xhr, status, error) {
							srch_dropdown.append('<li>'+ zoacres_ajax_var.try_again +'</li>');
						}
					});
				}

				return false;
				
			});

			// Hide property drop down when mouse click outer
			$(document).mouseup(function(e){
			
				var search_wrap = $(".advance-search-wrap");

				if (!search_wrap.is(e.target) && search_wrap.has(e.target).length === 0){
					search_wrap.find(".ajax-search-dropdown").removeClass("show");
				}
				
			});
			
		}
		
		if( $( ".advance-search-wrap .expand-advance-search" ).length ){
			$( document ).on( "click", ".advance-search-wrap .expand-advance-search", function() {
				var collapse_btn = $(this);
				setTimeout(function(){
					if( collapse_btn.attr("aria-expanded") == "true" ){
						collapse_btn.children("i").addClass("icon-size-actual").removeClass("icon-size-fullscreen");					
					}else{
						collapse_btn.children("i").addClass("icon-size-fullscreen").removeClass("icon-size-actual");
					}
				}, 500);
			});
		}

		$( document ).on( "click", ".ajax-search-trigger", function() {		
			if( $(this).parents(".search-form-redirect").length ){
				var red_url = $(this).parents(".search-form-redirect").data("search-url");
				
				var state_id = $(".search-state-id").length ? $(".search-state-id").val() : '';
				var prop_name = $(".ajax-search-box").length ? $(".ajax-search-box").val() : '';
				var city_id = $(".search-city-id").length ? $(".search-city-id").val() : '';
				var area_id = $(".search-area-id").length ? $(".search-area-id").val() : '';
				var type_id = $(".search-type-id").length ? $(".search-type-id").val() : '';
				var action_id = $(".search-action-id").length ? $(".search-action-id").val() : '';
				var rooms_id = $(".search-rooms-id").length ? $(".search-rooms-id").val() : '';
				var bed_id = $(".search-bed-id").length ? $(".search-bed-id").val() : '';
				var bath_id = $(".search-baths-id").length ? $(".search-baths-id").val() : '';
				var minarea_id = $(".search-minarea-id").length ? $(".search-minarea-id").val() : '';
				var maxarea_id = $(".search-maxarea-id").length ? $(".search-maxarea-id").val() : '';
				var price_min = $(".slider-range-amount").length ? $(".slider-range-amount").attr("data-from") : '';
				var price_max = $(".slider-range-amount").length ? $(".slider-range-amount").attr("data-to") : '';
				
				var prop_features = [];
				$.each($("input[name='property_more_features[]']:checked"), function(){            
					prop_features.push($(this).val());
				});
				var prop_features_list = prop_features.join(",");
				
				red_url = red_url + "?state_id="+ state_id +"&prop_name="+ prop_name +"&city_id="+ city_id +"&area_id="+ area_id +"&type_id="+ type_id +"&action_id="+ action_id +"&rooms_id="+ rooms_id +"&bed_id="+ bed_id +"&bath_id="+ bath_id +"&price_min="+ price_min +"&price_max="+ price_max +"&minarea_id="+ minarea_id +"&maxarea_id="+ maxarea_id +"&features="+ prop_features_list;
				
				location.href = red_url;
			}else{
				if( $( ".map-property-list" ).length ){
					zoacresPropertySearch("property", $(this));
				}
				if( $( ".zoacres-property-map" ).length ){
					zoacresPropertySearch("map", $(this));
				}
			}
		});
		
		//Advanced search box fill GET values
		if( $( ".search-template-actived" ).length ){
			$( ".bts-select" ).each(function( index ) {
				var hid_val = $(this).children(".search-hidd-id").val();
				if( hid_val ){
					var hid_sel_ele = $(this).find('ul.bts-select-menu > li[data-id="'+ hid_val +'"]');
					var attr_val = hid_sel_ele.attr("data-id");
					if( attr_val ){
						$(this).find(".bts-select-toggle").text( hid_sel_ele.text() );
					}
				}
			});
		}
		
		//Property layout click
		if( $( ".property-layouts-nav .property-layouts-trigger" ).length ){
			$( document ).on( "click", ".property-layouts-nav .property-layouts-trigger", function() {
				var cur_lay = $(this);
				var prop_lay = cur_lay.data("layout");
				cur_lay.parents( ".property-list-identity, .zoacres-search-property-wrap" ).find(".map-property-list").attr( "data-layout", prop_lay );
				if( cur_lay.parents(".advance-search-wrap").find(".advance-search-bottom .ajax-search-trigger").length ){
					cur_lay.parents(".advance-search-wrap").find(".advance-search-bottom .ajax-search-trigger").trigger("click");
				}else{
					cur_lay.parents(".advance-search-wrap").find(".ajax-search-trigger").trigger("click");
				}				
				//$( ".ajax-search-trigger" ).trigger("click");
				return false;
			});
		}
		
		//Property contact form submit
		$( ".property-contact-submit" ).on("click", function() {
			var name = $("#property-customer-name").val();
			var email = $("#property-customer-email").val();
			var phone = $("#property-customer-tele").val();
			
			var sts = 0;
			if( !zoacresEmptyCheck( name ) ){
				$(".validatation-status").html(zoacres_ajax_var.name_required);
				sts = 1;
			}else if( !zoacresValidateEmail( email ) ){
				$(".validatation-status").html(zoacres_ajax_var.email_required);
				sts = 1;
			}else if( !zoacresValidatePhone( phone ) ){
				$(".validatation-status").html(zoacres_ajax_var.phone_required);
				sts = 1;
			}else{
				$(".validatation-status").html('');
			}
			
			if( sts ){
				$(".validatation-status").addClass("show");
				return false;
			}else{
				$(".validatation-status").removeClass("show");
			}
			
			var contact_data = 'action=agent_contact_form&nonce='+ zoacres_ajax_var.agent_nounce +"&"+ $("#agent-contact-form").serialize();
			var sub_btn = $(this);
			sub_btn.addClass("processing");
			
			$.ajax({
				type: "post",
				url: zoacres_ajax_var.admin_ajax_url,
				dataType: 'JSON',				
				data: contact_data,
				success: function (data) {
					var mail_res = data["res_json"];
					$(".validatation-status").html( mail_res );
					$(".validatation-status").addClass("show");
					sub_btn.removeClass("processing");
				},error: function(xhr, status, error) {
					console.log( xhr );
					sub_btn.removeClass("processing");
				}
			});
			
			return false;
		});

		//Property compare
		$( document ).on( "click", ".prop-compare", function() {
			var cur_comp = $(this);
			cur_comp.addClass("compared");
			
			var pid = cur_comp.attr("data-id");
			var pimg = cur_comp.attr("data-img");
			
			if( ! $(document).find( ".property-compare-container" ).length ){
				$("body").append( '<div class="property-compare-container"><span class="compare-toggle icon-equalizer"></span><div class="property-compare-inner"><div class="compare-properties text-center"><ul class="nav compare-list"></ul><p><span class="prop-msg-box"></span><a href="#" class="btn compare-modal-trigger">'+ zoacres_ajax_var.prop_compare +'</a></p></div></div></div>' );
			}
			if( ! $(document).find( ".property-compare-container #compare_" + pid ).length ){
				var p_cont = '<li id="compare_'+ pid +'" class="nav-item" data-id="'+ pid +'"><span class="compare-prop-remove"><i class="icon-close"></i></span><img src="'+ pimg +'" /></li>';
				
				$(document).find(".property-compare-container .nav.compare-list").append(p_cont);
				
				if( $(document).find( ".property-compare-container" ).find( "li.nav-item" ).length ){
					$(document).find( ".property-compare-container" ).fadeIn(300);
				}			
				
			}
			$(document).find( ".property-compare-container .prop-msg-box" ).text("");
			return false;
		});
		
		//Property compare container toggle
		$( document ).on( "click", ".compare-toggle", function() {
			var comp_togl = $(this);
			comp_togl.parents(".property-compare-container").toggleClass("active");
			return false;
		});
		
		//Property compare remove
		$( document ).on( "click", ".compare-prop-remove", function() {
			var prop = $(this);
			if( $(document).find( ".property-compare-container" ).find( "li.nav-item" ).length == 1 ){
				$(document).find( ".property-compare-container" ).fadeOut(0);
			}
			prop.parents("li.nav-item").remove();
			return false;
		});
		
		//Property anything set by bg
		if( $(".set-by-bg-img").length ){
			$( ".set-by-bg-img" ).each(function( index ) {
				if( $(this).attr("data-bg-img") ){
					$(this).css({'background-image':'url('+ $(this).attr("data-bg-img") +')'});
				}
			});
		}
		
		//Property compare modal box trigger
		$( document ).on( "click", ".compare-modal-trigger", function() {
			var comp_prop = $(this);
			if( $(document).find( ".property-compare-container" ).find( "li.nav-item" ).length >= 2 ){
				//Ajax Modal Box Code
				
				$(this).addClass("disabled");
				
				var prop_ids = [];
				var i = 0;
				$(document).find( ".property-compare-container li.nav-item" ).each(function( index ) {
					prop_ids[i++] = $(this).attr("data-id");
				});
				$.ajax({
					type: 'post',
					dataType: 'json',
					url: zoacres_ajax_var.admin_ajax_url,
					data: { action: "zproduct_compare", 
							"nonce": zoacres_ajax_var.property_compare,
							"compare_ids": prop_ids
					},success: function(data){
						
						if( $(document).find('#property-compare-modal').length ){
							$(document).find('#property-compare-modal').remove();
						}
						$('body').addClass("property-modal-actived");
						$('body').append( data["result"] );
						$(document).find('#property-compare-modal').addClass('show');
						$(document).find('#property-compare-modal').fadeIn(300);
					},error: function(xhr, status, error) {
						console.log( xhr );
					}
				});
				
			}else{
				$(document).find( ".property-compare-container .prop-msg-box" ).text( zoacres_ajax_var.prop_compare_msg );
			}
			return false;
		});

		//Property compare modal box close
		$( document ).on( "click", ".property-modal-inner .close", function() {
			$(document).find( "#property-compare-modal" ).fadeOut(300).remove();
			$('body').removeClass("property-modal-actived");
			$(document).find( ".property-compare-container .compare-modal-trigger" ).removeClass("disabled");
			return false;
		});
		
		//Property txonomy page title bg image
		if( $(".page-title-bg-img").length ){
			$('.page-title-bg-img').each( function() {
				var img_url = $(this).data("img");
				if( img_url ){
					$(this).css({ 'background-image' : 'url('+ img_url +')' });
				}
			});
		}		
		
		//Property favourite
		$( document ).on( "click", ".property-favourite .property-fav", function() {
			if( !$("body.logged-in").length ){
				//Login/Register Form
				if( $( ".login-form-trigger" ) ){
					$( ".login-form-trigger" ).trigger("click");
				}
			}else{
				var cur_ele = $(this);
				var pid = cur_ele.attr("data-id");
				
				$.ajax({
					type: 'post',
					dataType: 'json',
					url: zoacres_ajax_var.admin_ajax_url,
					data: { action: "zadd_fav", 
							"nonce": zoacres_ajax_var.add_fav,
							"property_id": pid
					},success: function(data){
						if( data["result"] == "success" ){
							cur_ele.addClass("property-fav-done").removeClass("property-fav");
						}else{
							if( $( ".login-form-trigger" ) ){
								$( ".login-form-trigger" ).trigger("click");
							}
						}
					},error: function(xhr, status, error) {
						console.log( xhr );
					}
				});
			}
			return false;
		});

		$( document ).on( "click", ".property-favourite .property-fav-done", function() {
		
			if( !$("body.logged-in").length ){
				//Login/Register Form
				if( $( ".login-form-trigger" ) ){
					$( ".login-form-trigger" ).trigger("click");
				}
			}else{
				var cur_ele = $(this);
				var pid = cur_ele.attr("data-id");
				
				$.ajax({
					type: 'post',
					dataType: 'json',
					url: zoacres_ajax_var.admin_ajax_url,
					data: { action: "zremove_fav", 
							"nonce": zoacres_ajax_var.add_fav,
							"property_id": pid
					},success: function(data){
						if( data["result"] == "success" ){
							cur_ele.addClass("property-fav").removeClass("property-fav-done");
						}else{
							if( $( ".login-form-trigger" ) ){
								$( ".login-form-trigger" ).trigger("click");
							}
						}
					},error: function(xhr, status, error) {
						console.log( xhr );
					}
				});
			}
		
			return false;
		});
		
		$( document ).on( "click", ".property-load-more-wrap .property-load-more", function() {
			
			var cur = $(this);
			cur.parents(".property-load-more-wrap").addClass("on-process no-more-property");
			cur.parents(".property-load-more-wrap").removeClass("no-more-property");
			
			var map_stat = '';
			if( $( ".property-map-identity" ).length && $( ".property-list-identity" ).length ){
				map_stat = 'property_map';
			}else if( $( ".property-map-identity" ).length ){
				map_stat = 'map';
			}else{
				map_stat = 'property';
			}
			
			var prop_key = $(".ajax-search-box").length ? $(".ajax-search-box").val() : '';
			var country_id = $(".search-country-id").length ? $(".search-country-id").val() : '';
			var state_id = $(".search-state-id").length ? $(".search-state-id").val() : '';
			var city_id = $(".search-city-id").length ? $(".search-city-id").val() : '';
			var area_id = $(".search-area-id").length ? $(".search-area-id").val() : '';
			var type_id = $(".search-type-id").length ? $(".search-type-id").val() : '';
			var action_id = $(".search-action-id").length ? $(".search-action-id").val() : '';
			var rooms_id = $(".search-rooms-id").length ? $(".search-rooms-id").val() : '';
			var bed_id = $(".search-bed-id").length ? $(".search-bed-id").val() : '';
			var bath_id = $(".search-baths-id").length ? $(".search-baths-id").val() : '';
			var minarea_id = $(".search-minarea-id").length ? $(".search-minarea-id").val() : '';
			var maxarea_id = $(".search-maxarea-id").length ? $(".search-maxarea-id").val() : '';
			
			var price_min = $(".slider-range-amount").length ? $(".slider-range-amount").attr("data-from") : '';
			var price_max = $(".slider-range-amount").length ? $(".slider-range-amount").attr("data-to") : '';
			var paged = $(".property-load-more").length ? $(".property-load-more").attr("data-page") : '';
			var cols = $(".map-property-list").length ? $(".map-property-list").attr("data-cols") : '6';
			var full_map = $(".full-map-property-wrap").length ? true : false;
			var ppp = $(".map-property-list").length ? $(".map-property-list").attr("data-ppp") : '';
			
			var agent = $(".map-property-agent").length ? $(".map-property-agent").val() : '';
			var agent_page = $(".page-template-zoacres-user-properties").length ? true : false;
			var animation = $(".map-property-list").length ? $(".map-property-list").attr("data-animation") : false;
			var layout = $(".map-property-list").length ? $(".map-property-list").attr("data-layout") : '';
			
			var sort_val = $(".search-sort-filter-id").length ? $(".search-sort-filter-id").val() : '';
			
			var meta_args = '';
			if( cur.parents(".zoacres-search-property-wrap").length ){
				meta_args = cur.parents(".zoacres-search-property-wrap").find(".property-dynamic-ele").val();
			}
			
			var extra_args = '';
			if( map_stat == 'map' || map_stat == 'property_map' ){
				extra_args = $(".property-map-identity .zoacres-property-map").length ? jQuery.parseJSON( $(".property-map-identity .zoacres-property-map").attr("data-extra-args") ) : '';
			}
			
			var search_data = {
				'action' : 'zpropertygetting',
				'nonce' : zoacres_ajax_var.key_search,
				'key_val' : prop_key,
				'country_id' : country_id,
				'state_id' : state_id,
				'city_id' : city_id,
				'area_id' : area_id,
				'type_id' : type_id,
				'action_id' : action_id,
				'rooms_id' : rooms_id,
				'bed_id' : bed_id,
				'bath_id' : bath_id,
				'minarea_id' : minarea_id,
				'maxarea_id' : maxarea_id,
				'price_min' : price_min,
				'price_max' : price_max,
				'paged' : paged,
				'map_stat' : map_stat,
				'cols' : cols,
				'full_map' : full_map,
				'ppp' : ppp,
				'agent' : agent,
				'agent_page' : agent_page,
				'animation' : animation,
				'layout' : layout,
				'sort_val' : sort_val,
				'meta_args' : meta_args,
				'extra_args' : extra_args
			};
		
			$.ajax({
				type: 'post',
				dataType: 'json',
				url: zoacres_ajax_var.admin_ajax_url,
				data: search_data,
				success: function(data){
					
					if( data["property_json"] ){
						$("body").append('<div id="property-dynamic-res" style="display:none;">'+ data["property_json"] +'</div>');
						$("#property-dynamic-res .row > div").clone().appendTo( ".map-property-list > .row" );
						$("#property-dynamic-res").remove();
					}
					
					if( data["map_json"] ){
						$(".half-map-property-wrap").html( data["map_json"] );
						initZoacresGmap();
						var header_height = $(".zoacres-header").outerHeight();
						zoacres_halfmap_height_set(header_height);
					}
					
					cur.parents(".property-load-more-wrap").removeClass("on-process");
					$(".property-load-more").attr("data-page", ++paged);
					if( data["property_eof"] && data["property_eof"] == true ){
						$(".property-load-more-wrap").fadeOut(0);
						$(".property-load-more-wrap").children(".property-load-more-inner").fadeOut(0);
						cur.parents(".property-load-more-wrap").addClass("no-more-property");
						$(".property-load-more-wrap").append('<p class="no-more-properties">'+ zoacres_ajax_var.no_more_property +'</p>');
						$(".property-load-more-wrap").fadeIn(300);
						
						setTimeout(function(){ 
							$(".property-load-more-wrap").fadeOut(500);
						}, 1000);
						
					}else{
						$(".property-load-more-wrap").fadeOut(0);
						$(".property-load-more-wrap").children(".property-load-more-inner").fadeIn(0);
						$(".property-load-more-wrap").find(".no-more-properties").fadeOut(0);
						$(".property-load-more-wrap").fadeIn(500);
					}
					
					zoacres_scroll_animation();
					
				},error: function(xhr, status, error) {
					cur.parent(".property-load-more-wrap").removeClass("on-process no-more-property");
					console.log( xhr );
				}
			});
			return false;
		});
		
		// Property Filter Ajax
		$( document ).on( "click", ".property-filter > li > a", function() {
		
			var cur = $(this);
			var parent = cur.parents(".property-filter-sc");
			var filter = cur.attr("data-id");
			var ppp = parent.find(".map-property-list").attr("data-ppp");
			var prop_args = parent.find(".prop-params").attr("data-params");
			var filter_data = {
				'action' : 'filtered_property',
				'nonce' : zoacres_ajax_var.filter_ajax,
				'filter' : filter,
				'ppp' : ppp,
				'prop_args' : prop_args
			}
			
			parent.find(".property-filter a").removeClass("active");
			cur.addClass("active");
			zoacresFilterProperty( filter_data, parent, false );

			return false;
			
		});
		
		// Property Filter Ajax Loadmore
		$( document ).on( "click", ".property-filter-sc .property-loadmore", function() {
		
			var cur = $(this);
			var parent = cur.parents(".property-filter-sc");
			var filter = parent.find(".property-filter a.active").attr("data-id");
			var ppp = parent.find(".map-property-list").attr("data-ppp");
			var prop_args = parent.find(".prop-params").attr("data-params");
			var paged = cur.attr("data-page");
			var filter_data = {
				'action' : 'filtered_property',
				'nonce' : zoacres_ajax_var.filter_ajax,
				'filter' : filter,
				'ppp' : ppp,
				'prop_args' : prop_args,
				'paged' : paged
			}
			
			zoacresFilterProperty( filter_data, parent, true );

			return false;
			
		});

		//Property print
		if( $( ".property-print" ).length ){
			$( document ).on( "click", ".property-print", function() {
				window.print();
			});
		}
		
		if( $( ".property-single-pack-nav" ).length ){
			$( document ).on( "click", ".property-single-pack-nav a", function() {
				var cur = $(this);
				var parent_ul = cur.parents(".property-single-pack-nav");
				var cparent = cur.parents(".property-single-pack-inner");
				
				parent_ul.find("a.nav-link.active").removeClass("active");
				cur.addClass("active");
				
				var ctab = cur.attr('data-id');
				cparent.find( ".property-single-pack-content > div" ).fadeOut(0);

				cparent.find( ".property-single-pack-content ." + ctab ).fadeIn(300);
				if( ctab == "property-single-pack-sview" ){
					initZoacresGmap();
				}
				
				return false;
			});
		}
		
		//Property Single Owl Thumb Slider
		if( $( ".property-single-gallery" ).length ){
			var light_slider = $('.property-single-gallery');
			
			//light_slider.each(function( index ) {
				$('.property-single-gallery').lightSlider({
					gallery:true,
					item:1,
					thumbItem:9,
					slideMargin: 0,
					speed:500,
					auto:false,
					loop:true,
					onSliderLoad: function() {
						$('.property-single-gallery').removeClass('cS-hidden');
					}  
				});
			//});
		}
		
		if( $( ".profile-rem-image-trigger" ).length ){
			$( document ).on( "click", ".profile-rem-image-trigger", function() {
				$(".agent-no-photo").val("1");
				$(".profile-image-file").val('');
				$(".profile-preview-image").attr("src", zoacres_ajax_var.no_user_img);
			});
		}
		
		//profile-image-trigger
		if( $( ".profile-image-trigger" ).length ){
			$( document ).on( "click", ".profile-image-trigger", function() {
				$(".profile-image-file").trigger("click");
				return false;
			});
			
			//Profile image change event
			$( document ).on( "change", ".profile-image-file", function() {
				var input = this;
				if (input.files && input.files[0]) {
					var reader = new FileReader();

					reader.onload = function (e) {
						$('.profile-preview-image').attr('src', e.target.result);
					};

					reader.readAsDataURL(input.files[0]);
					$(".agent-no-photo").val("0");
				}
			});
		}
		
		if( $(".dashboard_password").length ){
			
			$( document ).on( "click", "#change_pass", function() {

				var old_pass = $("#oldpass").val();
				var new_pass = $("#newpass").val();
				var confirm_pass = $("#renewpass").val();
				
				if( ( new_pass == '' || confirm_pass == '' ) || new_pass != confirm_pass ){
					$(".pswd-updated-status").html(zoacres_ajax_var.not_equal_pswd);
					$(".pswd-status-wrap .pswd-updated-status").fadeIn(300);
					return false;
				}
				
				var profile_data = {
					'action' : 'zoacres_pswd_update',
					'nonce' : zoacres_ajax_var.profile_update,
					'old_pass' : old_pass,
					'new_pass' : new_pass
				};
				
				$(".pswd-status-wrap .pswd-updated-status").fadeOut(0);
				$(".pswd-status-wrap .process-loader").fadeIn(300);
				
				if( old_pass != '' && new_pass != '' ){
					//Profile update ajax
					$.ajax({
						type: "post",
						url: zoacres_ajax_var.admin_ajax_url,
						dataType: 'json',
						data: profile_data,
						success: function (data) {
							var res = data;
							if( res == 'success' ){
								$(".pswd-updated-status").html(zoacres_ajax_var.pswd_changed);
							}else if( res == 'mismatch' ){
								$(".pswd-updated-status").html(zoacres_ajax_var.pswd_mismatch);
							}else{
								$(".pswd-updated-status").html(zoacres_ajax_var.try_again);
							}
							$(".pswd-status-wrap .process-loader").fadeOut(0);
							$(".pswd-status-wrap .pswd-updated-status").fadeIn(300);
						},error: function(xhr, status, error) {
							console.log(xhr);
							if( xhr.responseText == 'success' ){
								$(".pswd-updated-status").html(zoacres_ajax_var.pswd_changed);
							}else if( xhr.responseText == 'mismatch' ){
								$(".pswd-updated-status").html(zoacres_ajax_var.pswd_mismatch);
							}else{
								$(".pswd-updated-status").html(zoacres_ajax_var.try_again);
							}
							
							$(".pswd-status-wrap .process-loader").fadeOut(0);
							$(".pswd-status-wrap .pswd-updated-status").fadeIn(300);
						}
					});
				}
				
				return false;
			});
		}
		
		//Save Profile Click
		if( $( ".zoacres_user_dashboard" ).length ){
			
			$('#profile-form').on( 'submit', function(e){
				
				e.preventDefault();
								
				var profile_data = new FormData(this);
				profile_data.append('nonce', zoacres_ajax_var.profile_update);
				profile_data.append('action', 'zoacres_profile_update');
				
				$(".process-status-wrap .profile-updated-status").fadeOut(0);
				$(".process-status-wrap .process-loader").fadeIn(300);
				
				//Profile update ajax
				$.ajax({
					type: "post",
					url: zoacres_ajax_var.admin_ajax_url,
					data: profile_data,
					cache:false,
					contentType: false,
					processData: false,
					success: function (data) {
						var res = data;
						if( res == 'success' ){
							$(".profile-updated-status").html(zoacres_ajax_var.details_updated);
						}else{
							$(".profile-updated-status").html(zoacres_ajax_var.try_again);
						}
						$(".process-status-wrap .process-loader").fadeOut(0);
						$(".process-status-wrap .profile-updated-status").fadeIn(300);
					},error: function(xhr, status, error) {
						console.log(xhr);
						$(".profile-updated-status").html(zoacres_ajax_var.try_again);
						$(".process-status-wrap .process-loader").fadeOut(0);
						$(".process-status-wrap .profile-updated-status").fadeIn(300);
					}
				});

				return false;
				
			});
		}
		
		//subscriber-confirm-change
		if( $( ".subscriber-profile-page" ).length ){
			$( document ).on( "click", ".subscriber-confirm-change", function() {
				
				var subs_role = $(".subscriber-confirm-role").val();
				var redirect_url = $(this).attr("data-url");
				var profile_data = {
					'action' : 'zoacres_role_change',
					'nonce' : zoacres_ajax_var.role_change,
					'role' : subs_role
				};
				
				$(this).next("button").trigger("click");
				$(".role-change-overlay").fadeIn(300);
				
				//Profile update ajax
				$.ajax({
					type: "post",
					url: zoacres_ajax_var.admin_ajax_url,
					dataType: 'json',
					data: profile_data,
					success: function (data) {
						var res = data['result'];
						if( res == "success" ){
							window.location.href = redirect_url;
						}
					},error: function(xhr, status, error) {
						console.log(xhr);
					}
				});
				
				return false;
			});
			
		}
		
		//Users fav load more
		if( $( ".property-fav-load-more" ).length ){
			/*$( document ).on( "click", ".agent-property-list", function() {
				
				//zoacres-get-agent-properties
				var ajax_data = {
					'action' : 'zoacres_agent_prop',
					'nonce' : zoacres_ajax_var.agent_properties
				};
				
				$(".process-change-overlay").fadeIn(300);
				
				//Get agent properties
				$.ajax({
					type: "post",
					url: zoacres_ajax_var.admin_ajax_url,
					dataType: 'json',
					data: ajax_data,
					success: function (data) {
						var res = data['result'];
						if( res ){
							$(".zoacres-agent-panel").html(res);
							//if( $(".zoacres-agent-panel").find(".zoacres-animate").length ){
								zoacres_scroll_animation();
							//}
						}
						$(".process-change-overlay").fadeOut(300);
					},error: function(xhr, status, error) {
						$(".process-change-overlay").fadeOut(300);
						console.log(xhr);
					}
				});
				
				return false;
			});*/

		
			//Agent Fav Property List on agent front page
			/*$( document ).on( "click", ".agent-fav-property-list", function() {
				
				var ajax_data = {
					'action' : 'zoacres_agent_fav_prop',
					'nonce' : zoacres_ajax_var.agent_fav_properties
				};

				$(".process-change-overlay").fadeIn(300);
				
				//Get agent properties
				$.ajax({
					type: "post",
					url: zoacres_ajax_var.admin_ajax_url,
					dataType: 'json',
					data: ajax_data,
					success: function (data) {
						var res = data['property_json'];
						if( res ){
							$(".zoacres-agent-panel").html(res);
							zoacres_scroll_animation();
						}
						$(".process-change-overlay").fadeOut(300);
					},error: function(xhr, status, error) {
						$(".process-change-overlay").fadeOut(300);
						console.log(xhr);
					}
				});
				
				return false;
			});*/
			
			$( document ).on( "click", ".property-load-more-wrap .property-fav-load-more", function() {
			
				var cur = $(this);
				cur.parents(".property-load-more-wrap").addClass("on-process");
				var paged = cur.attr("data-page");
				
				var ajax_data = {
					'action' : 'zoacres_agent_fav_prop',
					'nonce' : zoacres_ajax_var.agent_fav_properties,
					'paged' : paged
				};
				
				$.ajax({
					type: 'post',
					dataType: 'json',
					url: zoacres_ajax_var.admin_ajax_url,
					data: ajax_data,
					success: function(data){
						if( data["property_json"] ){
							$("body").append('<div id="property-dynamic-res" style="display:none;">'+ data["property_json"] +'</div>');
							$("#property-dynamic-res .row > div").clone().appendTo( ".map-property-list > .row" );
							$("#property-dynamic-res").remove();
						}

						cur.parents(".property-load-more-wrap").removeClass("on-process");
						$(".property-fav-load-more").attr("data-page", ++paged);
						if( data["property_eof"] && data["property_eof"] == true ){
							$(".property-load-more-wrap").fadeOut(0);
							$(".property-load-more-wrap").children(".property-load-more-inner").fadeOut(0);
							$(".property-load-more-wrap").append('<p class="no-more-properties">'+ zoacres_ajax_var.no_more_property +'</p>');
							$(".property-load-more-wrap").fadeIn(300);
							
							setTimeout(function(){ 
								$(".property-load-more-wrap").fadeOut(500);
							}, 1000);
							
						}else{
							$(".property-load-more-wrap").fadeOut(0);
							$(".property-load-more-wrap").children(".property-load-more-inner").fadeIn(0);
							$(".property-load-more-wrap").children(".no-more-properties").fadeOut(0);
							$(".property-load-more-wrap").fadeIn(500);
						}
						
						zoacres_scroll_animation();
						
					},error: function(xhr, status, error) {
						cur.parent(".property-load-more-wrap").removeClass("on-process");
						console.log( xhr );
					}
				});
				return false;
				
			});
			
		} // Users fav load more end
		
		//Set Saved Search
		if( zoacres_ajax_var.user_log_stat && $( ".saved-search-wrap" ).length ){
		
			$( document ).on( "click", ".saved-search-close", function() {
				$(".saved-search-wrap").fadeOut(300);
				return false;
			});
			
			$( document ).on( "click", ".saved-search-trigger", function() {

				var key_val = $(".ajax-search-box").length ? $(".ajax-search-box").val() : '';
				var country_id = $(".search-country-id").length ? $(".search-country-id").val() : '';
				var state_id = $(".search-state-id").length ? $(".search-state-id").val() : '';
				var city_id = $(".search-city-id").length ? $(".search-city-id").val() : '';
				var area_id = $(".search-area-id").length ? $(".search-area-id").val() : '';
				var type_id = $(".search-type-id").length ? $(".search-type-id").val() : '';
				var action_id = $(".search-action-id").length ? $(".search-action-id").val() : '';
				var rooms_id = $(".search-rooms-id").length ? $(".search-rooms-id").val() : '';
				var bed_id = $(".search-bed-id").length ? $(".search-bed-id").val() : '';
				var bath_id = $(".search-baths-id").length ? $(".search-baths-id").val() : '';
				var minarea_id = $(".search-minarea-id").length ? $(".search-minarea-id").val() : '';
				var maxarea_id = $(".search-maxarea-id").length ? $(".search-maxarea-id").val() : '';				
				var price_min = $(".slider-range-amount").length ? $(".slider-range-amount").attr("data-from") : '';
				var price_max = $(".slider-range-amount").length ? $(".slider-range-amount").attr("data-to") : '';
				
				var save_data = {
					'key_val' : key_val,
					'country_id' : country_id,
					'state_id' : state_id,
					'city_id' : city_id,
					'area_id' : area_id,
					'type_id' : type_id,
					'action_id' : action_id,
					'rooms_id' : rooms_id,
					'bed_id' : bed_id,
					'bath_id' : bath_id,
					'minarea_id' : minarea_id,
					'maxarea_id' : maxarea_id,
					'price_min' : price_min,
					'price_max' : price_max,
				};
				
				var ajax_data = {
					'action' : 'zosave_search',
					'nonce' : zoacres_ajax_var.save_search,
					'saved_search' : save_data
				};
				
				$.ajax({
					type: 'post',
					dataType: 'json',
					url: zoacres_ajax_var.admin_ajax_url,
					data: ajax_data,
					success: function(data){
						var result = data["status"];
						$(".saved-search-text").addClass("saved-search-done");
						setTimeout(function(){ $(".saved-search-wrap").fadeOut( 300 ); }, 1500); 
						
					},error: function(xhr, status, error) {
						console.log( xhr );
						$(".saved-search-text").addClass("saved-search-done");
						setTimeout(function(){ $(".saved-search-wrap").fadeOut( 300 ); }, 1500); 
					}
				});
				
				return false;
			});
			
		}
		
		//Get Saved Search
		if( zoacres_ajax_var.user_log_stat && $( ".saved-search-acco-trigger" ).length ){

			/*$( document ).on( "click", ".user-saved-searches", function() {
			
				$(".process-change-overlay").fadeIn(300);
				
				var ajax_data = {
					'action' : 'zoget_saved_search',
					'nonce' : zoacres_ajax_var.save_search
				};
				
				$.ajax({
					type: 'post',
					dataType: 'json',
					url: zoacres_ajax_var.admin_ajax_url,
					data: ajax_data,
					success: function(data){
						var result = data["result"];
						$(".zoacres-user-details-wrap").html(result);
						$(".process-change-overlay").fadeOut(300);						
					},error: function(xhr, status, error) {
						console.log( xhr );
						$(".process-change-overlay").fadeOut(300);
					}
				});
				
				return false;
			});*/
			
			$( document ).on( "click", ".saved-search-acco-trigger", function() {
			
				var params = $(this).attr("data-params");
				var target = $(this).attr("data-target");
				
				if( $(target).find(".saved-search-loader").length ){
					
					var s_obj = jQuery.parseJSON( params );
					
					var search_data = {
						'action' : 'zpropertygetting',
						'nonce' : zoacres_ajax_var.key_search,
						'key_val' : s_obj.prop_key,
						'country_id' : s_obj.country_id,
						'state_id' : s_obj.state_id,
						'city_id' : s_obj.city_id,
						'area_id' : s_obj.area_id,
						'type_id' : s_obj.type_id,
						'action_id' : s_obj.action_id,
						'rooms_id' : s_obj.rooms_id,
						'bed_id' : s_obj.bed_id,
						'bath_id' : s_obj.bath_id,
						'minarea_id' : s_obj.minarea_id,
						'maxarea_id' : s_obj.maxarea_id,
						'map_stat' : s_obj.map_stat,
						'price_min' : s_obj.price_min,
						'price_max' : s_obj.price_max,
						'cols': '6',
						'animation' : true
					};

					//For property	
					$.ajax({
						type: "post",
						url: zoacres_ajax_var.admin_ajax_url,
						dataType: 'JSON',
						data: search_data,
						success: function (data) {
							var res = data["property_json"];
							if( res != '' ){
								$("body").append('<div id="property-dynamic-res" style="display:none;">'+ data["property_json"] +'</div>');
								$(target).html('');
								$("#property-dynamic-res .row").clone().appendTo( target );
								$("#property-dynamic-res").remove();
							}else{
								if( !$(target).find(".property-nothing-found").length ){
									$(target).append('<div class="property-nothing-found"><span class="icon-dislike icons"></span><p>'+ zoacres_ajax_var.not_found +'</p></div>');
								}else{
									$(target).find(".property-nothing-found").fadeIn(300);
								}
							}
							zoacres_scroll_animation();
							
						},error: function(xhr, status, error) {
							console.log(xhr);
						}
					});
				}
				
			});
			
		}
		
		// Half Map Height Set
		if( $( ".half-map-property-row" ).length ){
			$("body").addClass("half-map-activated");
			var header_height = $(".zoacres-header").outerHeight();
			zoacres_halfmap_height_set(header_height);
			
			$( window ).smartresize(function() {
				zoacres_halfmap_height_set(header_height);							 
			});								 
		}

		if( $("body.page-template-zoacres-property-new").length ){
		
			//Image upload via ajax
			$( ".insert-property-ajax" ).on("click", function() {
			
				$(".property-upload-parent .property-new-process").fadeIn(300);
				
				$(".property-gallery-image-status").fadeIn(300);
				$(".property-gallery-image-status").text('');

				var featured_img = 0;
				var gallery_img = 0;
				var img_360 = 0;
				var doc_files = 0;

				// Property gallery images
				var img_data = new FormData();
				var prop_gallery = $( ".property-gallery-file" );
				
				// Loop through each data and create an array file[] containing our files data.
				var gallery_stat = 0;
				var gallery_count = 0;
				$.each($(prop_gallery), function(i, obj) {
					$.each(obj.files,function(j,file){
						gallery_stat = 1;
						img_data.append('files[' + j + ']', file);
						gallery_count++;
					})
				});
				
				if( gallery_stat ){
					img_data.append('action', 'zoacres_img_test');
					img_data.append('nonce', zoacres_ajax_var.img_test);
					
					$.ajax({
						type: "post",
						url: zoacres_ajax_var.admin_ajax_url,
						processData: false, // important
						contentType: false, // important
						data: img_data,
						dataType: 'JSON',
						success: function (data) {
							if( data ){
								$(".property-gallery-image-final").val( data['img_id'] );
								if( data['status'] == 'limit overflow' ){
									$(".property-gallery-image-status").text(zoacres_ajax_var.gallery_limit);
									$(".property-gallery-image-status").fadeIn(300);
									$(".property-upload-parent .property-new-process").fadeOut(300);
									
									var ani_pos = $("#property-gallery-image").offset();
									$('html,body').animate({ 'scrollTop': ani_pos.top - 200 }, 1000, 'easeInOutExpo' );
									
									return false;
								}else{
									gallery_img = 1;
									zoacresPropertyAdd( featured_img, gallery_img, img_360, doc_files );
								}
							}
						},error: function(xhr, status, error) {
							console.log(xhr);
						}
					});	
				}else{
					gallery_img = 1;
					zoacresPropertyAdd( featured_img, gallery_img, img_360, doc_files );
				}
				
				//Property documents upload
				var docs_data = new FormData();
				var prop_docs = $( ".property-docs-file" );
				
				// Loop through each data and create an array file[] containing our files data.
				var docs_stat = 0;
				var docs_count = 0;
				$.each($(prop_docs), function(i, obj) {
					$.each(obj.files,function(j,file){
						docs_stat = 1;
						docs_data.append('files[' + j + ']', file);
						docs_count++;
					})
				});
				
				if( docs_stat ){
					docs_data.append('action', 'zoacres_docs_upload');
					docs_data.append('nonce', zoacres_ajax_var.docs_upload);
					
					$.ajax({
						type: "post",
						url: zoacres_ajax_var.admin_ajax_url,
						processData: false, // important
						contentType: false, // important
						data: docs_data,
						dataType: 'JSON',
						success: function (data) {
							if( data ){
								$(".property-docs-file-final").val( data['doc_ids'] );
								doc_files = 1;
								zoacresPropertyAdd( featured_img, gallery_img, img_360, doc_files );
							}
						},error: function(xhr, status, error) {
							console.log(xhr);
						}
					});	
				}else{
					doc_files = 1;
					zoacresPropertyAdd( featured_img, gallery_img, img_360, doc_files );
				}
				
				// Property featured images
				var img_data = new FormData();
				img_data.append('action', 'zoacres_ftr_img');
				img_data.append('nonce', zoacres_ajax_var.img_test);
				img_data.append('files', $( ".property-image-file" ).prop('files')[0]);
				img_data.append('gal_count', gallery_count);				
				
				if( $( ".property-image-file" ).prop('files')[0] ){
					$.ajax({
						type: "post",
						url: zoacres_ajax_var.admin_ajax_url,
						processData: false, // important
						contentType: false, // important
						data: img_data,
						dataType: 'JSON',
						success: function (data) {
							if( data ){
								$(".property-image-final").val( data['img_id'] );
								featured_img = 1;
								zoacresPropertyAdd( featured_img, gallery_img, img_360, doc_files );
							}
						},error: function(xhr, status, error) {
							console.log(xhr);
						}
					});
				}else{
					featured_img = 1;
					zoacresPropertyAdd( featured_img, gallery_img, img_360, doc_files );
				}

				// Property 360 deg images
				var img_data = new FormData();
				img_data.append('action', 'zoacres_ftr_img');
				img_data.append('nonce', zoacres_ajax_var.img_test);
				img_data.append('files', $( ".property-360-image-file" ).prop('files')[0]);
				
				if( $( ".property-360-image-file" ).prop('files')[0] ){
					$.ajax({
						type: "post",
						url: zoacres_ajax_var.admin_ajax_url,
						processData: false, // important
						contentType: false, // important
						data: img_data,
						dataType: 'JSON',
						success: function (data) {
							$(".property-360-image-final").val( data['img_id'] );
							img_360 = 1;
							zoacresPropertyAdd( featured_img, gallery_img, img_360, doc_files );
						},error: function(xhr, status, error) {
							console.log(xhr);
						}
					});
				}else{
					img_360 = 1;
					zoacresPropertyAdd( featured_img, gallery_img, img_360, doc_files );
				}
				
				return false;
				
			});


		} //.body.page-template-zoacres-property-new end
		
		if( $("body.page-template-zoacres-property-edit").length ){
		
			//Image upload via ajax
			$( ".update-property-ajax" ).on("click", function() {
			
				$(".property-upload-parent .property-new-process").fadeIn(300);
				
				$(".property-gallery-image-status").fadeIn(300);
				$(".property-gallery-image-status").text('');

				var featured_img = 0;
				var gallery_img = 0;
				var img_360 = 0;
				var doc_files = 0;
				
				// Property gallery images
				var img_data = new FormData();
				var prop_gallery = $( ".property-gallery-file" );
				
				// Loop through each data and create an array file[] containing our files data.
				var gallery_stat = 0;
				var gallery_count = 0;
				$.each($(prop_gallery), function(i, obj) {
					$.each(obj.files,function(j,file){
						gallery_stat = 1;
						img_data.append('files[' + j + ']', file);
						gallery_count++;
					})
				});
				
				if( gallery_stat ){
					img_data.append('action', 'zoacres_img_test');
					img_data.append('nonce', zoacres_ajax_var.img_test);
					img_data.append('gallery_last', $(".property-gallery-image-final").val());
					
					$.ajax({
						type: "post",
						url: zoacres_ajax_var.admin_ajax_url,
						processData: false, // important
						contentType: false, // important
						data: img_data,
						dataType: 'JSON',
						success: function (data) {
							if( data ){
								$(".property-gallery-image-final").val( data['img_id'] );
								if( data['status'] == 'limit overflow' ){
									$(".property-gallery-image-status").text(zoacres_ajax_var.gallery_limit);
									$(".property-gallery-image-status").fadeIn(300);
									$(".property-upload-parent .property-new-process").fadeOut(300);
									
									var ani_pos = $("#property-gallery-image").offset();
									$('html,body').animate({ 'scrollTop': ani_pos.top - 200 }, 1000, 'easeInOutExpo' );
									
									return false;
								}else{
									gallery_img = 1;
									zoacresPropertyUpdate( featured_img, gallery_img, img_360, doc_files );
								}
							}
						},error: function(xhr, status, error) {
							console.log(xhr);
						}
					});	
				}else{
					gallery_img = 1;
					zoacresPropertyUpdate( featured_img, gallery_img, img_360, doc_files );
				}
				
				// Property Documents
				var docs_data = new FormData();
				var prop_docs = $( ".property-docs-file" );
				
				// Loop through each data and create an array file[] containing our files data.
				var docs_stat = 0;
				var docs_count = 0;
				$.each($(prop_docs), function(i, obj) {
					$.each(obj.files,function(j,file){
						docs_stat = 1;
						docs_data.append('files[' + j + ']', file);
						docs_count++;
					})
				});
				
				if( docs_stat ){
					docs_data.append('action', 'zoacres_docs_upload');
					docs_data.append('nonce', zoacres_ajax_var.docs_upload);
					docs_data.append('docs_last', $(".property-docs-file-final").val());
					
					$.ajax({
						type: "post",
						url: zoacres_ajax_var.admin_ajax_url,
						processData: false, // important
						contentType: false, // important
						data: docs_data,
						dataType: 'JSON',
						success: function (data) {
							if( data ){
								$(".property-docs-file-final").val( data['doc_ids'] );
								doc_files = 1;
								setTimeout(function(){
									zoacresPropertyUpdate( featured_img, gallery_img, img_360, doc_files );
								}, 300);
							}
						},error: function(xhr, status, error) {
							console.log(xhr);
						}
					});	
				}else{
					doc_files = 1;
					zoacresPropertyUpdate( featured_img, gallery_img, img_360, doc_files );
				}
				
				//return false; // this line only for testing
				
				// Property featured images
				var img_data = new FormData();
				img_data.append('action', 'zoacres_ftr_img');
				img_data.append('nonce', zoacres_ajax_var.img_test);
				img_data.append('files', $( ".property-image-file" ).prop('files')[0]);
				img_data.append('gal_count', gallery_count);	
				img_data.append('images_last', $(".property-image-final").val());
				
				if( $( ".property-image-file" ).prop('files')[0] ){
					$.ajax({
						type: "post",
						url: zoacres_ajax_var.admin_ajax_url,
						processData: false, // important
						contentType: false, // important
						data: img_data,
						dataType: 'JSON',
						success: function (data) {
							if( data ){
								$(".property-image-final").val( data['img_id'] );
								featured_img = 1;
								zoacresPropertyUpdate( featured_img, gallery_img, img_360, doc_files );
							}
						},error: function(xhr, status, error) {
							console.log(xhr);
						}
					});
				}else{
					featured_img = 1;
					zoacresPropertyUpdate( featured_img, gallery_img, img_360, doc_files );
				}

				// Property 360 deg images
				var img_data = new FormData();
				img_data.append('action', 'zoacres_ftr_img');
				img_data.append('nonce', zoacres_ajax_var.img_test);
				img_data.append('files', $( ".property-360-image-file" ).prop('files')[0]);
				img_data.append('images_last', $(".property-360-image-file").val());
				
				if( $( ".property-360-image-file" ).prop('files')[0] ){
					$.ajax({
						type: "post",
						url: zoacres_ajax_var.admin_ajax_url,
						processData: false, // important
						contentType: false, // important
						data: img_data,
						dataType: 'JSON',
						success: function (data) {
							$(".property-360-image-final").val( data['img_id'] );
							img_360 = 1;
							zoacresPropertyUpdate( featured_img, gallery_img, img_360, doc_files );
						},error: function(xhr, status, error) {
							console.log(xhr);
						}
					});
				}else{
					img_360 = 1;
					zoacresPropertyUpdate( featured_img, gallery_img, img_360, doc_files );
				}
				
				return false;
				
			});


		} //.body.page-template-zoacres-property-edit end
		
		if( $(".property-360-image-file").length ){
			$('.property-360-image-file').bind('change', function() {
				
				var cur = $(this);
				if( cur.prev("ul.image-list").length ){
					cur.prev("ul.image-list").remove();
				}

			});
		}
		
		if( $(".property-image-file").length ){
			$('.property-image-file').bind('change', function() {
				
				var cur = $(this);
				if( cur.prev("ul.image-list").length ){
					cur.prev("ul.image-list").remove();
				}

			});
		}
		
		if( $(".property-gallery-file").length ){
			$('.property-gallery-file').bind('change', function() {
				var out = '';
				
				var cur = $(this);
				if( cur.prev("ul.image-list").length ){
					cur.prev("ul.image-list").remove();
				}
				
				$(".property-gallery-image-status").html('');
				$.each( $(this), function(i, obj) {
					$.each(obj.files,function(j,file){			
						if( ( file.size/1024 ) > 500 ){
							out +=  file.name +' - '+ zoacres_ajax_var.too_large +'<br />';
							$(".property-gallery-image-status").html(out);
						}
					});
				});
				if( out ) $(".property-gallery-image-status").fadeIn(300);
			});
		}
		
		if( $(".property-plan-add").length ){
		
			//Plan image on change upload
			$(document).on('change', '.property-plan-image-file', function() {
				var cur = $(this);
				
				if( cur.prev("ul.image-list").length ){
					cur.prev("ul.image-list").remove();
				}
				
				var res_ele = cur.next(".property-plan-image-final");
				
				var img_data = new FormData();
				img_data.append('action', 'zoacres_ftr_img');
				img_data.append('nonce', zoacres_ajax_var.img_test);
				img_data.append('files', cur.prop('files')[0]);
				img_data.append('images_last', res_ele.val());
				
				if( cur.prop('files')[0] ){
					$.ajax({
						type: "post",
						url: zoacres_ajax_var.admin_ajax_url,
						processData: false, // important
						contentType: false, // important
						data: img_data,
						dataType: 'JSON',
						success: function (data) {
							res_ele.val( data['img_id'] );
						},error: function(xhr, status, error) {
							console.log(xhr);
						}
					});
				}
				
			});
		
			$( document ).on( "click", ".property-plan-add", function() {
				var plan_ids = $(".property-plan-ids").val();
				plan_ids = plan_ids.split(",");
				var plan_last_id = plan_ids.length - 1;
				var new_id = plan_ids[plan_last_id];
				new_id++;
				$(".property-plan-ids").val( $(".property-plan-ids").val() + ',' + new_id );
				var org_card = $("#property-plan .card.original-card").clone();
				org_card.removeClass("original-card");
				org_card.attr("data-key", new_id);
				org_card.find(".card-header h5").append('<span class="close property-plan-close"></span>');
				org_card.find(".card-header a").attr("href", "#property-plan-" + new_id);
				var card_header = org_card.find(".card-header a").text();
				//org_card.find(".card-header a").text( card_header.replace('1', new_id) );
				org_card.children("#property-plan-1").attr("id", "property-plan-" + new_id);
				org_card.find(".property-plan-image-file-1").attr("class", "property-plan-image-file property-plan-image-file-" + new_id);
				org_card.find(".property-plan-image-final-1").attr("name", "property_plan_image_final_" + new_id);
				org_card.find(".property-plan-image-final-1").attr("class", "property-plan-image-final" );
				org_card.find('input[name="property_plan_title_1"]').attr("name", "property_plan_title_" + new_id);
				org_card.find('input[name="property_plan_size_1"]').attr("name", "property_plan_size_" + new_id);
				org_card.find('input[name="property_plan_rooms_1"]').attr("name", "property_plan_rooms_" + new_id);
				org_card.find('input[name="property_plan_bathrooms_1"]').attr("name", "property_plan_bathrooms_" + new_id);
				org_card.find('input[name="property_plan_desc_1"]').attr("name", "property_plan_desc_" + new_id);
				org_card.find('input[name="property_plan_price_1"]').attr("name", "property_plan_price_" + new_id);
				org_card.find(".property-plan-image-final").attr("value", "");

				$("#property-plan").append(org_card);
				return false;
			});

			$( document ).on( "click", ".property-plan-close", function() {
				var plan_key = $(this).parents(".card").attr("data-key");
				var plan_ids = $(".property-plan-ids").val();
				plan_ids = plan_ids.replace( ',' + plan_key, '' );
				plan_ids = plan_ids.replace( plan_key, '' );
				$(".property-plan-ids").val(plan_ids);
				
				var image_id = $(this).parents(".card").find(".property-plan-image-final").val();

				if( image_id ){

					var img_data = {
						'action' : 'zoacres_ftr_img_remove',
						'nonce' : zoacres_ajax_var.img_test,
						'img_id' : image_id
					}
					
					$.ajax({
						type: "post",
						url: zoacres_ajax_var.admin_ajax_url,
						data: img_data,
						dataType: 'JSON',
						success: function (data) {
							$(this).parents(".card").remove();
						},error: function(xhr, status, error) {
							console.log(xhr);
							$(this).parents(".card").remove();
						}
					});
				}else{
					$(this).parents(".card").remove();
				}			
				
			});
		}
		
		//Package triggers
		if( $( ".package-renewal-toggle-trigger" ).length ){
			$( document ).on( "click", ".package-renewal-toggle-trigger", function() {
				$(".package-toggle-org").trigger("click");
				$(".package-renewal-trigger").trigger("click");
				
				return false;
			});
		}
		
			
		if( $( "#zoacres_property_location" ).length ){
			initZoacresPropertyLocationMap();
		}
		
		/* Custom Reqiured Field */
		if( $( ".meta-req" ).length ){
			$('.meta-req').hide();
			$( ".meta-req" ).each(function( index ) {
				var hidden_ele = this;
				var req_field = '#'+ $(this).attr('data-req');
				var req_val = $(this).attr('data-equal');
				var req_opr = $(this).attr('data-opr') ? $(this).attr('data-opr') : '';
				var req_selected = $( req_field ).find(":selected").val();
				
				if( req_opr == '=' || req_opr == '' ){
					if( req_selected == req_val ){
						$(this).show();
					}
				}else if( req_opr == '!=' ){
					if( req_selected != req_val ){
						$(this).show();
					}
				}
				
				$( req_field ).change(function() {
					req_selected = $( this ).find(":selected").val();
					
					if( req_opr == '=' || req_opr == '' ){
						if( req_selected == req_val ){
							$(hidden_ele).show();
						}else{
							if( $( hidden_ele ).find('select').length ){
								var t_val = $(hidden_ele).find('select').attr('id');
								$(hidden_ele).find('select').prop('selectedIndex',0);
								$(hidden_ele).parents('tbody').find('tr').filter('[data-req="'+ t_val +'"]').hide();
							}
							$(hidden_ele).hide();
						}
					}else if( req_opr == '!=' ){
						if( req_selected != req_val ){
							$(hidden_ele).show();
						}else{
							if( $( hidden_ele ).find('select').length ){
								var t_val = $(hidden_ele).find('select').attr('id');
								$(hidden_ele).find('select').prop('selectedIndex',0);
								$(hidden_ele).parents('tbody').find('tr').filter('[data-req="'+ t_val +'"]').hide();
							}
							$(hidden_ele).hide();
						}
					}
				});
				
			});
		}
		
		if( $( ".user-settings-wrap" ).length ){
			$( document ).on( "click", ".user-property-remove-confirm", function() {	
				var cur = $(this);
				var cur_parent = cur.parents(".property-wrap");
				var property_id = cur_parent.find(".user-settings-wrap").attr("data-id");
				cur_parent.find(".property-agent-process").fadeIn(300);
				
				if( property_id ){
					var property_data = {
						'action' : 'zoacres_property_remove',
						'nonce' : zoacres_ajax_var.property_remove,
						'property_id' : property_id
					}
					
					$.ajax({
						type: "post",
						url: zoacres_ajax_var.admin_ajax_url,
						data: property_data,
						dataType: 'JSON',
						success: function (data) {
							location.reload();
						},error: function(xhr, status, error) {
							console.log(xhr);
							location.reload();
						}
					});
				}
				
				return false;
			});
			$( document ).on( "click", ".user-property-remove", function() {	
				return false;
			});
			$( document ).on( "click", ".user-property-featured", function() {
				var cur = $(this);
				var property_id = cur.parents(".user-settings-wrap").attr("data-id");
				
				if( property_id ){
					var property_data = {
						'action' : 'zoacres_property_featured',
						'nonce' : zoacres_ajax_var.property_featured,
						'property_id' : property_id
					}
					
					$.ajax({
						type: "post",
						url: zoacres_ajax_var.admin_ajax_url,
						data: property_data,
						dataType: 'JSON',
						success: function (data) {
							if( data['msg'] == 'active' ){
								cur.addClass("featured-active");
							}else if( data['msg'] == 'inactive' ){
								cur.removeClass("featured-active");
							}
							location.reload();
						},error: function(xhr, status, error) {
							console.log(xhr);
							location.reload();
						}
					});
				}
				
				return false;
			});
		}
		
		if( $(".user-msg-delete").length ){
			$( document ).on( "click", ".user-msg-delete", function() {
				var cur = $(this);
				var rowid = cur.attr("data-row");
				if( rowid ){
					var msg_data = {
						'action' : 'zoacres_remove_inbox_msg',
						'nonce' : zoacres_ajax_var.remove_user_msg,
						'rowid' : rowid
					}
					
					cur.children("span").remove();
					cur.append('<span class="running-dots">'+ zoacres_ajax_var.del +'</span>');
					
					$.ajax({
						type: "post",
						url: zoacres_ajax_var.admin_ajax_url,
						data: msg_data,
						dataType: 'JSON',
						success: function (data) {
							if( data['msg'] == 'success' ){
								cur.parents("tr").remove();
							}
						},error: function(xhr, status, error) {
							console.log(xhr);
						}
					});
				}
				return false;
			});			
		}
		
		if( $(".user-msg-delete-all").length ){
			$( document ).on( "click", ".user-msg-delete-all", function() {
				var cur = $(this);

				var msg_data = {
					'action' : 'zoacres_remove_all_inbox_msg',
					'nonce' : zoacres_ajax_var.remove_user_msg
				}

				cur.html('<span class="running-dots">'+ zoacres_ajax_var.del +'</span>');
				
				$.ajax({
					type: "post",
					url: zoacres_ajax_var.admin_ajax_url,
					data: msg_data,
					dataType: 'JSON',
					success: function (data) {
						if( data['msg'] == 'success' ){
							cur.remove();
							location.reload();
						}
					},error: function(xhr, status, error) {
						console.log(xhr);
					}
				});

				return false;
			});			
		}
		
		if( $(".saved-search-remove").length ){
			$( document ).on( "click", ".saved-search-remove", function() {
				var cur = $(this);
				var rowid = cur.attr("data-key");
				if( rowid ){
					var msg_data = {
						'action' : 'zoacres_remove_saved_search',
						'nonce' : zoacres_ajax_var.remove_saved_search,
						'rowid' : rowid
					}
					
					cur.children("span").remove();
					cur.append('<span class="running-dots">'+ zoacres_ajax_var.del +'</span>');
					
					$.ajax({
						type: "post",
						url: zoacres_ajax_var.admin_ajax_url,
						data: msg_data,
						dataType: 'JSON',
						success: function (data) {
							if( data['msg'] == 'success' ){
								cur.parents(".card").remove();
								location.reload();
							}
						},error: function(xhr, status, error) {
							console.log(xhr);
						}
					});
				}
				return false;
			});			
		}
				
		//Animation call on window scroll
		$(window).scroll(function(){
			zoacres_scroll_animation();
		});
		
		//Halfmap template .half-map-property-list-wrap scroll animation. because window scroll deactivated here.
		if( $(".half-map-property-list-wrap").length ){
			$(".half-map-property-list-wrap").scroll(function(){
				zoacres_scroll_animation();
			});
		}
		
		//Print property
		$('.property-print').on("click", function(e){
			e.preventDefault();
			
			var prop_id, myWindow, ajaxurl;
			prop_id = $(this).attr('data-id');
		 
			myWindow=window.open('','Print Me','width=700 ,height=842');
			$.ajax({    
				type: 'POST',
				url: zoacres_ajax_var.admin_ajax_url, 
				data: {
					'action' : 'ajax_create_print',
					'property' : prop_id
				},
				success:function(data) {  
				   myWindow.document.write(data); 
					myWindow.document.close();
					myWindow.focus();
				},
				error: function(errorThrown){
				}

			});
			return false;
		});
		
		//Property Chart
		if( $("#property-days-views").length ){
			
			var days_view = [], daya_data = [];
			var data_options = JSON.parse( $("#property-days-views").attr("data-options") );
			var days_limit = $("#property-days-views").attr("data-limit");
			var chart_color = $("#property-days-views").attr("data-color");
			
			$.each(data_options, function (key, data) {
				days_view.push(key);
				daya_data.push(data);
			});
			
			days_view = days_view.slice(0, days_limit);
			daya_data = daya_data.slice(0, days_limit);
			
			
			
			var barChartData = {
				labels: days_view,
				datasets: [{
					label: 'Property Views',
					backgroundColor: chart_color,
					data: daya_data
				}]
			};

			window.onload = function() {
				var ctx = document.getElementById('property-days-views').getContext('2d');
				window.myBar = new Chart(ctx, {
					type: 'bar',
					data: barChartData,
					options: {
						responsive: true,
						legend: {
							position: 'none',
						},
						title: {
							display: false,
						}
					}
				});

			};
			
		}
		
		// Star Rating
		if( $("ul.star-rating").length ){

			$("ul.star-rating > li").on("click", function() {
				var index = $( this ).index();
				var parent = $( this ).parent( "ul.star-rating" );
				var i;
				
				//Reset
				$( parent ).find( "li > span" ).removeClass( "fa-star" ).addClass( "fa-star-o" );
				
				if( index != 0 ){
					for( i = 1; i <= index; i++ ){
						$( parent ).find( "li:eq("+ i +") > span" ).removeClass( "fa-star-o" ).addClass( "fa-star" );
					}
				}
				$( parent ).next( ".zoacres-meta-rating-value" ).val( index );
				
				var agent_id = $(".zoacres-meta-rating").attr("data-agent") ? $(".zoacres-meta-rating").attr("data-agent") : '';
				if( agent_id ){
					$.ajax({    
						type: 'POST',
						url: zoacres_ajax_var.admin_ajax_url, 
						data: {
							'nonce' : zoacres_ajax_var.agent_rate,
							'action' : 'set_agent_rate',
							'agent_id' : agent_id,
							'rating' : index
						},
						success:function(data) {  
							if( data == 'success' ){ 
								console.log("done.");
							}else{
								console.log("not done.");
							}
						},
						error: function(errorThrown){
						}

					});
				}
				return false;
				
			});
			
			// Meta Star Rating
			$( "ul.zoacres-meta-rating" ).each(function( index ) {
				var meta_val = $( this ).next( ".zoacres-meta-rating-value" ).val();
				if( meta_val ){
					//Reset
					$( this ).find( "li > span" ).removeClass( "fa-star" ).addClass( "fa-star-o" );
					var index = meta_val;
					
					if( index != 0 ){
						var i;
						for( i = 1; i <= index; i++ ){
							$( this ).find( "li:eq("+ i +") > span" ).removeClass( "fa-star-o" ).addClass( "fa-star" );
						}
					}
				}
			});
			
		} // Star rating exists
		
		//Remove documents
		if( $("ul.zoacres-docs-list").length ){
			$(document).on('click','ul.zoacres-docs-list > li > span',function(){
				var cur = $(this);
				var attc_id = cur.parent("li").attr("data-id");
				if( attc_id ){
					$.ajax({    
						type: 'POST',
						url: zoacres_ajax_var.admin_ajax_url, 
						data: {
							'nonce' : zoacres_ajax_var.remove_docs,
							'action' : 'zoacres_remove_docs',
							'attc_id' : attc_id
						},
						success:function(data) {  
						},
						error: function(errorThrown){
						}
					});	
					
					var file_ele = cur.parents(".property-docs-file-inner").find(".property-docs-file-final");
					var file_val = file_ele.val();
					file_val = file_val.replace(attc_id + ",", "");
					file_val = file_val.replace(attc_id, "");
					file_ele.val(file_val);
					cur.parent("li").remove();					
				}
			});
		}

	}); // doc ready end
	
	$( window ).load(function() {
		if( $( ".zoacresgmap" ).length ){
			initZoacresGmap();
		}
	});
	
	/*** Zoacres Functions ***/
	
	function zoacres_halfmap_height_set(header_height){
		var win_height = $(window).height();
		var prop_wrap_hg = win_height - header_height;
		$(".half-map-property-wrap").css({"top" : header_height+"px"});
		$(".zoacresgmap.zoacres-property-map").css({"height" : prop_wrap_hg+"px"});
		$(".half-map-property-list-wrap").css({"height" : prop_wrap_hg+"px"});
	}
	
	function doneKeySearch( e, cur_ele ) {
		var ele = $(cur_ele);
		
		var iKeyCode = (e.which) ? e.which : e.keyCode
		if ( ! ( iKeyCode <= 90 && iKeyCode >= 65 ) || ( iKeyCode <= 105 && iKeyCode >= 96 ) )
			return false;			
		
		if ( e.keyCode == 13 ) {
			e.preventDefault();
			return false;
		}else {
				
			var key_val = ele.val();
			var srch_dropdown = ele.parents(".bts-ajax-search").children(".ajax-search-dropdown");
			
			if( key_val ){
				
				if( $(cur_ele).parents(".property-list-identity").find(".map-property-list").length ){
					zoacresPropertySearch("property", '');
				}
				
				srch_dropdown.html('<img class="property-loader" src="'+ zoacres_ajax_var.search_load +'" />');
				srch_dropdown.addClass("show");
		
				var search_data = {
					'action' : 'key_search',
					'nonce' : zoacres_ajax_var.key_search,
					'key_val' : key_val
				};
				
				$.ajax({
					type: "post",
					url: zoacres_ajax_var.admin_ajax_url,
					dataType: 'JSON',				
					data: search_data,
					success: function (data) {
						var prop_res = data["property_json"];
						if( prop_res ){
							srch_dropdown.html( prop_res );
						}else{
							srch_dropdown.html('<ul class="property-search-list"><li>'+ zoacres_ajax_var.prop_not_found +'</li></ul>');
						}
						
					},error: function(xhr, status, error) {
						srch_dropdown.html('<ul class="property-search-list"><li>'+ zoacres_ajax_var.try_again +'</li></ul>');
					}
				});
			}else{
				srch_dropdown.removeClass("show");
			}

		}
		return false;
	}
	
	function zoacresPropertyAdd( featured_img, gallery_img, img_360, doc_files ){
	
		if( featured_img == 1 && gallery_img == 1 && img_360 ){
			var property_data = $("#add-new-property-form").serialize();
			$.ajax({
				type: 'post',
				dataType: 'json',
				url: zoacres_ajax_var.admin_ajax_url,
				data: property_data + "&action=zoacres_add_new_property&nonce=" + zoacres_ajax_var.property_add_new,
				success: function(data){
					console.log( data );
					$(".property-upload-parent .property-new-process").fadeOut(300);
					location.reload();
				},error: function(xhr, status, error) {
					console.log( xhr );
					$(".property-upload-parent .property-new-process").fadeOut(300);
				}
			});
		}
	
	}
	
	function zoacresPropertyUpdate( featured_img, gallery_img, img_360, doc_files ){
		if( featured_img == 1 && gallery_img == 1 && img_360 ){
			var property_data = $("#update-property-form").serialize();
			$.ajax({
				type: 'post',
				dataType: 'json',
				url: zoacres_ajax_var.admin_ajax_url,
				data: property_data + "&action=zoacres_update_property&nonce=" + zoacres_ajax_var.property_add_new,
				success: function(data){
					console.log( data );
					$(".property-upload-parent .property-new-process").fadeOut(300);
					location.reload();
				},error: function(xhr, status, error) {
					console.log( xhr );
					$(".property-upload-parent .property-new-process").fadeOut(300);
				}
			});
		}
	}
	
	function zoacresFilterProperty( filter_data, parent, loadmore_stat ){
	
		parent.find(".map-property-list").addClass("before-loader");
		parent.find(".property-loadmore").removeClass("disabled");

		$.ajax({
			type: 'post',
			dataType: 'json',
			url: zoacres_ajax_var.admin_ajax_url,
			data: filter_data,
			success: function(data){
				if( data["property_json"] ){
					var res = data["property_json"];
					if( loadmore_stat ){
						$("body").append('<div id="property-dynamic-res" style="display:none;">'+ res +'</div>');
						$("#property-dynamic-res .row > div").clone().appendTo( parent.find(".map-property-list > .row") );
						$("#property-dynamic-res").remove();
						var paged = parent.find(".property-loadmore").attr("data-page");
						parent.find(".property-loadmore").attr("data-page", ( parseInt( paged ) + 1 ));
						parent.find(".map-property-list").removeClass("before-loader");
						zoacres_scroll_animation();
					}else{
						$("body").append('<div id="property-dynamic-res" style="display:none;">'+ res +'</div>');
						$( parent.find(".map-property-list > .row") ).html('');
						$("#property-dynamic-res .row > div").clone().appendTo( parent.find(".map-property-list > .row") );
						$("#property-dynamic-res").remove();
						parent.find(".property-loadmore").attr("data-page", 2);
						parent.find(".map-property-list").removeClass("before-loader");
						zoacres_scroll_animation();
					}
				}else{
					parent.find(".property-loadmore").addClass("disabled");
					parent.find(".no-more-property").fadeIn(300);
					setTimeout(function(){
						parent.find(".no-more-property").fadeOut(500);
					}, 3000);
					parent.find(".map-property-list").removeClass("before-loader");
				}
			},error: function(xhr, status, error) {
				console.log( xhr );
				parent.find(".map-property-list").removeClass("before-loader");
			}
		});
	}
	
	function zoacres_scroll_animation(){
		setTimeout( function() {
			var anim_time = 300;
			$('.zoacres-animate:not(.run-animate)').each( function() {
				
				var elem = $(this);
				var bottom_of_object = elem.offset().top;
				var bottom_of_window = $(window).scrollTop() + $(window).height();
				
				if( bottom_of_window > bottom_of_object ){
					setTimeout( function() {
						elem.addClass("run-animate");
					}, anim_time );
				}
				anim_time += 300;
				
			});
		}, 200 );
	}
	
	//Email validation
	function zoacresValidateEmail(Email) {
		var pattern = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;

		return $.trim(Email).match(pattern) ? true : false;
	}
	
	function zoacresValidatePhone(Phone) {
		var pattern = /^[0-9-+ ]+$/;

		return $.trim(Phone).match(pattern) ? true : false;
	}
	
	function zoacresEmptyCheck(Field) {
		return Field != '' ? true : false;
	}
	
	function doneHalfMapSearch( e, cur_ele ) {			
		var ele = $(cur_ele);
		var key_val;
		
		var iKeyCode = (e.which) ? e.which : e.keyCode
		if ( ! ( iKeyCode <= 90 && iKeyCode >= 65 ) || ( iKeyCode <= 105 && iKeyCode >= 96 ) )
			return false;			
		
		if ( e.keyCode == 13 ) {
			e.preventDefault();
			return false;
		}else {						
			key_val = ele.val();
			if( $( ".map-property-list" ).length ){
				zoacresPropertySearch("property", cur_ele);
			}
			if( $( ".zoacres-property-map" ).length ){
				zoacresPropertySearch("map", cur_ele);
			}
		}		
	}
	
	function zoacresPropertySearch(map_stat, cele){
		
		var prop_key = $(".ajax-search-box").length ? $(".ajax-search-box").val() : '';
		var country_id = $(".search-country-id").length ? $(".search-country-id").val() : '';
		var state_id = $(".search-state-id").length ? $(".search-state-id").val() : '';
		var city_id = $(".search-city-id").length ? $(".search-city-id").val() : '';
		var area_id = $(".search-area-id").length ? $(".search-area-id").val() : '';
		var type_id = $(".search-type-id").length ? $(".search-type-id").val() : '';
		var action_id = $(".search-action-id").length ? $(".search-action-id").val() : '';
		var rooms_id = $(".search-rooms-id").length ? $(".search-rooms-id").val() : '';
		var bed_id = $(".search-bed-id").length ? $(".search-bed-id").val() : '';
		var bath_id = $(".search-baths-id").length ? $(".search-baths-id").val() : '';
		var garage_id = $(".search-garage-id").length ? $(".search-garage-id").val() : '';
		var minarea_id = $(".search-minarea-id").length ? $(".search-minarea-id").val() : '';
		var maxarea_id = $(".search-maxarea-id").length ? $(".search-maxarea-id").val() : '';
				
		var price_min = $(".slider-range-amount").length ? $(".slider-range-amount").attr("data-from") : '';
		var price_max = $(".slider-range-amount").length ? $(".slider-range-amount").attr("data-to") : '';
		var paged = $(".property-load-more").length ? $("#property-load-more").attr("data-page") : '1';
		var cols = $(".map-property-list").length ? $(".map-property-list").attr("data-cols") : '6';
		var layout = $(".map-property-list").length ? $(".map-property-list").attr("data-layout") : '';
		var full_map = $(".full-map-property-wrap").length ? true : false;
		var ppp = $(".map-property-list").length ? $(".map-property-list").attr("data-ppp") : '';
		var excerpt = $(".map-property-list").length ? $(".map-property-list").attr("data-excerpt") : '';
		var agent = $(".map-property-agent").length ? $(".map-property-agent").val() : '';
		var animation = $(".map-property-list").length ? $(".map-property-list").attr("data-animation") : false;
		
		var sort_val = $(".search-sort-filter-id").length ? $(".search-sort-filter-id").val() : '';
		
		var meta_args = '';
		if( $(cele).parents(".zoacres-search-property-wrap").length ){
			meta_args = $(cele).parents(".zoacres-search-property-wrap").find(".property-dynamic-ele").val();
			//meta_args = $.parseJSON( meta_args );
		}

		if( $(".property-more-features").length ){
			var more_search = [];
			$('.property-more-features:checked').each(function(i){
			  more_search[i] = $(this).val();
			});
		}
		
		var search_data = {
			'action' : 'zpropertygetting',
			'nonce' : zoacres_ajax_var.key_search,
			'key_val' : prop_key,
			'country_id' : country_id,
			'state_id' : state_id,
			'city_id' : city_id,
			'area_id' : area_id,
			'type_id' : type_id,
			'action_id' : action_id,
			'rooms_id' : rooms_id,
			'bed_id' : bed_id,
			'bath_id' : bath_id,
			'garage_id' : garage_id,
			'minarea_id' : minarea_id,
			'maxarea_id' : maxarea_id,
			'map_stat' : map_stat,
			'price_min' : price_min,
			'price_max' : price_max,
			'paged' : paged,
			'cols' : cols,
			'layout' : layout,
			'full_map' : full_map,
			'ppp' : ppp,
			'excerpt' : excerpt,
			'agent' : agent,
			'animation' : animation,
			'sort_val' : sort_val,
			'more_search' : more_search,
			'meta_args' : meta_args
		};
		
		if( map_stat == "property" ){
			$(".map-property-list").addClass("before-loader");
			$(".map-property-list").removeClass("nothing-found");
			$(".map-property-list").find(".property-nothing-found").fadeOut(300);
			
			var extra_args = $(".zoacres-property-map").attr("data-extra-args") ? $(".zoacres-property-map").attr("data-extra-args") : '';
			search_data.extra_args = extra_args;
			
			//For property
			$.ajax({
				type: "post",
				url: zoacres_ajax_var.admin_ajax_url,
				dataType: 'JSON',
				data: search_data,
				success: function (data) {
					//console.log( data );
					var res = data["property_json"];
					if( res != '' ){

						$("body").append('<div id="property-dynamic-res" style="display:none;">'+ data["property_json"] +'</div>');
						$(".map-property-list > .row").html('');
						$("#property-dynamic-res .row > div").clone().appendTo( ".map-property-list > .row" );
						$("#property-dynamic-res").remove();
						
						if( zoacres_ajax_var.user_log_stat ){
							$(".saved-search-text").removeClass( "saved-search-done" );
							$(".saved-search-wrap").fadeIn(300);
						}
						
						if( $(".property-sort-filter").length ){
							$(".property-sort-filter").fadeIn(300);
						}
						
						if( $(".property-load-more-wrap").length ){
							if( data["property_eof"] && data["property_eof"] == true ){
								$(".property-load-more-wrap").fadeOut(0);
								$(".property-load-more-wrap").children(".property-load-more-inner").fadeOut(0);
								$(".property-load-more-wrap").append('<p class="no-more-properties">'+ zoacres_ajax_var.no_more_property +'</p>');
								$(".property-load-more-wrap").fadeIn(300);
								
								setTimeout(function(){ 
									$(".property-load-more-wrap").fadeOut(500);
								}, 1000);
								
							}else{
								$(".property-load-more-wrap").removeClass("no-more-property");
								$(".property-load-more").attr('data-page',2);
								$(".property-load-more-wrap").fadeOut(0);
								$(".property-load-more-wrap").children(".property-load-more-inner").fadeIn(0);
								$(".property-load-more-wrap").children(".no-more-properties").fadeOut(0);
								$(".property-load-more-wrap").fadeIn(300);
							}
						}
					
						//$(".map-property-list").html(res);
					}else{
						$(".map-property-list").addClass("nothing-found");
						if( !$(".map-property-list").find(".property-nothing-found").length ){
							$(".map-property-list").append('<div class="property-nothing-found"><span class="icon-dislike icons"></span><p>'+ zoacres_ajax_var.not_found +'</p></div>');
						}else{
							$(".map-property-list").find(".property-nothing-found").fadeIn(300);
						}
					}
					$(".map-property-list").removeClass("before-loader");
					
					zoacres_scroll_animation();
					
				},error: function(xhr, status, error) {
					console.log(xhr);
					$(".map-property-list").removeClass("before-loader");
				}
			});
			
		}else if( map_stat == "map" ){
			
			$(".property-map-identity").addClass("before-loader");
			$(".property-map-identity").removeClass("nothing-found");
			$(".property-map-identity").find(".property-nothing-found").fadeOut(300);
			
			var extra_args = $(".zoacres-property-map").attr("data-extra-args") ? jQuery.parseJSON( $(".zoacres-property-map").attr("data-extra-args") ) : '';
			search_data.extra_args = extra_args;
			
			//For map property
			$.ajax({
				type: "post",
				url: zoacres_ajax_var.admin_ajax_url,
				dataType: 'JSON',				
				data: search_data,
				success: function (data) {
					var res = data["map_json"];
					if( res != '' ){
						$(".property-map-identity").html(res);
						initZoacresGmap();
					}else{
						$(".property-map-identity").addClass("nothing-found");
						if( !$(".property-map-identity").find(".property-nothing-found").length ){
							$(".property-map-identity").append('<div class="property-nothing-found"><span class="icon-dislike icons"></span><p>'+ zoacres_ajax_var.not_found +'</p></div>');
						}else{
							$(".property-map-identity").find(".property-nothing-found").fadeIn(300);
						}
					}
					$(".property-map-identity").removeClass("before-loader");
					
					zoacres_scroll_animation();
					
				},error: function(xhr, status, error) {
					console.log(xhr);
					$(".property-map-identity").removeClass("before-loader");
				}
			});
		}
				
	}
	
	//Map Function
	var near_markers = [];
	near_markers[0] = '';
	var panorama;
	var map_id, map_target, my_map_options;
	map_target = {
	  latitude : 0,
	  longitude: 0
	};
	var myloc_map;
	var directionsService;
	var directionsDisplay;
	var tlat;
	var tlng;
	
	function initZoacresGmap() {
		
		if( zoacres_ajax_var.map_stat == '0' ) return;
		
		var theme_color = $(".zoacres-property-map").length ? $(".zoacres-property-map").attr("data-theme") : '';
		
		var map_styles = '{ "Aubergine" : [	{"elementType":"geometry","stylers":[{"color":"#1d2c4d"}]},{"elementType":"labels.text.fill","stylers":[{"color":"#8ec3b9"}]},{"elementType":"labels.text.stroke","stylers":[{"color":"#1a3646"}]},{"featureType":"administrative.country","elementType":"geometry.stroke","stylers":[{"color":"#4b6878"}]},{"featureType":"administrative.land_parcel","elementType":"labels.text.fill","stylers":[{"color":"#64779e"}]},{"featureType":"administrative.province","elementType":"geometry.stroke","stylers":[{"color":"#4b6878"}]},{"featureType":"landscape.man_made","elementType":"geometry.stroke","stylers":[{"color":"#334e87"}]},{"featureType":"landscape.natural","elementType":"geometry","stylers":[{"color":"#023e58"}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#283d6a"}]},{"featureType":"poi","elementType":"labels.text.fill","stylers":[{"color":"#6f9ba5"}]},{"featureType":"poi","elementType":"labels.text.stroke","stylers":[{"color":"#1d2c4d"}]},{"featureType":"poi.park","elementType":"geometry.fill","stylers":[{"color":"#023e58"}]},{"featureType":"poi.park","elementType":"labels.text.fill","stylers":[{"color":"#3C7680"}]},{"featureType":"road","elementType":"geometry","stylers":[{"color":"#304a7d"}]},{"featureType":"road","elementType":"labels.text.fill","stylers":[{"color":"#98a5be"}]},{"featureType":"road","elementType":"labels.text.stroke","stylers":[{"color":"#1d2c4d"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#2c6675"}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#255763"}]},{"featureType":"road.highway","elementType":"labels.text.fill","stylers":[{"color":"#b0d5ce"}]},{"featureType":"road.highway","elementType":"labels.text.stroke","stylers":[{"color":"#023e58"}]},{"featureType":"transit","elementType":"labels.text.fill","stylers":[{"color":"#98a5be"}]},{"featureType":"transit","elementType":"labels.text.stroke","stylers":[{"color":"#1d2c4d"}]},{"featureType":"transit.line","elementType":"geometry.fill","stylers":[{"color":"#283d6a"}]},{"featureType":"transit.station","elementType":"geometry","stylers":[{"color":"#3a4762"}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#0e1626"}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"color":"#4e6d70"}]}], "Silver" : [{"elementType":"geometry","stylers":[{"color":"#f5f5f5"}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"elementType":"labels.text.fill","stylers":[{"color":"#616161"}]},{"elementType":"labels.text.stroke","stylers":[{"color":"#f5f5f5"}]},{"featureType":"administrative.land_parcel","elementType":"labels.text.fill","stylers":[{"color":"#bdbdbd"}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#eeeeee"}]},{"featureType":"poi","elementType":"labels.text.fill","stylers":[{"color":"#757575"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#e5e5e5"}]},{"featureType":"poi.park","elementType":"labels.text.fill","stylers":[{"color":"#9e9e9e"}]},{"featureType":"road","elementType":"geometry","stylers":[{"color":"#ffffff"}]},{"featureType":"road.arterial","elementType":"labels.text.fill","stylers":[{"color":"#757575"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#dadada"}]},{"featureType":"road.highway","elementType":"labels.text.fill","stylers":[{"color":"#616161"}]},{"featureType":"road.local","elementType":"labels.text.fill","stylers":[{"color":"#9e9e9e"}]},{"featureType":"transit.line","elementType":"geometry","stylers":[{"color":"#e5e5e5"}]},{"featureType":"transit.station","elementType":"geometry","stylers":[{"color":"#eeeeee"}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#c9c9c9"}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"color":"#9e9e9e"}]}], "Retro" : [{"elementType":"geometry","stylers":[{"color":"#ebe3cd"}]},{"elementType":"labels.text.fill","stylers":[{"color":"#523735"}]},{"elementType":"labels.text.stroke","stylers":[{"color":"#f5f1e6"}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#c9b2a6"}]},{"featureType":"administrative.land_parcel","elementType":"geometry.stroke","stylers":[{"color":"#dcd2be"}]},{"featureType":"administrative.land_parcel","elementType":"labels.text.fill","stylers":[{"color":"#ae9e90"}]},{"featureType":"landscape.natural","elementType":"geometry","stylers":[{"color":"#dfd2ae"}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#dfd2ae"}]},{"featureType":"poi","elementType":"labels.text.fill","stylers":[{"color":"#93817c"}]},{"featureType":"poi.park","elementType":"geometry.fill","stylers":[{"color":"#a5b076"}]},{"featureType":"poi.park","elementType":"labels.text.fill","stylers":[{"color":"#447530"}]},{"featureType":"road","elementType":"geometry","stylers":[{"color":"#f5f1e6"}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#fdfcf8"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#f8c967"}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#e9bc62"}]},{"featureType":"road.highway.controlled_access","elementType":"geometry","stylers":[{"color":"#e98d58"}]},{"featureType":"road.highway.controlled_access","elementType":"geometry.stroke","stylers":[{"color":"#db8555"}]},{"featureType":"road.local","elementType":"labels.text.fill","stylers":[{"color":"#806b63"}]},{"featureType":"transit.line","elementType":"geometry","stylers":[{"color":"#dfd2ae"}]},{"featureType":"transit.line","elementType":"labels.text.fill","stylers":[{"color":"#8f7d77"}]},{"featureType":"transit.line","elementType":"labels.text.stroke","stylers":[{"color":"#ebe3cd"}]},{"featureType":"transit.station","elementType":"geometry","stylers":[{"color":"#dfd2ae"}]},{"featureType":"water","elementType":"geometry.fill","stylers":[{"color":"#b9d3c2"}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"color":"#92998d"}]}], "Dark" : [{"elementType":"geometry","stylers":[{"color":"#212121"}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"elementType":"labels.text.fill","stylers":[{"color":"#757575"}]},{"elementType":"labels.text.stroke","stylers":[{"color":"#212121"}]},{"featureType":"administrative","elementType":"geometry","stylers":[{"color":"#757575"}]},{"featureType":"administrative.country","elementType":"labels.text.fill","stylers":[{"color":"#9e9e9e"}]},{"featureType":"administrative.land_parcel","stylers":[{"visibility":"off"}]},{"featureType":"administrative.locality","elementType":"labels.text.fill","stylers":[{"color":"#bdbdbd"}]},{"featureType":"poi","elementType":"labels.text.fill","stylers":[{"color":"#757575"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#181818"}]},{"featureType":"poi.park","elementType":"labels.text.fill","stylers":[{"color":"#616161"}]},{"featureType":"poi.park","elementType":"labels.text.stroke","stylers":[{"color":"#1b1b1b"}]},{"featureType":"road","elementType":"geometry.fill","stylers":[{"color":"#2c2c2c"}]},{"featureType":"road","elementType":"labels.text.fill","stylers":[{"color":"#8a8a8a"}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#373737"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#3c3c3c"}]},{"featureType":"road.highway.controlled_access","elementType":"geometry","stylers":[{"color":"#4e4e4e"}]},{"featureType":"road.local","elementType":"labels.text.fill","stylers":[{"color":"#616161"}]},{"featureType":"transit","elementType":"labels.text.fill","stylers":[{"color":"#757575"}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#000000"}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"color":"#3d3d3d"}]}], "Night" : [{"elementType":"geometry","stylers":[{"color":"#242f3e"}]},{"elementType":"labels.text.fill","stylers":[{"color":"#746855"}]},{"elementType":"labels.text.stroke","stylers":[{"color":"#242f3e"}]},{"featureType":"administrative.locality","elementType":"labels.text.fill","stylers":[{"color":"#d59563"}]},{"featureType":"poi","elementType":"labels.text.fill","stylers":[{"color":"#d59563"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#263c3f"}]},{"featureType":"poi.park","elementType":"labels.text.fill","stylers":[{"color":"#6b9a76"}]},{"featureType":"road","elementType":"geometry","stylers":[{"color":"#38414e"}]},{"featureType":"road","elementType":"geometry.stroke","stylers":[{"color":"#212a37"}]},{"featureType":"road","elementType":"labels.text.fill","stylers":[{"color":"#9ca5b3"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#746855"}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#1f2835"}]},{"featureType":"road.highway","elementType":"labels.text.fill","stylers":[{"color":"#f3d19c"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#2f3948"}]},{"featureType":"transit.station","elementType":"labels.text.fill","stylers":[{"color":"#d59563"}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#17263c"}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"color":"#515c6d"}]},{"featureType":"water","elementType":"labels.text.stroke","stylers":[{"color":"#17263c"}]}], "Blue" : [{"elementType":"geometry","stylers":[{"color":"#f5f5f5"}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"elementType":"labels.text.fill","stylers":[{"color":"#616161"}]},{"elementType":"labels.text.stroke","stylers":[{"color":"#f5f5f5"}]},{"featureType":"administrative.country","elementType":"geometry.fill","stylers":[{"color":"#4f8dec"},{"weight":1.5}]},{"featureType":"administrative.country","elementType":"geometry.stroke","stylers":[{"color":"#5765e3"}]},{"featureType":"administrative.country","elementType":"labels.text","stylers":[{"weight":5.5}]},{"featureType":"administrative.land_parcel","elementType":"labels.text.fill","stylers":[{"color":"#bdbdbd"}]},{"featureType":"administrative.locality","elementType":"labels.text.fill","stylers":[{"color":"#000000"},{"weight":7}]},{"featureType":"administrative.locality","elementType":"labels.text.stroke","stylers":[{"weight":3.5}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#eeeeee"}]},{"featureType":"poi","elementType":"labels.text.fill","stylers":[{"color":"#757575"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#e5e5e5"}]},{"featureType":"poi.park","elementType":"labels.text.fill","stylers":[{"color":"#9e9e9e"}]},{"featureType":"road","elementType":"geometry","stylers":[{"color":"#ffffff"}]},{"featureType":"road.arterial","elementType":"labels.text.fill","stylers":[{"color":"#757575"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#dadada"}]},{"featureType":"road.highway","elementType":"labels.text.fill","stylers":[{"color":"#616161"}]},{"featureType":"road.local","elementType":"labels.text.fill","stylers":[{"color":"#9e9e9e"}]},{"featureType":"transit.line","elementType":"geometry","stylers":[{"color":"#e5e5e5"}]},{"featureType":"transit.station","elementType":"geometry","stylers":[{"color":"#eeeeee"}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#c9c9c9"}]},{"featureType":"water","elementType":"geometry.fill","stylers":[{"color":"#46bcec"}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"color":"#9e9e9e"}]}], "Theme" : [{"elementType":"geometry","stylers":[{"color":"#f5f5f5"}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"elementType":"labels.text.fill","stylers":[{"color":"#616161"}]},{"elementType":"labels.text.stroke","stylers":[{"color":"#f5f5f5"}]},{"featureType":"administrative.country","elementType":"geometry.fill","stylers":[{"color":"#4f8dec"},{"weight":1.5}]},{"featureType":"administrative.country","elementType":"geometry.stroke","stylers":[{"color":"#5765e3"}]},{"featureType":"administrative.country","elementType":"labels.text","stylers":[{"weight":5.5}]},{"featureType":"administrative.land_parcel","elementType":"labels.text.fill","stylers":[{"color":"#bdbdbd"}]},{"featureType":"administrative.locality","elementType":"labels.text.fill","stylers":[{"color":"#000000"},{"weight":7}]},{"featureType":"administrative.locality","elementType":"labels.text.stroke","stylers":[{"weight":3.5}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#eeeeee"}]},{"featureType":"poi","elementType":"labels.text.fill","stylers":[{"color":"#757575"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#e5e5e5"}]},{"featureType":"poi.park","elementType":"labels.text.fill","stylers":[{"color":"#9e9e9e"}]},{"featureType":"road","elementType":"geometry","stylers":[{"color":"#ffffff"}]},{"featureType":"road.arterial","elementType":"labels.text.fill","stylers":[{"color":"#757575"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#dadada"}]},{"featureType":"road.highway","elementType":"labels.text.fill","stylers":[{"color":"#616161"}]},{"featureType":"road.local","elementType":"labels.text.fill","stylers":[{"color":"#9e9e9e"}]},{"featureType":"transit.line","elementType":"geometry","stylers":[{"color":"#e5e5e5"}]},{"featureType":"transit.station","elementType":"geometry","stylers":[{"color":"#eeeeee"}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#c9c9c9"}]},{"featureType":"water","elementType":"geometry.fill","stylers":[{"color":"'+ theme_color +'"}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"color":"#9e9e9e"}]}] }';
		
		var map_style_obj = JSON.parse(map_styles);
		
		var map_style_mode = [];
		var map_mode = '';
		var map_lang = '';
		var map_lat = '';
		var map_marker = '';
		var map_options = '';
		var infwin = [];
		var markers_pos = [];
		var near_latlang;
		
		$( ".zoacresgmap" ).each(function( index ) {
			
			var gmap = this;

			if( $( gmap ).attr( "data-map-style" ) ){
				map_mode = $( gmap ).data("map-style");
				map_lang = $( gmap ).data("map-lang");
				map_lat = $( gmap ).data("map-lat");
				map_marker = $( gmap ).data("map-marker");
				if( map_mode === 'aubergine' )
					map_style_mode = map_style_obj.Aubergine;
				else if( map_mode === 'silver' )
					map_style_mode = map_style_obj.Silver;
				else if( map_mode === 'retro' )
					map_style_mode = map_style_obj.Retro;
				else if( map_mode === 'dark' )
					map_style_mode = map_style_obj.Dark;
				else if( map_mode === 'night' )
					map_style_mode = map_style_obj.Night;
				else if( map_mode === 'theme' )
					map_style_mode = map_style_obj.Theme;
				else if( map_mode === 'blue' )
					map_style_mode = map_style_obj.Blue;
				else if( map_mode === 'custom' ){
					var c_style = $( gmap ).attr( "data-custom-style" ) && $( gmap ).attr( "data-custom-style" ) != '' ? JSON.parse( $( gmap ).attr( "data-custom-style" ) ) : '[]';
					map_style_mode = c_style;
				}else{
					map_style_mode = "[]";
				}
			}
			
			if( $( gmap ).attr( "data-multi-map" ) && $( gmap ).attr( "data-multi-map" ) == 'true' ){
				
				var map_values = JSON.parse( $( gmap ).attr( "data-maps" ) );
				
				if( map_values == '' ) return false;
				
				var map_wheel = $( gmap ).attr( "data-wheel" ) && $( gmap ).attr( "data-wheel" ) == 'true' ? true : false;
				var map_zoom = $( gmap ).attr( "data-zoom" ) && $( gmap ).attr( "data-zoom" ) != '' ? parseInt( $( gmap ).attr( "data-zoom" ) ) : 14;
				var map;
				
				var property_map = $( gmap ).hasClass("zoacres-property-map") ? true : false;

				var map_stat = 1;
				var markers = [];

				map_values.forEach( function( map_value ) {
					map_lat = map_value.map_latitude;
					map_lang = map_value.map_longitude;
					var LatLng = new google.maps.LatLng( map_lat, map_lang );
					near_latlang = LatLng;
					var mapProp= {
						center: LatLng,
						scrollwheel: map_wheel,
						zoom: map_zoom,
						zoomControl: false,
						streetViewControl: false,
						fullscreenControl: false,
						mapTypeControl: false,
						styles: map_style_mode
					};
					
					markers_pos.push(LatLng);
					
					//Create Map
					if( map_stat ){
						var t_gmap = $( gmap );
						map = new google.maps.Map( t_gmap[0], mapProp );
						myloc_map = map;
						map_stat = 0;
					}
					
					directionsService = new google.maps.DirectionsService;
					directionsDisplay = new google.maps.DirectionsRenderer({map: map});
					tlat = map_lat;
					tlng = map_lang;
					
					//Map Marker
					var marker = new google.maps.Marker({
						position: LatLng,
						icon: map_value.map_marker,
						map: map
					});
					
					markers.push(marker);
					
					//Info Window
					if( map_value.map_info_opt == 'on' ) {
						var info_title = map_value.map_info_title;
						var info_addr = map_value.map_info_address;
						
						var contentString = '';
						if( map_value.map_info_html ){
							contentString = '<div class="gmap-info-wrap"><span class="info-box-arrow"></span><span class="infobox-close"><i class="icon-close icons"></i></span><div class="gmap-info-inner">'+ info_addr +'</div></div>';
						}else{
							contentString = '<div class="gmap-info-wrap"><span class="info-box-arrow"></span><span class="infobox-close"><i class="icon-close icons"></i></span><div class="gmap-info-inner"><h3>'+ info_title +'</h3><p>'+ info_addr +'</p></div></div>';
						}

						//InfoBox
						var infobox_options = {
							content: contentString,
							disableAutoPan: true,
							maxWidth: 0,
							pixelOffset: new google.maps.Size( -110, 0 ),
							zIndex: null,
							boxStyle: { 
								width: "220px"
							},
							closeBoxMargin: "0",
							closeBoxURL: "",
							infoBoxClearance: new google.maps.Size(1, 1),
							isHidden: false,
							pane: "floatPane",
							enableEventPropagation: true
						};
						
						var zoacres_ib = new InfoBox(infobox_options);
						infwin.push(zoacres_ib);
						
						// Infobox Open
						google.maps.event.addListener( marker, "click", function (e) {
							zoacresCloseAllInfoBoxes( map, infwin, markers );
							zoacres_ib.open( map, this);
							map.panTo(marker.getPosition());
							map.panBy( 0, -200 );
						});
						
						// Infobox Close
						google.maps.event.addListener( zoacres_ib, 'domready', function(){
							$('.infobox-close').on("click", function (e) {
								e.preventDefault();
								zoacres_ib.close();
								map.panBy( 0, 200 );
							});
						});
						
						//infwin.push(zoacres_ib);
						
					}

					//Street View
					if( $( "#zoacres-street-view" ).length ){
						startStreetView( map, LatLng );
					}

				});
				
				if(  $( "#zoacres-map-zoomplus" ).length ){
					 google.maps.event.addDomListener(document.getElementById('zoacres-map-zoomplus'), 'click', function () {      
					   var current= parseInt( map.getZoom(),10);
					   current++;
					   if(current>20){
						   current=20;
					   }
					   map.setZoom(current);
					});  
				}
					
					
				if(  $( "#zoacres-map-zoomminus" ).length ){
					 google.maps.event.addDomListener(document.getElementById('zoacres-map-zoomminus'), 'click', function () {      
					   var current= parseInt( map.getZoom(),10);
					   current--;
					   if(current<0){
						   current=0;
					   }
					   map.setZoom(current);
					});  
				}
				
				//Nearby Set
				if( $( ".zoacres-nearby-icon-nav" ).length ){
					$( ".zoacres-nearby-icon-nav .near-by" ).on("click", function() {
						var near_id = $(this).data('id');
						var near_index = $(this).data('ind');
						nearByJson(near_id, near_index, near_latlang, map);
						return false;
					});
					
				}
				
				//Map style change dynamically
				if( $(".map-style-dropdown-menu").length ){
					$( document ).on( "click", ".map-style-dropdown-menu > a", function() {
						var map_style = $(this).attr("data-style") ? $(this).attr("data-style") : 'roadmap';
						map.setMapTypeId(map_style);
						return false;
					});
				}
				
				//Full screen process
				if( $(".map-full-screen").length ){
					$( document ).on( "click", ".map-full-screen", function() {
						$(this).parents(".property-map-identity").toggleClass("full-screen-map-actived");
						$("body").toggleClass("map-full-screen-activated");
						return false;
					});
				}
				
				//Map my location
				if( $(".map-my-location").length ){
					$( document ).on( "click", ".map-my-location", function() {
						my_map_options = {
						  enableHighAccuracy: true,
						  timeout: 5000,
						  maximumAge: 0
						};

						map_id = navigator.geolocation.getCurrentPosition(success, error, my_map_options);
						return false;
					});
				}

				var property_radius = '';
				var mproperty_radius = '';	
				if( $("#map-location-search-form").length ){
					
					// Empty the places when page load
					$("#map-location-search-form").val('');

					// Create the search box and link it to the UI element.
					var map_search_input = document.getElementById('map-location-search-form');
					var map_searchBox = new google.maps.places.SearchBox(map_search_input);
					
					var theme_color = zoacres_ajax_var.theme_color;
					
					map_searchBox.addListener('places_changed', function() {
					
						if (property_radius != '') {
							property_radius.setMap(null);
							property_radius = '';
						}
					
						var places = map_searchBox.getPlaces();
						var mbounds = new google.maps.LatLngBounds();
						places.forEach(function(place) {
							if (!place.geometry) {
							  console.log("Returned place contains no geometry");
							  return;
							}
							// codes removed
							if (place.geometry.viewport) {
							  // Only geocodes have viewport.
							  mbounds.union(place.geometry.viewport);
							} else {
							  mbounds.extend(place.geometry.location);
							}
						});
						
						var lat = mbounds.getNorthEast(); // LatLng of the north-east corner
						var lang = mbounds.getSouthWest(); 
						var LatLng = new google.maps.LatLng( lat.lat(), lang.lng() );
						var circle_args =  {
							map: map,
							center: LatLng
						};
						map.panTo(LatLng);
						
					});
					
				}
				
				/* Map Radius Search */
				if( $("#property-location-search-form").length ){
				
					// Empty the places when page load
					$("#property-location-search-form").val('');
					
					// Create the search box and link it to the UI element.
					var search_input = document.getElementById('property-location-search-form'); //$('#property-location-search-form');
					var searchBox = new google.maps.places.SearchBox(search_input);
					
					var theme_color = zoacres_ajax_var.theme_color;
					
					searchBox.addListener('places_changed', function() {
						var places = searchBox.getPlaces();
						
						var mradius = $("#property-radius-value").attr("data-min") ? $("#property-radius-value").attr("data-min") : 10;
						var mradius_val = parseInt( mradius ) * 1000;
						
						var bounds = new google.maps.LatLngBounds();
						  places.forEach(function(place) {
							if (!place.geometry) {
							  console.log("Returned place contains no geometry");
							  return;
							}
							// codes removed
							if (place.geometry.viewport) {
							  // Only geocodes have viewport.
							  bounds.union(place.geometry.viewport);
							} else {
							  bounds.extend(place.geometry.location);
							}
						  });
							
							
						if (property_radius != '') {
								property_radius.setMap(null);
								property_radius = '';
						}
						
						  var lat = bounds.getNorthEast(); // LatLng of the north-east corner
						  var lang = bounds.getSouthWest(); 
						  var LatLng = new google.maps.LatLng( lat.lat(), lang.lng() );
						  var circle_args =  {
							strokeColor: theme_color,
							strokeOpacity: 0.2,
							strokeWeight: 0,
							fillColor: theme_color,
							fillOpacity: 0.2,
							map: map,
							center: LatLng,
							radius: mradius_val
						};
						property_radius = new google.maps.Circle(circle_args);
						map.fitBounds(property_radius.getBounds());

					});
					
					if( $( "#property-radius" ).length ) {
	
						var min_val = Number( $( "#property-radius-value" ).attr("data-min") );
						var max_val = Number( $( "#property-radius-value" ).attr("data-max") );
						
						$( "#property-radius-value" ).text( min_val );
						
						$( "#property-radius" ).slider({
							min: min_val,
							max: max_val,
							values: [ min_val ],
							slide: function( event, ui ) {
								$( "#property-radius-value" ).text( ui.values[ 0 ] );
								$( "#property-radius-value" ).attr( "data-min", ui.values[ 0 ] );
								if( $("#property-location-search-form").val() != '' ){
									google.maps.event.trigger(searchBox, 'places_changed');
								}
							}
						});
					}
					
				}

				if( $( gmap ).attr( "data-cluster" ) && $( gmap ).attr( "data-cluster" ) == 'true' ){
				
					var cluster_img = $( gmap ).attr( "data-cluster-img" ) ? $( gmap ).attr( "data-cluster-img" ) : '';
				
					//Cluster making
					var clusterStyles = [
						{
							textColor: 'white',
							url: cluster_img,
							height: 52,
							width: 53
						}
					];
					var mcOptions = {
						gridSize: 80,
						styles: clusterStyles,
					};
					
					var markerCluster = new MarkerClusterer(map, markers, mcOptions);
					var last_map = -1;
					
					$( document ).on( "mouseenter", ".property-wrap", function() {
						$(this).unbind('mouseenter mouseleave');
						var i = $( this ).parent("div").index();
						if( $(".property-map-identity .property-map-nav").length ){
							$(".property-map-identity .property-map-nav").attr("data-index", i);
						}
						//setTimeout(function(){
							if( last_map != i && markers_pos[i] ){
								
								map.setZoom(16);
								var infw_new = infwin[i];
								google.maps.event.trigger( markers[i], 'click' );
							}
							last_map = i;
						//}, 300);
					});
					
					$( ".property-wrap" ).on( "mouseleave", function() {
						$(this).unbind('mouseenter mouseleave');
						var i = $( this ).parent("div").index();
						var infw = infwin[i];
						infw.close( map, markers[i] );
					});

					// Map prev next property
					$(".property-map-nav-next").unbind().unbind( "click", function( e ) {
						var mark_ind = parseInt( $(this).parents(".property-map-nav").attr("data-index") );

						mark_ind++;
						if( ( infwin.length ) > parseInt(mark_ind) ){
							$(this).parents(".property-map-nav").attr("data-index", mark_ind );
						}else{
							$(this).parents(".property-map-nav").attr("data-index", '0');
							mark_ind = 0;
						}
						
						if( map ){
							map.setZoom(16);
							var infw_new = infwin[mark_ind];
							google.maps.event.trigger( markers[mark_ind], 'click' );
						}
						
						return false;
					});
					
					// Map prev prev property
					$(".property-map-nav-prev").unbind().unbind( "click", function( e ) {
						var mark_ind = parseInt( $(this).parents(".property-map-nav").attr("data-index") );

						if( mark_ind ){
							mark_ind--;
							$(this).parents(".property-map-nav").attr("data-index", mark_ind);
						}else{
							$(this).parents(".property-map-nav").attr("data-index", parseInt( infwin.length - 1 ) );
							mark_ind = infwin.length - 1;
						}
						
						if( map ){
							map.setZoom(16);
							var infw_new = infwin[mark_ind];
							google.maps.event.trigger( markers[mark_ind], 'click' );
						}	
						
						return false;
					});
					
				} //data-cluster true if end
				
				
				
			}else{
			
				var LatLng = {lat: parseFloat(map_lat), lng: parseFloat(map_lang)};
				
				var map_wheel = $( gmap ).attr( "data-wheel" ) && $( gmap ).attr( "data-wheel" ) == 'true' ? true : false;
				var map_zoom = $( gmap ).attr( "data-zoom" ) && $( gmap ).attr( "data-zoom" ) != '' ? parseInt( $( gmap ).attr( "data-zoom" ) ) : 14;
				
				var mapProp= {
					center: LatLng,
					scrollwheel: map_wheel,
					zoom: map_zoom,
					styles: map_style_mode
				};
				var t_gmap = $( gmap );
				var map = new google.maps.Map( t_gmap[0], mapProp ); //document.getElementById("zoacresgmap")
				
				var marker = new google.maps.Marker({
				  position: LatLng,
				  icon: map_marker,
				  map: map
				});
				
				if( $( gmap ).attr( "data-info" ) == 1 ){
					var info_title = $( gmap ).attr( "data-info-title" ) ? $( gmap ).attr( "data-info-title" ) : '';
					var info_addr = $( gmap ).attr( "data-info-addr" ) ? $( gmap ).attr( "data-info-addr" ) : '';
					var contentString = '<div class="gmap-info-wrap"><h3>'+ info_title +'</h3><p>'+ info_addr +'</p></div>';
					var infowindow = new google.maps.InfoWindow({
					  content: contentString
					});
					marker.addListener( 'click', function() {
					  infowindow.open( map, marker );
					});
				}
				
				google.maps.event.addDomListener( window, 'resize', function() {
					var center = map.getCenter();
					google.maps.event.trigger(map, "resize");
					map.setCenter(LatLng);
				});
				
			}// data multi map false part end
			
		}); // end map each
		
	}
	
	function zoacresCloseAllInfoBoxes( map, infwin, markers ){
		if( infwin.length ){
			var i;
			for( i = 0; i < infwin.length; i++ ){
				var infw = infwin[i];
				//if( cur_info != markers[i] ){
					infw.close( map, markers[i] );
				//}
			}
		}
	}
							/**/
	
	function zoacresZoomControl(div, map) {
		// Get the control DIV. We'll attach our control UI to this DIV.
		var controlDiv = div;
		controlDiv.className = 'zoacres-map-zoomparent';
		
		var zoomin = document.createElement('div');
		zoomin.className = 'zoacres-map-zoomin';
		controlDiv.appendChild(zoomin);

		var zoominText = document.createElement('span');
		zoominText.innerHTML = '<i class="fa fa-plus"></i>';
		zoomin.appendChild(zoominText);

		var zoomout = document.createElement('div');
		zoomout.className = 'zoacres-map-zoomout';
		controlDiv.appendChild(zoomout);

		var zoomoutText = document.createElement('span');
		zoomoutText.innerHTML = '<i class="fa fa-minus"></i>';
		zoomout.appendChild(zoomoutText);		

		// Setup the click event listeners for zoom-in, zoom-out:
		google.maps.event.addDomListener(zoomout, 'click', function() {
		var currentZoomLevel = map.getZoom();
		if(currentZoomLevel != 0){
		 map.setZoom(currentZoomLevel - 1);}     
		});

		google.maps.event.addDomListener(zoomin, 'click', function() {
		var currentZoomLevel = map.getZoom();
		if(currentZoomLevel != 21){
		 map.setZoom(currentZoomLevel + 1);}
		});
	}
	
	function startStreetView( map, LatLng ){
		panorama = new google.maps.StreetViewPanorama(
			document.getElementById('zoacres-street-view'), {
			position: LatLng,
			pov: {
				heading: 10,
				pitch: 35
			}
		});
		//map.setStreetView(panorama);
	}
	
	function nearByJson(near_id, near_index, LatLng, nearmap ){
		
		var infowindow = new google.maps.InfoWindow({
			content: ''
		});
		
		var chk = 1;
		for (var i = 0; i < near_markers.length; i++) {
          if( near_markers[i].ind == near_index ){
		  	chk = 0;
			near_markers[i].ind = '';
			near_markers[i].data.setMap(null);
		  } 
        }
			
		//Clear Route
		directionsDisplay.setMap(null);
			
		if( !chk ){
			return;
		}
		
		var request = {
			location: LatLng,
			radius: 1000,
			types: [near_id] //e.g. school, restaurant,bank,bar,city_hall,gym,night_club,park,zoo
		};
		
		var service = new google.maps.places.PlacesService(nearmap);
		service.search(request, function(results, status) {
			//nearmap.setZoom(14);
			if (status == google.maps.places.PlacesServiceStatus.OK) {
				for (var i = 0; i < results.length; i++) {
					results[i].html_attributions='';
					dynamicMarker(results[i], near_id, near_index, near_markers, nearmap, infowindow);
				}
			}
		});
	}
	
	function dynamicMarker(places, near_id, near_index, near_markers, map, infoWindow){
		
		var placeLoc = places.geometry.location;
		var marker_t;
		
		marker_t = new google.maps.Marker({
			map: map,
			position: placeLoc,
			icon: { url: zoacres_ajax_var.assets_url +'/images/markers/'+ near_id +'.png' },
			visible:true
		});

		var tlat2 = placeLoc.lat();
		var tlng2 = placeLoc.lng();
		var distance = google.maps.geometry.spherical.computeDistanceBetween(new google.maps.LatLng(tlat, tlng), new google.maps.LatLng(tlat2, tlng2));  
		distance = (distance/1000);		
		
		google.maps.event.addListener(marker_t, 'click', function() {
			infoWindow.setContent("<div style=\"padding:10px; line-height:20px; \"><b>Name:</b> "+ places.name +"<br><b>Address:</b> "+ places.vicinity +"<br><b>Distance:</b> "+ distance.toFixed(2) +"km</div>");
			infoWindow.open(map, marker_t);
			
			//For Routing
			var myLatLng = new google.maps.LatLng( tlat, tlng );
			var desLatLng = new google.maps.LatLng( tlat2, tlng2 );
			directionsService.route({
			  origin: myLatLng,
			  destination: desLatLng,
			  travelMode: 'WALKING'
			}, function(response, status) {
				if(status === 'OK'){
					directionsDisplay.setMap(map);
					directionsDisplay.setOptions( { suppressMarkers: true } );
					directionsDisplay.setDirections(response);
				}else{	
					console.log('Directions request failed due to ' + status);
				}
			});
			
		});

		var near_markers_t = {};
		near_markers_t.ind = near_index;
		near_markers_t.data = marker_t;
		near_markers.push(near_markers_t);
	}
	
	function initZoacresPropertyLocationMap() {
		var map;
		var gmap = $( "#zoacres_property_location" );
		var map_lat, map_lang, zoom_lvl;
		map_lat = $("#zoacres_property_latitude").val();
		map_lang = $("#zoacres_property_longitude").val();
		if( map_lat == '' ){
			map_lat	= gmap.attr("data-lat");
			map_lang = gmap.attr("data-lang");
			zoom_lvl = 1;
		}else{
			zoom_lvl = 12;
		}
		
		var PropLatLng = {lat: parseFloat(map_lat), lng: parseFloat(map_lang)};
		map = new google.maps.Map( document.getElementById('zoacres_property_location'), {
			center: PropLatLng,
			zoom: zoom_lvl
        });

		var marker = new google.maps.Marker({
			position: PropLatLng,
			map: map,
        });
		
		google.maps.event.addListener(map, "click", function (e) {
			//lat and lng is available in e object
			var latLng = e.latLng;
			$("#zoacres_property_latitude").val(latLng.lat());
			$("#zoacres_property_longitude").val(latLng.lng());
		});
		
	}

	//Get lat lang
	function success(pos) {
		var crd = pos.coords;

		var MyPoint=  new google.maps.LatLng( pos.coords.latitude, pos.coords.longitude);
		myloc_map.setCenter(MyPoint); 
		var myloc_marker = new google.maps.Marker({
			position: MyPoint,
			map: myloc_map,
			icon: zoacres_ajax_var.my_location_pointer
		});
	}

	function error(err) {
		//console.warn('Map Warning: (' + err.code + '): ' + err.message);
	}

})( jQuery );
