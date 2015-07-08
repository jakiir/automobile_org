<?php
/* Template Name: Automobile archive */
?>
<?php get_header(); 
        global $autoMobile;
?>

<section class="main-container">
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                                                    
                <div class="ctg-title">
                    <h2><?php 
					$product_category = $_GET['product_category'];
    					if($product_category):
    						$autoMobileTermObject = get_term_by( 'id', absint( $_GET['product_category'] ), 'automobile_product_category' );
    						echo $autoMobileTermObject->name;
    					else :
    						echo 'Categories';
    					endif;
					?>                    
                    </h2>	
                </div>
				
				<div class="miniCart"><?php echo $autoMobile->mini_cart(); ?></div>
                
               <div id="products" class="list-group">

        <?php if ( have_posts() ) : ?>          
        <?php
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;		
    		$atm_make = $_GET['txt_automobile_make'];
    		$atm_model = $_GET['txt_automobile_model'];
    		$atm_year = $_GET['txt_automobile_year'];
    		$postLimit = 6;
		if(isset($_GET['txt_automobile_year']) && isset($_GET['txt_automobile_make']) && isset($_GET['txt_automobile_model'])) :	
			$args = array(
				'post_type' => 'tlp_automobile',
				'post_status' => 'publish',
				'posts_per_page' => $postLimit,
				'paged' => $paged,				
				'meta_query' => array(
							'relation' => 'AND',
					array(
							'key' => 'advanced_automobile_make',
							'value' => $atm_make,
							'compare' => 'LIKE',
					),
					array(
							'key' => 'advanced_automobile_model',
							'value' => $atm_model,
							'compare' => 'LIKE',
					),
					array(
							'key' => 'advanced_automobile_year',
							'value' => $atm_year,
							'compare' => 'LIKE',
					)					
				 )
			); 
		elseif($_GET['txt_automobile_model'] != '') :
			$args = array(
				'post_type' => 'tlp_automobile',
				'post_status' => 'publish',
				'posts_per_page' => $postLimit,
				'paged' => $paged,
				'meta_key'         => 'advanced_automobile_model',
				'meta_value'       => $atm_model				
			);
		elseif($_GET['product_category'] != '') :
			$args = array(
				'post_type' => 'tlp_automobile',
				'post_status' => 'publish',
				'posts_per_page' => $postLimit,
				'paged' => $paged,
				'tax_query' => array(
						array(
						  'taxonomy' => 'automobile_product_category',
						  'field' => 'id',
						  'terms' => $_GET['product_category'], 
						  'include_children' => false
						)
					  )				
			);
		else :
			$args = array(
				'post_type' => 'tlp_automobile',
				'post_status' => 'publish',
				'posts_per_page' => $postLimit,
				'paged' => $paged
			);        
		endif;
        
        
       
		if(isset($_GET['txt_automobile_year']) && isset($_GET['txt_automobile_make']) && isset($_GET['txt_automobile_model'])) {
			//echo $autoMobile->autoMobileList($args);
             echo $autoMobile->get_all_automobiles($args);
             echo $autoMobile->automobile_pagination($args);
		}else{
		  echo $autoMobile->get_all_automobiles($args);
          echo $autoMobile->automobile_pagination($args);
		}
         
 endif; 
 ?> 
    </div>  
            </div>
            <div class="col-md-3">
               <?php get_sidebar(); ?>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>