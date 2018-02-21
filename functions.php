<?php

//Register navigation menu
register_nav_menus(array(
  'primary' => "Navigation Menu"
));

//Register title tag
add_theme_support('title-tag');

//Register capability for logo
add_theme_support('custom-logo', array(
	'height' => 76,
	'width' => 150,
	'flex-width' => true,
  'flex-height' => false
));

//Register capability for fautured image
add_theme_support('post-thumbnails');
set_post_thumbnail_size(400,200);

//Load the CSS and JS
function theme_styles(){
	// Load all of the styles that need to appear on all pages
  wp_enqueue_style('main', get_template_directory_uri().'/styler.css');
  //Load the js
  wp_enqueue_script('jqueryCustm', 'https://code.jquery.com/jquery-3.3.1.min.js', array(), null, false);
  wp_enqueue_script('mainjs', get_template_directory_uri().'/main.js', array(), null, true);
  wp_enqueue_script('cookielib', get_template_directory_uri().'/cookie-lib.js', array(), null, false);
  //Load conditionally
  if(is_single() || is_page()){
    //Load stuff only for singlepages
    wp_enqueue_style('singleonly', get_template_directory_uri().'/singleonly.css');
  }
  else{
    wp_enqueue_style('listonly', get_template_directory_uri().'/listonly.css');
  }
}
add_action('wp_enqueue_scripts', 'theme_styles');


//Get recent posts
function get_recent_posts(){
  $id = get_the_ID();
  $args = array(
  	'numberposts' => 4,
  	'orderby' => 'rand',
  	'post_type' => 'post',
  	'post_status' => 'publish'
  );
  //Check if only one
  if(is_single() || is_page())$args['post__not_in']=array($id);
  //Return stuff
  return wp_get_recent_posts( $args, ARRAY_A );
}


//Get the user terms id
function the_terms_conditions_url(){
  $pages = get_pages(array(
    'meta_key' => '_wp_page_template',
    'meta_value' => 'terms-conditions.php'
  ));
  $id = $pages[0]->ID;
  echo get_permalink($id);
}


//Add the "the_content"-hook
add_filter('the_content', 'adsense_to_post');
function adsense_to_post($content){
  if(is_singular('post')){
    //Fetch ads
    $adsense1 = get_theme_mod('niche_adsense_1');
    $adsense2 = get_theme_mod('niche_adsense_2');
    $content = str_ireplace('%adsense1%', $adsense1, $content);
    $content = str_ireplace('%adsense2%', $adsense2, $content);
  }
  return $content;
}


//Define list type
function the_list_item(){ ?>
  <!-- Define list item -->
  <div class="post-list-item">
    <div class="imageholder">
      <div>
        <?php the_post_thumbnail(); ?>
        <!-- Add the link -->
        <span>Artikel Lesen</span>
        <a href="<?php echo get_permalink(); ?>">Artikel lesen</a>
      </div>
    </div>
    <div class="contentholder">
      <a style="text-decoration:none" href="<?php echo get_permalink(); ?>"><h1><?php the_title(); ?></h1></a>
      <?php the_excerpt(); ?>
    </div>
  </div><?php
}

require_once( __DIR__ . '/functions/meta-box.php');
require_once( __DIR__ . '/functions/customizer-settings.php');

?>
