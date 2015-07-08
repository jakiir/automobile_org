<?php
 /*Template Name: Automobile single */

 $automobile_options = get_option('automobile_options');
get_header(); 
?>

    <?php  while ( have_posts() ) : the_post();
        global $post;
    $pid=$post->ID;
    $post_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
    $author = get_the_author(get_the_ID($post->ID));
    global $autoMobile;
    ?>
   <div class="content-wrapper">
        <div class="item-container">
            <div class="container">
        <div class="col-md-9">
            <h2><?php //echo esc_attr($automobile_options['automobile_order_send_email']); ?></h2>
                <div class="col-md-5 service-image-left">
                        <div style="margin:0 auto;">
                            <?php echo $autoMobile->auto_mobile_thumbnail('400x250'); ?>
                            
                        </div>
                </div>
                <div class="col-md-7">
                    <div class="product-title"><?php the_title(); ?></div>
                    
                    <hr>
					<p class="automobile_sku">
						<strong>Part# :</strong>  <?php echo get_post_meta($post->ID, 'txt_automobile_sku', true); ?>
					</p>
                    <p class="price">
                    <?php $txt_automobile_regular_price = esc_html( get_post_meta( get_the_ID(), 'txt_automobile_regular_price', true ) );
                    if($txt_automobile_regular_price): ?>
                    <del><span class="amount">$<?php echo $txt_automobile_regular_price; ?>.00</span></del>
                    <?php endif;
                    $txt_automobile_price = esc_html( get_post_meta( get_the_ID(), 'txt_automobile_price', true ) );
                    if($txt_automobile_price):
                    ?>
                    <ins><span class="amount">$<?php echo $txt_automobile_price; ?>.00</span></ins>
                    <?php endif; ?>
                    </p>

                    <div class="product-stock">
                    <?php
                    $automobile_product_status = esc_html( get_post_meta( get_the_ID(), 'automobile-product-status', true ) );
                    if($automobile_product_status == 'instock' ):
                        echo 'In stock';
                    else :
                        echo 'Out of stock';
                    endif;
                    ?>

                    </div>
					<div class="product-qty">
						<?php $qty_product = get_post_meta($post->ID, 'txt_automobile_qty', true); 
						
						@session_start();
						$sessionId = session_id();
						$auto_mobile_info = '_auto_mobile_info_'.$sessionId;
						$get_mobile_info = get_option( $auto_mobile_info );
						if($get_mobile_info){
						$get_mobile_info_uns = @unserialize($get_mobile_info);
						if($get_mobile_info_uns){
							foreach($get_mobile_info_uns as $key=>$get_mobile_info_unss):
								$itemId = $get_mobile_info_unss['item_id'];
								if(get_the_ID() == $itemId)
									$item_quantity = $get_mobile_info_unss['item_quantity'];
							endforeach;
						} 
						}						
						?>
						<label for="product_qty_single" class="left-lable"><?php _e( 'QTY', 'automobile_plugin' )?></label>
						<select data-item_price="<?php echo esc_html( get_post_meta( get_the_ID(), 'txt_automobile_price', true ) ); ?>" name="product_qty_single" id="product_qty_single">							
							<?php
								if($qty_product){
								for($product_qty=1;$product_qty<=$qty_product;$product_qty++){ ?>
									<option value="<?php echo $product_qty; ?>" <?php if ( isset ( $item_quantity ) ) selected( $item_quantity, $product_qty ); ?>><?php echo $product_qty; ?></option>';
								<?php } } else { ?>
								<option value="0">0</option>';
								<?php } ?>
						</select>
					</div>
					
                    <hr>
                    <div class="btn-group cart">
                        <a data-item_id="<?php echo get_the_ID(); ?>" data-item_sku="<?php echo esc_html(get_post_meta(get_the_ID(), 'txt_automobile_sku', true)); ?>" data-quantity="1" data-item_price="<?php echo esc_html( get_post_meta( get_the_ID(), 'txt_automobile_price', true ) ); ?>" class="btn btn-success auto_mobile_add_to_cart" href="<?php echo esc_url(home_url('/auto-mobile/?addToCart='.get_the_ID())); ?>">Add to cart</a>
                    </div>


                </div>
                
                
                <div class="col-md-12 product-info">
			<?php
				$get_advanced_automobile_array = get_post_meta($post->ID, 'advanced_automobile', true);
				$get_advanced_automobile = unserialize($get_advanced_automobile_array);
			?>
                    <ul id="myTab" class="nav nav-tabs nav_tabs">						
						<li class="active"><a href="#product_details" data-toggle="tab">Product Details</a></li>
						<li><a href="#applications" data-toggle="tab">Applications</a></li>
						<li><a href="#product_inquiry" data-toggle="tab">Product Inquiry</a></li>	
                    </ul>
                <div id="myTabContent" class="tab-content">			

				
						<div class="tab-pane fade in active" id="product_details">

                            <section class="product-details">
                              <p>
								<span class="adv_head"><strong> Color </strong> </span>
								<span class="adv_result">:
									<?php echo $get_advanced_automobile['txt_automobile_color']; ?>
								</span>
							</p>
							<p>
								<span class="adv_head"><strong> Position </strong> </span>
								<span class="adv_result">:
								<?php echo $get_advanced_automobile['txt_automobile_position']; ?>
								</span>
							</p>
							<p>
								<span class="adv_head"><strong> MPN </strong> </span>
								<span class="adv_result">:
									
										<?php
										echo get_post_meta($post->ID, 'txt_automobile_mpn', true);
											/* $get_automobile_mpn = get_post_meta($post->ID, 'txt_automobile_mpn', true);
											$get_automobile_mpn_uns = unserialize($get_automobile_mpn);
											if($get_automobile_mpn_uns):
											foreach($get_automobile_mpn_uns as $get_automobile_mpn_un): ?>
												<li><?php echo $get_automobile_mpn_un; ?></li>
										<?php endforeach; endif; */ ?>
									
								</span>
							</p>
							<p>
								<span class="adv_head"><strong> Description </strong> </span>
								<span class="adv_result">:
									<?php the_content(); ?>
								</span>
							</p>
							
							
                            </section>

                        </div>
						<div class="tab-pane fade" id="applications">

                            <section class="applications">
							
<table class="table table-hover">
    <thead>
        <tr>
            <th>Year</th>
            <th>Make</th>
            <th>Model</th>
            <th>Position</th>
            <th>Application Notes</th>
        </tr>
    </thead>
    <tbody>
      <tr>
        <td><?php 
        $txt_automobile_year = get_post_meta($post->ID, 'advanced_automobile_year', true); 
        $auto_mobile_year = '_auto_mobile_year';
        $get_auto_mobile_year = get_option( $auto_mobile_year );
        $get_auto_mobile_year_uns = @unserialize($get_auto_mobile_year);
        echo $get_auto_mobile_year_uns[$txt_automobile_year]; 
        ?></td>
        <td><?php 
        if ( isset ( $get_advanced_automobile['txt_automobile_make'] ) )
        $txt_automobile_make = $get_advanced_automobile['txt_automobile_make'];
        $auto_mobile_make = '_auto_mobile_make';
        $get_auto_mobile_make = get_option( $auto_mobile_make );
        $get_auto_mobile_make_uns = @unserialize($get_auto_mobile_make);
        echo $get_auto_mobile_make_uns[$txt_automobile_make]; 
        ?></td>
        <td><?php 
        if ( isset ( $get_advanced_automobile['txt_automobile_model'] ) )
        $txt_automobile_model = $get_advanced_automobile['txt_automobile_model'];
        $auto_mobile_model = '_auto_mobile_model';
        $get_auto_mobile_model = get_option( $auto_mobile_model );
        $get_auto_mobile_model_uns = @unserialize($get_auto_mobile_model);
        echo $get_auto_mobile_model_uns[$txt_automobile_model];
        ?></td>
        <td><?php echo $get_advanced_automobile['txt_automobile_position']; ?></td>
        <td>	<?php echo $get_advanced_automobile['txt_automobile_comments']; ?></td>
      </tr>
      
    </tbody>
  </table>
                            </section>

                        </div>
						<div class="tab-pane fade" id="product_inquiry">

                            <section class="product-inquiry">
								<div id="enquiry_msg"></div>
								<form action="" method="post">
								  <div class="form-group">
									<label for="your_name">Your Name <span class="requird">*</span></label>
									<input type="text" class="form-control" id="your_name" placeholder="Your Name">
								  </div>
								  <div class="form-group">
									<label for="email_address">Email address <span class="requird">*</span></label>
									<input type="email" name="email_address" class="form-control" id="email_address" placeholder="Enter email">
								  </div>
								  <div class="form-group">
									<label for="parts">Part # (automatically fill)</label>
									<input readonly type="text" name="inquiry_parts" class="form-control" id="inquiry_parts" placeholder="Part # (automatically fill)" value="<?php echo get_post_meta($post->ID, 'txt_automobile_sku', true); ?>">
								  </div>
								  <div class="form-group">
									<label for="product_inquiry">Product Inquiry <span class="requird">*</span></label>
									<textarea name="product_inquiry" id="product_inquiry" class="form-control" rows="3"></textarea>									
								  </div>
								  <span>							  
								  <button type="submit" id="inquiry_submit" class="btn btn-default">Submit</button>
								  </span>
								</form>
                            </section>

                        </div>
                </div>
              
            </div>
                
                
                </div>
                 <div class="col-md-3">
               <?php get_sidebar(); ?>
            </div>
            </div>
        </div>
        
            
        </div>
    


   <?php endwhile;  ?>
  

<?php get_footer(); ?>
