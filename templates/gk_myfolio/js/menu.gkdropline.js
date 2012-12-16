window.addEvent('load', function() {
	var main = document.id('gkDropMain');
	var sub = document.id('gkDropSub');
	
	if(main) {
		var submenus = document.id('gkSubmenu').getElements('#gkDropSub > ul');
		var mainmenus = document.id('gkDropMain').getElements('li');
		var currentsub = null;
		
		mainmenus.each(function(el, i) {
				if(el.hasClass('active')){
					currentsub = submenus[i];
					currentsub.setStyle('left', 'auto');
					currentsub.setProperty('class', 'active');
				}
		});
		
		main.getElements('li').each(function(el, i) {
			el.addEvent('mouseenter', function() {
				if(currentsub) {
					currentsub.setStyle('left', '-999em'); 
					submenus.setProperty('class', '');
				}
                
				currentsub = submenus[i];
				currentsub.setStyle('left', 'auto');
				currentsub.setProperty('class', 'active');
			});
		});
	}
});  