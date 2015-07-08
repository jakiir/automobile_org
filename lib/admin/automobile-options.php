<?php
/**
 * Flex automobile plugin by bdwebteam.
 *
 * @package   automobile
 * @author    Mahabub Hasan <m.manik01@gmail.com>
 * @license   GPL-2.0+
 * @link      http://www.bdwebteam.com
 * @copyright 2015 Mahabub Hasan
 */

//add_action( 'admin_init', 'automobile_register_admin_scripts' );
add_action( 'admin_enqueue_scripts', 'automobile_register_admin_scripts' );
function automobile_register_admin_scripts() {
	global $autoMobile;
    wp_enqueue_style( 'automobile-font-awesome', plugins_url('css/font-awesome/css/font-awesome.min.css', __FILE__ ) );
    wp_enqueue_style( 'automobile_css', plugins_url( 'css/automobile-options.css', __FILE__ ) );
    wp_enqueue_style('thickbox');
    wp_enqueue_script('jquery-ui-core');
    wp_enqueue_script('jquery-ui-slider');
    wp_enqueue_script( 'automobile_colorpicker', plugins_url('js/colorpicker.js',__FILE__  ) );
    wp_enqueue_script( 'automobile_select_js', plugins_url('js/jquery.customSelect.min.js',__FILE__  ) );
	//wp_enqueue_script('meta_boxes_product_variation', plugins_url('js/meta-boxes-product-variation.js',__FILE__ ) );
	wp_enqueue_media();
    wp_enqueue_script('automobile_theme_options', plugins_url('js/automobile-options.js',__FILE__ ) );
    wp_localize_script(
        'automobile_theme_options',
        'adminUrl',
        array( 'ajaxurl' => admin_url('admin-ajax.php'), 'default_image' => esc_url( $autoMobile->auto_mobile_default_image() ) )
    );
    wp_enqueue_script('automobile_meta_latest', plugins_url('js/jquery-latest.js',__FILE__ ) );

    // Enqueue Datepicker + jQuery UI CSS
    wp_enqueue_script( 'jquery-ui-datepicker' );
    wp_enqueue_style( 'jquery-ui-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.1/themes/smoothness/jquery-ui.css', true);
	
	

}

global $pagenow;

if( ( 'themes.php' == $pagenow ) && ( isset( $_GET['activated'] ) && ( $_GET['activated'] == 'true' ) ) ) :
    /**
    * Set default options on activation
    */
    function automobile_init_options() {
        delete_option( 'automobile_options' );
        $options = get_option( 'automobile_options' );
        if ( false === $options ) {
            $options = automobile_default_options();
        }
        update_option( 'automobile_options', $options );
    }
    add_action( 'after_setup_theme', 'automobile_init_options', 9 );
endif;

/**
 * Register the automobile Options setting
 */
function automobile_register_settings() {
    register_setting( 'automobile_options', 'automobile_options', 'automobile_validate_options' );
}
add_action( 'admin_init', 'automobile_register_settings' );

/**
 * Register the options page
 */

function automobile_theme_add_page() {
    $automobile_options_page =  add_menu_page( 'Automobile Options', 'Automobile Options', 'edit_theme_options', 'automobile_options', '', '', '19' );
      //add_dashboard_page( $page_title, $menu_title, $capability, $menu_slug, $function);
    add_action( 'admin_print_styles-' . $automobile_options_page, 'automobile_theme_options_scripts' );
}
add_action( 'admin_menu', 'automobile_theme_add_page');
add_action( 'admin_menu', 'automobile_order_add_page');


function automobile_order_add_page() {
 add_submenu_page( 'automobile_options', 'settings', 'Settings', 'edit_theme_options', 'automobile_order', 'automobile_theme_options_page');
 add_submenu_page( 'automobile_options', 'export', 'Export', 'edit_theme_options', 'automobile_export', 'automobile_export_page');
 }
/**
 * Include scripts to the options page only
 */
function automobile_theme_options_scripts(){
    if ( ! did_action( 'wp_enqueue_media' ) ){
        wp_enqueue_media();
    }
    wp_enqueue_script('automobile_upload', plugins_url('/js/upload.js',__FILE__ ) );


}

/**
 * Output the options page
 */
function automobile_export_page() {
	echo '<div class="wrap">';
	echo '<div id="icon-tools" class="icon32">
	</div>';
	echo '<h2>Download Report</h2>';
	//$url = site_url();

	echo '<p>Export the Subscribers</p>';
	echo '<a href="admin.php?page=automobile_export&download_report=1">Download</a>';
	
}

/**
 * Output the options page
 */
function automobile_theme_options_page() {
?>
    <div id="automobile-admin">
            <div class="header">
                <div class="main">
                    <div class="left">
                        <h2><?php echo _e('automobile Options', 'automobileoptions'); ?></h2>
                    </div>

                    </div>
                <!-- <div class="subheader">

                </div> -->

            </div><!-- /header -->

        <div class="options-wrap">

            <div class="automobile">
                <ul>
                    <li class="general first"><a href="#general"><i class="icon-cogs"></i><?php echo _e('General', 'automobileoptions'); ?></a></li>
                    <li class="shortcode"><a href="#shortcode"><i class="icon-trello"></i><?php echo _e('Shortcode', 'automobileoptions'); ?></a></li>
                    <li class="reset"><a href="#reset"><i class="icon-refresh"></i><?php echo _e('Reset', 'wellthemes'); ?></a></li>
                </ul>
            </div><!-- /subheader -->
            <form action="options.php" method="post">
            <div class="options-form">

                    <?php if ( isset( $_GET['settings-updated'] ) ) : ?>
                        <div class="updated fade"><p><?php _e('automobile settings updated successfully', 'automobileoptions'); ?></p></div>
                    <?php endif; ?>



                        <?php settings_fields( 'automobile_options' ); ?>
                        <?php $options = get_option('automobile_options'); ?>

                        <div class="automobile_content">
                            <div id="general" class="automobile_block">


                                <!--<h2><?php //_e('Tean Settings', 'automobileoptions'); ?></h2>-->


                                        <div class="field">
                                            <label for="automobile_options[automobile_order_send_email]"><?php _e('Paypal Email', 'automobileoptions'); ?></label>
                                            <input id="automobile_options[automobile_order_send_email]" name="automobile_options[automobile_order_send_email]" type="text" value="<?php echo esc_attr($options['automobile_order_send_email']); ?>" />

                                        </div>
										
										<div class="field">
                                            <label for="automobile_options[automobile_shipping_charge]"><?php _e('Shipping Charge', 'automobileoptions'); ?></label>
                                            <input id="automobile_options[automobile_shipping_charge]" name="automobile_options[automobile_shipping_charge]" type="text" value="<?php echo esc_attr($options['automobile_shipping_charge']); ?>" onkeyup="check_number(this)" onkeypress="check_number(this)" />

                                        </div>
										
										<div class="field">
                                            <label for="automobile_options[automobile_tax_in]"><?php _e('Tax In %', 'automobileoptions'); ?></label>
                                            <input id="automobile_options[automobile_tax_in]" name="automobile_options[automobile_tax_in]" type="text" value="<?php echo esc_attr($options['automobile_tax_in']); ?>" onkeyup="check_number(this)" onkeypress="check_number(this)" />
                                        </div>
                                    </div><!-- /fields_wrap -->


                            <div id="shortcode" class="automobile_block">
                                <h2><?php _e('Shortcode', 'automobileoptions'); ?></h2>

                                <div class="fields_wrap">

                                    <div class="field infobox">
                                        <p><strong><?php _e('Settings for single posts, pages, images and archives', 'automobileoptions'); ?></strong></p>
                                        <?php _e('You can adjust single posts, pages images and archive settings.', 'automobileoptions'); ?>
                                    </div>

                                    <h3><?php _e('Blog Settings', 'automobileoptions'); ?></h3>

                                    <div class="field">
                                        <label for="automobile_options[automobile_enable_rating]"><?php _e('Enable Rating', 'automobileoptions'); ?></label>
                                        <input id="automobile_options[automobile_enable_rating]" name="automobile_options[automobile_enable_rating]" type="checkbox" value="1" <?php isset($options['automobile_enable_rating']) ? checked( '1', $options['automobile_enable_rating'] ) : checked('0', '1'); ?> />
                                        <span class="description chkdesc"><?php _e( 'Check if you want to display user ratings.', 'automobileoptions' ); ?></span>
                                    </div>



                                </div> <!-- /fields-wrap -->

                            </div><!-- /tab_block -->




                            <div id="reset" class="automobile_block">
                                <h2><?php _e('Reset Theme Settings', 'automobileoptions'); ?></h2>
                                    <div class="fields_wrap">
                                        <div class="field warningbox">
                                            <p><strong><?php _e('Please Note', 'automobileoptions'); ?></strong></p>
                                            <?php _e('You will lose all your theme settings and custom sidebar. The theme will restore default settings.', 'automobileoptions'); ?>
                                        </div>

                                        <div class="field">
                                            <p class="reset-info"><?php _e('If you want to reset the theme settings.', 'automobileoptions');?> </p>
                                            <input type="submit" name="automobile_options[reset]" class="button-primary" value="<?php _e( 'Reset Settings', 'automobileoptions' ); ?>" />
                                        </div>
                                    </div><!-- /fields_wrap -->
                            </div><!-- /tab_block -->

                        </div> <!-- /option -->



            </div>
     <div class="options-footer">
         <input type="submit" name="automobile_options[submit]" class="button-primary" value="<?php _e( 'Save Settings', 'automobileoptions' ); ?>" />
        </div>
        </form>

        </div> <!-- /automobile-admin -->
        </div><!-- /tab_block -->


    <?php
}

/**
 * Return default array of options
 */
function automobile_default_options() {
    $options = array(
        'automobile_order_send_email' => '',
		'automobile_shipping_charge' => '', 
		'automobile_tax_in' => ''
    );
    return $options;
}
/**
 * Sanitize and validate options
 */
function automobile_validate_options( $input='' ) {
    $submit = ( ! empty( $input['submit'] ) ? true : false );
    $reset = ( ! empty( $input['reset'] ) ? true : false );
    if( $submit ) :


        $input['automobile_order_send_email'] = wp_filter_nohtml_kses($input['automobile_order_send_email']);
		$input['automobile_shipping_charge'] = wp_filter_nohtml_kses($input['automobile_shipping_charge']);
		$input['automobile_tax_in'] = wp_filter_nohtml_kses($input['automobile_tax_in']);		
		 

     return $input;

    elseif( $reset ) :
        $input = automobile_default_options();
        return $input;

    endif;
}

if ( ! function_exists( 'automobile_get_option' ) ) :
/**
 * Used to output automobile Options is an elegant way
 * @uses get_option() To retrieve the options array
 */
function automobile_get_option( $option ) {
    //$options = get_option( 'automobile_options', automobile_default_options() );
    //return $options[ $option ];
}
endif;