 <?php
/* Template Name: Automobile archive */
?>
<?php get_header(); ?>


<section id="primary">
<div id="content" role="main">


<div class="container">
    <div class="well well-sm">
        <strong>Category Title</strong>
        <div class="btn-group">
            <a href="#" id="list" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-th-list">
            </span>List</a> <a href="#" id="grid" class="btn btn-default btn-sm"><span
                class="glyphicon glyphicon-th"></span>Grid</a>
        </div>
    </div>
    <div id="products" class="row list-group">

        <?php if ( have_posts() ) : ?>
          <header class="page-header">
          <h1 class="page-title">Movie Reviews</h1>
         </header>
        <?php while ( have_posts() ) : the_post();

            $txt_limit=20;
            $automobile_thumb   = get_post_thumbnail_id($post->ID);
            $automobile_img_url = wp_get_attachment_url( $automobile_thumb,'medium' ); //get full URL to image (use "large" or "medium" if the images too big)
            $automobile_image   = automobile_resize( $automobile_img_url,400,250, true );
            $content = get_the_content(get_the_ID($post->ID));
            $automobile_content = wp_trim_words( $content,$txt_limit);
        ?>

          <div class="item  col-xs-4 col-lg-4">
            <div class="thumbnail">
                <a href="<?php the_permalink(); ?>"><img class="group list-group-image" src="<?php echo $automobile_image;?>" alt="" /></a>
                <div class="caption">
                    <h4 class="group inner list-group-item-heading">
                        <?php the_title(); ?></h4>
                    <p class="group inner list-group-item-text">
                        <?php echo $automobile_content; ?></p>
                    <div class="row">
                        <div class="col-xs-12 col-md-6">
                            <span class="automobile-price">
                               Price: <?php echo esc_html( get_post_meta( get_the_ID(), 'txt_automobile_price', true ) ); ?></span>
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <a class="btn btn-success" href="<?php the_permalink(); ?>">Add to cart</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
         <?php endwhile; ?>
         <?php global $wp_query;
if ( isset( $wp_query->max_num_pages ) && $wp_query->max_num_pages > 1 ) { ?>
    <nav id="<?php echo $nav_id; ?>">
   <div class="nav-previous"><?php next_posts_link( '<span class="meta-nav">&larr;</span> Older reviews'); ?></div>
   <div class="nav-next"><?php previous_posts_link( 'Newer reviews <span class= "meta-nav">&rarr;</span>' ); ?></div>
  </nav>
 <?php };
endif; ?>
    </div>
</div>





  </div>
</section>
<?php get_footer(); ?>