<?php

require_once( 'config/bones.php' ); // if you remove this, bones will break
// require_once( 'library/admin.php' );
// require_once( 'config/custom-post-type.php' );
// require_once( 'config/custom-widgets.php' );

/************* THUMBNAIL SIZE OPTIONS *************/

// Thumbnail sizes
// add_image_size( 'bones-thumb-600', 600, 150, true );


/************* ACTIVE SIDEBARS ********************/

// Sidebars & Widgetizes Areas
function bones_register_sidebars() {
	register_sidebar(array(
		'id' => 'sidebar1',
		'name' => __( 'Sidebar 1', 'bonestheme' ),
		'description' => __( 'The first (primary) sidebar.', 'bonestheme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));
}

/**
 * Enqueuing assets based on our current environment
 * Register all plugins
 * Enqueue as required by env, grunt handles concat and min
 */
function enqueue_theme_assets() {

  // Env Variables
  $env = array(
    'current' => $_SERVER['HTTP_HOST'],
    'production' => 'bones.com',
    'staging' => 'bones.aytoo.com'
  );

  // Styles
  wp_register_style( 'theme', get_stylesheet_directory_uri().'/library/css/theme.css', '', '1.0.0', 'all' );
  wp_register_style( 'application-css', get_stylesheet_directory_uri().'/library/public/application.min.css', '', '1.0.0', 'all' );

  // Scripts
  wp_register_script( 'modernizr', get_stylesheet_directory_uri().'/library/js/libs/modernizr.custom.min.js', '', '1.0.0', false );
  wp_register_script( 'mainjs', get_stylesheet_directory_uri().'/library/js/scripts.js', ['modernizr', 'jquery'], '1.0.0', true );
  wp_register_script( 'application-js', get_stylesheet_directory_uri().'/library/public/application.min.js', ['modernizr', 'jquery'], '1.0.0', true );


  // Enqueue based on env
  if( $env['current'] == $env['staging'] || $env['current'] == $env['production'] ) {
    wp_enqueue_script('modernizr');
    wp_enqueue_script('jquery');

    wp_enqueue_style('application-css');
    wp_enqueue_script('application-js');
  } else {
    wp_enqueue_script('modernizr');
    wp_enqueue_script('jquery');

    wp_enqueue_style('theme');
    wp_enqueue_script('mainjs');
  }

}

// Fire enqueue
add_action( 'wp_enqueue_scripts', 'enqueue_theme_assets', 999 );

?>
