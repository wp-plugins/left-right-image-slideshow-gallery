<?php

/*
Plugin Name: Left right image slideshow gallery
Plugin URI: http://www.gopiplus.com/work/2011/04/25/wordpress-plugin-left-right-image-slideshow-gallery/
Description: Left right image slideshow gallery lets showcase images in a horizontal move style. Single image at a time and pull one by one continually. This slideshow will pause on mouse over. The speed of the plugin gallery is customizable. Persistence of last viewed image supported, so when the user reloads the page, the slideshow continues from the last image.
Author: Gopi.R
Version: 10.0
Author URI: http://www.gopiplus.com/work/
Donate link: http://www.gopiplus.com/work/2011/04/25/wordpress-plugin-left-right-image-slideshow-gallery/
Tags: image, slideshow, gallery
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

global $wpdb, $wp_version;
define("WP_LRISG_TABLE", $wpdb->prefix . "lrisg_plugin");
define("WP_Lrisg_UNIQUE_NAME", "ivrss");
define("WP_Lrisg_TITLE", "Left right image slideshow gallery");
define('WP_Lrisg_LINK', 'Check official website for more information <a target="_blank" href="http://www.gopiplus.com/work/2011/04/25/wordpress-plugin-left-right-image-slideshow-gallery/">click here</a>');
define('WP_Lrisg_FAV', 'http://www.gopiplus.com/work/2011/04/25/wordpress-plugin-left-right-image-slideshow-gallery/');

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
		
		$sSql = $IsSql . " VALUES ('".get_option('siteurl')."/wp-content/plugins/left-right-image-slideshow-gallery/images/250x167_1.jpg', '#', '_blank', 'Image 1', '1', 'YES', 'Widget', '0000-00-00 00:00:00');";
		$wpdb->query($sSql);
		
		$sSql = $IsSql . " VALUES ('".get_option('siteurl')."/wp-content/plugins/left-right-image-slideshow-gallery/images/250x167_2.jpg' ,'#', '_blank', 'Image 2', '2', 'YES', 'Widget', '0000-00-00 00:00:00');";
		$wpdb->query($sSql);
		
		$sSql = $IsSql . " VALUES ('".get_option('siteurl')."/wp-content/plugins/left-right-image-slideshow-gallery/images/250x167_3.jpg', '#', '_blank', 'Image 3', '1', 'YES', 'Sample', '0000-00-00 00:00:00');";
		$wpdb->query($sSql);
		
		$sSql = $IsSql . " VALUES ('".get_option('siteurl')."/wp-content/plugins/left-right-image-slideshow-gallery/images/250x167_4.jpg', '#', '_blank', 'Image 4', '2', 'YES', 'Sample', '0000-00-00 00:00:00');";
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
	add_option('Lrisg_type', "Widget");

}

function Lrisg_control() 
{
	echo '<p>To change the setting goto <b>Left right slideshow</b> link under Settings menu. ';
	echo '<a href="options-general.php?page=left-right-image-slideshow-gallery">click here</a></p>';
	echo WP_Lrisg_LINK;
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
	$current_page = isset($_GET['ac']) ? $_GET['ac'] : '';
	switch($current_page)
	{
		case 'edit':
			include('pages/image-management-edit.php');
			break;
		case 'add':
			include('pages/image-management-add.php');
			break;
		case 'set':
			include('pages/image-setting.php');
			break;
		default:
			include('pages/image-management-show.php');
			break;
	}
}

add_shortcode( 'lr-slideshow', 'Lrisg_shortcode' );

function Lrisg_shortcode( $atts ) 
{
	global $wpdb;
	
	$Lrisg_package = "";
	$Lr = "";
	
	//[lr-slideshow type="sample" width="250" height="170" pause="3000" random="YES"]
	if ( ! is_array( $atts ) ) { return ''; }
	$Lrisg_type = $atts['type'];
	$Lrisg_width = $atts['width'];
	$Lrisg_height = $atts['height'];
	$Lrisg_pause = $atts['pause'];
	$Lrisg_random = $atts['random'];
	
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
		
		$Lrisg_package = substr($Lrisg_package,0,(strlen($Lrisg_package)-1));
		$Lrisg_pluginurl = get_option('siteurl') . "/wp-content/plugins/left-right-image-slideshow-gallery/";
		$type = "auto";
		$wrapperid = "left" . $Lrisg_type;
		$Lr = $Lr .'<script type="text/javascript">';
		$Lr = $Lr .'var Lrisg_SlideShow=new Lrisg_Show({Lrisg_Wrapperid: "'.$wrapperid.'",Lrisg_WidthHeight: ['.$Lrisg_width.', '.$Lrisg_height.'], Lrisg_ImageArray: [ '.$Lrisg_package.' ],Lrisg_Displaymode: {type:"'.$type.'", pause:'.$Lrisg_pause.', cycles:'.$Lrisg_cycles.', pauseonmouseover:true},Lrisg_Orientation: "h",Lrisg_Persist: '.$Lrisg_persist.',Lrisg_Slideduration: '.$Lrisg_slideduration.' })';
		$Lr = $Lr .'</script>';
		$Lr = $Lr .'<div id="'.$wrapperid.'"></div>';
	}	
	else
	{
		$Lr = " Please check the short code ";
	}
	return $Lr;
}

function Lrisg_add_to_menu() 
{
	if (is_admin()) 
	{
		add_options_page('Left right image slideshow gallery', 'Left right slideshow', 'manage_options', 'left-right-image-slideshow-gallery', 'Lrisg_admin_options' );
		//add_options_page('Left right image slideshow gallery', '', 'manage_options', "left-right-image-slideshow-gallery/image-management.php",'' );
	}
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
	// No action required.
}

function Lrisg_add_javascript_files() 
{
	if (!is_admin())
	{
		wp_enqueue_script('jquery');
		wp_enqueue_script( 'left-right-image-slideshow-gallery', get_option('siteurl').'/wp-content/plugins/left-right-image-slideshow-gallery/inc/left-right-image-slideshow-gallery.js');
	}
}

add_action('wp_enqueue_scripts', 'Lrisg_add_javascript_files');
add_action("plugins_loaded", "Lrisg_init");
register_activation_hook(__FILE__, 'Lrisg_install');
register_deactivation_hook(__FILE__, 'Lrisg_deactivation');
add_action('admin_menu', 'Lrisg_add_to_menu');
?>
