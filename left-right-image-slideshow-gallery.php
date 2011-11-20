<?php

/*
Plugin Name: Left right image slideshow gallery
Plugin URI: http://www.gopiplus.com/work/2011/04/25/wordpress-plugin-left-right-image-slideshow-gallery/
Description: Left right image slideshow gallery lets showcase images in a horizontal move style. Single image at a time and pull one by one continually. This slideshow will pause on mouse over. The speed of the plugin gallery is customizable. Persistence of last viewed image supported, so when the user reloads the page, the slideshow continues from the last image.
Author: Gopi.R
Version: 4.0
Author URI: http://www.gopiplus.com/work/
Donate link: http://www.gopiplus.com/work/2011/04/25/wordpress-plugin-left-right-image-slideshow-gallery/
Tags: 
*/

/**
 *     Left right image slideshow gallery
 *     Copyright (C) 2011  www.gopiplus.com
 * 
 *     This program is free software: you can redistribute it and/or modify
 *     it under the terms of the GNU General Public License as published by
 *     the Free Software Foundation, either version 3 of the License, or
 *     (at your option) any later version.
 * 
 *     This program is distributed in the hope that it will be useful,
 *     but WITHOUT ANY WARRANTY; without even the implied warranty of
 *     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *     GNU General Public License for more details.
 * 
 *     You should have received a copy of the GNU General Public License
 *     along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

global $wpdb, $wp_version;
define("WP_LRISG_TABLE", $wpdb->prefix . "lrisg_plugin");

function Lrisg() 
{
	
	global $wpdb;
	$Lrisg_package = "";
	$Lrisg_title = get_option('Lrisg_title');
	$Lrisg_width = get_option('Lrisg_width');
	$Lrisg_height = get_option('Lrisg_height');
	$Lrisg_pause = get_option('Lrisg_pause');
	$Lrisg_cycles = get_option('Lrisg_cycles');
	$Lrisg_persist = get_option('Lrisg_persist');
	$Lrisg_slideduration = get_option('Lrisg_slideduration');
	$Lrisg_random = get_option('Lrisg_random');
	$Lrisg_type = get_option('Lrisg_type');
	
	if(!is_numeric(@$Lrisg_width)) { @$Lrisg_width = 250 ;}
	if(!is_numeric(@$Lrisg_height)) { @$Lrisg_height = 200; }
	if(!is_numeric(@$Lrisg_pause)) { @$Lrisg_pause = 2000; }
	if(!is_numeric(@$Lrisg_cycles)) { @$Lrisg_cycles = 5; }
	if(!is_numeric(@$Lrisg_slideduration)) { @$Lrisg_slideduration = 300; }
	
	$sSql = "select Lrisg_path,Lrisg_link,Lrisg_target,Lrisg_title from ".WP_LRISG_TABLE." where 1=1";
	if($Lrisg_type <> ""){ $sSql = $sSql . " and Lrisg_type='".$Lrisg_type."'"; }
	if($Lrisg_random == "YES"){ $sSql = $sSql . " ORDER BY RAND()"; }else{ $sSql = $sSql . " ORDER BY Lrisg_order"; }
	
	$data = $wpdb->get_results($sSql);
	
	if ( ! empty($data) ) 
	{
		foreach ( $data as $data ) 
		{
			$Lrisg_package = $Lrisg_package .'["'.$data->Lrisg_path.'", "'.$data->Lrisg_link.'", "'.$data->Lrisg_target.'"],';
		}
	}	
	$Lrisg_package = substr($Lrisg_package,0,(strlen($Lrisg_package)-1));
	
	?>
    <script type="text/javascript">

	var Lrisg_SlideShow=new Lrisg_Show({
		Lrisg_Wrapperid: "Lrisg_widgetss", 
		Lrisg_WidthHeight: [<?php echo $Lrisg_width; ?>, <?php echo $Lrisg_height; ?>], 
		Lrisg_ImageArray: [ <?php echo $Lrisg_package; ?> ],
		Lrisg_Displaymode: {type:'auto', pause:<?php echo $Lrisg_pause; ?>, cycles:<?php echo $Lrisg_cycles; ?>, pauseonmouseover:true},
		Lrisg_Orientation: "h", 
		Lrisg_Persist: <?php echo $Lrisg_persist; ?>, 
		Lrisg_Slideduration: <?php echo $Lrisg_slideduration; ?> 
	})
	
	</script>
    <div id="Lrisg_widgetss"></div>
    <?php

}

function Lrisg_install() 
{
	
	global $wpdb;
	
	if($wpdb->get_var("show tables like '". WP_LRISG_TABLE . "'") != WP_LRISG_TABLE) 
	{
		$sSql = "CREATE TABLE IF NOT EXISTS `". WP_LRISG_TABLE . "` (";
		$sSql = $sSql . "`Lrisg_id` INT NOT NULL AUTO_INCREMENT ,";
		$sSql = $sSql . "`Lrisg_path` TEXT CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,";
		$sSql = $sSql . "`Lrisg_link` TEXT CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,";
		$sSql = $sSql . "`Lrisg_target` VARCHAR( 50 ) NOT NULL ,";
		$sSql = $sSql . "`Lrisg_title` VARCHAR( 500 ) NOT NULL ,";
		$sSql = $sSql . "`Lrisg_order` INT NOT NULL ,";
		$sSql = $sSql . "`Lrisg_status` VARCHAR( 10 ) NOT NULL ,";
		$sSql = $sSql . "`Lrisg_type` VARCHAR( 100 ) NOT NULL ,";
		$sSql = $sSql . "`Lrisg_extra1` VARCHAR( 100 ) NOT NULL ,";
		$sSql = $sSql . "`Lrisg_extra2` VARCHAR( 100 ) NOT NULL ,";
		$sSql = $sSql . "`Lrisg_date` datetime NOT NULL default '0000-00-00 00:00:00' ,";
		$sSql = $sSql . "PRIMARY KEY ( `Lrisg_id` )";
		$sSql = $sSql . ")";
		$wpdb->query($sSql);
		
		$IsSql = "INSERT INTO `". WP_LRISG_TABLE . "` (`Lrisg_path`, `Lrisg_link`, `Lrisg_target` , `Lrisg_title` , `Lrisg_order` , `Lrisg_status` , `Lrisg_type` , `Lrisg_date`)"; 
		
		$sSql = $IsSql . " VALUES ('http://www.gopiplus.com/work/wp-content/uploads/pluginimages/250x167/250x167_1.jpg', 'http://www.gopiplus.com/work/2011/04/22/wordpress-plugin-wp-fadein-text-news/', '_blank', 'Image 1', '1', 'YES', 'widget', '0000-00-00 00:00:00');";
		$wpdb->query($sSql);
		
		$sSql = $IsSql . " VALUES ('http://www.gopiplus.com/work/wp-content/uploads/pluginimages/250x167/250x167_2.jpg' ,'http://www.gopiplus.com/work/2011/04/25/wordpress-plugin-left-right-image-slideshow-gallery/', '_blank', 'Image 2', '2', 'YES', 'widget', '0000-00-00 00:00:00');";
		$wpdb->query($sSql);
		
		$sSql = $IsSql . " VALUES ('http://www.gopiplus.com/work/wp-content/uploads/pluginimages/250x167/250x167_3.jpg', 'http://www.gopiplus.com/work/2011/04/25/wordpress-plugin-left-right-image-slideshow-gallery/', '_blank', 'Image 3', '1', 'YES', 'sample', '0000-00-00 00:00:00');";
		$wpdb->query($sSql);
		
		$sSql = $IsSql . " VALUES ('http://www.gopiplus.com/work/wp-content/uploads/pluginimages/250x167/250x167_4.jpg', 'http://www.gopiplus.com/work/2010/10/10/superb-slideshow-gallery/', '_blank', 'Image 4', '2', 'YES', 'sample', '0000-00-00 00:00:00');";
		$wpdb->query($sSql);

	}

	add_option('Lrisg_title', "Left right slideshow");
	add_option('Lrisg_width', "260");
	add_option('Lrisg_height', "200");
	add_option('Lrisg_pause', "2000");
	add_option('Lrisg_cycles', "5");
	add_option('Lrisg_persist', "true");
	add_option('Lrisg_slideduration', "300");
	add_option('Lrisg_random', "NO");
	add_option('Lrisg_type', "widget");

}

function Lrisg_control() 
{
	echo '<p>Left right image slideshow gallery.<br><br> To change the setting goto "Left right slideshow" link under SETTING menu. ';
	echo '<a href="options-general.php?page=left-right-image-slideshow-gallery/left-right-image-slideshow-gallery.php">click here</a></p>';
	echo '<a target="_blank" href="http://www.gopiplus.com/work/2011/04/25/wordpress-plugin-left-right-image-slideshow-gallery/">Click here</a> for more help.<br>';
}

function Lrisg_widget($args) 
{
	extract($args);
	echo $before_widget . $before_title;
	echo get_option('Lrisg_Title');
	echo $after_title;
	Lrisg();
	echo $after_widget;
}

function Lrisg_admin_options() 
{
	global $wpdb;
	
	echo "<div class='wrap'>";
	echo "<h2>"; 
	echo "Left right image slideshow gallery";
	echo "</h2>";
	$Lrisg_title = get_option('Lrisg_title');
	$Lrisg_width = get_option('Lrisg_width');
	$Lrisg_height = get_option('Lrisg_height');
	$Lrisg_pause = get_option('Lrisg_pause');
	$Lrisg_cycles = get_option('Lrisg_cycles');
	$Lrisg_persist = get_option('Lrisg_persist');
	$Lrisg_slideduration = get_option('Lrisg_slideduration');
	$Lrisg_random = get_option('Lrisg_random');
	$Lrisg_type = get_option('Lrisg_type');
	
	if (@$_POST['Lrisg_submit']) 
	{
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
	}
	
	echo '<form name="Lrisg_form" method="post" action="">';

	echo '<p>Title:<br><input  style="width: 450px;" maxlength="200" type="text" value="';
	echo $Lrisg_title . '" name="Lrisg_title" id="Lrisg_title" /> Widget title.</p>';

	echo '<p>Width:<br><input  style="width: 100px;" maxlength="200" type="text" value="';
	echo $Lrisg_width . '" name="Lrisg_width" id="Lrisg_width" /> Widget Width (only number).</p>';

	echo '<p>Height:<br><input  style="width: 100px;" maxlength="200" type="text" value="';
	echo $Lrisg_height . '" name="Lrisg_height" id="Lrisg_height" /> Widget Height (only number).</p>';

	echo '<p>Pause:<br><input  style="width: 100px;" maxlength="4" type="text" value="';
	echo $Lrisg_pause . '" name="Lrisg_pause" id="Lrisg_pause" /> Only Number / Pause between content change (millisec).</p>';

	echo '<p>Cycles :<br><input  style="width: 100px;" type="text" value="';
	echo $Lrisg_cycles . '" name="Lrisg_cycles" id="Lrisg_cycles" /> (only number)</p>';
	
	echo '<p>Persist:<br><input  style="width: 100px;" maxlength="4" type="text" value="';
	echo $Lrisg_persist . '" name="Lrisg_persist" id="Lrisg_persist" /></p>';

	echo '<p>Slideduration :<br><input  style="width: 100px;" type="text" value="';
	echo $Lrisg_slideduration . '" name="Lrisg_slideduration" id="Lrisg_slideduration" /></p>';

	echo '<p>Random :<br><input  style="width: 100px;" type="text" value="';
	echo $Lrisg_random . '" name="Lrisg_random" id="Lrisg_random" /> (YES/NO)</p>';

	echo '<p>Type:<br><input  style="width: 150px;" type="text" value="';
	echo $Lrisg_type . '" name="Lrisg_type" id="Lrisg_type" /> This field is to group the images.</p>';

	echo '<input name="Lrisg_submit" id="Lrisg_submit" class="button-primary" value="Submit" type="submit" />';

	echo '</form>';
	
	echo '</div>';
	?>
    <div style="float:right;">
	<input name="text_management1" lang="text_management" class="button-primary" onClick="location.href='options-general.php?page=left-right-image-slideshow-gallery/image-management.php'" value="Go to - Image Management" type="button" />
    <input name="setting_management1" lang="setting_management" class="button-primary" onClick="location.href='options-general.php?page=left-right-image-slideshow-gallery/left-right-image-slideshow-gallery.php'" value="Go to - Gallery Setting" type="button" />
    </div>
    <?php
	include("inc/help.php");
}

add_filter('the_content','Lrisg_Show_Filter');

function Lrisg_Show_Filter($content)
{
	return 	preg_replace_callback('/\[LR_IMAGE_GALLERY:(.*?)\]/sim','Lrisg_Show_Filter_Callback',$content);
}

function Lrisg_Show_Filter_Callback($matches) 
{
	global $wpdb;
	
	$scode = $matches[1];
	$Lrisg_package = "";
	$Lr = "";
	list($Lrisg_type_main, $Lrisg_width_main, $Lrisg_height_main, $Lrisg_pause_main, $Lrisg_random_main) = split("[:.-]", $scode);

	list($Lrisg_type_cap, $Lrisg_type) = split('[=.-]', $Lrisg_type_main);
	list($Lrisg_width_cap, $Lrisg_width) = split('[=.-]', $Lrisg_width_main);
	list($Lrisg_height_cap, $Lrisg_height) = split('[=.-]', $Lrisg_height_main);
	list($Lrisg_pause_cap, $Lrisg_pause) = split('[=.-]', $Lrisg_pause_main);
	list($Lrisg_random_cap, $Lrisg_random) = split('[=.-]', $Lrisg_random_main);

	$Lrisg_persist = get_option('Lrisg_persist');
	
	if($Lrisg_persist == "true")
	{
		$Lrisg_persist = "true";
	}
	else
	{
		$Lrisg_persist = "false";
	}
	
	$Lrisg_cycles = get_option('Lrisg_cycles');
	$Lrisg_slideduration = get_option('Lrisg_slideduration');
	
	if(!is_numeric(@$Lrisg_width)) { @$Lrisg_width = 250 ;}
	if(!is_numeric(@$Lrisg_height)) { @$Lrisg_height = 200; }
	if(!is_numeric(@$Lrisg_cycles)) { @$Lrisg_cycles = 5; }
	if(!is_numeric(@$Lrisg_slideduration)) { @$Lrisg_slideduration = 300; }
	if(!is_numeric(@$Lrisg_pause)) { @$Lrisg_pause = 2000; }
	
	$sSql = "select Lrisg_path,Lrisg_link,Lrisg_target,Lrisg_title from ".WP_LRISG_TABLE." where 1=1";
	if($Lrisg_type <> ""){ $sSql = $sSql . " and Lrisg_type='".$Lrisg_type."'"; }
	if($Lrisg_random == "YES"){ $sSql = $sSql . " ORDER BY RAND()"; }else{ $sSql = $sSql . " ORDER BY Lrisg_order"; }
	
	$data = $wpdb->get_results($sSql);
	
	if ( ! empty($data) ) 
	{
		foreach ( $data as $data ) 
		{
			$Lrisg_package = $Lrisg_package .'["'.$data->Lrisg_path.'", "'.$data->Lrisg_link.'", "'.$data->Lrisg_target.'"],';
		}
	}	
	$Lrisg_package = substr($Lrisg_package,0,(strlen($Lrisg_package)-1));
	
	$Lrisg_pluginurl = get_option('siteurl') . "/wp-content/plugins/left-right-image-slideshow-gallery/";
	
	$type = "auto";
	
	$wrapperid = $Lrisg_type;
	
    $Lr = $Lr .'<script type="text/javascript">';

	$Lr = $Lr .'var Lrisg_SlideShow=new Lrisg_Show({Lrisg_Wrapperid: "'.$wrapperid.'",Lrisg_WidthHeight: ['.$Lrisg_width.', '.$Lrisg_height.'], Lrisg_ImageArray: [ '.$Lrisg_package.' ],Lrisg_Displaymode: {type:"'.$type.'", pause:'.$Lrisg_pause.', cycles:'.$Lrisg_cycles.', pauseonmouseover:true},Lrisg_Orientation: "h",Lrisg_Persist: '.$Lrisg_persist.',Lrisg_Slideduration: '.$Lrisg_slideduration.' })';
	
	$Lr = $Lr .'</script>';
    $Lr = $Lr .'<div id="'.$wrapperid.'"></div>';
   
		
	return $Lr;
}

function Lrisg_add_to_menu() 
{
	add_options_page('Left right image slideshow gallery', 'Left right slideshow', 'manage_options', __FILE__, 'Lrisg_admin_options' );
	add_options_page('Left right image slideshow gallery', '', 'manage_options', "left-right-image-slideshow-gallery/image-management.php",'' );
}

if (is_admin()) 
{
	add_action('admin_menu', 'Lrisg_add_to_menu');
}

function Lrisg_init()
{
	if(function_exists('wp_register_sidebar_widget')) 
	{
		wp_register_sidebar_widget('left-right-image-slideshow-gallery', 'Left right image slideshow gallery', 'Lrisg_widget');
	}
	
	if(function_exists('wp_register_widget_control')) 
	{
		wp_register_widget_control('left-right-image-slideshow-gallery', array('Left right image slideshow gallery', 'widgets'), 'Lrisg_control');
	} 
}

function Lrisg_deactivation() 
{

}

function Lrisg_add_javascript_files() 
{
	if (!is_admin())
	{
		wp_enqueue_script( 'jquery.min', get_option('siteurl').'/wp-content/plugins/left-right-image-slideshow-gallery/inc/jquery.min.js');
		wp_enqueue_script( 'left-right-image-slideshow-gallery', get_option('siteurl').'/wp-content/plugins/left-right-image-slideshow-gallery/inc/left-right-image-slideshow-gallery.js');
	}
}

add_action('init', 'Lrisg_add_javascript_files');

add_action("plugins_loaded", "Lrisg_init");
register_activation_hook(__FILE__, 'Lrisg_install');
register_deactivation_hook(__FILE__, 'Lrisg_deactivation');
add_action('admin_menu', 'Lrisg_add_to_menu');


?>
