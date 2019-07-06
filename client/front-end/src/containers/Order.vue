<template>
  <b-col cols="6" offset="3" class="cars__item">
    <b-form @submit="orderForm">
    
      <b-form-group id="input-group-name" label="Name*:" label-for="input-name">
        <b-form-input
          id="input-name"
          v-model="store.cart.name"
          placeholder="Enter name"
          type='text'
          required
        ></b-form-input>
      </b-form-group>

      <b-form-group id="input-group-surname" label="Surname*:" label-for="input-surname">
        <b-form-input
          id="input-surname"
          v-model="store.cart.surname"
          placeholder="Enter surname"
          type='text'
          required
        ></b-form-input>
      </b-form-group>

      <b-form-group label="Payment method">
        <b-form-radio v-model="store.cart.paymentType" name="credit_card" value="credit_card">Credit card</b-form-radio>
        <b-form-radio v-model="store.cart.paymentType" name="cash" value="cash">Сash</b-form-radio>
      </b-form-group>

      <b-form-group id="input-group-carId" label="Car id*:" label-for="input-carId">
        <b-form-input
          id="input-carId"
          v-model="store.cart.carId"
          placeholder="Enter price"
          type='number'
          required
        ></b-form-input>
      </b-form-group>
      

      <b-alert show variant="danger" v-if='notFoundId'>Not found car ID</b-alert>
      <b-alert show variant="danger" v-if='errorMsg'>Error!</b-alert>
      <b-alert show variant="success" v-if='orderSuccess'>Success!</b-alert>

      <b-button type="submit" variant="primary">Search</b-button>
    </b-form>
  </b-col>
</template>


<script>
import Store from '@/Store';


export default {
  name: 'Order',
  data() {
    return {
      store: Store,
      notFoundId: false,
      orderSuccess: false,
      errorMsg: false,
    }
  },
  methods: {
    orderForm(event) {
      event.preventDefault()
      let orderData = {
        name: this.store.cart.name,
        surname: this.store.cart.surname,
        carId: this.store.cart.carId,
        paymentType: this.store.cart.paymentType,
        email: this.store.currentUser.email
      }
      if (
        orderData.name.length >= 4 && 
        orderData.surname.length >= 4 && 
        orderData.paymentType &&
        orderData.paymentType
      ) {
        let url = new URL("http://localhost/Rest/server/api/order/checkout"),
        params = orderData;
        Object.keys(params).forEach(key => url.searchParams.append(key, params[key]))
        fetch(url, {
          method: 'POST',
          'Content-Type': 'application/json',
          'Accept': 'application/json'
        })
        .then((response) => {
          response.json().then((response) => {
            if (!response.Error) {
              this.orderSuccess = true;
              this.store.cart = {};
              setTimeout(function() {
                this.orderSuccess = false;
              }.bind(this), 2000);
            } else {
              this.notFoundId = true;
            }
          })
        })
        .catch(err => {
          console.error(err)
        });
      } else {
        this.errorMsg = true;
      }
    }
  },
  created() {
    if(!this.store.currentUser.token) {
      this.$router.push({ path: '/no-access' });
    }
  }
}
</script>