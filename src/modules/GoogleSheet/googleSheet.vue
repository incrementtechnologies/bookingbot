<template>
  <div class="container-fluid google_sheet_holder d-flex align-items-center justify-content-center">
    <div class="card mb-5 google_sheet_card">
      <div class="card-body">
        <!-- <div class="row">
          <div class="col-sm-8 p-2">
            <div class="card json_card">
              <div class="card-body p-0">
                <div class="file-selector">
                  <figure>
                    <UploadIcon/>
                  </figure>Select Files from Google Drive
                  <p>
                    <span class="span">Authenticate with Google Drive</span>
                  </p>
                  <button class="google_connect" type="button" @click="driveIconClicked();">Connect to Google Drive</button>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-4 p-2 d-flex align-items-center">
            <div class="col-sm-12 p-0">
              <div class="card">
                <div class="card-body">
                  <AttachmentList :tempAttachments="getTempAttachments"/>
                  <p class="p-0 m-0">Google Sheet Page</p>
                  <input class="form-control mb-2">
                  <p class="p-0 m-0">Range</p>
                  <input class="form-control mb-2">
                  <div class="d-flex justify-content-center">
                    <button type="button" class="btn btn-outline-info mt-3"> Submit </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div> -->
        <center>
          <div class="google_sheet_form">
            <div class="text-center">
              <figure>
                <UploadIcon/>
              </figure>
              <button type="button" class="btn btn-outline-info mt-2 google_connect"  @click="driveIconClicked()"> Google Connect </button>
              <div class="card text-left mt-3 google_sheet_tips">
                <div class="card-body pt-2 pb-2 pl-1 pr-1">
                  <p class="m-0"><b> Tips: </b> Connect with google drive to auto fill some details. </p>
                </div>
              </div>
            </div>
            <div class="mt-3">
              <b class="font-weight-normal google_sheet_label">File Name: </b>
              <input class="form-control" v-model="attachments[0].title">
            </div>
            <div class="mt-3">
              <b class="font-weight-normal google_sheet_label">File ID: </b>
              <input class="form-control" v-model="attachments[0]._id">
            </div>
            <div class="mt-3">
              <b class="font-weight-normal google_sheet_label">Google Sheet Page:</b>
              <input class="form-control">
            </div>
            <div class="mt-5 text-center mb-2">
              <button type="button" class="btn btn-info sheet_submit_button">
                Submit
              </button>
            </div>
          </div>
        </center>
      </div>
    </div>
  </div>
</template>
<script>
import AttachmentList from './AttachmentList'
import UploadIcon from './UploadIcon'
export default {
  name: 'Attachment',
  data() {
    return {
      tempAttachments: [],
      attachments: [{}],
      pickerApiLoaded: false,
      developerKey: 'AIzaSyCfIlbignMnRJUkyEa0Q8klw2_el_Mohyo',
      clientId: '160116820228-sfnqnvn5d1e6let49onfn396veagua30.apps.googleusercontent.com',
      scope: 'https://www.googleapis.com/auth/drive.file',
      oauthToken: null
    }
  },
  components: {
    AttachmentList: AttachmentList,
    UploadIcon
  },
  mounted() {
    let gDrive = document.createElement('script')
    gDrive.setAttribute('type', 'text/javascript')
    gDrive.setAttribute('src', 'https://apis.google.com/js/api.js')
    document.head.appendChild(gDrive)

    this.APIRequest('google_sheet/googleTest', {}).then(response => {
      console.log(JSON.stringify(response))
    })
  },
  methods: {
    // function called on click of drive icon
    async driveIconClicked() {
      console.log('Clicked')
      await gapi.load('auth2', () => {
        console.log('Auth2 Loaded')
        gapi.auth2.authorize(
          {
            client_id: this.clientId,
            scope: this.scope,
            immediate: false
          },
          this.handleAuthResult
        )
      })
      gapi.load('picker', () => {
        console.log('Picker Loaded')
        this.pickerApiLoaded = true
        this.createPicker()
      })
    },
    handleAuthResult(authResult) {
      console.log('Handle Auth result', authResult)
      if (authResult && !authResult.error) {
        this.oauthToken = authResult.access_token
        this.createPicker()
      }
    },
    // Create and render a Picker object for picking user Photos.
    createPicker() {
      console.log('Create Picker')
      if (this.pickerApiLoaded && this.oauthToken) {
        const googleViewId = google.picker.ViewId.FOLDERS
        const shared = new google.picker.DocsView(googleViewId)
          .setIncludeFolders(true)
          .setMimeTypes('application/vnd.google-apps.folder')
          .setSelectFolderEnabled(true)
          .setEnableDrives(true)
        var picker = new google.picker.PickerBuilder()
          .enableFeature(google.picker.Feature.MULTISELECT_ENABLED)
          .addView(google.picker.ViewId.SPREADSHEETS)
          .addView(shared)
          .setOAuthToken(this.oauthToken)
          .setDeveloperKey('AIzaSyCfIlbignMnRJUkyEa0Q8klw2_el_Mohyo')
          .setCallback(this.pickerCallback)
          .build()
        picker.setVisible(true)
      }
    },
    async pickerCallback(data) {
      var url = 'nothing'
      var name = 'nothing'
      if (data[google.picker.Response.ACTION] === google.picker.Action.PICKED) {
        var doc = data[google.picker.Response.DOCUMENTS][0]
        url = doc[google.picker.Document.URL]
        name = doc.name
        let docs = data.docs
        var param = { fileId: doc.id, oAuthToken: this.oauthToken, name: name }
        let attachments = []
        for (let i = 0; i < docs.length; i++) {
          let attachment = {}
          attachment._id = docs[i].id
          attachment.title = docs[i].name
          attachment.name = docs[i].name + '.' + docs[i].mimeType.split('/')[1]
          attachment.type = 'gDrive'
          attachment.description = 'Shared with GDrive'
          attachment.extension =
            '.' +
            docs[i].mimeType.substring(docs[i].mimeType.lastIndexOf('.') + 1)
          attachment.iconURL = docs[i].iconUrl
          attachment.size = docs[i].sizeBytes
          attachment.user = JSON.parse(localStorage.getItem('user'))
          attachment.thumb = null
          attachment.thumb_list = null
          attachments.push(attachment)
        }
        this.tempAttachments = [...attachments]
        this.attachments = attachments
      }
      this.oauthToken = null
      this.pickerApiLoaded = false
    }
  },
  computed: {
    getTempAttachments() {
      return this.tempAttachments
    },
    getAttachments() {
      return this.attachments
    }
  }
}
</script>

<!-- Add 'scoped' attribute to limit CSS to this component only -->
<style scoped>
.google_sheet_tips{
  font-size: 14px;
  border: 1px dashed; 
}
.sheet_submit_button{
  background: #00C2E0;
  border: 1px solid #00C2E0;
}
.sheet_submit_button:hover{
  background: rgb(2, 184, 212);
  border: 1px solid rgb(2, 184, 212);
}
.google_sheet_label{
  font-size: 14px;
}
.google_sheet_form{
  width: 600px;
  text-align: left !important;
}
.sheet_card{
  width: 400px;
  height: 360px;
}
.sheet_card .card-header{
  background: white;
  height: 80px;
}
.file-selector {
  padding: 55px;
  font-weight: 600;
  background-color: #f9f9f9;
  border: 1px solid #ccc;
  border-radius: 4px;
  color: #4e5b69;
  z-index: -9;
}
figure {
  margin: 0px;
}
.dropzone-container {
  display: flex;
  flex-direction: column;
  border: 1px dashed #ccc;
  border-radius: 15px;
}
h1,
h2 {
  font-weight: normal;
}
ul {
  list-style-type: none;
  padding: 0;
}
li {
  display: inline-block;
  margin: 0 10px;
}
a {
  color: #42b983;
}
.google_connect {
  background: #00C2E0;
  font-family: SFProDisplay-Regular;
  font-size: 14px;
  color: #ffffff;
  letter-spacing: 0.4px;
  padding: 12px 30px;
  border-radius: 4px;
  outline: none !important;
  cursor: pointer;
  transition: all 0.25s;
  border: 1px solid #00C2E0;
}
.google_connect:hover {
  background-color: rgba(65, 184, 131, 1);
  border-color: transparent;
}
.separator {
  position: relative;
}
.separator:after {
  position: absolute;
  content: "";
  height: 1px;
  width: 200px;
  background: #d8d8d8;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}
.span {
  position: relative;
  background: #f9f9f9;
  padding: 0 4px;
  z-index: 9;
  font-size: 12px;
  color: #4e5b69;
}
.json_card{
  border: none;
}
#json{
  font-size: 12px !important;
}
.google_sheet_holder{
  min-height: calc(100vh - 65px) !important;
}

@media (max-width: 600px) {
  .google_sheet_form{
    width: 100% !important;
  }

  .google_sheet_card{
    width: 100% !important;
  }
}
</style>
