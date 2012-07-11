
(function ($) {
	
	$(function () {
		$('.date').datepicker({
			changeMonth: true,
			changeYear: true
		}).filter('.age').datepicker('option', 'yearRange', 'c-100:c');
	});
	
}(jQuery));
