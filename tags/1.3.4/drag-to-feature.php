<?php
	
	// Basic variables:
	$pluginDir = plugin_dir_url(__FILE__);
	
	// Byte formatting function:
	
	
?>
<div class="wrap">
	<div id="icon-themes" class="icon32"></div>
	<h2><?php _e('Options for Drag & Drop Featured Image'); ?></h2>
	
	<?php
	
		// Check for POST request:
		if (isset($_POST['updatePluginSettings'])){
		
			// Check that everything is set:
			if ($_POST['file_types'] && !empty($_POST['post_types'])){
				
				// Update post types:
				$selected = $_POST['post_types'];
				update_option('drag-drop-post-types', $selected);
				
				// Update formats:
				$selected = $_POST['file_types'];
				update_option('drag-drop-file-types', $selected);
				
				// Update filesize:
				if ($newLimit = (int) $_POST['filesize_limit']){
					if ($newLimit > 100){ $newLimit = (int) 100 * 1048576; }
					else if ($newLimit < 2){ $newLimit = (int) 2 * 1048576; }
					else { $newLimit = (int) $newLimit * 1048576; }
					update_option('drag-drop-filesize', $newLimit);
				} else {
					update_option('drag-drop-filesize', 2097152);
				}
				
				// Show message:
				echo '<div id="message" style="margin-top: 10px;" class="updated"><p><strong>Success:</strong> The plugin options have been successfully updated!</p></div>';
				
			} else {
				
				// Show message:
				echo '<div id="message" style="margin-top: 10px;" class="error"><p>Please make sure you filled in all the required fields before submitting. At least <em><strong>one post type</strong></em> and <em><strong>one extension</strong></em> must be selected!</p></div>';
				
			}
		}
		
	?>
	
	<div id="drag-to-feature-image" class="metabox-holder has-right-sidebar">
		
		<!-- Sidebar info -->
		<div class="inner-sidebar">
		
			<div class="postbox">
				<h3><span>Contact me</span></h3>
				<div class="inside">
					<p>If you have any questions regarding this plugin or have ideas on how to improve it then please dont hesitate to <a href="mailto:info@jonathanlundstrom.me">contact me.</a></p>
					<div class="blobContainer contact-me">
						<a href="mailto:info@jonathanlundstrom.me" title="Send me an email"><img src="<?php echo $pluginDir; ?>includes/images/blob-email.png" alt="" /></a>
						<a target="_blank" href="https://www.facebook.com/jonathanlundstrom" title="Find me on Facebook"><img src="<?php echo $pluginDir; ?>includes/images/blob-facebook.png" alt="" /></a>
						<a target="_blank" href="https://twitter.com/Plizzo" title="Find me on Twitter"><img src="<?php echo $pluginDir; ?>includes/images/blob-twitter.png" alt="" /></a>
						<a target="_blank" href="https://plus.google.com/111226368568418280015" title="Find me on Google+"><img class="last" src="<?php echo $pluginDir; ?>includes/images/blob-googleplus.png" alt="" /></a>
					</div>
				</div>
			</div>
		
		</div>
		
		<div id="post-body">
			<div id="post-body-content">
		
				<!-- Meta box -->
				<div id="manage-plugin-options" class="postbox">
					<h3 class="hndle"><span><?php _e('Available options:'); ?></span></h3>
					<div id="itoggle" class="inside" style="padding: 20px 30px;">
						<form action="" method="post">
							<strong>Which post types do you want the meta box to display at?</strong><br />
							<div class="containerDiv" style="margin: 2px 0px 20px 0px; overflow: hidden;">
								<?php $post_types = get_post_types(array('exclude_from_search' => false)); ?>
								<?php $selected = get_option('drag-drop-post-types'); ?>
								<div class="objectRow">
									<?php foreach ($post_types as $type): ?>
										<?php if ($type !== 'attachment'): ?>
											<?php $checked = (in_array($type, $selected)) ? 'checked="checked"' : ''; ?>
											<div class="toggleObject itoggle">
												<input class="iOSToggle" name="post_types[]" <?php echo $checked; ?> type="checkbox" id="type_<?php echo $type; ?>" value="<?php echo $type; ?>" />
												<p><?php echo ucfirst($type); ?></p>
											</div>
										<?php endif; ?>
									<?php endforeach; ?>
								</div>
							</div>
							
							<strong>Which of the following file types should be supported?</strong><br />
							<div class="containerDiv" style="margin: 2px 0px 20px 0px; overflow: hidden;">
								<?php $selected = get_option('drag-drop-file-types'); ?>
								<?php $file_types = array('jpg', 'jpeg', 'png', 'gif'); ?>
								<div class="objectRow">
									<?php foreach ($file_types as $ft): ?>
										<?php $checked = (in_array($ft, $selected)) ? 'checked="checked"' : ''; ?>
										<div class="toggleObject">
											<input class="iOSToggle" name="file_types[]" <?php echo $checked; ?> type="checkbox" id="filetype_<?php echo $ft; ?>" value="<?php echo $ft; ?>" />
											<p><?php echo mb_strtoupper($ft); ?></p>
										</div>
									<?php endforeach; ?>
								</div>
							</div>
							
							<strong>Do you want to modify the default filesize limitation?</strong><br />
							<small><em>The maximum value possible is 100MB, and the lowest is 2MB...</em></small><br />
							<input class="filesizeLimit" type="number" min="2" max="100" name="filesize_limit" value="<?php echo formatBytes(get_option('drag-drop-filesize'), 0); ?>" />
							
							<br /><br />
							
							<input type="submit" name="updatePluginSettings" class="button-secondary" value="Update settings" />
						</form>
					</div>
				</div>
				
			</div>
		</div>
		
	</div>
	
	<div id="contact-info" class="metabox-holder">
	
	</div>
	
</div>