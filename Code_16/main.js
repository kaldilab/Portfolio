$(function () {
  var $window = $(window),
    $body = $("body");

  // maintile swiper
  var maintileSwiper = new Swiper(".maintile__swiper", {
    slidesPerView: 1,
    grid: {
      rows: 2,
    },
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
    breakpoints: {
      751: {
        slidesPerView: 2,
        grid: {
          rows: 2,
        },
      },
      1441: {
        slidesPerView: 3,
        grid: {
          rows: 2,
        },
      },
    },
  });
  maintileSwiper.on("slideChange", function () {
    var getAllIndex = this.snapGrid.length - 1;
    if (maintileSwiper.activeIndex == getAllIndex) {
      $(".maintile__control").removeClass("next");
      $(".maintile__control").addClass("back");
    } else {
      $(".maintile__control").removeClass("back");
      $(".maintile__control").addClass("next");
    }
  });

  // maintile control
  $(".maintile__control").on("click", function () {
    if ($(this).hasClass("next")) {
      maintileSwiper.slideNext(800);
    } else {
      maintileSwiper.slidePrev(800);
    }
  });

  // mouse cursor
  var $mainLink = $(".maintile__link, .mainpop__link"),
    $mainCursor = $(".maintile__cursor, .mainpop__cursor");
  $mainLink.on("mousemove", function (event) {
    if ($window.width() > 750) {
      $mainCursor.css({
        left: event.clientX,
        top: event.clientY,
        opacity: 0.9,
        visibility: "visible",
      });
    }
  });
  $mainLink.on("mouseout", function () {
    if ($window.width() > 750) {
      $mainCursor.css({
        opacity: 0,
        visibility: "hidden",
      });
    }
  });
  if (
    "ontouchstart" in window ||
    navigator.maxTouchPoints > 0 ||
    navigator.msMaxTouchPoints > 0
  ) {
    $(".maintile__link").addClass("touch");
    $mainCursor.hide();
  }

  // main popup
  $(".maintile__link").on("click", function (event) {
    if (
      "ontouchstart" in window ||
      navigator.maxTouchPoints > 0 ||
      navigator.msMaxTouchPoints > 0
    ) {
      $(this).addClass("touch");
    } else {
      mainPop(event, this);
    }
  });
  $(".maintile__more").on("click", function (event) {
    mainPop(event, this);
  });
  $(".mainpop__close").on("click", function () {
    $(".mainpop__group").removeClass("open");
    setTimeout(function () {
      $body.removeClass("scroll-lock");
    }, 900);
  });

  // function
  function mainPop(e, t) {
    e.preventDefault();
    var index = $(t).parents(".swiper-slide").index();
    $(".mainpop__group").eq(index).addClass("open");
    $body.addClass("scroll-lock");
  }
});
