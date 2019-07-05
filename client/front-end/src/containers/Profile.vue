<template>
  <div>123123123</div>
</template>


<script>
import Store from '@/Store';


export default {
  name: 'Profile',
  data() {
    return {
      store: Store,
    }
  },
  created() {
    if(!this.store.currentUser.token) {
      this.$router.push({ path: '/no-access' });
    }
  }
}
</script>


<style>

</style>