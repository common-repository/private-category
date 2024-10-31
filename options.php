<?php
$location = $private_categories_options_page; // Form Action URI

// Update de la config
if ('process' == $_POST['stage']) 
{
    update_option('private_categories_cat', $_POST['private_categories_cat']);
	update_option('desactive-privacy', $_POST['desactive-privacy']);
	update_option('suscriber_can_read', $_POST['suscriber_can_read']);
	
	$status = "Settings updated successfully.";
} 

if ( get_option('desactive-privacy')!='1' ) { $privacy_msg=' (Private categories is curently disable) ';}
if ( get_option('desactive-privacy')=='1' ) { $privacy_msg=' (Private categories is curently activate) ';}
?>


<div class="wrap">
  <h2><?php _e('Options'.$privacy_msg.'', 'private-categories') ?></h2>
  <?php if(isset($status)) {?>
  	<div class="updated fade" id="message" style="background-color: rgb(255, 251, 204);">
  		<p><?php echo $status;?></p>
	</div>
  <?php } ?>
  
  <?php if(isset($error)) {?>
  	<div class="updated fade" id="message" style="background-color: rgb(255, 251, 204);">
  		<p><font color=red><?php echo $error;?></font></p>
	</div>
  <?php } ?>

  <form name="form1" method="post" action="<?php echo $location ?>&amp;updated=true">
	<input type="hidden" name="stage" value="process" />
	 <table width="100%" cellspacing="2" cellpadding="5" class="form-table">
        
		<tr valign="baseline">
	     <th scope="row"><?php _e('Active privacy', 'desactive-privacy') ?></th> 
         <td><input type="checkbox" name="desactive-privacy" id="desactive-privacy" value=1  <?php if ( get_option('desactive-privacy')=='1' ) echo 'checked="checked" '; ?> /></td>
        </tr>

		<tr valign="baseline">
         <th scope="row"><?php _e('Choose a category', 'choose-category') ?></th> 
         <td> <?php wp_dropdown_categories('hide_empty=0&orderby=name&name=private_categories_cat&selected='.get_option('private_categories_cat')); ?></td>
        </tr>
		
		<tr valign="baseline">
		 <th scope="row"><h3><?php _e('Actualy private cat.', 'actualy-private') ?></h3></th>
        </tr>
		 
		<tr valign="baseline">
		 <td><ul><?php wp_list_categories('hide_empty=0&title_li= &style=none&number=1&include='.get_option('private_categories_cat'))?></ul></td>
		</tr>
		
		<tr valign="baseline">
	     <th scope="row"><?php _e('Suscriber can read private posts & pages', 'suscriber can read') ?></th> 
         <td><input type="checkbox" name="suscriber_can_read" id="suscriber_can_read" value=1  <?php if ( get_option('suscriber_can_read')=='1' ) echo 'checked="checked" '; ?> /></td>
        </tr>
		
     </table>


	<p class="submit">
      <input type="submit" name="Submit" value="<?php _e('Save Changes', 'private-categories') ?>" />
    </p>
  </form>
   
</div>