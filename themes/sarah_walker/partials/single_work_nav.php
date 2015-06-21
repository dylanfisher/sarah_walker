<?php
  echo '<div class="single-work-info">';
    echo '<div class="previous">';
      if(get_next_post_link()) {
        next_post_link('%link', 'Previous ');
      } else {
        echo '<span class="disabled">Previous</span>';
      }
    echo '</div>';
    echo '<div class="next">';
      if(get_previous_posts_link()) {
        echo '<span class="disabled">Next</span>';
      } else {
        previous_post_link('%link', 'Next ');
      }
    echo '</div>';
    echo '<br><br>';
    echo '<h3>'.get_the_title().'</h3>';
    echo '<div>'.get_field('year').', '.get_field('dimensions').',<br>'.get_field('medium').'</div>';
  echo '</div>';
?>
