<?php get_header() ?>
  <div class="content">
    <div id="post-<?php the_ID() ?>" <?php post_class() ?>>
      <?php
        $images_page = get_page_by_path('images');
        $images_page = get_permalink($images_page);
        $images = get_attached_media('image');
        foreach ( $images as $image ):
          $attrs = array(
            'data-image-full' => $image->guid
          );
          echo '<a href="'.$images_page.'">';
            echo wp_get_attachment_image($image->ID, 'large', false, $attrs);
          echo '</a>';
        endforeach;
      ?>
    </div><!-- .post -->
  </div><!-- .content -->
<?php get_footer() ?>
</body>
</html>
