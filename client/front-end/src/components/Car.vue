<template>
  <b-col cols="4" class="cars__item">
    <b-card
      no-body
    >
      <b-card-body>
        <b-card-title>{{car.model}}</b-card-title>
        <b-card-sub-title class="mb-2">{{car.brand}}</b-card-sub-title>
          <router-link :to="{ name: 'CarDetail', params: { id: car.id }}" class="card-link">Read mode</router-link>
      </b-card-body>

      <b-card-footer class="cars__price"><h5>Price: {{car.price}}</h5></b-card-footer>
    </b-card>
  </b-col>
</template>


<script>
import Store from '@/Store';


export default {
  name: 'Car',
  data() {
    return {
      store: Store,
    }
  },
  props: ['car'],
}
</script>


<style>
.cars__item {
  margin-bottom: 25px;
}
.cars__price {
  margin-bottom: 0;
}
</style>