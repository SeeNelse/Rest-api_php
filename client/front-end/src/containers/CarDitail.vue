<template>
  <b-col cols="12" class="cars__item">
    <b-card
      no-body
    >
      <b-card-body>
        <b-card-title>{{car.model}}</b-card-title>
        <b-card-sub-title class="mb-2">{{car.brand}}</b-card-sub-title>
      </b-card-body>

      <b-list-group flush>
        <b-list-group-item>Year: {{car.year_production}}</b-list-group-item>
        <b-list-group-item>Engine capacity: {{car.engine_capacity}}</b-list-group-item>
        <b-list-group-item>Max speed: {{car.max_speed}}</b-list-group-item>
        <b-list-group-item>Color: {{car.color}}</b-list-group-item>
      </b-list-group>

      <b-card-footer class="cars__price"><h5>Price: {{car.price}}</h5></b-card-footer>
    </b-card>
  </b-col>
</template>


<script>
import Store from '@/Store';


export default {
  name: 'CarDitail',
  data() {
    return {
      store: Store,
      car: [],
    }
  },
  created() {
    Store.fetchCarById(this.$route.params.id).then(data => {this.car = data[0]}); 
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