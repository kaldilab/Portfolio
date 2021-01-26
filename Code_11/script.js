$(function () {
  "use strict";

  // var
  var $window = $(window),
    $html = $("html");

  // device check
  var deviceAgent = navigator.userAgent.toLowerCase();
  if (deviceAgent.match(/(iphone|ipod|ipad)/)) {
    $html.addClass("ios");
    $html.addClass("mobile");
  }
  if (navigator.userAgent.search("MSIE") >= 0) {
    $html.addClass("ie");
  } else if (navigator.userAgent.search("Chrome") >= 0) {
    $html.addClass("chrome");
  } else if (navigator.userAgent.search("Firefox") >= 0) {
    $html.addClass("firefox");
  } else if (navigator.userAgent.search("Safari") >= 0 && navigator.userAgent.search("Chrome") < 0) {
    $html.addClass("safari");
  } else if (navigator.userAgent.search("Opera") >= 0) {
    $html.addClass("opera");
  }

  // header
  scrollViewTopAct("main", ".header", "fixed", 0);
  scrollAni(".process__title", "img", "animated fadeInUp", 0);
  scrollAni(".count__title", "img", "animated slideInUp", 0);
  scrollAni(".intro-feature", ".intro-title", "animated zoomIn", 0);
  scrollAni(".intro-accident", ".intro-title", "animated zoomIn", 0);
  scrollAni(".intro-history", ".intro-title", "animated zoomIn", 0);
  scrollAni(".intro-history", ".intro-history__video", "animated fadeInUp delay-_4s", 0);
  scrollAni(".intro-history", ".intro-history__list", "animated fadeInUp delay-_8s", 0);
  scrollAni(".intro-kit", ".intro-title", "animated zoomIn", 0);
  scrollAni(".intro-kit__item", ".intro-kit__thumb", "animated slideInUp", 0);
  scrollAni(".intro-kit__item.item-01", ".intro-kit__info", "animated fadeInLeft delay-_3s", 0);
  scrollAni(".intro-kit__item.item-02, .intro-kit__item.item-03", ".intro-kit__info", "animated fadeInRight delay-_3s", 0);
  scrollAni(".intro-kit", ".intro-kit-bg.img-02", "animated bounceIn delay-1s", 0);
  scrollAni(".intro-kit", ".intro-kit-bg.img-04", "animated bounceIn delay-1_5s", 0);

  // count
  if ($('.count-number').length) {
    $window.on('scroll', scrollCount);
    var viewed = false;
  }

  // process
  if ($('.process__slider').length) {
    var processSlider = new Swiper('.process__slider', {
      centeredSlides: true,
      slidesPerView: 1,
      spaceBetween: 40,
      speed: 800,
      pagination: {
        el: '.process-pagination',
        clickable: true,
      },
      navigation: {
        nextEl: '.process-button-next',
        prevEl: '.process-button-prev',
      },
      breakpoints: {
        576: {
          slidesPerView: 'auto',
          spaceBetween: 130,
        },
      },
      on: {
        slideChangeTransitionStart: function () {
          $('.process-menu').find('li').eq(this.realIndex).addClass('active').siblings().removeClass('active');
        }
      }
    });
    $('.process-menu').find('li').on('click', function () {
      var index = $(this).index();
      processSlider.slideTo(index);
    });
  }

  // intro feature
  if ($('.intro-feature__slider').length) {
    var introFeatureSlider = new Swiper('.intro-feature__slider', {
      autoplay: {
        delay: 4000,
      },
      centeredSlides: true,
      slidesPerView: 1,
      spaceBetween: 40,
      speed: 800,
      pagination: {
        el: '.intro-feature-pagination',
        clickable: true,
      },
      navigation: {
        nextEl: '.intro-feature-button-next',
        prevEl: '.intro-feature-button-prev',
      },
      breakpoints: {
        576: {
          slidesPerView: 'auto',
          spaceBetween: 130,
        },
      },
    });
  }

  // intro accident
  if ($('.intro-accident__slider').length) {
    var introAccidentSlider = new Swiper('.intro-accident__slider', {
      effect: 'fade',
      speed: 400,
      pagination: {
        el: '.intro-accident-pagination',
        clickable: true,
      },
      on: {
        slideChangeTransitionStart: function () {
          $('.intro-accident-menu').find('li').eq(this.realIndex).addClass('active').siblings().removeClass('active');
        }
      }
    });
    $('.intro-accident-menu').find('li').on('click', function () {
      var index = $(this).index();
      introAccidentSlider.slideTo(index);
    });
  }

  // mobile
  if ($window.width() < 576) {
    $('.header__navbtn').on('click', function (event) {
      event.preventDefault();
      $(this).hide();
      $('.header__navbtn--close').addClass('active');
      $('.header__nav').addClass('open');
      $('.header').addClass('active');
    });
    $('.header__navbtn--close').on('click', function (event) {
      event.preventDefault();
      $('.header__navbtn').show();
      $(this).removeClass('active');
      $('.header__nav').removeClass('open');
      $('.header').removeClass('active');
    });
  }

  // check exam
  if ($('.btn-exam').length) {
    var thisVideoCookie = getCookie('GLK_watchvideo_y7Pflss5iDc');
    $('.btn-exam').on('click', function () {
      var $this = $(this);
      if (thisVideoCookie) {
        $this.removeAttr('data-target data-toggle');
      }
    });
  }

  // kit certificate
  if ($('.kit-print').length) {
    window.scrollTo(0, 0);
    var kitPrintCertipicate = document.querySelector(".kit-print__certificate");
    html2canvas(
      kitPrintCertipicate, {
        background: null,
      }
    ).then(function (canvas) {
      document.querySelector(".kit-print__wrap")
        .insertBefore(canvas, kitPrintCertipicate)
        .setAttribute('id', "kitCertificate");
    });
    // 출력하기
    $('.btn-print').on('click', function () {
      window.print();
    });
    // 저장하기
    $('.btn-save').on('click', function () {
      var canvas = document.getElementById('kitCertificate');
      var image = canvas.toDataURL("image/jpeg");
      var target = $(this).attr('data-target');
      $(target).find('.save-image').attr('src', image);
      $(target).find('.btn-download').attr({'href': image, 'download': '수료증.jpg'});
    });
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

  // scrollIntoView
  function scrollIntoView(elem) {
    var docViewTop = $(window).scrollTop();
    var docViewBottom = docViewTop + $(window).innerHeight();
    var elemTop = $(elem).offset().top;
    var elemBottom = elemTop + $(elem).innerHeight();
    return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
  }

  // addComma
  function addComma(val) {
    while (/(\d+)(\d{3})/.test(val.toString())) {
      val = val.toString().replace(/(\d+)(\d{3})/, '$1' + ',' + '$2');
    }
    return val;
  }

  // scrollCount
  function scrollCount() {
    if (scrollIntoView($(".count-number")) && !viewed) {
      viewed = true;
      $('.count-number').find('strong').each(function () {
        $(this).prop('Counter', 0).animate({
          Counter: $(this).text().replace(/,/g, '')
        }, {
          duration: 3000,
          easing: 'swing',
          step: function (now) {
            $(this).text(addComma(Math.ceil(now)));
          }
        });
      });
    }
  }

  // get cookie
  function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
      var c = ca[i];
      while (c.charAt(0) == ' ') {
        c = c.substring(1);
      }
      if (c.indexOf(name) == 0) {
        return c.substring(name.length, c.length);
      }
    }
    return "";
  }
});
