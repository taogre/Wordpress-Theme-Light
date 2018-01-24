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

//Register Customizer img
function register_customizer($wp_customize){
  //Add the autor section
  $wp_customize->add_section('niche_author_section', array('title'=>"Author image", 'active_callback' => 'is_front_page'));
  $wp_customize->add_setting(
		// $id
		'author_image',
		// $args
		array(
			'default'		=> get_stylesheet_directory_uri() . '/images/screenshot.jpg',
			'sanitize_callback'	=> 'esc_url_raw',
			'transport'		=> 'postMessage'
		)
	);
  //Add setting
  $wp_customize->add_control(
		new WP_Customize_Image_Control(
			// $wp_customize object
			$wp_customize,
			// $id
			'author_image',
			// $args
			array(
				'settings'		=> 'author_image',
				'section'		=> 'niche_author_section',
				'label'			=> 'Author image',
				'description'	=> 'Select Author the image'
			)
		)
	);
  //Add the adsens section
  $wp_customize->add_section('niche_adsense', array('title'=>"Adsense", 'active_callback' => 'is_front_page'));
  //Adsense verifier
  $wp_customize->add_setting('niche_adsense_verifier', array(
    'default' => "<!-- Code -->",
    'sanitize_callback' => ''
  ));
  $wp_customize->add_control('niche_adsense_verifier', array(
    'type' => 'textarea',
    'section' => 'niche_adsense', // Add a default or your own section
    'label' => "Adsense Verifier",
    'description' => htmlspecialchars("Ad the adsense code which is going between <head> and </head>"),
  ));
  //First adsense block
  $wp_customize->add_setting('niche_adsense_1', array(
    'default' => "<!-- Code -->",
    'sanitize_callback' => ''
  ));
  $wp_customize->add_control('niche_adsense_1', array(
    'type' => 'textarea',
    'section' => 'niche_adsense', // Add a default or your own section
    'label' => "Adsense 1",
    'description' => "Ad the adsense code for the first ad",
  ));
  //second adsense block
  $wp_customize->add_setting('niche_adsense_2', array(
    'default' => "<!-- Code -->",
    'sanitize_callback' => ''
  ));
  $wp_customize->add_control('niche_adsense_2', array(
    'type' => 'textarea',
    'section' => 'niche_adsense', // Add a default or your own section
    'label' => "Adsense 2",
    'description' => "Ad the adsense code for the second ad",
  ));
}
add_action('customize_register', 'register_customizer');


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
function the_list_item(){
  ?>
  <!-- Define list item -->
  <div class="post-list-item">
    <div class="imageholder">
      <div>
        <?php the_post_thumbnail(); ?>
        <!-- Add the link -->
        <div class="image-overlay"></div>
        <a href="<?php echo get_permalink(); ?>"><span></span>Artikel Lesen</a>
      </div>
    </div>
    <div class="contentholder">
      <a href="<?php echo get_permalink(); ?>" style="text-decoration:none"><h1><?php the_title(); ?></h1></a>
      <?php the_excerpt(); ?>
    </div>
  </div>

<?php } ?>
