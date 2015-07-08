<?php
if (!class_exists('atm_activation'))
{
  class atm_activation
  {

    public $atm_shop_name;
    public $atm_shop_title;
    public $atm_shop_page_name;
    public $page_id;

    public $cart_name;
    public $cart_page_title;
    public $cart_page_name;

    public $checkout_name;
    public $checkout_page_title;
    public $checkout_page_name;

    public $atm_account_name;
    public $atm_account_title;
    public $atm_account_page_name;

    function __construct(){

        $this->atm_shop_name      = 'auto-mobile';
        $this->atm_shop_title = 'Auto Mobile';
        $this->atm_shop_page_name  = $this->atm_shop_name;
        $this->page_id    = '0';

        $this->cart_name      = 'shopping-cart';
        $this->cart_page_title = 'Shopping Cart';
        $this->cart_page_name  = $this->cart_name;
        $this->page_id    = '0';

        $this->checkout_name      = 'automobile-checkout';
        $this->checkout_page_title = 'Automobile Checkout';
        $this->checkout_page_name  = $this->checkout_name;
        $this->page_id    = '0';

        $this->atm_account_name      = 'automobile-account';
        $this->atm_account_title = 'Automobile Account';
        $this->atm_account_page_name  = $this->atm_account_name;
        $this->page_id    = '0';
    }


    public function atm_activate()
    {
     // global $wpdb;
     delete_option($this->atm_shop_name.'_page_title');
      add_option($this->atm_shop_name.'_page_title', $this->atm_shop_title, '', 'yes');

      delete_option($this->atm_shop_name.'_page_name');
      add_option($this->atm_shop_name.'_page_name', $this->atm_shop_page_name, '', 'yes');

      delete_option($this->atm_shop_name.'_page_id');
      add_option($this->atm_shop_name.'_page_id', $this->page_id, '', 'yes');

      $the_shop_page = get_page_by_title($this->atm_shop_title);

      if (!$the_shop_page)
      {
        // Create post object
        $_p = array();
        $_p['post_title']     = $this->atm_shop_title;
        $_p['post_content']   = "AutoMobile Shop Page";
        $_p['post_status']    = 'publish';
        $_p['post_type']      = 'page';
        $_p['comment_status'] = 'closed';
        $_p['ping_status']    = 'closed';
        $_p['post_category'] = array(1); // the default 'Uncatrgorised'

        // Insert the post into the database
        $this->page_id = wp_insert_post($_p);
      }
      else
      {
        // the plugin may have been previously active and the page may just be trashed...
        $this->page_id = $the_shop_page->ID;

        //make sure the page is not trashed...
        $the_shop_page->post_status = 'publish';
        $this->page_id = wp_update_post($the_shop_page);
      }

      delete_option($this->atm_shop_name.'_page_id');
      add_option($this->atm_shop_name.'_page_id', $this->page_id);

      //Cart Page

      delete_option($this->cart_name.'_page_title');
      add_option($this->cart_name.'_page_title', $this->cart_page_title, '', 'yes');

      delete_option($this->cart_name.'_page_name');
      add_option($this->cart_name.'_page_name', $this->cart_page_name, '', 'yes');

      delete_option($this->cart_name.'_page_id');
      add_option($this->cart_name.'_page_id', $this->page_id, '', 'yes');

      $the_cart_page = get_page_by_title($this->cart_page_title);

      if (!$the_cart_page)
      {
        // Create post object
        $_p = array();
        $_p['post_title']     = $this->cart_page_title;
        $_p['post_content']   = "AutoMobile Cart Page";
        $_p['post_status']    = 'publish';
        $_p['post_type']      = 'page';
        $_p['comment_status'] = 'closed';
        $_p['ping_status']    = 'closed';
        $_p['post_category'] = array(1); // the default 'Uncatrgorised'

        // Insert the post into the database
        $this->page_id = wp_insert_post($_p);
      }
      else
      {
        // the plugin may have been previously active and the page may just be trashed...
        $this->page_id = $the_cart_page->ID;

        //make sure the page is not trashed...
        $the_cart_page->post_status = 'publish';
        $this->page_id = wp_update_post($the_cart_page);
      }

      delete_option($this->cart_name.'_page_id');
      add_option($this->cart_name.'_page_id', $this->page_id);

      // Checkout page

      delete_option($this->checkout_name.'_page_title');
      add_option($this->checkout_name.'_page_title', $this->checkout_page_title, '', 'yes');

      delete_option($this->checkout_name.'_page_name');
      add_option($this->checkout_name.'_page_name', $this->checkout_page_name, '', 'yes');

      delete_option($this->checkout_name.'_page_id');
      add_option($this->checkout_name.'_page_id', $this->page_id, '', 'yes');

      $the_checkout_page = get_page_by_title($this->checkout_page_title);

      if (!$the_checkout_page)
      {
        // Create post object
        $_p = array();
        $_p['post_title']     = $this->checkout_page_title;
        $_p['post_content']   = "AutoMobile Checkout Page";
        $_p['post_status']    = 'publish';
        $_p['post_type']      = 'page';
        $_p['comment_status'] = 'closed';
        $_p['ping_status']    = 'closed';
        $_p['post_category'] = array(1); // the default 'Uncatrgorised'

        // Insert the post into the database
        $this->page_id = wp_insert_post($_p);
      }
      else
      {
        // the plugin may have been previously active and the page may just be trashed...
        $this->page_id = $the_checkout_page->ID;

        //make sure the page is not trashed...
        $the_checkout_page->post_status = 'publish';
        $this->page_id = wp_update_post($the_checkout_page);
      }

      delete_option($this->checkout_name.'_page_id');
      add_option($this->checkout_name.'_page_id', $this->page_id);


      // AutoMobile Account page

      delete_option($this->atm_account_name.'_page_title');
      add_option($this->atm_account_name.'_page_title', $this->atm_account_title, '', 'yes');

      delete_option($this->atm_account_name.'_page_name');
      add_option($this->atm_account_name.'_page_name', $this->atm_account_page_name, '', 'yes');

      delete_option($this->atm_account_name.'_page_id');
      add_option($this->atm_account_name.'_page_id', $this->page_id, '', 'yes');

      $the_account_page = get_page_by_title($this->atm_account_title);

      if (!$the_account_page)
      {
        // Create post object
        $_p = array();
        $_p['post_title']     = $this->atm_account_title;
        $_p['post_content']   = "AutoMobile Account Page";
        $_p['post_status']    = 'publish';
        $_p['post_type']      = 'page';
        $_p['comment_status'] = 'closed';
        $_p['ping_status']    = 'closed';
        $_p['post_category'] = array(1); // the default 'Uncatrgorised'

        // Insert the post into the database
        $this->page_id = wp_insert_post($_p);
      }
      else
      {
        // the plugin may have been previously active and the page may just be trashed...
        $this->page_id = $the_account_page->ID;

        //make sure the page is not trashed...
        $the_account_page->post_status = 'publish';
        $this->page_id = wp_update_post($the_account_page);
      }

      delete_option($this->atm_account_name.'_page_id');
      add_option($this->atm_account_name.'_page_id', $this->page_id);


    }

    public function atm_deactivate()
    {
      //$this->atm_deletePage();
      //$this->atm_deleteOptions();
    }

    public function atm_uninstall()
    {
      //$this->atm_deletePage(true);
      //$this->atm_deleteOptions();
    }

      /*public function atm_query_parser($q)
      {
        if(isset($q->query_vars['page_id']) AND (intval($q->query_vars['page_id']) == $this->page_id ))
        {
          $q->set($this->cart_name.'_page_is_called', true);
        }
        elseif(isset($q->query_vars['pagename']) AND (($q->query_vars['pagename'] == $this->cart_page_name) OR ($_pos_found = strpos($q->query_vars['pagename'],$this->cart_page_name.'/') === 0)))
        {
          $q->set($this->cart_name.'_page_is_called', true);
        }
        else
        {
          $q->set($this->cart_name.'_page_is_called', false);
        }
      }

        function atm_page_filter($posts)
        {
          global $wp_query;

          if($wp_query->get($this->cart_name.'_page_is_called'))
          {
            $posts[1]->post_title = __('Shopping Cartt');
            $posts[1]->post_content = '';
          }
          return $posts;
        }

        private function atm_deletePage($hard = false)
        {
          global $wpdb;

          $id = get_option($this->cart_name.'_page_id');
          if($id && $hard == true)
            wp_delete_post($id, true);
          elseif($id && $hard == false)
            wp_delete_post($id);

         $chid = get_option($this->checkout_name.'_page_id');
          if($chid && $hard == true)
            wp_delete_post($chid, true);
          elseif($chid && $hard == false)
            wp_delete_post($chid);

        $accid = get_option($this->atm_account_name.'_page_id');
          if($accid && $hard == true)
            wp_delete_post($accid, true);
          elseif($accid && $hard == false)
            wp_delete_post($accid);

        $shopid = get_option($this->atm_shop_name.'_page_id');
          if($shopid && $shopid == true)
            wp_delete_post($shopid, true);
          elseif($shopid && $hard == false)
            wp_delete_post($shopid);


        }

        private function atm_deleteOptions()
        {
          delete_option($this->cart_name.'_cart_page_title');
          delete_option($this->cart_name.'_cart_page_name');
          delete_option($this->cart_name.'_page_id');

          delete_option($this->checkout_name.'_checkout_page_title');
          delete_option($this->checkout_name.'_checkout_page_name');
          delete_option($this->checkout_name.'_page_id');

          delete_option($this->atm_account_name.'_checkout_page_title');
          delete_option($this->atm_account_name.'_checkout_page_name');
          delete_option($this->atm_account_name.'_page_id');

          delete_option($this->atm_shop_name.'_checkout_page_title');
          delete_option($this->atm_shop_name.'_checkout_page_name');
          delete_option($this->atm_shop_name.'_page_id');

        }*/
  }
}
$automobile_cart = new atm_activation();
?>