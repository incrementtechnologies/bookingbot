<template>
    <div class="row">
        <div class="col-md-6">
            <div class="fbPage">
              <facebook-login class="button"
                @sdk-loaded="sdkLoaded"
                appId="791862984686403"
                @login="onLogin"
                @logout="onLogout"
                @get-initial-status="getUserData"
                scope="pages_show_list"
                >
              </facebook-login>
            </div>
            <div v-if="fbData.length !== [] && fbData.length > 0">
              <div class="fbMargin">
                  <h3>Facebook Pages</h3>
              </div>
              <div class="fbPage">
                  <div class="oneFbPage" v-for="(item, index) in fbData" :key="index">
                      <img class="txt_inline imageStyle" :src="selectedImage">
                      <label for="selectedPage">{{item.name}}</label>
                      <button style="float: right" v-if="!storeId.includes(item.id)" type="submit" class="btn btnSetup" @click="set(item)">Setup</button>
                  </div>
              </div>
              <div class="start">
                <span for="start">Join us to create templates and earn per template created.</span><br>
                <button type="submit" class="btn btnStart">Start</button>
              </div>
            </div>
            <div v-else>
              <empty :title="'No Page Available'"></empty>
            </div>
        </div>
        <div class="col-md-6">
            <div style="width: 100%; height: 90%; margin-top: 5%;">
                <center>
                    <Analytics></Analytics>
                </center>
            </div>
        </div>

    </div>
</template>
<style scoped>
.start{
    margin-top: 10%;
}
.btnStart{
    background-color: #00C2E0;
    width: 150px;
    margin-top: 2%;
}
span{
    font-size: 18px;
}
.oneFbPage{
    margin-top: 2%;
}
.btnSetup{
    float: right;
    background-color: #00C2E0;
    width: 150px;
}
label{
    margin-left: 2%;
    font-size: 18px;
}
.fbPage{
    margin-top: 10%;
}
.fbMargin{
    margin-top: 5%;
}
.imageStyle{
    width: 50px;
    height: 50px;
}
/* #app {
  display: flex;
  flex-direction: column;
  align-items: flex-start
} */
.information {
  margin-top: 100px;
  margin: auto;
  display: flex;
  flex-direction: column;
}
.well {
  background-color: rgb(191, 238, 229);
  margin: auto;
  padding: 50px 50px;
  ;
  border-radius: 20px;
  /* display:inline-block; */
}
.login {
  width: 200px;
  margin: auto;
}
.list-item:first-child {
  margin: 0;
}
.list-item {
  display: flex;
  align-items: center;
  margin-top: 20px;
}
.button {
  margin: auto;
}
</style>
<script>
import image from 'src/assets/img/logo.png'
import ROUTER from 'src/router'
import AUTH from 'src/services/auth'
import CONFIG from 'src/config.js'
import COMMON from 'src/common.js'
import empty from 'src/components/increment/generic/empty/Empty.vue'
import facebookLogin from 'facebook-login-vuejs'
import Analytics from 'src/modules/dashboard/Analytics.vue'
export default {
  data(){
    return {
      data: [],
      selectedImage: image,
      fbData: [],
      retrieveData: null,
      token: null,
      model: {},
      scope: {},
      isConnected: false,
      name: '',
      email: '',
      personalID: '',
      picture: '',
      FB: undefined,
      storeId: []
    }
  },
  mounted(){
    console.log('length ni cya', this.fbData.length)
    this.getUserData()
    this.retrieveSetup()
  },
  components: {
    facebookLogin,
    Analytics,
    empty
  },
  methods: {
    getUserData() {
      this.FB.api('/me', 'GET', { fields: 'id, name, email, picture' },
        user => {
          this.personalID = user.id
          this.email = user.email
          this.name = user.name
          this.picture = user.picture.data.url
          localStorage.setItem('fb_user_id', user.id)
        }
      )
      this.token = this.FB.getAccessToken()
      localStorage.setItem('fb_token', this.FB.getAccessToken())
      if(this.personalID !== null && this.token !== null){
        this.getFBPage()
      }
    },
    sdkLoaded(payload) {
      this.isConnected = payload.isConnected
      this.FB = payload.FB
      console.log('-----payload ni cya', this.FB.getAccessToken())
      if (this.isConnected) this.getUserData()
    },
    onLogin() {
      this.isConnected = true
      this.getUserData()
    },
    onLogout() {
      this.isConnected = false
      this.fbData = []
    },
    getFBPage(){
      let parameter = {
        user_id: localStorage.getItem('fb_user_id') === null ? this.personalID : localStorage.getItem('fb_user_id'),
        user_access_token: localStorage.getItem('fb_token') === null ? this.token : localStorage.getItem('fb_token')
      }
      console.log(parameter)
      $('#loading').css({display: 'block'})
      this.APIRequest('facebook_page/get_fb_page', parameter).then(response => {
        $('#loading').css({display: 'none'})
        this.fbData = response.data
        this.retrieveSetup()
        console.log('-------curl', response)
      })
    },
    set(item){

    },
    setup(item){
      console.log(item)
      let params = {
        fb: item.id,
        access_token: item.access_token,
        category: item.category,
        name: item.name
      }
      $('#loading').css({display: 'block'})
      this.APIRequest('setup_page/create', params).then(response => {
        $('#loading').css({display: 'none'})
        this.getFBPage()
        this.retrieveSetup()
      })
    },
    retrieveSetup(){
      this.APIRequest('setup_page/retrieve').then(response => {
        this.data = response.data
        console.log('asdfsafsdaf', response)
        response.data.forEach(el => {
          this.storeId.push(el.fb)
        })
      })
    }
  }
}
</script>
