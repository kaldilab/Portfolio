# **프론트 가이드**

- [프론트엔드](#frontend)
- [에디터 : VSCode](#editor)
  - [에디터 세팅 방법](#editor-settings)
  - [필수 확장프로그램](#editor-extension-essential)
  - [추천 확장프로그램](#editor-extension-recommend)
- [퍼블리싱](#publishing)
  - [HTML](#publishing-html)
  - [CSS](#publishing-css)
  - [jQuery(ES5)](#publishing-jquery)
  - [접근성](#publishing-accessibility)
- [HTML&CSS](#htmlcss)
  - [방법론 : BEM](#bem)
  - [템플릿 : Bootstrap](#bootstrap)
- [네이밍 규칙](#naming)
  - [CSS 파일명](#naming-css)
  - [클래스명](#naming-class)
  - [이미지명](#naming-image)
- [퍼블리싱 패키지](#package) : <b style="color:orange;">[보기](https://github.com/kaldilab/Portfolio/tree/master/Code_08/project)</b>
- [CSS 전처리기 : SCSS](#preprocessor)
  - [SCSS 문법](#preprocessor-usage)
  - [SCSS 컴파일](#preprocessor-compile)
- [자바스크립트 플러그인](#plugin)
  - [코어](#plugin-core)
  - [슬라이더](#plugin-slider)
  - [모달](#plugin-modal)
  - [차트](#plugin-chart)
  - [원페이지](#plugin-onepage)
  - [유효성검사](#plugin-validation)
  - [기타](#plugin-etc)
- [Git](#git)
  - [Message](#git-message)

## <b id="frontend">프론트엔드</b>

- 프론트엔드 개발자에게 HTML, CSS, JQUERY 스킬은 기본으로 한다. 퍼블리싱 기반이 튼튼해야 라이브러리, 프레임워크 등을 더욱 효율적으로 활용할 수 있다.
- 퍼블리싱만으로 단일 웹페이지를 제작한다. 프론트 작업만으로도 완성도 있는 정보성 웹사이트를 제작하고 UI/UX 차원에서 고퀄의 화면을 구현해낸다.

## <b id="editor">에디터 : VSCode</b>

- 에디터는 **Visual Studio Code (VSCode)** 를 기본으로 한다.
- 개인 에디터를 사용할 수 있지만 공동작업 시에는 기본 에디터로 소통할 수 있어야 한다.
- 공동작업 시 전체 작업자에게 영향을 미치는 확장프로그램을 **필수**로 한다.
- 필수 확장프로그램의 **기본 세팅 값은 커스텀하지 않는다**.

### <b id="editor-settings">에디터 세팅 방법 (순서대로)</b>

- VSCode를 [다운로드](https://code.visualstudio.com/download) 하고 설치한다.
- VSCode를 다시 세팅할 때는 프로그램 재설치만으로는 초기화 되지 않기 때문에 ‎⁨세팅과 확장프로그램 파일을 직접 삭제해야 한다.
  1. Mac에서 파인더를 열고 숨김 파일 보기(cmd+shift+.)를 켠다.
  2. 세팅 삭제 : [Macintosh HD⁩] ▸ ⁨사용자⁩ ▸ {이름}⁩ ▸ ⁨라이브러리⁩ ▸ ⁨Application Support⁩ ▸ ⁨Code⁩ ▸ ⁨{모든 파일}
  3. 확장프로그램 삭제 : [Macintosh HD]⁩ ▸ ⁨사용자⁩ ▸ {이름}⁩ ▸ {.vscode}
- 에디터를 설치한 뒤 아래 **필수 확장프로그램** 을 전부 설치한다.
- Command Pallete를 열어 'settings'라고 검색하여 `Preferences: Open Settings (JSON)` 항목을 선택한다.
- 'settings.json' 파일이 열리면 [settings](https://github.com/kaldilab/Portfolio/tree/master/Code_08/settings/vscode_settings.json) 파일의 내용을 전부 복사하여 붙여넣기 한다.
- 에디터를 종료 후 재실행한다. 끝.

### <b id="editor-extension-essential">필수 확장프로그램 (Extensions)</b>

- [Prettier](https://marketplace.visualstudio.com/items?itemName=esbenp.prettier-vscode)
  - 코드 정렬
- [Visual Studio Intellicode](https://marketplace.visualstudio.com/items?itemName=VisualStudioExptTeam.vscodeintellicode)
  - 마이크로소프트에서 개발한 코드 자동 완성 및 추천
- [ESLint](https://marketplace.visualstudio.com/items?itemName=dbaeumer.vscode-eslint)
  - 자바스크립트 문법 검사
- [IntelliSense for CSS class names in HTML](https://marketplace.visualstudio.com/items?itemName=Zignd.html-css-class-completion)
  - 클래스명 자동 완성
- [Relative Path](https://marketplace.visualstudio.com/items?itemName=jakob101.RelativePath)
  - 경로 자동 완성
- [Live Sass Compiler](https://marketplace.visualstudio.com/items?itemName=ritwickdey.live-sass)
  - SASS 컴파일러 (Live Server 확장프로그램이 자동 설치됨)

### <b id="editor-extension-recommend">추천 확장프로그램 (Extensions)</b>

- Editor
  - [Sublime Text Keymap and Settings Importer](https://marketplace.visualstudio.com/items?itemName=ms-vscode.sublime-keybindings)
    - 서브라임 텍스트 기본 단축키 및 세팅 가져오기
  - [Monokai Pro](https://marketplace.visualstudio.com/items?itemName=monokai.theme-monokai-pro-vscode)
    - Monokai Pro 테마
  - [Bracket Pair Colorizer](https://marketplace.visualstudio.com/items?itemName=CoenraadS.bracket-pair-colorizer)
    - 브라켓((), {}, []) 세트를 컬러로 구분
  - [Active File In StatusBar](https://marketplace.visualstudio.com/items?itemName=RoscoP.ActiveFileInStatusBar)
    - 에디터 하단에 파일 관련 정보 확인
- Tools
  - [SFTP](https://marketplace.visualstudio.com/items?itemName=liximomo.sftp)
    - FTP Sync
  - [Lorem Ipsum](https://marketplace.visualstudio.com/items?itemName=Tyriar.lorem-ipsum)
    - Lorem Ipsum 더미 텍스트 자동 생성
  - [Text Pastry](https://marketplace.visualstudio.com/items?itemName=jkjustjoshing.vscode-text-pastry)
    - 숫자를 순서대로 자동 입력
  - [Auto Rename Tag](https://marketplace.visualstudio.com/items?itemName=formulahendry.auto-rename-tag)
    - 열림 태그를 수정하면 닫힘 태그도 같이 수정
- Git
  - [GitLens](https://marketplace.visualstudio.com/items?itemName=eamodio.gitlens)
    - 깃 히스토리 탐색기
  - [Git History](https://marketplace.visualstudio.com/items?itemName=donjayamanne.githistory)
    - 깃을 그래프 형식으로 볼 수 있는 익스텐션
- HTML&CSS
  - [Easy Less](https://marketplace.visualstudio.com/items?itemName=mrcrowl.easy-less)
    - LESS 컴파일러
  - [Open In Browser](https://marketplace.visualstudio.com/items?itemName=techer.open-in-browser)
    - option+b로 HTML 파일을 브라우저에서 열기 기능
- PHP
  - [PHP IntelliSense](https://marketplace.visualstudio.com/items?itemName=felixfbecker.php-intellisense)
    - PHP 코드 자동 완성
  - [PHP Intelephense](https://marketplace.visualstudio.com/items?itemName=bmewburn.vscode-intelephense-client)
    - PHP 코드 자동 정렬
  - [PHP Debug](https://marketplace.visualstudio.com/items?itemName=felixfbecker.php-debug)
    - PHP 디버깅
- jQuery
  - [jQuery Code Snippets](https://marketplace.visualstudio.com/items?itemName=donjayamanne.jquerysnippets)
    - jQuery 코드 자동 완성
- Markdown
  - [Markdown All in One](https://marketplace.visualstudio.com/items?itemName=yzhang.markdown-all-in-one)
    - 마크다운 플러그인

## <b id="publishing">퍼블리싱</b>

- W3C 문법과 슬로워크 표준 가이드를 지켜 코드를 작성한다.
- 다수의 공동작업이라 해도 한 명이 코딩한 것처럼 보이도록 한다.
- 코드의 효율성과 간결성을 위해 노력한다.
- 웹표준, 웹접근성, 브라우저 호환성 등을 최대한 체크한다.
- [W3C 통합 검사기](https://validator.w3.org/unicorn/?ucn_lang=ko) 등으로 웹표준 준수여부를 확인한다.
- IE10 이상, Edge, Chrome, Safari, Firefox 브라우저를 지원한다.
- css, javascript는 inline으로 작성하지 않도록 한다.
- [MDO 가이드](http://code-guide.aliencube.org/) 를 참고한다.

### <b id="publishing-html">HTML</b>

- 태그 속성은 아래 순서로 작성한다.
  1. id
  2. class
  3. name, data-\*
  4. src, for, type, href, value
  5. title, alt
  6. aria-\*, role
- HTML5 Doctype을 선언한다.

```
<!DOCTYPE html>
```

- HTML 문서의 주 언어를 언어속성(lang)에 설정한다.

```
<html lang="ko">
```

- `<head>`에 UTF-8로 인코딩을 설정한다.

```
<meta charset="UTF-8">
```

- IE 호환모드를 최신으로 작성한다.

```
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
```

- 반응형 프로젝트는 viewport 속성을 정의한다.

```
<meta name="viewport" content="width=device-width, initial-scale=1.0">
```

- Boolean 속성(disabled, checked, slelected 등)의 ‘값’은 지정하지 않는다.

```
<input type="text" disabled>
<input type="checkbox" value="1" checked>
```

css와 javascript를 불러올 때 'type' 속성을 생략한다.

```
<link rel="stylesheet" href="...">
<script src="..."></script>
```

단일 태그(br, img 등)에는 슬래시(/)를 사용하지 않는다.

```
ex) <img src="" alt="" /> // (X)
ex) <img src="" alt="">   // (O)
```

- 시작과 끝을 나타내는 주석은 다음과 같이 한다.

```
<!--주석-->
...
<!--//주석-->
```

- 속성(attr)값에는 항상 큰 따옴표를 사용한다.
- css 스타일이 없어도 html 문서 자체만으로도 내용과 구조를 알 수 있어야 한다.
- SEO와 웹접근성을 위해 HTML5의 Semantic 태그를 사용한다.

### <b id="publishing-css">CSS</b>

- 속성 선언 순서는 다음을 따른다.
  1. Position
  2. Box-model
  3. Typography(font)
  4. Visual(color, background..)
  5. etc
- 선택자를 그룹핑하는 경우 쉼표(,) 뒤에서 줄바꿈한다.

```
.item1,
.item2 {
  color: red;
}
```

- 속성값에는 따옴표(' ', " ")를 사용하지 않는다.

```
background: url(background.png);
```

- 한 줄에 하나의 속성만 작성하고, 마지막은 항상 세미콜론(;)으로 끝낸다.

```
div {
  display: inline-block;
  width: 16px;
  height: 15px;
  background-image: url(../img/sprite.png);
}
```

- 줄임 속성(background, padding, margin 등)을 사용할 때는 속성 순서를 맞춘다.

```
ex) div { background: no-repeat url(xxx.png); }                     // (X)
ex) div { background: #fff url(img_tree.png) no-repeat right top; } // (O)
```

- 배경에서 색상 값만 지정할 때는 background 줄임 속성 대신 backgroud-color 사용을 권장한다

```
ex) div { background: #f00; }       // (X)
ex) div { background-color: #f00; } // (O)
```

- 다중 속성값들은 쉼표(,) 뒤에 공백 또는 줄바꿈을 포함한다.

```
box-shadow: 1px 1px 1px #ccc, -1px -1px 1px #000;
```

- 괄호 안에서는 쉼표(,) 뒤에 공백을 넣지 않는다.

```
color: rgba(0,0,0,.5);
```

- `0` 값들에서는 단위를 쓰지 않는다. 축약 가능한 값은 최대한 축약한다.

```
margin: 0;
background-position: 50%;
opacity: .8
```

- 주석은 다음 형태로 간결하게 작성한다.

```
/* Modal */
```

- 반응형 설정을 위한 미디어쿼리는 별도의 파일이나 파일 하단에 모아놓지 않고 해당 규칙이 있는 자리에 최대한 가까이 위치시킨다.
- `@import` 사용을 지양한다. 여러 개의 `<link>`를 사용하거나, css 전처리기로 하나의 파일로 만든다.
- css는 모바일 먼저 작성하고 media query로 태블릿, 데스크톱 해상도 스타일을 작성한다.
- 블록, 섹션, 컴포넌트 단위 별로 코드를 모아서 작성한다.
- 선택자 우선순위를 높이는 조합과 중첩을 과도하게 사용하지 않는다.
- html 마크업 구조, 혹은 계층 구조의 순서에 따라 작성한다.

### <b id="publishing-jquery">jQuery(ES5)</b>

- jQuery 라이브러리는 1.12.4 이상 버전을 사용한다.
- 의존성을 생각해서 inline 코드 사용은 지양한다.
- 접근 용이성을 고려하여 순수 JavaScript와 jQuery를 혼용하는 것은 지양한다.
- 닫는 `</body>` 태그 전에 `<script>...</script>` 코드를 넣는다.
- 프로젝트 전역에 정의할 코드는 다음 이름의 파일에 정의한다.

```
project.js
```

- project.js 파일에서 특정 페이지의 객체를 대상으로 하는 코드는 **length** 체크를 해서 다른 페이지에서 에러가 나지 않도록 한다.
- 분리한 js 파일이나 외부 라이브러리 파일은 `/js` 폴더에 추가한다.
- 시작/종료 구문은 아래와 같이 선언한다.

```
(function($) {
  'use strict';

  // 코드가 들어가는 부분

})(jQuery);
```

- 위 ‘코드가 들어가는 부분'에 아래 선언문을 중첩하여 사용하지 않는다.

```
$(function() { … });
$(document).ready(function() { … });
jQuery(document).ready(function($) { … });
```

- 자주 사용하는 변수는 코드의 최상단에 정의한다.

```
var $window = $(window),
    $document = $(document);
```

- 객체를 참조한 변수명에는 `$`를 붙여 식별을 용이하게 한다.

```
var $header = $('.header');
```

- 변수명, 함수명 등 네이밍은 **camelCase**로 작성한다.
- 지나치게 축약된 변수명은 지양하고, 변수를 논리적으로 그룹화 한다.

```
ex) var bb; // bb가 무슨 뜻인지 알 수 없다
```

- `<a>` 태그 등의 기본 이벤트 속성을 방지할 때는 ‘return false’가 아닌 **event.preventDefault()** 를 사용한다.
- 이벤트 버블링 방지는 **event.stopPropagation()** 을 사용한다.
- 배포/오픈 전에는 console.log는 꼭 삭제한다. (IE 호환성 문제)
- 코드 이해를 돕기 위해 함수나 이벤트 명세 위에 최소 한 가지 주석은 남긴다. 그러나 잘 짜인 코드에 주석이 필수는 아니다.

### <b id="publishing-accessibility">접근성</b>

- [웹 접근성 연구소 가이드](https://www.wah.or.kr:444/Participation/guide.asp)를 기반으로 작성한다.
- 코드 최상단에 건너뛰기 링크를 제공한다.
- (선택) 건너뛰기 링크에 포커스 되었을 때 시각적으로 보여야한다.
- 디자인 시안에서 섹션에 제목이 없어도 스크린리더 전용 텍스트를 추가한다.
- 이미지의 alt는 필수이며 배경이미지로 대체할 수 있으면 [IR 기법](http://darum.daum.net/convention/css/css_ir)을 사용한다.
- IR 기법에서 보이스오버 인식을 위해 `font-size: 0`은 사용하지 않는다 .
- 웹페이지의 처음부터 끝까지 tab으로 조작할 수 있어야 한다.
- tab 조작시 논리적인 순서로 이동하도록 마크업한다.
- `<select>`는 그것을 작동시키는 버튼과 함께 제공한다.
- 셀렉트박스 형태로 디자인 되었더라도, 링크 이동하는 기능이라면 `<div>`나 `<a>`로 마크업한다.
- 자동으로 슬라이딩하는 캐로셀 UI는 재생/일시정지 버튼을 함께 제공한다.
- 새 창에서 팝업 열기보다 팝업 레이어를 사용을 권장한다.
- `<table>`은 `<caption>`을 제공한다.
- `<th>` 태그는 scope 속성을 명시한다.
- `<input>`, `<textarea>`, `<select>` 등 form 관련 태그에는 각각에 대응하는 `<label>`을 함께 작성한다.
- WAI-ARIA를 사용하여 접근성을 부여할 수 있으나, 올바르게 HTML을 사용한다면 WAI-ARIA 사용을 최소화할 수 있다.
- HTML을 의미 있게(Semantic Markup) 사용했는지 검토하고, HTML이 제공하는 의미와 부합하지 않을 때만 WAI-ARIA를 사용한다.

## <b id="htmlcss">HTML&CSS</b>

- HTML&CSS 작성은 BEM 방법론으로 하고, Bootstrap 템플릿을 활용한다.

### <b id="bem">방법론 : BEM</b>

- [BEM 방법론](http://getbem.com/naming/)의 기본 개념대로 작성한다. 단, **몇 가지 예외**를 둔다.
- BEM 방법론을 반영하여 작성한 아래 예시들을 참조한다.
  - HTML
    - [엄격하게 Ver.](https://github.com/kaldilab/Portfolio/tree/master/Code_08/bem/bem_1.html)
    - [유연하게 Ver.](https://github.com/kaldilab/Portfolio/tree/master/Code_08/bem/bem_2.html)
  - CSS
    - [엄격하게 Ver.](https://github.com/kaldilab/Portfolio/tree/master/Code_08/bem/bem_1.css)
    - [유연하게 Ver.](https://github.com/kaldilab/Portfolio/tree/master/Code_08/bem/bem_2.css)
- 블록(Block)은 다음 7개 태그에만 한정한다.

```
<header>, <nav>, <aside>, <article>, <main>, <section>, <footer>
```

- 블록 안에 블록을 두는 것은 지양하되, 그래야만 하는 상황에선 각 블록이 명확히 구분될 수 있도록 한다.

```
<!-- main 블록 안에 main__section 엘리먼트이자 section1/section2 블록이 있다. -->
<main class="main">
  <section class="main__section section1">
    <p class="section1__title"></p>
    <p class="section1__desc"></p>
  </section>
  <section class="main__section section2">
    <p class="section2__title"></p>
    <p class="section2__desc"></p>
  </section>
</main>
```

- 블록 클래스명은 전체 웹사이트에서 다른 블록명과 차별화되어 중복되지 않아야 한다.
- 블록명과 엘리먼트명은 완전한 형태의 단어로 짓는다. 단, 엘리먼트명은 축약하거나 이니셜을 사용할 수도 있다.
- 블록(B)과 엘리먼트(E)의 개념은 엄격히 따르나, 모디파이어(M)는 생략할 수 있다.
- 블록 내부 DOM 트리의 최종 요소에는 클래스를 생략할 수도 있다.

```
<section class="block">
  <h2 class="block__title"></h2>
  <ul class="block__list">
    <li class="block__item">
      <figure>
        <img src="" alt="">
        <figcaption></figcaption>
      </figure>
    </li>
  </ul>
</section>
```

- 엘리먼트는 최대한 해당 요소의 의미에 들어맞고 시각적으로도 구분되는 태그를 사용한다.
- 비슷한 성질의 요소라면 고민하지 말고 다른 블록에서 사용한 엘리먼트를 반복 재사용한다. 블록 내에서만 엘리먼트명이 중복되지 않으면 된다. 차별화되는 태그라면 태그명을 엘리먼트명에 그대로 사용하여 네이밍 고민 시간을 줄인다.
- BEM 방법론의 기본 개념 대로 코딩한 후에 공통 요소에 대해서는 별도의 규칙을 따른다.

### <b id="bootstrap">템플릿 : Bootstrap</b>

- [부트스트랩 가이드](https://getbootstrap.com/docs/4.3/getting-started/introduction/)를 기반으로 작성한다.
- 모든 퍼블리싱마다 부트스트랩 최신 버전 템플릿을 활용하여 작업한다.
- 아래 두 파일을 필수적으로 임포트한다.(경우에 따라 reboot, grid, bundle 등의 파일로 변경할 수 있다.)

```
bootstrap.min.css
bootstrap.min.js
```

## <b id="naming">네이밍 규칙</b>

- 기본적으로 BEM 방식의 규칙을 따른다.
- 모든 프로젝트마다 bootstrap의 css파일을 임포트하고 관련 네이밍 규칙을 따른다.
- 부트스트랩 파일을 임포트하여 초기화 요소나 공통 요소들을 활용한다.

### <b id="naming-css">CSS 파일명</b>

- 프로젝트의 코어 css(scss) 파일명은 다음으로 한다.

```
project.css(scss)
```

- 개별 프로젝트에서 생성된 scss 파일들은 project.scss에 임포트하여 컴파일한다.
  1. \_{filename}.scss에서 작업
  2. project.scss에 임포트
  3. project.css로 컴파일
- project.scss에는 스타일 선언은 하지 않고 다른 scss 파일들을 임포트하는 용도로만 사용한다.
- 필수 scss 파일 구성과 용도는 다음과 같이 한다.(파일명 수정 불가)

```
_common.scss : 공통, 헤더, 푸터, 모달 등등
_main.scss : 홈, 메인, 프론트 등등
_sub.scss : 서브 레이아웃, 서브 컨텐츠 등등
```

- 필수 scss 파일 외의 파일을 추가할 때 파일명은 언더스크어(\_)로 시작한다.

```
ex) _form.scss
ex) _popup.scss
ex) _sub_01.scss
```

- 폰트 페이스 선언은 `fonts` 내의 각 폰트 폴더 안에 포함시킨다.
- 파일명은 해당 폰트명으로 한다.

```
ex) NotoSansKR.css
```

### <b id="naming-class">클래스명</b>

- 개별 프로젝트의 공통 요소들은 `_layout.scss` 파일에서 정의하고 클래스명은 다음 규칙을 따른다.
  - 3글자 이니셜과 **언더스크어(\_) 한 개**를 접두어로 한다.
  - 경우에 따라서는 3글자 이상을 접두어로 사용할 수도 있다.

```
ex) 폰트색(col_), 배경색(bgc_), 버튼(btn_), 인풋(ipt_), 타이틀(tit_), 텍스트(txt_), 테이블(tbl_), 팝업(pop_), 모달(modal_)
```

- 접두어 다음에 순번을 붙이는 걸 기본으로 하되 타입별 접미어를 붙일 수도 있다.

```
ex) txt_type_01, btn_large, tbl_ty_01
```

- 변화를 주는 클래스명은 다음과 같이 한다.
  - 화면에서 보이던 요소의 형태 변화 : **on**, **off**
  - 화면에서 보이지 않던 요소의 노출/비노출 1 : **active**, **inactive**
  - 화면에서 보이지 않던 요소의 노출/비노출 2 : **visible**, **invisible**
  - 포지션 고정 : **fixed**
  - 스크롤 고정 : **locked**
  - 현재를 나타내는 클래스 : **current**
- 모든 네이밍의 순번은 ‘언더스코어(\_) + nn’ 형태로 한다.

```
ex) btn_01, txt_01
```

- **아이디명**은 아래와 같이 `-`로 네이밍한다.

```
id="name-name"
```

### <b id="naming-image">이미지명</b>

- 이미지는 아이콘, 사진 등의 성격에 따라 3글자 이니셜과 언더스크어(\_) 한 개를 접두어로 한다.
- 해당 이미지의 위치가 블록 요소인지 엘리먼트 요소인지에 따라 아래와 같이 네이밍한다.
  - **타입*블록*엘리먼트\_순번(성격).png**

```
ex) ico_block_element_01.png
ex) img_block_prev.jpg
ex) ico_block_01.png
```

- 사진형 이미지는 jpg로 임포트하고, 일반형 이미지는 png로 임포트하되, svg 임포트가 가능하다면 svg로 한다.
- 제플린에서 이미지 임포트 시 사이즈는 다음과 같이한다.
  - 가로 720픽셀 이상 이미지 : 1배(1x)
  - 가로 720픽셀 이하 이미지 : 2배(2x)
- 웹폰트는 공통 저장소에 있는 폰트 파일과 폰트 페이스 선언을 그대로 가져다 쓴다.

## <b id="package">퍼블리싱 패키지</b>

- 퍼블리싱 작업 시에 퍼블리싱 패키지를 활용한다. [보기](https://github.com/kaldilab/Portfolio/tree/master/Code_08/project)
- 퍼블리싱 패키지의 구성은 다음과 같다.

```
[PROJECT]
  [assets]
    plugins...
  [css]
    project.css
  [fonts]
    [somefont]
      font.scss
      font_file...
  [html]
    html_file...
  [images]
    images...
  [scss]
    project.scss
    _common.scss
    _main.scss
    _sub.scss
  [js]
    project.js
```

- 퍼블리싱 패키지를 그대로 사용하고, 퍼블리싱 가이드 대로 작업한다.
- html 파일명은 프로젝트의 페이지 ID를 따른다.
- 제2의 플랫폼(라이브러리, 프레임워크 등등)을 활용한 개발이 아닌 경우엔 퍼블리싱 가이드를 충실히 따른다.
- 프로젝트 개발 플랫폼과 프레임워크 등의 사용 여부에 따라, **퍼블리싱 가이드와 퍼블리싱 패키지는 무시될 수 있다**.

## <b id="preprocessor">CSS 전처리기 : SCSS</b>

- CSS 전처리기는 [SCSS](https://sass-lang.com/)로 한다.

### <b id="preprocessor-usage">SCSS 문법</b>

- SCSS 기본 작성 방법은 다음 사이트들을 참고한다.
- [Sass Basics](https://sass-lang.com/guide)
- [Sass Tutorial](https://www.w3schools.com/sass/default.asp)
- [Sass(SCSS) 완전 정복!](https://heropy.blog/2018/01/31/sass/)

### <b id="preprocessor-compile">SCSS 컴파일</b>

- CSS 컴파일은 프로젝트별 자동 컴파일 시스템을 세팅하여 실행하는 것으로 하나, 기본적으로 VSCode를 통해 SCSS를 CSS로 컴파일하여 사용하는 것을 공유한다.
- VSCode SASS 컴파일러 확장 프로그램
  - [Live Sass Compiler](https://marketplace.visualstudio.com/items?itemName=ritwickdey.live-sass)
- 컴파일 방법
  1. VSCode에서 확장프로그램을 설치한다.
  2. Command Palette를 열어 `Live Sass : Watch Sass`를 검색하여 실행한다.(또는, 에디터 하단 상태바의 ‘Watch Sass’를 클릭)
  3. 한 번 실행 후에는 저장만 하면 자동으로 컴파일이 된다.
  4. 컴파일 실행메시지는 VSCode의 'OUTPUT' 창에서 확인할 수 있다.
- 세팅([settings.json](https://github.com/ritwickdey/vscode-live-sass-compiler/blob/master/docs/settings.md))

```
"liveSassCompile.settings.formats": [{
  "format": "compressed",
  "savePath": "~/../css"
}],
```

- format은 가급적 **compressed** 으로 하고 컴파일 결과를 주기적으로 확인이 필요한 경우에만 **compact** 로 함. **expaned** 는 지양.
- 소스맵 파일은 자동 생성하도록 그대로 둠.
- ‘Project’ 폴더 구조가 루트에 [scss], [css] 폴더가 있으므로, 전자에는 scss파일을 두고 후자에는 css파일이 컴파일 되도록 함.
- 여러 개의 scss파일을 한 개의 css파일로 컴파일 할 때는, [scss] 폴더에 파일들을 아래와 같이 구성함.

```
project.scss
_{filename1}.scss
_{filename2}.scss
_{filename3}.scss
```

- project.scss 파일 외의 scss파일들은 파일명에 언더스코어(\_)를 붙여주고, project.scss에 임포트한다.
- **주의사항** : VSCode Workspace에 다른 프로젝트나 작업과 무관한 scss파일들이 있을 경우 ‘Watch Sass’가 그 파일들도 자동으로 컴파일할 수 있으니 한 개의 프로젝트만 작업하거나 ‘liveSassCompile.settings.excludeList’ 옵션을 추가해서 컴파일 대상에서 제외시켜야 함.

## <b id="plugin">자바스크립트 플러그인</b>

### <b id="plugin-core">코어</b>

- [jQuery UI](https://jqueryui.com/)
  - Demos : https://jqueryui.com/demos/
  - 프로젝트 진행 시 아코디언 같은 위젯 등을 스크립트 짜고 싶지 않을 때 바로 적용할 수 있게 jQuery 라이브러리와 함께 기본 인클루드 하는 게 좋을 듯함. 애니메이션 Easing 값을 적용하는 데 필요한 Effect 스크립트도 내장되어 있어서 애니메이션 작업 시에는 필수.

### <b id="plugin-slider">슬라이더</b>

- [Swiper](https://swiperjs.com/)
  - Demos : https://swiperjs.com/demos/
  - 슬라이더를 커스텀해야 할 땐 무조건 Swiper를 사용함. 다른 슬라이더와의 차이는 HTML Dom을 자동생성하지 않는다는 점. 기본 Dom이 그대로 유지된 상태에서 커스텀할 수 있어서 자유로운 변형이 가능. 작은 모바일 애플리케이션을 만들 수 있을 정도. 무수한 예시와 API를 제공. 다른 플러그인들과의 충돌이 없음.
- [Slick](http://kenwheeler.github.io/slick/)
  - Demos : http://kenwheeler.github.io/slick/#demos
  - 슬라이더 커스텀을 안 할 때 사용함. 다른 플러그인들과의 충돌이 없음.

### <b id="plugin-modal">모달</b>

- [Magnific Popup](https://dimsemenov.com/plugins/magnific-popup/)
  - Docu : http://dimsemenov.com/plugins/magnific-popup/documentation.html
  - 팝업 이미지 슬라이더, 팝업 뷰어, 팝업 갤러리, 팝업 비디오 플레이어, Ajax 팝업, 팝업 폼, 컨텐츠 팝업 등 팝업을 다양하게 커스텀 할 수 있음. 프로젝트 전체에 다양한 팝업을 띄우거나 반응형 작업을 할 땐 마그니픽 팝업 하나로 모두 커버하는 게 좋음.

### <b id="plugin-chart">차트</b>

- [Chart.js](https://www.chartjs.org)
  - Demos : https://www.chartjs.org/samples/latest/
  - 다양한 차트와 API를 제공함. 옵션 값을 잘 찾으면 다양한 커스텀이 가능함. 프로젝트 진행 시 기획이나 디자인 파트와 협의하여 샘플페이지에서 차트의 기본 외형을 벤치마킹하도록 유도할 필요가 있음. Canvas 방식이라 CSS로 차트의 외형을 커스텀하기가 까다로움.
- [Google Charts](https://developers.google.com/chart?hl=ko)
  - Demos : https://developers.google.com/chart/interactive/docs?hl=ko
  - 차트 외형 면에서는 Chart.js보다는 촌스러움. 다양한 차트와 API를 제공하고 브라우저 호환성이 좋음. HTML5/SVG 방식이어서 JS, CSS로 차트의 외형을 커스텀할 수 있음.
- [D3.js](https://d3js.org)
  - Docu : https://github.com/zziuni/d3/wiki
  - 복잡한 차트를 구현할 때 사용함. HTML5/SVG 방식. 차트 타입에 따라 Canvas 방식도 있음.

### <b id="plugin-onepage">원페이지</b>

- [Fullpage.js](https://alvarotrigo.com/fullPage/ko/)
  - Docu : https://github.com/alvarotrigo/fullpage.js
  - v2.9.7 : https://github.com/alvarotrigo/fullPage.js/releases/tag/2.9.7
  - 원페이지나 풀페이지 사이트 구현 시 거의 대체 불가능한 플러그인. 마우스 휠/스크롤 애니메이션 등을 구현할 때 발생하는 다양한 이슈에 일일이 대응하고 싶지 않으면 무조건 사용할 것. 다양한 Method와 Callback을 제공함. v3.0 이후부터는 유료구매를 하지 않으면 콘솔창에 라이센스 구매하라는 메시지가 뜸. 그 메시지를 보고 싶지 않으면 v2.9.7 버전을 사용할 것.

### <b id="plugin-validation">유효성검사</b>

- [jQuery Validation](https://jqueryvalidation.org/)
  - Docu : https://jqueryvalidation.org/validate/
- [Parsley](http://parsleyjs.org/)
  - Docu : http://parsleyjs.org/doc/index.html

### <b id="plugin-etc">기타</b>

- [jQuery Steps](http://www.jquery-steps.com/)
  - Demos : http://www.jquery-steps.com/Examples
  - 폼 탭/컨텐트 플러그인. 스텝 방식의 회원가입 폼 구현 시 사용하면 유용.

## <b id="git">Git</b>

### <b id="git-message">Message</b>

- 공동 프로젝트의 경우 깃 메시지는 커밋할 데이터 변화의 핵심 또는 요약 정보를 **문장형**으로 작성한다.
- "~합니다" 형태의 동사로 끝맺어 메시지를 전달하면 단어나 구나 절의 형태로 작성하는 것보다 일관된 톤을 유지하여 메시지 전달에 더 효과적이다.
- 문장형으로 작성하면 자기도 모르게 해당 커밋의 핵심 내용을 정리하게 되고, 다른 작업자도 메시지를 이해하는 데 수월해진다.

```
ex) git commit -m "임시로 뉴스레터 플러그인에 구독자를 저장하던 로직을 삭제합니다."
ex) git commit -m "무한스크롤이 작동하도록 변경합니다."
```
