<?php

/**
 * Post meta API
 * get_label()
 * get_field()
 * get_duplicate_field()
 * get_group()
 * get_duplicate_group()
 * -------------------------
 * Out put with label and field valu in a given template
 * 
 * get_field_tpl()
 * get_duplicate_field_tpl()
 * get_group_tpl()
 * get_duplicate_group_tpl()
 * 
 * get_image()
 * get_audio()
 * get_video()
 * preview()
 */

/**
 * get_label($metaKey)
 * 
 * @$metaKey for the field 
 * */
function get_label($metaKey){
    global $postMeta;
    
	return $postMeta->get_label($metaKey);
    
}


function get_field($metaKey,$groupIndex=1,$fieldIndex=1,$post_id=null){
    
    global $postMeta;
    
	return $postMeta->get_field($metaKey,$groupIndex,$fieldIndex,$post_id);
    
}


function get_duplicate_field($metaKey,$groupIndex=1,$post_id=null){
    
    global $postMeta;
    
	return $postMeta->get_duplicate_field($metaKey,$groupIndex,$post_id);
}


function get_group($metaKey,$groupIndex=1,$post_id=null){
    
    global $postMeta;
    
	return $postMeta->get_group($metaKey,$groupIndex,$post_id);
    
}

function get_duplicate_group($metaKey,$post_id=null){
    
     global $postMeta;
    
	return $postMeta->get_duplicate_group($metaKey,$post_id);
}

function get_field_tpl($metaKey,$groupIndex=1,$fieldIndex=1,$post_id=null){
    
    global $postMeta;
    
	return $postMeta->get_field_tpl($metaKey,$groupIndex,$fieldIndex,$post_id);
}

function get_duplicate_field_tpl($metaKey,$groupIndex=1,$post_id=null){
    
    global $postMeta;
    
	return $postMeta->get_duplicate_field_tpl($metaKey,$groupIndex,$post_id);
}

function get_group_tpl($metaKey,$groupIndex=1,$post_id=null){
    
    global $postMeta;
    
	return $postMeta->get_group_tpl($metaKey,$groupIndex,$post_id);   

}

function get_duplicate_group_tpl($metaKey,$post_id=null){
    
    global $postMeta;
    
	return $postMeta->get_duplicate_group_tpl($metaKey,$post_id=null);
    
}


function get_image($metaKey,$groupIndex=1,$fieldIndex=1,$parameter=array(),$attr=array(),$post_id=null){
    
    global $postMeta;
    
	return $postMeta->get_image($metaKey,$groupIndex,$fieldIndex,$parameter,$attr,$post_id);
}


function get_audio($metaKey,$groupIndex=1,$fieldIndex=1,$post_id=null){
    
    global $postMeta;
    
	return $postMeta->get_audio($metaKey,$groupIndex,$fieldIndex,$post_id);
}

function get_video($metaKey,$groupIndex=1,$fieldIndex=1,$post_id=null){
    
    global $postMeta;
    
	return $postMeta->get_video($metaKey,$groupIndex,$fieldIndex,$post_id);
}


function preview($url,$type='image',$attr=array('thumb'=>true)){

    global $postMeta;
    
	return $postMeta->preview($url,$type,$attr);
}

?>