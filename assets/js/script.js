jQuery(document).ready(function(){

	var data = {
		action: 'DCP_showCategories',
	};

	jQuery.post(ajaxurl, data, function(response){
		jQuery('#categories').html(response);
	});


	// Show count products
	jQuery('#categories').on('click', '.category', function() {
		var categoryId = jQuery(this).attr('id');
		var categoryName = jQuery(this).attr('value');

		var data = {
			action: 'DCP_showCountProducts',
			categoryId: categoryId,
			categoryName: categoryName,
		};

		jQuery.post(ajaxurl, data, function(response) {
			jQuery('#categoryInfo').html(response);
		});
	});


	// Delete all products from category
	jQuery('#categoryInfo').on('click', '.delete', function() {
		var categoryId = jQuery(this).attr('id');
		
		var data = {
			action: 'DCP_deleteProducts',
			categoryId: categoryId,
		};

		jQuery.post(ajaxurl, data, function(response) {
			jQuery('#categoryInfo').html(response);
		});
	});

});