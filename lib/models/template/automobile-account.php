<?php
 /*Template Name: checkout
 */

 //$automobile_options = get_option('automobile_options');
get_header(); 
?>
<script>
function signIn(){
	$("#signUp").hide();
	$("#signIn").show();
}
function signUp(){	
	$("#signIn").hide();
	$("#signUp").show();
}
function iamAgree(STATUS){	
	if(STATUS == 'yes'){		
		$('#signUp #t_and_c').val(STATUS);
	}	
}

</script>

<div class="container">

<div class="row">
<?php if ( !is_user_logged_in() ) : ?>
    <div id="signUp" class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
        <form role="form">
            <h2>Please Sign Up <small>It's free and always will be.</small></h2>
			<div id="signMess"></div>
            <hr class="colorgraph">
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="form-group">
                        <input type="text" name="first_name" id="first_name" class="form-control input-lg" placeholder="First Name" tabindex="1">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="form-group">
                        <input type="text" name="last_name" id="last_name" class="form-control input-lg" placeholder="Last Name" tabindex="2">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <input type="text" name="user_name" id="user_name" class="form-control input-lg" placeholder="Username" tabindex="3">
            </div>
            <div class="form-group">
                <input type="email" name="user_email" id="user_email" class="form-control input-lg" placeholder="Email Address" tabindex="4">
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="form-group">
                        <input type="password" name="password" id="password" class="form-control input-lg" placeholder="Password" tabindex="5">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="form-group">
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control input-lg" placeholder="Confirm Password" tabindex="6">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-4 col-sm-3 col-md-3">
                    <span class="button-checkbox">
                        <button type="button" class="btn" data-color="info" tabindex="7" onclick="iamAgree('yes')">I Agree</button>
                        <input type="hidden" name="t_and_c" id="t_and_c" class="" value="no">
                    </span>
                </div>
                <div class="col-xs-8 col-sm-9 col-md-9">
                     By clicking <strong class="label label-primary">Register</strong>, you agree to the <a href="#" data-toggle="modal" data-target="#t_and_c_m">Terms and Conditions</a> set out by this site, including our Cookie Use.
                </div>
            </div>

            <hr class="colorgraph">
            <div class="row">
			<input type="hidden" name="regInfo" id="regInfo" value="pass"/>
			<input type="hidden" name="regStatus" id="regStatus" value="memberRegistration"/>
                <div class="col-xs-12 col-md-6"><input id="user_registration" name="register" type="submit" value="Register" class="btn btn-primary btn-block btn-lg" tabindex="7"></div>
                <div class="col-xs-12 col-md-6"><a href="javascript:void(0)" onclick="signIn()" class="btn btn-success btn-block btn-lg">Sign In</a></div>
            </div>
        </form>
    </div>
	<div id="signIn" style="display:none;" class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
        <form role="form" autocomplete="off">
            <h2>Please Sign In</h2>
			<div id="loginMess"></div>
            <hr class="colorgraph">
            
            <div class="form-group">
				<input type="text" name="username" id="username" class="form-control input-lg" value="" placeholder="Username" tabindex="1" autocomplete="off">
            </div>
            <div class="form-group">
                <input type="password" name="password" id="password" class="form-control input-lg" value="" placeholder="******" tabindex="2" autocomplete="off">
            </div>    
            

            <hr class="colorgraph">
            <div class="row">
                <div class="col-xs-12 col-md-6"><a href="javascript:void(0)" onclick="signUp()" class="btn btn-primary btn-block btn-lg" tabindex="7">Register</a></div>
                <div class="col-xs-12 col-md-6"><a href="javascript:void(0)" id="loginSubmit" class="btn btn-success btn-block btn-lg">Sign In</a></div>
            </div>
			<?php wp_nonce_field( 'ajax-login-nonce', 'security' ); ?>
        </form>
    </div>
	<?php else : 
	$userId = get_current_user_id();
	$user_info = get_userdata($userId);
	echo $userEmail = 'Email : '.$user_info->data->user_email;
	echo '<br>';
	echo $display_name = 'Full Name : '.$user_info->data->display_name;
	
	
	?>
	<p class="log_out">
		<a href="<?php echo wp_logout_url( get_permalink() ); ?>">Log Out</a>
	</p>
	<?php endif; ?>
</div>
<!-- Modal -->
<div class="modal fade" id="t_and_c_m" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">�</button>
                <h4 class="modal-title" id="myModalLabel">Terms & Conditions</h4>
            </div>
            <div class="modal-body">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="iamAgree('yes')" class="btn btn-primary" data-dismiss="modal">I Agree</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>
<?php get_footer(); ?>
