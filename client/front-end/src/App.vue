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
              <template slot="button-content"><em><b>Guest</b></em></template>
              <b-dropdown-item class="user__drop">
                <b-button class="user__btn" v-b-modal.modal-1>Log In</b-button>
              </b-dropdown-item>
              <b-dropdown-item class="user__drop">
                <b-button class="user__btn" v-b-modal.modal-2>Sign Up</b-button>
              </b-dropdown-item>



            </b-nav-item-dropdown>
          </b-navbar-nav>
        </b-collapse>
      </b-container>
    </b-navbar>
    <b-container class="bv-example-row">
      <router-view/>
    </b-container>

    <!-- modal -->
    <!-- Log In -->
      <b-modal id="modal-1" title="Log In" hide-footer>
        <b-form @submit="logInSubmit">
          <b-form-group id="input-group-1" label="Your Email:" label-for="log-in-email">
            <b-form-input
              id="log-in-email"
              v-model="logIn.email"
              required
              placeholder="Enter email"
              type="email"
            ></b-form-input>
          </b-form-group>

          <b-form-group id="input-group-2" label="Your Password:" label-for="log-in-pass">
            <b-form-input
              id="log-in-pass"
              v-model="logIn.password"
              required
              placeholder="Enter password"
              type="password"
            ></b-form-input>

          </b-form-group>
          <b-button type="submit" variant="primary">Submit</b-button>
        </b-form>
      </b-modal>


      <!-- Sign Up -->
      <b-modal id="modal-2" title="Sign Up" hide-footer>
        <b-form @submit="signUpSubmit">
          <b-form-group id="input-group-1" label="Your Name*:" label-for="sign-up-name">
            <b-form-input
              id="sign-up-name"
              v-model="signIn.name"
              required
              placeholder="Enter Name"
              type="text"
            ></b-form-input>
          </b-form-group>

          <b-form-group id="input-group-2" label="Your Email*:" label-for="sign-up-email">
            <b-form-input
              id="sign-up-email"
              v-model="signIn.email"
              required
              placeholder="Enter email"
              type="email"
            ></b-form-input>
          </b-form-group>

          <b-form-group id="input-group-3" label="Your Password*:" label-for="sign-up-pass">
            <b-form-input
              id="sign-up-pass"
              v-model="signIn.password"
              required
              placeholder="Enter password"
              type="password"
            ></b-form-input>
          </b-form-group>
          <b-button type="submit" variant="primary">Submit</b-button>
        </b-form>
      </b-modal>


  </div>
</template>

<script>
export default {
  name: 'app',
  data() {
    return {
      search: {
        input: '',
      },
      logIn: {
        email: 'seenelse@gmail.com',
        password: 'fdfdfsd',
      },
      signIn: {
        username: 'Vlad',
        email: 'seenelse@gmail.com',
        password: 'asdfsadf',
      }
    }
  },
  methods: {
    searchSubmit(event) {
      event.preventDefault()
      if (this.search.input) {
        this.$router.push({ path: `/car/${this.search.input}` })
      }
      
    },
    logInSubmit(event) {
      event.preventDefault();

      let url = new URL("http://localhost/Rest/server/api/user/login"),
      params = this.logIn;
      Object.keys(params).forEach(key => url.searchParams.append(key, params[key]))
      fetch(url, {
        method: 'PUT',
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

    },
    signUpSubmit(event) {
      event.preventDefault();

      let url = new URL("http://localhost/Rest/server/api/user/signup"),
      params = this.signIn;
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

    },
  }
}
</script>

<style>
.navbar {
  margin-bottom: 40px;
}
.user__drop a {
  padding: 0 !important;
}
.user__btn {
  display: block !important;
  width: 100% !important;
  padding: 0.25rem 1.5rem !important;
  clear: both !important;
  font-weight: 400 !important;
  color: #212529 !important;
  text-align: inherit !important;
  white-space: nowrap !important;
  background-color: transparent !important;
  border: 0 !important;
}
.user__btn:focus {
  box-shadow: none !important;
}
</style>
