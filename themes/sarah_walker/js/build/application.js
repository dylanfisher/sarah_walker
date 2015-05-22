// Primary Javascript file

(function($){

  var app = (function() {

    return {
      init: function() {
        // init
      }
    };

  }());

  app.init();


  // pjax start
  $(document).on('pjax:start', function() {
  });

  // pjax end
  $(document).on('pjax:end', function() {
    app.init();
  });

})(jQuery);
