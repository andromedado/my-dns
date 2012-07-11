
var TabSets = (function ($) {
	var _app = {},
		selClass = 'sel',
		tabSets = [],
		TabSet;
	
	TabSet = function ($div) {
		var t = this;
		tabSets.push(this);
		this.id = tabSets.length;
		this.$div = $div.attr('id', 'tabSet_' + this.id);
		this.$headers = $div.find('.headWrapper');
		this.$contents = $div.find('.bodyWrapper');
		this.$all = this.$headers.add(this.$contents);
		
		this.$headers.each(function (i, E){
			$(E).attr('id', 'tabHead_' + t.id + '_' + i);
		});
		this.$contents.each(function (i, E){
			$(E).attr('id', 'tabContent_' + t.id + '_' + i);
		});
		this.$div.on('click', '.headWrapper', function () {
			t.goToTab(this);
		});
	};
	
	TabSet.prototype.goToTab = function (el) {
		var w = String($(el).attr('id')).replace(/^\D+/, ''), selector;
		this.$all.removeClass(selClass);
		this.$contents.not('#tabContent_' + w).trigger('closeTab');
		selector = '#tabHead_' + w + ', #tabContent_' + w;
		$(selector).addClass(selClass);
		$('#tabContent_' + w).trigger('openTab');
		window.location.hash = '#tb' + w.replace(/^\d+_/, '');
	};
	
	TabSet.prototype.goToFirst = function () {
		return this.goToNum(1);
	};
	
	TabSet.prototype.goToNum = function (num) {
		while (!this.$headers.eq(num).length && this.$headers.length) {
			num--;
		}
		this.$headers.eq(num).click();
		return this;
	};
	
	_app.getNumTabSets = function () {
		return tabSets.length;
	};
	
	_app.getTabSets = function () {
		return tabSets;
	};
	
	$.fn.inTab = function () {
		return this.getTab().length > 0;
	};
	
	$.fn.inClosedTab = function () {
		return this.inTab() && !this.getTab().hasClass('sel');
	};
	
	$.fn.getTab = function () {
		return this.eq(0).closest('.bodyWrapper');
	};
	
	$(function () {
		var num = 0;
		if (window.location.hash) {
			num = String(window.location.hash).replace(/\D+/g, '');
		}
		$('div.tabSetWrap').each(function (i, E) {
			(new TabSet($(E))).goToNum(num);
		});
	});
	
	return _app;
}(jQuery));
