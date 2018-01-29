<?php

// --------------- File to create the nichesitemetabox ---------------- //

//Create methode to get the title and image if available
function the_auto_header(){
  //Check if active
  if(get_post_meta(get_the_ID(), "niche-auto-img-title-checkbox", true)!="true")
    return;
  //Is active --> print stuff ?>
  <h1><?php the_title();?></h1>
  <?php if(has_post_thumbnail())
    the_post_thumbnail('post-thumbnail', ['class' => 'fullwidth']);
}

// Add the Auto image and title metabox - create the markup
function niche_auto_img_title_html($object){
  wp_nonce_field(basename(__FILE__), "niche-meta-box"); ?>
  <div>
    <?php $active = get_post_meta($object->ID, "niche-auto-img-title-checkbox", true); /* Convert to bool */ $active=($active=="true" ? true : false);?>
    <label for="niche-auto-img-title-checkbox">Automatische Titel &amp; Bildfunktion </label>
    <input name="niche-auto-img-title-checkbox" type="checkbox" value="<?php echo ($active? "true" : "false"); ?>" <?php echo ($active? "checked":""); ?>>
    <script>$('input[name="niche-auto-img-title-checkbox"]').click().click();</script>
  </div>
  <?php
}
//Add the listener
function niche_auto_img_title_box(){
    add_meta_box("niche-auto-meta-box", "Niche Site Settings", "niche_auto_img_title_html", "post", "side", "high", null);
}
add_action("add_meta_boxes", "niche_auto_img_title_box");

//Save the settings
function save_niche_meta_box($post_id, $post, $update){
  //Some preventions for hacks
  if(!isset($_POST["niche-meta-box"]) || !wp_verify_nonce($_POST["niche-meta-box"], basename(__FILE__)))
    return $post_id;
  if(!current_user_can("edit_post", $post_id))
      return $post_id;
  if(defined("DOING_AUTOSAVE") && DOING_AUTOSAVE)
      return $post_id;
  if("post" != $post->post_type)
      return $post_id;

  //Create post meta if not existend
  if(!get_post_meta($post_id, "niche-auto-img-title-checkbox", true))
    add_post_meta( $post_id, "niche-auto-img-title-checkbox", "", true);
  //Allright -- fetch data and save
  $checked = isset($_POST["niche-auto-img-title-checkbox"]);
  //Save post
  update_post_meta($post_id, "niche-auto-img-title-checkbox", ($checked?"true":"false"));
  //return post id
  return $post_id;
}
add_action("save_post", "save_niche_meta_box", 10, 3);

?>
