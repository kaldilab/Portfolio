(function ($) {
  "use strict";

  // page name
  var pageName = "load";

  // 관리자게시판
  var page_board_user = 2;
  var $load_board_user_list = $(".load_board_user_list");
  var $load_board_user_btn = $(".load_board_user_btn");
  if ($load_board_user_list.length) {
    // get url
    if (window.location.hash) {
      var url_hash = window.location.hash;
      var get_number = url_hash.match(/\d/g).join("");
      var hash_number = parseInt(get_number);
      var get_string = url_hash.replace(/[0-9]/g, "");
      var hash_string = get_string.replace("#", "");
    }
    // click
    $load_board_user_btn.on("click", function () {
      window.location.hash = pageName + page_board_user;
      ajax_call_board_user();
    });
    // hash check
    if (url_hash && hash_string == pageName) {
      for (var i = 2; i < hash_number + 1; i++) {
        page_board_user = i;
        ajax_call_board_user();
      }
    }
    // function
    function ajax_call_board_user() {
      // loading
      $load_board_user_btn.after(
        '<div class="spinner-border" role="status"><span class="sr-only">Loading</span></div>'
      );
      // data
      var data = {
        action: "load_board_user",
        page: page_board_user,
        ajax_nonce: ajax_object.ajax_nonce,
      };
      // post
      $.post(ajax_object.ajax_url, data, function (response) {
        if (response != "") {
          $load_board_user_list.append(response);
          $(".spinner-border").remove();
          page_board_user++;
        } else {
          $load_board_user_btn.hide();
          $(".list_none").show();
          $(".spinner-border").remove();
        }
      });
    }
  }
})(jQuery);
