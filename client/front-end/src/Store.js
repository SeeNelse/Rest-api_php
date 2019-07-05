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
      },
      cart: {
        name: '',
        carId: '',
        surname: '',
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
        })
        .catch(err => {
          console.error(err)
        })
    },
    fetchCarById(id) {
      return fetch('http://localhost/Rest/server/api/carshop/cars/'+id)
        .then(response => response.json())
        .then(data => {
          if (data.Error) {
            return false;
          }
          return data;
        })
        .catch(err => {
          console.error(err)
        })
    }
  }
})