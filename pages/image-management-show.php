<?php
// Form submitted, check the data
if (isset($_POST['frm_Lrisg_display']) && $_POST['frm_Lrisg_display'] == 'yes')
{
	$did = isset($_GET['did']) ? $_GET['did'] : '0';
	
	$Lrisg_success = '';
	$Lrisg_success_msg = FALSE;
	
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
		?><div class="error fade"><p><strong><?php _e('Oops, selected details doesnt exist', 'lrisg'); ?></strong></p></div><?php
	}
	else
	{
		// Form submitted, check the action
		if (isset($_GET['ac']) && $_GET['ac'] == 'del' && isset($_GET['did']) && $_GET['did'] != '')
		{
			//	Just security thingy that wordpress offers us
			check_admin_referer('Lrisg_form_show');
			
			//	Delete selected record from the table
			$sSql = $wpdb->prepare("DELETE FROM `".WP_LRISG_TABLE."`
					WHERE `Lrisg_id` = %d
					LIMIT 1", $did);
			$wpdb->query($sSql);
			
			//	Set success message
			$Lrisg_success_msg = TRUE;
			$Lrisg_success = __('Selected record was successfully deleted.', 'lrisg');
		}
	}
	
	if ($Lrisg_success_msg == TRUE)
	{
		?><div class="updated fade"><p><strong><?php echo $Lrisg_success; ?></strong></p></div><?php
	}
}
?>
<div class="wrap">
  <div id="icon-edit" class="icon32 icon32-posts-post"></div>
    <h2><?php _e('Left right image slideshow gallery', 'lrisg'); ?>
	<a class="add-new-h2" href="<?php echo WP_LRISG_ADMIN_URL; ?>&amp;ac=add"><?php _e('Add New', 'lrisg'); ?></a></h2>
    <div class="tool-box">
	<?php
		$sSql = "SELECT * FROM `".WP_LRISG_TABLE."` order by Lrisg_type, Lrisg_order";
		$myData = array();
		$myData = $wpdb->get_results($sSql, ARRAY_A);
		?>
		<script language="JavaScript" src="<?php echo WP_LRISG_PLUGIN_URL; ?>/pages/setting.js"></script>
		<form name="frm_Lrisg_display" method="post">
      <table width="100%" class="widefat" id="straymanage">
        <thead>
          <tr>
            <th class="check-column" scope="row"><input type="checkbox" name="Lrisg_group_item[]" /></th>
			<th scope="col"><?php _e('Group', 'lrisg'); ?></th>
			<th scope="col"><?php _e('Reference', 'lrisg'); ?></th>
            <th scope="col"><?php _e('URL', 'lrisg'); ?></th>
			<th scope="col"><?php _e('Target', 'lrisg'); ?></th>
            <th scope="col"><?php _e('Order', 'lrisg'); ?></th>
            <th scope="col"><?php _e('Display', 'lrisg'); ?></th>
          </tr>
        </thead>
		<tfoot>
          <tr>
            <th class="check-column" scope="row"><input type="checkbox" name="Lrisg_group_item[]" /></th>
			<th scope="col"><?php _e('Group', 'lrisg'); ?></th>
			<th scope="col"><?php _e('Reference', 'lrisg'); ?></th>
            <th scope="col"><?php _e('URL', 'lrisg'); ?></th>
			<th scope="col"><?php _e('Target', 'lrisg'); ?></th>
            <th scope="col"><?php _e('Order', 'lrisg'); ?></th>
            <th scope="col"><?php _e('Display', 'lrisg'); ?></th>
          </tr>
        </tfoot>
		<tbody>
		<?php 
		$i = 0;
		if(count($myData) > 0 )
		{
			foreach ($myData as $data)
			{
				?>
				<tr class="<?php if ($i&1) { echo'alternate'; } else { echo ''; }?>">
					<td align="left"><input type="checkbox" value="<?php echo $data['Lrisg_id']; ?>" name="Lrisg_group_item[]"></td>
					<td>
					<strong><?php echo esc_html(stripslashes($data['Lrisg_type'])); ?></strong>
					<div class="row-actions">
						<span class="edit"><a title="Edit" href="<?php echo WP_LRISG_ADMIN_URL; ?>&amp;ac=edit&amp;did=<?php echo $data['Lrisg_id']; ?>"><?php _e('Edit', 'lrisg'); ?></a> | </span>
						<span class="trash"><a onClick="javascript:Lrisg_delete('<?php echo $data['Lrisg_id']; ?>')" href="javascript:void(0);"><?php _e('Delete', 'lrisg'); ?></a></span> 
					</div>
					</td>
					<td><?php echo esc_html(stripslashes($data['Lrisg_title'])); ?></td>
					<td><a href="<?php echo esc_html(stripslashes($data['Lrisg_path'])); ?>" target="_blank"><?php echo esc_html(stripslashes($data['Lrisg_path'])); ?></a></td>
					<td><?php echo esc_html(stripslashes($data['Lrisg_target'])); ?></td>
					<td><?php echo esc_html(stripslashes($data['Lrisg_order'])); ?></td>
					<td><?php echo esc_html(stripslashes($data['Lrisg_status'])); ?></td>
				</tr>
				<?php 
				$i = $i+1; 
			}
		}
		else
		{
			?><tr><td colspan="6" align="center"><?php _e('No records available', 'lrisg'); ?></td></tr><?php 
		}
		?>
		</tbody>
        </table>
		<?php wp_nonce_field('Lrisg_form_show'); ?>
		<input type="hidden" name="frm_Lrisg_display" value="yes"/>
      </form>	
	  <div class="tablenav">
	  <h2>
	  <a class="button add-new-h2" href="<?php echo WP_LRISG_ADMIN_URL; ?>&amp;ac=add"><?php _e('Add New', 'lrisg'); ?></a>
	  <a class="button add-new-h2" href="<?php echo WP_LRISG_ADMIN_URL; ?>&amp;ac=set"><?php _e('Widget setting', 'lrisg'); ?></a>
	  <a class="button add-new-h2" target="_blank" href="<?php echo WP_LRISG_FAV; ?>"><?php _e('Help', 'lrisg'); ?></a>
	  </h2>
	  </div>
	  <br />
	  <p class="description">
		<?php _e('Check official website for more information', 'lrisg'); ?>
		<a target="_blank" href="<?php echo WP_LRISG_FAV; ?>"><?php _e('click here', 'lrisg'); ?></a>
	  </p>
	</div>
</div>