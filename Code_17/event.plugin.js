export default ({ app }, inject) => {
  const bootstrap = process.client ? require('bootstrap') : null

  inject('eventInitMasonry', (selector, that) => {
    const Masonry = require('masonry-layout')
    const imagesLoaded = require('imagesloaded')
    if (selector) {
      imagesLoaded(selector, () => {
        that.masonryInstance = new Masonry(selector, {
          gutter: 24,
          percentPosition: true,
        })
        that.masonryInstance.layout()
      })
    }
  })
  // Event Init Offcanvas
  inject('eventInitOffcanvas', () => {
    document.querySelectorAll('.th-header, .th-sidebar, .th-panel, .th-ctrler, .th-chatter, .th-editor').forEach((element) => {
      const clickEventHandler = () => app.$eventHideAllOffcanvas()
      element.removeEventListener('click', clickEventHandler)
      element.addEventListener('click', clickEventHandler)
    })
  })
  // Event Speech Bubble
  inject('eventInitSpeechBubble', () => {
    let currentSpeechBubble = null
    let currentHoverElement = null
    const createSpeechBubble = (btnSpeech) => {
      const data = btnSpeech.dataset
      const type = data.speechType
      const place = data.speechPlace
      const title = data.speechTitle
      const desc = data.speechDesc
      const position = btnSpeech.getBoundingClientRect()
      const width = position.width
      const height = position.height
      const startX = position.x
      const startY = position.y
      const midX = startX + width / 2
      const midY = startY + height / 2
      const endX = position.right
      const endY = position.bottom
      let html = ''
      html += `<div class="speech-bubble speech-${type} speech-${place}">`
      title && (html += `<h6>${title}</h6>`)
      html += `<div>${desc}</div>`
      html += `</div>`
      const dom = app.$utilDom(html)
      const speechBubble = dom.body.querySelector('.speech-bubble')
      const speechBubbleStyle = speechBubble.style
      if (place === 'top') {
        speechBubbleStyle.left = midX + 'px'
        speechBubbleStyle.top = startY + 'px'
        speechBubbleStyle.transform = 'translate(-50%, calc(-100% - 1.6rem))'
      } else if (place === 'bottom') {
        speechBubbleStyle.left = midX + 'px'
        speechBubbleStyle.top = endY + 'px'
        speechBubbleStyle.transform = 'translate(-50%, 1.6rem)'
      } else if (place === 'left') {
        speechBubbleStyle.left = startX + 'px'
        speechBubbleStyle.top = midY + 'px'
        speechBubbleStyle.transform = 'translate(calc(-100% - 1.6rem), -50%)'
      } else if (place === 'right') {
        speechBubbleStyle.left = endX + 'px'
        speechBubbleStyle.top = midY + 'px'
        speechBubbleStyle.transform = 'translate(1.6rem, -50%)'
      }
      // 말풍선 삽입
      document.body.append(speechBubble)
      // 삽입 후 위치 조정
      const viewportWidth = window.innerWidth
      const viewportHeight = window.innerHeight
      const speechBubbleRect = speechBubble.getBoundingClientRect()
      if (speechBubbleRect.right > viewportWidth) {
        speechBubbleStyle.left = viewportWidth - speechBubbleRect.width / 2 + 'px'
        speechBubble.classList.add('speech-adjust')
      } else if (speechBubbleRect.left < 0) {
        speechBubbleStyle.left = speechBubbleRect.width / 2 + 'px'
        speechBubble.classList.add('speech-adjust')
      }
      if (speechBubbleRect.bottom > viewportHeight) {
        speechBubbleStyle.top = viewportHeight - speechBubbleRect.height / 2 + 'px'
        speechBubble.classList.add('speech-adjust')
      } else if (speechBubbleRect.top < 0) {
        speechBubbleStyle.top = speechBubbleRect.height / 2 + 'px'
        speechBubble.classList.add('speech-adjust')
      }
      return speechBubble
    }
    const removeSpeechBubble = (speechBubble) => {
      if (speechBubble && speechBubble.parentElement) {
        speechBubble.parentElement.removeChild(speechBubble)
      }
    }
    const mouseoverEventHandler = (event) => {
      const element = event.target
      if (element.closest('.btn-speech')) {
        const speechBubble = createSpeechBubble(element.closest('.btn-speech'))
        currentSpeechBubble = speechBubble
        currentHoverElement = element.closest('.btn-speech')
      }
    }
    const mouseoutEventHandler = () => {
      removeSpeechBubble(currentSpeechBubble)
      currentSpeechBubble = null
      currentHoverElement = null
    }
    const initSpeechBubble = () => {
      const elementsWithSpeechBubble = document.querySelectorAll('.btn-speech')
      elementsWithSpeechBubble.forEach((element) => {
        const btnSpeech = element.closest('.btn-speech')
        btnSpeech.removeEventListener('mouseover', mouseoverEventHandler)
        btnSpeech.removeEventListener('mouseout', mouseoutEventHandler)
        btnSpeech.addEventListener('mouseover', mouseoverEventHandler)
        btnSpeech.addEventListener('mouseout', mouseoutEventHandler)
      })
    }
    const isNodeRemoved = (removedNodes, targetNode) => {
      for (let i = 0; i < removedNodes.length; i++) {
        if (removedNodes[i] === targetNode) {
          return true
        }
        if (removedNodes[i].childNodes && removedNodes[i].childNodes.length) {
          if (isNodeRemoved(removedNodes[i].childNodes, targetNode)) {
            return true
          }
        }
      }
      return false
    }
    const observer = new MutationObserver((mutations) => {
      mutations.forEach((mutation) => {
        if (mutation.type === 'attributes' && mutation.attributeName === 'disabled') {
          if (currentHoverElement === mutation.target && mutation.target.disabled) {
            removeSpeechBubble(currentSpeechBubble)
            currentSpeechBubble = null
            currentHoverElement = null
          }
        }
        if (isNodeRemoved(mutation.removedNodes, currentHoverElement)) {
          removeSpeechBubble(currentSpeechBubble)
          currentSpeechBubble = null
          currentHoverElement = null
        }
      })
      initSpeechBubble()
    })
    observer.observe(document.body, { childList: true, subtree: true, attributeFilter: ['disabled'] })
  })

  // ----------
  // Event Open Modal
  inject('eventOpenModal', (target) => {
    window.requestAnimationFrame(() => app.$eventShowModal(target))
  })
  // Event Show Modal
  inject('eventShowModal', (target) => {
    const targetElement = document.getElementById(target)
    const modal = bootstrap.Modal.getOrCreateInstance(targetElement)
    modal.show()
  })
  // Event Hide Modal
  inject('eventHideModal', (target) => {
    const targetElement = document.getElementById(target)
    targetElement.querySelector('.btn.close').click()
  })

  // ----------
  // Event Show Offcanvas
  inject('eventShowOffcanvas', (target) => {
    const targetElement = document.getElementById(target)
    const offcanvas = bootstrap.Offcanvas.getOrCreateInstance(targetElement)
    offcanvas.show()
  })
  // Event Hide Offcanvas
  inject('eventHideOffcanvas', (target) => {
    const targetElement = document.getElementById(target)
    const offcanvas = bootstrap.Offcanvas.getOrCreateInstance(targetElement)
    offcanvas.hide()
  })
  // Event Hide All Offcanvas
  inject('eventHideAllOffcanvas', () => {
    document.querySelectorAll('.th-offcanvas').forEach((element) => {
      element.querySelectorAll('.btn.close, .btn.prev').forEach((subElement) => subElement.click())
      app.$eventHideSidebarMenu(element)
    })
  })
  // Event Hide Other Offcanvas
  inject('eventHdieOtherOffcanvas', (target) => {
    document.querySelectorAll('.th-offcanvas').forEach((element) => {
      if (!element.id.includes(target)) {
        element.querySelectorAll('.btn.close, .btn.prev').forEach((subElement) => subElement.click())
        app.$eventHideSidebarMenu(element)
      }
    })
  })
  // Event Prev Offcanvas
  inject('eventPrevOffcanvas', (target) => {
    document.getElementById(target).querySelector('.btn.prev').click()
  })

  // ----------
  // Event Toggle Popmenu
  inject('eventTogglePopmenu', (event) => {
    event.stopPropagation()
    const clickEventHandler = () => {
      document.querySelectorAll('.btn-popmenu').forEach((element) => element.classList.remove('active'))
      document.querySelectorAll('.popmenu').forEach((element) => element.classList.remove('active'))
    }
    document.removeEventListener('click', clickEventHandler)
    document.addEventListener('click', clickEventHandler)
    const btnPopmenu = event.target.closest('.btn-popmenu')
    const popmenu = btnPopmenu.nextElementSibling
    const modalMain = btnPopmenu.closest('.modal-main')
    btnPopmenu.classList.toggle('active')
    popmenu.classList.toggle('active')
    if (modalMain) {
      if (popmenu.getBoundingClientRect().right > modalMain.getBoundingClientRect().right) {
        popmenu.classList.remove('popmenu-left')
        popmenu.classList.remove('popmenu-right')
        popmenu.classList.add('popmenu-left')
      }
    }
  })
  // Event Hide Popmenu
  inject('eventHidePopmenu', (event) => {
    const parent = event.target
    parent.querySelector('.btn-popmenu').classList.remove('active')
    parent.querySelector('.popmenu').classList.remove('active')
  })

  // ----------
  // Event Hide Sidebar Menu
  inject('eventHideSidebarMenu', (element) => {
    const targetOffcanvas = element.dataset.offcanvas
    const sidebarMenuAsset = document.querySelector('.th-sidebar-item.menu-asset')
    const sidebarMenuBlock = document.querySelector('.th-sidebar-item.menu-block')
    const sidebarMenuPage = document.querySelector('.th-sidebar-item.menu-page')
    const sidebarMenuResource = document.querySelector('.th-sidebar-item.menu-resource')
    const sidebarMenuProject = document.querySelector('.th-sidebar-item.menu-project')
    if (targetOffcanvas === 'asset') {
      sidebarMenuAsset.classList.remove('on')
    } else if (targetOffcanvas === 'block') {
      sidebarMenuBlock.classList.remove('on')
    } else if (targetOffcanvas === 'page') {
      sidebarMenuPage.classList.remove('on')
    } else if (targetOffcanvas === 'resource') {
      sidebarMenuResource.classList.remove('on')
    } else if (targetOffcanvas === 'project') {
      sidebarMenuProject.classList.remove('on')
    }
  })
  // Event Selectmenu
  inject('eventSelectmenu', (event) => {
    event.stopPropagation()
    const clickEventHandler = () => document.querySelectorAll('.selectmenu-wrap').forEach((element) => element.classList.remove('active'))
    document.removeEventListener('click', clickEventHandler)
    document.addEventListener('click', clickEventHandler)
    const btnSelectmenu = event.target
    const selectmenu = btnSelectmenu.nextElementSibling
    selectmenu.classList.toggle('active')
  })
  // Event Selectbox
  inject('eventSelectbox', (event) => {
    event.stopPropagation()
    const clickEventHandler = () => document.querySelectorAll('.selectbox-wrap').forEach((element) => element.classList.remove('active'))
    document.removeEventListener('click', clickEventHandler)
    document.addEventListener('click', clickEventHandler)
    const btnSelectbox = event.target.closest('.selectbox-button')
    const selectbox = btnSelectbox.nextElementSibling
    selectbox.classList.toggle('active')
  })
  // Event Searchbox
  inject('eventSearchbox', (event) => {
    event.stopPropagation()
    const inputEventHandler = () => document.querySelectorAll('.searchbox').forEach((element) => element.classList.remove('active'))
    document.removeEventListener('input', inputEventHandler)
    document.addEventListener('input', inputEventHandler)
    document.removeEventListener('click', inputEventHandler)
    document.addEventListener('click', inputEventHandler)
    const inputbox = event.target
    const searchbox = inputbox.parentElement.nextElementSibling
    if (inputbox.value) {
      searchbox.classList.add('active')
    } else {
      searchbox.classList.remove('active')
    }
  })
  // Event PlayVideo
  inject('eventPlayVideo', (videoId) => {
    const thVideo = document.querySelector('.th-player')
    const thVideoYoutube = document.querySelector('.th-player-youtube')
    thVideoYoutube.src = `//www.youtube.com/embed/${videoId}?modestbranding=1`
    thVideo.classList.add('active')
  })
  // Event Sync Color
  inject('eventSyncColor', () => {
    const formColor = document.querySelector('.form-control-color')
    const inputColor = document.querySelector('.input-color')
    if (formColor) {
      const changeEventHandler = (event) => (inputColor.value = event.target.value)
      formColor.removeEventListener('change', changeEventHandler)
      formColor.addEventListener('change', changeEventHandler)
    }
  })
  // Event Show Ctrler
  inject('eventShowCtrler', () => {
    const button = document.getElementById('thCtrler')
    button.classList.add('on')
    document.querySelector('.th-test').classList.add('ctrler-active')
    document.querySelector('.th-ctrler').classList.add('ctrler-active')
  })
  // Event Hide Ctrler
  inject('eventHideCtrler', () => {
    const button = document.getElementById('thCtrler')
    button.classList.remove('on')
    document.querySelector('.th-test').classList.remove('ctrler-active')
    document.querySelector('.th-ctrler').classList.remove('ctrler-active')
  })
  // Event Select Ctrler
  inject('eventSelectCtrler', (type) => {
    document.querySelectorAll('.th-ctrler-content').forEach((item) => item.classList.remove('active'))
    if (type === 'block') {
      document.getElementById('tabContentBlock').classList.add('active')
    }
    if (type === 'asset') {
      document.getElementById('tabContentAsset').classList.add('active')
    }
  })
  // Event Accordset
  inject('eventAccordset', () => {
    const accordset = document.querySelectorAll('.accordset-group')
    accordset.forEach((item) => {
      const clickEventHandler = () => {
        const parentClasses = item.classList
        if (parentClasses.contains('active')) {
          parentClasses.remove('active')
        } else {
          parentClasses.add('active')
        }
      }
      const accordlistHead = item.querySelector('.accordset-head')
      accordlistHead.removeEventListener('click', clickEventHandler)
      accordlistHead.addEventListener('click', clickEventHandler)
    })
  })
  // Event Before Unload
  inject('eventBeforeUnload', (projectId) => {
    window.addEventListener('beforeunload', () => app.$thLeaveProject(projectId))
  })
  // Event Help Placeholder
  inject('eventHelpPlaceholder', (value, target) => {
    if (value === '04') {
      target.placeholder =
        '· 테스트'
    } else if (value === '05') {
      target.placeholder = '· 테스트'
    } else {
      target.placeholder = '내용을 입력하세요.'
    }
  })
  // Event Popup Error
  inject('eventPopupError', (message, confirm) => {
    document.getElementById('popupErrorMessage').innerHTML = message
    app.$eventShowModal('modalPopupError')
    if (confirm) {
      return new Promise((resolve) => {
        const errorDone = document.getElementById('popupErrorDone')
        const doneEventListener = () => resolve(true)
        errorDone.removeEventListener('click', doneEventListener)
        errorDone.addEventListener('click', doneEventListener)
      })
    }
  })
  // Event Popup Alert
  inject('eventPopupAlert', (message) => {
    document.getElementById('popupAlertMessage').innerHTML = message
    app.$eventShowModal('modalPopupAlert')
  })
  // Event Popup Finish
  inject('eventPopupFinish', (title, message, link) => {
    document.getElementById('popupFinishTitle').innerHTML = title
    document.getElementById('popupFinishMessage').innerHTML = message
    if (link) {
      const popupFinishLink = document.getElementById('popupFinishLink')
      const clickEventHandler = () => app.router.push(link)
      popupFinishLink.removeEventListener('click', clickEventHandler)
      popupFinishLink.addEventListener('click', clickEventHandler)
    }
    app.$eventShowModal('modalPopupFinish')
  })
  // Event Popup Confirm
  inject('eventPopupConfirm', (message) => {
    document.getElementById('popupConfirmMessage').innerHTML = message
    app.$eventShowModal('modalPopupConfirm')
    return new Promise((resolve) => {
      const confirmCancel = document.getElementById('popupConfirmCancel')
      const confirmDone = document.getElementById('popupConfirmDone')
      const cancelEventListener = () => resolve(false)
      const doneEventListener = () => resolve(true)
      confirmCancel.removeEventListener('click', cancelEventListener)
      confirmCancel.addEventListener('click', cancelEventListener)
      confirmDone.removeEventListener('click', doneEventListener)
      confirmDone.addEventListener('click', doneEventListener)
    })
  })
  // Event Ani Gradient Top
  inject('eventAnimationGradientTop', (parentClass, canvasId, speed, color1, colorStop1, color2, colorStop2, color3, colorStop3) => {
    const P5 = process.client ? require('p5') : null
    const sketch = (p) => {
      let canvas = ''
      let ctx = ''
      let centerX = ''
      let centerY = ''
      let time = ''
      const drawGradient = () => {
        ctx.save()
        ctx.scale(2, 1)
        const gradient = ctx.createRadialGradient(centerX / 2, centerY, 0, centerX / 2, centerY, Math.min(canvas.width, canvas.height))
        gradient.addColorStop(colorStop1, color1)
        gradient.addColorStop(colorStop2, color2)
        gradient.addColorStop(colorStop3, color3)
        ctx.fillStyle = gradient
        ctx.fillRect(0, 0, canvas.width / 2, canvas.height)
        ctx.restore()
      }
      const updateCenterPosition = () => {
        const scaleFactor = 2
        const noiseScaleX = canvas.width * scaleFactor
        const noiseScaleY = canvas.height * scaleFactor
        centerX = (p.noise(time) - 0.5) * noiseScaleX + canvas.width / 2
        centerY = (p.noise(time + 5) - 0.5) * noiseScaleY + canvas.height / 2
        time += speed
      }
      p.setup = () => {
        const visual = document.querySelector(`.${parentClass}`)
        canvas = document.getElementById(canvasId)
        canvas.width = visual.offsetWidth
        canvas.height = visual.offsetHeight
        ctx = canvas.getContext('2d')
        centerX = canvas.width / 2
        centerY = canvas.height / 2
        time = 0
      }
      p.draw = () => {
        updateCenterPosition()
        drawGradient()
      }
    }
    /* eslint-disable-next-line no-new */
    new P5(sketch)
  })
  // Event Ani Gradient Template
  inject('eventAnimationGradientTemplate', (parentClass, canvasId, speed, color1, colorStop1, color2, colorStop2) => {
    const P5 = process.client ? require('p5') : null
    const sketch = (p) => {
      let canvas = ''
      let ctx = ''
      let centerX = ''
      let centerY = ''
      let time = ''
      const drawGradient = () => {
        const gradient = ctx.createRadialGradient(centerX, centerY, 0, centerX, centerY, Math.min(canvas.width, canvas.height) / 2)
        gradient.addColorStop(colorStop1, color1)
        gradient.addColorStop(colorStop2, color2)
        ctx.fillStyle = gradient
        ctx.fillRect(0, 0, canvas.width, canvas.height)
      }
      const updateCenterPosition = () => {
        const scaleFactor = 2
        const noiseScaleX = canvas.width * scaleFactor
        const noiseScaleY = canvas.height * scaleFactor
        centerX = (p.noise(time) - 0.5) * noiseScaleX + canvas.width / 2
        centerY = (p.noise(time + 5) - 0.5) * noiseScaleY + canvas.height / 2
        time += speed
      }
      p.setup = () => {
        const visual = document.querySelector(`.${parentClass}`)
        canvas = document.getElementById(canvasId)
        canvas.width = visual.offsetWidth
        canvas.height = visual.offsetHeight
        ctx = canvas.getContext('2d')
        centerX = canvas.width / 2
        centerY = canvas.height / 2
        time = 0
      }
      p.draw = () => {
        updateCenterPosition()
        drawGradient()
      }
    }
    /* eslint-disable-next-line no-new */
    new P5(sketch)
  })
}
