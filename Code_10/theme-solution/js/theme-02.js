(function ($) {
  "use strict";

  // var
  var $window = $(window),
    $header = $(".header"),
    $nav_btn = $header.find(".header__navbtn"),
    $nav_menu = $header.find(".nav-menu"),
    $menu_depth1 = $nav_menu.children(".menu-item");

  // --------------------------------
  // Desktop
  // --------------------------------
  if ($window.width() > 576) {
    // GNB
    $menu_depth1.hover(
      function () {
        $(this).find(".sub-menu").stop().slideDown(300, "easeInOutCirc");
      },
      function () {
        $(this).find(".sub-menu").stop().slideUp(300, "easeInOutCirc");
      }
    );

    // Accesibility
    $menu_depth1.children("a").on("focus", function () {
      $header.find(".sub-menu").stop().slideUp(300, "easeInOutCirc");
      $(this).siblings(".sub-menu").stop().slideDown(300, "easeInOutCirc");
    });
    $(".accesibility").on("focus", function () {
      $header.find(".sub-menu").stop().slideUp(300, "easeInOutCirc");
    });
    $(".header__utilmenu")
      .find("a")
      .on("focus", function () {
        $(".searchbar").stop().slideUp(300, "easeInOutCirc");
        $(".searchbar-dim").remove();
      });
  }
  // --------------------------------
  // Mobile
  // --------------------------------
  else {
    // GNB
    $nav_btn.on("click", function () {
      if ($(this).hasClass("on")) {
        $header.addClass("active-nav");
      } else {
        setTimeout(function () {
          $header.removeClass("active-nav");
        }, 300);
      }
    });
  }
})(jQuery);
