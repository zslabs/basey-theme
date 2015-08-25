<?php

/**
 * Enqueue styles
 * @return void
 */
function basey_styles() {
  wp_enqueue_style( 'basey-styles', get_template_directory_uri() . '/assets/css/build/app.css', false, BASEY_VER, 'all' );
}
add_action( 'wp_enqueue_scripts', 'basey_styles', 12 );

/**
 * Enqueue scripts
 * @return void
 */
function basey_enqueue_scripts() {
  wp_enqueue_script( 'jquery' );

  // Register the 'comment-reply' JS if we are on a single post, comments are open and we have the 'thread_comments' options set
  if ( is_single() && comments_open() && get_option( 'thread_comments' ) ) {
    wp_enqueue_script( 'comment-reply' );
  }

  wp_enqueue_script( 'basey-dep', get_template_directory_uri() . '/assets/js/build/deps.js', array( 'jquery' ), BASEY_VER, true );
  wp_enqueue_script( 'basey-scripts', get_template_directory_uri() . '/assets/js/build/app.js', array( 'jquery' ), BASEY_VER, true );
}
add_action( 'wp_enqueue_scripts', 'basey_enqueue_scripts' );

/**
 * Long name, but important function
 * If you're using SVG sprites, this is what will be passed to the into the DOM
 * rewrite function that converts your icon references to the appopriate SVG
 * @return void
 */
function basey_set_svg_sprite_path() { ?>
  <script>
    // SVG Icons
    svgSpritePath = "<?php echo get_stylesheet_directory_uri() . '/assets/svg/build/sprite.svg'; ?>";
  </script>

<?php }
add_action( 'wp_footer', 'basey_set_svg_sprite_path' );