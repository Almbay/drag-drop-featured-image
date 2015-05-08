jQuery(document).ready(function($){
	
	// Set required variables:
	var dgdUploaderButtonClicked = false;
	
	// Media button hook:
	$('div.wp-media-buttons a.insert-media, div.wp-media-buttons a.add_media').live('click', function(){
		dgdUploaderButtonClicked = true;
	});
	
	// Media Library button hook (WP >= 3.5):
	$('a#dgd_library_button').live('click', function(){
		dgdUploaderButtonClicked = true;
		$('div.media-frame div.media-menu a.media-menu-item').eq(2).click();
		$('div.media-frame div.media-frame-router a.media-menu-item').eq(1).click();
	});
	
	// Media Library close hook:
	if (typeof wp !== 'undefined'){
		var frame = wp.media.editor.add('content');
		frame.on('escape', function(){
			dgdUploaderButtonClicked = false;
		});
	}
	
	// Set as featured image hook (WP < 3.5):
	$('a.wp-post-thumbnail').live('click', function(e){
		parent.tb_remove();
		parent.location.reload(1);
	});
	
	// Set as featured image handler (WP >= 3.5):
	$('div.media-toolbar-primary a.media-button-select').live('click', function(){
		if ($('div#post-body').length > 0){
			if (dgdUploaderButtonClicked){
				if (!$('div.media-frame').hasClass('hide-router')){
					doFetchFeaturedImage();
				}
			}
		}
	});
	
	
	// Fetch featured image function:
	function doFetchFeaturedImage(){	
		dgdUploaderButtonClicked = false;
		$.post(ajaxurl, {
			action: 'get_featured_image',
			post_id: dgd_post_id
		}, function (response){
			
			// Parse response AS JSON:
			response = $.parseJSON(response);
			
			// Valid response:
			if (response.response_code == 200){
				
				// Find current image and continue:
				if ($('#drag_to_upload div.inside').find('.attachment-full').length > 0){
					
					// Hide container:
					$('#current-uploaded-image').slideUp('medium', function(){
						
						// Update image with new info:
						var imageObject = $('#drag_to_upload div.inside img.attachment-full');
						var currentImageHeight = imageObject.outerHeight();
						imageObject.attr('src', response.response_content);
						imageObject.removeAttr('width');
						imageObject.removeAttr('height');
						imageObject.removeAttr('title');
						imageObject.removeAttr('alt');

						// Hide container:
						imageObject.load(function(){

							// Display container:
							$('#current-uploaded-image').slideDown('medium');

							// Fade in upload container:
							$('div#plupload-upload-ui').fadeIn('medium');
							$('#uploaderSection .loading').fadeOut('medium');

						});
						
					});
					
				}
				
			} else {
				alert(response.response_content);
			}

		});
	}
	
});