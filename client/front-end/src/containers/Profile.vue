<template>
  <b-col cols="12" class="cars__item">
    <b-card
      no-body
      v-if='ordersList'
      v-for='orderItem in ordersList'
      :key='orderItem.id'
      class="order__item"
    >
      <b-card-body>
        <b-card-title>{{orderItem.name+' '+orderItem.surname}}</b-card-title>
      </b-card-body>

      <b-list-group flush>
        <b-list-group-item>Car id: <router-link :to="{ name: 'CarDetail', params: { id: orderItem.car_id }}">{{orderItem.car_id}}</router-link></b-list-group-item>
        <b-list-group-item>Payment type: {{orderItem.payment == 'credit_card' ? 'Credit card' : 'Cash'}}</b-list-group-item>
      </b-list-group>

    </b-card>
    <b-card v-else>
      <b-card-body>
        <b-card-title>No orders</b-card-title>
      </b-card-body>
    </b-card>
  </b-col>
</template>


<script>
import Store from '@/Store';


export default {
  name: 'Profile',
  data() {
    return {
      store: Store,
      ordersList: [],
    }
  },
  created() {
    if(!this.store.currentUser.token) {
      this.$router.push({ path: '/no-access' });
    }
    fetch('http://localhost/Rest/server/api/order/orders/'+this.store.currentUser.email)
    .then(response => response.json())
    .then(data => {
      if (data.Error) {
        return false;
      }
      this.ordersList = data;
    })
    .catch(err => {
      console.error(err)
    })
  }
}
</script>


<style>
.order__item {
  margin-bottom: 20px;
}
</style>