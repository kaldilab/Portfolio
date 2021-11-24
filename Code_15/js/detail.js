// Remove Speaker Text Tag
setTimeout(function() {
  $('.session-highlight-detail-speaker-text').each(function() {
    var speakerText = $(this).html();
    var removeTag = speakerText.replace(/<br><br>/g, "<br>");
    $(this).html(removeTag)
  });
}, 1000);