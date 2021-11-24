// sticky filter
setScrollUI();
$(window).on("scroll", function () {
  setScrollUI();
});
function setScrollUI() {
  var scrollAmt = $(document).scrollTop();
  if (scrollAmt > 400) {
    $("nav.search-filters").addClass("active");
    $("nav.search-filters").siblings('.main-content').addClass("active");
  } else {
    $("nav.search-filters").removeClass("active");
    $("nav.search-filters").siblings('.main-content').removeClass("active");
  }
}