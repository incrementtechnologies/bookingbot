<template >
  <div class="container-fluid">
    <div class="my-3">
      <div class="container-fluid d-flex justify-content-between">
        Facebook Page: Increment Technologies
        <div>
          <button type="button" id="btn" class="btn btn-info" @click="save()" >Save</button>
          <b-button id="btn" variant="outline-info"  @click="configure(); enable = false ">Configure</b-button>
        </div>
      </div>
      <div class="container-fluid mt-3">
        <p>Get Started</p>
        <div class="d-flex justify-content-between">
          Enable to allow user click the get started button and reply
          the welcome message
          <b-button id="btn" variant="outline-info" @click="configure(); enable = true">Enable</b-button>
        </div>
        <div v-if ="successMessage!== null" >
          <label class = 'text-success'>{{successMessage}} </label>
        </div>
      </div>
    </div>
    <div
      class="container-fluid"
    >
      <div class="row">
        <div class="col-lg-4" 
        v-for="(menu,i) in setting.menus"
        :key="i"
        @dragstart="startDrag($event,i)"
        @drop="onDrop($event,i)"
        @dragover.prevent
        @dragenter.prevent
        >
          <div class="border mb-3">
            <div class="card border-0 px-3 py-1">
              <div class="card-title d-flex justify-content-between d-inline-flex align-items-center  ">
                <div>{{menu.name}} 
                </div> 
                  <div class="d-flex justify-content-between d-inline-flex align-items-center ">
                    <a
                    data-toggle="collapse"
                    :href="'#'+ i"
                    role="button"
                    aria-expanded="false"
                    :aria-controls="i"
                  >
                    <i class="fa fa-chevron-up mr-3"></i>
                    </a>
                    <div class="border border-primary rounded-circle py-2 px-3 mt-2">
                     {{i+1}}
                    </div>
                  </div>
              </div>
            </div>
            <div class="collapse show" :id="i">
              <b-card class="border-0">
                Title
                <b-form-input v-model="menu.name" list="my-list-id" placeholder="Rooms"></b-form-input>
                <b-card-text>
                  <br>Payload
                  <br>
                  <b-form-input list="my-list-id" placeholder="Payload" v-model="menu.payload"></b-form-input>
                </b-card-text>
              </b-card>
            </div>
          </div>
        </div>
      </div>
    </div>
    <confirmation  ref="confirmed" 
      title='Confirmation Message' :message="enable ? 'Are you sure you want to enable the settings?': 'Are you sure you want to configured the setting?'"   @onConfirm="enable ? getStarted() : persistentMenu()"
    ></confirmation>
  </div>
</template>
<script>
import ROUTER from 'src/router'
import axios from 'axios'
import Vue from 'vue'
import CONFIG from 'config'
import AUTH from 'src/services/auth'
import COMMON from 'src/common.js'
import confirmation from 'components/increment/generic/modal/Confirmation.vue'
export default {
  data: () => {
    return {
      user: AUTH.user,
      successMessage: null,
      enable: false,
      setting: {
        // configure: false,
        menus: [
          { id: 1, name: 'Menu 1', payload: null },
          { id: 2, name: 'Menu 2', payload: null },
          { id: 3, name: 'Menu 3', payload: null }
        ]
      }
    }
  },
  components: {
    'confirmation': require('components/increment/generic/modal/Confirmation.vue')
  },
  mounted() {
    this.retrieve()
  },
  computed: {
    returnSetting () {
      return this.setting
    }
  },
  methods: {
    configure(){
      this.$refs['confirmed'].show()
    },
    enableSettings(){
      let parameter = {
        account_id: this.user.userID
      }
      $('#loading').css({display: 'block'})
      this.APIRequest('bot/get_started', parameter).then(response => {
        $('#loading').css({display: 'none'})
      })
      .catch(err => console.log(err))
    },
    getStarted(){
      let parameter = {
        account_id: this.user.userID
      }
      $('#loading').css({display: 'block'})
      this.APIRequest('bot/get_started', parameter).then(response => {
        $('#loading').css({display: 'none'})
        this.successMessage = 'Enabled Successfully!'
        // console.log('You have successfully enabled the settings!')
      })
      .catch(err => console.log(err))
    },
    persistentMenu(){
      this.enableSettings()
      let parameter = {
        account_id: this.user.userID
      }
      this.APIRequest('bot/persistent', parameter).then(response => {
        $('#loading').css({display: 'none'})
        // console.log('You have successfully configured the settings! ')
        this.successMessage = 'Configured Successfully!'
      })
      .catch(err => console.log(err))
    },
    retrieve(){
      let parameter = {
        account_id: this.user.userID
      }
      $('#loading').css({display: 'block'})
      this.APIRequest('bot_template/retrieve', parameter).then(response => {
        $('#loading').css({display: 'none'})
      })
      .catch(err => console.log(err))
    },
    save(){
      let parameter = {
        account_id: this.user.userID,
        setting: JSON.stringify(this.setting)
      }
      $('#loading').css({display: 'block'})
      this.APIRequest('bot_template/save_settings', parameter).then(response => {
        $('#loading').css({display: 'none'})
      })
    },
    startDrag: (event, index) => {
      event.dataTransfer.dropEffect = 'move'
      event.dataTransfer.effectAllowed = 'move'
      event.dataTransfer.setData('menuIndex', index)
    },
    onDrop(evt, id) {
      const index = evt.dataTransfer.getData('menuIndex')
      let temp = this.setting.menus[index]
      this.setting.menus.splice(index, 1)
      this.setting.menus.splice(id, 0, temp)
    }
  }
}
</script>
<style scoped>
fa {
  margin-left: 75px;
  cursor: pointer;
  user-select: none;
}
.card-header {
  max-height: 1.9cm;
}
#btn {
  width: 105px;
}
@media (max-width: 992px) {
  .container-fluid{
    padding-left: 0px;
    padding-right: 0px;
    }
}
</style>
