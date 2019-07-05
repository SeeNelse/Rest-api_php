<template>
  <div id="app">
    <b-navbar toggleable="lg" type="dark" variant="secondary">
      <b-container>
        <router-link to="/" class="navbar-brand">Car Show Room</router-link>

        <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

        <b-collapse id="nav-collapse" is-nav>
          <b-navbar-nav>
            <router-link class="nav-link" to='/order'>Buy a car</router-link>
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
              <template slot="button-content"><em><b>{{store.currentUser.username ? store.currentUser.username : 'Guest'}}</b></em></template>
              <div v-if='!tokenCheck()'> 
                <b-dropdown-item class="user__drop">
                  <b-button class="user__btn" v-b-modal.modal-1>Log In</b-button>
                </b-dropdown-item>
                <b-dropdown-item class="user__drop">
                  <b-button class="user__btn" v-b-modal.modal-2>Sign Up</b-button>
                </b-dropdown-item>
              </div>

              <div v-else>
                <b-dropdown-item class="user__drop">
                  <b-button class="user__btn user__btn_link"><router-link to='/profile'>Profile</router-link></b-button>
                </b-dropdown-item>
                <b-dropdown-item class="user__drop">
                  <b-button class="user__btn" v-on:click='logOut()'>Log Out</b-button>
                </b-dropdown-item>
              </div>
              

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

        <b-alert show variant="danger" v-if='loginError'>Error</b-alert>
        <b-alert show variant="success" v-if='loginSuccess'>Welcome!</b-alert>

        <b-button type="submit" variant="primary">Submit</b-button>
      </b-form>
    </b-modal>


    <!-- Sign Up -->
    <b-modal id="modal-2" title="Sign Up" hide-footer>
      <b-form @submit="signUpSubmit">
        <b-form-group id="input-group-1" label="Your Name*:" label-for="sign-up-name">
          <b-form-input
            id="sign-up-name"
            v-model="signIn.username"
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

        <b-alert show variant="danger" v-if='signInError'>Error</b-alert>
        <b-alert show variant="danger" v-if='signInErrorEmail'>Such email exists</b-alert>
        <b-alert show variant="success" v-if='signInSuccess'>You have created an account</b-alert>

        <b-button type="submit" variant="primary">Submit</b-button>
      </b-form>
    </b-modal>


    <b-modal id="modal-3" title="Log Out" hide-footer>
      <b-alert show variant="danger">Bye!</b-alert>
    </b-modal>

  </div>
</template>

<script>
import Store from '@/Store';

export default {
  name: 'app',
  data() {
    return {
      store: Store,
      search: {
        input: '',
      },
      logIn: {
        email: 'seenelse@gmail.com',
        password: 'asdfsadf',
        logInTime: new Date().getTime(),
      },
      signIn: {
        username: 'Vlad',
        email: 'seenelse@gmail.com',
        password: 'asdfsadf',
      },
      loginError: false,
      loginSuccess: false,
      signInError: false,
      signInErrorEmail: false,
      signInSuccess: false,
    }
  },
  methods: {
    searchSubmit(event) {
      event.preventDefault();
      if (this.search.input) {
        this.$router.push({ name: 'CarDetail', params: {id: this.search.input} })
        Store.fetchCarById(this.$route.params.id).then(data => {this.store.carId = data[0]}); 
      }
    },
    logInSubmit(event) {
      event.preventDefault();
      if (this.logIn.email && this.logIn.password.length >= 4 && this.signIn.password.length <= 30) {
        this.loginError = false;
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
            if (!response.Error) {
              this.loginError = false;
              this.loginSuccess = true;
              localStorage.setItem('currentUser', JSON.stringify(response));
              setTimeout(function() {
                this.$bvModal.hide('modal-1');
                this.loginSuccess = false;
                this.store.currentUser = response;
              }.bind(this), 2000);
            } else {
              this.loginError = true;
            }
          })
        })
        .catch(err => {
          console.error(err)
        })
      } else {
        this.loginError = true;
      }
    },
    signUpSubmit(event) {
      event.preventDefault();
      if (
        this.signIn.email && 
        this.signIn.password.length >= 4 && 
        this.signIn.password.length <= 30 &&
        this.signIn.username.length >= 4 &&
        this.signIn.username.length <= 15
      ) {
        this.signInError = false;
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
            if (!response.Error) {
              this.signInErrorEmail = false;
              this.signInError = false;
              this.signInSuccess = true;
              setTimeout(function() {
                this.$bvModal.hide('modal-2');
                this.$bvModal.show('modal-1');
                this.signInSuccess = false;
              }.bind(this), 2000);
            } else {
              this.signInErrorEmail = true;
            }
          })
        })
        .catch(err => {
          console.error(err)
        })
      } else {
        this.signInError = true;
      }
    },
    logOut() {
      this.$bvModal.show('modal-3');
      setTimeout(function() {
        this.$bvModal.hide('modal-3');
        localStorage.setItem('currentUser', JSON.stringify(''));
        this.store.currentUser = {};
        this.$router.push({ path: '/' });
      }.bind(this), 2000);
    },
    tokenCheck() {
      if (localStorage.getItem('currentUser') && this.store.currentUser.token) {
        return true;
      } else {
        return false;
      }
    }
  },
  created() {
    let storage = JSON.parse(localStorage.getItem('currentUser'));
    if (!storage.logInTime) {
      return false;
    }
    let currentMs = new Date().getTime();
    var msToMinCurrent = (currentMs / (1000 * 60)).toFixed(0);
    var msToMinStorage = (storage.logInTime / (1000 * 60)).toFixed(0)
    if (msToMinCurrent - +msToMinStorage <= 20) {
      this.store.currentUser = storage;
    } else {
      return false;
    }
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
  .user__btn_link {
    padding: 0 !important;
  }
  .user__btn_link a {
    padding: 0.25rem 1.5rem !important;
    display: block;
    color: #212529 !important;
  }
  .user__btn_link a:hover {
    text-decoration: none;
  }
</style>
