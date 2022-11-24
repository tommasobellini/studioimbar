(function( $ ) {
	
	"use strict";
	
	$( document ).ready(function() {
	
		if( $( ".slider-range" ).length ) {
			
			
			$( ".property-price-search " ).each(function( index ) {
				
				var cur_range = $(this);
				
				var min_val = Number( cur_range.find( ".slider-range-amount" ).attr("data-min") );
				var max_val = Number( cur_range.find( ".slider-range-amount" ).attr("data-max") );
				var from_val = Number( cur_range.find( ".slider-range-amount" ).attr("data-from") );
				var to_val = Number( cur_range.find( ".slider-range-amount" ).attr("data-to") );
				var currency = cur_range.find( ".slider-range-amount" ).attr("data-currency");
				var currency_position = cur_range.find( ".slider-range-amount" ).attr("data-currency-position");
				var front_curr = '';
				var back_cur = '';
				if( currency_position == 'before' ) front_curr = currency;
				if( currency_position == 'after' ) back_cur = currency;
				
				cur_range.find( ".slider-range-amount" ).text( front_curr + from_val + back_cur + " - "+ front_curr + to_val + back_cur );
				
				cur_range.find( ".slider-range" ).slider({
					range: true,
					min: min_val,
					max: max_val,
					values: [ from_val, to_val ],
					slide: function( event, ui ) {
						cur_range.find( ".slider-range-amount" ).text( front_curr + ui.values[ 0 ] + back_cur + " - " + front_curr + ui.values[ 1 ] + back_cur );
						cur_range.find( ".slider-range-amount" ).attr("data-from", ui.values[ 0 ]);
						cur_range.find( ".slider-range-amount" ).attr("data-to", ui.values[ 1 ]);
					}
				});
			});
		}

	});
	
})( jQuery );