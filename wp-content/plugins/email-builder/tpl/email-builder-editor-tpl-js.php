<script type="text/javascript">
	(function($) {
		$(document).ready(function(){
			$(".ngfb-notice").remove();

			$(".preview-box").each(function(){
				var box = $(this);

				$.ajax({
					"url": "/wp-json/email-builder/v1/statictemplate?template=" + fragment.template + "&type=" + fragment.type + "&prefix=" + fragment.site + "&cache=" + (new Date().getTime()),
					"dataType": "json",
					"success": function(r) {
						box.html( r[0].Content );
					}
				});
			});

			$(".close-window").on("click", function(){
				window.close();
			});

			$(".wp-submenu a").each(function(){
				if( $(this).attr("href").indexOf("last-word-email-builder-editor") != -1 ) {
					$(this).parent().hide().parents(".wp-has-submenu").eq(0).removeClass("wp-has-current-submenu");
				}
			});

			$(".triggerable").each(function(){
				var triggerable = $(this);

				triggerable.find(".triggerable-button button").on("click", function(e){
					e.preventDefault();

					$(this).parent().parent().toggleClass("active");
				});
			});

			$('.add-image-button, .update-image-button').on('click', function(e) {
				e.preventDefault();

	    		var button = $(this);
    			var input = button.siblings("input");
    			var image = button.siblings("img");

    		    var custom_uploader = wp.media({
						title: 'Insert image',
						library: { type : 'image' },
						button: { text: 'Use this image' },
						id: 'library-' + (Math.random() * 10),
						multiple: false
					}).on('select', function() {
						var attachment = custom_uploader.state().get('selection').first().toJSON();

						button.parent().addClass('active');

						input.val(attachment.url);
						image.attr('src', attachment.url);
				})
				.open();
			});
			 
			$('.remove-image-button').on('click', function(e) {
				e.preventDefault();

				var button = $(this);
    			var input = button.siblings("input");
    			var image = button.siblings("img");
    			
    			button.parent().removeClass('active');
    			input.val('');
    			image.removeAttr('src');
			});
		});

	})( jQuery );
</script>
