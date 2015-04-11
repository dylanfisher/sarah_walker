<?php get_header() ?>
  <div class="content">
    <div id="post-<?php the_ID() ?>" <?php post_class() ?>>
      <?php
        $images = get_attached_media('image');
        foreach ( $images as $image ):
          $attrs = array(
            'data-image-full' => $image->guid
          );
          echo wp_get_attachment_image($image->ID, 'full', false, $attrs);
        endforeach;
      ?>
    </div><!-- .post -->
  </div><!-- .content -->
<?php get_footer() ?>
</body>
</html>
