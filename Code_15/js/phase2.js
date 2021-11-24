// D-Day Counter
ddayCounter();
function ddayCounter() {
  // D-Day
  var dday = new Date("2021-10-26T10:00:00");
  setInterval(function () {
    // Content
    var cont = document.querySelector(".atd-home-countdown-counter");
    if (cont) {
      // 태평양 표준시 기준 현재 시각
      var now = new Date(getWorldTime(-7));
      var distance = dday - now;
      var d = Math.floor(distance / (1000 * 60 * 60 * 24));
      var h = leadingZeros(Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)), 2);
      var m = leadingZeros(Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60)), 2);
      var s = leadingZeros(Math.floor((distance % (1000 * 60)) / 1000), 2);
      if (s < 0) {
        cont.innerHTML = "<span>Stay Tuned!</span>";
      } else {
        if (d > 1) {
          cont.innerHTML = "D-" + d;
        } else {
          if (d == 1) {
            cont.innerHTML = Number(h) + 24 + ":" + m + ":" + s;
          } else {
            cont.innerHTML = h + ":" + m + ":" + s;
          }
        }
      }
      console.log(d + "---" + h + ":" + m + ":" + s);
    }
  }, 1000);
}
function getWorldTime(tzOffset) {
  var now = new Date();
  var tz = now.getTime() + now.getTimezoneOffset() * 60000 + tzOffset * 3600000;
  now.setTime(tz);
  var s =
    leadingZeros(now.getFullYear(), 4) +
    "-" +
    leadingZeros(now.getMonth() + 1, 2) +
    "-" +
    leadingZeros(now.getDate(), 2) +
    "T" +
    leadingZeros(now.getHours(), 2) +
    ":" +
    leadingZeros(now.getMinutes(), 2) +
    ":" +
    leadingZeros(now.getSeconds(), 2);

  return s;
}
function leadingZeros(n, digits) {
  var zero = "";
  n = n.toString();
  if (n.length < digits) {
    for (i = 0; i < digits - n.length; i++) zero += "0";
  }
  return zero + n;
}

// Home Scroll
function scrollHomeSection(event){
  window.event.preventDefault();
  var $this = $(event);
  var targetID = $this.attr('href');
  var offset = $(targetID).offset().top;
  $('html, body').animate({scrollTop : offset - 124}, 400);
}

// Window Reload For Swiper
if(!(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent))) {
  window.addEventListener("resize", function () {
    location.reload();
    console.log('resize');
  });
}

// Home Popup Close
setTimeout(function() {
  if (getHomePopupCookie("homePopup") != "Y") {
    $('.atd-home-popup').show();
  }
}, 1000);
function closeHomePopup() {
  setHomePopupCookie("homePopup", "Y", 1);
  $('.atd-home-popup').hide();
}
function setHomePopupCookie(name, value, expiredays) {
  var todayDate = new Date();
  todayDate.setDate(todayDate.getDate() + expiredays);
  document.cookie =
    name +
    "=" +
    escape(value) +
    "; path=/; expires=" +
    todayDate.toGMTString() +
    ";";
}
function getHomePopupCookie(name) {
  var obj = name + "=";
  var x = 0;
  while (x <= document.cookie.length) {
    var y = x + obj.length;
    if (document.cookie.substring(x, y) == obj) {
      if ((endOfCookie = document.cookie.indexOf(";", y)) == -1)
        endOfCookie = document.cookie.length;
      return unescape(document.cookie.substring(y, endOfCookie));
    }
    x = document.cookie.indexOf(" ", x) + 1;

    if (x == 0) break;
  }
  return "";
}

// Tech Talk Carousel
setTimeout(function() {
  const swiper = new Swiper('.atd-home-techtalk-swiper', {
    spaceBetween: 30,
    grid: {
      rows: 2,
    },
    pagination: {
      el: ".swiper-pagination",
      type: 'custom',
      renderCustom: function (swiper, current, total) {
          return current + ' of ' + (total); 
      }
    },
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
    breakpoints: {
      425: {
        slidesPerView: 1,
        slidesPerGroup: 1,
      },
      768: {
        slidesPerView: 2,
        slidesPerGroup: 2,
      },
      1280: {
        slidesPerView: 3,
        slidesPerGroup: 3,
      }
    }
  });
}, 2000);