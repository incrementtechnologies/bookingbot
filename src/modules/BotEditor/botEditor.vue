<template>
    <div class="container-fluid editor_container">
        <div class="bootEditorActionGroup">
            <button type="button" class="btn bootEditorActions" @click="redirect('/setting')"> Settings </button>
            <button type="button" class="btn bootEditorActions"> Preview </button>
            <button type="button" class="btn bootEditorSave" @click="save"> Save </button>
        </div>
        <div class="dropZone" v-for="(item, index) in returnResponse" :key="index" @drop="drop($event, index)" @dragover.prevent @dragenter.prevent>
            <div class="draggable" draggable @dragstart="drag($event, index)">
                <div class="col-md-12 card bootEditorCard" v-if="item.type.toLowerCase() === 'welcome'">
                    <div class="card-body bootEditorBody">
                        <div class="d-flex justify-content-between">
                            <div>
                                <select class="type_select form-control" v-model="response[index].data.messageType">
                                    <option v-for="mType in type" :key="mType">{{mType}}</option>
                                </select>
                                <span>
                                <b>Welcome Message</b>
                                </span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <div>
                                    <i class="fas fa-chevron-up" @click="hide()"></i>
                                </div>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <div class="index">
                                    <b>{{index + 1}}</b>
                                </div>
                            </div>
                        </div>
                        <div class="hide_body">
                            <br/>
                            <br/>
                            <p>Message Keywords:</p>
                            <input type="text" class="form-control" placeholder="Getting Started, Hi, Hello ..." v-model="response[index].data.keywords"/>
                            <p>Reply</p>
                            <input type="text" class="form-control" placeholder="Welcome to { Company Name }! Hope you're doing well!" v-model="response[index].data.reply"/>
                        </div>
                    </div>
                    <div class="card-footer text-last bootEditorCardFooter">
                        <i class="far fa-trash-alt" @click="removeComponent($event, item.type, index)"></i>&nbsp;&nbsp;&nbsp;&nbsp;<i class="fas fa-plus" @click="addComponent(item.type, index)"></i>
                    </div>
                </div>
                <div class="col-md-12 card bootEditorCard" v-if="item.type.toLowerCase() === 'information'">
                    <div class="card-body bootEditorBody">
                        <div class="d-flex justify-content-between">
                            <div>
                                <select class="type_select form-control" v-model="response[index].data.messageType">
                                    <option v-for="mType in type" :key="mType">{{mType}}</option>
                                </select>
                                <span>
                                <b>Message</b>
                                </span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <div>
                                    <i class="fas fa-chevron-up" @click="hide()"></i>
                                </div>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <div class="index">
                                    <b>{{index + 1}}</b>
                                </div>
                            </div>
                        </div>
                        <div class="hide_body">
                            <br/>
                            <br/>
                            <p>Message Keywords:</p>
                            <input type="text" class="form-control" placeholder="Location, Address..." v-model="response[index].data.keywords"/>
                            <p>Reply</p>
                            <input type="text" class="form-control" placeholder="We are open all day and night!" v-model="response[index].data.reply"/>
                        </div>
                    </div>
                    <div class="card-footer text-last bootEditorCardFooter">
                        <i class="far fa-trash-alt" @click="removeComponent($event, item.type, index)"></i>&nbsp;&nbsp;&nbsp;&nbsp;<i class="fas fa-plus" @click="addComponent(item.type, index)"></i>
                    </div>
                </div>
                <div class="col-md-12 card bootEditorCard" v-if="item.type.toLowerCase() === 'products'">
                    <div class="card-body bootEditorBody">
                        <div class="d-flex justify-content-between">
                            <div>
                                <select class="type_select form-control" v-model="response[index].data.messageType">
                                    <option v-for="mType in type" :key="mType">{{mType}}</option>
                                </select>
                                <span>
                                <b>Products</b>
                                </span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <div>
                                    <i class="fas fa-chevron-up" @click="hide()"></i>
                                </div>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <div class="index">
                                    <b>{{index + 1}}</b>
                                </div>
                            </div>
                        </div>
                        <div class="hide_body">
                            <br/>
                            <br/>
                            <p>Message Keywords:</p>
                            <input type="text" class="form-control" placeholder="Products, rooms, etc..." v-model="response[index].data.keywords"/>
                            <div class="d-flex justify-content-between replyPadding">
                                <div>
                                    <p>Reply</p>
                                </div>
                                <div>
                                    <i class="fas fa-plus" @click="addReply(item.type, index, null, $event)"></i>
                                </div>
                            </div>
                            <div class="productsBody">
                                <div style="width: 180px; margin-right: 15px;" v-for="(data, data_index) in item.data.reply" :key="data_index">
                                    <center>
                                      <div class="productsElement productsAddImage" :style="'background-image: url(' + readImage(data.image) + ');background-size: 180px 140px !important;'">
                                            <i class="fas fa-plus" @click="imageUpload('image' + String(index) + String(data_index))"></i>
                                            <input :ref="'image' + String(index) + String(data_index)" type="file" accept="image/*" name="image_src" id="image_src" @change="uploaded($event, index, data_index)"/>
                                        </div>
                                    </center>
                                    <input type="text" class="form-control productsElement" placeholder="Title here" v-model="response[index].data.reply[data_index].title"/>
                                    <textarea class="form-control productsElement" placeholder="Description" v-model="response[index].data.reply[data_index].description"></textarea>
                                    <div v-for="(btn, productBTNNx) in data.buttons" :key="'products' + String(btn) + String(data_index + productBTNNx)">
                                      <button 
                                          type="button" 
                                          class="btn btn-info form-control productsElement bootEditorButtonfull"
                                          :id="'pop' + (String(data_index) + String(productBTNNx) + String(index))"
                                          @click="setUpBtnEvent('pop' + (data_index + productBTNNx + index), btn)"
                                      >{{(btn.title !== '') ? btn.title : 'click to setup' }}</button>
                                      <i class="far fa-trash-alt setup_remove" title="remove button" @click="removeReply(index, data_index, 'productButton', productBTNNx)"></i>
                                    </div>

                                    <b-popover ref="popover" v-for="(pops, popIndex) in data.buttons" :key="popIndex + data_index" :target="'pop' + (String(data_index) + String(popIndex) + String(index))" placement="right">
                                      <b class="popOverLabel"> Button Type </b>
                                      <select class="btn_type_select form-control" v-model="buttonType">
                                        <option v-for="(btnType, type_ndx) in buttonTypes" :key="type_ndx">{{btnType}}</option>
                                      </select>
                                      <b class="popOverLabel"> Button Name </b>
                                      <input type="text" class="form-control mb-2" placeholder="Button Name" v-model="buttonName"/>
                                      <b class="popOverLabel"> {{(pops.type.toLowerCase === 'url button' || buttonType.toLowerCase() === 'url button') ? 'Url' : 'Payload'}} </b>
                                      <input type="text" class="form-control mb-2" :placeholder="(pops.values.toLowerCase() === 'url button' || buttonType.toLowerCase() === 'url button') ? 'url' : 'payload'" v-model="buttonAction"/>
                                      <button type="button" class="btn btn-info form-control" @click="setup(index, data_index, popIndex)"> Setup </button>
                                    </b-popover>

                                    <button type="button" class="btn btn-info form-control productsElement bootEditorButtonOutlined" @click="addReply('addproductbutton', index, data_index, $event)">New Button</button>
                                    <button type="button" class="btn btn-info form-control productsElement bootEditorButtonOutlined" @click="removeReply(index, data_index, item.type)">Remove Product</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-last bootEditorCardFooter">
                        <i class="far fa-trash-alt" @click="removeComponent($event, item.type, index)"></i>&nbsp;&nbsp;&nbsp;&nbsp;<i class="fas fa-plus" @click="addComponent(item.type, index)"></i>
                    </div>
                </div>
                <div class="col-md-12 card bootEditorCard" v-if="item.type.toLowerCase() === 'redirects'">
                    <div class="card-body bootEditorBody">
                        <div class="d-flex justify-content-between">
                            <div>
                                <select class="type_select form-control" v-model="response[index].data.messageType">
                                    <option v-for="mType in type" :key="mType">{{mType}}</option>
                                </select>
                                <span>
                                <b>Redirects</b>
                                </span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <div>
                                    <i class="fas fa-chevron-up" @click="hide()"></i>
                                </div>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <div class="index">
                                    <b>{{index + 1}}</b>
                                </div>
                            </div>
                        </div>
                        <div class="hide_body">
                            <br/>
                            <br/>
                            <p>Message Keywords:</p>
                            <input type="text" class="form-control" placeholder="Map..." v-model="response[index].data.keywords"/>
                            <div class="d-flex justify-content-between replyPadding">
                                <div>
                                    <p>Reply</p>
                                </div>
                                <div>
                                    <i class="fas fa-plus" @click="addReply(item.type, index, null, $event)"></i>
                                </div>
                            </div>
                            <div class="redirects">
                                <div class="mr-2" v-for="(data, re_index) in item.data.reply" :key="'redirect' + String(re_index) + String(index)">
                                    <button 
                                    type="button" 
                                    class="btn btn-outline-info form-control productsElement bootEditorButtonOutlined ButtonsSlider"
                                    :id="'re_pop' + (String(re_index) + String(index))"
                                    @click="setUpBtnEvent('re_pop' + (re_index + index), data)"
                                    >
                                    {{(data.title !== '') ? data.title : 'click to setup'}}</button>
                                    <i class="far fa-trash-alt setup_remove" title="remove button" @click="removeReply(index, re_index, item.type)"></i>
                                    <b-popover ref="popover" :target="'re_pop' + (String(re_index) + String(index))" placement="right">
                                      <b class="popOverLabel"> Button Type </b>
                                      <select class="btn_type_select form-control" v-model="buttonType">
                                        <option v-for="(btnType, type_ndx) in buttonTypes" :key="type_ndx">{{btnType}}</option>
                                      </select>
                                      <b class="popOverLabel"> Button Name </b>
                                      <input type="text" class="form-control mb-2" placeholder="Button Name" v-model="buttonName"/>
                                      <b class="popOverLabel">{{(data.type.toLowerCase() === 'url button' || buttonType.toLowerCase() === 'url button') ? 'Url' : 'Payload'}}</b>
                                      <input type="text" class="form-control mb-2" :placeholder="(data.type.toLowerCase() === 'url button' || buttonType.toLowerCase() === 'url button') ? 'Url' : 'Payload'" v-model="buttonAction"/>
                                      <button type="button" class="btn btn-info form-control" @click="setUpRedirect(index, re_index,)"> Setup </button>
                                    </b-popover>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-last bootEditorCardFooter">
                        <i class="far fa-trash-alt" @click="removeComponent($event, item.type, index)"></i>&nbsp;&nbsp;&nbsp;&nbsp;<i class="fas fa-plus" @click="addComponent(item.type, index)"></i>
                    </div>
                </div>
                <div class="col-md-12 card bootEditorCard" v-if="item.type.toLowerCase() === 'confirmation'">
                    <div class="card-body bootEditorBody">
                        <div class="d-flex justify-content-between">
                            <div>
                                <select class="type_select form-control" v-model="response[index].data.messageType">
                                    <option v-for="mType in type" :key="mType">{{mType}}</option>
                                </select>
                                <span>
                                <b>Confirmation</b>
                                </span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <div>
                                    <i class="fas fa-chevron-up" @click="hide()"></i>
                                </div>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <div class="index">
                                    <b>{{index + 1}}</b>
                                </div>
                            </div>
                        </div>
                        <div class="hide_body">
                            <br/>
                            <br/>
                            <p>Message Keywords:</p>
                            <input type="text" class="form-control" placeholder="Getting Started, Hi, Hello ..." v-model="response[index].data.keywords"/>
                            <p>Reply</p>
                            <input type="text" class="form-control productsElement" placeholder="Are your sure?" v-model="response[index].data.reply"/>
                             <button type="button" class="mb-4 mt-4 btn btn-info productsElement bootEditorButtonOutlined confirmationBTN type_select" @click="addReply(item.type, index, null, $event)"><i class="fas fa-plus-circle mr-1"></i> Add Button</button>
                            <div class="d-flex justify-content-end">
                              <div v-for="(co_btn, co_btn_index) in item.data.buttons" :key="'confirmation' + String(co_btn_index) + String(index)">
                                <button 
                                type="button" 
                                class="btn btn-info productsElement bootEditorButtonfull confirmationBTN" 
                                :id="'co_pop' + (String(co_btn_index) + String(index))"
                                @click="setUpBtnEvent('co_pop' + (String(co_btn_index) + String(index)), co_btn)"
                                >{{(co_btn.title !== '') ? co_btn.title : 'click to setup'}}</button>
                                <i class="far fa-trash-alt setup_remove" title="remove button" @click="removeReply(index, co_btn_index, item.type)"></i>
                              </div>
                                <b-popover ref="popover" v-for="(pops, co_popIndex) in item.data.buttons" :key="co_popIndex + index" :target="'co_pop' + (String(co_popIndex) + String(index))" placement="right">
                                  <b class="popOverLabel"> Button Type </b>
                                  <select class="btn_type_select form-control" v-model="buttonType">
                                    <option v-for="(btnType, type_ndx) in buttonTypes" :key="type_ndx">{{btnType}}</option>
                                  </select>
                                  <b class="popOverLabel"> Button Name </b>
                                  <input type="text" class="form-control mb-2" placeholder="Button Name" v-model="buttonName"/>
                                  <b class="popOverLabel"> {{(pops.type.toLowerCase() === 'url button' || buttonType.toLowerCase() === 'url button') ? 'Url' : 'Payload'}} </b>
                                  <input type="text" class="form-control mb-2" :placeholder="(pops.type.toLowerCase() === 'url button' || buttonType.toLowerCase() === 'url button') ? 'Url' : 'Payload'"  v-model="buttonAction"/>
                                  <button type="button" class="btn btn-info form-control" @click="setUpConfirmation(index, co_popIndex)"> Setup </button> 
                                </b-popover>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bootEditorCardFooter">
                        <i class="far fa-trash-alt" @click="removeComponent($event, item.type, index)"></i>&nbsp;&nbsp;&nbsp;&nbsp;<i class="fas fa-plus" @click="addComponent(item.type, index)"></i>
                    </div>
                </div>
                 <div class="col-md-12 card bootEditorCard" v-if="item.type.toLowerCase() === 'form'">
                    <div class="card-body bootEditorBody">
                        <div class="d-flex justify-content-between">
                            <div>
                                <select class="type_select form-control" v-model="response[index].data.messageType">
                                    <option v-for="mType in type" :key="mType">{{mType}}</option>
                                </select>
                                <span>
                                <b>Form</b>
                                </span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <div>
                                    <i class="fas fa-chevron-up" @click="hide()"></i>
                                </div>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <div class="index">
                                    <b>{{index + 1}}</b>
                                </div>
                            </div>
                        </div>
                        <div class="hide_body pt-4">
                            <p class="mb-1"> Keyword </p>
                            <input type="text" class="form-control" placeholder="Keywords" v-model="response[index].data.keywords"/>
                            <button type="button" class="mt-5 btn btn-info bootEditorActions type_select"  @click="driveIconClicked(index)">
                              Connect to Drive
                            </button>
                            <div class="card text-left mt-3 google_sheet_tips">
                              <div class="card-body pt-2 pb-2 pl-1 pr-1">
                                <p class="m-0"><b> Tips: </b> Connect with google drive to auto fill some details. </p>
                              </div>
                            </div>
                            <p class="mb-1 mt-2">File Name:</p>
                            <input type="text" class="form-control" placeholder="File Name" v-model="response[index].data.file_name"/>
                            <p class="mb-1 mt-2">Google Sheet ID:</p>
                            <input type="text" class="form-control" placeholder="Sheet ID" v-model="response[index].data.sheet_id"/>
                            <p class="mb-1 mt-2">Google Sheet Page:</p>
                            <input type="text" class="form-control mb-5" placeholder="Page" v-model="response[index].data.page_number"/>
                            <div class="mt-4">
                            <button type="button" class="form-control btn bt-info bootEditorActions type_select" @click="addReply(item.type, index, null, $event)"> <i class="fas fa-plus-circle mr-1"></i> Question </button>
                            </div>
                            <div class="fieldContainer">
                              <div class="fieldSubContainer mt-4 mt-1 mb-1 p-0" v-for="(form, form_index) in item.data.fields" :key="String(form) + form_index">
                                <div class="form_field_wrapper">
                                  <input type="text" class="form_field" placeholder="Question" v-model="response[index].data.fields[form_index].header"/>
                                </div>
                                <div class="ml-2 mr-2">
                                  <i class="far fa-trash-alt text-danger" @click="removeField(index, 'fields', form_index)"></i>
                                </div>
                                <div class="p-2">
                                  <i class="fas fa-cog" :id="'form_pop' + (String(form_index) + String(index))" @click="settings('form_pop' + (String(form_index) + String(index)), form)"></i>
                                </div>
                              </div>
                              <b-popover ref="popover" v-for="(pops, form_popIndex) in item.data.fields" :key="form_popIndex + index" :target="'form_pop' + (String(form_popIndex) + String(index))" placement="right">
                                    <b class="popOverLabel"> Type </b>
                                    <select class="btn_type_select form-control mb-2" v-model="formType">
                                      <option v-for="(btnType, type_ndx) in fieldTypes" :key="type_ndx">{{btnType}}</option>
                                    </select>
                                    <b class="popOverLabel" v-if="pops.type.toLowerCase() === 'Text' || formType.toLowerCase() === 'text'"> Length </b>
                                    <input type="number" class="form-popover mb-2" placeholder="Field Length" v-model="formLength" v-if="pops.type.toLowerCase() === 'Text' || formType.toLowerCase() === 'text'"/>
                                    <b class="popOverLabel"> Value </b>
                                    <input type="text" class="form-popover mb-2" placeholder="Field Value" v-model="formValue"/>
                                    <button type="button" class="btn btn-info form-control mt-2" @click="settingsSave(index, form_popIndex)"> Setup </button>
                                </b-popover>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-last bootEditorCardFooter">
                        <i class="far fa-trash-alt" @click="removeComponent($event, item.type, index)"></i>&nbsp;&nbsp;&nbsp;&nbsp;<i class="fas fa-plus" @click="addComponent(item.type, index)"></i>
                    </div>
                </div>
            </div>
        </div>
        <div ref="removeAlert" class="modal fade remove_alert" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content text-center">
                    <div class="card">
                        <div class="card-body">
                            <i class="fas fa-exclamation-triangle warningIcon"></i>
                            <p>{{returnAlert}}</p>
                            <button class="btn bootEditorSave" data-dismiss="modal">OK</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
import CONFIG from 'src/config.js'
import AUTH from 'src/services/auth'
export default {
  data () {
    return {
      top: 'top: 90px',
      type: [
        'Text',
        'Slider',
        'Sliderbuttons',
        'Form'
      ],
      response: [
        {
          data: {
            keywords: '',
            reply: '',
            messageType: 'Text'
          },
          type: 'welcome'
        },
        {
          data: {
            keywords: '',
            reply: '',
            messageType: 'Text'
          },
          type: 'information'
        },
        {
          data: {
            keywords: '',
            reply: [],
            messageType: 'Slider'
          },
          type: 'products'
        },
        {
          data: {
            keywords: '',
            reply: [],
            messageType: 'Sliderbuttons'
          },
          type: 'redirects'
        },
        {
          data: {
            keywords: '',
            buttons: [],
            reply: '',
            messageType: 'Text'
          },
          type: 'confirmation'
        },
        {
          data: {
            keywords: '',
            file_name: '',
            sheet_id: '',
            page_number: '',
            fields: [],
            messageType: 'Form'
          },
          type: 'form'
        }
      ],
      popState: false,
      buttonName: '',
      buttonAction: '',
      buttonType: '',
      formType: '',
      formLength: '',
      formValue: '',
      bgImage: '',
      alertMessage: '',
      BACKEND_URL: CONFIG.BACKEND_URL,
      user: AUTH.user,
      modalShow: false,
      Data: new FormData(),
      buttonTypes: [
        'URL Button',
        'Postback Button'
      ],
      fieldTypes: [
        'Text',
        'Email'
      ],
      google_file_index: null,
      attachments: [],
      pickerApiLoaded: false,
      developerKey: 'AIzaSyCfIlbignMnRJUkyEa0Q8klw2_el_Mohyo',
      clientId: '160116820228-sfnqnvn5d1e6let49onfn396veagua30.apps.googleusercontent.com',
      scope: 'https://www.googleapis.com/auth/drive.file',
      oauthToken: null
    }
  },
  mounted () {
    let gDrive = document.createElement('script')
    gDrive.setAttribute('type', 'text/javascript')
    gDrive.setAttribute('src', 'https://apis.google.com/js/api.js')
    document.head.appendChild(gDrive)

    this.retrieve()
  },
  components: {},
  computed: {
    scrollPosition(){
      return this.top
    },
    returnResponse () {
      return this.response
    },
    returnBackground () {
      return this.bgImage
    },
    returnAlert () {
      return this.alertMessage
    },
    hideModal() {
      return this.browseModal
    }
  },
  methods: {
    redirect(url) {
      this.$router.push(url)
    },
    drag: (evt, index) => {
      evt.dataTransfer.dropEffect = 'move'
      evt.dataTransfer.effectAllowed = 'move'
      evt.dataTransfer.setData('index', index)
    },
    drop (evt, containerIndex) {
      const index = evt.dataTransfer.getData('index')
      let temp = this.response[index]
      this.response.splice(index, 1)
      this.response.splice(containerIndex, 0, temp)
    },
    addReply (type, index, optionalIndex = null, event) {
      switch(type){
        case 'products':
          if(this.response[index].data.reply.length + 1 < 11){
            let tempProduct = {
              image: '',
              title: '',
              description: '',
              buttons: []
            }
            this.response[index].data.reply.push(tempProduct)
          }else{
            event.target.setAttribute('data-toggle', 'modal')
            event.target.setAttribute('data-target', '.remove_alert')
            this.alertMessage = 'Products exceeds the maximum number!'
          }
          break
        case 'redirects':
          if(this.response[index].data.reply.length + 1 < 11){
            let tempRedirect = {
              title: '',
              values: '',
              type: ''
            }
            this.response[index].data.reply.push(tempRedirect)
          }else{
            event.target.setAttribute('data-toggle', 'modal')
            event.target.setAttribute('data-target', '.remove_alert')
            this.alertMessage = 'Redirects exceeds the maximum number!'
          }
          break
        case 'confirmation':
          if(this.response[index].data.buttons.length + 1 < 4){
            let tempConfirmation = {
              title: '',
              values: '',
              type: ''
            }
            this.response[index].data.buttons.push(tempConfirmation)
          }else{
            event.target.setAttribute('data-toggle', 'modal')
            event.target.setAttribute('data-target', '.remove_alert')
            this.alertMessage = 'Confirmation exceeds the maximum number!'
          }
          break
        case 'addproductbutton':
          if(this.response[index].data.reply[optionalIndex].buttons.length + 1 < 4){
            let tempAddProductButton = {
              title: '',
              values: '',
              type: ''
            }
            this.response[index].data.reply[optionalIndex].buttons.push(tempAddProductButton)
          }else{
            event.target.setAttribute('data-toggle', 'modal')
            event.target.setAttribute('data-target', '.remove_alert')
            this.alertMessage = 'Product Button exceeds the maximum number!'
          }
          break
        case 'form':
          let tempField = {
            header: '',
            type: '',
            length: ''
          }
          this.response[index].data.fields.push(tempField)
          break
      }
    },
    addComponent(type, index){
      switch(type){
        case 'welcome':
          let tempWelcome = {
            data: {
              keywords: '',
              reply: '',
              messageType: 'Text'
            },
            type: type
          }
          this.response.splice(index + 1, 0, tempWelcome)
          break
        case 'information':
          let tempInformation = {
            data: {
              keywords: '',
              reply: '',
              messageType: 'Text'
            },
            type: type
          }
          this.response.splice(index + 1, 0, tempInformation)
          break
        case 'products':
          let tempProduct = {
            data: {
              keywords: '',
              reply: [],
              messageType: 'Slider'
            },
            type: type
          }
          this.response.splice(index + 1, 0, tempProduct)
          break
        case 'redirects':
          let tempRedirect = {
            data: {
              keywords: '',
              reply: [],
              messageType: 'SliderButtons'
            },
            type: type
          }
          this.response.splice(index + 1, 0, tempRedirect)
          break
        case 'confirmation':
          let tempConfirmation = {
            data: {
              keywords: '',
              reply: '',
              buttons: [],
              messageType: 'Text'
            },
            type: type
          }
          this.response.splice(index + 1, 0, tempConfirmation)
          break
        case 'form':
          let tempForm = {
            data: {
              keywords: '',
              file_name: '',
              sheet_id: '',
              page_number: '',
              fields: [],
              messageType: 'Form'
            },
            type: type
          }
          this.response.splice(index + 1, 0, tempForm)
          break
      }
    },
    removeField(index, property, propIndex){
      this.response[index].data[property].splice(propIndex, 1)
    },
    removeComponent(event, type, index){
      let x = 0
      this.response.forEach(element => {
        if(element.type === type){
          x++
        }
      })
      if(!(x > 0 && x < 2)){
        this.response.splice(index, 1)
      }else{
        this.alertMessage = 'Unable to remove this item!'
        event.target.setAttribute('data-toggle', 'modal')
        event.target.setAttribute('data-target', '.remove_alert')
      }
    },
    setup(index, dataIndex, buttonIndex){
      this.$root.$emit('bv::hide::popover')
      this.response[index].data.reply[dataIndex].buttons[buttonIndex].title = this.buttonName
      this.response[index].data.reply[dataIndex].buttons[buttonIndex].values = this.buttonAction
      this.response[index].data.reply[dataIndex].buttons[buttonIndex].type = this.buttonType
      this.buttonName = ''
      this.buttonAction = ''
      this.buttonType = ''
    },
    setUpRedirect(index, ReIndex){
      this.$root.$emit('bv::hide::popover')
      this.response[index].data.reply[ReIndex].title = this.buttonName
      this.response[index].data.reply[ReIndex].values = this.buttonAction
      this.response[index].data.reply[ReIndex].type = this.buttonType
      this.buttonName = ''
      this.buttonAction = ''
    },
    setUpConfirmation(index, CoIndex){
      this.$root.$emit('bv::hide::popover')
      this.response[index].data.buttons[CoIndex].title = this.buttonName
      this.response[index].data.buttons[CoIndex].values = this.buttonAction
      this.response[index].data.buttons[CoIndex].type = this.buttonType
      this.buttonName = ''
      this.buttonAction = ''
      this.buttonType = ''
    },
    setUpBtnEvent(id, btn){
      this.buttonName = btn.title
      this.buttonAction = btn.values
      this.buttonType = btn.type
      if(this.popState){
        this.$root.$emit('bv::hide::popover')
        this.popState = !this.popState
      }
      if(this.popState === false){
        this.$root.$emit('bv::show::popover', id)
        this.popState = !this.popState
      }
    },
    settings(id, form){
      this.formType = form.type
      this.formLength = form.length
      this.formValue = form.value
      if(this.popState){
        this.$root.$emit('bv::hide::popover')
        this.popState = !this.popState
      }
      if(this.popState === false){
        this.$root.$emit('bv::show::popover', id)
        this.popState = !this.popState
      }
    },
    settingsSave(index, Sindex){
      this.$root.$emit('bv::hide::popover')
      this.response[index].data.fields[Sindex].type = this.formType
      this.response[index].data.fields[Sindex].length = this.formLength
      this.response[index].data.fields[Sindex].value = this.formValue
      this.formType = ''
      this.formLength = ''
      this.formValue = ''
    },
    formRequest(url, data){
      let config = {
        header: {
          'Content-Type': 'multipart/form-data'
        }
      }
      let api = axios
      return new Promise((resolve, reject) => {
        api.post(CONFIG.BACKEND_URL + url, data, config).then(response => {
          resolve(response)
        })
      })
    },
    readImage(image){
      return (image.includes('.')) ? CONFIG.BACKEND_URL + image : ''
    },
    imageUpload(image){
      this.$refs[image][0].click()
    },
    uploaded(event, index, dataIndex){
      if (event.target.files && event.target.files[0]) {
        var reader = new FileReader()
        let dom = this
        let i = index
        let dI = dataIndex
        let time = Date.now()
        let form = new FormData()
        form.append('accountID', this.user.userID)
        this.Data.append(String(this.user.userID) + time, event.target.files[0])
        this.response[i].data.reply[dI].image = String(this.user.userID) + time
        reader.onload = function(e) {
          event.target.parentNode.style = 'background-image: url(' + e.target.result + ') !important;background-size: 180px 140px !important;'
        }
        reader.readAsDataURL(event.target.files[0]) // convert to base64 string
      }
    },
    hide(e){
      let a = event.target.parentNode.parentNode.parentNode.parentNode
      if(a.children[1].style.display !== 'none'){
        a.children[1].style = 'display: none;'
        a.parentNode.children[1].style = 'display: none;'
        event.target.className = 'fas fa-chevron-down'
      }else{
        a.children[1].style = 'display: block;'
        a.parentNode.children[1].style = 'display: flex;'
        event.target.className = 'fas fa-chevron-up'
      }
    },
    retrieve(){
      let parameters = {
        account_id: this.user.userID
      }
      $('#loading').css({display: 'block'})
      this.APIRequest('bot_template/retrieve', parameters).then(response => {
        $('#loading').css({display: 'none'})
        if(response.data.length > 0){
          let parse = JSON.parse(response.data[0].content)
          this.response = parse.data
        }
      })
    },
    async save (e) {
      e.preventDefault()
      this.Data.append('account_id', this.user.userID)
      this.Data.append('content', JSON.stringify({data: this.response}))
      $('#loading').css({display: 'block'})
      await this.formRequest('/bot_template/save', this.Data).then(response => {
        console.log(response.data)
        $('#loading').css({display: 'none'})
      })
    },
    url(directory){
      return (directory === '') ? '' : this.BACKEND_URL
    },
    removeReply(index, toRemoveIndex, type, optionalIndex = null){
      switch(type){
        case 'products':
          this.response[index].data.reply.splice(toRemoveIndex, 1)
          break
        case 'confirmation':
          this.response[index].data.buttons.splice(toRemoveIndex, 1)
          break
        case 'redirects':
          this.response[index].data.reply.splice(toRemoveIndex, 1)
          break
        case 'productButton':
          this.response[index].data.reply[toRemoveIndex].buttons.splice(optionalIndex, 1)
          break
      }
    },
    async driveIconClicked(index) {
      this.google_file_index = index
      await gapi.load('auth2', () => {
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
        this.pickerApiLoaded = true
        this.createPicker()
      })
    },
    handleAuthResult(authResult) {
      if (authResult && !authResult.error) {
        this.oauthToken = authResult.access_token
        this.createPicker()
      }
    },
    // Create and render a Picker object for picking user Photos.
    createPicker() {
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
        this.response[this.google_file_index].data.file_name = attachments[0].title
        this.response[this.google_file_index].data.sheet_id = attachments[0]._id
        this.attachments = attachments
      }
      this.oauthToken = null
      this.pickerApiLoaded = false
    }
  }
}
</script>

<style scoped>
.google_sheet_tips{
  font-size: 14px;
  border: 1px dashed; 
}
.sheet_connect_button{
  background: #00C2E0;
  border: 1px solid #00C2E0;
}
.sheet_connect_button:hover{
  background: rgb(2, 184, 212);
  border: 1px solid rgb(2, 184, 212);
}
.form-control{
  font-size: 14px;
}
.popover{
  width: 320px !important;
}
.btn_type_select{
  font-size: 14px !important;
  /* border: 1px solid #00C2E0;
  color: #00C2E0; */
}
.setup_remove{
  position: absolute;
  font-size: 11px !important;
  color: red;
  padding: 6px;
  border-radius: 50%;
  border: 1px solid white;
  margin-top: 6px;
  margin-left: -35px !important;
  background: white;
}
.form_add{
  width: 140px !important;
  color: #00C2E0;
}
.form_field_wrapper{
  width: 100%;
  border-radius: 4px;
}
.form-popover{
  padding-left: 15px;
  padding-right: 15px;
  height: 40px;
  width: 100% !important;
  outline: none;
  border: 1px solid rgb(216, 216, 216);
}
.form_field{
  border: none;
  border-radius: 4px;
  padding-left: 15px;
  padding-right: 15px;
  height: 40px;
  width: 100% !important;
  outline: none;
}
.form_field:active{
  outline: none;
  box-shadow: none;
}
.fieldSubContainer{
  border: 1px solid rgb(216, 216, 216);
  border-radius: 4px;
  padding-left: 5px;
  padding-right: 5px;
  padding-top: 5px;
  padding-bottom: 5px;
  min-height: 40px;
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.fieldContainer{
  /* border: 1px solid rgb(216, 216, 216);x */
  border-radius: 0px;
  font-size: 12px;
  /* padding: 15px; */
}
.editor_container{
  /* padding-left: 20%;
  padding-right: 20%; */
}
.modalTrigger{
    display: none;
}
.warningIcon{
    font-size: 30px;
    padding: 10px;
    padding-bottom: 15px;
    padding-left: 12px;
    padding-right: 12px;
    color: white;
    background: rgb(226, 196, 25);
    border-radius: 50%;
    margin-bottom: 15px;
}
.remove_alert{
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) !important;
}
#image_src{
    display: none;
}
.popOverLabel{
    font-weight: normal;
    font-size: 12px;
}
.type_select{
    height: 40px;
    border: 1px solid #00C2E0;
    color: #00C2E0;
    width: 140px !important;
    display: inline;
    padding-top: 5px;
    font-size: 12px;
}
.bootEditorActionGroup{
    display: flex;
    justify-content: flex-end;
    margin-bottom: 50px;
    margin-top: 50px;
}
.bootEditorSave{
    width: 100px;
    font-size: 13px;
    outline: none;
    background: #00C2E0;
    border: 1px solid #00C2E0 !important;
    color: white;
    margin-left: 2px;
    margin-right: 2px;
    cursor: pointer;
}
.bootEditorSave:focus{
    box-shadow: none;
}
.bootEditorActions{
    width: 100px;
    margin-left: 2px;
    margin-right: 2px;
    padding-top: 5px;
    padding-bottom: 5px;
    font-size: 13px;
    outline: none;
    background: white;
    border: 1px solid #00C2E0 !important;
    cursor: pointer;
}
.bootEditorActions:hover{
    color: white;
    background: #00C2E0;
}
.bootEditorActions:focus{
    box-shadow: none;
}
.confirmationAdd{
  width: 140px !important;
  padding-top: 5px;
  padding-bottom: 5px;
  font-size: 13px;
}
.confirmationBTN{
    width: 220px;
    margin-left: 2px;
    margin-right: 2px;
    white-space: normal !important;
}
.dropZone{
    width: 100%;
}
.draggable{
    width: 100%;
}
.index{
    margin-top: -7px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 10px;
    padding-left: 17px;
    padding-right: 17px;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    border: 2px solid #00C2E0 !important;
}
.index b {
    font-style: normal;
    font-size: 10px;
    padding: 0px;
    margin: 0px;
}
.bootEditorBody{
    padding: 0px;
    padding-top: 15px;
    padding-bottom: 15px;
    direction: ltr;
}
.bootEditorCard{
    margin-bottom: 15px;
    font-size: 14px !important;
}
.bootEditorCardFooter{
    background: none;
    border-top: none;
    padding-top: 0px;
    display: flex;
    justify-content: flex-end;
}
.bootEditorCardFooter i  {
    cursor: pointer;
}
.bootEditorButtonfull{
    background-color: #00C2E0;
    outline: none;
    white-space: normal !important;
}
.bootEditorButtonfull:hover{
    outline: none;
    color: white;
    border: 1px solid #00C2E0;
    box-shadow: none;
}
.bootEditorButtonfull:focus{
    color: white;
    border: 1px solid #00C2E0;
    box-shadow: none;
}
.bootEditorButtonfull:active{
    color: white;
    border: 1px solid #00C2E0;
    box-shadow: none;
}
.bootEditorButtonOutlined{
    background-color: white;
    border: 1px solid #00C2E0;
    color: #00C2E0;
    outline: none;
}
.bootEditorButtonOutlined:hover{
    color: white;
    background-color: #00C2E0;
}
.bootEditorButtonOutlined:focus{
    box-shadow: none;
}
.ButtonsSlider{
    border-radius: 20px;
    width: 170px;
    white-space: normal !important;
}
 /* style="height: 140px; width: 180px; border: 1px solid #e3e1da;" */
.productsAddImage{
    height: 140px;
    width: 180px;
    border: 1px solid #e3e1da;
    display: flex;
    align-items: center;
    justify-content: center;
}
.productsElement{
    margin-bottom: 5px;
}
.productsAddImage i {
    font-size: 30px;
    cursor: pointer;
    color: white;
    -webkit-text-stroke-width: 1px;
    -webkit-text-stroke-color: rgb(100, 98, 98);
}

.productsBody{
    padding: 15px;
    padding-left: 0px;
    padding-right: 0px;
    display: flex;
    justify-content: flex-start;
    overflow-x: scroll;
    scrollbar-width: thin !important;
}
.redirects{
    padding: 15px;
    padding-left: 0px;
    padding-right: 0px;
    display: flex;
    justify-content: flex-start;
    overflow-x: scroll;
}
.replyPadding{
    padding-top: 15px;
}
.replyPadding div i{
    cursor: pointer;
}
.productsBody::-webkit-scrollbar-track
{
	-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
	background-color: #F5F5F5;
}

.productsBody::-webkit-scrollbar
{
    height: 7px;
	background-color: #F5F5F5;
}

.productsBody::-webkit-scrollbar-thumb
{
	background-color: #00C2E0;
	border: 0px;
    border-radius: 10px;
}

.redirects::-webkit-scrollbar-track
{
	-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
	background-color: #F5F5F5;
}

.redirects::-webkit-scrollbar
{
    height: 7px;
	background-color: #F5F5F5;
}

.redirects::-webkit-scrollbar-thumb
{
	background-color: #00C2E0;
	border: 0px;
    border-radius: 10px;
}
@media (max-width: 600px) {
    .editor_container{
        padding-left: 0px;
        padding-right: 0px;
    }
}
</style>

