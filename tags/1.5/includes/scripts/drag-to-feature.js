jQuery(document).ready(function($){
	
	// Load iOS Switch script:
	$('input.iOSToggle').iToggle();
	
	// Info panel blob jump:
	$('div.blobContainer img').hover(function(){
		$(this).stop(true, false).animate({ marginTop: '-5px', opacity: 1.0 }, 200);
	}, function(){
		$(this).stop(true, false).animate({ marginTop: '0px', opacity: 0.7 }, 200);
	});
	
});