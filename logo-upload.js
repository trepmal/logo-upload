jQuery(document).ready( function($) {

	var file_frame,
		$button = $('.upload-image'),
		$removeButton = $('.remove-image');

	$button.click( function( event ){

		event.preventDefault();

		// If the media frame already exists, reopen it.
		if ( file_frame ) {
			file_frame.open();
			return;
		}

		// Create the media frame.
		file_frame = wp.media.frames.file_frame = wp.media({
			title: jQuery( this ).data( 'uploader_title' ),
			button: {
				text: jQuery( this ).data( 'uploader_button_text' ),
			},
			library: {
				type: 'image'
			},
			multiple: false  // Set to true to allow multiple files to be selected
		});

		// When an image is selected, run a callback.
		file_frame.on( 'select', function() {
			// We set multiple to false so only get one image from the uploader
			attachment = file_frame.state().get('selection').first().toJSON();

			if ( $button.next('input').next('br').next('img').length > 0 ) {
				$button.next('input').next('br').next('img').remove();
			}

			// set input
			$('#blog_logo').val( attachment.id );
			// set preview
			img = '<img src="'+ attachment.url +'" />';
			$button.next('input').next('br').after( img );

		});

		// Finally, open the modal
		file_frame.open();
	});

	$removeButton.click( function( event ){

		event.preventDefault();

		$('#blog_logo').val('');
		$removeButton.next('br').next('img').remove();
	});
});