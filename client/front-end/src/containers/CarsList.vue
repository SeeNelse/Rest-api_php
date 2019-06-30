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
    }
  },
  created() {
    if (!this.store.cars.length) {
      Store.fetchAllCars();
    }
  },
  props: {
    
  },
  methods: {
  }
}
</script>


<style>

</style>