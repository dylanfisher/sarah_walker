// Primary Javascript file

$ = jQuery;

jQuery(document).ready(function($){

  var app = (function() {

    return {
      init: function() {

        // Lightbox
        $('[data-lightbox]').click(function(e){
          e.preventDefault();
          $('body').addClass('lightbox-open');
          $('[data-lightbox]').removeClass('active');
          $(this).addClass('active');

          var images = [];
          images.push( assembleImage( $(this).prevWrap() ) );
          images.push( assembleImage( $(this) ) );
          images.push( assembleImage( $(this).nextWrap() ) );

          var controls = '<div class="lightbox-next"></div><div class="lightbox-previous"></div>';

          $('body').append('<div class="lightbox"><div class="lightbox-outer"><div class="lightbox-inner"></div></div></div>');
          $('.lightbox-inner').append('<div class="lightbox-images">' + images.join('') + '</div>' + controls);
          $('.lightbox-images .lightbox-image-wrapper').eq(1).addClass('active');
        });

      } // init
    };

  }());

  app.init();

  $(document).on('pjax:start', function() {
    // pjax start
  });

  $(document).on('pjax:end', function() {
    app.init();
    closeLightbox();
  });

  $(document).on('click', '.lightbox', function(e){
    if($('body').hasClass('lightbox-open')) {
      if(!e.target.closest('.lightbox-image, .lightbox-next, .lightbox-previous, .permalink')) {
        closeLightbox();
      }
    }
  });

  $(document).on('click', '.lightbox-image, .lightbox-next', function(e){
    nextImage();
  });

  $(document).on('click', '.lightbox-previous', function(e){
    prevImage();
  });

  $(document).keyup(function(e) {
    if (e.keyCode == 27) closeLightbox();
  });

  $(document).keydown(function(e) {
    switch(e.which) {
      case 25: // esc
        closeLightbox();
      break;

      case 37: // left
        prevImage();
      break;

      case 39: // right
        nextImage();
      break;

      default: return;
    }
    e.preventDefault();
  });

  var isLightboxOpen = function() {
    return $('body').hasClass('lightbox-open') ? true : false;
  };

  var closeLightbox = function() {
    if($('body').hasClass('lightbox-open')) {
      $('body').removeClass('lightbox-open');
      $('.lightbox').remove();
    }
  };

  var prevImage = function() {
    if(!isLightboxOpen()) return;
    setPrevActive($('[data-lightbox].active'));
    setPrevActive($('.lightbox-image-wrapper.active'));
    $('.lightbox-image-wrapper').last().remove();
    var newImage = assembleImage($('[data-lightbox].active').prevWrap());
    $('.lightbox-images').prepend(newImage);
  };

  var nextImage = function() {
    if(!isLightboxOpen()) return;
    setNextActive($('[data-lightbox].active'));
    setNextActive($('.lightbox-image-wrapper.active'));
    $('.lightbox-image-wrapper').first().remove();
    var newImage = assembleImage($('[data-lightbox].active').nextWrap());
    $('.lightbox-images').append(newImage);
  };

  var setPrevActive = function(el) {
    el.removeClass('active').prevWrap().addClass('active');
  };

  var setNextActive = function(el) {
    el.removeClass('active').nextWrap().addClass('active');
  };

  var assembleImage = function(el) {
    var url = el.attr('data-image-full');
    var title = el.attr('data-title');
    var meta  = el.attr('data-post-meta');
    var permalink = el.attr('href');
    meta = JSON.parse(meta);
    var year = meta.year ? meta.year[0] : '';
    var dimensions = meta.dimensions ? meta.dimensions[0] : '';
    var medium = meta.medium ? meta.medium[0] : '';

    var workInfoTitle = '<div class="title">' + title + '</div>';
    var workInfoYear = '<div class="year">' + year + '</div>';
    var workInfoDimensions = '<div class="dimensions">' + dimensions + '</div>';
    var workInfoMedium = '<div class="medium">' + medium + '</div>';
    var workPermalink = '<a href="' + permalink + '" class="permalink" title="Permalink">&#8734;</a>';
    var workInfo = workInfoTitle + workInfoYear + workInfoDimensions + workInfoMedium + workPermalink;

    var lightboxWork = '<div class="lightbox-work-info">' + workInfo + '</div>';
    var lightboxImage = '<div class="lightbox-image-inner-wrapper"><img class="lightbox-image" src="' + url + '"></div>';

    return '<div class="lightbox-image-wrapper">' + lightboxWork + lightboxImage + '</div>';
  };


  $.fn.nextWrap = function( selector ) {
    var $next = $(this).next( selector );
    if ( ! $next.length ) {
      $next = $(this).parent().children( selector ).first();
    }
    return $next;
  };

  $.fn.prevWrap = function( selector ) {
    var $previous = $(this).prev( selector );
    if ( ! $previous.length ) {
      $previous = $(this).parent().children( selector ).last();
    }
    return $previous;
  };


});
