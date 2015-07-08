/* jQuery(document).ready(function ($) {
	
	$('#wt_logo_upload_button').click(function(){
		wp.media.editor.send.attachment = function(props, attachment){
			$('#wt_options\\[wt_logo_url\\]').val(attachment.url);
		}
		wp.media.editor.open(this);
		return false;
	});
	
	$('#wt_favicon_button').click(function(){
		wp.media.editor.send.attachment = function(props, attachment){
			$('#wt_options\\[wt_favicon\\]').val(attachment.url);
		}
		wp.media.editor.open(this);
		return false;
	});
	
	$('#wt_apple_touch_button').click(function(){
		wp.media.editor.send.attachment = function(props, attachment){
			$('#wt_options\\[wt_apple_touch\\]').val(attachment.url);
		}
		wp.media.editor.open(this);
		return false;
	});
	
	$('#wt_bg_upload_button').click(function(){
		wp.media.editor.send.attachment = function(props, attachment){
			$('#wt_options\\[wt_custom_bg\\]').val(attachment.url);
		}
		wp.media.editor.open(this);
		return false;
	});
	
	$('#wt_meta_post_bg_color_button').click(function(){
		wp.media.editor.send.attachment = function(props, attachment){
			$('#wt_options\\[wt_meta_post_bg_img\\]').val(attachment.url);
		}
		wp.media.editor.open(this);
		return false;
	});
	
	$('#wt_menu_item1_img_button').click(function(){
		wp.media.editor.send.attachment = function(props, attachment){
			$('#wt_options\\[wt_menu_item1_img\\]').val(attachment.url);
		}
		wp.media.editor.open(this);
		return false;
	});
	
	$('#wt_menu_item2_img_button').click(function(){
		wp.media.editor.send.attachment = function(props, attachment){
			$('#wt_options\\[wt_menu_item2_img\\]').val(attachment.url);
		}
		wp.media.editor.open(this);
		return false;
	});
	
	$('#wt_menu_item3_img_button').click(function(){
		wp.media.editor.send.attachment = function(props, attachment){
			$('#wt_options\\[wt_menu_item3_img\\]').val(attachment.url);
		}
		wp.media.editor.open(this);
		return false;
	});
	
	$('#wt_menu_item4_img_button').click(function(){
		wp.media.editor.send.attachment = function(props, attachment){
			$('#wt_options\\[wt_menu_item4_img\\]').val(attachment.url);
		}
		wp.media.editor.open(this);
		return false;
	});
	
	$('#wt_menu_item5_img_button').click(function(){
		wp.media.editor.send.attachment = function(props, attachment){
			$('#wt_options\\[wt_menu_item5_img\\]').val(attachment.url);
		}
		wp.media.editor.open(this);
		return false;
	});
		
}); */


jQuery(document).ready(function($){
	
	var fp_uploader;
	
	$('.field').on('click','.upload_image_button',function(e){
		e.preventDefault();
		
		form_field = jQuery(this).prev('input');
		
		if (fp_uploader) {
            fp_uploader.open();
            return;
        }
		
		fp_uploader = wp.media.frames.file_frame = wp.media({
			library: {
				type: 'image'
			},
			multiple: false
		});
	
		
		fp_uploader.on('select', function() {
			attachment = fp_uploader.state().get('selection').first().toJSON();
				var thumbnail_url = attachment.url;
				
				if (thumbnail_url != ''){
					form_field.val(thumbnail_url);
				}
		});
	
		fp_uploader.open();
		
	});	
	
	
});