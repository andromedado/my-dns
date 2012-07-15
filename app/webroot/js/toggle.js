
new App.Module(function ($, app) {
	var Module = {name : 'toggle'},
	listening = false;
	
	Module.listen = function () {
		if (listening) return;
		listening = true;
		$('body').on('click', '.toggler', function () {
			$(this).closest('.toggle_wrap').find('.toggles').toggleClass('none');
		});
	};
	
	return Module;
});
