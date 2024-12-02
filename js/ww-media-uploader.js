jQuery(document).ready(function($) {
    // Ensure that the WordPress media uploader is correctly initialized
    console.log('jQuery is loaded:', typeof $);

    $('#ww_select_images_button').click(function(e) {
        e.preventDefault();

        // Open the WordPress media frame
        var frame = wp.media({
            title: 'Select Images',
            button: { text: 'Use These Images' },
            multiple: true // Allow multiple image selection
        });

        // When images are selected
        frame.on('select', function() {
            var selection = frame.state().get('selection');
            var imageUrls = [];

            selection.each(function(attachment) {
                imageUrls.push(attachment.attributes.url); // Collect image URLs
            });

            console.log('Selected Images:', imageUrls);

            // Update the hidden input with the selected image URLs
            var currentUrls = $('#ww_slider_images').val();
            var newUrls = currentUrls ? currentUrls.split(',') : [];
            newUrls = newUrls.concat(imageUrls); // Add new URLs
            $('#ww_slider_images').val(newUrls.join(',')); // Update hidden input value

            // Update the preview of selected images
            $('#image-preview').html('');
            newUrls.forEach(function(url) {
                $('#image-preview').append('<div class="image-preview-item" data-url="' + url + '"><img src="' + url + '" style="max-width: 100px; margin: 10px;"> <button type="button" class="remove-image">&times;</button></div>');
            });
        });

        // Open the media frame
        frame.open();
    });

    // Handle image removal
    $('#image-preview').on('click', '.remove-image', function() {
        var imageUrl = $(this).closest('.image-preview-item').data('url');
        console.log('Removing image:', imageUrl);

        // Remove the image from the preview
        $(this).closest('.image-preview-item').remove();

        // Remove the URL from the hidden input
        var currentUrls = $('#ww_slider_images').val();
        var newUrls = currentUrls ? currentUrls.split(',') : [];
        newUrls = newUrls.filter(function(url) {
            return url !== imageUrl;
        });
        $('#ww_slider_images').val(newUrls.join(',')); // Update hidden input value
    });
});

