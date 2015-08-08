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
          'post_type'        => 'post',
          'meta_query' => array(
            array(
              'key'     => 'detail_images',
              'value'   => '0',
              'compare' => 'NOT LIKE',
            ),
          ),
          'orderby'          => 'rand'
        );

        $detail_query = new WP_Query( $args );

        if ( $detail_query->have_posts() ):
          while ( $detail_query->have_posts() ):
            $detail_query->the_post();

            if( have_rows('detail_images') ):
              $rows = get_field('detail_images' );
              $rand_row = $rows[ array_rand( $rows ) ];
              $rand_row_image = $rand_row['image'];
              echo '<a href="' . get_permalink( get_page_by_path('images') ) . '">';
                echo '<div class="featured-image" style="background-image: url(' . $rand_row_image['url'] . ')"></div>';
              echo '</a>';
            endif;
          endwhile;
        endif;
        wp_reset_postdata();
      ?>
      <?php wp_reset_postdata(); ?>
    </div><!-- .post -->
  </div><!-- .content -->
<?php get_footer() ?>
</body>
</html>
