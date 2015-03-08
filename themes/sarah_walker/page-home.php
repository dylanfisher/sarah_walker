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
        $querystr = "
          SELECT wposts.ID, wposts.post_title
          FROM $wpdb->posts wposts
          WHERE wposts.post_type = 'attachment'
          AND wposts.post_mime_type = 'image/jpeg'
          ORDER BY RAND() LIMIT 1
        ";

        $id = $wpdb->get_results($querystr, ARRAY_A);

        $title = wp_get_attachment_image($id[0]['post_title']);
        $url =  wp_get_attachment_url($id[0]['ID']);
      ?>
      <div class="featured-image" style="background-image: url(<?php echo $url ?>)"></div>
    </div><!-- .post -->
  </div><!-- .content -->
<?php get_footer() ?>
</body>
</html>
