<?php
/**
*    Plugin Name: Auto Mobile
*    Plugin URI: http://jakirhossain.com
*    Description: An eCommerce toolkit that helps you sell any product.
*    Author: Jakir Hossain
*    Version: 1.0
*    Author URI: http://jakirhossain.com
*/
if (realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
    exit('Please don\'t access this file directly.');
}

require_once ( 'lib/init.php' );
//require_once ( 'lib/api.php' );

if (!class_exists( 'AutoMobile' )){
    class AutoMobile extends autoMobileCore {

        public $title       = 'Auto Mobile';
        public $name        = 'auto-mobile';
        public $version     = '1.0';
        public $prefix      = 'atm_';
        public $prefixLong  = 'auto_mobile_';
        public $website     = 'http://jakirhossain.com';

        function __construct(){
            global $wpdb;
            $this->file             = __FILE__;
            $this->pluginSlug       = plugin_basename(__FILE__);
            $this->pluginPath       = dirname( __FILE__ );
            $this->modelsPath       = $this->pluginPath . '/lib/models/';
			$this->statesPath       = $this->pluginPath . '/inc/states/';
            $this->adminPath       = $this->pluginPath . '/lib/admin/';
            $this->controllersPath  = $this->pluginPath . '/lib/controllers/';
            $this->viewsPath        = $this->pluginPath . '/lib/views/';
            $this->helperPath        = $this->pluginPath . '/lib/helpers/';

            $this->pluginUrl        = plugins_url( '' , __FILE__ );
            $this->assetsUrl        = $this->pluginUrl  . '/lib/assets/';
            $this->helperUrl        = $this->pluginUrl  .'/lib/helpers/';
            define('ATM_PATH',dirname( __FILE__ ));
            //define('ATM_PLUGIN_URL',plugins_url( '' , __FILE__ )).'/';
            //define('ATM_ASSECTS_URL', ATM_PLUGIN_URL.'/assets/');
            //define('ATM_HELPER_URL', ATM_PLUGIN_URL.'/lib/helpers/');


          $this->loadModels( $this->modelsPath );
            $this->loadAdmins( $this->adminPath );
            $this->loadHelpers( $this->helperPath );
          //$this->loadModels( $this->modelsPath.'enc/' , true);

          $this->options=array(
            'auto_mobile' =>'atm_auto_mobile',
            'post_types'=>'atm_post_types',
            'taxonomies'=>'atm_taxonomies',
            'settings'  =>'atm_settings',
            'cache'     =>'atm_cache'
            );

          register_activation_hook(__FILE__, array($this, 'atm_activate'));
          register_deactivation_hook(__FILE__, array($this, 'atm_deactivate'));
          //register_uninstall_hook(__FILE__, array($this, 'atm_uninstall'));

          //add_filter('parse_query', array($this, 'atm_query_parser'));
          //add_filter('the_posts', array($this, 'atm_page_filter'));

            // Setup global database table names
            $this->auto_mobile_order          = $wpdb->prefix . 'auto_mobile_order';
            $this->auto_mobile_order_meta     = $wpdb->prefix . 'auto_mobile_order_meta';

          }
        function init(){

            //$this->pluginInit();

            $this->install_db();

        }
		
		

        function auto_mobile_thumbnail($placeholderImage = '') {
            $uploads_dir = wp_upload_dir();
            $upload_url = $uploads_dir['baseurl']."/";
            $upload_dir = $uploads_dir['basedir']."/";
            $thumb_url = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID(), 'medium' ) );
            $check_image_dir = str_replace($upload_url, $upload_dir, $thumb_url);
            if ( has_post_thumbnail() ) {
                if(@file_exists($check_image_dir)){
                    //$automobile_image   = automobile_resize( $thumb_url,400,250, true );
                    $output = '<img class="group list-group-image" src="'.$thumb_url.'" alt="" />';
                } else {
                    $output = '<img src="http://placehold.it/'.$placeholderImage.'" />';
                }
            }
            else {
                $output = '<img src="http://placehold.it/'.$placeholderImage.'" />';
            }
            return $output;
        }
		
		function auto_mobile_default_image() {            
            return $this->assetsUrl.'images/no-preview.png';
        }      
    }
    global $autoMobile;
    $autoMobile = new AutoMobile;
    $autoMobile->init();
}


