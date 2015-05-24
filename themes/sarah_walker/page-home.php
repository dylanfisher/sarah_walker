<?php
/*
Template Name: Home
*/
?>
<?php get_header() ?>
  <div class="content">
<?php the_post() ?>
    <div id="page-<?php the_ID() ?>" <?php post_class() ?>>
      <?php
        $args = array(
          'posts_per_page'   => 1,
          'category_name'    => 'featured',
          'post_type'        => 'post',
          'orderby'          => 'rand'
        );
        $posts_array = get_posts( $args );
        $featured_post = $posts_array[0];
        $featured_image = get_attached_media('image', $featured_post);
        $featured_image = sandbox_flatten($featured_image);
        if($featured_image):
          $featured_image = $featured_image[0];
          $featured_image = wp_get_attachment_image_src($featured_image->ID, 'full');
          $url = $featured_image[0];
          echo '<div class="featured-image" style="background-image: url(' . $url . ')"></div>';
        endif;
      ?>
      <?php wp_reset_postdata(); ?>
    </div><!-- .post -->
  </div><!-- .content -->
<?php get_footer() ?>
</body>
</html>
