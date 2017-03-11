(function($){
	var initLayout = function() {
		var hash = window.location.hash.replace('#', '');
		var currentTab = $('ul.navigationTabs a')
							.bind('click', showTab)
							.filter('a[rel=' + hash + ']');
		if (currentTab.size() == 0) {
			currentTab = $('ul.navigationTabs a:first');
		}
		showTab.apply(currentTab.get(0));
	};	
	var showTab = function(e) {
		var tabIndex = $('ul.navigationTabs a')
							.removeClass('active')
							.index(this);
							
		//tab index 2 = comment of fb
		
		if(document.getElementById('fbcomments')){
			var fbTab = document.getElementById('fbcomments');
			if(tabIndex != 2){
				fbTab.style.visibility="hidden";
			}
			else
			{
				fbTab.style.visibility="visible";
				$("#fbheight").css("height",$("#fbcomments").css("height"));
			}			
		}
		
		$(this)
			.addClass('active')
			.blur();
		$('div.tab')
			.hide()
				.eq(tabIndex)
				.show();
	};
	
	EYE.register(initLayout, 'init');
})(jQuery)

$(document).ready(function(){
	if(document.getElementById('fbcomments'))
	document.getElementById('fbcomments').style.visibility="hidden";
});