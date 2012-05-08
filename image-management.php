<div class="wrap">
  <?php
  	global $wpdb;
    @$mainurl = get_option('siteurl')."/wp-admin/options-general.php?page=left-right-image-slideshow-gallery/image-management.php";
    @$DID=@$_GET["DID"];
    @$AC=@$_GET["AC"];
    @$submittext = "Insert Message";
	if($AC <> "DEL" and trim(@$_POST['Lrisg_link']) <>"")
    {
			if($_POST['Lrisg_id'] == "" )
			{
					$sql = "insert into ".WP_LRISG_TABLE.""
					. " set `Lrisg_path` = '" . mysql_real_escape_string(trim($_POST['Lrisg_path']))
					. "', `Lrisg_link` = '" . mysql_real_escape_string(trim($_POST['Lrisg_link']))
					. "', `Lrisg_target` = '" . mysql_real_escape_string(trim($_POST['Lrisg_target']))
					. "', `Lrisg_title` = '" . mysql_real_escape_string(trim($_POST['Lrisg_title']))
					. "', `Lrisg_order` = '" . mysql_real_escape_string(trim($_POST['Lrisg_order']))
					. "', `Lrisg_status` = '" . mysql_real_escape_string(trim($_POST['Lrisg_status']))
					. "', `Lrisg_type` = '" . mysql_real_escape_string(trim($_POST['Lrisg_type']))
					. "'";	
			}
			else
			{
					$sql = "update ".WP_LRISG_TABLE.""
					. " set `Lrisg_path` = '" . mysql_real_escape_string(trim($_POST['Lrisg_path']))
					. "', `Lrisg_link` = '" . mysql_real_escape_string(trim($_POST['Lrisg_link']))
					. "', `Lrisg_target` = '" . mysql_real_escape_string(trim($_POST['Lrisg_target']))
					. "', `Lrisg_title` = '" . mysql_real_escape_string(trim($_POST['Lrisg_title']))
					. "', `Lrisg_order` = '" . mysql_real_escape_string(trim($_POST['Lrisg_order']))
					. "', `Lrisg_status` = '" . mysql_real_escape_string(trim($_POST['Lrisg_status']))
					. "', `Lrisg_type` = '" . mysql_real_escape_string(trim($_POST['Lrisg_type']))
					. "' where `Lrisg_id` = '" . $_POST['Lrisg_id'] 
					. "'";	
			}
			$wpdb->get_results($sql);
    }
    
    if($AC=="DEL" && $DID > 0)
    {
        $wpdb->get_results("delete from ".WP_LRISG_TABLE." where Lrisg_id=".$DID);
    }
    
    if($DID<>"" and $AC <> "DEL")
    {
        $data = $wpdb->get_results("select * from ".WP_LRISG_TABLE." where Lrisg_id=$DID limit 1");
        if ( empty($data) ) 
        {
           echo "<div id='message' class='error'><p>No data available! use below form to create!</p></div>";
           return;
        }
        $data = $data[0];
        if ( !empty($data) ) $Lrisg_id_x = htmlspecialchars(stripslashes($data->Lrisg_id)); 
		if ( !empty($data) ) $Lrisg_path_x = htmlspecialchars(stripslashes($data->Lrisg_path)); 
        if ( !empty($data) ) $Lrisg_link_x = htmlspecialchars(stripslashes($data->Lrisg_link));
		if ( !empty($data) ) $Lrisg_target_x = htmlspecialchars(stripslashes($data->Lrisg_target));
        if ( !empty($data) ) $Lrisg_title_x = htmlspecialchars(stripslashes($data->Lrisg_title));
		if ( !empty($data) ) $Lrisg_order_x = htmlspecialchars(stripslashes($data->Lrisg_order));
		if ( !empty($data) ) $Lrisg_status_x = htmlspecialchars(stripslashes($data->Lrisg_status));
		if ( !empty($data) ) $Lrisg_type_x = htmlspecialchars(stripslashes($data->Lrisg_type));
        $submittext = "Update Message";
    }
    ?>
  <h2>Left right image slideshow gallery</h2>
  <script language="JavaScript" src="<?php echo get_option('siteurl'); ?>/wp-content/plugins/left-right-image-slideshow-gallery/inc/setting.js"></script>
  <form name="Lrisg_form" method="post" action="<?php echo $mainurl; ?>" onsubmit="return Lrisg_submit()"  >
    <table width="100%">
      <tr>
        <td colspan="2" align="left" valign="middle">Enter image url:</td>
      </tr>
      <tr>
        <td colspan="2" align="left" valign="middle"><input name="Lrisg_path" type="text" id="Lrisg_path" value="<?php echo @$Lrisg_path_x; ?>" size="125" /></td>
      </tr>
      <tr>
        <td colspan="2" align="left" valign="middle">Enter target link:</td>
      </tr>
      <tr>
        <td colspan="2" align="left" valign="middle"><input name="Lrisg_link" type="text" id="Lrisg_link" value="<?php echo @$Lrisg_link_x; ?>" size="125" /></td>
      </tr>
	  <tr>
        <td colspan="2" align="left" valign="middle">Enter target option:</td>
      </tr>
      <tr>
        <td colspan="2" align="left" valign="middle"><input name="Lrisg_target" type="text" id="Lrisg_target" value="<?php echo @$Lrisg_target_x; ?>" size="50" /> ( _blank, _parent, _self, _new )</td>
      </tr>
	  <tr>
        <td colspan="2" align="left" valign="middle">Enter image reference:</td>
      </tr>
      <tr>
        <td colspan="2" align="left" valign="middle"><input name="Lrisg_title" type="text" id="Lrisg_title" value="<?php echo @$Lrisg_title_x; ?>" size="125" /></td>
      </tr>
	  <tr>
        <td colspan="2" align="left" valign="middle">Enter gallery type (This is to group the images):</td>
      </tr>
      <tr>
        <td colspan="2" align="left" valign="middle"><input name="Lrisg_type" type="text" id="Lrisg_type" value="<?php echo @$Lrisg_type_x; ?>" size="50" /></td>
      </tr>
      <tr>
        <td align="left" valign="middle">Display Status:</td>
        <td align="left" valign="middle">Display Order:</td>
      </tr>
      <tr>
        <td width="22%" align="left" valign="middle"><select name="Lrisg_status" id="Lrisg_status">
            <option value="">Select</option>
            <option value='YES' <?php if(@$Lrisg_status_x=='YES') { echo 'selected' ; } ?>>Yes</option>
            <option value='NO' <?php if(@$Lrisg_status_x=='NO') { echo 'selected' ; } ?>>No</option>
          </select>
        </td>
        <td width="78%" align="left" valign="middle"><input name="Lrisg_order" type="text" id="Lrisg_rder" size="10" value="<?php echo @$Lrisg_order_x; ?>" maxlength="3" /></td>
      </tr>
      <tr>
        <td height="35" colspan="2" align="left" valign="bottom"><table width="100%">
            <tr>
              <td width="50%" align="left"><input name="publish" lang="publish" class="button-primary" value="<?php echo @$submittext?>" type="submit" />
                <input name="publish" lang="publish" class="button-primary" onclick="Lrisg_redirect()" value="Cancel" type="button" />
              </td>
              <td width="50%" align="right">
			  <input name="text_management1" lang="text_management" class="button-primary" onClick="location.href='options-general.php?page=left-right-image-slideshow-gallery/image-management.php'" value="Go to - Image Management" type="button" />
        	  <input name="setting_management1" lang="setting_management" class="button-primary" onClick="location.href='options-general.php?page=left-right-image-slideshow-gallery/left-right-image-slideshow-gallery.php'" value="Go to - Gallery Setting" type="button" />
			  <input name="Help" lang="publish" class="button-primary" onclick="Lrisg_help()" value="Help" type="button" />
			  </td>
            </tr>
          </table></td>
      </tr>
      <input name="Lrisg_id" id="Lrisg_id" type="hidden" value="<?php echo @$Lrisg_id_x; ?>">
    </table>
  </form>
  <div class="tool-box">
    <?php
	$data = $wpdb->get_results("select * from ".WP_LRISG_TABLE." order by Lrisg_type,Lrisg_order");
	if ( empty($data) ) 
	{ 
		echo "<div id='message' class='error'>No data available! use below form to create!</div>";
		return;
	}
	?>
    <form name="frm_Lrisg_display" method="post">
      <table width="100%" class="widefat" id="straymanage">
        <thead>
          <tr>
            <th width="10%" align="left" scope="col">Type
              </td>
            <th width="52%" align="left" scope="col">Reference
              </td>
			 <th width="10%" align="left" scope="col">Target
              </td>
            <th width="8%" align="left" scope="col">Order
              </td>
            <th width="7%" align="left" scope="col">Display
              </td>
            <th width="13%" align="left" scope="col">Action
              </td>
          </tr>
        </thead>
        <?php 
        $i = 0;
        foreach ( $data as $data ) { 
		if($data->Lrisg_status=='YES') { $displayisthere="True"; }
        ?>
        <tbody>
          <tr class="<?php if ($i&1) { echo'alternate'; } else { echo ''; }?>">
            <td align="left" valign="middle"><?php echo(stripslashes($data->Lrisg_type)); ?></td>
            <td align="left" valign="middle"><?php echo(stripslashes($data->Lrisg_title)); ?></td>
			<td align="left" valign="middle"><?php echo(stripslashes($data->Lrisg_target)); ?></td>
            <td align="left" valign="middle"><?php echo(stripslashes($data->Lrisg_order)); ?></td>
            <td align="left" valign="middle"><?php echo(stripslashes($data->Lrisg_status)); ?></td>
            <td align="left" valign="middle"><a href="options-general.php?page=left-right-image-slideshow-gallery/image-management.php&DID=<?php echo($data->Lrisg_id); ?>">Edit</a> &nbsp; <a onClick="javascript:Lrisg_delete('<?php echo($data->Lrisg_id); ?>')" href="javascript:void(0);">Delete</a> </td>
          </tr>
        </tbody>
        <?php $i = $i+1; } ?>
        <?php if($displayisthere<>"True") { ?>
        <tr>
          <td colspan="6" align="center" style="color:#FF0000" valign="middle">No message available with display status 'Yes'!' </td>
        </tr>
        <?php } ?>
      </table>
    </form>
  </div>
  <table width="100%">
    <tr>
      <td align="right"><input name="text_management" lang="text_management" class="button-primary" onClick="location.href='options-general.php?page=left-right-image-slideshow-gallery/image-management.php'" value="Go to - Image Management" type="button" />
        <input name="setting_management" lang="setting_management" class="button-primary" onClick="location.href='options-general.php?page=left-right-image-slideshow-gallery/left-right-image-slideshow-gallery.php'" value="Go to - Gallery Setting" type="button" />
		<input name="Help1" lang="publish" class="button-primary" onclick="Lrisg_help()" value="Help" type="button" />
      </td>
    </tr>
  </table>
</div>
<?php include("inc/help.php"); ?>