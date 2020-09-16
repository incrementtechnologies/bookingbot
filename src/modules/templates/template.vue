<template>
    <div class="container">
        <div style="padding-top: 2%; padding-bottom: 3%;" v-if="!viewDemo">
            <h5 class="txt_inline">Selected Page</h5>
            <img class="txt_inline imageStyle" :src="selectedImage">
            <h5 class="txt_inline">Go Commerce</h5>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <div class="column_design"></div>
                <h5>Hotel Bot with Ecommerce</h5>
                <p>Add your rooms and add your restaurant products so that your customer can  enjoy a lot.</p>
                <button type="submit" class="btn btn_Setup">Setup</button>
                <button type="submit" @click="showDemo('hotel')" class="btn btn_Demo">View Demo</button>
            </div>
            <div class="col-sm-4">
                <div class="column_design"></div>
                <h5>Restaurant Bot with Ecommerce</h5>
                <p>Add your rooms and add your restaurant products so that your customer can  enjoy a lot.</p>
                <button type="submit" class="btn btn_Setup">Setup</button>
                <button type="submit" @click="showDemo('restaurant')" class="btn btn_Demo">View Demo</button>
            </div>
            <div class="col-sm-4">
                <div class="column_design"></div>
                <h5 class="txt_inline">Business Bot</h5>
                <p>Add your rooms and add your restaurant products so that your customer can  enjoy a lot.</p>
                <button type="submit" class="btn btn_Setup">Setup</button>
                <button type="submit" @click="showDemo('business')" class="btn btn_Demo">View Demo</button>
            </div>
        </div>
        <div v-if="viewDemo" id="modal" class="blurred-background">
            <div class="alert-box">
                <iframe v-if="video === 'hotel'" width="560" height="315" src="https://www.youtube.com/embed/zojhJqDhFxY" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                <iframe v-if="video === 'restaurant'" width="560" height="315" src="https://www.youtube.com/embed/8eP2Bmo8VMU" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                <iframe v-if="video === 'business'" width="560" height="315" src="https://www.youtube.com/embed/nWw5UO6qzwU" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                <br><button class="btn btn-primary btnModal" @click="hide">OK</button>
            </div>
        </div>
    </div>
</template>
<style lang="scss" scoped>
.imageStyle{
    margin-left: 3%;
    width: 50px;
    height: 50px;
}
.btnModal {
    width: 80px;
    color: black;
    font-weight: bold;
}
.blurred-background {
    position: fixed;
    box-sizing: border-box;
    width: 100%;
    height: 100%;
    z-index: 1;
    top: 0;
    left: 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    text-align: center;
    background: rgba(54, 54, 54, .7);
}
.alert-box {
    background: white;
    display: inline-block;
    margin-top: 180px;
    font-weight: lighter;
    border-radius: 3px;
    font-size: 30px;
    padding: 20px;
    transition: .2s;
}
.demo{
    width: 100%;
    height: 100%;
    background-color: grey;
}
.txt_inline{
    display: inline
}
.column_design{
    height: 500px;
    background-color: #d1d1d1;
    margin-bottom: 5%;
}
.column_design:hover{
    background-color: #c2c2c2;
}
p{
    margin-top: 5%;
    margin-bottom: 5%;
}
.btn_Setup{
    cursor: pointer;
    width: 100%;
    background-color: #00C2E0;
}
.btn_Setup:hover{
    background-color: #35e2fc;
    border-color: #00C2E0;
}
.btn_Demo{
    cursor: pointer;
    width: 100%;
    margin-top: 2%;
    margin-bottom: 5%;
    border-color: #00C2E0;
    background-color: white;
}
</style>
<script>
import image from 'src/assets/img/book.png'
export default {
  data(){
    return {
      selectedImage: image,
      viewDemo: false,
      video: null
    }
  },
  methods: {
    showDemo(parameter){
      console.log(parameter)
      if(parameter === 'business'){
        this.video = 'business'
      }else if(parameter === 'restaurant'){
        this.video = 'restaurant'
      }else if(parameter === 'hotel'){
        this.video = 'hotel'
      }
      this.viewDemo = true
    },
    hide(){
      this.viewDemo = false
    }
  }
}
</script>
