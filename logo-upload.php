<?php
/*
 * Plugin Name: Logo Upload
 * Plugin URI: trepmal.com
 * Description:
 * Version:
 * Author: Kailey Lampert
 * Author URI: kaileylampert.com
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * TextDomain: logo-upload
 * DomainPath:
 * Network:
 */
$logo_upload = new Logo_Upload;
class Logo_Upload {

	function __construct( ) {
		add_filter( 'admin_init' , array( &$this , 'register_fields' ) );
	}

	function register_fields() {
		register_setting( 'general', 'blog_logo', 'intval' );
		add_settings_field('blog_logo', '<label for="blog_logo">'. __('Blog Logo', 'logo-upload' ) .'</label>' , array(&$this, 'fields_html') , 'general' );
	}

	function fields_html() {
		$value = get_option( 'blog_logo', '' );
		wp_enqueue_media();
		wp_enqueue_script( 'logo-upload', plugins_url('logo-upload.js', __FILE__ ), array('jquery') );

		echo "<input name='blog_logo' id='blog_logo' type='hidden' value='$value' />";

		$button_text = __( 'Upload', 'logo-upload' );
		$uploader_title_text = __( 'Select an Image', 'logo-upload' );
		$uploader_button_text = __( 'Select', 'logo-upload' );
		echo "<input type='button' class='button upload-image' value='$button_text' data-uploader_title='$uploader_title_text' data-uploader_button_text='$uploader_button_text' />";

		$button_text = __( 'Remove', 'logo-upload' );
		echo "<input type='button' class='button remove-image' value='$button_text' /><br />";
		if ( ! empty( $value ) ) {
			$img = wp_get_attachment_image_src( $value );
			echo "<img src='$img[0]' />";
		}
	}

}