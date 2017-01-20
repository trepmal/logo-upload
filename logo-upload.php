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

	/**
	 * Get hooked in
	 *
	 */
	function __construct( ) {
		add_filter( 'admin_init' , array( $this , 'register_fields' ) );
	}

	/**
	 * Register our option
	 *
	 */
	function register_fields() {
		register_setting( 'general', 'blog_logo', 'absint' );
		add_settings_field( 'blog_logo', '<label for="blog_logo">' . __( 'Blog Logo', 'logo-upload' ) . '</label>' , array( $this, 'fields_html' ) , 'general' );
	}

	/**
	 * Output HTML for field
	 *
	 */
	function fields_html() {
		$value = get_option( 'blog_logo', '' );
		wp_enqueue_media();
		wp_enqueue_script( 'logo-upload', plugins_url( 'logo-upload.js', __FILE__ ), array( 'jquery' ) );
		wp_localize_script( 'logo-upload', 'logoUpload', array(
			'textFullSize' => __( 'Full size', 'logo-upload' ),
		) );

		echo '<input name="blog_logo" id="blog_logo" type="hidden" value="' . esc_attr( $value ) . '" />';

		echo '<input type="button" class="button upload-image"
			value="' .esc_attr__( 'Upload', 'logo-upload' ) . '"
			data-uploader_title="' . esc_attr__( 'Select an Image', 'logo-upload' ) . '"
			data-uploader_button_text="' . esc_attr__( 'Select', 'logo-upload' ) . '" />';

		echo '<input type="button" class="button remove-image" value="' . esc_attr__( 'Remove', 'logo-upload' ) . '" /><br />';

		echo '<div id="logo-preview">';
		$img = wp_get_attachment_image_src( $value, 'medium' );
		if ( $img ) {
			echo '<img src="' . esc_url( $img[0] ) . '" /><br />';
			$img = wp_get_attachment_image_src( $value );
			echo '<a href="' . esc_url( $img[0] ) . '">Full size</a>';
		}
		echo '</div>';

	}

}