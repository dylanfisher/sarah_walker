<?php

//  ____                  _ _
// | ___|  __ _ _ __   __| | |__   _____  __
// |___ \ / _` | '_ \ / _` | '_ \ / _ \ \/ /
//  ___) | (_| | | | | (_| | |_) | (_) >  <
// |____/ \__,_|_| |_|\__,_|_.__/ \___/_/\_\


//
// Enqueue scripts
//

function sandbox_enqueue_scripts() {
  $application = sandbox_is_local() ? 'application.js' : 'application.min.js';
  wp_enqueue_script('jquery');
  wp_enqueue_script(
    'application',
    get_stylesheet_directory_uri() . '/js/build/' . $application,
    array('jquery')
  );
}
add_action( 'wp_enqueue_scripts', 'sandbox_enqueue_scripts' );


//
// Enables
//

// Custom menus
add_theme_support('menus');

// Custom Image Sizes
// add_image_size( 'custom-image-size-name', 300, 300, true ); // Custom Image - Name, Width, Height, Hard Crop boolean

// Check for custom Single Post templates by category ID. Format for new template names is single-category[ID#].php (ommiting the brackets)
// add_filter('single_template', create_function('$t', 'foreach( (array) get_the_category() as $cat ) { if ( file_exists(TEMPLATEPATH . "/single-{$cat->term_id}.php") ) return TEMPLATEPATH . "/single-{$cat->term_id}.php"; } return $t;' ));

//
// Disables
//

// Disable automatic updates for certain plugins
function filter_plugin_updates( $value ) {
    unset( $value->response['wp-pjax/wp-pjax.php'] );
    return $value;
}
add_filter( 'site_transient_update_plugins', 'filter_plugin_updates' );

// Disable Admin Bar
add_filter('show_admin_bar', '__return_false');

// Disable Wordpress Generator meta tag
function sandbox_version_info() {
   return '';
}
add_filter('the_generator', 'sandbox_version_info');

// Remove unnecessary wp_head items
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'parent_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);

// Remove meta boxes from dashboard
function sandbox_remove_dashboard_widgets(){
  global $wp_meta_boxes;
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);}
add_action('wp_dashboard_setup', 'sandbox_remove_dashboard_widgets' );

// Remove unneccesary admin menu panels. Uncomment to disable
function sandbox_remove_menus(){
  // remove_menu_page( 'index.php' );                  //Dashboard
  // remove_menu_page( 'edit.php' );                   //Posts
  // remove_menu_page( 'upload.php' );                 //Media
  // remove_menu_page( 'edit.php?post_type=page' );    //Pages
  remove_menu_page( 'edit-comments.php' );          //Comments
  // remove_menu_page( 'themes.php' );                 //Appearance
  // remove_menu_page( 'plugins.php' );                //Plugins
  // remove_menu_page( 'users.php' );                  //Users
  // remove_menu_page( 'tools.php' );                  //Tools
  // remove_menu_page( 'options-general.php' );        //Settings
}
add_action( 'admin_menu', 'sandbox_remove_menus' );


//
// Custom functions
//

// Check if running on localhost
function sandbox_is_local() {
  $localhost_whitelist = array( '127.0.0.1', '::1' );
  if( in_array($_SERVER['REMOTE_ADDR'], $localhost_whitelist) ) {
    return true;
  } else {
    return false;
  }
}

// Function to create slug out of text
function sandbox_slugify( $text ) {
  $str = strtolower( trim( $text ) );
  $str = preg_replace( '/[^a-z0-9-]/', '-', $str );
  $str = preg_replace( '/-+/', "-", $str );
  return trim( $str, '-' );
}

// Custom excerpt size
function sandbox_custom_excerpt($limit) {
  $excerpt = explode(' ', get_the_excerpt(), $limit);
  if (count($excerpt)>=$limit) {
    array_pop($excerpt);
    $excerpt = implode(" ",$excerpt).'...';
  } else {
    $excerpt = implode(" ",$excerpt);
  }
  $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
  return $excerpt;
}

// Limit content
function sandbox_content($limit) {
  $content = explode(' ', get_the_content(), $limit);
  if (count($content)>=$limit) {
    array_pop($content);
    $content = implode(" ",$content).'...';
  } else {
    $content = implode(" ",$content);
  }
  $content = preg_replace('/\[.+\]/','', $content);
  $content = apply_filters('the_content', $content);
  $content = str_replace(']]>', ']]&gt;', $content);
  return $content;
}


//
// Filters
//

function sandbox_adjacent_post_where($sql) {
  if ( !is_main_query() || !is_singular() )
    return $sql;

  $the_post = get_post( get_the_ID() );
  $patterns = array();
  $patterns[] = '/post_date/';
  $patterns[] = '/\'[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}\'/';
  $replacements = array();
  $replacements[] = 'menu_order';
  $replacements[] = $the_post->menu_order;
  // print_r(preg_replace( $patterns, $replacements, $sql ));
  return preg_replace( $patterns, $replacements, $sql );
}
add_filter( 'get_next_post_where', 'sandbox_adjacent_post_where' );
add_filter( 'get_previous_post_where', 'sandbox_adjacent_post_where' );

function sandbox_adjacent_post_sort($sql) {
  if ( !is_main_query() || !is_singular() )
    return $sql;

  $pattern = '/post_date/';
  $replacement = 'menu_order';
  // print_r(preg_replace( $pattern, $replacement, $sql ));
  return preg_replace( $pattern, $replacement, $sql );
}
add_filter( 'get_next_post_sort', 'sandbox_adjacent_post_sort' );
add_filter( 'get_previous_post_sort', 'sandbox_adjacent_post_sort' );

// Add page slug to body class
function sandbox_add_slug_body_class( $classes ) {
  global $post;
  if ( isset( $post ) ) {
    $classes[] = $post->post_type . '-' . $post->post_name;
  }
  return $classes;
}
add_filter( 'body_class', 'sandbox_add_slug_body_class' );

// Rename "Posts" to "Work"
// http://new2wp.com/snippet/change-wordpress-posts-post-type-news/
function sandbox_change_post_menu_label() {
  global $menu;
  global $submenu;
  $menu[5][0] = 'Work';
  $submenu['edit.php'][5][0] = 'Work';
  $submenu['edit.php'][10][0] = 'Add Work';
  $submenu['edit.php'][16][0] = 'Work Tags';
  echo '';
}

function sandbox_change_post_object_label() {
  global $wp_post_types;
  $labels = &$wp_post_types['post']->labels;
  $labels->name = 'Work';
  $labels->singular_name = 'Work';
  $labels->add_new = 'Add Work';
  $labels->add_new_item = 'Add Work';
  $labels->edit_item = 'Edit Work';
  $labels->new_item = 'Work';
  $labels->view_item = 'View Work';
  $labels->search_items = 'Search Work';
  $labels->not_found = 'No Work found';
  $labels->not_found_in_trash = 'No Work found in Trash';
}

add_action( 'admin_menu', 'sandbox_change_post_menu_label' );
add_action( 'init', 'sandbox_change_post_object_label' );

?>
