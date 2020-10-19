<template>
  <div class="modal fade" id="guideModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
          <div class="modal-header bg-primary">
            <h5 class="modal-title text-white" id="exampleModalLabel">{{common.APP_NAME}} User Guide</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true" class="text-white">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="guide-holder">
              <p><strong>Hi {{user.username}}! Welcome to {{common.APP_NAME}} by {{common.COMPANY}}!</strong></p>
              <p v-if="guide !== null" v-html="guide">
              </p>
            </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#guideModal">Close</button>
          </div>
        </div>
      </div>
    </div>
</template>
<style scoped lang="scss">
@import "~assets/style/colors.scss";
.bg-primary{
  background-color: $primary !important;
}
.guide-holder{
  margin-top:22px;
  width:96%;
  float: left;
  margin-left:2%;
  margin-right:2%;
}

.jumbotron{
  padding-top: 0rem !important;
  padding-bottom: 0rem !important;
  background: #fff;
}

.alert{
  text-align: justify !important;
}
.alert-info{
  background: #fff !important;
  border: 0px !important;
  color: #212529;
}

ul{
  list-style: circle;
}

ul li{
  text-align: justify;
  font-size: 15px;
  color: grey;
  padding-top: 10px;
}
.bg-danger{
  color: #fff !important;
}
</style>
<script>
  import ROUTER from 'src/router'
  import Vue from 'vue'
  import AUTH from 'src/services/auth'
  import COMMON from 'src/common.js'
  export default{
    mounted(){
      this.getData()
    },
    data(){
      return {
        user: AUTH.user,
        common: COMMON,
        guide: null
      }
    },
    props: {
    },
    methods: {
      redirect(parameter){
        ROUTER.push(parameter)
      },
      getData(){
      }
    }
  }
</script>
