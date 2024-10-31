<?php
/*

Plugin Name: Private categories
Plugin URI: http://www.devsector.ch/index.php/wordpress
Description: Making a private category (with login).
Version: 1.0.1
Author: Cavimaster
Author URI: http://www.devsector.ch
License: Creative Commons Attribution-ShareAlike (GPLv2) //License

*/

//************************************ Options
$privacy = get_option('desactive-privacy');
$private_cat = get_option('private_categories_cat');
$suscriber_can_read = get_option('suscriber_can_read');



//************************************ Options file
$private_categories_options_page = get_option('siteurl') . '/wp-admin/options-general.php?page=private-category/options.php';


//************************************ Add admin options
function private_categories_options_page() {
	add_options_page('Private categories Options', 'Private categories', 10, '/private-category/options.php');
}

//************************************ Add suscriber role
function add_subscriber_role() {
   global $wp_roles; 
      if(is_object($wp_roles) && method_exists($wp_roles,'add_cap'))
      {
   $wp_roles->add_cap('subscriber', 'read_private_posts');
   $wp_roles->add_cap('subscriber', 'read_private_pages');
     }}
	 if($suscriber_can_read == '1'){ add_action( 'init', 'add_subscriber_role' ); }
	 
//************************************ Remove suscriber role
function remove_subscriber_role() {
   global $wp_roles;
   if(is_object($wp_roles) && method_exists($wp_roles,'add_cap'))
      {
   $wp_roles->remove_cap('subscriber', 'read_private_posts');
   $wp_roles->remove_cap('subscriber', 'read_private_pages');
     }}
   if($suscriber_can_read != '1'){ add_action( 'init', 'remove_subscriber_role' ); }
	
//************************************ The script
function private_categories_scripts(){

   global $wp_query;
   global $user_ID;
   
   global $privacy;
   global $private_cat;

//Get the current cat ID
  if(is_category() || is_single()){
     $cat_ID = get_query_var('cat');
  }

  if ($private_cat == $cat_ID && $privacy == 1){

  if (! $user_ID){
			
  if (!isset( $user_login )){$user_login = '';}
		$pr_page_content = '<div id="login">
		<form style="text-align: left;" action="' . get_bloginfo ( 'wpurl' ) . '/wp-login.php" method="post">
			<p>
				<label for="log"><input type="text" name="log" id="log" value="' . wp_specialchars ( stripslashes ( $user_login ) , 1 ) . '"  /> Username</label><br />
				<label for="pwd"><input type="password" name="pwd" id="pwd" /> Password</label><br />
				<input type="submit" name="submit" value="Log In" class="button" />
				<label for="rememberme"><input name="rememberme" id="rememberme" type="checkbox" checked="checked" value="forever" /> Remember me</label><br />
			</p>
			<input type="hidden" name="redirect_to" value="' . $_SERVER['REQUEST_URI'] . '" />
		</form>
		<p>
		</div>
		';

    echo $pr_page_content;

  }
    else echo '<a href="'.wp_logout_url( home_url() ).'" title="Logout" class="logoutbutton">Logout</a>';
  }//fin private cat
  
}

add_action('get_template_part_loop', 'private_categories_scripts');

//************************************ Install
function private_categories_install()
{ 
	add_option('private_categories_cat', '');
	add_option('desactive-privacy', '');
}
add_action('activate_private-categories/private-categories.php', 'private_categories_install');


//************************************ Uninstall
function private_categories_uninstall()
{ 
	delete_option('private_categories_cat');
	delete_option('desactive-privacy');
}
add_action('deactivate_private-categories/private-categories.php', 'private_categories_uninstall');


//************************************ Admin menu
add_action('admin_menu', 'private_categories_options_page');
?>