(function ($) {
  "use strict";

  // var
  var $window = $(window),
    $header = $(".header"),
    $nav_menu = $header.find(".nav-menu"),
    $menu_depth1 = $nav_menu.children(".menu-item");

  // --------------------------------
  // Desktop
  // --------------------------------
  if ($window.width() > 576) {
    // GNB
    $menu_depth1.hover(
      function () {
        $header.addClass("active");
      },
      function () {
        $header.removeClass("active");
      }
    );

    // Accesibility
    $(".header__searchbtn").on("focus", function () {
      $header.removeClass("active");
    });
    $(".header__title").on("focus", function () {
      $header.removeClass("active");
    });
    $nav_menu.find("a").on("focus", function () {
      $header.addClass("active");
    });
    $menu_depth1.find("a").on("focus", function () {
      $(".searchbar").stop().slideUp(300, "easeInOutCirc");
      $(".searchbar-dim").remove();
    });
  }
  // --------------------------------
  // Mobile
  // --------------------------------
  else {
  }
})(jQuery);
