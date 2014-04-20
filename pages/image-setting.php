<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<div class="wrap">
  <div class="form-wrap">
    <div id="icon-edit" class="icon32 icon32-posts-post"><br>
    </div>
    <h2><?php _e('Left right image slideshow gallery', 'lrisg'); ?></h2>
	<h3><?php _e('Widget setting', 'lrisg'); ?></h3>
    <?php
	$Lrisg_title = get_option('Lrisg_title');
	$Lrisg_width = get_option('Lrisg_width');
	$Lrisg_height = get_option('Lrisg_height');
	$Lrisg_pause = get_option('Lrisg_pause');
	$Lrisg_cycles = get_option('Lrisg_cycles');
	$Lrisg_persist = get_option('Lrisg_persist');
	$Lrisg_slideduration = get_option('Lrisg_slideduration');
	$Lrisg_random = get_option('Lrisg_random');
	$Lrisg_type = get_option('Lrisg_type');
	
	if (isset($_POST['Lrisg_submit'])) 
	{
		//	Just security thingy that wordpress offers us
		check_admin_referer('Lrisg_form_setting');
			
		$Lrisg_title = stripslashes($_POST['Lrisg_title']);
		$Lrisg_width = stripslashes($_POST['Lrisg_width']);
		$Lrisg_height = stripslashes($_POST['Lrisg_height']);
		$Lrisg_pause = stripslashes($_POST['Lrisg_pause']);
		$Lrisg_cycles = stripslashes($_POST['Lrisg_cycles']);
		$Lrisg_persist = stripslashes($_POST['Lrisg_persist']);
		$Lrisg_slideduration = stripslashes($_POST['Lrisg_slideduration']);
		$Lrisg_random = stripslashes($_POST['Lrisg_random']);
		$Lrisg_type = stripslashes($_POST['Lrisg_type']);
		
		update_option('Lrisg_title', $Lrisg_title );
		update_option('Lrisg_width', $Lrisg_width );
		update_option('Lrisg_height', $Lrisg_height );
		update_option('Lrisg_pause', $Lrisg_pause );
		update_option('Lrisg_cycles', $Lrisg_cycles );
		update_option('Lrisg_persist', $Lrisg_persist );
		update_option('Lrisg_slideduration', $Lrisg_slideduration );
		update_option('Lrisg_random', $Lrisg_random );
		update_option('Lrisg_type', $Lrisg_type );
		
		?>
		<div class="updated fade">
			<p><strong><?php _e('Details successfully updated.', 'lrisg'); ?></strong></p>
		</div>
		<?php
	}
	?>
	<script language="JavaScript" src="<?php echo WP_LRISG_PLUGIN_URL; ?>/pages/setting.js"></script>
    <form name="Lrisg_form" method="post" action="">
      
	  <label for="tag-title"><?php _e('Enter widget title', 'lrisg'); ?></label>
      <input name="Lrisg_title" id="Lrisg_title" type="text" value="<?php echo $Lrisg_title; ?>" size="80" />
      <p><?php _e('Enter widget title, Only for widget.', 'lrisg'); ?></p>
      
	  <label for="tag-width"><?php _e('Width (Only number)', 'lrisg'); ?></label>
      <input name="Lrisg_width" id="Lrisg_width" type="text" value="<?php echo $Lrisg_width; ?>" />
      <p><?php _e('Widget Width (only number). (Example: 250)', 'lrisg'); ?></p>
      
	  <label for="tag-height"><?php _e('Height of each image', 'lrisg'); ?></label>
      <input name="Lrisg_height" id="Lrisg_height" type="text" value="<?php echo $Lrisg_height; ?>" />
      <p><?php _e('Widget Height (only number). (Example: 200)', 'lrisg'); ?></p>
	  
	  <label for="tag-height"><?php _e('Pause', 'lrisg'); ?></label>
      <input name="Lrisg_pause" id="Lrisg_pause" type="text" value="<?php echo $Lrisg_pause; ?>" />
      <p><?php _e('Only Number / Pause time of the slideshow in milliseconds.', 'lrisg'); ?></p>
	  
	  <label for="tag-height"><?php _e('Cycles', 'lrisg'); ?></label>
      <input name="Lrisg_cycles" id="Lrisg_cycles" type="text" value="<?php echo $Lrisg_cycles; ?>" />
      <p><?php _e('Gallery will automatically start the slideshow and it will stop number of cycle mentioned in this property. (only number)', 'lrisg'); ?></p>
	  
	  <label for="tag-height"><?php _e('Persist', 'lrisg'); ?></label>
      <input name="Lrisg_persist" id="Lrisg_persist" type="text" value="<?php echo $Lrisg_persist; ?>" />
      <p></p>
	  
	  <label for="tag-height"><?php _e('Slide duration', 'lrisg'); ?></label>
      <input name="Lrisg_slideduration" id="Lrisg_slideduration" type="text" value="<?php echo $Lrisg_slideduration; ?>" />
      <p><?php _e('Slideshow transition duration in milliseconds.', 'lrisg'); ?></p>
	  
	  <label for="tag-height"><?php _e('Random', 'lrisg'); ?></label>
      <input name="Lrisg_random" id="Lrisg_random" type="text" value="<?php echo $Lrisg_random; ?>" />
      <p><?php _e('(YES/NO)', 'lrisg'); ?></p>
      
	  <label for="tag-height"><?php _e('Select your gallery group', 'lrisg'); ?></label>
	  <select name="Lrisg_type" id="Lrisg_type">
        <option value='GROUP1' <?php if($Lrisg_type=='GROUP1') { echo 'selected' ; } ?>>Group1</option>
        <option value='GROUP2' <?php if($Lrisg_type=='GROUP2') { echo 'selected' ; } ?>>Group2</option>
        <option value='GROUP3' <?php if($Lrisg_type=='GROUP3') { echo 'selected' ; } ?>>Group3</option>
        <option value='GROUP4' <?php if($Lrisg_type=='GROUP4') { echo 'selected' ; } ?>>Group4</option>
        <option value='GROUP5' <?php if($Lrisg_type=='GROUP5') { echo 'selected' ; } ?>>Group5</option>
        <option value='GROUP6' <?php if($Lrisg_type=='GROUP6') { echo 'selected' ; } ?>>Group6</option>
        <option value='GROUP7' <?php if($Lrisg_type=='GROUP7') { echo 'selected' ; } ?>>Group7</option>
        <option value='GROUP8' <?php if($Lrisg_type=='GROUP8') { echo 'selected' ; } ?>>Group8</option>
        <option value='GROUP9' <?php if($Lrisg_type=='GROUP9') { echo 'selected' ; } ?>>Group9</option>
        <option value='GROUP0' <?php if($Lrisg_type=='GROUP0') { echo 'selected' ; } ?>>Group0</option>
		<option value='Widget' <?php if($Lrisg_type=='Widget') { echo 'selected' ; } ?>>Widget</option>
		<option value='Sample' <?php if($Lrisg_type=='Sample') { echo 'selected' ; } ?>>Sample</option>
      </select>
      <p><?php _e('This field is to group the images. Select your group name to fetch the images for widget.', 'lrisg'); ?></p>
      
	  <input name="Lrisg_submit" id="Lrisg_submit" class="button-primary" value="<?php _e('Submit', 'lrisg'); ?>" type="submit" />
	  <input name="publish" lang="publish" class="button-primary" onclick="Lrisg_redirect()" value="<?php _e('Cancel', 'lrisg'); ?>" type="button" />
        <input name="Help" lang="publish" class="button-primary" onclick="Lrisg_help()" value="<?php _e('Help', 'lrisg'); ?>" type="button" />
	  <?php wp_nonce_field('Lrisg_form_setting'); ?>
    </form>
  </div>
  <br />
<p class="description">
	<?php _e('Check official website for more information', 'lrisg'); ?>
	<a target="_blank" href="<?php echo WP_LRISG_FAV; ?>"><?php _e('click here', 'lrisg'); ?></a>
</p>
</div>
