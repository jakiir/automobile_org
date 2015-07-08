<?php
add_action('save_post', 'automobile_save_meta_box', 10, 2);
function automobile_save_meta_box($post_id)
{
   if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
       return;

   if('page' == $_POST['post_type'])
   {
       if(!current_user_can('edit_page', $post_id))
           return;
   }
   else
       if(!current_user_can('edit_post', $post_id))
           return;

   if(isset($_POST['automobile_plugin_noncename']) && wp_verify_nonce($_POST['automobile_plugin_noncename'], plugins_url(__FILE__)) && check_admin_referer(plugins_url(__FILE__), 'automobile_plugin_noncename'))
   {

	
	
global $autoMobile;	
$get_automobile_post_id = $autoMobile->get_automobile_post_id($_POST[ 'txt_automobile_sku' ]);
$txt_automobile_sku_now = get_post_meta( $post_id, 'txt_automobile_sku', true );
if ( in_array("yes", $get_automobile_post_id ) && $_POST[ 'txt_automobile_sku' ] != $txt_automobile_sku_now ) {
	@session_start();
	$_SESSION['skuMess'] = 'Part# is unique, please write another';	
    //return;
} else {
	
    if( isset( $_POST[ 'txt_automobile_sku' ] ) ) {
		update_post_meta($post_id, 'txt_automobile_sku', $_POST['txt_automobile_sku']);
	} else {
		delete_post_meta( $post_id, 'txt_automobile_sku' );
	}
	@session_start();
	$_SESSION['skuMess'] = '';
}

       

            if( isset( $_POST[ 'txt_automobile_regular_price' ] ) ) {
                      update_post_meta($post_id, 'txt_automobile_regular_price', $_POST['txt_automobile_regular_price']);
                    } else {
                        delete_post_meta( $post_id, 'txt_automobile_regular_price' );
                    }

            if( isset( $_POST[ 'txt_automobile_price' ] ) ) {
                      update_post_meta($post_id, 'txt_automobile_price', $_POST['txt_automobile_price']);
                    } else { delete_post_meta( $post_id, 'txt_automobile_price' ); }


            if( isset( $_POST[ 'txt_automobile_qty' ] ) ) {
                      update_post_meta($post_id, 'txt_automobile_qty', $_POST['txt_automobile_qty']);
                    } else { delete_post_meta( $post_id, 'txt_automobile_qty' );}

              if( isset( $_POST[ 'automobile-product-status' ] ) ) {
                      update_post_meta($post_id, 'automobile-product-status', $_POST['automobile-product-status']);
                    } else {
						delete_post_meta( $post_id, 'automobile-product-status' ); 
						}
					
			if( isset( $_POST[ 'txt_automobile_color' ] ) ){
				$txt_automobile_color = $_POST[ 'txt_automobile_color' ];
					update_post_meta($post_id, 'txt_automobile_color', $txt_automobile_color);
				} else { 
					delete_post_meta( $post_id, 'txt_automobile_color' );  
				}
			if( isset( $_POST[ 'txt_automobile_mpn' ] ) )
			{
				$combined = $_POST['txt_automobile_mpn'];
				//$automobile_mpn = serialize($combined);
				//$pics=implode('|',$combined);
				update_post_meta($post_id, 'txt_automobile_mpn', $combined);
			}
			else
			{
				delete_post_meta( $post_id, 'txt_automobile_mpn' );
			}


	if( isset( $_POST[ 'txt_automobile_make' ] ) )
	{ 
		$txt_automobile_make = $_POST[ 'txt_automobile_make' ]; } else { $txt_automobile_make = ''; 
		
	}
	if( isset( $_POST[ 'txt_automobile_model' ] ) )
	{ 
		$txt_automobile_model = $_POST['txt_automobile_model'];} else { $txt_automobile_model = '';
	}

	if( isset( $_POST[ 'txt_automobile_year' ] ) )
	{ $txt_automobile_year = $_POST[ 'txt_automobile_year' ]; } else { $txt_automobile_year = ''; }

	

	if( isset( $_POST[ 'txt_automobile_position' ] ) )
	{ $txt_automobile_position = $_POST[ 'txt_automobile_position' ]; } else { $txt_automobile_position = ''; }

	if( isset( $_POST[ 'txt_automobile_weight' ] ) )
	{ $txt_automobile_weight = $_POST[ 'txt_automobile_weight' ]; } else { $txt_automobile_weight = ''; }

	if( isset( $_POST[ 'txt_automobile_comments' ] ) )
	{ $txt_automobile_comments = $_POST[ 'txt_automobile_comments' ]; } else { $txt_automobile_comments = ''; }

	if( isset( $_POST[ 'automobile_inquiry' ] ) )
	{ $automobile_inquiry = $_POST[ 'automobile_inquiry' ]; } else { $automobile_inquiry = ''; }

        $advanced_automobile_array = array(
            'txt_automobile_make'   => $txt_automobile_make,
            'txt_automobile_model'  => $txt_automobile_model,
            'txt_automobile_year'   => $txt_automobile_year,            
            'txt_automobile_position' => $txt_automobile_position,
            'txt_automobile_weight' => $txt_automobile_weight,
			'txt_automobile_comments' => $txt_automobile_comments,
			'automobile_inquiry' => $automobile_inquiry
            );
        $advanced_automobile = serialize($advanced_automobile_array);
        update_post_meta($post_id, 'advanced_automobile', $advanced_automobile);
		
		update_post_meta($post_id, 'advanced_automobile_make', $txt_automobile_make);
		update_post_meta($post_id, 'advanced_automobile_model', $txt_automobile_model);
		update_post_meta($post_id, 'advanced_automobile_year', $txt_automobile_year);
		


            


                  if( isset( $_POST[ 'monday-checkbox' ] ) ) {
            update_post_meta( $post_id, 'monday-checkbox', 'yes' );
        } else {
            update_post_meta( $post_id, 'monday-checkbox', 'no' );
        }
   }
   return;
}


add_action( 'init', 'automobile_product' );
function automobile_product() {
    register_post_type( 'tlp_automobile',
        array(
            'labels' => array(
                'name' => 'Automobiles',
                'singular_name' => 'Automobile',
                'add_new' => 'Add New',
                'add_new_item' => 'Add New Automobile',
                'edit' => 'Edit',
                'edit_item' => 'Edit Automobile',
                'new_item' => 'New Automobile',
                'view' => 'View',
                'view_item' => 'View Automobile',
                'search_items' => 'Search Automobiles',
                'not_found' => 'No Automobiles found',
                'not_found_in_trash' => 'No Automobiles found in Trash',
                'parent' => 'Parent Automobile'
            ),

            'public' => true,
            'menu_position' => 15,
            'supports' => array( 'title', 'editor', 'comments', 'thumbnail', 'custom-fields' ),
            'taxonomies' => array( '' ),
            'menu_icon' => plugins_url( '../assets/images/image.png', __FILE__ ),
            'has_archive' => true
        )
    );
	
	atm_register_order_type(
			'automobile_order',
			apply_filters( 'automobile_register_post_type_automobile_order',
				array(
					'labels'              => array(
							'name'               => __( 'Orders', 'automobile' ),
							'singular_name'      => __( 'Order', 'automobile' ),
							'add_new'            => __( 'Add Order', 'automobile' ),
							'add_new_item'       => __( 'Add New Order', 'automobile' ),
							'edit'               => __( 'Edit', 'automobile' ),
							'edit_item'          => __( 'Edit Order', 'automobile' ),
							'new_item'           => __( 'New Order', 'automobile' ),
							'view'               => __( 'View Order', 'automobile' ),
							'view_item'          => __( 'View Order', 'automobile' ),
							'search_items'       => __( 'Search Orders', 'automobile' ),
							'not_found'          => __( 'No Orders found', 'automobile' ),
							'not_found_in_trash' => __( 'No Orders found in trash', 'automobile' ),
							'parent'             => __( 'Parent Orders', 'automobile' ),
							'menu_name'          => _x( 'Orders', 'Admin menu name', 'automobile' )
						),
					'description'         => __( 'This is where store orders are stored.', 'automobile' ),
					'public'              => false,
					'show_ui'             => true,	
					'capability_type'     => 'post',
					'map_meta_cap'        => true,
					'publicly_queryable'  => false,
					'exclude_from_search' => true,
					'show_in_menu'        => current_user_can( 'edit_theme_options' ) ? 'automobile_options' : true,
					'hierarchical'        => false,
					'show_in_nav_menus'   => false,
					'rewrite'             => false,
					'query_var'           => false,
					'supports'            => array( 'title', 'comments', 'custom-fields' ),
					'has_archive'         => false,
				)
			)
		);
}

add_filter( 'manage_automobile_order_posts_columns', 'automobile_order_columns'  );
add_action( 'manage_automobile_order_posts_custom_column', 'render_automobile_order_columns', 2 );	

add_action( 'admin_menu', 'automobile_submenu', 2 );
function automobile_submenu() {
    add_submenu_page(
        'edit.php?post_type=tlp_automobile',
        'Attributes', /*page title*/
        'Attributes', /*menu title*/
        'manage_options', /*roles and capabiliyt needed*/
        'attributes',
        'automobile_attributes' /*replace with your own function*/
    );

}

function automobile_attributes(){
    ?>
    <div id="automobile-admin">
        <div class="header">
            <div class="main">
                <div class="left">
                    <h2><?php echo _e('Attributes', 'automobileoptions'); ?></h2>
                </div>
            </div>
        </div><!-- /header -->
        <div class="options-wrap">
            <div class="automobile">
                <ul>
                    <li class="general first"><a href="#automobile_make"><i class="icon-cogs"></i><?php echo _e('Make', 'automobileoptions'); ?></a></li>
                    <li class="shortcode"><a href="#automobile_model"><i class="icon-trello"></i><?php echo _e('Model', 'automobileoptions'); ?></a></li>
					<li class="shortcode"><a href="#automobile_year"><i class="icon-trello"></i><?php echo _e('Year', 'automobileoptions'); ?></a></li>

                </ul>
            </div><!-- /subheader -->


                <div class="options-form">

                    <div class="automobile_content">
                        <div id="automobile_make" class="automobile_block">


                            <h2><?php _e('Automobile make', 'automobileoptions'); ?></h2>
                            <div class="fields_wrap">
                                <span id="automobile_make_add">
                                <label for="automobile_make_id">Add automobile make</label>
                                <input type="text" name="automobile_make" class="" id="automobile_make_id"/>
                                <input type="submit" name="automobile_make_submit" id="automobile_make_submit" class="button-primary" value="Add New">
                                </span>
                                <span id="automobile_make_edit" style="display:none">
                                <label for="edit_automobile_make">Edit automobile make</label>
                                <input type="text" name="edit_automobile_make" class="" id="edit_automobile_make"/>
                                <input type="submit" name="automobile_make_edit_submit" id="automobile_make_edit_submit" class="button-primary" value="Edit">
                                </span>
                                <span class="reloadIcon" style="display:none"></span>
                                <span class="message"></span>
                                <ul id="make_display_area">
                                    <?php
                                    $auto_mobile_make = '_auto_mobile_make';
                                    $get_auto_mobile_make = get_option( $auto_mobile_make );
                                    $get_auto_mobile_make_uns = @unserialize($get_auto_mobile_make);
                                    if($get_auto_mobile_make_uns) {
                                        foreach ($get_auto_mobile_make_uns as $key=>$get_auto_mobile_make_unss): ?>
                                            <li class='<?php echo $key; ?>'><?php echo $get_auto_mobile_make_unss; ?> <a href='javascript:void(0)' class='make_del delIcon' onclick='make_del(this)' data-keys='<?php echo $key; ?>'><i class='fa fa-times'></i></a><a href='javascript:void(0)' class='make_edit editIcon' onclick='make_edit(this)' data-keys='<?php echo $key; ?>' data-make_value='<?php echo $get_auto_mobile_make_unss; ?>'><i class='fa fa-pencil-square-o'></i></a></li>
                                    <?php endforeach; } ?>

                                </ul>
                            </div> <!-- /fields-wrap -->


                        </div><!-- /fields_wrap -->


                        <div id="automobile_model" class="automobile_block">
                            <h2><?php _e('Automobile model', 'automobileoptions'); ?></h2>                            
                            <div class="fields_wrap">
                                <span id="automobile_model_add">
                                <label for="automobile_model_id">Add automobile model</label>
                                <input type="text" name="automobile_model" class="" id="automobile_model_id"/>
                                <input type="submit" name="automobile_model_submit" id="automobile_model_submit" class="button-primary" value="Add New"/>
                                </span>
                                <span id="automobile_model_edit" style="display:none">
                                <label for="edit_automobile_model">Edit automobile model</label>
                                <input type="text" name="edit_automobile_model" class="" id="edit_automobile_model"/>
                                <input type="submit" name="automobile_model_edit_submit" id="automobile_model_edit_submit" class="button-primary" value="Edit">
                                </span>
                                <span class="reloadIcon" style="display:none"></span>
                                <span class="message"></span>
                                <ul id="model_display_area">
                                    <?php
                                    $auto_mobile_model = '_auto_mobile_model';
                                    $get_auto_mobile_model = get_option( $auto_mobile_model );
                                    $get_auto_mobile_model_uns = @unserialize($get_auto_mobile_model);
                                    if($get_auto_mobile_model_uns) {
                                        foreach ($get_auto_mobile_model_uns as $key=>$get_auto_mobile_model_unss):
                                            echo "<li class='".$key."'>$get_auto_mobile_model_unss <a href='javascript:void(0)' class='model_del delIcon' onclick='model_del(this)' data-keys='".$key."'><i class='fa fa-times'></i></a><a href='javascript:void(0)' class='model_edit editIcon' onclick='model_edit(this)' data-keys='".$key."' data-model_value='".$get_auto_mobile_model_unss."'><i class='fa fa-pencil-square-o'></i></a></li>";
                                        endforeach;
                                    }
                                    ?>

                                </ul>
                            </div> <!-- /fields-wrap -->

                        </div><!-- /tab_block -->
						
						<div id="automobile_year" class="automobile_block">
                            <h2><?php _e('Automobile year', 'automobileoptions'); ?></h2>                            
                            <div class="fields_wrap">
                                <span id="automobile_year_add">
                                <label for="automobile_year_id">Add automobile year</label>
                                <input type="text" maxlength="4" onkeyup="check_number(this)" onkeypress="check_number(this)" name="automobile_year" class="" id="automobile_year_id"/>
                                <input type="submit" name="automobile_year_submit" id="automobile_year_submit" class="button-primary" value="Add New">
                                </span>
                                <span id="automobile_year_edit" style="display:none">
                                <label for="edit_automobile_year">Edit automobile year</label>
                                <input type="text" maxlength="4" onkeyup="check_number(this)" onkeypress="check_number(this)" name="edit_automobile_year" class="" id="edit_automobile_year"/>
                                <input type="submit" name="automobile_year_edit_submit" id="automobile_year_edit_submit" class="button-primary" value="Edit">
                                </span>
                                <span class="reloadIcon" style="display:none"></span>
                                <span class="message"></span>
                                <ul id="year_display_area">
                                    <?php
                                    $auto_mobile_year = '_auto_mobile_year';
                                    $get_auto_mobile_year = get_option( $auto_mobile_year );
                                    $get_auto_mobile_year_uns = @unserialize($get_auto_mobile_year);
                                    if($get_auto_mobile_year_uns) {
                                        foreach ($get_auto_mobile_year_uns as $key=>$get_auto_mobile_year_unss):
                                            echo "<li class='".$key."'>$get_auto_mobile_year_unss <a href='javascript:void(0)' class='year_del delIcon' onclick='year_del(this)' data-keys='".$key."'><i class='fa fa-times'></i></a><a href='javascript:void(0)' class='year_edit editIcon' onclick='year_edit(this)' data-keys='".$key."' data-year_value='".$get_auto_mobile_year_unss."'><i class='fa fa-pencil-square-o'></i></a></li>";
                                        endforeach;
                                    }
                                    ?>

                                </ul>
                            </div> <!-- /fields-wrap -->

                        </div><!-- /tab_block -->
						
                    </div> <!-- /option -->

                </div>
                <div class="options-footer">

                </div>
        </div> <!-- /automobile-admin -->
    </div><!-- /tab_block -->
<?php
}


add_filter( 'manage_edit-tlp_automobile_columns', 'automobile_columns' );

 function tlp_automobile_meta_box()
        {
            add_meta_box(
            'tlp_automobile_discount',
            __('Automobile Discount ', 'automobile_plugin'),
            'automobile_discount_meta_box',
            'tlp_automobile',
            'normal',
            'high'
        );
    }

 add_action('add_meta_boxes', 'tlp_automobile_meta_box', 10, 2);
function automobile_discount_meta_box($post){
   wp_nonce_field(plugins_url(__FILE__), 'automobile_plugin_noncename');
   $prfx_stored_meta = get_post_meta( $post->ID );
?>
<div class="automobile-meta">
 <ul class='tabs tabs-menu'>
    <li><a href='#general'>General</a></li>
    <!--<li><a href='#mpn'>MPN</a></li>-->
    <li><a href='#applicationsTab'>Applications TAB</a></li>
    <!--<li><a href='#options'>Options</a></li>-->
  </ul>
  <div class="automobile-meta-boxs">
  <div id='general'>
    <p>
		<?php @session_start(); if($_SESSION['skuMess'] != ''): echo '<span style="color:red">'.$_SESSION['skuMess'].'</span>'; $_SESSION['skuMess'] = ''; endif; ?>
       <label class="left-lable"  for="txt_automobile_sku"><?php _e('Part#', 'automobile_plugin'); ?>: </label>
       <input type="text" name="txt_automobile_sku" id="txt_automobile_sku" size="50" value="<?php echo get_post_meta($post->ID, 'txt_automobile_sku', true); ?>" />
       <!--<span class="tip"><a rel="tooltip" title="A paragraph typically consists of a unifying main point, thought, or idea accompanied by <b>supporting details</b>">paragraph</a></span>-->
   </p>
   <div class="border-sep"></div>
   <p>
       <label class="left-lable"  for="txt_automobile_regular_price"><?php _e('Price ($)', 'automobile_plugin'); ?>: </label>
       <input type="number" name="txt_automobile_regular_price" id="txt_automobile_regular_price" size="50" value="<?php echo get_post_meta($post->ID, 'txt_automobile_regular_price', true); ?>" />
       <em></em>
   </p>
  <p>
       <label class="left-lable"  for="txt_automobile_price"><?php _e('Special Price ($)', 'automobile_plugin'); ?>: </label>
       <input type="number" name="txt_automobile_price" id="txt_automobile_price" size="50" value="<?php echo get_post_meta($post->ID, 'txt_automobile_price', true); ?>" />
       <em></em>
   </p>
   <div class="border-sep"></div>
   <p>

    <label for="meta-select" class="left-lable"><?php _e( 'Stock Status', 'automobile_plugin' )?>:</label>
    <select name="automobile-product-status" id="meta-select">
        <option value="instock" <?php if ( isset ( $prfx_stored_meta['automobile-product-status'] ) ) selected( $prfx_stored_meta['automobile-product-status'][0], 'instock' ); ?>><?php _e( 'In stock', 'automobile_plugin' )?></option>';
        <option value="Outofstock" <?php if ( isset ( $prfx_stored_meta['automobile-product-status'] ) ) selected( $prfx_stored_meta['automobile-product-status'][0], 'Outofstock' ); ?>><?php _e( 'Out of stock', 'automobile_plugin' )?></option>';
    </select>
</p>
   <p>
       <label class="left-lable"  for="txt_automobile_qty"><?php _e('Qty', 'automobile_plugin'); ?>: </label>
       <input type="number" name="txt_automobile_qty" id="txt_automobile_qty" size="50" value="<?php echo get_post_meta($post->ID, 'txt_automobile_qty', true); ?>" />
       <em></em>
   </p>
   <p>
       <label class="left-lable"  for="txt_automobile_color"><?php _e('Color', 'automobile_plugin'); ?>: </label>
       <input type="text" name="txt_automobile_color" id="txt_automobile_color" size="50" value="<?php echo get_post_meta($post->ID, 'txt_automobile_color', true); ?>" />
       <em></em>
   </p>
   <p>
       <label class="left-lable"  for="txt_automobile_mpn"><?php _e('MPN', 'automobile_plugin'); ?>: </label>
       <input type="text" name="txt_automobile_mpn" id="txt_automobile_mpn" size="50" value="<?php echo get_post_meta($post->ID, 'txt_automobile_mpn', true); ?>" />
       <em></em>
   </p>
  </div>

  <!--<div id='mpn'>
    <div class="automobile_mpn">
        <!--<?php /* if(empty($prfx_stored_meta)): ?>
        <p><label for="txt_automobile_mpn"></label>
        <p><label for="txt_automobile_mpn2"></label>
            <input type="text" name="txt_automobile_mpn" id="txt_automobile_mpn2" size="50" value="<?php echo get_post_meta($post->ID, 'txt_automobile_mpn', true); ?>" />
        </p>
        <p><span class=" add_more button button-primary button-large" style="margin-left:5px; margin-top:5px;">Add More</span></p>
        <?php else:
            $get_automobile_mpn = get_post_meta($post->ID, 'txt_automobile_mpn', true);
            $get_automobile_mpn_uns = @unserialize($get_automobile_mpn);
            if($get_automobile_mpn_uns):
                $incr = 0;
            foreach($get_automobile_mpn_uns as $get_automobile_mpn_un): ?>
                <p>
                    <label for="txt_automobile_mpn_<?php echo $incr; ?>"></label>
                    <input size="50" id="txt_automobile_mpn_<?php echo $incr; ?>" name='txt_automobile_mpn[]' type='text' class='in_box'  value="<?php echo $get_automobile_mpn_un; ?>" />
                    <span class="rem"><a href='javascript:void(0);' ><span class="dashicons dashicons-dismiss"></span></a></span>
                </p>
            <?php $incr++; endforeach; endif; ?>
            <p> <span class="add_more button button-primary button-large"><?php _e('Add More', 'automobile_plugin'); ?></span> </p>
        <?php endif; */?>-->
		<!--<p>
       <label class="left-lable"  for="txt_automobile_mpn"><?php //_e('MPN', 'automobile_plugin'); ?>: </label>
       <input type="text" name="txt_automobile_mpn" id="txt_automobile_mpn" size="50" value="<?php //echo get_post_meta($post->ID, 'txt_automobile_mpn', true); ?>" />
       <em></em>
   </p>
    </div>

  </div>-->
<div id='applicationsTab'>
<?php
global $post;
$get_advanced_automobile_array = get_post_meta($post->ID, 'advanced_automobile', true);
if(!$get_advanced_automobile_array): add_post_meta( $post->ID, 'advanced_automobile', '' ); endif;
$get_advanced_automobile = @unserialize($get_advanced_automobile_array);
?>
	<p>
	<label for="txt_automobile_year" class="left-lable"><?php _e( 'Year', 'automobile_plugin' )?></label>
        <select name="txt_automobile_year" id="txt_automobile_year">
            <option value="">None</option>
            <?php
            $auto_mobile_year = '_auto_mobile_year';
            $get_auto_mobile_year = get_option( $auto_mobile_year );
            $get_auto_mobile_year_uns = @unserialize($get_auto_mobile_year);
            if($get_auto_mobile_year_uns) {
                foreach ($get_auto_mobile_year_uns as $key=>$get_auto_mobile_year_unss): ?>
                    <option value="<?php echo $key; ?>" <?php if ( isset ( $get_advanced_automobile['txt_automobile_year'] ) ) selected( $get_advanced_automobile['txt_automobile_year'], $key ); ?>><?php _e( $get_auto_mobile_year_unss, 'automobile_plugin' )?></option>';
                <?php  endforeach;
            }
            ?>
        </select>
    </p>
    <!--<p>
    <label class="left-lable"  for="txt_automobile_year"><?php //_e('Year', 'automobile_plugin'); ?>: </label>
    <?php
        //$already_selected_value = 1984;
        //$earliest_year = 1980; ?>
       <select name="txt_automobile_year"  id="txt_automobile_year">
           <option value="">None</option>
        <?php //foreach (range(date('Y', strtotime('+1 year')), $earliest_year) as $x) { ?>
            <option value="<?php //echo $x; ?>" <?php //if ( isset ( $get_advanced_automobile['txt_automobile_year'] ) ) selected( //$get_advanced_automobile['txt_automobile_year'], $x ); ?> ><?php //echo $x; ?></option>
       <?php //} ?>
       </select>
       <em></em>
   </p> -->  
    <p>
        <label for="txt_automobile_make" class="left-lable"><?php _e( 'Make', 'automobile_plugin' )?></label>
        <select name="txt_automobile_make" id="txt_automobile_make">
            <option value="">None</option>
            <?php
            $auto_mobile_make = '_auto_mobile_make';
            $get_auto_mobile_make = get_option( $auto_mobile_make );
            $get_auto_mobile_make_uns = @unserialize($get_auto_mobile_make);
            if($get_auto_mobile_make_uns) {
                foreach ($get_auto_mobile_make_uns as $key=>$get_auto_mobile_make_unss): ?>
                    <option value="<?php echo $key; ?>" <?php if ( isset ( $get_advanced_automobile['txt_automobile_make'] ) ) selected( $get_advanced_automobile['txt_automobile_make'], $key ); ?>><?php _e( $get_auto_mobile_make_unss, 'automobile_plugin' )?></option>';
                <?php  endforeach;
            }
            ?>
        </select>
    </p>
	<p>
        <label for="txt_automobile_model" class="left-lable"><?php _e( 'Model', 'automobile_plugin' )?></label>
        <select name="txt_automobile_model" id="txt_automobile_model">
            <option value="">None</option>
            <?php
            $auto_mobile_model = '_auto_mobile_model';
            $get_auto_mobile_model = get_option( $auto_mobile_model );
            $get_auto_mobile_model_uns = @unserialize($get_auto_mobile_model);
            if($get_auto_mobile_model_uns) {
                foreach ($get_auto_mobile_model_uns as $key=>$get_auto_mobile_model_unss): ?>
                    <option value="<?php echo $key; ?>" <?php if ( isset ( $get_advanced_automobile['txt_automobile_model'] ) ) selected( $get_advanced_automobile['txt_automobile_model'], $key ); ?>><?php _e( $get_auto_mobile_model_unss, 'automobile_plugin' )?></option>';
                <?php  endforeach;
            }
            ?>
        </select>
    </p>
	
   
   <p>
       <label class="left-lable"  for="txt_automobile_position"><?php _e('Position', 'automobile_plugin'); ?>: </label>
       <input type="text" name="txt_automobile_position" id="txt_automobile_position" size="50" value="<?php echo $get_advanced_automobile['txt_automobile_position']; ?>" />
       <em></em>
   </p>
   <p>
       <label class="left-lable"  for="txt_automobile_weight"><?php _e('Weight (oz)', 'automobile_plugin'); ?>: </label>
       <input type="text" name="txt_automobile_weight" size="50" id="txt_automobile_weight" value="<?php echo $get_advanced_automobile['txt_automobile_weight']; ?>" />
       <em></em>
   </p>
   <p>
        <label for="txt_automobile_comments"><?php _e( 'Comments', 'wpshed' ); ?>:</label><br />
        <textarea name="txt_automobile_comments" id="txt_automobile_comments" cols="60" rows="4"><?php echo $get_advanced_automobile['txt_automobile_comments']; ?></textarea>
    </p>
</div>
  <!--<div id="options">
    <p>
        <label class="left-lable"  for="inquiry"><?php //_e('Product Inquiry', 'automobile_plugin'); ?>: </label>
        <input type="checkbox" class="ckb-inquiry" name="automobile_inquiry" id="inquiry" value="yes" <?php //if ( isset ( $get_advanced_automobile['automobile_inquiry'] ) ) checked( $get_advanced_automobile['automobile_inquiry'], 'yes' ); ?> />
        <?php //_e( ' Yes / No', 'automobile_plugin' )?>
    </p>
  </div>-->
   </div>
  </div>
<?php
}
?>