import Vue from 'vue';

export default new Vue({
  data() {
    return {
      cars: [],
      carId: {},
      currentUser: {
        username: '',
        email: '',
        token: '',
        logInTime: null,
        surname: '',
      },
      cart: {
        carId: '',
        paymentType: '',
      }
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
          console.log(data)
          if (data.Error) {
            return false;
          }
          return data;
        });
    }
  }
})