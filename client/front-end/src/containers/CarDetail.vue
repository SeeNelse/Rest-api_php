<template>
  <b-col cols="12" class="cars__item">
    <b-card
      no-body
      v-if='car'
    >
      <b-card-body>
        <b-card-title>{{store.carId.model}}</b-card-title>
        <b-card-sub-title class="mb-2">{{store.carId.brand}}</b-card-sub-title>
      </b-card-body>

      <b-list-group flush>
        <b-list-group-item>Year: {{store.carId.year_production}}</b-list-group-item>
        <b-list-group-item>Engine capacity: {{store.carId.engine_capacity}}</b-list-group-item>
        <b-list-group-item>Max speed: {{store.carId.max_speed}}</b-list-group-item>
        <b-list-group-item>Color: {{store.carId.color}}</b-list-group-item>
      </b-list-group>

      <b-card-footer class="cars__price"><h5>Price: {{store.carId.price}}</h5></b-card-footer>
    </b-card>
    <b-card v-else>
      <b-card-body>
        <b-card-title>Not found</b-card-title>
      </b-card-body>
    </b-card>
  </b-col>
</template>


<script>
import Store from '@/Store';

export default {
  name: 'CarDetail',
  data() {
    return {
      store: Store,
      car: [],
    }
  },
  created() {
    Store.fetchCarById(this.$route.params.id).then(data => {this.store.carId = data[0]});
  },
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