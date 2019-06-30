import Vue from 'vue';

export default new Vue({
  data() {
    return {
      cars: [],
    }
  },
  methods: {
    fetchAllCars() {
      fetch('http://localhost/Rest/server/api/carshop/cars/')
        .then(response => response.json())
        .then(data => {
          this.cars = data;
        });
    },
    fetchCarById(id) {
      return fetch('http://localhost/Rest/server/api/carshop/cars/'+id)
        .then(response => response.json())
        .then(data => {
          return data;
        });
    }
  }
})