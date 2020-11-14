<template>
    <div class="container-fluid">
        <h1> Google Sheet Page </h1>
    </div>
</template>

<script>
import axios from 'axios'
export default {
  mounted(){
    this.APIRequest('google_sheet/googleTest', {}).then(res => {
      console.log('------------- ', res)
    })
  }
}
</script>

<style>

</style>
