(function ($) {
  "use strict";

  // var
  var $window = $(window),
    $header = $(".header"),
    $nav_btn = $header.find(".header__navbtn"),
    $nav_menu = $header.find(".nav-menu"),
    $searchBtn = $(".header__searchbtn"),
    $searchBar = $(".searchbar");

  // add class to acf-form
  if ($(".acf-form").length) {
    $(".acf-form")
      .find(".acf-field")
      .each(function () {
        var dataName = $(this).attr("data-name");
        $(this).find("input, textarea").not("[type=hidden]").addClass(dataName);
      });
    $("._post_title").attr("placeholder", "제목을 입력하세요.");
  }

  // single page menu highlight
  if ($("body").hasClass("single")) {
    var $sub_menu = $nav_menu.find(".sub-menu"),
      $currentMenu = $sub_menu.find(".current-menu-item");
    $currentMenu
      .parent()
      .siblings("a")
      .parent()
      .addClass("current-menu-parent");
  }

  // Search
  $searchBtn.on("click", function () {
    searchOpen();
  });
  $searchBar.find(".searchbar-close").on("click", function () {
    searchClose();
  });
  $(".container-fluid").on("click", function () {
    searchClose();
  });
  $header.on("click", function (event) {
    event.stopPropagation();
  });

  // header
  scrollViewTopAct(".header", ".header", "fixed", 0);

  // main
  scrollAni(".main > .section", ".h2", "animated fadeInUp", 50);
  scrollAni(".main > .section", ".h3", "animated fadeInUp", 50);

  // resize reload
  if (window.addEventListener) {
    window.addEventListener("orientationchange", function () {
      location.reload();
    });
  }

  // --------------------------------
  // Desktop
  // --------------------------------
  if ($window.width() > 576) {
    // Accesibility
    $searchBtn.on("focus", function () {
      searchOpen();
    });
    $("#content").on("focusin", function () {
      searchClose();
    });
  }
  // --------------------------------
  // Mobile
  // --------------------------------
  else {
    // nav
    $nav_btn.on("click", function () {
      $(this).toggleClass("on");
      $nav_menu.toggleClass("active");
      searchClose();
    });
    $nav_menu.children(".menu-item.menu-item-has-children").each(function () {
      $(this)
        .children("a")
        .on("click", function (event) {
          event.preventDefault();
          var $this = $(this),
            $parentSiblings = $this.parent().siblings();
          $parentSiblings.children("a").removeClass("on");
          $parentSiblings.children(".sub-menu").removeClass("active");
          $this.toggleClass("on");
          $this.siblings(".sub-menu").toggleClass("active");
        });
      if ($(this).hasClass("current-menu-parent")) {
        $(this).children("a").addClass("on");
        $(this).children(".sub-menu").addClass("active");
      }
    });

    // search
    $searchBtn.on("click", function () {
      $nav_btn.removeClass("on");
      $nav_menu.removeClass("active");
    });

    // view
    if ($(".view-blog").length) {
      var $viewBlog = $(".view-blog");
      $viewBlog.find(".view-related").before($viewBlog.find(".view-recent"));
      $viewBlog.find(".view-related").before($viewBlog.find(".view-gotolist"));
    }
  }

  // scroll view top classes
  function scrollViewTopAct(target1, target2, classes, offset) {
    var $target1 = $(target1),
      $target2 = $(target2);
    if ($target1.length) {
      $target1.each(function () {
        var targetTop = $target1.offset().top + offset;
        $(window).on("scroll resize load", function () {
          var viewTop = $(this).scrollTop();
          if (viewTop > targetTop) {
            $target2.addClass(classes);
          } else {
            $target2.removeClass(classes);
          }
        });
      });
    }
  }

  // scroll ani up & down
  function scrollAni(target1, target2, aniClasses, offset) {
    if ($(target1).length) {
      $(target1).each(function () {
        var $window = $(window),
          $target1 = $(this);
        var targetTop = $target1.offset().top - offset;
        $window.on("scroll resize load", function () {
          var viewTop = $(this).scrollTop(),
            viewBtm = viewTop + $window.innerHeight();
          if (viewBtm > targetTop) {
            $target1.find(target2).addClass(aniClasses);
          } else {
            $target1.find(target2).removeClass(aniClasses);
          }
        });
      });
    }
  }

  // search open
  function searchOpen() {
    $searchBar.stop().slideDown(300, "easeInOutCirc");
    if (!$(".searchbar-dim").length) {
      $header.before('<div class="searchbar-dim"></div>');
    }
  }

  // search close
  function searchClose() {
    $searchBar.stop().slideUp(300, "easeInOutCirc");
    $(".searchbar-dim").remove();
  }
})(jQuery);
