// script for sorting the colour movies

$( window ).on('load',function() {
    var $wrapper = $('.movies');

$('#movie-sorter').change(function() {
  // sort by rating
  if ($(this).children('option[value="rating"]').is(':selected')) {
    $wrapper.find('.movie').sort(function(b, a) {
        return $(a).data('movie-tomato') - $(b).data('movie-tomato')
      })
      .appendTo($wrapper)
  }
  // sort by year
  if ($(this).children('option[value="year"]').is(':selected')) {
    $wrapper.find('.movie').sort(function(a, b) {
        return $(a).data('movie-year') - $(b).data('movie-year')
      })
      .appendTo($wrapper)
  }
  // sort by title
  if ($(this).children('option[value="title"]').is(':selected')) {
    var alpha = $('.movie').sort(function(a, b) {
      return String.prototype.localeCompare.call($(a).data('movie-title').toLowerCase(), $(b).data('movie-title').toLowerCase());
    });

    $wrapper.detach().empty().append(alpha);
    $('#main-content > .container').append($wrapper);

  }
});

});