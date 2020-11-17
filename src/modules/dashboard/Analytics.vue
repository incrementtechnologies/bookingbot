<template>
    <div class="container-fluid border bg-light shadow-sm rounded-lg">
      <p class=" pt-4 m-0 p-0 font-weight-bold" >Data Analytics</p>
      <input type="month" class="form-control" v-model="searchDate" @change="getSummary()" >
     
      <topAffectedPlaces
        ref="realtimeChart"
        width="500"
        type="line"
        :options="options"
        :series="series"
      ></topAffectedPlaces>
 </div>
</template>
<script>
import ROUTER from 'src/router'
import axios from 'axios'
import Vue from 'vue'
import CONFIG from 'config'
import AUTH from 'src/services/auth'
import COMMON from 'src/common.js'
import topAffectedPlaces from 'vue-apexcharts'
export default {
  mounted() {
    this.getSummary()
  },
  data() {
    return {
      user: AUTH.user,
      options: {
        colors: ['#28a745', '#FF0000'],
        chart: {
          id: 'summary'
        },
        xaxis: {
          categories: ['Messages', 'Orders']
        },
        stroke: {
          width: 2,
          curve: 'smooth'
        }
      },
      series: [{
        name: 'Summary of Messages',
        data: [139]
      },
      {
        name: 'Summary of Orders',
        data: [539]
      },
      {
      }]
    }
  },
  getSummaryMessages() {
    if (this.user.userID === null) {
      return
    }
    let parameter = {
      account_id: this.user.userID,
      date: this.searchedDate
    }
    this.APIRequest('messages/summary_of_messages', parameter).then(response => {
      if (response.data !== null) {
        this.series = response.data.series
        this.options.xaxis.categories = response.data.categories
      } else {
        this.series = []
        this.options.xaxis.categories = []
      }
    })
  },
  getSummaryOrder(){
    if (this.user.userID === null) {
      return
    }
    let parameter = {
      account_id: this.user.userID,
      date: this.searchedDate
    }
    this.APIRequest('orders/summary_of_orders', parameter).then(response => {
      if (response.data !== null) {
        this.series = response.data.series
        this.options.xaxis.categories = response.data.categories
      } else {
        this.series = []
        this.options.xaxis.categories = []
      }
    })

  },
  components: {
    topAffectedPlaces
  }
}
</script>
