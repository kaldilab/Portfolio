// IE Check
detectIE();
function detectIE() {
  var agent = navigator.userAgent.toLowerCase();
  if (
    (navigator.appName == "Netscape" && agent.indexOf("trident") != -1) ||
    agent.indexOf("msie") != -1
  ) {
    $('.not-support').show();
    $('.rf-org-footer-container').addClass('ie');
    $('.widget-header').hide();
  }
}
  
// Mobile GNB
function mobileMenu(event) {
  var $this = $(event);
  var $headerNavbar = $(".header__navbar");
  $this.toggleClass("open");
  $headerNavbar.stop().slideToggle(250);
}

// Window Reload
orientationChange();
function orientationChange() {
  window.addEventListener("orientationchange", function () {
    location.reload();
  });
}
  
// Scroll To Top
$(window).on('scroll', function() {
  var $btnScrollTop = $(".btn-scrolltop");
  if (window.scrollY >= 200) {
    $btnScrollTop.addClass('active');
  } else {
    $btnScrollTop.removeClass('active');
  }
});
function scrollToTop() {
  window.scrollTo({
    top: 0,
    behavior: "smooth",
  });
}

// Privacy Scroll
function scrollPrivacySubject(num){
  var offset = $("#subject-" + num).offset().top;
  $('html, body').animate({scrollTop : offset - 164}, 400);
}

// Privacy Highlight
$(window).on("scroll", function () {
  scrollPrivacyHighlight();
});
function scrollPrivacyHighlight() {
  var position = window.pageYOffset;
  $('h4.privacy-cont-desc-tit').each(function () {
    var target = $(this).offset().top - 264;
    var id = $(this).attr('id');
    var navLinks = $('.privacy-side-subject-item p');
    if (position >= target) {
      navLinks.removeClass('active');
      $('.privacy-side-subject-item p[data-id="' + id + '"]').addClass('active');
    }
  });
  var scrollAmt = $(document).scrollTop();
  if (scrollAmt > 400) {
    $(".privacy-side-subject").addClass("active");
  } else {
    $(".privacy-side-subject").removeClass("active");
  }
}

// Support Toggle
function toggleSupport(event) {
  var $this = $(event);
  $('.support-subject-desc').stop().slideUp(300);
  $this.siblings('.support-subject-desc').not($this).stop().slideToggle(300);
  $this.toggleClass('open');
  $('.support-subject-tit').not($this).removeClass('open');
}