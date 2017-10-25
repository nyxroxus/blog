<?php

function customtheme_custom_logo_setup(){
  $defaults = array(
  'height' => 100,
  'width' =>  400,
  'flex-height' => true,
  'flex-width' => true,
  );
  add_theme_support( 'custom-logo', $defaults );
}
add_action( 'after_setup_theme', customtheme_custom_logo_setup );

register_nav_menus( array(
  'primary'   =>  __( 'Primary navigation', 'custom-theme' ),
) );
?>
