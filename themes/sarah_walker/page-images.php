<?php
/*
Template Name: Images
*/
?>
<?php get_header() ?>
  <div class="content">
<?php the_post() ?>
    <div id="page-<?php the_ID() ?>" <?php post_class() ?>>
      <?php
        $args = array(
          'post_type' => 'post',
          'posts_per_page' => -1,
          'orderby'   => 'menu_order',
          'order'     => 'ASC'
        );

        $works = new WP_Query( $args );

        if ( $works->have_posts() ):
          while ( $works->have_posts() ):
            $works->the_post();
            $images = get_attached_media('image');
            foreach ( $images as $image ):
              $image_medium = wp_get_attachment_image_src($image->ID, 'medium', false);
              $url = $image_medium[0];
              $width = $image_medium[1];
              $height = $image_medium[2];
              echo '<a href="'.get_permalink().'">';
                echo '<img src="'.$url.'" width="'.$width.'" height="'.$height.'">';
              echo '</a>';
            endforeach;

          endwhile;
        endif;
        wp_reset_postdata();
      ?>
    </div><!-- .post -->
  </div><!-- .content -->
<?php get_footer() ?>
</body>
</html>
