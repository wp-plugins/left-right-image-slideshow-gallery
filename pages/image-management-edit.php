<div class="wrap">
<?php
$did = isset($_GET['did']) ? $_GET['did'] : '0';

// First check if ID exist with requested ID
$sSql = $wpdb->prepare(
	"SELECT COUNT(*) AS `count` FROM ".WP_LRISG_TABLE."
	WHERE `Lrisg_id` = %d",
	array($did)
);
$result = '0';
$result = $wpdb->get_var($sSql);

if ($result != '1')
{
	?><div class="error fade"><p><strong>Oops, selected details doesn't exist.</strong></p></div><?php
}
else
{
	$Lrisg_errors = array();
	$Lrisg_success = '';
	$Lrisg_error_found = FALSE;
	
	$sSql = $wpdb->prepare("
		SELECT *
		FROM `".WP_LRISG_TABLE."`
		WHERE `Lrisg_id` = %d
		LIMIT 1
		",
		array($did)
	);
	$data = array();
	$data = $wpdb->get_row($sSql, ARRAY_A);
	
	// Preset the form fields
	$form = array(
		'Lrisg_path' => $data['Lrisg_path'],
		'Lrisg_link' => $data['Lrisg_link'],
		'Lrisg_target' => $data['Lrisg_target'],
		'Lrisg_title' => $data['Lrisg_title'],
		'Lrisg_order' => $data['Lrisg_order'],
		'Lrisg_status' => $data['Lrisg_status'],
		'Lrisg_type' => $data['Lrisg_type']
	);
}
// Form submitted, check the data
if (isset($_POST['Lrisg_form_submit']) && $_POST['Lrisg_form_submit'] == 'yes')
{
	//	Just security thingy that wordpress offers us
	check_admin_referer('Lrisg_form_edit');
	
	$form['Lrisg_path'] = isset($_POST['Lrisg_path']) ? $_POST['Lrisg_path'] : '';
	if ($form['Lrisg_path'] == '')
	{
		$Lrisg_errors[] = __('Please enter the image path.', WP_Lrisg_UNIQUE_NAME);
		$Lrisg_error_found = TRUE;
	}

	$form['Lrisg_link'] = isset($_POST['Lrisg_link']) ? $_POST['Lrisg_link'] : '';
	if ($form['Lrisg_link'] == '')
	{
		$Lrisg_errors[] = __('Please enter the target link.', WP_Lrisg_UNIQUE_NAME);
		$Lrisg_error_found = TRUE;
	}
	
	$form['Lrisg_target'] = isset($_POST['Lrisg_target']) ? $_POST['Lrisg_target'] : '';
	$form['Lrisg_title'] = isset($_POST['Lrisg_title']) ? $_POST['Lrisg_title'] : '';
	$form['Lrisg_order'] = isset($_POST['Lrisg_order']) ? $_POST['Lrisg_order'] : '';
	$form['Lrisg_status'] = isset($_POST['Lrisg_status']) ? $_POST['Lrisg_status'] : '';
	$form['Lrisg_type'] = isset($_POST['Lrisg_type']) ? $_POST['Lrisg_type'] : '';

	//	No errors found, we can add this Group to the table
	if ($Lrisg_error_found == FALSE)
	{	
		$sSql = $wpdb->prepare(
				"UPDATE `".WP_LRISG_TABLE."`
				SET `Lrisg_path` = %s,
				`Lrisg_link` = %s,
				`Lrisg_target` = %s,
				`Lrisg_title` = %s,
				`Lrisg_order` = %d,
				`Lrisg_status` = %s,
				`Lrisg_type` = %s
				WHERE Lrisg_id = %d
				LIMIT 1",
				array($form['Lrisg_path'], $form['Lrisg_link'], $form['Lrisg_target'], $form['Lrisg_title'], $form['Lrisg_order'], $form['Lrisg_status'], $form['Lrisg_type'], $did)
			);
		$wpdb->query($sSql);
		
		$Lrisg_success = 'Image details was successfully updated.';
	}
}

if ($Lrisg_error_found == TRUE && isset($Lrisg_errors[0]) == TRUE)
{
?>
  <div class="error fade">
    <p><strong><?php echo $Lrisg_errors[0]; ?></strong></p>
  </div>
  <?php
}
if ($Lrisg_error_found == FALSE && strlen($Lrisg_success) > 0)
{
?>
  <div class="updated fade">
    <p><strong><?php echo $Lrisg_success; ?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/admin.php?page=left-right-image-slideshow-gallery">Click here</a> to view the details</strong></p>
  </div>
  <?php
}
?>
<script language="JavaScript" src="<?php echo get_option('siteurl'); ?>/wp-content/plugins/left-right-image-slideshow-gallery/pages/setting.js"></script>
<div class="form-wrap">
	<div id="icon-edit" class="icon32 icon32-posts-post"><br></div>
	<h2><?php echo WP_Lrisg_TITLE; ?></h2>
	<form name="Lrisg_form" method="post" action="#" onsubmit="return Lrisg_submit()"  >
      <h3>Update image details</h3>
      <label for="tag-image">Enter image path</label>
      <input name="Lrisg_path" type="text" id="Lrisg_path" value="<?php echo $form['Lrisg_path']; ?>" size="125" />
      <p>Where is the picture located on the internet</p>
      <label for="tag-link">Enter target link</label>
      <input name="Lrisg_link" type="text" id="Lrisg_link" value="<?php echo $form['Lrisg_link']; ?>" size="125" />
      <p>When someone clicks on the picture, where do you want to send them</p>
      <label for="tag-target">Enter target option</label>
      <select name="Lrisg_target" id="Lrisg_target">
        <option value='_blank' <?php if($form['Lrisg_target']=='_blank') { echo 'selected' ; } ?>>_blank</option>
        <option value='_parent' <?php if($form['Lrisg_target']=='_parent') { echo 'selected' ; } ?>>_parent</option>
        <option value='_self' <?php if($form['Lrisg_target']=='_self') { echo 'selected' ; } ?>>_self</option>
        <option value='_new' <?php if($form['Lrisg_target']=='_new') { echo 'selected' ; } ?>>_new</option>
      </select>
      <p>Do you want to open link in new window?</p>
      <label for="tag-title">Enter image reference</label>
      <input name="Lrisg_title" type="text" id="Lrisg_title" value="<?php echo $form['Lrisg_title']; ?>" size="125" />
      <p>Enter image reference. This is only for reference.</p>
      <label for="tag-select-gallery-group">Select gallery type</label>
      <select name="Lrisg_type" id="Lrisg_type">
        <option value='GROUP1' <?php if($form['Lrisg_type']=='GROUP1') { echo 'selected' ; } ?>>Group1</option>
        <option value='GROUP2' <?php if($form['Lrisg_type']=='GROUP2') { echo 'selected' ; } ?>>Group2</option>
        <option value='GROUP3' <?php if($form['Lrisg_type']=='GROUP3') { echo 'selected' ; } ?>>Group3</option>
        <option value='GROUP4' <?php if($form['Lrisg_type']=='GROUP4') { echo 'selected' ; } ?>>Group4</option>
        <option value='GROUP5' <?php if($form['Lrisg_type']=='GROUP5') { echo 'selected' ; } ?>>Group5</option>
        <option value='GROUP6' <?php if($form['Lrisg_type']=='GROUP6') { echo 'selected' ; } ?>>Group6</option>
        <option value='GROUP7' <?php if($form['Lrisg_type']=='GROUP7') { echo 'selected' ; } ?>>Group7</option>
        <option value='GROUP8' <?php if($form['Lrisg_type']=='GROUP8') { echo 'selected' ; } ?>>Group8</option>
        <option value='GROUP9' <?php if($form['Lrisg_type']=='GROUP9') { echo 'selected' ; } ?>>Group9</option>
        <option value='GROUP0' <?php if($form['Lrisg_type']=='GROUP0') { echo 'selected' ; } ?>>Group0</option>
		<option value='Widget' <?php if($form['Lrisg_type']=='Widget') { echo 'selected' ; } ?>>Widget</option>
		<option value='sample' <?php if($form['Lrisg_type']=='Sample') { echo 'selected' ; } ?>>Sample</option>
      </select>
      <p>This is to group the images. Select your slideshow group. </p>
      <label for="tag-display-status">Display status</label>
      <select name="Lrisg_status" id="Lrisg_status">
        <option value='YES' <?php if($form['Lrisg_status']=='YES') { echo 'selected' ; } ?>>Yes</option>
        <option value='NO' <?php if($form['Lrisg_status']=='NO') { echo 'selected' ; } ?>>No</option>
      </select>
      <p>Do you want the picture to show in your galler?</p>
      <label for="tag-display-order">Display order</label>
      <input name="Lrisg_order" type="text" id="Lrisg_order" size="10" value="<?php echo $form['Lrisg_order']; ?>" maxlength="3" />
      <p>What order should the picture be played in. should it come 1st, 2nd, 3rd, etc.</p>
      <input name="Lrisg_id" id="Lrisg_id" type="hidden" value="">
      <input type="hidden" name="Lrisg_form_submit" value="yes"/>
      <p class="submit">
        <input name="publish" lang="publish" class="button-primary" value="Update Details" type="submit" />
        <input name="publish" lang="publish" class="button-primary" onclick="Lrisg_redirect()" value="Cancel" type="button" />
        <input name="Help" lang="publish" class="button-primary" onclick="Lrisg_help()" value="Help" type="button" />
      </p>
	  <?php wp_nonce_field('Lrisg_form_edit'); ?>
    </form>
</div>
<p class="description"><?php echo WP_Lrisg_LINK; ?></p>
</div>