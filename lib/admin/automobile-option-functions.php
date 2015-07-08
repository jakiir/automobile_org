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
$options = get_option('automobile_options');
function automobile_get_rgb_color($color){

        if ( $color[0] == '#' ) {
                $color = substr( $color, 1 );
        }
        if ( strlen( $color ) == 6 ) {
                list( $r, $g, $b ) = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
        } elseif ( strlen( $color ) == 3 ) {
                list( $r, $g, $b ) = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
        } else {
                return false;
        }

        $r = hexdec( $r );
        $g = hexdec( $g );
        $b = hexdec( $b );


        $rgb =$r.','.$g.','.$b;
        return $rgb;
}

/**
 * A safe way of adding JavaScripts to a WordPress generated page.
 */

if (!is_admin()){
    add_action('wp_footer', 'automobile_js');
}
if (!function_exists('automobile_js')) {
    function automobile_js() {
           wp_enqueue_script( 'automobile_theme_options', plugins_url('assets/js/custom_automobile.js',dirname(__FILE__)) );
           wp_localize_script(
            'automobile_theme_options',
            'adminUrl',
             array( 'ajaxurl' => admin_url('admin-ajax.php') )
          );

    }
  }

/**
 * Enqueues styles for front-end.
 *
 */
if (!function_exists('automobile_public_css')) {
    function automobile_public_css() {
    wp_enqueue_style( 'font-awesome', plugins_url('admin/css/font-awesome/css/font-awesome.min.css', dirname(__FILE__)) );
    }
}
add_action( 'wp_enqueue_scripts', 'automobile_public_css' );


function automobile_custom_styles(){
    $options = get_option('automobile_options');
    //$automobile_text_color = $options['automobile_text_color'];
    $automobile_background_color = $options['automobile_background_color'];
    $automobile_hover_background_color = $options['automobile_hover_background_color'];
    $automobile_links_hover_color = $options['automobile_links_hover_color'];
    //$automobile_fontsize = $options['automobile_fontsize'];
    $automobile_links_color = $options['automobile_links_color'];
    //$automobile_line_height = $options['automobile_line_height'];
    //$automobile_padding_top_bottom = $options['automobile_padding_top_bottom'];
    //$automobile_padding_left_right = $options['automobile_padding_left_right'];

    $custom_css = "
                div.bhoechie-tab-container{
                border:1px solid #ddd;}
                div.bhoechie-tab-menu div.list-group>a .glyphicon,div.bhoechie-tab-menu div.list-group>a .fa,div.bhoechie-tab-menu div.list-group>a {color: $automobile_links_color;background-color: $automobile_background_color;}
                div.bhoechie-tab-menu div.list-group>a.active,
                div.bhoechie-tab-menu div.list-group>a.active .glyphicon,
                div.bhoechie-tab-menu div.list-group>a.active .fa{
                background-color: $automobile_hover_background_color;
                background-image: $automobile_hover_background_color;
                color: $automobile_links_hover_color;
                }
                ";


    wp_add_inline_style( 'custom-style', $custom_css );
}
add_action( 'wp_enqueue_scripts', 'automobile_custom_styles' );

add_action('admin_enqueue_scripts', 'admin_automobile_style');

function admin_automobile_style() {
    //$options = get_option('automobile_options');
   // $automobile_text_color = $options['automobile_text_color'];
   // $automobile_background_color = $options['automobile_background_color'];
    //$automobile_hover_background_color = $options['automobile_hover_background_color'];
    //$automobile_links_hover_color = $options['automobile_links_hover_color'];
    //$automobile_fontsize = $options['automobile_fontsize'];
    //$automobile_links_color = $options['automobile_links_color'];
    //$automobile_line_height = $options['automobile_line_height'];
    //$automobile_padding_top_bottom = $options['automobile_padding_top_bottom'];
    //$automobile_padding_left_right = $options['automobile_padding_left_right'];
    ?>
  <style>
    #automobile-admin .automobile ul li a{
    color:<?php //echo $automobile_links_color; ?> !important;
    background: <?php //echo $automobile_background_color; ?> !important;
    padding-top:<?php //echo $automobile_padding_top_bottom; ?> !important;
    padding-bottom:<?php //echo $automobile_padding_top_bottom; ?> !important;
    padding-right:<?php //echo $automobile_padding_left_right; ?> !important;
     }
     #automobile-admin .automobile ul li a:hover,#automobile-admin .automobile ul li.active a{
         color:<?php //echo $automobile_links_hover_color; ?> !important;
        background: <?php //echo $automobile_hover_background_color; ?>
     }
     </style>
<?php
}

/**
 * Set font styles
 */
function automobile_set_font_style($font_style){
    $stack = '';

    switch ( $font_style ) {

        case "normal":
            $stack .= "";
        break;
        case "italic":
            $stack .= "    font-style: italic;";
        break;
        case 'bold':
            $stack .= "    font-weight: bold;";
        break;
        case 'bold-italic':
            $stack .= "    font-style: italic;\n    font-weight: bold;";
        break;
    }
    return $stack;
}

//make
function add_automobile_make(){
    $make_val = $_POST['make_val'];
    //$success = false;
    if($make_val !=''){
        $make_info = array(
            'make_1'    =>   $make_val
        );
        $make_info2 = serialize($make_info);
        $auto_mobile_make = '_auto_mobile_make';
        if ( get_option( $auto_mobile_make ) !== false ) {

           $get_auto_mobile_make = get_option( $auto_mobile_make );
            $get_auto_mobile_make_uns = unserialize($get_auto_mobile_make);

            $lastKey = substr(end(array_keys($get_auto_mobile_make_uns)), -1);
            $incrLast = intval($lastKey) + 1;
            $item_info2 = array(
                'make_'.$incrLast => $make_val
            );
            $itemInfo_result = array_merge($get_auto_mobile_make_uns, $item_info2 );
            $item_inform2 = serialize($itemInfo_result);
           update_option( $auto_mobile_make, $item_inform2 );

        } else {
            $incrLast = 1;
            add_option( $auto_mobile_make, $make_info2, '', 'yes' );
        }


        $success = true;
        $value = $make_val;
        $keys = 'make_'.$incrLast;
    } else {
        $success = false;
        $value = 'Required field!';
        $keys = '';
    }
    $results = array(
        'success'   => $success,
        'value'     => $value,
        'key'     => $keys
    );
    echo json_encode($results);
    die();
}
add_action( 'wp_ajax_nopriv_add_automobile_make','add_automobile_make' );
add_action( 'wp_ajax_add_automobile_make','add_automobile_make' );

function del_automobile_make(){
    $data_keys = $_POST['data_keys'];
    if($data_keys):
        $auto_mobile_make = '_auto_mobile_make';
        $get_mobile_make = get_option( $auto_mobile_make );
        $get_mobile_make_uns = unserialize($get_mobile_make);
        unset($get_mobile_make_uns[$data_keys]);
        $item_inform2 = serialize($get_mobile_make_uns);
        update_option( $auto_mobile_make, $item_inform2 );
    endif;
    die();
}
add_action( 'wp_ajax_nopriv_del_automobile_make','del_automobile_make' );
add_action( 'wp_ajax_del_automobile_make','del_automobile_make' );

function edit_automobile_make(){
    $data_keys = $_POST['data_keys'];
    $make_value = $_POST['make_value'];
    if($data_keys):
        $auto_mobile_make = '_auto_mobile_make';
        $get_mobile_make = get_option( $auto_mobile_make );
        $get_mobile_make_uns = unserialize($get_mobile_make);
        $get_mobile_make_uns[$data_keys] = $make_value;
        $item_inform2 = serialize($get_mobile_make_uns);
        update_option( $auto_mobile_make, $item_inform2 );
    endif;
    die();
}
add_action( 'wp_ajax_nopriv_edit_automobile_make','edit_automobile_make' );
add_action( 'wp_ajax_edit_automobile_make','edit_automobile_make' );

// Model

function add_automobile_model(){
    $model_val = $_POST['model_val'];
    //$success = false;
    if($model_val !=''){
        $model_info = array(
            'model_1'    =>   $model_val
        );
        $model_info2 = serialize($model_info);
        $auto_mobile_model = '_auto_mobile_model';
        if ( get_option( $auto_mobile_model ) !== false ) {

           $get_auto_mobile_model = get_option( $auto_mobile_model );
            $get_auto_mobile_model_uns = unserialize($get_auto_mobile_model);

            $lastKey = substr(end(array_keys($get_auto_mobile_model_uns)), -1);
            $incrLast = intval($lastKey) + 1;
            $item_info2 = array(
                'model_'.$incrLast => $model_val
            );
            $itemInfo_result = array_merge($get_auto_mobile_model_uns, $item_info2 );
            $item_inform2 = serialize($itemInfo_result);
           update_option( $auto_mobile_model, $item_inform2 );

        } else {
            $incrLast = 1;
            add_option( $auto_mobile_model, $model_info2, '', 'yes' );
        }


        $success = true;
        $value = $model_val;
        $keys = 'model_'.$incrLast;
    } else {
        $success = false;
        $value = 'Required field!';
        $keys = '';
    }
    $results = array(
        'success'   => $success,
        'value'     => $value,
        'key'     => $keys
    );
    echo json_encode($results);
    die();
}
add_action( 'wp_ajax_nopriv_add_automobile_model','add_automobile_model' );
add_action( 'wp_ajax_add_automobile_model','add_automobile_model' );

function del_automobile_model(){
    $data_keys = $_POST['data_keys'];
    if($data_keys):
        $auto_mobile_model = '_auto_mobile_model';
        $get_mobile_model = get_option( $auto_mobile_model );
        $get_mobile_model_uns = unserialize($get_mobile_model);
        unset($get_mobile_model_uns[$data_keys]);
        $item_inform2 = serialize($get_mobile_model_uns);
        update_option( $auto_mobile_model, $item_inform2 );
    endif;
    die();
}
add_action( 'wp_ajax_nopriv_del_automobile_model','del_automobile_model' );
add_action( 'wp_ajax_del_automobile_model','del_automobile_model' );

function edit_automobile_model(){
    $data_keys = $_POST['data_keys'];
    $model_value = $_POST['model_value'];
    if($data_keys):
        $auto_mobile_model = '_auto_mobile_model';
        $get_mobile_model = get_option( $auto_mobile_model );
        $get_mobile_model_uns = unserialize($get_mobile_model);
        $get_mobile_model_uns[$data_keys] = $model_value;
        $item_inform2 = serialize($get_mobile_model_uns);
        update_option( $auto_mobile_model, $item_inform2 );
    endif;
    die();
}
add_action( 'wp_ajax_nopriv_edit_automobile_model','edit_automobile_model' );
add_action( 'wp_ajax_edit_automobile_model','edit_automobile_model' );

function add_automobile_year(){
    $year_val = $_POST['year_val'];
    //$success = false;
    if($year_val !=''){
        $year_info = array(
            'year_1'    =>   $year_val
        );
        $year_info2 = serialize($year_info);
        $auto_mobile_year = '_auto_mobile_year';
        if ( get_option( $auto_mobile_year ) !== false ) {

           $get_auto_mobile_year = get_option( $auto_mobile_year );
            $get_auto_mobile_year_uns = unserialize($get_auto_mobile_year);

            $lastKey = substr(end(array_keys($get_auto_mobile_year_uns)), -1);
            $incrLast = intval($lastKey) + 1;
            $item_info2 = array(
                'year_'.$incrLast => $year_val
            );
            $itemInfo_result = array_merge($get_auto_mobile_year_uns, $item_info2 );
            $item_inform2 = serialize($itemInfo_result);
           update_option( $auto_mobile_year, $item_inform2 );

        } else {
            $incrLast = 1;
            add_option( $auto_mobile_year, $year_info2, '', 'yes' );
        }


        $success = true;
        $value = $year_val;
        $keys = 'year_'.$incrLast;
    } else {
        $success = false;
        $value = 'Required field!';
        $keys = '';
    }
    $results = array(
        'success'   => $success,
        'value'     => $value,
        'key'     => $keys
    );
    echo json_encode($results);
    die();
}
add_action( 'wp_ajax_nopriv_add_automobile_year','add_automobile_year' );
add_action( 'wp_ajax_add_automobile_year','add_automobile_year' );

function del_automobile_year(){
    $data_keys = $_POST['data_keys'];
    if($data_keys):
        $auto_mobile_year = '_auto_mobile_year';
        $get_mobile_year = get_option( $auto_mobile_year );
        $get_mobile_year_uns = unserialize($get_mobile_year);
        unset($get_mobile_year_uns[$data_keys]);
        $item_inform2 = serialize($get_mobile_year_uns);
        update_option( $auto_mobile_year, $item_inform2 );
    endif;
    die();
}
add_action( 'wp_ajax_nopriv_del_automobile_year','del_automobile_year' );
add_action( 'wp_ajax_del_automobile_year','del_automobile_year' );

function edit_automobile_year(){
    $data_keys = $_POST['data_keys'];
    $year_value = $_POST['year_value'];
    if($data_keys):
        $auto_mobile_year = '_auto_mobile_year';
        $get_mobile_year = get_option( $auto_mobile_year );
        $get_mobile_year_uns = unserialize($get_mobile_year);
        $get_mobile_year_uns[$data_keys] = $year_value;
        $item_inform2 = serialize($get_mobile_year_uns);
        update_option( $auto_mobile_year, $item_inform2 );
    endif;
    die();
}
add_action( 'wp_ajax_nopriv_edit_automobile_year','edit_automobile_year' );
add_action( 'wp_ajax_edit_automobile_year','edit_automobile_year' );

function add_order_status(){
    $order_id = $_POST['order_id'];
    $order_status = $_POST['order_status'];
	$results = array();
    if($order_id):
		$orderStatus = array();
		if($order_status == 'processing'):
			$orderStatus = array(
				'name' => 'on-hold',
				'title' => 'On Hold'
			);
		endif;
		if($order_status == 'complete'):
			$orderStatus = array(
				'name' => 'on-complete',
				'title' => 'On Complete'
			);
		endif;
		
		$orderStatuSer = serialize($orderStatus);
        update_post_meta($order_id, 'order_status', $orderStatuSer);
		
		$results = array(
			'success' => true
		);
	else :
		$results = array(
			'success' => false
		);
    endif;
		
	echo json_encode($results);
    die();
}
add_action( 'wp_ajax_nopriv_add_order_status','add_order_status' );
add_action( 'wp_ajax_add_order_status','add_order_status' );

add_role(
    'atm_customer',
    __( 'Customer' ),
    array(
        'read'         => true,
        'edit_posts'   => false,
        'delete_posts' => false
    )
);