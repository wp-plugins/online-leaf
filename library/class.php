<?php

if(!class_exists("OnlineLeaf")) {
	class OnlineLeaf {
		function OnlineLeaf_Engine_Standby() {
			$installed = get_option('onlineleaf_engines');
			if($installed['standby']) {
				echo '<script language="javaScript" type="text/javascript" src="http://www.onlineleaf.com/savetheenvironment.js"></script>';
			}
//			if($doNoConflict) { echo '<script>jQuery.noConflict();</script>'; }
		}

		/* Admin pages */
		function OnlineLeaf_AddPages() {

			function OnlineLeaf_filter_plugin_actions($links, $file) {
    			static $this_plugin;
    			if(!$this_plugin) $this_plugin = plugin_basename(__FILE__);

    			if($file == $this_plugin) {
    			    $settings_link = '<a href="options-general.php?page=onlineleaf_settings">' . __('Settings') . '</a>';
    			    array_unshift($links, $settings_link);
    			}

    			return $links;
    		}

			/* Load pages */
			add_options_page('Online Leaf Settings', '<img src="'.$this->PluginDestination.'images/leaf_menu.png" style="float: right; margin-top: 2px;"> Online Leaf', 8, 'onlineleaf_settings', 'OnlineLeaf_Settings');
			add_filter('plugin_action_links', 'OnlineLeaf_filter_plugin_actions', 10, 2);

			function OnlineLeaf_Settings() {
				global $wpdb;

				$new = FALSE;
				$installed = get_option('onlineleaf_engines');
				if($_GET['install']) { $installed[$_GET['install']] = TRUE; }
				else if($_GET['uninstall']) { $installed[$_GET['uninstall']] = FALSE; }
				else if(!$installed) {
					$installed['standby'] = TRUE;
					add_option('onlineleaf_engines', $installed, FALSE, 'yes');
					$new = TRUE;
				}
				if(!$new) { update_option('onlineleaf_engines', $installed); }
				$installeds = get_option('onlineleaf_engines');
				$installed = array();
				foreach($installeds AS $k => $v) {
					if($v) { $installed[$k] = $v; }
				}

				echo '
<script language="javaScript" type="text/javascript" src="'.get_settings('siteurl').'/wp-content/plugins/online-leaf/scripts/jquery.js"></script>
<script language="javaScript" type="text/javascript" src="'.get_settings('siteurl').'/wp-content/plugins/online-leaf/scripts/load.js"></script>
<link rel="stylesheet" type="text/css" href="'.get_settings('siteurl').'/wp-content/plugins/online-leaf/style/online-leaf.css" />
<div class="wrap" style="margin: 0 25px 0 10px;">
	<h2>Online <span>Leaf</span> <img src="'.get_settings('siteurl').'/wp-content/plugins/online-leaf/images/leaf_head.png"></h2>
	<h3>What is Online Leaf?</h3>
	<div style="width: 48%; float: right;">
		<p>Feel free to place one or more of the following badges on your blog, if you use any of the green engines.</p>
		<table width="100%" cellspacing="5px">
			<tr>
				<td><img src="'.get_settings('siteurl').'/wp-content/plugins/online-leaf/images/badges/green-website-155-55.png"></td><td class="code">'.htmlspecialchars('<a href="http://www.onlineleaf.com/Green-Websites/" title="Green Website"><img src="'.get_settings('siteurl').'/wp-content/plugins/online-leaf/images/badges/green-website-155-55.png"></a>').'</td>
			</tr>
			<tr>
				<td><img src="'.get_settings('siteurl').'/wp-content/plugins/online-leaf/images/badges/green-website-100-35.png"></td><td class="code">'.htmlspecialchars('<a href="http://www.onlineleaf.com/Green-Websites/" title="Green Website"><img src="'.get_settings('siteurl').'/wp-content/plugins/online-leaf/images/badges/green-website-100-35.png"></a>').'</td>
			</tr>
			<tr>
				<td><img src="'.get_settings('siteurl').'/wp-content/plugins/online-leaf/images/badges/green-website-70-25.png"></td><td class="code">'.htmlspecialchars('<a href="http://www.onlineleaf.com/Green-Websites/" title="Green Website"><img src="'.get_settings('siteurl').'/wp-content/plugins/online-leaf/images/badges/green-website-70-25.png"></a>').'</td>
			</tr>
			<tr>
				<td><a href="" style="color: #44cc00; font-size: 15px; font-weight: bold; text-decoration: none;" title="Green Websites">Green Website</a></td><td class="code">'.htmlspecialchars('<a href="http://www.onlineleaf.com/Green-Websites/" style="color: #44cc00; font-size: 15px; font-weight: bold; text-decoration: none;" title="Green Websites">Green Website</a>').'</td>
			</tr>
		</table>
	</div>
	<p style="width: 48%;">There are most likely many people browsing your site each day, and even small things such as displaying a page, some white colors or an animation, increase the overall energy consumption from generating your website.</p>
	<p style="width: 48%;"><a href="http://www.onlineleaf.com/" target="_blank">Online Leaf</a> is a green initiative, which attempts to reduce the CO<sup>2</sup> emitted from website browsing, <u>while still maintaining a great visitor experience</u>.</p>
	<p style="width: 48%;">And how is this done? Well, this plugin serves as base for environmentally friendly engines and contains one-click install solutions for the energy saving methods Online Leaf develops. Remember, you can always uninstall any of our engines with a simple click, and we constantly develop new ones which will be available through this plugin.</p>

	<h3>Engines</h3>
	<p>You currently have <b>'.count($installed).'</b> environmentally friendly engine'.iif(count($installed) != 1, 's').' installed.<br />To install or uninstall engines, simply click the button in the <u>Action column</u> to the left.</p>
	<p style="text-align: center;">By using a green engine, your blog will automatically be listed as a <a href="http://www.onlineleaf.com/Green-Websites/" target="_blank" style="color: #44cc00; font-weight: bold; text-decoration: none;">Green Website</a>.</p>
	<table width="100%" class="info" cellspacing="0">
		<tr class="head">
			<td width="20%" align="center">Action</td>
			<td width="20%">Engine</td>
			<td width="60%">Description</td>
		</tr>
		<tr>
			<td align="center">'.iif($installed['standby'], '<font color="#44cc00"><b>Installed</b></font><br />').'<a href="options-general.php?page=onlineleaf_settings&'.iif($installed['standby'], 'un').'install=standby" class="'.iif($installed['standby'], 'de').'install">'.iif($installed['standby'], 'UN').'INSTALL</a></td>
			<td>Standby</td>
			<td><p>Detects inactivity and automatically launches a standby screen in dark colors<a href="#dark_colors" style="text-decoration: none;"><sup>1</sup></a>, which also hides active animations and other visual effects.<br />Launches when the visitor is inactive, and returns to the page as soon as the visitor is active again (moves his/her mouse across the website, or uses the keyboard).</p></td>
		</tr>
	</table>
	<ul>
		<li><a name="dark_colors"><sup>[1]</sup></a> In many cases, dark colors require less energy for monitors to display than light colors</a></li>
	</ul>

	<h3 style="margin-top: 15px;">How can I help Online Leaf?</h3>
	<div style="float: right; width: 48%">
		<h4>Donate</h4>
		<p>For obvious reasons, we can not keep fighting for the environment without money for maintenance and development, so if you would like us to continue development, feel free to <a href="http://www.onlineleaf.com/Donate/" target="_blank">make a donation here</a>.</p>
		<p>We also list all green donors on <a href="http://www.onlineleaf.com/Donate/" target="_blank">OnlineLeaf.com/Donate/</a> and of course appreciate all contributions!</p>';
				$url = 'http%3A%2F%2Fwww.onlineleaf.com%2F';
				$thetitle = 'Online%20Leaf%20-%20Making%20Websites%20Greener';
				$description = urlencode('As a new environmental initiative, Online Leaf provides lightweight, yet powerful, easily installable solutions to reduce the energy required to generate websites.').'%0A'.urlencode('The project\'s goal is to create Green Websites and reduce the amount of CO2 produced while browsing the web, all without loss of the websites\' user experience.');
				$category = 'environment';
				echo '<br />
		<a rel="nofollow" target="_blank" href="http://twitter.com/home?status='.$url.'" title="TwitThis"><img class="fade" src="'.get_settings('siteurl').'/wp-content/plugins/online-leaf/images/social-networking-icons/twitter.png" title="TwitThis" alt="TwitThis" /></a>
		<a rel="nofollow" target="_blank" href="http://www.facebook.com/share.php?u='.$url.'&t='.$thetitle.'" title="Facebook"><img class="fade" src="'.get_settings('siteurl').'/wp-content/plugins/online-leaf/images/social-networking-icons/FaceBook.png" title="Facebook" alt="Facebook" /></a>
		<a rel="nofollow" target="_blank" href="http://digg.com/submit?phase=2&amp;url='.$url.'&title='.$thetitle.'&bodytext='.$description.'&topic='.$category.'" title="Digg"><img class="fade" src="'.get_settings('siteurl').'/wp-content/plugins/online-leaf/images/social-networking-icons/Digg.png" title="Digg" alt="Digg" /></a>
		<a rel="nofollow" target="_blank" href="http://del.icio.us/post?url='.$url.'&title='.$thetitle.'" title="Del.icio.us"><img class="fade" src="'.get_settings('siteurl').'/wp-content/plugins/online-leaf/images/social-networking-icons/delicious.png" title="Del.icio.us" alt="Del.icio.us" /></a>
		<a rel="nofollow" target="_blank" href="http://www.stumbleupon.com/submit?url='.$url.'&title='.$thetitle.'" title="StumbleUpon"><img class="fade" src="'.get_settings('siteurl').'/wp-content/plugins/online-leaf/images/social-networking-icons/Stumbleupon.png" title="StumbleUpon" alt="StumbleUpon" /></a>
		<a rel="nofollow" target="_blank" href="http://reddit.com/submit?url='.$url.'&title='.$thetitle.'" title="Reddit"><img class="fade" src="'.get_settings('siteurl').'/wp-content/plugins/online-leaf/images/social-networking-icons/Reddit.png" title="Reddit" alt="Reddit" /></a>
	</div>
	<h4>Tell people about it</h4>
	<p style="width: 48%;">You already own a blog, right? Writing about it on your blog will certainly help a lot.</p>

	<h4>Rate it!</h4>
	<p style="width: 48%;">If you like green websites and green initiatives, we would appreciate if you give this plugin a good rating on <a href="http://www.wordpress.org/extend/plugins/online-leaf/" target="_blank">Wordpress.org</a> or similar pages.</p>

	<h4>Help <span>spread the leaf</span>!</h4>
	<p style="width: 48%;">Link to www.onlineleaf.com, share it on Facebook, Digg it, Twit it, bookmark it or anything else you can think of. Be creative, and help spread the Online Leaf!</p>

	<p style="width: 48%;"><b>Are you an entrepreneur?</b> If so, you can also help by developing Online Leaf plugins to other platforms, or perhaps you should <a href="http://www.onlineleaf.com/Contact/" target="_blank">contact us</a> if you have a great idea and would like us to work with you on it. <b>Perhaps another green engine is on your mind?</b></p>
</div>';
			}
		}
	}
}

?>