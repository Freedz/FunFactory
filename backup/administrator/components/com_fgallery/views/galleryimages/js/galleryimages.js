jQuery.noConflict();
jQuery(document).ready(function(){	
	jQuery( ".adminlist" ).sortable({ 
		items: '.galleryimage',
		cursor: 'move', 
		forcePlaceholderSize: true,
		update: function(event, ui) {
			album = jQuery(this).attr('id');
			sort_url = jQuery('.adminlist #sort_url').attr('href');
			jQuery('.adminlist .galleryimage').each(function(index){
				img_id = jQuery(this).attr('id');
				img_id = img_id.replace("image_", "");
				jQuery.ajax({
					url : sort_url,
					type: "GET",
					data: ({id : img_id, gall_id : album, order: index})
				});
			});
		}
	});
});