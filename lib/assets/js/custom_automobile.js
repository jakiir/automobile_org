jQuery( function( $ ) {	
	/*var element = document.getElementById('automobile_place_order');
		if (element != null && login_user_selectCountry != '' && login_user_checkout_town_city != '') {
			get_state_city(login_user_selectCountry, login_user_checkout_town_city);
		}*/

    $( document ).on( 'click', '#inquiry_submit', function() {
        var $thisbutton = $( this );
        var enquiry_msg = $('#enquiry_msg');

        var your_name = $('#your_name');
        if (your_name.val()==null || your_name.val()=="")
          {
                enquiry_msg.html('<span class="error">Name is required!</span>');
                your_name.focus();
                your_name.select();
                return false;
          } else {
            enquiry_msg.html('');
          }

        var email_address = $('#email_address');
        if (email_address.val()==null || email_address.val()=="")
          {
                enquiry_msg.html('<span class="error">Email is required!</span>');
                email_address.focus();
                email_address.select();
                return false;
          } else {
            enquiry_msg.html('');
          }
          if(!IsEmail(email_address.val())){
                enquiry_msg.html('<span class="error">Email is not valid!</span>');
                email_address.focus();
                email_address.select();
                return false;
          }else {
            enquiry_msg.html('');
          }

        var inquiry_parts = $('#inquiry_parts');

        var product_inquiry = $('textarea#product_inquiry');
        if (product_inquiry.val()==null || product_inquiry.val()=="")
          {
                enquiry_msg.html('<span class="error">Inquiry is required!</span>');
                product_inquiry.focus();
                product_inquiry.select();
                return false;
          } else {
            enquiry_msg.html('');
          }

          $thisbutton.parent().addClass('addToCartLodding');
          enquiry_msg.html('');
          $.ajax({
          type: 'POST',
          url: adminUrl.ajaxurl,
          data: {
          action: 'inquiry_send',
          your_name:your_name.val(),
          email_address:email_address.val(),
          inquiry_parts:inquiry_parts.val(),
          product_inquiry:product_inquiry.val()
          },
          success: function(data){
            $thisbutton.parent().removeClass('addToCartLodding');
            enquiry_msg.html('');
            console.log(data);
            var obj = jQuery.parseJSON(data);
            if(obj['success'] == true){
                enquiry_msg.html('<span class="success">'+obj['mess']+'</span>');
            } else {
                enquiry_msg.html('<span class="error">'+obj['mess']+'</span>');
            }
          },
          error: function(errorThrown){
            alert(errorThrown);
          }

          });

        return false;
    });
	
	$( document ).on( 'change', '#product_qty_single', function() {
		var thisItem = $( this );
		var thisVal = parseInt($( this ).val());
		$('.auto_mobile_add_to_cart').attr('data-quantity', thisVal);
		var item_price = parseInt(thisItem.attr('data-item_price'));		
		$('.auto_mobile_add_to_cart').attr('data-item_price', thisVal*item_price);
		
	});

    $( document ).on( 'click', '.auto_mobile_add_to_cart', function() {
        var $thisbutton = $( this );
		
		var product_qty_single = document.getElementById('product_qty_single');
		if (product_qty_single != null) {
			var product_qty = $('#product_qty_single').val();
			if (product_qty == null || product_qty == 0){
				alert('Product quantity is empty. Please, buy another product.');
				return false;
			}
		}
		
        //$('.addToCartLodding').removeClass( 'addToCartLodding' );
        $thisbutton.parent().addClass('addToCartLodding');
        var item_id = $thisbutton.attr('data-item_id');
        var item_sku = $thisbutton.attr('data-item_sku');
        var quantity = $thisbutton.attr('data-quantity');
		
        var item_price = $thisbutton.attr('data-item_price');

        /*var total_qty = parseInt($('.cart_item').attr('data-qty'));
        var now_qty = total_qty + parseInt(quantity);
        var total_price = parseInt($('.cart_price').attr('data-price'));
        var now_price = total_price + parseInt(item_price);*/

        $.ajax({
          type: 'POST',
          url: adminUrl.ajaxurl,
          data: {
          action: 'autoMobileAddToCart',
          itemId:item_id,
		  addtocartType: 'multiple',
          itemSku:item_sku,
          quantity:quantity,
          itemPrice:item_price
          },
          success: function(data){
			  $thisbutton.parent().removeClass('addToCartLodding');
			var obj = jQuery.parseJSON(data);			 
            if(obj['success'] == true){              
              $('.cart_item').attr('data-qty', obj['quantity']).html(obj['quantity']);
              $('.cart_price').attr('data-price', obj['totalPrice']).html('$' + obj['totalPrice']);
              $('.view_cart').show();
			}
          },
          error: function(errorThrown){
            alert(errorThrown);
          }

          });

        return false;

    });
	
	
	$( document ).on( 'click', '.add_to_cart_one_by_one', function() {
        var $thisbutton = $( this );
		
        //$('.addToCartLodding').removeClass( 'addToCartLodding' );
        $thisbutton.parent().addClass('addToCartLodding');
        var item_id = $thisbutton.attr('data-item_id');
        var item_sku = $thisbutton.attr('data-item_sku');
        var quantity = $thisbutton.attr('data-quantity');
		
        var item_price = $thisbutton.attr('data-item_price');

        /*var total_qty = parseInt($('.cart_item').attr('data-qty'));
        var now_qty = total_qty + parseInt(quantity);
        var total_price = parseInt($('.cart_price').attr('data-price'));
        var now_price = total_price + parseInt(item_price);*/

        $.ajax({
          type: 'POST',
          url: adminUrl.ajaxurl,
          data: {
          action: 'autoMobileAddToCart',
          itemId:item_id,
		  addtocartType: 'oneby',
          itemSku:item_sku,
          quantity:quantity,
          itemPrice:item_price
          },
          success: function(data){
			  $thisbutton.parent().removeClass('addToCartLodding');
			var obj = jQuery.parseJSON(data);			 
            if(obj['success'] == true){              
              $('.cart_item').attr('data-qty', obj['quantity']).html(obj['quantity']);
              $('.cart_price').attr('data-price', obj['totalPrice']).html('$' + obj['totalPrice']);
              $('.view_cart').show();
			}
          },
          error: function(errorThrown){
            alert(errorThrown);
          }

          });

        return false;

    });
	
	$( document ).on( 'click', '.itemUpdateBtn', function() {		
        var $thisbutton = $( this );
		var incr_id = $thisbutton.attr('data-incr_id');
		var product_qty_single = document.getElementById('item_quantity'+incr_id);
		if (product_qty_single != null) {
			var product_qty = $('#item_quantity'+incr_id).val();
			if (product_qty == null || product_qty == 0){
				alert('Product quantity is empty. Please, buy another product.');
				return false;
			}
		}
		
        $thisbutton.parent().addClass('addToCartLodding');
        var item_id = $thisbutton.attr('data-item_id');
        var item_sku = $thisbutton.attr('data-item_sku');		
        var quantity = parseInt($('#item_quantity'+incr_id).val());
		
        var item_price_sub = parseInt($thisbutton.attr('data-item_price'));
		
		var item_price = item_price_sub*quantity;

        //var total_qty = parseInt($('.cart_item').attr('data-qty'));
        //var now_qty = total_qty + parseInt(quantity);

        //var total_price = parseInt($('.cart_price').attr('data-price'));
        //var now_price = total_price + parseInt(item_price);

        $.ajax({
          type: 'POST',
          url: adminUrl.ajaxurl,
          data: {
          action: 'autoMobileUpdateCart',
          itemId:item_id,		  
          itemSku:item_sku,
          quantity:quantity,
          itemPrice:item_price
          },
          success: function(data){
			  $thisbutton.parent().removeClass('addToCartLodding');
			var obj = jQuery.parseJSON(data);			
            if(obj['success'] == true){ 
				location.reload();              
			}
          },
          error: function(errorThrown){
            alert(errorThrown);
          }

          });

        return false;

    });


    $( document ).on( 'change', '#txt_automobile_year_dropdown', function() {
        var $thisbutton = $( this );
        var thisText = $thisbutton.find("option:selected").text();

        var thisValue = $thisbutton.val();
        var txt_automobile_make_dropdown = $('#txt_automobile_make_dropdown');
        var txt_automobile_model_dropdown = $('#txt_automobile_model_dropdown');
        $.ajax({
          type: 'POST',
          url: adminUrl.ajaxurl,
          data: {
          action: 'autoMobileMakeNModel',
            automobile_year:thisValue
          },
          success: function(data){
              //console.log(data);
            var obj = jQuery.parseJSON(data);
            if(obj['success'] == true){
                var value_dum = '';
                txt_automobile_make_dropdown.prop('disabled', false);
                txt_automobile_make_dropdown.html('');
                txt_automobile_make_dropdown.append('<option value="' + value_dum + '">Show Make for '+thisText+'</option>');
                for (var prop in obj['make']) {
                    txt_automobile_make_dropdown.append('<option value="'+obj['make'][prop]+'">' + obj['make_val'][prop] + '</option>');
                }

                txt_automobile_model_dropdown.html('');
                txt_automobile_model_dropdown.append('<option value="' + value_dum + '">Show Model for '+thisText+'</option>');
                for (var prop in obj['model']) {
                    txt_automobile_model_dropdown.append('<option value="'+obj['model'][prop]+'">' + obj['model_val'][prop] + '</option>');
                }

            }
          },
          error: function(errorThrown){
            alert(errorThrown);
          }

          });

        return false;

    });
    $( document ).on( 'change', '#txt_automobile_make_dropdown', function() {
        var $thisbutton = $( this );
        var txt_automobile_model_dropdown = $('#txt_automobile_model_dropdown');
        txt_automobile_model_dropdown.prop('disabled', false);
    });
	
	$( document ).on( 'click', '#loginSubmit', function() {
        var $thisbutton = $( this );
		var loginMess = $('#signIn #loginMess');
		var security = $('#signIn #security');
		var username = $('#signIn #username');		
        if (username.val()==null || username.val()=="")
          {
                loginMess.html('<span class="error">Username is required!</span>');
                username.focus();
                username.select();
                return false;
          } else {
            loginMess.html('');
          }
		  
		  var password = $('#signIn #password');
		  if (password.val()==null || password.val()=="")
          {
                loginMess.html('<span class="error">Password is required!</span>');
                password.focus();
                password.select();
                return false;
          } else {
            loginMess.html('');
          }
	
        $.ajax({
          type: 'POST',
          url: adminUrl.ajaxurl,
          data: {
          action: 'user_login_form',
          username:username.val(),
          password:password.val(),
		  security: security.val()
          },
          success: function(data){
			  loginMess.html('');
			  var obj = jQuery.parseJSON(data);
			  if (obj['loggedin'] == true){
					loginMess.html(obj['message']);				  
					location.reload();
              } else {
				loginMess.html('<span class="error">'+ obj['message'] +'</span>');
			  }
          },
          error: function(errorThrown){
            alert(errorThrown);
          }

          });

        return false;

    });
	
	$( document ).on( 'click', '#user_registration', function() {
        var $thisbutton = $( this );
		
		var signMess = $('#signUp #signMess');
		var first_name = $('#signUp #first_name');
		var last_name = $('#signUp #last_name');
		var user_name = $('#signUp #user_name');
		var user_email = $('#signUp #user_email');
		var password = $('#signUp #password');
		var password_confirmation = $('#signUp #password_confirmation');
		var t_and_c = $('#signUp #t_and_c');
		var regInfo = $('#signUp #regInfo');
		var regStatus = $('#signUp #regStatus');	
		
        if (user_name.val()==null || user_name.val()=="")
          {
                signMess.html('<span class="error">Username is required!</span>');
                user_name.focus();
                user_name.select();
                return false;
          } else {
            signMess.html('');
          }	 

		if (user_email.val()==null || user_email.val()=="")
          {
                signMess.html('<span class="error">Email is required!</span>');
                user_email.focus();
                user_email.select();
                return false;
          } else {
				signMess.html('');
          }
          if(!IsEmail(user_email.val())){
                signMess.html('<span class="error">Email is not valid!</span>');
                user_email.focus();
                user_email.select();
                return false;
          }else {
            signMess.html('');
          }
		  
		  if (password.val()==null || password.val()=="")
          {
                signMess.html('<span class="error">Password is required!</span>');
                password.focus();
                password.select();
                return false;
          } else {
            signMess.html('');
          }
		  
		if (password.val().length < 6) {
			signMess.html('<span class="error">Password is 6 disit must!</span>');
			password.focus();
			password.select();
			return false;
		} else {
			signMess.html('');
		}
		
		if (password_confirmation.val()==null || password_confirmation.val()=="")
          {
                signMess.html('<span class="error">Confirm password is required!</span>');
                password_confirmation.focus();
                password_confirmation.select();
                return false;
          } else {
            signMess.html('');
          }
		  
		if (password_confirmation.val().length < 6) {
			signMess.html('<span class="error">Confirm password is 6 disit must!</span>');
			password_confirmation.focus();
			password_confirmation.select();
			return false;
		} else {
			signMess.html('');
		}
		
		if (password.val() != password_confirmation.val())
          {
                signMess.html('<span class="error">Password mis-match!</span>');                
                return false;
          } else {
            signMess.html('');
          }
        
		if (t_and_c.val()== 'no' || t_and_c.val()=="")
          {
                signMess.html('<span class="error">Please, select agree button.</span>');                
                return false;
          } else {
            signMess.html('');
          }
		
	
        $.ajax({
          type: 'POST',
          url: adminUrl.ajaxurl,
          data: {
          action: 'user_regi_form',
          first_name:first_name.val(),
          last_name:last_name.val(),
		  user_name: user_name.val(),
		  user_email:user_email.val(),
		  password: password.val(),
		  password_confirmation: password_confirmation.val(),
		  t_and_c: t_and_c.val(),
		  regInfo: regInfo.val(),
		  regStatus: regStatus.val()
          },
          success: function(data){
			  signMess.html('');
			  var obj = jQuery.parseJSON(data);
			  if (obj['success'] == true){									  
					location.reload();
              } else {
				signMess.html('<span class="error">'+ obj['message'] +'</span>');
			  }
          },
          error: function(errorThrown){
            alert(errorThrown);
          }

          });

        return false;

    });


	/* Product Item remove */
    $( document ).on( 'click', '.itemRemoveBtn', function() {
        var $thisbutton = $( this );
        $thisbutton.parent().addClass('addToCartLodding');
        var item_id = $thisbutton.attr('data-item_id');
        var item_key = $thisbutton.attr('data-item_key');

        $.ajax({
          type: 'POST',
          url: adminUrl.ajaxurl,
          data: {
          action: 'autoMobileRemoveCart',
          itemId:item_id,
          item_key:item_key
          },
          success: function(){
              //console.log(data);
              $thisbutton.parent().removeClass('addToCartLodding');
              location.reload();
          },
          error: function(errorThrown){
            alert(errorThrown);
          }

          });

        return false;

    });

    /*$( document ).on( 'change', '#selectCountry', function() {
        var $thisbutton = $( this );
        var $thisVal = $thisbutton.val();
        //alert($thisbutton.val());
        var checkout_town_city = $('#checkout_town_city');
        var checkout_town_citi = $('.checkout_town_city');
        $.ajax({
          type: 'POST',
          url: adminUrl.ajaxurl,
          data: {
          action: 'get_country_state',
          country:$thisVal
          },
          success: function(data){
            var obj = jQuery.parseJSON(data);
            if(obj['success'] == true){
                checkout_town_citi.html('');
                checkout_town_city.show();
                var value_dum = '';
                checkout_town_city.html('');
                checkout_town_city.append('<option value="' + value_dum + '">Select One</option>');
                for (var prop in obj[$thisVal]) {
                    $('#checkout_town_city').append('<option value="'+prop+'">' + obj[$thisVal][prop] + '</option>');
                }
            } else {
                checkout_town_city.hide();
                checkout_town_citi.html('').html('<input type="test" id="town_city_text" name="town_city_text" class="form-control"/>');
            }
          },
          error: function(errorThrown){
            alert(errorThrown);
          }
          });

    return false;
    });*/

    $( document ).on( 'click', '#automobile_place_order', function() {
        var $thisbutton = $( this );
        var data_logged = $thisbutton.attr('data-logged');
        var checkout_mess = $('#checkout_mess');
		
		var checkout_first_name = $('#checkout_first_name');
        if (checkout_first_name.val()==null || checkout_first_name.val()=="")
          {
            checkout_mess.html('<span class="error">First Name is required!</span>');
            checkout_first_name.focus();
            checkout_first_name.select();
            return false;
          } else {
            checkout_mess.html('');
          }
        var checkout_last_name = $('#checkout_last_name');
        if (checkout_last_name.val()==null || checkout_last_name.val()=="")
          {
            checkout_mess.html('<span class="error">Last Name is required!</span>');
            checkout_last_name.focus();
            checkout_last_name.select();
            return false;
          } else {
            checkout_mess.html('');
          }

        var checkout_email = $('#checkout_email');
        if (checkout_email.val()==null || checkout_email.val()=="")
          {
                checkout_mess.html('<span class="error">Email is required!</span>');
                checkout_email.focus();
                checkout_email.select();
                return false;
          } else {
            checkout_mess.html('');
          }
          if(!IsEmail(checkout_email.val())){
                checkout_mess.html('<span class="error">Email is not valid!</span>');
                checkout_email.focus();
                checkout_email.select();
                return false;
          }else {
            checkout_mess.html('');
          }

        var checkout_password = $('#checkout_password');
        if(data_logged =='no') {
            if (checkout_password.val() == null || checkout_password.val() == "") {
                checkout_mess.html('<span class="error">Password is required!</span>');
                checkout_password.focus();
                checkout_password.select();
                return false;
            } else {
                checkout_mess.html('');
            }
            if (checkout_password.val().length < 6) {
                checkout_mess.html('<span class="error">Password is 6 disit must!</span>');
                checkout_password.focus();
                checkout_password.select();
                return false;
            } else {
                checkout_mess.html('');
            }
        }
        if(data_logged =='yes'){
            if (checkout_password.val() != "") {
                if (checkout_password.val().length < 6) {
                    checkout_mess.html('<span class="error">Password is 6 disit must!</span>');
                    checkout_password.focus();
                    checkout_password.select();
                    return false;
                } else {
                    checkout_mess.html('');
                }
            }
        }
        
        var checkout_address = $('#checkout_address');
        if (checkout_address.val()==null || checkout_address.val()=="")
          {
            checkout_mess.html('<span class="error">Address is required!</span>');
            checkout_address.focus();
            checkout_address.select();
            return false;
          } else {
            checkout_mess.html('');
          }
        
		var checkout_city = $('#checkout_city');
            if (checkout_city.val()==null || checkout_city.val()=="")
              {
                checkout_mess.html('<span class="error">City is required!</span>');
                checkout_city.focus();
                checkout_city.select();
                return false;
              } else {
                checkout_mess.html('');
              }
		var checkout_state = $('#checkout_state');
		if (checkout_state.val()==null || checkout_state.val()=="")
		  {
			checkout_mess.html('<span class="error">State is required!</span>');
			checkout_state.focus();
			checkout_state.select();
			return false;
		  } else {
			checkout_mess.html('');
		  }
        
        var checkout_postcode = $('#checkout_postcode');
        if (checkout_postcode.val()==null || checkout_postcode.val()=="")
          {
            checkout_mess.html('<span class="error">Post code is required!</span>');
            checkout_postcode.focus();
            checkout_postcode.select();
            return false;
          } else {
            checkout_mess.html('');
          }
        
        var checkout_notes = $('#checkout_notes');
        var product_ids = getValues('product_ids');
        var product_names = getValues('product_names');
        var product_item_prices = getValues('product_item_prices');
        var product_total_price = getValues('product_total_price');
        var product_quantity = getValues('product_quantity');
        var product_shipping = getValues('product_shipping');

        var subTotalPrice = $('#subTotalPrice');
        var productTotalPrice = $('#productTotalPrice');
        var productTotalItem = $('#productTotalItem');

        $.ajax({
          type: 'POST',
          url: adminUrl.ajaxurl,
          data: {
          action: 'add_customer_info',
            checkout_email : checkout_email.val(),
            checkout_password : checkout_password.val(),
            checkout_first_name : checkout_first_name.val(),
            checkout_last_name : checkout_last_name.val(),
            checkout_address : checkout_address.val(),            
            selectCountry : 'US',
            checkout_postcode : checkout_postcode.val(),
            checkout_city : checkout_city.val(),
			checkout_state : checkout_state.val(),
            checkout_notes    : checkout_notes.val(),
            subTotalPrice 	: subTotalPrice.val(),
            productTotalPrice : productTotalPrice.val(),
            productTotalItem : productTotalItem.val(),
            product_ids : product_ids,
            product_names : product_names,
            product_item_prices : product_item_prices,
            product_total_price : product_total_price,
            product_quantity : product_quantity,
            product_shipping : product_shipping,
            registrationId : $thisbutton.attr('id')
          },
          success: function(data){
            var obj = jQuery.parseJSON(data);
            //console.log(data);
            if(obj['success'] == true && obj['post_id'] !=''){
                setTimeout("document.frm_payment_method.submit()", 2);
            } else {
                checkout_mess.html('<span class="error">'+obj['mess']+'</span>');
            }

          },
          error: function(errorThrown){
            alert(errorThrown);
          }

          });

    return false;
    });
});

function IsEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}

function check_number(txtMobId) {
 reg = /[^0-9.,]/g;
 txtMobId.value =  txtMobId.value.replace(reg,"");
}

function getValues(className){
    var tempValues = {};
    var i = 0;
    $('.' + className).each(function(){
        var th= $(this);
        tempValues[i] = th.val();
        i++;
    });
    return tempValues;
}

/*function get_state_city(VALUE,CITY) {
    var $thisVal = VALUE;
    var checkout_town_city = $('#checkout_town_city');
    var checkout_town_citi = $('.checkout_town_city');
    $.ajax({
        type: 'POST',
        url: adminUrl.ajaxurl,
        data: {
            action: 'get_country_state',
            country:$thisVal
        },
        success: function(data){
            var obj = jQuery.parseJSON(data);
            if(obj['success'] == true){
                checkout_town_citi.html('');
                checkout_town_city.show();
                var value_dum = '';
                checkout_town_city.html('');
                checkout_town_city.append('<option value="' + value_dum + '">Select One</option>');
                for (var prop in obj[$thisVal]) {
                    var $marked = ( prop == CITY ? 'selected="selected"' : null );
                    $('#checkout_town_city').append('<option '+$marked+' value="'+prop+'">' + obj[$thisVal][prop] + '</option>');
                }
            } else {
                checkout_town_city.hide();
                checkout_town_citi.html('').html('<input type="test" id="town_city_text" name="town_city_text" class="form-control"/>');
            }
        },
        error: function(errorThrown){
            alert(errorThrown);
        }
    });

    return false;
}*/

