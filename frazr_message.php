<?php
/*
Plugin Name: Frazr Message
Plugin URI: http://wordpress.org/extend/plugins/frazrmessage/
Description: A plug-in to show the last frazr fraze for a user. Rewritten from <a href="http://www.sleepydisco.co.uk/" title="David Wood">David Woods</a> Simpletwitter. 
Version: 0.2.2
Author: Joerg Kanngiesser
Author URI: http://novaforce.org/blog/
*/
/*  Copyright 2007  Joerg Kanngiesser  (email : joerg.kanngiesser@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

$_opt_frazr_msg = 'fm_frazr_msg';
$_opt_frazr_id = 'fm_frazr_id';
$_opt_frazr_img = 'fm_frazr_img';
$_opt_cache_mins = 'fm_cache_mins';
$_opt_last_cache_time = 'fm_last_cache_time';

add_action('wp_head', 'check_frazr_cache');
add_action('admin_menu', 'add_frazr_options');

// Options hook
function add_frazr_options() {
    if (function_exists('add_options_page')) {
		add_options_page('Frazr Message', 'Frazr Message', 8, 'Frazr Message', 'frazrmsg_options_subpanel');
    }
}
 
// Options panel and form processing
function frazrmsg_options_subpanel() {
	echo "<h2>Frazr Message</h2>";

	if (!function_exists('curl_init')) {
		_show_frazrmsg_curl_warning();	
	}
	else {
		if (isset($_POST['info_update'])) {
			global $_opt_frazr_id;
			global $_opt_cache_mins;
      global $_opt_frazr_img;
	
			$frazrId = $_POST['frazr_id'];
			$cacheMins = $_POST['cache_mins'];
      $frazrImg = $_POST['frazr_img'];
			update_option($_opt_frazr_id, $frazrId);
			update_option($_opt_cache_mins, $cacheMins);
      update_option($_opt_frazr_img, $frazrImg);
		}
		_show_frazrmsg_form();
	}
}

// Displays a form to edit configuration options
function _show_frazrmsg_form() {
	?>
<div class="wrap">
<form method="post">
<fieldset class="options">
<legend>Einstellungen</legend>
<table width="100%" cellspacing="2" cellpadding="5" class="editform"> 
<tr valign="top"> 
<th width="33%" scope="row"><label for="frazr_id">Frazr Benutzername</label></th> 
<td><input type="text" name="frazr_id" id="frazr_id" value="<?php form_option('fm_frazr_id'); ?>"/></td> 
</tr>
<tr valign="top">
<th scope="row"><label for="cache_mins">Aktualisierungsintervall</label></th>
<td><input type="text" name="cache_mins" id="cache_mins" size="3" value="<?php form_option('fm_cache_mins'); ?>"/> <?php _e('minuten') ?></td>
</tr>
<tr valign="top">
<th scope="row"><label for="frazr_img">Benutzerbild</label></th>
<td><input type="text" name="frazr_img" id="frazr_img" size="60" value="<?php form_option('fm_frazr_img'); ?>"/> <br />Direkter Link ("http://www.bilder.de/bild.jpg")</td>
</tr> 
</table> 
<p class="submit">
<input type="submit" name="info_update" value="&Uuml;bernehmen &raquo;" />
</p>
</fieldset>
</form>
</div>
	<?php
}

// Displays a warning message when cURL isn't available
function _show_frazrmsg_curl_warning() {
	?>
<div class="error">
<h3>F&uuml;r Frazr Message muss die php cURL Bibliothek installiert sein</h3>
<p>Anscheinend ist die cURL Bibliothek nicht auf dem Webserver verf&uuml;gbar.</p>
</div>	
	<?php
}

// Returns the stored message
function get_frazr_msg() {
	global $_opt_frazr_msg;
  $msg = get_option($_opt_frazr_msg);
  echo $msg;
}

function get_frazr_badge() {
  global $_opt_frazr_msg;
  global $_opt_frazr_img;
  global $_opt_frazr_id;
  $usr = get_option($_opt_frazr_id);
  $msg = get_option($_opt_frazr_msg);
  $img = get_option($_opt_frazr_img);
  if ($img == '') { 
    $img = get_option('siteurl').'/wp-content/plugins/frazrmessage/frazr_user_img.png'; 
  }
  $logo = get_option('siteurl').'/wp-content/plugins/frazrmessage/frazr_logo.png'; 
  $balloon = get_option('siteurl').'/wp-content/plugins/frazrmessage/sprechblase.png';
  // HTML code for 250 pixels wide frazr badge
  ?>
  
<table width="250" border="0" cellspacing="0" cellpadding="0">
 <tr>
  <td valign="top" height="101">
    <a href="http://www.frazr.de/u/<?php echo $usr; ?>" title="<?php echo $usr; ?> bei frazr" target="_blank">
    <img src="<?php echo $img; ?>" width="48" height="48" border="0" alt="<?php echo $usr; ?> bei frazr"/></a>
</td>
  <td width="202" valign="top" background="<?php echo $balloon; ?>" style="background-repeat:no-repeat">
    <div style="padding-left:20px;padding-top:7px;padding-right:6px;padding-bottom:5px;font-family:Arial;font-size:10px;color:#000000;"><?php echo $msg; ?>
    </div>
  </td>
</tr>
</table>
  
  <?php
}

// Called by hook into wp_head. Checks for message expiry
function check_frazr_cache() {
	global $_opt_cache_mins;
	global $_opt_last_cache_time;
	$cache_mins = get_option($_opt_cache_mins);
	if ($cache_mins == '')
		$cache_mins = 1;
	$cache_time = $cache_mins * 60;

	// Time and file stats
	$now = time();
	$lsmod = get_option($_opt_last_cache_time);
	if ($lsmod == '')
		$lsmod = 0;

	// Cache is expired if the diff between now time and last mod time
	// is greater than cache time
	$cache_expired = ($now - $lsmod) > $cache_time;
	if ($cache_expired) {
		update_frazr_message();
	}
}

// Updates the message cache
function update_frazr_message() {
	// Update cache
	global $_opt_frazr_id;
	global $_opt_frazr_msg;
	global $_opt_last_cache_time;
	$frazrId = get_option($_opt_frazr_id);
	if ($frazrId != '') {
		$url = 'http://www.frazr.com/de/rss/?action=user&user='.$frazrId;
		$title = get_message_from_url($url);
		if ($title != '') {
			$msg = extract_message_from_frazr_title($title);
			update_option($_opt_frazr_msg, $msg);
			update_option($_opt_last_cache_time, time());
		}
	}
}
	
// Message comes in the format 'Name : Message'. This removes the 'Name : ' part
function extract_message_from_frazr_title($title) {
	$msg = substr($title, strpos($title, ':') + 2);
	return $msg;
}

// Gets the RSS feed and reads the title of the first item
function get_message_from_url($url, $tag = 'title', $item = 'item') {
	$msg = '';
	
	$page = '';
	if (function_exists('curl_init')) {
		
		$curl_session = curl_init($url);
		curl_setopt($curl_session, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl_session, CURLOPT_CONNECTTIMEOUT, 4);
		curl_setopt($curl_session, CURLOPT_TIMEOUT, 8);
		$page = curl_exec($curl_session);
		curl_close($curl_session);

	}		
	if ($page == '') {
		return '';
	}

	$lines = explode("\n",$page);
	
	$itemTag = "<$item>";
	$startTag = "<$tag>";
	$endTag = "</$tag>";
	
	$inItem = false;
	foreach ($lines as $s) {
		$s = rtrim($s);		
		if (strpos($s, $itemTag)) {
			$inItem = true;
		}
		if ($inItem) {
			$msg .= $s;
		}
		if ($inItem && strpos($s, $endTag)) {
			$msg = substr_replace($msg, '', strpos($msg, $endTag));
			$msg = substr($msg, strpos($msg, $startTag) + strlen($startTag));
			break;
		}
	}
	return $msg;
}
?>