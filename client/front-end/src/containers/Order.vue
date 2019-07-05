<template>
  <b-col cols="6" offset="3" class="cars__item">
    <b-form @submit="orderForm">
    
      <b-form-group id="input-group-1" label="Name*:" label-for="input-1">
        <b-form-input
          id="input-1"
          v-model="store.currentUser.username"
          placeholder="Enter name"
          type='text'
          required
        ></b-form-input>
      </b-form-group>

      <b-form-group id="input-group-1" label="Surname*:" label-for="input-1">
        <b-form-input
          id="input-1"
          v-model="store.currentUser.surname"
          placeholder="Enter surname"
          type='text'
          required
        ></b-form-input>
      </b-form-group>

      <b-form-group id="input-group-2" label="E-mail*:" label-for="input-2">
        <b-form-input
          id="input-2"
          v-model="store.currentUser.email"
          placeholder="Enter email"
          type='text'
          required
        ></b-form-input>
      </b-form-group>

      <b-form-group label="Payment method">
        <b-form-radio v-model="store.cart.paymentType" name="credit_card" value="credit_card">Credit card</b-form-radio>
        <b-form-radio v-model="store.cart.paymentType" name="cash" value="cash">Сash</b-form-radio>
      </b-form-group>

      <b-form-group id="input-group-6" label="Car id*:" label-for="input-6">
        <b-form-input
          id="input-6"
          v-model="store.cart.carId"
          placeholder="Enter price"
          type='number'
          required
        ></b-form-input>
      </b-form-group>
      

      <!-- <b-alert show variant="danger" v-if='notFoundId'>Not found car ID</b-alert>
      <b-alert show variant="success" v-if='orderSuccess'>Success!</b-alert> -->

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
    }
  },
  methods: {
    orderForm(event) {
      event.preventDefault()
      let orderData = {
        name: this.store.currentUser.username,
        surname: this.store.currentUser.surname,
        carId: this.store.cart.carId,
        paymentType: this.store.cart.paymentType,
        email: this.store.currentUser.email
      }
      // if (
      //   this.signIn.email && 
      //   this.signIn.password.length >= 4 && 
      //   this.signIn.password.length <= 30 &&
      //   this.signIn.username.length >= 4 &&
      //   this.signIn.username.length <= 15
      // ) {

      // }


      let url = new URL("http://localhost/Rest/server/api/order/setorder"),
        params = orderData;
        Object.keys(params).forEach(key => url.searchParams.append(key, params[key]))
        fetch(url, {
          method: 'POST',
          'Content-Type': 'application/json',
          'Accept': 'application/json'
        })
        .then((response) => {
          response.json().then((response) => {
            console.log(response);
          })
        })
        .catch(err => {
          console.error(err)
        })
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