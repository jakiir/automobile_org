<?php
    //ShortCode
    add_shortcode('team', 'team_view');
    function team_view( $atts ) {
   $options = get_option('team_options');

    $bd_items=$options['items'];

    if($bd_items!=''){
        $items = $options['items'];
     }else{
          $items='4';
     }


    $bd_navigation=$options['navigation'];
     if($bd_navigation!=''){
        $navigation = $options['navigation'];
     }else{
           $navigation='true';
     }


    $bd_pagination=$options['pagination'];
     if($bd_pagination!=''){
        $pagination = $options['pagination'];
     }else{
          $pagination='true';
     }



    $bd_responsive=$options['responsive'];
    if($bd_responsive!=''){
        $responsive = $options['responsive'];
     }else{
          $responsive='true';
     }
    $bd_autoHeight=$options['autoHeight'];
    if($bd_autoHeight!=''){
        $autoHeight = $options['autoHeight'];
     }else{
          $autoHeight='true';
     }


    $bd_itemsDesktop_width=$options['itemsDesktop_width'];
    $bd_itemsDesktop_item=$options['itemsDesktop_width'];
        if($bd_itemsDesktop_width!=''){
            $itemsDesktop_width = $options['itemsDesktop_width'];
         }else{
              $itemsDesktop_width='1000';
         }
        if($bd_itemsDesktop_item!=''){
        $itemsDesktop_item = $options['itemsDesktop_item'];
         }else{
              $itemsDesktop_item='4';
         }


    $bd_ItemsDesktopSmall_width=$options['ItemsDesktopSmall_width'];
    $bd_ItemsDesktopSmall_item=$options['ItemsDesktopSmall_item'];
        if($bd_ItemsDesktopSmall_width!=''){
            $ItemsDesktopSmall_width = $options['ItemsDesktopSmall_width'];
         }else{
              $ItemsDesktopSmall_width='900';
         }
         if($bd_ItemsDesktopSmall_item!=''){
            $ItemsDesktopSmall_item = $options['ItemsDesktopSmall_item'];
         }else{
              $ItemsDesktopSmall_item='4';
         }



    $bd_itemsTablet_width=$options['itemsTablet_width'];
    $bd_itemsTablet_item=$options['itemsTablet_item'];
        if($bd_itemsTablet_width!=''){
            $itemsTablet_width = $options['itemsTablet_width'];
         }else{
              $itemsTablet_width='768';
         }
         if($bd_itemsTablet_item!=''){
            $itemsTablet_item = $options['itemsTablet_item'];
         }else{
              $itemsTablet_item='3';
         }

    $bd_itemsMobile_width=$options['itemsMobile_width'];
    $itemsMobile_item=$options['itemsMobile_item'];
        if($bd_itemsMobile_width!=''){
            $itemsMobile_width = $options['itemsMobile_width'];
         }else{
              $itemsMobile_width='460';
         }
         if($bd_itemsMobile_item!=''){
            $itemsMobile_item = $options['itemsMobile_item'];
         }else{
              $itemsMobile_item='1';
         }


    $bd_singleItem=$options['singleItem'];
    if($bd_singleItem!=''){
        $singleItem = $options['singleItem'];
     }else{
          $singleItem='false';
     }


    $bd_slideSpeed=$options['slideSpeed'];
    if($bd_slideSpeed!=''){
        $slideSpeed = $options['slideSpeed'];
     }else{
          $slideSpeed='true';
     }


    $bd_paginationSpeed=$options['paginationSpeed'];
    if($bd_paginationSpeed!=''){
        $paginationSpeed = $options['paginationSpeed'];
     }else{
          $paginationSpeed='true';
     }


    $bd_autoPlay=$options['autoPlay'];
    if($bd_autoPlay!=''){
        $autoPlay = $options['autoPlay'];
     }else{
          $autoPlay='true';
     }


    $bd_stopOnHover=$options['stopOnHover'];
    if($bd_stopOnHover!=''){
        $stopOnHover = $options['stopOnHover'];
     }else{
          $stopOnHover='true';
     }


  extract( shortcode_atts( array( 'limit' => -1),$atts ) );
        global $paged;
            $temp = $my_query;
            $my_query = null;
            $txt_limit=20;
            $my_query = new WP_Query(
                array(
                    'posts_per_page' => $limit,
                    post_type => 'your_team',
                    order => 'ASC',
                    orderby =>'menu_order',
                    'paged' => $paged,
                )
); ?>
    <h2 class="team-title">Your Team</h2>
        <div id="team-carousel" class="owl-carousel owl-theme text-center team-carousel">
        <?php  while ($my_query->have_posts()) : $my_query->the_post(); ?>

         <?php
            $pid=$post->ID;
            $facebook= get_post_meta(get_the_ID($post->ID), 'facebook', true);
            $twitter= get_post_meta(get_the_ID($post->ID), 'twitter', true);
            $google_plus= get_post_meta(get_the_ID($post->ID), 'google_plus', true);
            $linkedin= get_post_meta(get_the_ID($post->ID), 'linkedin', true);
            $position= get_post_meta(get_the_ID($post->ID), 'position', true);
            $img_src=getFeaturedImage($post->ID);
            $post_title= get_the_title(get_the_ID($post->ID));
            $content = get_the_content(get_the_ID($post->ID));
            $trimmed_content = wp_trim_words( $content,$txt_limit);
            $img_src=getFeaturedImage($post->ID);
            if( empty( $img_src ) ) {
            $img_src = plugins_url('/team/images/default.png');
            }
            ?>     <div class="item">
		  			<div class="team-wrapper">
						<div class="team-img-wrapper">

							<img alt="" src="<?php echo $img_src; ?>" class="img-circle">
						</div>
						<div class="team-content">
						    <h3 class="name">
						      <?php echo $post_title;?>
						      <span>
						        <?php echo $position; ?>
						      </span>
						    </h3>

								<div class="social-icons">
                                <?php if($facebook!=''){ ?>
									<a href="<?php echo $facebook; ?>"><i class="fa fa-facebook"></i></a>
                                 <?php } ?>
                                 <?php if($twitter!=''){ ?>
										<a href="<?php echo $twitter; ?>"><i class="fa fa-twitter"></i></a>
                                 <?php } ?>
                                 <?php if($google_plus!=''){ ?>
									<a href="<?php echo $google_plus; ?>"><i class="fa fa-google-plus"></i></a>
                                 <?php } ?>
                                 <?php if($linkedin!=''){ ?>
									 <a href="<?php echo $linkedin; ?>"><i class="fa fa-linkedin"></i></a>
                                 <?php } ?>
								</div>

						</div>
					</div><!--/ Team wrapper end -->
				</div><!--/ Item 1 end -->
					<?php  endwhile;  ?>
				</div>

			 <?php
     $my_query = null;
     $my_query = $temp;  // Reset
   ?>

    <link rel="stylesheet" href="<?php echo plugins_url('/team'); ?>/lib/assets/style/style.css" />

    <script src="<?php echo plugins_url('/team'); ?>/lib/assets/js/jquery-1.9.1.min.js"></script>

    <script type='text/javascript' >
    var j = jQuery.noConflict();
    j(document).ready(function() {
    $("#team-carousel").owlCarousel({

    // Most important owl features
    items :<?php echo $items;?>,
    itemsDesktop : [<?php echo $itemsDesktop_width;?>,<?php echo $itemsDesktop_item;?>],
    itemsDesktopSmall : [<?php echo $ItemsDesktopSmall_width;?>,<?php echo $ItemsDesktopSmall_item;?>],
    itemsTablet: [<?php echo $itemsTablet_width;?>,<?php echo $itemsTablet_item;?>],
    itemsMobile : [<?php echo $itemsMobile_width;?>,<?php echo $itemsMobile_item;?>],
    singleItem :  <?php echo $singleItem;?>,

    //Basic Speeds
    slideSpeed : <?php echo $slideSpeed;?>,
    paginationSpeed : <?php echo $paginationSpeed;?>,


    //Autoplay
    autoPlay : <?php echo $autoPlay;?>,
    stopOnHover : <?php echo $stopOnHover;?>,

    // Navigation
    navigation : <?php echo $navigation;?>,

    //Pagination
    pagination : <?php echo $pagination;?>,

    // Responsive
    responsive: <?php echo $responsive;?>,

    navigationText: ["<i class='fa fa-chevron-left'></i>", "<i class='fa fa-chevron-right'></i>"]
    })
});
</script>
     <?php }

       //ShortCode
    add_shortcode('team-one', 'team_view_one');
    function team_view_one( $atts ) {
   $options = get_option('team_options');

    $bd_items=$options['items'];

    if($bd_items!=''){
        $items = $options['items'];
     }else{
          $items='4';
     }


    $bd_navigation=$options['navigation'];
     if($bd_navigation!=''){
        $navigation = $options['navigation'];
     }else{
           $navigation='true';
     }


    $bd_pagination=$options['pagination'];
     if($bd_pagination!=''){
        $pagination = $options['pagination'];
     }else{
          $pagination='true';
     }



    $bd_responsive=$options['responsive'];
    if($bd_responsive!=''){
        $responsive = $options['responsive'];
     }else{
          $responsive='true';
     }
    $bd_autoHeight=$options['autoHeight'];
    if($bd_autoHeight!=''){
        $autoHeight = $options['autoHeight'];
     }else{
          $autoHeight='true';
     }


    $bd_itemsDesktop_width=$options['itemsDesktop_width'];
    $bd_itemsDesktop_item=$options['itemsDesktop_width'];
        if($bd_itemsDesktop_width!=''){
            $itemsDesktop_width = $options['itemsDesktop_width'];
         }else{
              $itemsDesktop_width='1000';
         }
        if($bd_itemsDesktop_item!=''){
        $itemsDesktop_item = $options['itemsDesktop_item'];
         }else{
              $itemsDesktop_item='4';
         }


    $bd_ItemsDesktopSmall_width=$options['ItemsDesktopSmall_width'];
    $bd_ItemsDesktopSmall_item=$options['ItemsDesktopSmall_item'];
        if($bd_ItemsDesktopSmall_width!=''){
            $ItemsDesktopSmall_width = $options['ItemsDesktopSmall_width'];
         }else{
              $ItemsDesktopSmall_width='900';
         }
         if($bd_ItemsDesktopSmall_item!=''){
            $ItemsDesktopSmall_item = $options['ItemsDesktopSmall_item'];
         }else{
              $ItemsDesktopSmall_item='4';
         }



    $bd_itemsTablet_width=$options['itemsTablet_width'];
    $bd_itemsTablet_item=$options['itemsTablet_item'];
        if($bd_itemsTablet_width!=''){
            $itemsTablet_width = $options['itemsTablet_width'];
         }else{
              $itemsTablet_width='768';
         }
         if($bd_itemsTablet_item!=''){
            $itemsTablet_item = $options['itemsTablet_item'];
         }else{
              $itemsTablet_item='3';
         }

    $bd_itemsMobile_width=$options['itemsMobile_width'];
    $itemsMobile_item=$options['itemsMobile_item'];
        if($bd_itemsMobile_width!=''){
            $itemsMobile_width = $options['itemsMobile_width'];
         }else{
              $itemsMobile_width='460';
         }
         if($bd_itemsMobile_item!=''){
            $itemsMobile_item = $options['itemsMobile_item'];
         }else{
              $itemsMobile_item='1';
         }


    $bd_singleItem=$options['singleItem'];
    if($bd_singleItem!=''){
        $singleItem = $options['singleItem'];
     }else{
          $singleItem='false';
     }


    $bd_slideSpeed=$options['slideSpeed'];
    if($bd_slideSpeed!=''){
        $slideSpeed = $options['slideSpeed'];
     }else{
          $slideSpeed='true';
     }


    $bd_paginationSpeed=$options['paginationSpeed'];
    if($bd_paginationSpeed!=''){
        $paginationSpeed = $options['paginationSpeed'];
     }else{
          $paginationSpeed='true';
     }


    $bd_autoPlay=$options['autoPlay'];
    if($bd_autoPlay!=''){
        $autoPlay = $options['autoPlay'];
     }else{
          $autoPlay='true';
     }


    $bd_stopOnHover=$options['stopOnHover'];
    if($bd_stopOnHover!=''){
        $stopOnHover = $options['stopOnHover'];
     }else{
          $stopOnHover='true';
     }


  extract( shortcode_atts( array( 'limit' => -1),$atts ) );
        global $paged;
            $temp = $my_query;
            $my_query = null;
            $txt_limit=20;
            $my_query = new WP_Query(
                array(
                    'posts_per_page' => $limit,
                    post_type => 'your_team',
                    order => 'ASC',
                    orderby =>'menu_order',
                    'paged' => $paged,
                )
); ?>
<h2 class="team-title">Your Team</h2>
        <div id="team-carousel-one" class="owl-carousel owl-theme text-center team-carousel">



        <?php  while ($my_query->have_posts()) : $my_query->the_post(); ?>

         <?php
            $pid=$post->ID;
            $facebook= get_post_meta(get_the_ID($post->ID), 'facebook', true);
            $twitter= get_post_meta(get_the_ID($post->ID), 'twitter', true);
            $google_plus= get_post_meta(get_the_ID($post->ID), 'google_plus', true);
            $linkedin= get_post_meta(get_the_ID($post->ID), 'linkedin', true);
            $position= get_post_meta(get_the_ID($post->ID), 'position', true);
            $img_src=getFeaturedImage($post->ID);
            $post_title= get_the_title(get_the_ID($post->ID));
            $content = get_the_content(get_the_ID($post->ID));
            $trimmed_content = wp_trim_words( $content,$txt_limit);
            $img_src=getFeaturedImage($post->ID);
            if( empty( $img_src ) ) {
            $img_src = plugins_url('/team/images/default.png');
            }
            ?>     <div class="item">
		  			<div class="team-wrapper">
						<div class="team-img-wrapper">
							<div class="team-img-wrapper-hover">
								<div class="social-icons">
                                <?php if($facebook!=''){ ?>
									<a href="<?php echo $facebook; ?>"><i class="fa fa-facebook"></i></a>
                                 <?php } ?>
                                 <?php if($twitter!=''){ ?>
										<a href="<?php echo $twitter; ?>"><i class="fa fa-twitter"></i></a>
                                 <?php } ?>
                                 <?php if($google_plus!=''){ ?>
									<a href="<?php echo $google_plus; ?>"><i class="fa fa-google-plus"></i></a>
                                 <?php } ?>
                                 <?php if($linkedin!=''){ ?>
									 <a href="<?php echo $linkedin; ?>"><i class="fa fa-linkedin"></i></a>
                                 <?php } ?>
								</div>
							</div>
							<img alt="" src="<?php echo $img_src; ?>" class="img-circle">
						</div>
						<div class="team-content">
						    <h3 class="name">
						      <?php echo $post_title;?>
						      <span>
						        <?php echo $position; ?>
						      </span>
						    </h3>
                            <?php  if($trimmed_content){?>

						     <?php echo $trimmed_content; ?>

                            <?php } ?>
						</div>
					</div><!--/ Team wrapper end -->
				</div><!--/ Item 1 end -->
					<?php  endwhile;  ?>
				</div>

			 <?php
     $my_query = null;
     $my_query = $temp;  // Reset
   ?>

    <link rel="stylesheet" href="<?php echo plugins_url('/team'); ?>/lib/assets/style/style_1.css" />

    <script src="<?php echo plugins_url('/team'); ?>/lib/assets/js/jquery-1.9.1.min.js"></script>

    <script type='text/javascript' >
    var j = jQuery.noConflict();
    j(document).ready(function() {
    $("#team-carousel-one").owlCarousel({

    // Most important owl features
    items :<?php echo $items;?>,
    itemsDesktop : [<?php echo $itemsDesktop_width;?>,<?php echo $itemsDesktop_item;?>],
    itemsDesktopSmall : [<?php echo $ItemsDesktopSmall_width;?>,<?php echo $ItemsDesktopSmall_item;?>],
    itemsTablet: [<?php echo $itemsTablet_width;?>,<?php echo $itemsTablet_item;?>],
    itemsMobile : [<?php echo $itemsMobile_width;?>,<?php echo $itemsMobile_item;?>],
    singleItem :  <?php echo $singleItem;?>,

    //Basic Speeds
    slideSpeed : <?php echo $slideSpeed;?>,
    paginationSpeed : <?php echo $paginationSpeed;?>,


    //Autoplay
    autoPlay : <?php echo $autoPlay;?>,
    stopOnHover : <?php echo $stopOnHover;?>,

    // Navigation
    navigation : <?php echo $navigation;?>,

    //Pagination
    pagination : <?php echo $pagination;?>,

    // Responsive
    responsive: <?php echo $responsive;?>,

    navigationText: ["<i class='fa fa-chevron-left'></i>", "<i class='fa fa-chevron-right'></i>"]
    })
});
</script>
     <?php }


      ?>