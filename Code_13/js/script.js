$(document).ready(function () {
    // message view
    if($('.msg-view .msg-paper').innerHeight() < 300) {
        $('.msg-view .msg-paper').addClass('active');
    }

    // load
    $(window).on('load', function() {
        $('.msg-container').show();
        $('.msg-view .msg-card').find('.deco').addClass('ani');
    });

    // skin slider
    var skinSlider = $('.skin-slider').slick({
        dots: true,
        variableWidth: true,
        centerMode: true,
        centerPadding: '30px',
        slidesToShow: 1,
        arrows: false,
    });
    skinSlider.on('afterChange', function(event, slick, currentSlide){
        var currentNumber = currentSlide + 1;
        var formatNumber = ('0' + currentNumber).slice(-2);
        $('.slick-slide').removeClass('on');
        $('.skin-number').val(formatNumber);
        // background
        $('.msg-card').removeClass(function (index, className) {
            return (className.match (/(^|\s)skin-\S+/g) || []).join(' ');
        });
        $('.msg-card').addClass('skin-' + formatNumber);
    });
    $('.slick-slide').on('click', function() {
        if($(this).hasClass('slick-current')) {
            $(this).addClass('on');
            $('.msg-container').addClass('active');
            $('.msg-container .msg-card').addClass('active');
            $('.msg-container .msg-card').find('.deco').addClass('ani');
            $('.msg-container .msg-box').addClass('active');
        }
    });

    // message back
    $('.msg-back').on('click', function() {
        $('.slick-slide').removeClass('on');
        $('.msg-container').removeClass('active');
        $('.msg-container .msg-card').removeClass('active');
        $('.msg-container .msg-card').find('.deco').removeClass('ani');
        $('.msg-container .msg-box').removeClass('active');
        youtubeStop();
    });
    scrollAni('.msg-back', 'scroll', 1.8, 1);

    // message select
    $('.msg-select-item').on('click', function() {
        var $this = $(this);
        // selected
        $this.siblings().removeClass('selected');
        $this.addClass('selected');
        // popup
        $('body').removeAttr('style');
        $('.msg-select, .dimmed').hide();
        // text
        if($this.find('.msg-select-text strong').length) {
            var selectedTextStrong = $this.find('.msg-select-text strong').html();
            var selectedTextSpan = $this.find('.msg-select-text span').html();
            var selectedText = selectedTextStrong + selectedTextSpan;
        } else {
            var selectedText = '';
        }
        var selectedTextConvert = replaceAllTxt(selectedText,'<br>', '\n');
        let textLength = selectedTextConvert.length;
        $('.msg-form').val(selectedTextConvert);
        $('.msg-form').html(selectedTextConvert);
        $('.msg-form')[0].setSelectionRange(textLength, textLength);
        $('.msg-form').focus();
    });

    // message form
    $('.msg-form').on('keyup focus', function(){
        var formValue = $(this).val();
        var formValueLength = formValue.length;
        $('.msg-length').find('strong').text(formValueLength);
        textareaLimit();
    });

    // message slider
    var msgSlider = $('#msgSlider, #msgSliderPreview').slick({
        variableWidth: true,
        centerMode: true,
        slidesToShow: 1,
        arrows: false,
        infinite: false,
    });
    msgSlider.on('afterChange', function(event, slick, currentSlide, nextSlide){
        youtubeStop();
    });

    // message video play
    $('.msg-video-play').on('click', function() {
        var $this = $(this);
        var videoIndex = $this.attr('data-video-index');
        if (videoIndex == 1) {
            window.youtubeVideo1.playVideo();
            window.youtubeVideo1.mute();
        } else if (videoIndex == 2) {
            window.youtubeVideo2.playVideo();
            window.youtubeVideo2.mute();
        } else if (videoIndex == 3) {
            window.youtubeVideo3.playVideo();
            window.youtubeVideo3.mute();
        } else if (videoIndex == 4) {
            window.youtubeVideo4.playVideo();
            window.youtubeVideo4.mute();
        } else if (videoIndex == 5) {
            window.youtubeVideo5.playVideo();
            window.youtubeVideo5.mute();
        } else if (videoIndex == 6) {
            window.youtubeVideo6.playVideo();
            window.youtubeVideo6.mute();
        }
        $this.siblings('.msg-video-thumb').hide();
        $this.hide();
    });

    // message preview
    $('.msg-preview-btn').on('click', function() {
        $('#msgSliderPreview').get(0).slick.setPosition();
        $('.msg-preview').find('.cont').append($('.msg-banner').clone());
        $('.msg-result').html($('.msg-form').val().replace(/\r?\n/g, '<br>'));
        $('.msg-preview .msg-card').find('.deco').addClass('ani');
        if($('.msg-preview .msg-paper').innerHeight() < 300) {
            $('.msg-preview .msg-paper').addClass('active');
        }
        youtubeStop();
    });
    $('.msg-preview').find('.closeL').on('click', function() {
        $('.msg-preview').find('.msg-banner').remove();
        $('.msg-preview .msg-card').find('.deco').removeClass('ani');
        $('.msg-preview .msg-paper').removeClass('active');
        youtubeStop();
    });

    // message share
    $('.msg-share-list-btn').on('click', function(event) {
        if($('.msg-form').val().length < 1) {
            $('.alertBox').show();
        } else {
            MOBILE.layerPopup.openPop('#msgShare');
        }
    });
    $('.msg-share-item').on('click', function() {
        var $this = $(this);
        var thisIndex = $(this).index();
        // selected
        $this.siblings().removeClass('selected');
        $this.addClass('selected');
        // button
        $('.msg-share-btn').hide();
        $('.msg-share-btn').eq(thisIndex).show();
    });
    $('.alertBoxClose').on('click', function() {
        $('.alertBox').hide();
    });

    // replace text
    function replaceAllTxt(val, txt, replace) {
		return val.split(txt).join(replace);
	}

    // textarea limit
    function textareaLimit() {
        var tempText = $('.msg-form');
        var tempChar = '';
        var tempChar2 = '';
        var countChar = 0;
        var tempHangul = 0;
        var maxSize = 150;
        for(var i = 0 ; i < tempText.val().length; i++) {
            tempChar = tempText.val().charAt(i);
            if(escape(tempChar).length > 4) {
                countChar += 2;
                tempHangul++;
            } else {
                countChar++;
            }
        }
        if((countChar-tempHangul) > maxSize) {
            tempChar2 = tempText.val().substr(0, maxSize-1);
            tempText.val(tempChar2);
        }
    }

    // youtube stop
    function youtubeStop() {
        if($('#youtubeVideo1').length) {
            window.youtubeVideo1.stopVideo();
        }
        if($('#youtubeVideo2').length) {
            window.youtubeVideo2.stopVideo();
        }
        if($('#youtubeVideo3').length) {
            window.youtubeVideo3.stopVideo();
        }
        if($('#youtubeVideo4').length) {
            window.youtubeVideo4.stopVideo();
        }
        if($('#youtubeVideo5').length) {
            window.youtubeVideo5.stopVideo();
        }
        if($('#youtubeVideo6').length) {
            window.youtubeVideo6.stopVideo();
        }
        $('.msg-video-thumb').show();
        $('.msg-video-play').show();
    }

    // scroll ani up & down
    function scrollAni(target, aniClasses, elemPosition, elemSize) {
        if ($(target).length) {
            $(target).each(function() {
                var $window = $(window),
                    $target = $(this);
                $window.on("scroll resize", function() {
                    var windowScrollTop = $(this).scrollTop(),
                        windowHeight = $(this).height();
                    if (windowScrollTop >= $target.offset().top - windowHeight / elemPosition + $target.height() / elemSize && windowScrollTop <= $target.offset().top + $target.height()) {
                        $target.addClass(aniClasses);
                    } else {
                        $target.removeClass(aniClasses);
                    }
                });
            });
        }
    }

});

// youtube video
var tag = document.createElement('script');
tag.src = "https://www.youtube.com/iframe_api";
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

window.ytPlayerList = [];
window.ytPlayerList.push(
    { Id: 'youtubeVideo1', DivId: 'youtubeVideo1', VideoId: '8aRiQBbKWIM' },
    { Id: 'youtubeVideo2', DivId: 'youtubeVideo2', VideoId: 'Fnd16uxjWVY' },
    { Id: 'youtubeVideo3', DivId: 'youtubeVideo3', VideoId: 'qFZjlZxQDWk' },
    { Id: 'youtubeVideo4', DivId: 'youtubeVideo4', VideoId: '8aRiQBbKWIM' },
    { Id: 'youtubeVideo5', DivId: 'youtubeVideo5', VideoId: 'Fnd16uxjWVY' },
    { Id: 'youtubeVideo6', DivId: 'youtubeVideo6', VideoId: 'qFZjlZxQDWk' },
);

function onYouTubeIframeAPIReady() {
    for (var i = 0; i < ytPlayerList.length; i++) {
        var player = ytPlayerList[i];
        var pl = new YT.Player(player.DivId, {
            width: '100%',
            height: '100%',
            videoId: player.VideoId,
            playerVars: { 'playsinline':1, 'modestbranding':1, 'rel':0 },
        });
        window[player.Id] = pl;
    }
}