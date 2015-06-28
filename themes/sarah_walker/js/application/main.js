jQuery(document).ready(function($){

  $(document).on('pjax:end', function() {
    ga('set', 'location', window.location.href);
    ga('send', 'pageview');
  });

});
