jQuery(document).ready(function($){
	
	// Set required variables:
	var advancedCustomFieldClicked = false;
	
	// Load iOS Switch script:
	$('input.iOSToggle').iToggle();
	
	// Advanced custom fields fix:
	$('div.acf-image-uploader input.add-image').live('click', function(){
		advancedCustomFieldClicked = true;
	});
	
	// Set as featured image handler (WP < 3.5):
	$('a.wp-post-thumbnail').live('click', function(e){
		parent.tb_remove();
		parent.location.reload(1);
	});
	
	// Set as featured image handler (WP >= 3.5):
	$('div.media-toolbar-primary a.media-button-select').live('click', function(){
		if ($('div#post-body').length > 0){
			if (!advancedCustomFieldClicked){
				if (!$('div.media-frame').hasClass('hide-router')){ window.location.reload(1); }
			} else {
				advancedCustomFieldClicked = false;
			}
		} else {
			advancedCustomFieldClicked = false;
		}
	});
	
	// Media Library button handler (WP >= 3.5):
	$('a#dgd_library_button').live('click', function(){
		$('div.media-frame div.media-menu a.media-menu-item').eq(2).click();
		$('div.media-frame div.media-frame-router a.media-menu-item').eq(1).click();
	});
	
	// Info panel blob jump:
	$('div.blobContainer img').hover(function(){
		$(this).stop(true, false).animate({ marginTop: '-5px', opacity: 1.0 }, 200);
	}, function(){
		$(this).stop(true, false).animate({ marginTop: '0px', opacity: 0.7 }, 200);
	});
	
});