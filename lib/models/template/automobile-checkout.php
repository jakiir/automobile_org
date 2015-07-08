<?php
 /*Template Name: checkout*/
 
 $automobile_options = get_option('automobile_options');
 
get_header();
$userEmail = '';
$display_name = '';
if ( is_user_logged_in() ) {
    $userId = get_current_user_id();
    $user_info = get_userdata($userId);
    $userEmail = $user_info->data->user_email;
    $display_name = $user_info->data->display_name;
    $first_last_name = explode(' ', $display_name);
    $checkout_address = get_user_meta($userId, 'checkout_address', true);
    $checkout_phone = get_user_meta($userId, 'checkout_phone', true);
    $checkout_company_name = get_user_meta($userId, 'checkout_company_name', true);
    $selectCountry = get_user_meta($userId, 'selectCountry', true);
    $checkout_postcode = get_user_meta($userId, 'checkout_postcode', true);
    $checkout_town_city = get_user_meta($userId, 'checkout_town_city', true);
    $checkout_notes = get_user_meta($userId, 'checkout_notes', true);

}

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
<?php
	@session_start();
	$sessionId = session_id();
	$auto_mobile_info = '_auto_mobile_info_'.$sessionId;
	$get_mobile_info = get_option( $auto_mobile_info );
	if($get_mobile_info){
	$get_mobile_info_uns = @unserialize($get_mobile_info);
	if($get_mobile_info_uns){
?>
<div class="row">
        <div class="col-sm-6 col-md-6">
          
       <form class="form-horizontal">
<fieldset>

<!-- Form Name -->
<legend>Form Name</legend>
<div id="checkout_mess"></div>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="checkout_first_name">First Name</label>
  <div class="controls">
    <input id="checkout_first_name" name="checkout_first_name" value="<?php if($display_name): echo $first_last_name[0]; endif; ?>" placeholder="First Name" class="form-control" type="text">
    
  </div>
</div>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="checkout_last_name">Last Name</label>
  <div class="controls">
    <input id="checkout_last_name" name="checkout_last_name" value="<?php if($display_name): echo $first_last_name[1]; endif; ?>" placeholder="Last Name" class="form-control" type="text">
    
  </div>
</div>
<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="checkout_email">Email Address *</label>
  <div class="controls">
    <input id="checkout_email" name="email" value="<?php if($userEmail): echo $userEmail; endif; ?>" placeholder="Email Address " class="form-control" type="text">
    
  </div>
</div>

<!-- Password input-->
<div class="control-group">
  <label class="control-label" for="checkout_password">Password</label>
  <div class="controls">
    <input id="checkout_password" name="checkout_password" placeholder="******" class="form-control" required="" type="password">
    
  </div>
</div>

<!-- Textarea -->
<div class="control-group">
  <label class="control-label" for="checkout_notes">Notes </label>
  <div class="controls">                     
    <textarea  class="form-control" id="checkout_notes" name="checkout_notes"><?php if($checkout_notes): echo $checkout_notes; endif; ?></textarea>
  </div>
</div>

<!-- Textarea -->
<div class="control-group">
  <label class="control-label" for="checkout_address">Address</label>
  <div class="controls">                     
    <textarea id="checkout_address" class="form-control" name="checkout_address"><?php if($checkout_address): echo $checkout_address; endif; ?></textarea>
  </div>
</div>

<!-- Select Basic -->
<div class="control-group">
  <label class="control-label" for="checkout_city">City</label>
  <div class="controls">
	<input id="checkout_city" name="checkout_city" placeholder="City" class="form-control" type="text">    
  </div>
</div>

<!-- Select Basic -->
<div class="control-group">
  <label class="control-label" for="checkout_state">State</label>
  <div class="controls">
	<?php
		global $autoMobile;
		$state_list = $autoMobile->state_list();  
	?>
    <select id="checkout_state" name="checkout_state" class="form-control">
        <option value="">State</option>
        <?php
		
        foreach($state_list as $ckey => $cvalue) {
            $marked = ( $ckey == $state_list ? 'selected="selected"' : null );
            echo "<option value='$ckey' $marked>$cvalue</option>";
        }
        ?>
    </select>
	
  </div>
</div>
<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="checkout_postcode">Zip</label>
  <div class="controls">
    <input value="<?php if($checkout_postcode): echo $checkout_postcode; endif; ?>" id="checkout_postcode" onkeyup="check_number(this)" onkeypress="check_number(this)" name="checkout_postcode" placeholder="Postcode / Zip" class="form-control" type="text">
    
  </div>
</div>
</fieldset>
</form>
    </div>
    <div class="col-sm-6 col-md-6">        
    <table class="table table-hover">
        <form action="" method="">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th class="text-center">Price</th>
                        <th class="text-center">Total</th>
                        <th> </th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $totalPrice =0;
                $incr = 0;
				$totalItem = 0;
                foreach($get_mobile_info_uns as $key=>$get_mobile_info_unss):
                $itemId = $get_mobile_info_unss['item_id'];
                $item_quantity = $get_mobile_info_unss['item_quantity'];
                $item_price = $get_mobile_info_unss['item_price'];
                $post_image = wp_get_attachment_url( get_post_thumbnail_id($itemId) );
                if($post_image): $postImage = $post_image; else : $postImage = 'http://placehold.it/72x72'; endif;
                $totalPrice += $item_price;
				$totalItem += $item_quantity;
                ?>
                    <tr>
<input type="hidden" class="product_ids" name="product_ids[]" value="<?php echo $itemId; ?>"/>
<input type="hidden" class="product_names" name="product_names[]" value="<?php echo get_the_title( $itemId ); ?>"/>
<input type="hidden" class="product_item_prices" name="product_item_price[]" value="<?php echo $item_price/$item_quantity; ?>"/>
<input type="hidden" class="product_total_price" name="product_total_price[]" value="<?php echo $item_price; ?>"/>
<input type="hidden" class="product_quantity" name="product_quantity[]" value="<?php echo $item_quantity; ?>"/>
<input type="hidden" class="product_shipping" name="product_shipping[]" value="0.00"/>
                        <td class="col-sm-8 col-md-6">
                        <div class="media">
                          
                            <div class="media-body">
                                <h4 class="media-heading"><a href="#"><?php echo get_the_title( $itemId ); ?></a></h4>
                                <h5 class="media-heading"> by <a href="#">Brand name</a></h5>
                               
                            </div>
                        </div></td>
                        <td class="col-sm-1 col-md-1" style="text-align: center">
                        <span><?php echo $item_quantity; ?></span>
                        </td>
                        <td class="col-sm-1 col-md-1 text-center"><strong>$<?php echo $item_price/$item_quantity; ?></strong></td>
                        <td class="col-sm-1 col-md-1 text-center"><strong>$<?php echo $item_price; ?></strong></td>
                       
                    </tr>
                    <?php $incr++; endforeach; ?>
<input type="hidden" id="subTotalPrice" name="subTotalPrice" value="<?php echo $totalPrice; ?>"/>
<input type="hidden" id="productTotalPrice" name="productTotalPrice" value="<?php echo $totalPrice; ?>"/>
<input type="hidden" id="productTotalItem" name="productTotalItem" value="<?php echo $totalItem; ?>"/>         
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
                    
                </tbody>
        </form>
            </table>
			
			<?php
			$options = get_option('automobile_options');
			if($options):
				$order_send_email = esc_attr($options['automobile_order_send_email']);
				if($order_send_email):
					$orderEmail = $order_send_email;
				else :
					$orderEmail = 'jakir44.du@gmail.com';
				endif;
			else :
				$orderEmail = 'jakir44.du@gmail.com';
			endif;
			$data=array(
				'merchant_email'=>$orderEmail,	
				'currency_code'=>'USD',
				'thanks_page'=>"http://".$_SERVER['HTTP_HOST'].'paypal/thank.php',
				'notify_url'=>"http://".$_SERVER['HTTP_HOST'].'paypal/ipn.php',
				'cancel_url'=>"http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'],
				'paypal_mode'=>true,
			);
			define( 'SSL_URL', 'https://www.paypal.com/cgi-bin/webscr' );
			define( 'SSL_SAND_URL', 'https://www.sandbox.paypal.com/cgi-bin/webscr' );
			$action = '';
			 //Is this a test transaction?
			$action = ($data['paypal_mode']) ? SSL_SAND_URL : SSL_URL;
			?>

			<form name="frm_payment_method" action="<?php echo $action; ?>" method="post">
			<input type="hidden" name="cmd" value="_cart">
			<input type="hidden" name="upload" value="1">
			<input type="hidden" name="business" value="<?php echo $data['merchant_email']; ?>">
			<input type="hidden" name="currency_code" value="<?php echo $data['currency_code']; ?>">
			<input type="hidden" name="notify_url" value="<?php echo $data['notify_url']; ?>" />
			<input type="hidden" name="cancel_return" value="<?php echo $data['cancel_url']; ?>" />
			<input type="hidden" name="return" value="<?php echo $data['thanks_page']; ?>" />
			<input type="hidden" name="charset" value="utf-8" />
			<?php $inn = 1; foreach($get_mobile_info_uns as $key=>$get_mobile_info_unss): 
				$item_id = $get_mobile_info_unss['item_id'];
                $itemQuantity = $get_mobile_info_unss['item_quantity'];
                $itemPrice = $get_mobile_info_unss['item_price'];             
                
			?>
			<input type="hidden" name="item_name_<?php echo $inn; ?>" value="<?php echo get_the_title( $item_id ); ?>">
			<input type="hidden" name="amount_<?php echo $inn; ?>" value="<?php echo $itemPrice/$itemQuantity; ?>">
			<input type="hidden" name="quantity_<?php echo $inn; ?>" value="<?php echo $itemQuantity; ?>">			
			<?php $inn++; endforeach; ?>
			</form>
			
			
        
<div class="control-group pull-right">
  <label class="control-label" for="Place order">Place order</label>
  <div class="controls">
    <a id="automobile_place_order" href="javascript:void(0)" data-logged="<?php if ( is_user_logged_in() ) : echo 'yes'; else : echo 'no'; endif; ?>" name="automobile_place_order" class="btn btn-primary">Place order</a>
  </div>
</div>
            </div>
            <!-- Button -->
</div>
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

<?php /* if($selectCountry): ?>
<script type="text/javascript">
	var login_user_selectCountry = '<?php echo $selectCountry; ?>';
	var login_user_checkout_town_city = '<?php echo $checkout_town_city; ?>';    
</script>
<?php else : ?>
<script type="text/javascript">
	var login_user_selectCountry = '';
	var login_user_checkout_town_city = '';    
</script>
 <?php endif; */ ?>
<?php get_footer(); ?>
              