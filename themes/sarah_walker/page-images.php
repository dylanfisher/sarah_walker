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
            $post_meta_json = json_encode(get_post_meta($post->ID));
            $post_meta = htmlentities($post_meta_json);
            $images = get_attached_media('image');
            foreach ( $images as $image ):
              echo '<a href="'.get_permalink().'" data-lightbox data-image-full="'.$image->guid.'" data-title="'.get_the_title().'" data-post-meta="'.$post_meta.'">';
                echo wp_get_attachment_image($image->ID, 'medium', false);
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
