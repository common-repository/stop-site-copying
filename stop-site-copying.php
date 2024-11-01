<?php
/*
Plugin Name: Stop Site Copying
Plugin URI: http://vlcmedia.blogspot.com/2011/07/stop-site-copying.html
Description: Protects your blog from people stealing your content!
Version: 1.0.0
Author: VLCMedia
Author URI: http://www.vlcmediaplayer.net
*/

/*  Copyright 2011 VLCMedia - site@techfirefly.net

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
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// Hook for adding admin menus
add_action('admin_menu', 'stopsitecopying_add_pages');

// action function for above hook
function stopsitecopying_add_pages() {
    add_options_page('Stop Site Copying', 'Stop Site Copying', 'administrator', 'protection', 'stopsitecopying_options_page');
}

// jr_effects_options_page() displays the page content for the Test Options submenu
function stopsitecopying_options_page() {

    // variables for the field and option names
    $opt_name_1 = 'mt_stopsitecopying_click';	
    $opt_name_5 = 'mt_stopsitecopying_plugin_support';
	$opt_name_6 = 'mt_stopsitecopying_rss';
	$opt_name_7 = 'mt_stopsitecopying_highlight';
    $hidden_field_name = 'mt_stopsitecopying_submit_hidden';
	$data_field_name_1 = 'mt_stopsitecopying_click';
    $data_field_name_5 = 'mt_stopsitecopying_plugin_support';
	$data_field_name_6 = 'mt_stopsitecopying_rss';
	$data_field_name_7 = 'mt_stopsitecopying_highlight';

    // Read in existing option value from database
	$opt_val_1 = get_option($opt_name_1);
    $opt_val_5 = get_option($opt_name_5);
	$opt_val_6 = get_option($opt_name_6);
	$opt_val_7 = get_option($opt_name_7);

    // See if the user has posted us some information
    // If they did, this hidden field will be set to 'Y'
    if( $_POST[ $hidden_field_name ] == 'Y' ) {
        // Read their posted value
		$opt_val_1 = $_POST[$data_field_name_1];
        $opt_val_5 = $_POST[$data_field_name_5];
		$opt_val_6 = $_POST[$data_field_name_6];
		$opt_val_7 = $_POST[$data_field_name_7];

        // Save the posted value in the database
		update_option( $opt_name_1, $opt_val_1 );
        update_option( $opt_name_5, $opt_val_5 );
		update_option( $opt_name_6, $opt_val_6 );
		update_option( $opt_name_7, $opt_val_7 );

        // Put an options updated message on the screen

?>
<div class="updated"><p><strong><?php _e('Options saved.', 'mt_trans_domain' ); ?></strong></p></div>
<?php

    }

    // Now display the options editing screen

    echo '<div class="wrap">';

    // header

    echo "<h2>" . __( 'Stop Site Copying Plugin Options', 'mt_trans_domain' ) . "</h2>";
echo "<br /><strong>Please note: Content theft is still possible even with the use of this content. If some users really wish to steal your content, they'll always find a way to do so for as long as your content is online. However, use of this plugin does make it more difficult to do so and will stop some content thieves.</strong><br />";

    // options form
    
    $change3 = get_option("mt_stopsitecopying_plugin_support");
	$change4 = get_option("mt_stopsitecopying_click");
	$change5 = get_option("mt_stopsitecopying_rss");
	$change6 = get_option("mt_stopsitecopying_highlight");

if ($change3=="Yes" || $change3=="") {
$change3="checked";
$change31="";
} else {
$change3="";
$change31="checked";
}

if ($change4=="Yes" || $change4=="") {
$change4="checked";
$change41="";
} else {
$change4="";
$change41="checked";
}

if ($change5=="Yes") {
$change5="checked";
} else if ($change5=="No") {
$change51="checked";
} else {
$change52="checked";
}

if ($change6=="Yes" || $change6=="") {
$change6="checked";
$change61="";
} else {
$change6="";
$change61="checked";
}
    ?>
<form name="form1" method="post" action="">
<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">
<p><?php _e("(Default: Disabled) Right-clicking on your page is...", 'mt_trans_domain' ); ?> 
<input type="radio" name="<?php echo $data_field_name_1; ?>" value="Yes" <?php echo $change4; ?>>Disabled
<input type="radio" name="<?php echo $data_field_name_1; ?>" value="No" <?php echo $change41; ?>>Enabled
</p>

<p><?php _e("(Default: Enabled) RSS Feed is...", 'mt_trans_domain' ); ?> 
<input type="radio" name="<?php echo $data_field_name_6; ?>" value="Yes" <?php echo $change5; ?>>Disabled
<input type="radio" name="<?php echo $data_field_name_6; ?>" value="No" <?php echo $change51; ?>>Enabled
<input type="radio" name="<?php echo $data_field_name_6; ?>" value="Member" <?php echo $change52; ?>>Enabled if logged in
</p>

<p><?php _e("(Default: Disabled) Highlighting text is...", 'mt_trans_domain' ); ?> 
<input type="radio" name="<?php echo $data_field_name_7; ?>" value="Yes" <?php echo $change6; ?>>Disabled
<input type="radio" name="<?php echo $data_field_name_7; ?>" value="No" <?php echo $change61; ?>>Enabled
</p><hr />

<p><?php _e("Give the author a link?", 'mt_trans_domain' ); ?> 
<input type="radio" name="<?php echo $data_field_name_5; ?>" value="Yes" <?php echo $change3; ?>>Yes
<input type="radio" name="<?php echo $data_field_name_5; ?>" value="No" <?php echo $change31; ?>>No
</p>

<p class="submit">
<input type="submit" name="Submit" value="<?php _e('Update Options', 'mt_trans_domain' ) ?>" />
</p><hr />

</form>
<?php } ?>
<?php

function disable_feed() {
if (get_option("mt_stopsitecopying_rss")=="Member") {
if (!is_user_logged_in()) {
	wp_die( __('The feed is disabled. Please visit the <a href="'. get_bloginfo('url') .'">Homepage</a>.') );
}
} else {
	wp_die( __('The feed is disabled. Please visit the <a href="'. get_bloginfo('url') .'">Homepage</a>.') );
}
}

function show_protection() {
$click=get_option("mt_stopsitecopying_click");
$rss=get_option("mt_stopsitecopying_rss");
$highlight=get_option("mt_stopsitecopying_highlight");

if ($click=="" || $click=="Yes") {
?>
<SCRIPT TYPE="text/javascript">
<!--
var message="This page is protected!";
function clickIE() {if (document.all) {(message);return false;}}
function clickNS(e) {if
(document.layers||(document.getElementById&&!document.all)) {
if (e.which==2||e.which==3) {(message);return false;}}}
if (document.layers)
{document.captureEvents(Event.MOUSEDOWN);document.onmousedown=clickNS;}
else{document.onmouseup=clickNS;document.oncontextmenu=clickIE;}
document.oncontextmenu=new Function("return false")
// -->
</SCRIPT> 
<?php
}

if ($highlight=="" || $highlight=="Yes") {
?>
<script type="text/javascript">
window.onload = function() {
  document.onselectstart = function() {return false;} // ie
  document.onmousedown = function() {return false;} // mozilla
}

window.onload = function() {
  var element = document.getElementById('body');
  element.onselectstart = function () { return false; } // ie
  element.onmousedown = function () { return false; } // mozilla
}
</script>
<script language="JavaScript1.2">
 
function disableselect(e){
return false
}
 
function reEnable(){
return true
}
 
//if IE4+
document.onselectstart=new Function ("return false")
 
//if NS6
if (window.sidebar){
document.onmousedown=disableselect
document.onclick=reEnable
}
</script>
<?php
}

if ($rss=="Yes") {
add_action('do_feed', 'disable_feed', 1);
add_action('do_feed_rdf', 'disable_feed', 1);
add_action('do_feed_rss', 'disable_feed', 1);
add_action('do_feed_rss2', 'disable_feed', 1);
add_action('do_feed_atom', 'disable_feed', 1);
}

$supportplugin=get_option("mt_stopsitecopying_plugin_support");
if ($supportplugin=="Yes" || $supportplugin=="") {
add_action('wp_footer', 'stopsitecopying_footer_plugin_support');
}
}

function stopsitecopying_footer_plugin_support() {
  $pshow = "<p style='font-size:x-small'>Stop Copying Plugin made by <a href='http://www.vlcmediaplayer.net'>VLC Media Player</a></p>";
  echo $pshow;
}

add_action("wp_head", "show_protection");

?>
