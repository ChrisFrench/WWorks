window.addEvent('domready', function(){
	// smooth anchor scrolling
	new SmoothScroll(); 
	// style area
	if(document.id('gkStyleArea')){
		$$('#gkColors a').each(function(element,index){
			element.addEvent('click',function(e){
	            e.stop();
				changeStyle(index+1);
			});
		});
		
		$$('#gkPatterns a').each(function(element,index){
			element.addEvent('click',function(e){
		        e.stop();
				changePattern(index+1);
			});
		});
	}
	// font-size switcher
	if(document.id('gkTools') && document.id('gkComponentWrap')) {
		var current_fs = 100;
		var content_fx = new Fx.Tween(document.id('gkComponentWrap'), { property: 'font-size', unit: '%', duration: 200 }).set(100);
		document.id('gkToolsInc').addEvent('click', function(e){ 
			e.stop(); 
			if(current_fs < 150) { 
				content_fx.start(current_fs + 10); 
				current_fs += 10; 
			} 
		});
		document.id('gkToolsReset').addEvent('click', function(e){ 
			e.stop(); 
			content_fx.start(100); 
			current_fs = 100; 
		});
		document.id('gkToolsDec').addEvent('click', function(e){ 
			e.stop(); 
			if(current_fs > 70) { 
				content_fx.start(current_fs - 10); 
				current_fs -= 10; 
			} 
		});
	}
	// nsp gallery suffix
	if($$('.gallery .nspMain')) {
		var arts = $$('.gallery .nspMain .nspArt');
		//
		arts.each(function(el, i) {
			//
			var img = el.getElement('.nspImage');
			var header = el.getElement('.nspHeader');
			var projectURL = (header.getElement('a')) ? header.getElement('a').getProperty('href') : '#';
			//
			if(header.getElement('a')) header.getElement('a').innerHTML = $GK_LANG_LANUCH_PROJECT;
			else header.innerHTML = $GK_LANG_LANUCH_PROJECT;
			//
			var text = el.getElement('.nspText');
			var info = el.getElements('.nspInfo');
			var readmore = el.getElement('.readon');
			//
			var container = new Element('div', { 'class': 'nspContainer', 'html': '<div></div>' });
			container.setStyles({'width': img.getSize().x + "px", 'height': img.getSize().y + "px" });
			container.inject(el.getElement('div'), 'bottom');
			container.setStyle('margin', container.getParent().getStyle('padding'));
			//
			container.getElement('div').addEvent('click', function() {
				window.location = projectURL;
			});
			header.addEvent('click', function() {
				window.location = projectURL;
			});
			//
			if(header) header.inject(container.getElement('div'), 'bottom');
			if(text) text.destroy();
			if(info) info.destroy();
			if(readmore) readmore.destroy();
		});
	}
});
// function to set cookie
function setCookie(c_name, value, expire) {
	var exdate=new Date();
	exdate.setDate(exdate.getDate()+expire);
	document.cookie=c_name+ "=" +escape(value) + ((expire==null) ? "" : ";expires=" + exdate.toUTCString());
}
// Function to change styles
function changeStyle(style){
	var file1 = $GK_TMPL_URL+'/css/style'+style+'.css';
	var file2 = $GK_TMPL_URL+'/css/typography.style'+style+'.css';
	new Asset.css(file1);
	new Asset.css(file2);
	Cookie.write('gk_myfolio_16_style', style, { duration:365, path: '/' });
}
// Function to change patterns
function changePattern(style){
	var file = $GK_TMPL_URL+'/css/pattern'+style+'.css';
	new Asset.css(file);
	Cookie.write('gk_myfolio_16_pattern', style, { duration:365, path: '/' });
}