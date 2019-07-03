<template>
  <b-col cols="6" offset="3" class="cars__item">
    <b-form @submit="advancedSearchSubmit" :state="validation">
    
      <b-form-group id="input-group-1" label="Model:" label-for="input-1">
        <b-form-input
          id="input-1"
          v-model="form.model"
          placeholder="Enter model"
          type='text'
        ></b-form-input>
      </b-form-group>

      <b-form-group id="input-group-2" label="Year*:" label-for="input-2">
        <b-form-input
          :state="validation"
          id="input-2"
          v-model="form.year"
          required
          placeholder="Enter year"
          type='number'
        ></b-form-input>
      </b-form-group>

      <b-form-group id="input-group-3" label="Engine capacity:" label-for="input-3">
        <b-form-input
          id="input-3"
          v-model="form.engine"
          placeholder="Enter capacity"
          type='number'
        ></b-form-input>
      </b-form-group>

      <b-form-group id="input-group-4" label="Color:" label-for="input-4">
        <b-form-input
          id="input-4"
          v-model="form.color"
          placeholder="Enter color"
          type='text'
        ></b-form-input>
      </b-form-group>

      <b-form-group id="input-group-5" label="Max speed:" label-for="input-5">
        <b-form-input
          id="input-5"
          v-model="form.speed"
          placeholder="Enter max speed"
          type='number'
        ></b-form-input>
      </b-form-group>

      <b-form-group id="input-group-6" label="Price:" label-for="input-6">
        <b-form-input
          id="input-6"
          v-model="form.price"
          placeholder="Enter price"
          type='number'
        ></b-form-input>
      </b-form-group>
      

       <b-alert show variant="danger" v-if='notFound'>Not found</b-alert>


      <b-button type="submit" variant="primary">Search</b-button>
    </b-form>
  </b-col>
</template>


<script>
import Store from '@/Store';


export default {
  name: 'AdvancedSearch',
  data() {
    return {
      store: Store,
      notFound: false,
      form: {
        year: ''
      },
    }
  },
  methods: {
    advancedSearchSubmit(evt) {
      evt.preventDefault()
      if (!this.form.year || this.form.year.length != 4) {
        return false;
      }
      let url = new URL("http://localhost/Rest/server/api/carshop/cars"),
      params = this.form;
      Object.keys(params).forEach(key => url.searchParams.append(key, params[key]))
      fetch(url)
        .then(response => response.json())
        .then(json => {
          if (json.length) {
            this.store.cars = json;
            this.$router.push({ path: '/advanced-search-result' });
          } else {
            this.notFound = true;
          }
        });
    },
  },
  computed: {
    validation() {
      return this.form.year.length === 4
    }
  }
}
</script>


<style>

</style>