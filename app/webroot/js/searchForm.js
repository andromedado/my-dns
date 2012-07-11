
new App.Module(function ($, app) {
	var Module = {name : 'searchForm'},
	searchForm,
	searchForms = [];
	
	searchForm = function ($form) {
		var t = this;
		searchForms.push(this);
		t.$form = $form.addClass('listening');
		t.id = $form.attr('id');
		t.url = $('#' + t.id + '_url').val();
		t.inputs = $form.find('input, select, textarea');
		t.$results = $('#' + t.id + '_results');
		$form.submit(function () {
			t.submit();
			return false;
		});
	};
	
	searchForm.prototype.submit = function () {
		var data = {};
		this.$results.ajMask(1);
		this.inputs.each(function (i, E) {
			var $E = $(E);
			if ($E.attr('name')) data[$E.attr('name')] = $E.val();
		});
		app.ajax({
			url : this.url,
			data : data,
			recip : this.$results
		});
	};
	
	Module.getSearchForms = function () {
		return searchForms;
	};
	
	Module.listen = function () {
		$(function () {
			$('form.search_form').not('.listening').each(function (i, E) {
				new searchForm($(E));
			});
		});
		return Module;
	};
	
	Module.onReady = Module.listen;
	
	return Module;
});
