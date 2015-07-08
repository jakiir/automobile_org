<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

add_action( 'init', 'automobile_taxonomies', 0 );
function automobile_taxonomies() {
    register_taxonomy(
        'automobile_product_category',
        'tlp_automobile',
        array(
            'labels' => array(
                'name' => 'AutoMobile Category ',
                'add_new_item' => 'Add New Category',
                'new_item_name' => "New AutoMobile Type Category"
            ),
            'show_ui' => true,
            'show_tagcloud' => false,
            'hierarchical' => true,
        )
    );
}
// Add columns
	add_filter( 'manage_edit-automobile_product_category_columns', 'automobile_product_category_columns' );
	function automobile_product_category_columns( $columns ) {
		$new_columns          = array();
		$new_columns['cb']    = $columns['cb'];
		$new_columns['thumb'] = __( 'Image', 'automobile' );

		unset( $columns['cb'] );

		return array_merge( $new_columns, $columns );
	}

add_filter( 'manage_automobile_product_category_custom_column', 'automobile_product_category_column', 10, 3 );


	function automobile_product_category_column( $columns, $column, $id ) {
		global $autoMobile;
		if ( 'thumb' == $column ) {
			$automobile_category_extra_fields = get_option('automobile_category_images');
			$thumbnail_id = $automobile_category_extra_fields[$id]['automobile_category_images'];
			if ( $thumbnail_id ) {
				$image = wp_get_attachment_thumb_url( $thumbnail_id );
			} else {
				$image = $autoMobile->auto_mobile_default_image();
			}

			$image = str_replace( ' ', '%20', $image );
			$columns .= '<img src="' . esc_url( $image ) . '" alt="'. __( 'Thumbnail', 'automobile' ) . '" class="wp-post-image" height="48" width="48" />';

		}

		return $columns;
	}

add_action( 'automobile_product_category_add_form_fields', 'add_automobile_category_fields' );
		/**
		 * Category thumbnail fields.
		 */
		function add_automobile_category_fields() {
			global $autoMobile;
			
		?>
		
		<div class="form-field">
			<label><?php echo _e( 'Thumbnail', 'automobileoptions' ); ?></label>
			<div id="automobile_product_category_thumbnail" style="float: left; margin-right: 10px;"><img src="<?php echo esc_url( $autoMobile->auto_mobile_default_image() ); ?>" width="60px" height="60px" /></div>
			<div style="line-height: 60px;">
				<input type="hidden" id="automobile_product_category_thumbnail_id" name="automobile_product_category_thumbnail_id" />
				<button type="button" class="upload_image_button button"><?php echo _e( 'Upload/Add image', 'automobileoptions' ); ?></button>
				<button type="button" class="remove_image_button button"><?php echo _e( 'Remove image', 'automobileoptions' ); ?></button>
			</div>
			
			<div class="clear"></div>
		</div>
		<?php
	}
	
	add_action( 'automobile_product_category_edit_form_fields', 'edit_automobile_category_fields' , 10 );
	function edit_automobile_category_fields( $term ) {
		global $autoMobile;
		$automobile_category_extra_fields = get_option('automobile_category_images');
		$thumbnail_id = absint($automobile_category_extra_fields[$term->term_id]['automobile_category_images']);
		if ( $thumbnail_id ) {
			$image = wp_get_attachment_thumb_url( $thumbnail_id );
		} else {
			$image = $autoMobile->auto_mobile_default_image();
		}
		?>
		
		<tr class="form-field">
			<th scope="row" valign="top"><label><?php echo _e( 'Thumbnail', 'automobileoptions' ); ?></label></th>
			<td>
				<div id="automobile_product_category_thumbnail" style="float: left; margin-right: 10px;"><img src="<?php echo esc_url( $image ); ?>" width="60px" height="60px" /></div>
				<div style="line-height: 60px;">
					<input type="hidden" id="automobile_product_category_thumbnail_id" name="automobile_product_category_thumbnail_id" value="<?php echo $thumbnail_id; ?>" />
					<button type="button" class="upload_image_button button"><?php echo _e( 'Upload/Add image', 'automobileoptions' ); ?></button>
					<button type="button" class="remove_image_button button"><?php echo _e( 'Remove image', 'automobileoptions' ); ?></button>
				</div>
<script type="text/javascript">

					// Only show the "remove image" button when needed
					if ( '0' === jQuery( '#automobile_product_category_thumbnail_id' ).val() ) {
						jQuery( '.remove_image_button' ).hide();
					}
					
				</script>				
				<div class="clear"></div>
			</td>
		</tr>
		<?php
	}
	
	add_action( 'created_term', 'save_automobile_category_fields', 10, 3 );
	add_action( 'edit_term', 'save_automobile_category_fields', 10, 3 );
	function save_automobile_category_fields( $term_id, $tt_id = '', $taxonomy = '' ) {
		if ( isset( $_POST['automobile_product_category_thumbnail_id'] ) && 'automobile_product_category' === $taxonomy ) {
			$automobile_category_extra_fields = get_option('automobile_category_images');
			$automobile_category_extra_fields[$term_id]['automobile_category_images'] = absint( $_POST['automobile_product_category_thumbnail_id'] );			
			update_option('automobile_category_images', $automobile_category_extra_fields);
		}		
	}
	
	add_filter('deleted_term_taxonomy', 'remove_automobile_category_fields');
	function remove_automobile_category_fields($term_id) {
	  if($_POST['taxonomy'] == 'automobile_product_category'):
		$automobile_category_extra_fields = get_option('automobile_category_images');
		unset($automobile_category_extra_fields[$term_id]);
		update_option('automobile_category_images', $automobile_category_extra_fields);
	  endif;
	}