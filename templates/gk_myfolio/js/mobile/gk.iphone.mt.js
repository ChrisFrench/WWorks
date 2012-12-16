
window.addEvent('domready', function(){
	/*
		Menu code
	 */ 
	
	// stack of opened submenus
	var openedStack = [];
	// array of all submenus
	var submenus = [];
	// change all hrefs in links with submenu to #
	$$('#gkNav a.haschild').each(function(el, i){
		$$(el).set('href', '#'+i);
		var submenu = $$(el).getParent().getElement('ul');
		submenu.setStyle('display', 'none');
		document.id('gkMenuContent').appendChild(submenu[0]);
		submenus[i] = submenu;
	});
	// prepare events
	$$('#gkNav a.haschild').addEvent('click', function(e){
		var submenu = $$(submenus[parseInt($$(e.target).get('href').toString().replace(/\#/g, ''))]);
		openedStack.push(submenu);
		btnBack.setStyle('display', 'inline-block');
		openedStack[openedStack.length-2].setStyle('display', 'none');
		submenu.setStyle('display', 'block');
	});
	// prepare buttons handlers
	var btnMenu = document.id('gk-btn-menu');
	var btnSearch = document.id('gk-btn-search');
	var btnSwitch = document.id('gk-btn-switch');
	var btnBack = document.id('gk-btn-nav-prev');
	var btnClose = document.id('gk-btn-nav-close');
	// switcher desktop-mobile
	if(btnSwitch) {
		btnSwitch.addEvent('click', function(e){
			e.preventDefault();
			var agree = confirm(document.id('translation-confirm').get('html'));
			if(agree) {
				setCookie('gkGavernMobile'+$('#translation-name').html(), 'desktop', 365);
				window.location.reload();
			}
		});
	}
	// menu button
	btnMenu.addEvent('click', function() {
		document.id('gkMenuContent').setStyle('display', 'block');
		document.id('gkContent').setStyle('opacity', 0.3);
		// hide / show buttons
		btnMenu.setStyle('display', 'none');
		btnSearch.setStyle('display', 'none');
		btnClose.setStyle('display', 'block');
		openedStack.push(document.id('gkMenuContent').getElement('ul'));
	});
	// menu close button
	btnClose.addEvent('click', function() {
		document.id('gkMenuContent').setStyle('display', 'none');
		document.id('gkContent').setStyle('opacity', 1.0);
		// hide / show buttons
		btnMenu.setStyle('display', 'inline-block');
		btnSearch.setStyle('display', 'inline-block');
		btnClose.setStyle('display', 'none');
		btnBack.setStyle('display', 'none');
		// reset menu
		$$('#gkMenuContent ul').setStyle('display', 'none');
		document.id('gkMenuContent').getElement('ul').setStyle('display', 'block');
		openedStack = [];
	});
	// menu back button
	btnBack.addEvent('click', function() {
		var toHide = openedStack.pop();
		if(openedStack.length == 1) btnBack.setStyle('display', 'none');
		$$('#gkMenuContent ul').setStyle('display', 'none');
		openedStack[openedStack.length-1].setStyle('display', 'block');
	});
	
	if(btnSearch) {
		var search_opened = false;
		btnSearch.addEvent('click', function() {
			document.id('gkSearch').setStyle('display', (search_opened) ? 'none' : 'block');
			search_opened = !search_opened; 
		});
	}
	
	/* 
		Collapsible blocks code
	 */
	 
	if($$('.gkCollapsible').length > 0) {
		$$('.gkCollapsible').each(function(el, i) {
			$$(el).addEvent('click', function(){
				var toggled = $$('.gkFeaturedItem')[i];
				if(toggled.getStyle('display') == 'none' || toggled.getStyle('display') == '') {
					$$('.gkFeaturedItem')[i].setStyle('display', 'block');
					$$('.gkToggle')[i].set('class', 'gkToggle hide');
				} else {
					$$('.gkFeaturedItem')[i].setStyle('display', 'none');
					$$('.gkToggle')[i].set('class', 'gkToggle show');
				}
			});
			
			$$(el+' a').addEvent('click', function(e) {
				e.preventDefault(); // disable links on toggler
			});
		});
	}
});

function setCookie(c_name, value, expire) {
	var exdate=new Date();
	exdate.setDate(exdate.getDate()+expire);
	document.cookie=c_name+ "=" +escape(value) + ((expire==null) ? "" : ";expires=" + exdate.toUTCString());
}
