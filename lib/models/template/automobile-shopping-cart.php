<?php
 /*Template Name: order
 */

 $automobile_options = get_option('automobile_options');

get_header(); 
	$permalink_structure = get_option('permalink_structure');
	if($permalink_structure == ''):
		$auto_mobile_page_id = get_option('auto-mobile_page_id');
		$auto_mobile_permalink = home_url('/?page_id='.$auto_mobile_page_id);
		
		$automobile_checkout_page_id = get_option('automobile-checkout_page_id');
		$automobile_checkout_permalink = home_url('/?page_id='.$automobile_checkout_page_id);
	else :
		$auto_mobile_page_name = get_option('auto-mobile_page_name');
		$auto_mobile_permalink = home_url('/'.$auto_mobile_page_name.'/');
		
		$automobile_checkout_page_name = get_option('automobile-checkout_page_name');
		$automobile_checkout_permalink = home_url('/'.$automobile_checkout_page_name.'/');
	endif;
?>

<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-10 col-md-offset-1">
        <?php
        @session_start();
        $sessionId = session_id();
        $auto_mobile_info = '_auto_mobile_info_'.$sessionId;
        $get_mobile_info = get_option( $auto_mobile_info );
        if($get_mobile_info){
        $get_mobile_info_uns = @unserialize($get_mobile_info);
        if($get_mobile_info_uns){
        ?>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th class="text-center">Price</th>
                        <th class="text-center">Total</th>
                        <th colspan="2"> </th>
                    </tr>
                </thead>
                <tbody>

                <?php
                $totalPrice =0;
                $incr = 0;
                foreach($get_mobile_info_uns as $key=>$get_mobile_info_unss):
                $itemId = $get_mobile_info_unss['item_id'];
                $item_quantity = $get_mobile_info_unss['item_quantity'];
                $item_price = $get_mobile_info_unss['item_price'];
                $post_image = wp_get_attachment_url( get_post_thumbnail_id($itemId) );
                if($post_image): $postImage = $post_image; else : $postImage = 'http://placehold.it/72x72'; endif;
                $totalPrice += $item_price;
				$get_advanced_automobile_array = get_post_meta($itemId, 'advanced_automobile', true);
				$get_advanced_automobile = unserialize($get_advanced_automobile_array);
				$partId = get_post_meta($itemId, 'txt_automobile_sku', true);
                ?>
                    <tr>
                        <td class="col-sm-8 col-md-7">
                        <div class="media">
                            <a class="thumbnail pull-left" href="<?php echo get_permalink( $itemId ); ?>">
                            <img class="media-object" src="<?php echo $postImage; ?>" style="width: 72px; height: 72px;">
                            </a>
                            <div class="media-body">
                                <h4 class="media-heading"><a href="<?php echo get_permalink( $itemId ); ?>"><?php echo get_the_title( $itemId ); ?></a></h4>
                                <h5 class="media-heading"> Part# <?php echo $partId; ?></h5>
                                <span>Make: </span><span class="text-success"><strong>
                                <?php 
									if ( isset ( $get_advanced_automobile['txt_automobile_make'] ) )
									$txt_automobile_make = $get_advanced_automobile['txt_automobile_make'];
									$auto_mobile_make = '_auto_mobile_make';
									$get_auto_mobile_make = get_option( $auto_mobile_make );
									$get_auto_mobile_make_uns = @unserialize($get_auto_mobile_make);
									echo $get_auto_mobile_make_uns[$txt_automobile_make]; 
								?>
                                </strong>/</span>
								<span>Model: </span><span class="text-success"><strong>
                                <?php 
									if ( isset ( $get_advanced_automobile['txt_automobile_model'] ) )
									$txt_automobile_model = $get_advanced_automobile['txt_automobile_model'];
									$auto_mobile_model = '_auto_mobile_model';
									$get_auto_mobile_model = get_option( $auto_mobile_model );
									$get_auto_mobile_model_uns = @unserialize($get_auto_mobile_model);
									echo $get_auto_mobile_model_uns[$txt_automobile_model]; 
								?>
                                </strong>/</span>
								<span>Year: </span><span class="text-success"><strong>
                                <?php 
									$txt_automobile_year = get_post_meta($itemId, 'advanced_automobile_year', true); 
									$auto_mobile_year = '_auto_mobile_year';
									$get_auto_mobile_year = get_option( $auto_mobile_year );
									$get_auto_mobile_year_uns = @unserialize($get_auto_mobile_year);
									echo $get_auto_mobile_year_uns[$txt_automobile_year];  
								?>
                                </strong></span>
                            </div>
                        </div></td>
                        <td class="col-sm-1 col-md-1" style="text-align: center">
                            <label for="item_quantity<?php echo $incr; ?>"></label>
                        <input type="number" class="form-control" id="item_quantity<?php echo $incr; ?>" value="<?php echo $item_quantity; ?>">
                        </td>
                        <td class="col-sm-1 col-md-1 text-center"><strong>$<?php echo $item_price/$item_quantity; ?></strong></td>
                        <td class="col-sm-1 col-md-1 text-center"><strong>$<?php echo $item_price; ?></strong></td>
						<td class="col-sm-1 col-md-1">
                        <a href="javascript:void(0)" data-item_sku="<?php echo $partId; ?>" data-incr_id="<?php echo $incr; ?>" data-item_price="<?php echo $item_price/$item_quantity; ?>" data-item_id="<?php echo $itemId; ?>" data-item_key="<?php echo $key; ?>" class="btn btn-danger itemUpdateBtn">
                            <span class="glyphicon glyphicon-ok"></span>
                        </a></td>
                        <td class="col-sm-1 col-md-1">
                        <a href="javascript:void(0)" data-item_id="<?php echo $itemId; ?>" data-item_key="<?php echo $key; ?>" class="btn btn-danger itemRemoveBtn">
                            <span class="glyphicon glyphicon-remove"></span>
                        </a></td>
                    </tr>
                <?php $incr++; endforeach; ?>

                    <tr>
                        <td>   </td>
                        <td>   </td>
                        <td>   </td>
                        <td><h5>Subtotal</h5></td>
                        <td class="text-right"><h5><strong>$<?php echo $totalPrice; ?></strong></h5></td>
                    </tr>
                    <tr>
                        <td>   </td>
                        <td>   </td>
                        <td>   </td>
                        <td><h5>Estimated shipping</h5></td>
                        <td class="text-right"><h5><strong>$0.00</strong></h5></td>
                    </tr>
                    <tr>
                        <td>   </td>
                        <td>   </td>
                        <td>   </td>
                        <td><h3>Total</h3></td>
                        <td class="text-right"><h3><strong>$<?php echo $totalPrice; ?></strong></h3></td>
                    </tr>
                    <tr>
                        <td>   </td>
                        <td>   </td>
                        <td>   </td>
                        <td>
                        <a href="<?php echo $auto_mobile_permalink; ?>" class="btn btn-default">
                            <span class="glyphicon glyphicon-shopping-cart"></span> Continue Shopping
                        </a>
                        </td>
                        <td>
                        <a href="<?php echo $automobile_checkout_permalink; ?>" class="btn btn-success">
                            Checkout <span class="glyphicon glyphicon-play"></span>
                        </a></td>
                    </tr>
                </tbody>
            </table>
        <?php } else { ?>
        <article id="post-5" class="post-5 page type-page status-publish hentry">
                <header class="entry-header">

                <h1 class="entry-title">Cart</h1>
                </header><!-- .entry-header -->

                <div class="entry-content">
                <div class="">
                <p class="cart-empty">Your cart is currently empty.</p>
                <p class="return-to-auto-mobile"><a class="button wc-backward" href="<?php echo $auto_mobile_permalink; ?>">Return To Auto Mobile</a></p>
                </div>
                </div>
            </article>
        <?php } } else { ?>
            <article id="post-5" class="post-5 page type-page status-publish hentry">
                <header class="entry-header">

                <h1 class="entry-title">Cart</h1>
                </header><!-- .entry-header -->

                <div class="entry-content">
                <div class="">
                <p class="cart-empty">Your cart is currently empty.</p>
                <p class="return-to-auto-mobile"><a class="button wc-backward" href="<?php echo $auto_mobile_permalink; ?>">Return To Auto Mobile</a></p>
                </div>
                </div>
            </article>
        <?php } ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>
