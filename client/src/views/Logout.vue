<template>
<div class="car-profile-box">
  <div class="logo"><img src="./../assets/logo.png" style="width: 300px" alt=""></div>
    <b-tabs content-class="p-4 mt-3 w-100" justified>
    <b-tab title="Login" active>
      <b-form @submit="login" @reset="onResetLoginForm" v-if="show">
      <b-form-group id="input-group-1">
        <b-form-input
          id="login-username"
          v-model="loginForm.login"
          required
          placeholder="Login"
        ></b-form-input>
      </b-form-group>
 
      <b-form-group id="input-group-2">
        <b-form-input
          id="login-password"
          v-model="loginForm.password"
          required
          placeholder="Password"
          type="password"
        ></b-form-input>
      </b-form-group>

      <b-button type="submit" variant="primary">Submit</b-button>
      <b-button type="reset" variant="danger">Reset</b-button>
    </b-form>
    </b-tab>
    <!-- REGISTER FORM -->
    <b-tab title="Register">
<b-form @submit="register" @reset="onResetRegisterForm" v-if="show">
      <b-form-group id="input-group-3">
        <b-form-input
          id="register-login"
          v-model="registerForm.login"
          required
          placeholder="Login"
        ></b-form-input>
      </b-form-group>

      <b-form-group id="input-group-4">
        <b-form-input
          id="register-mail"
          v-model="registerForm.mail"
          required
          placeholder="Mail"
        ></b-form-input>
      </b-form-group>

      <b-form-group id="input-group-5">
        <b-form-input
          id="register-password"
          v-model="registerForm.password"
          required
          placeholder="Password"
          type="password"
        ></b-form-input>
      </b-form-group>

      <b-form-group id="input-group-6">
        <b-form-input
          id="register-password2"
          v-model="registerForm.password2"
          required
          placeholder="Password"
          type="password"
        ></b-form-input>
      </b-form-group>

      <b-button type="submit" variant="primary">Submit</b-button>
      <b-button type="reset" variant="danger">Reset</b-button>
    </b-form>


    </b-tab>
  </b-tabs>
</div>
</template>

<script>
export default {
    name: 'Logout',
    data() {
      return {
        loginForm: {
          login: '',
          password: ''
        },
        registerForm: {
          login: '',
          mail: '',
          password: '',
          password2: ''
        },
        show: true
      }
    },
    methods: {
      onResetLoginForm(evt) {
        evt.preventDefault()
        // Reset our form values
        this.loginForm.login = ''
        this.loginForm.password = ''
        this.show = false
        this.$nextTick(() => {
          this.show = true
        })
      },
      onResetRegisterForm(evt) {
        evt.preventDefault()
        // Reset our form values
        this.registerForm.login = ''
        this.registerForm.mail = ''
        this.registerForm.password = ''
        this.registerForm.password2 = ''
        this.show = false
        this.$nextTick(() => {
          this.show = true
        })
      },
      login: function() {
        let username = document.querySelector("#login-username");
        let password = document.querySelector("#login-password");

        var json = {
          login: username.value,
          password: password.value
        };

        var requestOptions = {
          method: 'POST',
          body: JSON.stringify(json),
          redirect: 'follow',
          credentials: 'include'
        };

        fetch(`${process.env.VUE_APP_API_URL}/user/login`, requestOptions)
        .then(response => response.json())
        .then((data) => {
          if(data.message == "Logged in") this.$router.push({ path: '/cars' }).catch(err => {console.log(err)})
          else alert("Nieprawidłowe dane");

          location.reload();
        })
        .catch(error => console.log('error', error));
      },
      register: function() {
        let username = document.querySelector("#register-login");
        let email = document.querySelector("#register-mail");
        let password = document.querySelector("#register-password");
        let password2 = document.querySelector("#register-password2");
        if(password.value != password2.value) {
          alert("Zle powtorzyles haslo");
          return 0;
        }
        var json = {
          login: username.value,
          email: email.value,
          password: password.value
        };
        var requestOptions = {
          method: 'POST',
          body: JSON.stringify(json),
          redirect: 'follow',
          credentials: 'include'
        };
        fetch(`${process.env.VUE_APP_API_URL}/user/create`, requestOptions)
        .then(response => response.json())
        .then((result) => {
          alert(result.message);
        })
        .catch(error => console.log('error', error));
      }
    }
}
</script>

<style>
body {
  margin: 0;
  padding: 0;
  background: black;
  background-size: cover;
  font-family: sans-serif;
  height: 100vh;
}

  .logo {
    /* border: black solid 1px; */
  }

  .container {

    /* border: black solid 1px; */
  }
</style>
