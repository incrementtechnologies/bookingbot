<template>
    
</template>

<script>
import CONFIG from 'src/config.js'
import AUTH from 'src/services/auth'
export default {
  data() {
    return{
      user: AUTH.user
    }
  }
}
</script>

<style>

</style>
