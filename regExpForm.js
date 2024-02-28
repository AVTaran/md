

$( function() {

	console.log('regExpForm');

	var dialog, form;

		// From http://www.whatwg.org/specs/web-apps/current-work/multipage/states-of-the-type-attribute.html#e-mail-state-%28type=email%29
		// emailRegex = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/,
		// name = $( "#name" ),
		// email = $( "#email" ),
		// password = $( "#password" ),
		// allFields = $( [] ).add( name ).add( email ).add( password ),
		// tips = $( ".validateTips" );

	/*
	function updateTips( t ) {
		tips
			.text( t )
			.addClass( "ui-state-highlight" );
		setTimeout(function() {
			tips.removeClass( "ui-state-highlight", 1500 );
		}, 500 );
	}

	function checkLength( o, n, min, max ) {
		if ( o.val().length > max || o.val().length < min ) {
			o.addClass( "ui-state-error" );
			updateTips( "Length of " + n + " must be between " +
				min + " and " + max + "." );
			return false;
		} else {
			return true;
		}
	}

	function checkRegexp( o, regexp, n ) {
		if ( !( regexp.test( o.val() ) ) ) {
			o.addClass( "ui-state-error" );
			updateTips( n );
			return false;
		} else {
			return true;
		}
	}

	function addUser() {
		var valid = true;
		allFields.removeClass( "ui-state-error" );

		// valid = valid && checkLength( name, "username", 3, 16 );
		// valid = valid && checkLength( email, "email", 6, 80 );
		//valid = valid && checkLength( password, "password", 5, 16 );

		//valid = valid && checkRegexp( name, /^[a-z]([0-9a-z_\s])+$/i, "Username may consist of a-z, 0-9, underscores, spaces and must begin with a letter." );
		//valid = valid && checkRegexp( email, emailRegex, "eg. ui@jquery.com" );
		//valid = valid && checkRegexp( password, /^([0-9a-zA-Z])+$/, "Password field only allow : a-z 0-9" );

		//if ( valid ) {
		//	$( "#users tbody" ).append( "<tr>" +
		//		"<td>" + name.val() + "</td>" +
		//		"<td>" + email.val() + "</td>" +
		//		"<td>" + password.val() + "</td>" +
		//	"</tr>" );
		//	dialog.dialog( "close" );
		// }
		return valid;
	}
	*/


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

		//var lessThenBox = null;
		var lessThenBox = true;
		//var lessThenBox = false;

		if (lessThenBox===true) {
			regExpD = '-[0-9]{1,2}\/[A-Z]{1,2}';
		}
		if (lessThenBox===false) {
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
			},
			Cancel: function() {
				dialog.dialog( "close" );
			}
		},
		close: function() {
			form[ 0 ].reset();
			allFields.removeClass( "ui-state-error" );
		}
	});

	form = dialog.find( "form" ).on( "submit", function( event ) {
		// event.preventDefault();
		// addUser();
		newRegExp = getRegExp();
		$('#newRegExpPlease').text(newRegExp);
	});


	$( "input[type=checkbox]" ).checkboxradio();


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


	$( "#create-regExp" ).button().on( "click", function(evt) {
		//if (evt.ctrlKey) {
			dialog.dialog( "open" );
		//}
		// if (evt.altKey)
			// alert('Alt down');
	});



} );