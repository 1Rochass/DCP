<?php 
// Show categoies
function DCP_showCategories() {
	// For WP
	global $wpdb;
	// Get categories name
	$allCategories = $wpdb->get_results("
		SELECT * FROM wp_terms
		JOIN wp_termmeta
		on wp_terms.term_id = wp_termmeta.term_id
		WHERE wp_termmeta.meta_value > 0
		");
// Display response
	foreach ($allCategories as $key => $value) {
		echo "<input type='button' value='" . $value->name . "' id='" . $value->term_id . "' class='category'>";
	}

	// Else showing zero after content
	wp_die();	
}

// Show count products
function DCP_showCountProducts() {
	
	$categoryId = $_POST['categoryId'];
	$categoryName = $_POST['categoryName'];

	// For WP
	global $wpdb;
	// Get categories name
	$countProduct = $wpdb->get_row("
		SELECT * FROM wp_termmeta
		WHERE term_id = $categoryId 
		AND meta_key = 'product_count_product_cat'
		");

	echo 'Категория: ' . $categoryName . "</br>";
	echo "Количество товаров: " . $countProduct->meta_value . "</br>";
	echo " <input type='button' value='Удалить' id='" . $categoryId . "' class='delete'>";
	

	// Else showing zero after content
	wp_die();	
}



 function DCP_deleteProducts() {

 	$categoryId = $_POST['categoryId'];
	//$categoryName = $_POST['categoryName'];

 	// For WP
	global $wpdb;
 	
	// Get all products from categry
	$allProductsFromCategory = $wpdb->get_results("
		SELECT * FROM wp_term_relationships 
		WHERE term_taxonomy_id = $categoryId
	");

	// Here we must put deleted rows
	$wp_term_relationships = [];
	$wp_postmeta = [];
	$wp_posts = [];


	// echo "<pre>";
	// var_dump($allProductsFromCategory);
	// echo "</pre>";
	// wp_die();

	foreach ($allProductsFromCategory as $value) {
		// Delete from wp_term_relationships
		$wp_term_relationships[] = $wpdb->query("
			DELETE * FROM wp_term_relationships 
			WHERE object_id = $value->object_id
			"); 
		// Delete from wp_postmeta
		$wp_postmeta[] = $wpdb->query("
			DELETE * FROM wp_postmeta 
			WHERE post_id = $value->object_id
			");
		// Delete from wp_posts
		$wp_posts[] = $wpdb->query("
			DELETE * FROM wp_posts 
			WHERE id = $value->object_id
			");
		
	}

	echo count($wp_term_relationships) . " строк удалено из таблицы wp_term_relationships <br>";
	echo count($wp_postmeta) . " строк удалено из таблицы wp_postmeta <br>";
	echo count($wp_posts) . " строк удалено из таблицы wp_posts <br>";
 	// Else showing zero after content
	wp_die();

// 	DELETE FROM wp_term_relationships WHERE object_id IN (SELECT ID FROM wp_posts WHERE post_type = 'product'); 
// DELETE FROM wp_postmeta WHERE post_id IN (SELECT ID FROM wp_posts WHERE post_type = 'product'); 
// DELETE FROM wp_posts WHERE post_type = 'product';
}