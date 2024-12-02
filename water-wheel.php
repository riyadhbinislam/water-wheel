<?php
/*
Plugin Name:        Water Wheel Carousel Gallery
Plugin URI:         https://github.com/riyadhbinislam?tab=repositories
Description:        A simple and easy-to-use jQuery plugin that helps you create a slider widget on your web page for showcasing your photos in a touch-enabled Waterwheel Carousel interface.
Version:            1.1.0
Requires at Least:  6.7.1
Requires PHP:       7.2
Author:             Riyadh Bin Islam
Author URI:         https://github.com/riyadhbinislam
License:            GNU General Public License v2 or later
License URI:        http://www.gnu.org/licenses/gpl-2.0.html
Update URI:         https://github.com/riyadhbinislam
Text Domain:        ww
*/


/**
 * Water Wheel Slider Plugin

*-- Plugin Settings

*---- Global settings for default options like color, typography, size etc
*---- Sliders
*------ Add new slider
*-------- Title
*-------- Select images
*-------- Settings
*----- View list of created sliders

*-------eitay each slider er sathe shortcode ta dekhabe jate copy kore use kora jay

*------WP er table use hobe

*-------bulk action, trash, edit eigula kora jabe\
*/







if (!defined('ABSPATH')) {
  exit; // Exit if accessed directly
}

// Enqueue Styles
function ww_enqueue_styles() {
  // Enqueue the custom CSS for the plugin
  wp_enqueue_style('ww-style', plugins_url('css/ww-style.css', __FILE__), array(), '1.0.0', 'all');
}

// Enqueue Plugin Scripts for Frontend
function ww_enqueue_plugin_script() {
  // Enqueue the custom plugin script
  wp_enqueue_script('ww-plugin-script', plugins_url('js/ww-plugin.js', __FILE__), array('jquery'), '1.0.0', true);
}

// Enqueue Media Uploader Scripts for Admin (Settings Page)
function ww_enqueue_media_uploader_scripts($hook) {
  // Check if we're on the settings page for the Water Wheel Slider
  if ('toplevel_page_water-wheel-slider-settings' === $hook) {
      // Enqueue the WordPress media uploader
      wp_enqueue_media();

      // Enqueue the custom JavaScript for handling the media uploader
      wp_enqueue_script('ww-media-uploader', plugins_url('js/ww-media-uploader.js', __FILE__), array('jquery'), '1.0.0', true);
      wp_enqueue_style('ww-admin-style', plugins_url('css/ww-admin-style.css', __FILE__), array(), '1.0.0', 'all');
  }
}

// Hook for the Admin and Frontend
add_action('wp_enqueue_scripts', 'ww_enqueue_styles'); // Enqueue styles on the frontend
add_action('wp_enqueue_scripts', 'ww_enqueue_plugin_script'); // Enqueue plugin script on the frontend
add_action('admin_enqueue_scripts', 'ww_enqueue_media_uploader_scripts'); // Enqueue media uploader scripts only in the admin area

// Register the settings page
function ww_slider_add_menu_page() {
  add_menu_page(
      'Water Wheel Slider Settings',    // Page title
      'WW Slider Setting',             // Menu title
      'manage_options',                 // Capability
      'water-wheel-slider-settings',    // Menu slug
      'ww_slider_settings_page',        // Correct callback
      'dashicons-images-alt2',          // Icon
      101                               // Position
  );
}
add_action('admin_menu', 'ww_slider_add_menu_page');

// Callback function to display the settings page
function ww_slider_settings_page() {
  ?>
  <div class="wrap">
      <h1>Water Wheel Slider Settings</h1>
      <form method="post" action="options.php">
          <?php
          settings_fields('ww_slider_settings_group'); // Security fields
          do_settings_sections('ww-slider-settings');  // Settings sections
          submit_button(); // Save button
          ?>
      </form>
  </div>
  <?php
}

// Register settings, sections, and fields
function ww_slider_register_settings() {
  // Register a setting
  register_setting('ww_slider_settings_group', 'ww_slider_images');

  // Add a section
  add_settings_section(
      'ww_slider_main_section',
      'Main Settings',
      'ww_slider_section_callback',
      'ww-slider-settings'
  );

  // Add a field for the image URLs
  add_settings_field(
      'ww_slider_images_field',
      'Slider Images (Select from Media Library)',
      'ww_slider_images_field_callback', // Correctly referenced callback
      'ww-slider-settings',
      'ww_slider_main_section'
  );
}

add_action('admin_init', 'ww_slider_register_settings');

// Section callback
function ww_slider_section_callback() {
  echo '<p>Select images for the slider from your Media Library.
            Use [water_wheel_slider] shortcode To View This Gallery In Frontend</p>';
}

// Field callback with media uploader
function ww_slider_images_field_callback() {
  $images = get_option('ww_slider_images', '');
  ?>
  <input type="button" class="button" value="Select Images" id="ww_select_images_button" name="ww_select_images_button">
  <input type="hidden" name="ww_slider_images" id="ww_slider_images" value="<?php echo esc_attr($images); ?>" style="width: 100%;">

  <!-- Displaying selected images -->
  <div id="image-preview">
      <?php
      $selected_images = get_option('ww_slider_images', '');
      if (!empty($selected_images)) {
          $image_urls = explode(',', $selected_images); // Get the list of selected images
          foreach ($image_urls as $url) {
              echo '<div class="image-preview-item" data-url="' . esc_url(trim($url)) . '">
                      <img src="' . esc_url(trim($url)) . '" style="max-width: 100px; margin: 10px;">
                      <button type="button" class="remove-image" style="position: absolute; top: 5px; right: 5px;">&times;</button>
                  </div>';
          }
      }
      ?>
  </div>
  <?php
}


// Shortcode for the carousel
function water_wheel_slider_shortcode() {
  // Get image URLs from the settings field
  $images = get_option('ww_slider_images', '');
  $image_urls = explode(',', $images); // Convert comma-separated URLs into an array

  if (empty($image_urls) || !is_array($image_urls)) {
      return '<p>No images found for the slider. Please add images in the settings page.</p>';
  }

  ob_start();
?>
  <div id="carousel">
      <?php foreach ($image_urls as $index => $image_url): ?>
          <?php
          // Assign classes based on the position of the image
          $class = '';
          if ($index === 0) {
              $class = 'hideLeft';
          } elseif ($index === 1) {
              $class = 'prevLeftSecond';
          } elseif ($index === 2) {
              $class = 'prev';
          } elseif ($index === 3) {
              $class = 'selected';
          } elseif ($index === 4) {
              $class = 'next';
          } elseif ($index === 5) {
              $class = 'nextRightSecond';
          } else {
              $class = 'hideRight';
          }
          ?>
          <div class="<?php echo esc_attr($class); ?>">
              <img src="<?php echo esc_url(trim($image_url)); ?>" alt="Carousel Image <?php echo ($index + 1); ?>">
          </div>
      <?php endforeach; ?>
  </div>
  <div class="buttons">
      <button class="ww_button" id="prev">Prev</button>
      <button class="ww_button" id="next">Next</button>
  </div>
  <?php
  return ob_get_clean();
}
add_shortcode('water_wheel_slider', 'water_wheel_slider_shortcode');


?>