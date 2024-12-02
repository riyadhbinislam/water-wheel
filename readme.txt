Water Wheel Carousel Gallery Plugin

Version: 1.1.0
Author: Riyadh Bin Islam
Requires at least: WordPress 6.1
Requires PHP: 7.2

Description

The Water Wheel Carousel Gallery Plugin is a simple and easy-to-use WordPress plugin that helps you create a stunning, touch-enabled carousel slider on your website. Showcase your photos in an engaging Waterwheel-style rotating gallery.

Features

	•	Fully responsive design.
	•	Touch-enabled for mobile devices.
	•	Seamless integration with WordPress Media Library.
	•	Customizable via an admin settings page.
	•	Smooth animations for a modern carousel effect.
	•	Built with jQuery for simplicity and flexibility.

Installation

	1.	Download the plugin or clone the repository.
	2.	Upload the plugin folder to your WordPress installation at wp-content/plugins/.
	3.	Activate the plugin from the Plugins menu in your WordPress admin panel.
	4.	Configure settings via the WW Slider Setting menu under the admin dashboard.

Usage

1. Admin Configuration

	•	Navigate to WW Slider Setting in your WordPress admin panel.
	•	Use the Select Images button to choose images from the WordPress Media Library.
	•	Save your settings.

2. Display the Carousel

	•	Use the shortcode [water_wheel_slider] to display the carousel on any page or post.

Example:

[water_wheel_slider]


Files Overview

Main Files

	•	water-wheel.php: Core plugin file for functionality.
	•	css/ww-style.css: Styles for the carousel layout.
	•	js/ww-plugin.js: Core jQuery for the carousel animation.
	•	js/ww-media-uploader.js: JavaScript for handling the media uploader in the admin settings.


Development

Enqueue Scripts & Styles

	•	Admin Area: The ww-media-uploader.js and admin-specific CSS are loaded only in the admin area using admin_enqueue_scripts.
	•	Frontend: Gallery-related scripts (ww-plugin.js) and styles (ww-style.css) are loaded on the frontend via wp_enqueue_scripts.

JavaScript Dependencies

	•	jQuery is required for the carousel functionality and WordPress Media Uploader integration.

Contributions

Contributions are welcome!
Feel free to fork the repository and submit pull requests.

License

This plugin is licensed under the GNU General Public License v2 or later.
For more details, visit: http://www.gnu.org/licenses/gpl-2.0.html


Support

If you encounter any issues or have questions, please reach out via the GitHub repository: GitHub