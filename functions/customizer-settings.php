<?php

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

?>
