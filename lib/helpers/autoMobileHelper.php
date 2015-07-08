<?php
if (!class_exists('autoMobileHelper'))
{
  class autoMobileHelper
  {


    function __construct(){

    }

    function mini_cart(){
        $output = '';
        $quantity = 0;
        $totalPrice = 0;
		$permalink_structure = get_option('permalink_structure');
		if($permalink_structure == ''):
		$shopping_cart_id = get_option('shopping-cart_page_id');
		$shopping_cart = home_url('/?page_id='.$shopping_cart_id);
		else :
		$shopping_cart_name = get_option('shopping-cart_page_name');
        $shopping_cart = home_url('/'.$shopping_cart_name.'/');
		endif;
		
        @session_start();
        $sessionId = session_id();
        $auto_mobile_info = '_auto_mobile_info_'.$sessionId;
        $get_mobile_info = get_option( $auto_mobile_info );
        $get_mobile_info_uns = @unserialize($get_mobile_info);
        if($get_mobile_info_uns){
            foreach($get_mobile_info_uns as $key=>$get_mobile_info_unss):
                $item_quantity = $get_mobile_info_unss['item_quantity'];
                $item_price = $get_mobile_info_unss['item_price'];
                $quantity += $item_quantity;
                $totalPrice += $item_price;
            endforeach;

            $output = '<span class="cart_item" data-qty="'.$quantity.'">'.$quantity.'</span> ';
            $output .= ' <span class="cart_price" data-price="'.$totalPrice.'">$'.$totalPrice.'</span> ';
            $output .= ' <span class="view_cart"><a href="'.$shopping_cart.'" title="view cart" target="_self">View Cart</a></span>';
        }
        if($output != ''){
            return $output;
        } else {
            $output_empty = '<span class="cart_item" data-qty="0"></span> ';
            $output_empty .= ' <span class="cart_price" data-price="0"></span> ';
            $output_empty .= ' <span class="view_cart" style="display:none;"><a href="'.$shopping_cart.'" title="view cart" target="_self">View Cart</a></span>';
            return $output_empty;
        }
    }
	
function automobile_search_list() {
	echo '<form action="'. home_url('/auto-mobile/') .'" method="GET"><ul class="list-inline">';
    $screen = get_current_screen();
	
		$auto_mobile_year = '_auto_mobile_year';
        $get_auto_mobile_year = get_option( $auto_mobile_year );
        $get_auto_mobile_year_uns = @unserialize($get_auto_mobile_year);
        echo '<li><select class="form-control"  name="txt_automobile_year" id="txt_automobile_year_dropdown"><option value="">Show All Year</option>';         
		if($get_auto_mobile_year_uns) {
			arsort($get_auto_mobile_year_uns);
            foreach ($get_auto_mobile_year_uns as $key=>$get_auto_mobile_year_unss): ?>
                <option value="<?php echo $key; ?>" <?php if ( isset ( $_GET['txt_automobile_year'] ) ) selected( $_GET['txt_automobile_year'], $key ); ?>><?php _e( $get_auto_mobile_year_unss, 'automobile_plugin' )?></option>';         <?php  endforeach;
        }
        echo '</select></li>';
		
		$auto_mobile_make = '_auto_mobile_make';
        $get_auto_mobile_make = get_option( $auto_mobile_make );
        $get_auto_mobile_make_uns = @unserialize($get_auto_mobile_make);
        echo '<li><select disabled class="form-control"  name="txt_automobile_make" id="txt_automobile_make_dropdown"><option value="">Show All Make</option>';         if($get_auto_mobile_make_uns) {
            foreach ($get_auto_mobile_make_uns as $key=>$get_auto_mobile_make_unss): ?>
                <option value="<?php echo $key; ?>" <?php if ( isset ( $_GET['txt_automobile_make'] ) ) selected( $_GET['txt_automobile_make'], $key ); ?>><?php _e( $get_auto_mobile_make_unss, 'automobile_plugin' )?></option>';         <?php  endforeach;
        }
        echo '</select></li>';
		
		$auto_mobile_model = '_auto_mobile_model';
        $get_auto_mobile_model = get_option( $auto_mobile_model );
        $get_auto_mobile_model_uns = @unserialize($get_auto_mobile_model);
        echo '<li><select disabled class="form-control"  name="txt_automobile_model" id="txt_automobile_model_dropdown"><option value="">Show All Model</option>';
            if($get_auto_mobile_model_uns) {
                foreach ($get_auto_mobile_model_uns as $key=>$get_auto_mobile_model_unss): ?>
                    <option value="<?php echo $key; ?>" <?php if ( isset ( $_GET['txt_automobile_model'] ) ) selected( $_GET['txt_automobile_model'], $key ); ?>><?php _e( $get_auto_mobile_model_unss, 'automobile_plugin' )?></option>';
                <?php  endforeach;
            }
        echo '</select></li>';
		
		echo '<li><input type="submit" class="btn btn-danger search_submit" value="Go"/></li></ul></form>';
    
}

function automobile_search_by_model() {
	echo '<ul>';
		$auto_mobile_model = '_auto_mobile_model';
        $get_auto_mobile_model = get_option( $auto_mobile_model );
        $get_auto_mobile_model_uns = @unserialize($get_auto_mobile_model);       
		if($get_auto_mobile_model_uns) {
			foreach ($get_auto_mobile_model_uns as $key=>$get_auto_mobile_model_unss): ?>
				<li><a href="<?php echo home_url('/auto-mobile/?txt_automobile_model='.$key); ?>"><i class="fa fa-arrow-circle-right"></i><?php _e( $get_auto_mobile_model_unss, 'automobile_plugin' ); ?></a></li>
			<?php  endforeach;
		}
	echo '</ul>';
    
}


function automobile_taxonomies_terms(){
$terms = get_terms( 'automobile_product_category' );
$output = '';
 if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
	 global $autoMobile;
	 $automobile_category_extra_fields = get_option('automobile_category_images');
       
     $output = '<div class="row">';
     foreach ( $terms as $term ) {
		 
		$permalink_cat = home_url('/auto-mobile/?product_category='.$term->term_id);
		
		$thumbnail_id = absint($automobile_category_extra_fields[$term->term_id]['automobile_category_images']);
		if ( $thumbnail_id ) {
			$image = wp_get_attachment_thumb_url( $thumbnail_id );
		} else {
			$image = $autoMobile->auto_mobile_default_image();
		}
       $output .= '<div class="col-md-3 col-sm-6"><div class="product-box product-box-cat"><a href="' . esc_url( $permalink_cat ) . '"><img src="' . esc_url( $image ) . '" alt="'. __( 'Thumbnail', 'automobile' ) . '" class="wp-post-image img-responsive" height="" width="" /></a><h3><a href="' . esc_url( $permalink_cat ) . '">' . $term->name . '</a></h3></div></div>';
        
     }
     $output .= '</div>';
	return $output;
	}
}

function get_automobile_post_id($automobile_sku){
	$args = array(
		'post_type' => 'tlp_automobile',
		'post_status' => 'publish',	
	);

	global $wp_query , $post;
	$wp_query = new WP_Query($args);
	if( $wp_query->have_posts() ) {
	  while ($wp_query->have_posts()) : $wp_query->the_post();
		$postId = $post->ID;
		
		$txt_automobile_sku = get_post_meta( $postId, 'txt_automobile_sku', true );
		if($txt_automobile_sku == $automobile_sku){
			$checkVal[] = 'yes';
		} else {
			$checkVal[] = 'no';
		}
		
	  endwhile;
	  return $checkVal;
	}
}


    function get_all_automobiles($args = array()){

        global $wp_query , $post, $autoMobile;
        $wp_query = new WP_Query($args);
        if( $wp_query->have_posts() ) {
          while ($wp_query->have_posts()) : $wp_query->the_post();
            $txt_limit=20;
            $txt_automobile_price = esc_html( get_post_meta( get_the_ID(), 'txt_automobile_price', true ) );
            $content = get_the_content(get_the_ID($post->ID));
            $automobile_content = wp_trim_words( $content,$txt_limit); ?>
            <div class="item  col-md-4 col-sm-6">
            <div class="product-box product-box-border">
                <a href="<?php the_permalink(); ?>">
                    <?php echo $autoMobile->auto_mobile_thumbnail('400x250'); ?>
                </a>
                <div class="caption">
                    <h3>
                            <a href="<?php the_permalink(); ?>">
                                <?php the_title(); ?>
                            </a>
                            
                    </h3>   
                     <ul class="buy-now-pro-btn">
                     <li>
                    <span class="auto-price">$<?php if($txt_automobile_price) : echo $txt_automobile_price; else : echo '-'; endif; ?></span>                 
                  		</li>					
                          <li>     <a class="btn btn-success auto_mobile_add_to_cart" href="#" data-item_id="<?php echo get_the_ID(); ?>" data-item_sku="<?php echo esc_html(get_post_meta(get_the_ID(), 'txt_automobile_sku', true)); ?>" data-quantity="1" data-item_price="<?php echo esc_html( get_post_meta( get_the_ID(), 'txt_automobile_price', true ) ); ?>"><i class="fa fa-shopping-cart"></i> Buy Now</a>
                           </li>
                           </ul>
                </div>
            </div>
        </div>
        <?php  endwhile;
        }
    }
	
	function autoMobileList($args = array()){ ?>
		
        
            <div class="arkive-product">
                <div class="row" style="padding: 0;">
                    <div class="product-heading">
                        <div class="col-md-2">
                            <h5>Parts#</h5>
                        </div>
                        <div class="col-md-2">
                            <h5>Image</h5>
                        </div> 
                        <div class="col-md-6">
                            <h5>Product Name</h5>
                        </div> 
                        <div class="col-md-2">
                           
                        </div>             
                    </div>
                </div>
                
                
               
    <?php
		global $wp_query , $post, $autoMobile;
        $wp_query = new WP_Query($args);
        if( $wp_query->have_posts() ) {
          while ($wp_query->have_posts()) : $wp_query->the_post();            
			$txt_automobile_price = esc_html( get_post_meta( get_the_ID(), 'txt_automobile_price', true ) );
			$partId = get_post_meta(get_the_ID(), 'txt_automobile_sku', true);
			?>
                
                <div class="row" style="padding: 0;">
                    <div class="product-box2">
                        <div class="col-md-2 col-sm-6">
                            <h5> <?php if($partId): echo $partId; else : echo '-'; endif; ?></h5>
                        </div>
                        <div class="col-md-2 col-sm-6">
                            <h5><a href="<?php the_permalink(); ?>"><?php echo $autoMobile->auto_mobile_thumbnail('72x72'); ?></a></h5>
                        </div> 
                        <div class="col-md-6 col-sm-8">
                            <p class="p-name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p>
                        </div> 
                        <div class="col-md-2 col-sm-4">
                            <div class="product-price">
                                <span class="t-price">$<?php if($txt_automobile_price) : echo $txt_automobile_price; else : echo '-'; endif; ?></span>
                            </div>
                            <div class="buy-now-pro-btn">							
                                <a class="btn btn-success auto_mobile_add_to_cart" href="#" data-item_id="<?php echo get_the_ID(); ?>" data-item_sku="<?php echo esc_html(get_post_meta(get_the_ID(), 'txt_automobile_sku', true)); ?>" data-quantity="1" data-item_price="<?php echo esc_html( get_post_meta( get_the_ID(), 'txt_automobile_price', true ) ); ?>"><i class="fa fa-shopping-cart"></i> Buy Now</a>
                           </div>
                        </div>             
                    </div>                             
                </div>
		<?php endwhile; } ?>
                
             
                
                
            </div>
              
    
	<?php }

  }
}
?>