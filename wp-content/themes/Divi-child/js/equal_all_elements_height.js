//Equal Height generator use class .equal
function adjust_height(){
	
	var currentTallest = 0,
	currentRowStart = 0,
	rowDivs = new Array(),
	$el,
	topPosition = 0;

	jQuery('.equal:visible').each(function() {
		$el = jQuery(this);
		topPosition = $el.position().top;

		if (currentRowStart != topPosition) {

			// we just came to a new row.  Set all the heights on the completed row
			for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
				rowDivs[currentDiv].height(currentTallest);
			}

			// set the variables for the new row
			rowDivs.length = 0; // empty the array
			currentRowStart = topPosition;
			currentTallest = $el.height();
			rowDivs.push($el);

		} else {

			// another div on the current row.  Add it to the list and check if it's taller
			rowDivs.push($el);
			currentTallest = (currentTallest < $el.height()) ? ($el.height()) : (currentTallest);
			
		}

		// do the last row
		for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
			rowDivs[currentDiv].height(currentTallest);
		}
	});
}

adjust_height();

jQuery(window).resize( function(){
	setTimeout( function(){
 		jQuery('.equal').css({ height: '100%' });
 		adjust_height();
 	}, 500);
});


jQuery(window).load(function() {
 	adjust_height();
});