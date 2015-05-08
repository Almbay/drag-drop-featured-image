<?php

	/*
		Plugin Name: Drag & Drop Featured Image
		Plugin URI: http://wordpress.org/extend/plugins/drag-drop-featured-image/description/
		Description: A drag'n'drop replacement for the featured image.
		Version: 1.3.5
		Author: Jonathan Lundström
		Author URI: http://www.jonathanlundstrom.me
		License: GPLv2 or later
	
		Code references and thanks to:
		http://wordpress.org/support/topic/use-php-to-set-featured-image
		http://wordpress.stackexchange.com/questions/33173/plupload-intergration-in-a-meta-box
	*/
	
	// Add default options:
	add_option('drag-drop-post-types', array('post', 'page'));
	add_option('drag-drop-file-types', array('jpg', 'jpeg', 'png', 'gif'));
	add_option('drag-drop-filesize', 20971520);
	
	// Add plugin actions:
	add_action('admin_menu', 'dgd_setMenuPage');
	add_action('plugins_loaded', 'dgd_pluginInit');
	add_action('admin_head', 'dgd_loadPanelScripts');
	add_action('add_meta_boxes', 'dgd_addNewMetaBox');
	add_action('add_meta_boxes', 'dgd_removeDefaultBoxes');
	add_action('admin_enqueue_scripts', 'dgd_removeDefaultScripts');
	add_action('wp_ajax_photo_gallery_upload', 'dgd_ajaxPhotoUpload');
	
	// Define constants:
	define('MY_TEXTDOMAIN', 'dgdfi');
	
	
	// Set localization:
	function dgd_pluginInit(){
		load_plugin_textdomain('dgdfi', false, dirname(plugin_basename(__FILE__)).'/languages/');
	}
	
	
	// Remove the default thumbnail box:
	function dgd_removeDefaultBoxes(){
		$selected = get_option('drag-drop-post-types');
		
		// Add theme support:
		add_theme_support('post-thumbnails', $selected);
		
		// Remove meta boxes:
		foreach ($selected as $post_type){
			add_post_type_support($post_type, 'thumbnail');
			remove_meta_box('postimagediv', $post_type, 'side');
			remove_meta_box('postimagediv', $post_type, 'normal');
			remove_meta_box('postimagediv', $post_type, 'advanced');
		}
	}
	
	
	// Include necessary scripts:
	function dgd_removeDefaultScripts(){
		global $hook_suffix, $post, $current_screen;
		if ($current_screen->base === 'post'){
			$pluginDir = plugin_dir_url(__FILE__);
			$currentPostType = get_post_type($post->ID);
			$selected = get_option('drag-drop-post-types');
			if (in_array($currentPostType, $selected)){
				wp_enqueue_script('plupload-all');
			}
		}
	}
	
	
	// Load option panel scripts:
	function dgd_loadPanelScripts(){
		
		// Set plugin dir:
		$pluginDir = plugin_dir_url(__FILE__);
		
		// Register styles:
		wp_register_style('itoggle_style', $pluginDir.'includes/style/engage.itoggle.css', false);
		wp_register_style('dgd_uploaderStyle', $pluginDir.'includes/style/drag-to-feature.css', false);
		
		// Register scripts:
		wp_register_script('itoggle_script', $pluginDir.'includes/scripts/engage.itoggle.1.7.min.js', 'jquery');
		wp_register_script('dgd_panelScript', $pluginDir.'includes/scripts/drag-to-feature.js', 'jquery');
		
		// Enqueue styles:
		wp_enqueue_style('itoggle_style');
		wp_enqueue_style('dgd_uploaderStyle');
		
		// Enqueue scripts:
		wp_enqueue_script('itoggle_script');
		wp_enqueue_script('dgd_panelScript');
		
	}
	
	
	// Add the meta box to the edit page:
	function dgd_addNewMetaBox(){
		$selected = get_option('drag-drop-post-types');
		foreach ($selected as $post_type){
			add_meta_box('drag_to_upload', __('Featured Image'), 'dgd_upload_meta_box', $post_type, 'side', 'default');
		}
	}
	
	
	// Add menu page to appearence:
	function dgd_setMenuPage(){
		add_theme_page(__('Options for Drag & Drop Featured Image', 'dgdfi'), __('D&D Featured Image', 'dgdfi'), 'manage_options', 'drag-drop-featured-image/drag-to-feature.php', '');
	}
	

	// Uploading functionality trigger:
	// (Most of the code comes from media.php and handlers.js)
	function dgd_upload_meta_box(){ ?>
		<?php $pluginDir = plugin_dir_url(__FILE__); ?>
		<div id="uploadContainer" style="margin-top: 10px;">
			
			<!-- Current image -->
			<div id="current-uploaded-image" class="<?php if (has_post_thumbnail()): ?>open<?php else: ?>closed<?php endif; ?>">
				<?php if (has_post_thumbnail()): ?>
					<?php the_post_thumbnail('full'); ?>
				<?php else: ?>
					<img class="attachment-full" src="" />
				<?php endif; ?>
				
				<?php global $post; ?>
				<?php $thumbnail_id = get_post_thumbnail_id($post->ID); ?>
				<?php $ajax_nonce = wp_create_nonce("set_post_thumbnail-$post->ID"); ?>
				<p class="hide-if-no-js"><a class="button-secondary" href="#" id="remove-post-thumbnail" onclick="WPRemoveThumbnail('<?php echo $ajax_nonce; ?>');return false;"><?php _e('Remove featured image'); ?></a></p>
			</div>
			
			<!-- Uploader section -->
			<div id="uploaderSection" style="position: relative;">
				<div class="loading"><img src="<?php echo $pluginDir; ?>includes/images/loading.gif" alt="Loading..." /></div>
				<div id="plupload-upload-ui" class="hide-if-no-js">
					<div id="drag-drop-area">
						<div class="drag-drop-inside">
							<p class="drag-drop-info"><?php _e('Drop files here'); ?></p>
							<p><?php _ex('or', 'Uploader: Drop files here - or - Select Files'); ?></p>
							<p class="drag-drop-buttons"><input id="plupload-browse-button" type="button" value="<?php esc_attr_e('Select Files'); ?>" class="button" /></p>
							<p><?php _e('from', 'dgdfi'); ?></p>
							<p class="drag-drop-buttons">
								<a href="<?php bloginfo('wpurl'); ?>/wp-admin/media-upload.php?post_id=<?php echo $post->ID; ?>&amp;tab=library&amp;=&post_mime_type=image&amp;TB_iframe=1&amp;width=640&amp;height=353" class="thickbox add_media button-secondary" id="content-browse_library" title="Browse Media Library" onclick="return false;"><?php _e('Media Library', 'dgdfi'); ?></a>
							</p>
						</div>
					</div>
				</div>
			</div>
			
			<!-- Hidden data -->
			<input type="hidden" id="attachmentQueryURL" value="<?php echo $pluginDir; ?>get-attachment.php" />
			
		</div>

		<?php
			global $post;
			$plupload_init = array(
				'runtimes'            => 'html5,silverlight,flash,html4',
				'browse_button'       => 'plupload-browse-button',
				'container'           => 'plupload-upload-ui',
				'drop_element'        => 'drag-drop-area',
				'file_data_name'      => 'async-upload',            
				'multiple_queues'     => true,
				//'max_file_size'       => wp_max_upload_size().'b',
				'max_file_size'       => get_option('drag-drop-filesize').'b',
				'url'                 => admin_url('admin-ajax.php'),
				'flash_swf_url'       => includes_url('js/plupload/plupload.flash.swf'),
				'silverlight_xap_url' => includes_url('js/plupload/plupload.silverlight.xap'),
				'filters'             => array(array('title' => __('Allowed Files', 'dgdfi'), 'extensions' => implode(',', get_option('drag-drop-file-types')))),
				'multipart'           => true,
				'urlstream_upload'    => true,

				// Additional parameters:
				'multipart_params'    => array(
					'_ajax_nonce' => wp_create_nonce('photo-upload'),
					'action'      => 'photo_gallery_upload', // The AJAX action name
					'postID'	  => $post->ID
				),
			);

			// Apply filters to initiate plupload:
			$plupload_init = apply_filters('plupload_init', $plupload_init); ?>

			<script type="text/javascript">
				jQuery(document).ready(function($){
					
					// Create uploader and pass configuration:
					var uploader = new plupload.Uploader(<?php echo json_encode($plupload_init); ?>);

					// Check for drag'n'drop functionality:
					uploader.bind('Init', function(up){
						var uploaddiv = $('#plupload-upload-ui');
						
						// Add classes and bind actions:
						if(up.features.dragdrop){
							uploaddiv.addClass('drag-drop');
							$('#drag-drop-area')
								.bind('dragover.wp-uploader', function(){ uploaddiv.addClass('drag-over'); })
								.bind('dragleave.wp-uploader, drop.wp-uploader', function(){ uploaddiv.removeClass('drag-over'); });

						} else{
							uploaddiv.removeClass('drag-drop');
							$('#drag-drop-area').unbind('.wp-uploader');
						}
					});

					// Initiate uploading script:
					uploader.init();

					// File queue handler:
					uploader.bind('FilesAdded', function(up, files){
						var hundredmb = 100 * 1024 * 1024, max = parseInt(up.settings.max_file_size, 10);
						
						// Limit to one limit:
						if (files.length > 1){
							alert("<?php _e('You may only upload one image at a time!', 'dgdfi'); ?>");
							return false;
						}
						
						// Loop through files:
						plupload.each(files, function(file){
							if (max > hundredmb && file.size > hundredmb && up.runtime != 'html5'){
								alert("<?php _e('The file you selected exceeds the maximum filesize limit.', 'dgdfi'); ?>");
							} else {
								// DEBUG: console.log(file);
							}
						});

						// Refresh and start:
						up.refresh();
						up.start();
						
						// Set sizes and hide container:
						var currentHeight = $('#uploaderSection').outerHeight();
						$('#uploaderSection').css({ height: currentHeight });
						$('div#plupload-upload-ui').fadeOut('medium');
						$('#uploaderSection .loading').fadeIn('medium');
						$('#current-uploaded-image').slideUp('medium');
						
					});
					
					// A new file was uploaded:
					uploader.bind('FileUploaded', function(up, file, response) {
						
						// Parse response AS JSON:
						response = $.parseJSON(response.response);
						
						// Find current image and continue:
						if ($('#drag_to_upload div.inside').find('.attachment-full').length > 0){
						
							// Update image with new info:
							var imageObject = $('#drag_to_upload div.inside img.attachment-full');
							var currentImageHeight = imageObject.outerHeight();
							imageObject.attr('src', response.image);
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
							
						}
						
					});
					
					// Remove image handler:
					$('#remove-post-thumbnail').live('click', function(){
						$('#current-uploaded-image').slideUp('medium');
					});
					
				});
			</script>
			
		<?php
	}
	
	
	// File upload handler:
	function dgd_ajaxPhotoUpload(){
		
		// Check referer, die if no ajax:
		check_ajax_referer('photo-upload');
		
		/// Upload file using Wordpress functions:
		$file = $_FILES['async-upload'];
		$status = wp_handle_upload($file, array('test_form'=>true, 'action' => 'photo_gallery_upload'));
	
		// Fetch post ID:
		global $post;
		$post_id = $_POST['postID'];
		
		// Insert uploaded file as attachment:
		$attach_id = wp_insert_attachment(array(
			'post_mime_type' => $status['type'],
			'post_title' => preg_replace('/\.[^.]+$/', '', basename($file['name'])),
			'post_content' => '',
			'post_status' => 'inherit'
		), $status['file'], $post_id);
		
		// Include the image handler library:
		require_once(ABSPATH . 'wp-admin/includes/image.php');
		
		// Generate meta data and update attachment:
		$attach_data = wp_generate_attachment_metadata($attach_id, $status['file']);
		wp_update_attachment_metadata($attach_id, $attach_data);
		
		// Check for current meta (update / add):
		if ($prevValue = get_post_meta($post_id, '_thumbnail_id', true)){
			update_post_meta($post_id, '_thumbnail_id', $attach_id, $prevValue);
		} else {
			add_post_meta($post_id, '_thumbnail_id', $attach_id);
		}
		
		// Get image sizes and correct thumb:
		$croppedImage = wp_get_attachment_image_src($attach_id, 'full');
		$imageDetails = getimagesize($croppedImage[0]);
		
		// Create response array:
		$uploadResponse = array(
			'image' => $croppedImage[0],
			'width' => $imageDetails[0],
			'height' => $imageDetails[1],
			'postID' => $post_id
		);
		
		// Return response and exit:
		echo json_encode($uploadResponse);
		exit;
		
	}
	
	
	// Byte formatting function:
	function formatBytes($bytes, $precision = 2) { 
		$units = array('B', 'KB', 'MB', 'GB', 'TB'); 
		$bytes = max($bytes, 0); 
		$pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
		$pow = min($pow, count($units) - 1); 
		$bytes /= pow(1024, $pow);
		return round($bytes, $precision); 
	}
	
	
?>