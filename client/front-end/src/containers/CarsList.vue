<template>
  <b-row>
    <car v-for="(car, key) in store.cars" 
          :car="car" 
          :key="key" />
  </b-row>
</template>


<script>
import Store from '@/Store';
import Car from '@/components/Car';


export default {
  name: 'Index',
  components: {
    'car' : Car,
  },
  data() {
    return {
      store: Store,
      fromSearch: false,
    }
  },
  created() {
    if (!this.store.cars.length || this.$router.history.current.path === '/') {
      Store.fetchAllCars();
    }
  },
  watch: {
    '$route' (to) {
      if (to.path == '/') {
        Store.fetchAllCars();
      }
    }
  }
}
</script>


<style>

</style>