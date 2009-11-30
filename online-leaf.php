<?php

/*
Plugin Name: Online Leaf
Plugin URI: http://www.onlineleaf.com/
Description: 
Author: Rune Jensen
Version: 0.9
Author URI: http://www.rune-jensen.com/
*/

require_once 'library/include.php';

if(class_exists("OnlineLeaf")) { $OnlineLeaf = new OnlineLeaf(); }

if(isset($OnlineLeaf)) {
	$OnlineLeaf->PluginDestination = get_settings('siteurl').'/wp-content/plugins/online-leaf/';
	add_action('admin_menu', array(&$OnlineLeaf, 'OnlineLeaf_AddPages'));
	add_action('wp_head', array(&$OnlineLeaf, 'OnlineLeaf_Engine_Standby'));
}

?>