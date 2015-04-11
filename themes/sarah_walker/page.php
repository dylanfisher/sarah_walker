<?php get_header() ?>
  <div class="content">
<?php the_post() ?>
    <div id="page-<?php the_ID() ?>" <?php post_class() ?>>
      <div class="entry-content">
<?php the_content() ?>
      </div>
    </div><!-- .post -->
  </div><!-- .content -->
<?php get_footer() ?>
</body>
</html>
