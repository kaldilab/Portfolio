// Youtube Unmute
hideUnmute();
function hideUnmute() {
  setTimeout(function () {
    $(".btn-ytunmute").hide();
  }, 6000);
}

function closeUnmute(event) {
  $(event).hide();
}