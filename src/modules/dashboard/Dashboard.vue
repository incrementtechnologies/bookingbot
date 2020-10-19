<template>
    <div class="container-fluid border bg-light shadow-sm pt-0 m-0 rounded-lg mt-3 ml-5">
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
import topAffectedPlaces from 'vue-apexcharts'
export default {
  mounted() {
    this.getSummary()
  },
  data() {
    return {
      options: {
        colors: ['#28a745', '#FF0000'],
        chart: {
          id: 'sales-summary'
        },
        xaxis: {
          categories: []
        },
        stroke: {
          width: 2,
          curve: 'smooth'
        }
      },
      series: []
    }
  },
  getSummary() {
    if (this.user.SubAccount.merhant === null) {
      return
    }
    let parameter = {
      merhant_id: this.user.SubAccount.merhant.id,
      date: this.searchedDate
    }
    this.APIRequest('checkout/summary_of_orders', parameter).then(response => {
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
<style scoped>
div{
  width:600px;

}
</style>
  