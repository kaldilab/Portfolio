// Home Scroll
function scrollHomeSection(event){
  window.event.preventDefault();
  var $this = $(event);
  var targetID = $this.attr('href');
  var offset = $(targetID).offset().top;
  $('html, body').animate({scrollTop : offset - 124}, 400);
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

// Window Reload for Swiper
/* setTimeout(function() {
  if(!(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent))) {
    if(navigator.maxTouchPoints < 1) {
      if($('.atd-home-techtalk-swiper').length) {
        window.addEventListener("resize", function () {
          location.reload();
        });
      }
    }
  }
}, 1000) */
/* window.onresize = function (event) {
  const swiper = new Swiper('.atd-home-techtalk-swiper');
  swiper.destroy();
  reformatTechTalk();
} */
window.addEventListener('resize', function(event) {
  if(navigator.maxTouchPoints < 1) {
    setTimeout(function () {
      const swiper = new Swiper('.atd-home-techtalk-swiper');
      swiper.destroy();
      reformatTechTalk();
    }, 700);
  }
});

window.addEventListener("orientationchange", function () {
  setTimeout(function () { 
    var swiper = new Swiper('.atd-home-techtalk-swiper');
    swiper.destroy();
    reformatTechTalk();
  }, 700);
});
  
// Keynote Speaker
function keynoteSpeaker(event) {
  var $this = $(event);
  var $modalSpeaker = $("#keynoteSpeaker");
  var profile = $this.find(".session-keynote-detail-speaker-profile, .atd-home-keynote-speaker-profile").attr("src");
  var name = $this.find(".session-keynote-detail-speaker-name, .atd-home-keynote-speaker-name").html();
  var text = $this.find(".session-keynote-detail-speaker-text, .atd-home-keynote-speaker-text").html();
  var desc = $this.find(".session-keynote-detail-speaker-desc, .atd-home-keynote-speaker-desc").html();
  $modalSpeaker.find(".speaker-profile").attr("src", profile);
  $modalSpeaker.find(".speaker-name").html(name);
  $modalSpeaker.find(".speaker-text").html(text);
  $modalSpeaker.find(".speaker-desc").html(desc);
}