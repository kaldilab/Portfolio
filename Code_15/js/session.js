// Session Filter
$(document).on('click', '#sessionFilter .form-check-input', function () {
  if ($('#sessionFilter .form-check-input:checked').length) {
    $('.rf-tile-wrapper').hide();
    $('#sessionFilter .form-check-input:checked').each(function () {
      var $this = $(this);
      var targetElement = $this[0].value;
      $('.rf-tile-wrapper').each(function () {
        var keyword = $(this).find('.rf-tile-info').text().includes('#' + targetElement);
        if (keyword) {
          $(this).show();
        }
      });
    });
  } else {
    clearSessionFilter();
  }
});
function clearSessionFilter() {
  $('.rf-tile-wrapper').show();
  $('#sessionFilter .form-check-input').prop('checked', false);
  if($(window).width() <= 640) {
    closeMobileSessionFilter();
  }
}
function mobileSessionFilter() {
  $('.session-techtalk-side-search').show();
  $('.session-techtalk-side-search-dim').show();
}
function closeMobileSessionFilter() {
  $('.session-techtalk-side-search').hide();
  $('.session-techtalk-side-search-dim').hide();
}

// Sticky Session Filter
setScrollUI();
$(window).on("scroll", function () {
  setScrollUI();
});
function setScrollUI() {
  var scrollAmt = $(document).scrollTop();
  if($(window).width() > 640) {
    if (scrollAmt > 400) {
      $(".session-techtalk-side-search").addClass("active");
    } else {
      $(".session-techtalk-side-search").removeClass("active");
    }
  }
}