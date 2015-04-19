// Primary Javascript file

$ = jQuery;

jQuery(document).ready(function($){

  var SW = {};

  // Lightbox
  $('[data-lightbox]').click(function(e){
    e.preventDefault();
    $('body').addClass('lightbox-open');

    var url = $(this).attr('data-image-full');
    var title = $(this).attr('data-title');
    var meta  = $(this).attr('data-post-meta');
    meta = JSON.parse(meta);
    var year = meta.year ? meta.year[0] : '';
    var dimensions = meta.dimensions ? meta.dimensions[0] : '';
    var medium = meta.medium ? meta.medium[0] : '';

    var workInfoTitle = '<div class="title">' + title + '</div>';
    var workInfoYear = '<div class="year">' + year + '</div>';
    var workInfoDimensions = '<div class="dimensions">' + dimensions + '</div>';
    var workInfoMedium = '<div class="medium">' + medium + '</div>';
    var workInfo = workInfoTitle + workInfoYear + workInfoDimensions + workInfoMedium;

    $('body').append('<div class="lightbox"><div class="lightbox-outer"><div class="lightbox-inner"></div></div></div>');
    $('.lightbox-inner').append('<img class="lightbox-image" src="' + url + '"><div class="lightbox-work-info">' + workInfo + '</div>');
  });

  $(document).on('click', '.lightbox', function(e){
    if($('body').hasClass('lightbox-open')) {
      if(!e.target.closest('.lightbox-image')) {
        SW.closeLightbox();
      }
    }
  });

  SW.closeLightbox = function() {
    $('body').removeClass('lightbox-open');
    $('.lightbox').remove();
  };

});
