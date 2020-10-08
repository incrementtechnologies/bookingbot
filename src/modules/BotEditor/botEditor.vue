<template>
    <div class="container-fluid editor_container">
        <div class="bootEditorActionGroup">
            <button type="button" class="btn bootEditorActions"> settings </button>
            <button type="button" class="btn bootEditorActions"> preview </button>
            <button type="button" class="btn bootEditorSave" @click="save"> save </button>
        </div>
        <div class="dropZone" v-for="(item, index) in returnResponse" :key="index" @drop="drop($event, index)" @dragover.prevent @dragenter.prevent>
            <div class="draggable" draggable @dragstart="drag($event, index)">
                <div class="col-md-12 card bootEditorCard" v-if="item.type === 'welcome'">
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
                <div class="col-md-12 card bootEditorCard" v-if="item.type === 'information'">
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
                <div class="col-md-12 card bootEditorCard" v-if="item.type === 'products'">
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
                                    <button 
                                        type="button" 
                                        class="btn btn-info form-control productsElement bootEditorButtonfull" 
                                        v-for="(btn, productBTNNx) in data.buttons" 
                                        :key="'products' + String(btn) + String(data_index + productBTNNx)"
                                        :id="'pop' + (String(data_index) + String(productBTNNx) + String(index))"
                                        @click="setUpBtnEvent('pop' + (data_index + productBTNNx + index), btn)"
                                    >{{(btn.buttonName !== '') ? btn.buttonName : 'click to setup' }}</button>

                                    <b-popover ref="popover" v-for="(pops, popIndex) in data.buttons" :key="popIndex + data_index" :target="'pop' + (String(data_index) + String(popIndex) + String(index))" placement="right">
                                        <b class="popOverLabel"> Button Name </b>
                                        <input type="text" class="form-control mb-2" placeholder="Button Name" v-model="buttonName"/>
                                        <b class="popOverLabel"> Button Action </b>
                                        <input type="text" class="form-control mb-2" placeholder="link" v-model="buttonAction"/>
                                        <button type="button" class="btn btn-info form-control" @click="setup(index, data_index, popIndex)"> setup </button> 
                                    </b-popover>

                                    <button type="button" class="btn btn-info form-control productsElement bootEditorButtonOutlined" @click="addReply('addproductbutton', index, data_index, $event)">New Button</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-last bootEditorCardFooter">
                        <i class="far fa-trash-alt" @click="removeComponent($event, item.type, index)"></i>&nbsp;&nbsp;&nbsp;&nbsp;<i class="fas fa-plus" @click="addComponent(item.type, index)"></i>
                    </div>
                </div>
                <div class="col-md-12 card bootEditorCard" v-if="item.type === 'redirects'">
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
                                <div style="width: 180px; margin-right: 15px;" v-for="(data, re_index) in item.data.reply" :key="'redirect' + String(re_index) + String(index)">
                                    <button 
                                    type="button" 
                                    class="btn btn-outline-info form-control productsElement bootEditorButtonOutlined ButtonsSlider"
                                    :id="'re_pop' + (String(re_index) + String(index))"
                                    @click="setUpBtnEvent('re_pop' + (re_index + index), data)"
                                    >
                                    {{(data.buttonName !== '') ? data.buttonName : 'click to setup'}}</button>
                                    <b-popover ref="popover" :target="'re_pop' + (String(re_index) + String(index))" placement="right">
                                        <b class="popOverLabel"> Button Name </b>
                                        <input type="text" class="form-control mb-2" placeholder="Button Name" v-model="buttonName"/>
                                        <b class="popOverLabel"> Button Action </b>
                                        <input type="text" class="form-control mb-2" placeholder="link" v-model="buttonAction"/>
                                        <button type="button" class="btn btn-info form-control" @click="setUpRedirect(index, re_index)"> setup </button>
                                    </b-popover>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-last bootEditorCardFooter">
                        <i class="far fa-trash-alt" @click="removeComponent($event, item.type, index)"></i>&nbsp;&nbsp;&nbsp;&nbsp;<i class="fas fa-plus" @click="addComponent(item.type, index)"></i>
                    </div>
                </div>
                <div class="col-md-12 card bootEditorCard" v-if="item.type === 'confirmation'">
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
                            <div class="d-flex justify-content-end">
                                <button 
                                type="button" 
                                class="btn btn-info productsElement bootEditorButtonfull confirmationBTN" 
                                v-for="(co_btn, co_btn_index) in item.data.buttons" :key="'confirmation' + String(co_btn_index) + String(index)"
                                :id="'co_pop' + (String(co_btn_index) + String(index))"
                                @click="setUpBtnEvent('co_pop' + (String(co_btn_index) + String(index)), co_btn)"
                                >{{(co_btn.buttonName !== '') ? co_btn.buttonName : 'click to setup'}}</button>
                                <b-popover ref="popover" v-for="(pops, co_popIndex) in item.data.buttons" :key="co_popIndex + index" :target="'co_pop' + (String(co_popIndex) + String(index))" placement="right">
                                    <b class="popOverLabel"> Button Name </b>
                                    <input type="text" class="form-control mb-2" placeholder="Button Name" v-model="buttonName"/>
                                    <b class="popOverLabel"> Button Action </b>
                                    <input type="text" class="form-control mb-2" placeholder="link" v-model="buttonAction"/>
                                    <button type="button" class="btn btn-info form-control" @click="setUpConfirmation(index, co_popIndex)"> setup </button> 
                                </b-popover>
                                <button type="button" class="btn btn-info productsElement bootEditorButtonOutlined confirmationBTN" @click="addReply(item.type, index, null, $event)">Add Button</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bootEditorCardFooter">
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
        'text',
        'slider',
        'sliderbuttons'
      ],
      response: [
        {
          data: {
            keywords: '',
            reply: '',
            messageType: 'text'
          },
          type: 'welcome'
        },
        {
          data: {
            keywords: '',
            reply: '',
            messageType: 'text'
          },
          type: 'information'
        },
        {
          data: {
            keywords: '',
            reply: [],
            messageType: 'slider'
          },
          type: 'products'
        },
        {
          data: {
            keywords: '',
            reply: [],
            messageType: 'sliderbuttons'
          },
          type: 'redirects'
        },
        {
          data: {
            keywords: '',
            buttons: [],
            reply: '',
            messageType: 'text'
          },
          type: 'confirmation'
        }
      ],
      popState: false,
      buttonName: '',
      buttonAction: '',
      bgImage: '',
      alertMessage: '',
      BACKEND_URL: CONFIG.BACKEND_URL,
      user: AUTH.user,
      modalShow: false,
      Data: new FormData()
    }
  },
  mounted () {
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
              buttonName: '',
              values: ''
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
              buttonName: '',
              values: ''
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
              buttonName: '',
              values: ''
            }
            this.response[index].data.reply[optionalIndex].buttons.push(tempAddProductButton)
          }else{
            event.target.setAttribute('data-toggle', 'modal')
            event.target.setAttribute('data-target', '.remove_alert')
            this.alertMessage = 'Product Button exceeds the maximum number!'
          }
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
              messageType: 'message'
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
              messageType: 'message'
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
              messageType: 'slider'
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
              messageType: 'sliderbuttons'
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
              messageType: 'message'
            },
            type: type
          }
          this.response.splice(index + 1, 0, tempConfirmation)
          break
      }
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
      this.response[index].data.reply[dataIndex].buttons[buttonIndex].buttonName = this.buttonName
      this.response[index].data.reply[dataIndex].buttons[buttonIndex].values = this.buttonAction
      this.buttonName = ''
      this.buttonAction = ''
    },
    setUpRedirect(index, ReIndex){
      this.$root.$emit('bv::hide::popover')
      this.response[index].data.reply[ReIndex].buttonName = this.buttonName
      this.response[index].data.reply[ReIndex].buttonAction = this.buttonAction
      this.buttonName = ''
      this.buttonAction = ''
    },
    setUpConfirmation(index, CoIndex){
      this.$root.$emit('bv::hide::popover')
      this.response[index].data.buttons[CoIndex].buttonName = this.buttonName
      this.response[index].data.buttons[CoIndex].buttonAction = this.buttonAction
      this.buttonName = ''
      this.buttonAction = ''
    },
    setUpBtnEvent(id, btn){
      this.buttonName = btn.buttonName
      this.buttonAction = btn.values
      if(this.popState){
        this.$root.$emit('bv::hide::popover')
        this.popState = !this.popState
      }
      if(this.popState === false){
        this.$root.$emit('bv::show::popover', id)
        this.popState = !this.popState
      }
    },
    apiRequest(url, data){
      let config = {
        header: {
          'Content-Type': 'application/json'
        }
      }
      let api = axios
      return new Promise((resolve, reject) => {
        api.post(CONFIG.BACKEND_URL + url, data, config).then(response => {
          resolve(response)
        })
      })
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
      this.apiRequest('/bot_template/retrieve', parameters).then(response => {
        if(response.data.data.length > 0){
          let parse = JSON.parse(response.data.data[0].content)
          this.response = parse.data
        }
      })
    },
    async save (e) {
      e.preventDefault()
      this.Data.append('account_id', this.user.userID)
      this.Data.append('content', JSON.stringify({data: this.response}))
      await this.formRequest('/bot_template/save', this.Data).then(response => {
        console.log(response.data)
      })
    },
    url(directory){
      return (directory === '') ? '' : this.BACKEND_URL
    }
  }
}
</script>

<style scoped>
.editor_container{
    padding-left: 20%;
    padding-right: 20%;
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
    width: 150px;
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

