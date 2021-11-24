// Survey Variables
var surveyDate1 = "2021-10-26T";
var surveyDate2 = "2021-10-27T";
var surveyTime1 = new Date(surveyDate1 + "11:00:00-07:00");
var surveyTime2 = new Date(surveyDate1 + "12:00:00-07:00");
var surveyTime3 = new Date(surveyDate1 + "13:00:00-07:00");
var surveyTime4 = new Date(surveyDate1 + "14:00:00-07:00");
var surveyTime5 = new Date(surveyDate1 + "16:00:00-07:00");
var surveyTime6 = new Date(surveyDate1 + "18:00:00-07:00");
var surveyTime7 = new Date(surveyDate1 + "20:00:00-07:00");
var surveyTime8 = new Date(surveyDate1 + "22:00:00-07:00");
var surveyTime9 = new Date(surveyDate2 + "00:00:00-07:00");
var surveyEnd = new Date(surveyDate2 + "01:00:00-07:00");

// Survey Popup Checker
surveyPopupChecker();
function surveyPopupChecker() {
  // now
  var now = new Date();

  setInterval(function() {
    // del cookie
    if (now >= surveyTime1 && now < surveyTime2) {
      console.log('start');
    } else if (now >= surveyTime2 && now < surveyTime3) {
      delSurveyPopupCookie('surveyPopup1');
    } else if (now >= surveyTime3 && now < surveyTime4) {
      delSurveyPopupCookie('surveyPopup1');
      delSurveyPopupCookie('surveyPopup2');
    } else if (now >= surveyTime4 && now < surveyTime5) {
      delSurveyPopupCookie('surveyPopup1');
      delSurveyPopupCookie('surveyPopup2');
      delSurveyPopupCookie('surveyPopup3');
    } else if (now >= surveyTime5 && now < surveyTime6) {
      delSurveyPopupCookie('surveyPopup1');
      delSurveyPopupCookie('surveyPopup2');
      delSurveyPopupCookie('surveyPopup3');
      delSurveyPopupCookie('surveyPopup4');
    } else if (now >= surveyTime6 && now < surveyTime7) {
      delSurveyPopupCookie('surveyPopup1');
      delSurveyPopupCookie('surveyPopup2');
      delSurveyPopupCookie('surveyPopup3');
      delSurveyPopupCookie('surveyPopup4');
      delSurveyPopupCookie('surveyPopup5');
    } else if (now >= surveyTime7 && now < surveyTime8) {
      delSurveyPopupCookie('surveyPopup1');
      delSurveyPopupCookie('surveyPopup2');
      delSurveyPopupCookie('surveyPopup3');
      delSurveyPopupCookie('surveyPopup4');
      delSurveyPopupCookie('surveyPopup5');
      delSurveyPopupCookie('surveyPopup6');
    } else if (now >= surveyTime8 && now < surveyTime9) {
      delSurveyPopupCookie('surveyPopup1');
      delSurveyPopupCookie('surveyPopup2');
      delSurveyPopupCookie('surveyPopup3');
      delSurveyPopupCookie('surveyPopup4');
      delSurveyPopupCookie('surveyPopup5');
      delSurveyPopupCookie('surveyPopup6');
      delSurveyPopupCookie('surveyPopup7');
    } else if (now >= surveyTime9 && now < surveyEnd) {
      delSurveyPopupCookie('surveyPopup1');
      delSurveyPopupCookie('surveyPopup2');
      delSurveyPopupCookie('surveyPopup3');
      delSurveyPopupCookie('surveyPopup4');
      delSurveyPopupCookie('surveyPopup5');
      delSurveyPopupCookie('surveyPopup6');
      delSurveyPopupCookie('surveyPopup7');
      delSurveyPopupCookie('surveyPopup8');
    }
    // get cookie
    if (now >= surveyTime1 && now < surveyEnd) {
      if (getSurveyPopupCookie("surveyPopup1") == "Y") {
        $('.survey-popup').hide();  
      } else if (getSurveyPopupCookie("surveyPopup2") == "Y") {
        $('.survey-popup').hide();  
      } else if (getSurveyPopupCookie("surveyPopup3") == "Y") {
        $('.survey-popup').hide();  
      } else if (getSurveyPopupCookie("surveyPopup4") == "Y") {
        $('.survey-popup').hide();  
      } else if (getSurveyPopupCookie("surveyPopup5") == "Y") {
        $('.survey-popup').hide();  
      } else if (getSurveyPopupCookie("surveyPopup6") == "Y") {
        $('.survey-popup').hide();  
      } else if (getSurveyPopupCookie("surveyPopup7") == "Y") {
        $('.survey-popup').hide();  
      } else if (getSurveyPopupCookie("surveyPopup8") == "Y") {
        $('.survey-popup').hide();  
      } else if (getSurveyPopupCookie("surveyPopup9") == "Y") {
        $('.survey-popup').hide();  
      } else {
        $('.survey-popup').show();
      }
    } else {
      $('.survey-popup').hide();
    }
  }, 1000);
  console.log('기준', surveyTime1);
  console.log('현재', now);
  console.log('종료', surveyEnd);
}

// Survey Popup Close
function closeSurveyPopup(now) {
  // set cookie
  if (now >= surveyTime1 && now < surveyTime2) {
    setSurveyPopupCookie("surveyPopup1", "Y", 1);
  } else if (now >= surveyTime2 && now < surveyTime3) {
    setSurveyPopupCookie("surveyPopup2", "Y", 1);
  } else if (now >= surveyTime3 && now < surveyTime4) {
    setSurveyPopupCookie("surveyPopup3", "Y", 1);
  } else if (now >= surveyTime4 && now < surveyTime5) {
    setSurveyPopupCookie("surveyPopup4", "Y", 1);
  } else if (now >= surveyTime5 && now < surveyTime6) {
    setSurveyPopupCookie("surveyPopup5", "Y", 1);
  } else if (now >= surveyTime6 && now < surveyTime7) {
    setSurveyPopupCookie("surveyPopup6", "Y", 1);
  } else if (now >= surveyTime7 && now < surveyTime8) {
    setSurveyPopupCookie("surveyPopup7", "Y", 1);
  } else if (now >= surveyTime8 && now < surveyTime9) {
    setSurveyPopupCookie("surveyPopup8", "Y", 1);
  } else if (now >= surveyTime9 && now < surveyEnd) {
    setSurveyPopupCookie("surveyPopup9", "Y", 1);
  }
  $('.survey-popup').hide();
  console.log('클릭', now);
}

// Popup Cookie
function setSurveyPopupCookie(name, value, expiredays) {
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
function getSurveyPopupCookie(name) {
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
function delSurveyPopupCookie(name) {
  var expireDate = new Date();
  expireDate.setDate(expireDate.getDate() - 1);
  document.cookie = name + "= " + "; expires=" + expireDate.toGMTString() + "; path=/";
}