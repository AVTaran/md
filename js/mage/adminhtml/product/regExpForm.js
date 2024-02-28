
jQuery(document).ready(function($) {

	$( function() {
		var dialog, form;
		var nameOfFieldForRegExp = "#productGrid_product_filter_sku";

		function getRegExp() {
			var regExp  = '',
				regExpW = '',
				regExpR = '',
				regExpB = '',
				regExpS = '',
				regExpD = '';

			// Warehouses
			var checkedWarehouses = $('input[name="warehouse[]"]:checked');
			if (checkedWarehouses.length > 0) {
				checkedWarehouses.each( function( chkboxIndex, chkbox ) {
					if (regExpW!='') { regExpW = regExpW + '|';}
					regExpW = regExpW + chkbox.value;
				});
				regExpW = '^('+regExpW+')';
			} else {
				$('input[name="warehouse[]"]').each( function( chkboxIndex, chkbox ) {
					regExpW = regExpW + chkbox.value;
				});
				regExpW = '^['+regExpW+']';
			}

			// Rows
			var checkedRows = $('input[name="row[]"]:checked');
			if (checkedRows.length > 0) {
				checkedRows.each( function( chkboxIndex, chkbox ) {
					if (regExpR!='') { regExpR = regExpR + '|';}
					regExpR = regExpR + chkbox.value;
				});
				regExpR = '('+regExpR+')';
			} else {
				regExpR = '[0-9]{1,2}';
			}

			// Bins
			var checkedBins = $('input[name="bin[]"]:checked');
			if (checkedBins.length > 0) {
				checkedBins.each( function( chkboxIndex, chkbox ) {
					if (regExpB!='') { regExpB = regExpB + '|';}
					regExpB = regExpB + chkbox.value;
				});
				regExpB = '('+regExpB+')';
			} else {
				regExpB = '[0-9]{1,2}';
			}

			// Shelves
			var shelfMinMax = $('input[id="shelves"]').val().split(" - ");
			var shelf = parseInt(shelfMinMax[0]);
			while (shelf<=parseInt(shelfMinMax[1])) {
				if (regExpS!='') { regExpS = regExpS + "|";}
				regExpS = regExpS+shelf;
				shelf = shelf + 5;
			}
			regExpS = '('+regExpS+')';

			// dimensions
			lessThenBox = $('input[name="dimension"]:checked').val();
			console.log(lessThenBox);
			var lessThenBox = null;

			if (lessThenBox=='true') {
				regExpD = '-[0-9]{1,2}\/[A-Z]{1,2}';
			}
			if (lessThenBox=='false') {
				regExpD = '-[0-9]{1,2}[\^\/]';
			}

			// total
			regExp = '#'+regExpW+''+regExpR+'-'+regExpB+'-'+regExpS+''+regExpD+'#';

			return regExp;
		}


		dialog = $( "#dialog-form" ).dialog({
			autoOpen: false,
			height: 500,
			width: 450,
			modal: true,
			buttons: {
				"Take it": function() {
					newRegExp = getRegExp();
					$('#newRegExpPlease').text(newRegExp);
					$(nameOfFieldForRegExp).val(newRegExp);
				},
				"Close": function() {
					dialog.dialog( "close" );
				}
			},
			close: function() {
				form[ 0 ].reset();
			}
		});

		form = dialog.find( "form" ).on( "submit", function( event ) {
			newRegExp = getRegExp();
			$('#newRegExpPlease').text(newRegExp);
		});

		// nice view for checkboxes and radio
		$(".checkboxInput").checkboxradio();
		$(".radioInput"   ).checkboxradio();


		// ToDo
		// https://jqueryui.com/slider/#custom-handle
		$( "#shelves-range" ).slider({
			range: true,
			min: 10,
			max: 160,
			step: 5,
			values: [ 10, 60 ],
			slide: function( event, ui ) {
				$( "#shelves" ).val( "" + ui.values[ 0 ] + " - " + ui.values[ 1 ] );
			}
		});
		$( "#shelves" ).val(
			"" +
			$( "#shelves-range" ).slider( "values", 0 ) +
			" - " +
			$( "#shelves-range" ).slider( "values", 1 )
		);

		// test button
		$( "#createRegExp" ).button().on( "click", function(evt) {
			dialog.dialog( "open" );
		});

		$(nameOfFieldForRegExp).mousedown(function(evt) {
			// console.log($(this));
			if (evt.ctrlKey) {
				dialog.dialog("open");
			}
		});

	} );

});


