<?php
/*
Template Name: Images
*/
?>
<?php get_header() ?>
  <div class="content">
<?php the_post() ?>
    <div id="page-<?php the_ID() ?>" <?php post_class() ?>>
      <div class="entry-content">
        <?php
          $querystr = "
            SELECT wposts.ID, wposts.post_title
            FROM $wpdb->posts wposts
            WHERE wposts.post_type = 'attachment'
            AND wposts.post_mime_type = 'image/jpeg'
            ORDER BY RAND()
          ";

          $images = $wpdb->get_results($querystr, ARRAY_A);
          // var_dump($images);

          // $title = wp_get_attachment_image($id[0]['post_title']);
          // $url =  wp_get_attachment_url($id[0]['ID']);

          foreach ($images as $image) {
            $img = wp_get_attachment_image($image['ID'], 'medium');
            echo $img;
          }
        ?>
      </div>
    </div><!-- .post -->
  </div><!-- .content -->
<?php get_footer() ?>
</body>
</html>
