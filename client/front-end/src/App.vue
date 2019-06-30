<template>
  <div id="app">
    <b-navbar toggleable="lg" type="dark" variant="secondary">
      <b-container>
        <router-link to="/" class="navbar-brand">Car Show Room</router-link>

        <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

        <b-collapse id="nav-collapse" is-nav>
          <b-navbar-nav>
            <b-nav-item href="#">Link</b-nav-item>
            <b-nav-item href="#" disabled>Disabled</b-nav-item>
          </b-navbar-nav>

          <!-- Right aligned nav items -->
          <b-navbar-nav class="ml-auto">
            <b-nav-form @submit="searchSubmit">
              <b-form-input size="sm" class="mr-sm-2" placeholder="Search" type="number" v-model="search.input"></b-form-input>
              <b-button size="sm" variant="dark" class="my-2 my-sm-0" type="submit">Search</b-button>
            </b-nav-form>

            <router-link to='/advanced-search' class="nav-link">Advanced search</router-link>

            <b-nav-item-dropdown right>
              <!-- Using 'button-content' slot -->
              <template slot="button-content"><em>User</em></template>
              <b-dropdown-item href="#">Profile</b-dropdown-item>
              <b-dropdown-item href="#">Sign Out</b-dropdown-item>
            </b-nav-item-dropdown>
          </b-navbar-nav>
        </b-collapse>
      </b-container>
    </b-navbar>
    <b-container class="bv-example-row">
      <router-view/>
    </b-container>
  </div>
</template>

<script>
export default {
  name: 'app',
  data() {
    return {
      search: {
        input: ''
      }
    }
  },
  methods: {
    searchSubmit(evt) {
      evt.preventDefault()
      // alert(JSON.stringify(this.search.input))
      this.$router.push({ path: `/car/${this.search.input}` })
    },
  }
}
</script>

<style>
#app {
  /* font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50; */
}
.navbar {
  margin-bottom: 40px;
}
</style>
