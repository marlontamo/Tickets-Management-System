
jQuery(function() {

    jQuery("#deactivate-books-management-system").on("click", function(event) {

        event.preventDefault();

        var hasConfirm = confirm("Are you sure want to de-activate 'tickets Management System'?")

        // Cancel -> false

        // Ok -> true

        if (hasConfirm) {

            var deactivateLink = jQuery(this).attr("href");

            window.location.href = deactivateLink;
        }
    });

    // Form validation
    jQuery("#frm-add-book").validate();

    // Handle Media Upload Event
    jQuery("#btn-upload-cover").on("click", function(event) {

        event.preventDefault();

        // Media Object
        var mediaUploader = wp.media({
            title: "Upload Book Cover",
            multiple: false
        });

        // Media open
        mediaUploader.open();

        // Cover image file selection
        mediaUploader.on("select", function() {

            var attachment = mediaUploader.state().get("selection").first().toJSON();

            //console.log(attachment);
            jQuery("#cover_image").attr("src",attachment.url);
        });
    });
});