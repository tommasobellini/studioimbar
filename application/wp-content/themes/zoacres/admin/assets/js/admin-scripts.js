(function( $ ) {
	"use strict";

	$( document ).ready(function() {
	
		/* Zoacres Widget Dependency */
		if( $(".widgets-holder-wrap").length ){
			$(document).ajaxSuccess(function(e, xhr, settings) {
				if(settings.data.search('action=save-widget') != -1) {
					
					$('.zoacres-widget-dependancy').each( function() {
						var org = $(this).attr("data-depend");
						var depend_val = $(this).attr("data-depend-val");;
						var parent = $(this).parents(".widget-content");
						var org_val = $(parent).find( "#" + org ).val();
						
						if( org_val == depend_val ){
							$(this).css('display', 'block');
						}else{
							$(this).css('display', 'none');
						}
					});
					// do other stuff
				}
			});
		}
		
		$('.zoacres-widget-dependancy').each( function() {
			var org = $(this).attr("data-depend");
			var depend_val = $(this).attr("data-depend-val");;
			var parent = $(this).parents(".widget-content");
			var org_val = $(parent).find( "#" + org ).val();
			
			if( org_val == depend_val ){
				$(this).css('display', 'block');
			}else{
				$(this).css('display', 'none');
			}
		});
		
		$(document).on('change', '.zoacres-widget-dependancy-select', function() {
			var val = this.value;
			var cur_id = $(this).attr("id");
			var parent = $(this).parents(".widget-content");
			
			 
			$(parent).find( ".zoacres-widget-dependancy[data-depend="+ cur_id +"]" ).each( function() {
				var depend_val = $(this).attr("data-depend-val");
				if( depend_val == val ){
					$(this).css('display', 'block');
				}else{
					$(this).css('display', 'none');
				}
			});
		});

		// Set Post Featured Status
		$(".zoacres-post-featured-status").change(function(){
												 
			var postid = $(this).attr('data-post');
			var stat;
			if( $(this).is( ":checked" ) ) {
				stat = 1;
			}else{
				stat = 0;
			}
			$( "#post-featured-stat-msg-" + postid ).text( zoacres_admin_ajax_var.process + "..." );
			if( postid ){
				// Ajax call
				$.ajax({
					type: "post",
					url: zoacres_admin_ajax_var.admin_ajax_url,
					data: "action=zoacres-post-featured-active&nonce="+zoacres_admin_ajax_var.featured_nonce+"&featured-stat="+ stat +"&postid="+ postid,
					success: function(data){
						$( "#post-featured-stat-msg-"+ postid ).text( "" );
					}
				});
			}
		});
		
		// Set Property Active/Inactive Status
		$(".zoacres-property-active-status").change(function(){
			
			var cur_prop_stat = $(this);
			var postid = cur_prop_stat.attr('data-post');
			var stat;
			if( cur_prop_stat.is( ":checked" ) ) {
				stat = 1;
			}else{
				stat = 0;
			}
			$( "#property-active-stat-msg-" + postid ).text( zoacres_admin_ajax_var.process + "..." );
			if( postid ){
				// Ajax call
				$.ajax({
					type: "post",
					url: zoacres_admin_ajax_var.admin_ajax_url,
					data: "action=zoacres-property-active&nonce="+zoacres_admin_ajax_var.property_active+"&property-stat="+ stat +"&postid="+ postid,
					success: function(data){
						if( data == "limit-crossed" ){
							$( "#property-active-stat-msg-"+ postid ).text( zoacres_admin_ajax_var.over_limit );
							cur_prop_stat.prop('checked', false);
						}else{
							$( "#property-active-stat-msg-"+ postid ).text( "" );
						}
					}
				});
			}
		});
		
		// Set Agent Post Active/Inactive Status
		$(".zoacres-agent-properties-status").change(function(){
												 
			var postid = $(this).attr('data-post');
			var stat;
			if( $(this).is( ":checked" ) ) {
				stat = 1;
			}else{
				stat = 0;
			}
			$( "#post-agent-properties-stat-msg-" + postid ).text( zoacres_admin_ajax_var.process + "..." );
			if( postid ){
				// Ajax call
				$.ajax({
					type: "post",
					url: zoacres_admin_ajax_var.admin_ajax_url,
					data: "action=zoacres-agent-properties-active&nonce="+zoacres_admin_ajax_var.agent_properties+"&agent-stat="+ stat +"&postid="+ postid,
					success: function(data){
						$( "#post-agent-properties-stat-msg-"+ postid ).text( "" );
					}
				});
			}
		});
		
		$( ".export-custom-sidebar" ).on("click", function() {
			// Ajax call
			$.ajax({
				type: "post",
				url: zoacres_admin_ajax_var.admin_ajax_url,
				data: "action=zoacres-custom-sidebar-export&nonce="+zoacres_admin_ajax_var.sidebar_nounce,
				success: function( data ){
					
					$("<a />", {
						"download": "custom-sidebars.json",
						"href" : "data:application/json," + encodeURIComponent( data )
					}).appendTo("body").on("click", function() {
						$(this).remove();
					})[0]. click();
					
				}
			});
			return false;
		});
		
		if( $( '#import-code-value' ).length ){
			$( '#redux-import' ).on("click", function( e ) {
					$( '#redux-import' ).attr( "disabled", "disabled" );
					if ( $( '#import-code-value' ).val() === "" && $( '#import-link-value' ).val() === "" ) {
						e.preventDefault();
						return false;
					}else{
						var json_data = '';
						var stat = '';
						if( $( '#import-code-value' ).val() != "" ){
							json_data = $( '#import-code-value' ).val();
							stat = 'data';
						}else if( $( '#import-link-value' ).val() != "" ){
							json_data = $( '#import-link-value' ).val()
							stat = 'url';
						}
						var post_data = { action: "zoacres-redux-themeopt-import", nonce: zoacres_admin_ajax_var.redux_themeopt_import, json_data : json_data, stat: stat };
						jQuery.post(zoacres_admin_ajax_var.admin_ajax_url, post_data, function( response ) {
							location.reload(true);
							$( '#redux-import' ).removeAttr( "disabled" );
						});
						
						return false;
					}
				}
			);
		}
		
		$('#zoacres_property_features input[type="checkbox"]').change(function() {
			var final_ele = $(this).parents("td").find(".zoacres_property_features");
			var final_val = '';
			$('#zoacres_property_features input[type="checkbox"]').each(function( index ) {
				if($(this).is(":checked")) {
					final_val = final_val + $(this).val() + ',';
				}
			});
			final_val = final_val != '' ? final_val.replace(/,\s*$/, "") : '';
			final_ele.val(final_val);
		});
		
		$('#zoacres_property_structures input[type="checkbox"]').change(function() {
			var final_ele = $(this).parents("td").find(".zoacres_property_structures");
			var final_val = '';
			$('#zoacres_property_structures input[type="checkbox"]').each(function( index ) {
				if($(this).is(":checked")) {
					final_val = final_val + $(this).val() + ',';
				}
			});
			final_val = final_val != '' ? final_val.replace(/,\s*$/, "") : '';
			final_ele.val(final_val);
		});
		
		// Theme Option Custom Fields
		if( $( "#zoacres_options-property-custom-fields" ).length ){
		
			$( "#zoacres_options-property-custom-fields" ).prepend( '<div id="zoacres-custom-panel"><div class="result"><table><tr><td><strong>'+ zoacres_admin_ajax_var.cf_index +'</strong></td><td><strong>'+ zoacres_admin_ajax_var.cf_field_name +'</strong></td><td><strong>'+ zoacres_admin_ajax_var.cf_field_type +'</strong></td><td><strong>'+ zoacres_admin_ajax_var.cf_dd_values +'</strong></td><td><strong>'+ zoacres_admin_ajax_var.cf_delete +'</strong></td></tr></table></div><input type="button" class="button btn btn-primary" value="'+ zoacres_admin_ajax_var.cf_add_new +'" id="add-new"><div class="dialog" id="zoacres-cus-form"><form class="form-horizontal"><div class="form-group"><label for="field-name">'+ zoacres_admin_ajax_var.cf_index +':</label><input type="text" id="field-index" class="form-control"></div><div class="form-group"><label for="field-name">'+ zoacres_admin_ajax_var.cf_field_name +':</label><input type="text" id="field-name" class="form-control"></div><div class="form-group"><label for="field-type">'+ zoacres_admin_ajax_var.cf_field_type +':</label><select id="field-type" class="form-control"><option value="text">'+ zoacres_admin_ajax_var.cf_text +'</option><option value="textarea">'+ zoacres_admin_ajax_var.cf_textarea +'</option><option value="checkbox">'+ zoacres_admin_ajax_var.cf_checkbox +'</option><option value="dropdown">'+ zoacres_admin_ajax_var.cf_dd +'</option></select></div><div class="form-group dd-field"><label for="field-name">'+ zoacres_admin_ajax_var.cf_dd_values +':</label><textarea id="ddval" class="form-control"></textarea><span>'+ zoacres_admin_ajax_var.cf_separate_txt +'</span></div><div class="form-control"><input type="button" class="button btn btn-primary" value="'+ zoacres_admin_ajax_var.cf_add +'" id="btn-add"><input type="button" class="button btn btn-primary" value="'+ zoacres_admin_ajax_var.cf_update +'" id="btn-update"><input type="button" class="button btn btn-primary" value="'+ zoacres_admin_ajax_var.cf_close +'" id="btn-close"></div><span id="cf-tr-id" data-id=""></span></form></div></div>' );
			
			var tbl_vals = $("#property-custom-fields-textarea").val();
			if( tbl_vals ){
				/*tbl_vals = tbl_vals.replace(/\Field Name/g, 'FieldName');*/
				var fname = zoacres_admin_ajax_var.cf_field_name;
				var ftype = zoacres_admin_ajax_var.cf_field_type;
				var fdd = zoacres_admin_ajax_var.cf_dd_values;
				tbl_vals = replaceAll( tbl_vals, fname, fname.replace(" ", "") );
				tbl_vals = replaceAll( tbl_vals, ftype, ftype.replace(" ", "") );
				tbl_vals = replaceAll( tbl_vals, fdd, fdd.replace(" ", "") );				

				var obj = eval( tbl_vals );
				var tr_id = 1;
				$.each(obj, function(i, item) {
					var res_html = '<tr id="cf-tr-'+ tr_id +'"><td>' + obj[i].Index + '</td><td>' + obj[i].FieldName + '</td><td>' + obj[i].FieldType + '</td><td>' + obj[i].DropdownValues + '</td><td><a href="#" class="remove-feature"><i class="fa fa-times"></i></a></td></tr>';
					$("#zoacres-custom-panel").children(".result").find("table").append(res_html);
					tr_id++;
					
				});
			}
			
			$(document).on( "click", "#zoacres-custom-panel .remove-feature", function( e ) {
				$(this).parent("td").parent("tr").remove();
				setTimeout(function(){
					var table = $('#zoacres-custom-panel .result table').tableToJSON(); // Convert the table into a javascript object
					var json = JSON.stringify(table);
					$("#property-custom-fields-textarea").val(json);
				}, 300);
				cf_json_update();
				return false;
			});
			
			$( document ).on("click", "#zoacres-custom-panel table td", function( e ) {
				if( !$(this).parent("tr").attr("id") ) return false;
				
				$("#zoacres-cus-form").fadeIn(300);
				$("#zoacres-cus-form").find("#cf-tr-id").attr( "data-id", $(this).parent("tr").attr("id") );
				$("#zoacres-cus-form").find("#field-index").val( $(this).parent("tr").find("td:first-child").html() );
				$("#zoacres-cus-form").find("#field-name").val( $(this).parent("tr").find("td:nth-child(2)").html() );
				var field_type = $(this).parent("tr").find("td:nth-child(3)").html();
				$("#zoacres-cus-form").find("#field-type").val( field_type );
				if( field_type == 'dropdown' ){
					$("#zoacres-cus-form").find("#ddval").val( $(this).parent("tr").find("td:nth-child(4)").html() );
					$("#zoacres-cus-form").find(".dd-field").fadeIn(300);
				}else{
					$("#zoacres-cus-form").find("#ddval").val('');
					$("#zoacres-cus-form").find(".dd-field").fadeOut(300);
				}
				
				$("#zoacres-cus-form #btn-update").fadeIn(100);
				$("#zoacres-cus-form #btn-add").fadeOut(100);
				
			});
			
			$( '#zoacres-custom-panel #btn-close' ).on("click", function( e ) {
				$("#zoacres-cus-form").fadeOut(300);
			});

			$( '#zoacres-custom-panel #add-new' ).on("click", function( e ) {
				cf_form_reset();
				$(this).next("#zoacres-cus-form").fadeToggle(300);
				
				$("#zoacres-cus-form #btn-add").fadeIn(100);
				$("#zoacres-cus-form #btn-update").fadeOut(100);
			});
			
			$( '#zoacres-cus-form #btn-update' ).on("click", function( e ) {
				var fld_id = $("#zoacres-cus-form #cf-tr-id").attr("data-id");
				var fld_index = $("#zoacres-cus-form #field-index").val();
				var fld_name = $("#zoacres-cus-form #field-name").val();
				var fld_type = $("#zoacres-cus-form #field-type").val();
				var fld_ddval = $("#zoacres-cus-form #ddval").val();
				
				$("#"+fld_id).children("td:first-child").html(fld_index);
				$("#"+fld_id).children("td:nth-child(2)").html(fld_name);
				$("#"+fld_id).children("td:nth-child(3)").html(fld_type);
				$("#"+fld_id).children("td:nth-child(4)").html(fld_ddval);
				
				cf_json_update();
				$("#zoacres-cus-form").fadeOut(300);
			});
			
			$( '#zoacres-custom-panel #zoacres-cus-form #field-type' ).change(function() {
				var s_val = this.value;
				if(s_val == 'dropdown'){
					$( '#zoacres-custom-panel #zoacres-cus-form #field-type' ).parents(".form-group").next(".form-group").fadeIn(300);
				}else{
					$( '#zoacres-custom-panel #zoacres-cus-form #field-type' ).parents(".form-group").next(".form-group").fadeOut(300);
				}
			});
			
			$("#zoacres-cus-form .form-horizontal #btn-add").on("click", function( e ) {
				var parent = $(this).parents(".form-horizontal");
				var tr_id = parent.parents("#zoacres-custom-panel").find(".result table tr:last-child").attr("id");
				if( tr_id ){
					tr_id = parseInt( tr_id.replace( "cf-tr-", "" ) );
					tr_id++;
				}else{
					tr_id = 1;
				}
				var fieldindex = parent.find("#field-index").val();
				var fieldname = parent.find("#field-name").val();
				var selectedtype = parent.find("#field-type option:selected").val();
				var ddvalues = parent.find("#ddval").val();
				var res_html = '<tr id="cf-tr-'+ tr_id +'"><td>' + fieldindex + '</td><td>' + fieldname + '</td><td>' + selectedtype + '</td><td>' + ddvalues + '</td><td><a href="#" class="remove-feature"><i class="fa fa-times"></i></a></td></tr>';
				$(this).parents("#zoacres-custom-panel").children(".result").find("table").append(res_html);
			
				cf_json_update();
				$("#zoacres-cus-form").fadeOut(300);
			});
			
			/* Define function for escaping user input to be treated as 
			   a literal string within a regular expression */
			function escapeRegExp(string){
				return string.replace(/[.*+?^${}()|[\]\\]/g, "\\$&");
			}
			 
			/* Define functin to find and replace specified term with replacement string */
			function replaceAll(str, term, replacement) {
			  return str.replace(new RegExp(escapeRegExp(term), 'g'), replacement);
			}
			
			function cf_form_reset(){
				var tr_id = $("#zoacres-custom-panel").find(".result table tr:last-child").attr("id");
				if( tr_id ){
					tr_id = parseInt( tr_id.replace( "cf-tr-", "" ) );
					tr_id++;
				}else{
					tr_id = 1;
				}
				$("#zoacres-cus-form #field-index").val(tr_id);
				$("#zoacres-cus-form #field-name").val('');
				$("#zoacres-cus-form #field-type").val('text');
				$("#zoacres-cus-form #ddval").val('');
				$("#zoacres-cus-form .dd-field").fadeOut(100);
			}
			
			function cf_json_update(){
				var table = $('#zoacres-custom-panel .result table').tableToJSON(); // Convert the table into a javascript object
				var json = JSON.stringify(table);
				$("#property-custom-fields-textarea").val(json);
			}
			
		}
		
		$(document).on('click','ul.zoacres-attachment-list > li > span',function(){
			var cur = $(this);
			var attc_id = cur.parent("li").attr("data-id");
			if( attc_id ){
				var file_ele = cur.parents(".meta_box_file_stuff").children(".meta_box_upload_file");
				var file_val = file_ele.val();
				file_val = file_val.replace(attc_id + ",", "");
				file_val = file_val.replace(attc_id, "");
				file_ele.val(file_val);
			}
			cur.parent("li").remove();
		});
		
	});
	
})(jQuery);

