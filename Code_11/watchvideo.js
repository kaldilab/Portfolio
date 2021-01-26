// watchvideo youtube
var tag = document.createElement('script');
tag.src = "http://www.youtube.com/player_api";
var firstScriptTag = document.getElementById('watchvideo');
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
var player;

function onYouTubePlayerAPIReady() {
  player = new YT.Player('watchvideo', {
    videoId: 'eso500Q3R5M',
    playerVars: {
      'autoplay': 0,
      'controls': 1,
      'disablekb': 1,
      'fs': 0,
      'rel': 1,
      'modestbranding': 1,
      'playsinline': 1,
    },
    events: {
      onStateChange: onPlayerStateChange,
    }
  });
}

$(function () {
  var $watchvideoStep = $('.watchvideo-step'),
    $watchvideoSlider = $('.watchvideo__slider'),
    $buttonLocked = $('.button-locked');

  // watchvideo slider
  var watchvideoSlider = new Swiper($watchvideoSlider, {
    centeredSlides: true,
    slidesPerView: 1,
    spaceBetween: 40,
    speed: 800,
    allowTouchMove: false,
    pagination: {
      el: '.watchvideo-pagination',
      clickable: true,
    },
    navigation: {
      nextEl: '.watchvideo-button-next',
      prevEl: '.watchvideo-button-prev',
    },
    breakpoints: {
      576: {
        slidesPerView: 'auto',
        spaceBetween: 130,
      },
    },
    on: {
      init: function () {
        $watchvideoStep.find('li').eq(0).addClass('active step-current');
        buttonLocked();
      },
      slideChangeTransitionStart: function () {
        $watchvideoStep.find('li').eq(this.activeIndex).addClass('active').siblings().removeClass('active');
        buttonLocked();
      }
    }
  });

  // watchvideo step
  $watchvideoStep.find('li').each(function () {
    var $this = $(this);
    var thisIndex = $this.index();
    var $targetSlide = $watchvideoSlider.find('.swiper-slide').eq(thisIndex);
    var targetSlideId = $targetSlide.find('.btn-watchvideo').attr('id');
    $this.attr('id', 'step-' + targetSlideId);
    var thisId = $this.attr('id'),
      thisVideoId = thisId.replace('step-', ''),
      thisVideoCookie = getCookie('GLK_watchvideo_' + thisVideoId);
    if (thisVideoCookie) {
      if (thisIndex === ($watchvideoStep.find('li').length - 1)) {
        $this.addClass('step-pass');
        $targetSlide.addClass('slide-pass');
        $targetSlide.find('.btn-wrap').removeClass('d-none');
      } else {
        $this.next().removeClass('step-locked').removeAttr('data-target data-toggle').addClass('step-current');
        $this.next().siblings().removeClass('step-current');
        $buttonLocked.hide();
        $this.addClass('step-pass');
        $targetSlide.addClass('slide-pass');
      }
    }
    if ($this.hasClass('step-current')) {
      watchvideoSlider.slideTo(thisIndex);
    }
  });
  $watchvideoStep.find('li').on('click', function () {
    var $this = $(this),
      thisindex = $this.index();
    if (!$this.hasClass('step-locked')) {
      watchvideoSlider.slideTo(thisindex);
    }
  });

  // watchvideo modal
  var $watchvideoModal = $('.watchvideo-modal');
  $watchvideoModal.find('.modal-body').on('click', function (event) {
    event.stopPropagation();
  });
  $watchvideoModal.on('click', function () {
    player.stopVideo();
  });
  $(".btn-watchvideo").on("click", function () {
    player.loadVideoById(this.id);
  });

  // button locked
  function buttonLocked() {
    $this = $watchvideoStep.find('.active');
    if ($this.hasClass('active') && $this.next().hasClass('step-locked')) {
      $buttonLocked.show();
    } else {
      $buttonLocked.hide();
    }
  }
});

// watchvideo check state
function onPlayerStateChange(event) {
  var videoData = player.getVideoData(),
    videoId = videoData['video_id'],
    videoTitle = videoData.title;
  if (event.data == YT.PlayerState.ENDED) {
    alert(videoTitle + '\n시청을 완료하였습니다.');
    setCookie('GLK_watchvideo_' + videoId, true, 100 * 365);
    window.location.reload()
    console.log(thisVideoId);
  }
}

// set cookie
function setCookie(cname, cvalue, exdays) {
  var d = new Date();
  d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
  var expires = "expires=" + d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
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