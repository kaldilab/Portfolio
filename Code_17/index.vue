<template>
  <div v-frag>
    <!-- wrap -->
    <div class="wrap th-temha">
      <!-- header -->
      <EditorThHeader @emitOpenViewResult="handleOpenViewResult" @emitPageList="showPageList" @emitPageSetting="showPageSetting" />
      <!-- //header -->
      <!-- sidebar -->
      <EditorThSidebar
        @emitAssetList="showAssetList"
        @emitBlockList="showBlockList"
        @emitPageList="showPageList"
        @emitProjectList="showProjectList"
        @emitResourceList="showResourceList"
        @emitOpenOnboard="handleOpenOnboard"
      />
      <!-- //sidebar -->
      <!-- main -->
      <main class="th-main" :class="$thCoworkViewer() ? 'main-viewer' : ''">
        <!-- panel -->
        <div v-show="!comPageLoading" :class="`th-panel ${comPageMode === 'mo' ? 'panel-mobile' : ''}`">
          <iframe v-show="!comProjectLoading" class="th-panel-iframe" src="./_views/page" @load="$thLoadPage($event, comProjectId)"></iframe>
          <div v-show="comProjectLoading" class="th-panel-loading"><LoadingThType1 /></div>
        </div>
        <div v-show="comPageLoading" class="th-panel-loading"><LoadingThType1 /></div>
        <!-- //panel -->
      </main>
      <!-- //main -->
      <!-- footer -->
      <EditorThFooter />
      <!-- //footer -->
      <!-- editor -->
      <EditorThEditor v-if="!$thCoworkViewer()" @emitCodeBlock="updateBlockEdit" @emitSaveEditor="handleEditBlock" />
      <!-- //editor -->
    </div>
    <!-- //wrap -->
    <!-- offcanvas -->
    <EditorOffcanvasPageList @emitSelectPageInProject="handleSelectPageInProject" @emitPageSetting="showPageSetting" />
    <EditorOffcanvasProjectList @emitProjectSetting="showProjectSetting" />
    <div v-if="!$thCoworkViewer()" v-frag>
      <EditorOffcanvasAssetList @emitEditPersonalAssetGroup="handleEditPersonalAssetGroup" />
      <EditorOffcanvasBlockList @emitEditPersonalBlockGroup="handleEditPersonalBlockGroup" />
      <EditorOffcanvasPageSetting v-model="currentPageSetting" @emitSetting="dataPageSetting" @emitSettingPage="handleSettingPage" />
      <EditorOffcanvasProjectSetting v-model="currentProjectSetting" @emitSetting="dataProjectSetting" @emitSettingProject="handleSettingProject" />
      <EditorOffcanvasResourceList />
    </div>
    <!-- //offcanvas -->
    <!-- modal -->
    <EditorModalViewResult v-if="openViewResult" @emitCloseViewResult="handleCloseViewResult" />
    <div v-if="!$thCoworkViewer()" v-frag>
      <EditorModalSelectTheme />
      <EditorModalSelectImage />
      <EditorModalSelectVideo />
      <EditorModalPersonalBlock :current-block="currentBlock" @emitAddPersonalBlock="handleAddPersonalBlock" />
      <EditorModalPersonalBlockSetting :current-block="currentBlock" />
      <EditorModalPersonalAsset :current-asset="currentAsset" @emitAddPersonalAsset="handleAddPersonalAsset" />
      <EditorModalPersonalAssetSetting :current-asset="currentAsset" />
      <EditorModalCommonBlock :current-block="currentBlock" @emitAddCommonBlock="handleAddCommonBlock" />
      <EditorModalDownloadProduct />
      <EditorModalViewShortcut />
    </div>
    <!-- //modal -->
    <!-- control -->
    <EditorThPlayer />
    <EditorThChatter />
    <div v-if="!$thCoworkViewer()" v-frag>
      <EditorThCtrler @emitEditBlock="updateBlockEdit" @emitOptionBlock="handleEditBlock" @emitOption="dataBlockOption" />
      <EditorThOnboarder :open-onboard="openOnboard" @emitCloseOnboard="handleCloseOnboard" />
    </div>
    <!-- //control -->
    <!-- cowork -->
    <CoworkThProject :project-id="comProjectId" :project-title="comProject.title" :project-type="projectType" />
    <CoworkThInvite :project-id="comProjectId" />
    <!-- //cowork -->
    <!-- popup -->
    <PopupThError />
    <PopupThAlert />
    <PopupThFinish />
    <PopupThConfirm />
    <!-- //popup -->
  </div>
</template>

<script>
const bootstrap = process.client ? require('bootstrap') : null

export default {
  name: 'EditorPage',
  data() {
    return {
      currentSection: '',
      currentBlock: {
        option: {},
      },
      currentAsset: {},
      currentPageSetting: {},
      currentProjectSetting: {
        thumb: {},
        meta: {},
      },
      currentProjectThumb: '',
      selectPageId: '',
      selectProjectId: '',
      openViewResult: false,
      openOnboard: false,
      projectType: 'own',
    }
  },
  head() {
    return {
      title: '에디터',
    }
  },
  computed: {
    comPage() {
      return this.$store.state.page
    },
    comPageView() {
      return this.comPage.view
    },
    comPageBlock() {
      return this.comPage.block
    },
    comPageHistory() {
      return this.comPage.history
    },
    comPageLoading() {
      return this.comPage.loading
    },
    comPageId() {
      return this.comPageView.id
    },
    comPageMode() {
      return this.comPageView.mode
    },
    comProjectId() {
      return this.comPageView.projectId
    },
    comProjectList() {
      return this.$store.state.project.list
    },
    comProjectSync() {
      return this.$store.state.project.sync
    },
    comProjectLoading() {
      return this.$store.state.project.loading
    },
    comProject() {
      const project = this.comProjectList.find((item) => item.id === this.comProjectId)
      return project || ''
    },
    comProjectIndex() {
      const index = this.comProjectList.findIndex((item) => item.id === this.comProjectId)
      return index || 0
    },
    comProjectTemplate() {
      return this.comProject.template
    },
    comCommon() {
      return this.$store.state.common
    },
    comCommonUpload() {
      return this.comCommon.upload
    },
    comCowork() {
      return this.$store.state.cowork
    },
    comCoworkList() {
      return this.comCowork.list
    },
    comCoworkLive() {
      return this.comCowork.live
    },
    comCoworkAuth() {
      return this.comCowork.auth
    },
    comMemberProfile() {
      return this.$store.state.member.profile
    },
  },
  watch: {
    comPageView: {
      handler(value) {
        const pageId = value.id
        const projectId = value.projectId
        const newPage = value
        const oldPage = this.comPageHistory && this.comPageHistory[0]
        this.selectPageId = pageId
        this.selectProjectId = projectId
        this.$thUpdatePage(projectId, pageId, newPage, oldPage)
      },
      deep: true,
    },
    comPageBlock(value) {
      if (value) {
        this.updateBlockEdit(value.index, value.core, value.section)
      }
    },
    comProjectId(value) {
      if (value) {
        this.$thGetCowork(value, true)
      }
    },
    comProjectTemplate(value) {
      if (value) {
        this.$thSetTemplateSource(value.id, value.name)
      }
    },
    comCoworkList(value) {
      if (value.length) {
        this.$thConnectWebsock(this.comProjectId, this.comPageId)
      }
    },
    comCoworkAuth(value) {
      this.projectType = value === 'OWNER' ? 'own' : 'cowork'
    },
  },
  created() {
    this.$thGetMember()
  },
  beforeMount() {
    const projectId = this.$route.query.project
    const pageId = this.$route.query.page
    this.$thSetProject(projectId, pageId)
  },
  mounted() {
    if (this.$utilIsMobile()) {
      this.$router.push('/editor/mobile')
    }
    this.$eventInitOffcanvas()
    this.$eventInitSpeechBubble()
  },
  beforeDestroy() {
    this.$thLeaveProject(this.comProjectId)
  },
  methods: {
    // Data
    dataBlockOption(event, name) {
      if (event === 'classtitle') {
        this.currentBlock.classtitle = name
      } else if (event === 'tagtitle') {
        this.currentBlock.tagtitle = name
      } else if (event === 'idtitle') {
        this.currentBlock.idtitle = name
      } else {
        const target = event.target
        const type = target.type
        const value = target.value
        const checked = target.checked
        if (type === 'checkbox') {
          this.currentBlock.option[name] = checked
        } else {
          this.currentBlock.option[name] = value
        }
      }
    },
    dataPageSetting(name, value) {
      this.currentPageSetting[name] = value
    },
    dataProjectSetting(name, value, depth) {
      if (depth === 'thumb') {
        this.currentProjectThumb = value
      } else if (depth === 'meta') {
        this.currentProjectSetting[depth][name] = value
      } else {
        this.currentProjectSetting[name] = value
      }
    },
    // Update
    updateBlockEdit(index, block, section) {
      const name = block.name
      const id = block.id
      this.currentSection = section
      this.currentBlock = {
        index,
        name,
        classtitle: block.classtitle,
        oldClasstitle: block.classtitle,
        tagtitle: block.tagtitle,
        oldTagtitle: block.tagtitle,
        idtitle: block.idtitle,
        oldIdtitle: block.idtitle,
        id,
        bid: block.bid,
        html: block.html,
        css: block.css,
        js: block.js,
        thpart: block.thpart,
        thwhole: block.thwhole,
        option: {
          fixed: block.option.fixed,
          bgcolor: block.option.bgcolor,
          bgcolorCheck: block.option.bgcolorCheck,
          top: block.option.top,
          bottom: block.option.bottom,
          left: block.option.left,
          right: block.option.right,
        },
      }
    },
    // Onboard
    handleOpenOnboard() {
      this.openOnboard = true
    },
    handleCloseOnboard() {
      this.openOnboard = false
    },
    // Result
    handleOpenViewResult() {
      this.openViewResult = true
      this.$eventOpenModal('modalViewResult')
    },
    handleCloseViewResult() {
      this.openViewResult = false
    },
    // Block
    handleEditBlock(section) {
      this.currentSection = section
      if (this.currentBlock.thpart) {
        this.$thEditBlock(section, this.currentBlock, 'thpart')
      } else if (this.currentBlock.thwhole) {
        this.$thEditBlock(section, this.currentBlock, 'thwhole')
      } else {
        this.$thEditBlock(section, this.currentBlock)
      }
    },
    // Personal Block
    handleAddPersonalBlock(groupId, groupName, blockTitle) {
      this.$eventPopupConfirm(`'${groupName}' 그룹에 '${blockTitle}' 블록을 저장할까요?`).then((confirm) => {
        if (confirm) {
          const coverImage = this.$store.state.page.cover
          const promise = this.$thUploadFileCover('personalBlockCover', coverImage)
          Promise.all([promise]).then(() => {
            const cover = {
              url: this.comCommonUpload.url,
              key: this.comCommonUpload.key,
            }
            this.currentBlock.groupId = groupId
            this.currentBlock.title = blockTitle
            this.$thAddPersonalBlock(this.currentBlock, cover)
          })
        }
      })
    },
    handleEditPersonalBlockGroup(block) {
      this.currentBlock = block
    },
    // Common Block
    handleAddCommonBlock(commonType, blockTitle) {
      const coverImage = this.$store.state.page.cover
      this.currentBlock.title = blockTitle
      if (commonType === 'thpart') {
        this.$eventPopupConfirm('부분 공통 블록으로 저장할까요?').then((confirm) => {
          if (confirm) {
            const promise = this.$thUploadFileCover('commonBlockCover', coverImage)
            Promise.all([promise]).then(() => {
              const cover = {
                url: this.comCommonUpload.url,
                key: this.comCommonUpload.key,
              }
              this.$thAddThpartBlock(this.comProjectIndex, this.currentBlock, cover)
              this.currentBlock.thpart = true
              this.currentBlock.classtitle = 'thpart-' + this.currentBlock.bid
              this.$thEditBlock(this.currentSection, this.currentBlock)
            })
          }
        })
      } else if (commonType === 'thwhole') {
        this.$eventPopupConfirm('전체 공통 블록으로 저장할까요?').then((confirm) => {
          if (confirm) {
            const promise = this.$thUploadFileCover('commonBlockCover', coverImage)
            Promise.all([promise]).then(() => {
              const cover = {
                url: this.comCommonUpload.url,
                key: this.comCommonUpload.key,
              }
              this.$thAddThwholeBlock(this.comProjectIndex, this.currentBlock, cover)
              this.currentBlock.thwhole = true
              this.currentBlock.classtitle = 'thwhole-' + this.currentBlock.bid
              this.$thEditBlock(this.currentSection, this.currentBlock)
            })
          }
        })
      }
    },
    // Personal Asset
    handleAddPersonalAsset(groupId, groupName, assetTitle) {
      this.$eventPopupConfirm(`'${groupName}' 그룹에 '${assetTitle}' 요소를 저장할까요?`).then((confirm) => {
        if (confirm) {
          const coverImage = this.$store.state.page.cover
          const promise = this.$thUploadFileCover('personalAssetCover', coverImage)
          Promise.all([promise]).then(() => {
            const cover = {
              url: this.comCommonUpload.url,
              key: this.comCommonUpload.key,
            }
            this.currentAsset.groupId = groupId
            this.currentAsset.title = assetTitle
            this.$thAddPersonalAsset(this.currentAsset, cover)
          })
        }
      })
    },
    handleEditPersonalAssetGroup(asset) {
      this.currentAsset = asset
    },
    // Setting
    handleSettingPage() {
      this.$thSettingPage(this.selectPageId, this.selectProjectId, this.currentPageSetting)
    },
    handleSettingProject() {
      const file = this.currentProjectThumb
      const project = this.comProjectList.find((item) => item.id === this.selectProjectId)
      const projectThumb = project.thumb
      if (file) {
        const promise = projectThumb.key
          ? this.$thUploadFileProjectMedia(file, projectThumb.key, this.comProjectId)
          : this.$thUploadFileProjectMedia(file, null, this.comProjectId)
        Promise.all([promise]).then(() => {
          this.currentProjectSetting.thumb.url = this.comCommonUpload.url
          this.currentProjectSetting.thumb.key = this.comCommonUpload.key
          this.$thSettingProject(this.selectProjectId, this.currentProjectSetting)
        })
      } else {
        this.currentProjectSetting.thumb = projectThumb
        this.$thSettingProject(this.selectProjectId, this.currentProjectSetting)
      }
    },
    // Page
    handleSelectPageInProject(pageId) {
      this.selectPageId = pageId
      this.$thSelectPageInProject(pageId, this.selectProjectId)
    },
    // Offcanvas
    showAssetList(event) {
      event.stopPropagation()
      this.$eventHdieOtherOffcanvas('offcanvasAsset')
      this.toggleOffcanvasSingle('offcanvasAssetList')
    },
    showBlockList(event) {
      event.stopPropagation()
      this.$eventHdieOtherOffcanvas('offcanvasBlock')
      this.toggleOffcanvasSingle('offcanvasBlockList')
    },
    showPageList(event) {
      event.stopPropagation()
      this.$eventHdieOtherOffcanvas('offcanvasPage')
      this.toggleOffcanvasMulti('offcanvasPageList')
    },
    showPageSetting(id) {
      this.selectPageId = id
      this.$thSelectPageInProject(id, this.selectProjectId)
      this.currentPageSetting = {
        title: this.comPageView.title,
        name: this.comPageView.name,
        memo: this.comPageView.memo,
        status: this.comPageView.status,
        layout: this.comPageView.layout,
        bodyStart: this.comPageView.bodyStart,
        bodyEnd: this.comPageView.bodyEnd,
      }
      this.toggleOffcanvasMulti('offcanvasPageSetting')
    },
    showProjectList(event) {
      event.stopPropagation()
      this.$eventHdieOtherOffcanvas('offcanvasProject')
      this.$thSelectProject(this.selectProjectId)
      this.toggleOffcanvasMulti('offcanvasProjectList')
    },
    showProjectSetting(id) {
      this.selectProjectId = id
      this.$thSelectProject(id)
      this.$thSelectFirstPageInProject(id)
      const settingThumb = this.comProject.thumb
      const settingMeta = this.comProject.meta
      const settingSyncTitle = settingMeta.syncTitle
      const settingSyncDesc = settingMeta.syncDesc
      this.currentProjectSetting = {
        title: this.comProject.title,
        name: this.comProject.name,
        thumb: {
          url: settingThumb.url,
          key: settingThumb.key,
        },
        meta: {
          metaTitle: settingMeta.metaTitle,
          metaDesc: settingMeta.metaDesc,
          metaKeywords: settingMeta.metaKeywords,
          ogTitle: settingSyncTitle ? settingMeta.metaTitle : settingMeta.ogTitle,
          ogDesc: settingSyncDesc ? settingMeta.metaDesc : settingMeta.ogDesc,
          ogImage: settingMeta.ogImage,
          ogUrl: settingMeta.ogUrl,
          syncTitle: settingSyncTitle,
          syncDesc: settingSyncDesc,
        },
      }
      this.toggleOffcanvasMulti('offcanvasProjectSetting')
    },
    showResourceList(event) {
      event.stopPropagation()
      this.$eventHdieOtherOffcanvas('offcanvasResource')
      this.toggleOffcanvasSingle('offcanvasResourceList')
    },
    toggleOffcanvasSingle(target) {
      const targetElement = document.getElementById(target)
      const offcanvas = bootstrap.Offcanvas.getOrCreateInstance(targetElement)
      offcanvas.toggle()
      // Sidebar Menu
      const targetOffcanvas = targetElement.dataset.offcanvas
      const checkOffcanvas = offcanvas._isShown
      const sidebarMenuAsset = document.querySelector('.th-sidebar-item.menu-asset')
      const sidebarMenuBlock = document.querySelector('.th-sidebar-item.menu-block')
      const sidebarMenuResource = document.querySelector('.th-sidebar-item.menu-resource')
      if (targetOffcanvas === 'asset') {
        if (checkOffcanvas) {
          sidebarMenuAsset.classList.add('on')
        } else {
          sidebarMenuAsset.classList.remove('on')
        }
      }
      if (targetOffcanvas === 'block') {
        if (checkOffcanvas) {
          sidebarMenuBlock.classList.add('on')
        } else {
          sidebarMenuBlock.classList.remove('on')
        }
      }
      if (targetOffcanvas === 'resource') {
        if (checkOffcanvas) {
          sidebarMenuResource.classList.add('on')
        } else {
          sidebarMenuResource.classList.remove('on')
        }
      }
    },
    toggleOffcanvasMulti(target) {
      const targetElement = document.getElementById(target)
      const offcanvas = bootstrap.Offcanvas.getOrCreateInstance(targetElement)
      const targetId = offcanvas._element.id
      const childId = targetId.replace('List', 'Setting')
      const child = document.getElementById(childId)
      child && child.querySelector('.btn.prev').click()
      offcanvas.toggle()
      // Sidebar Menu
      const targetOffcanvas = targetElement.dataset.offcanvas
      const checkOffcanvas = offcanvas._isShown
      const sidebarMenuPage = document.querySelector('.th-sidebar-item.menu-page')
      const sidebarMenuProject = document.querySelector('.th-sidebar-item.menu-project')
      if (targetOffcanvas === 'page') {
        if (checkOffcanvas) {
          sidebarMenuPage.classList.add('on')
        } else {
          sidebarMenuPage.classList.remove('on')
        }
      }
      if (targetOffcanvas === 'project') {
        if (checkOffcanvas) {
          sidebarMenuProject.classList.add('on')
        } else {
          sidebarMenuProject.classList.remove('on')
        }
      }
    },
  },
}
</script>
