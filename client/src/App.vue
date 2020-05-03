<template>
  <div id="app">

<nav v-show="this.loginStatus" id="main-nav" class="navbar navbar-expand-lg navbar-light bg-light text-light">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav text-light">
      <router-link to="/dashboard"><a class="nav-item nav-link active" href="#dashboard">Dashboard<span class="sr-only">(current)</span></a></router-link>
      <router-link to="/cars"><a class="nav-item nav-link" href="#cars">Cars</a></router-link>
      <router-link to="/reports"><a class="nav-item nav-link" href="#reports">Reports</a></router-link>
      <router-link to="/setting"><a class="nav-item nav-link disabled" href="#setting">Setting</a></router-link>
      <router-link to="/"><a class="nav-item nav-link" href="#" v-on:click="logout()">Logout</a></router-link>
    </div>
  </div>
</nav>


    <router-view />
  </div>
</template>

<script>
// import LoginForm from './components/LoginForm.vue'

export default {
  name: 'App',
  components: {
    
  }, 
  data: function() {
    return {
      loginStatus: this.getStatus()
    }
  },
  methods: {
    getStatus: function() {

      var requestOptions = {
        method: 'GET',
        redirect: 'follow',
        credentials: 'include'
      };

      fetch("http://marcin.innome.pl:8000/user/status", requestOptions)
      .then(response => response.json())
      .then((data) => {
        let login = data.status;
        let nav = document.querySelector("#main-nav");
        if (!login) {
          console.log("Nie zalogowany!!!");
          // nav.style.display = "none";
          this.$router.push({ path: '/' }).catch(err => {console.log(err)})
          // this.$router.next({ replace: true, name: 'Logout' }).catch(err => {console.log(err)})
          this.loginStatus = false;
          return false;
        } else {
          console.log("Zalogowany!!!");
          this.$router.push({ path: '/cars' }).catch(err => {console.log(err)})
          // this.$router.next({ replace: true, name: 'Dashboard' }).catch(err => {console.log(err)})
          nav.style.display = "flex";
          this.loginStatus = true;
          return true;
        }
      })
      .catch(error => console.log('error', error));
    },
    logout: function() {
      var requestOptions = {
        method: 'GET',
        redirect: 'follow',
        credentials: 'include'
      };

      fetch("http://marcin.innome.pl:8000/user/logout", requestOptions)
      .then(response => response.json())
      .then((data) => {

        console.log(data)
        this.loginStatus = false;
        this.$router.push({ path: '/' }).catch(err => {console.log(err)})
        this.loginStatus = false;

        // let nav = document.querySelector("#main-nav");
        // nav.style.display = "none";
      })
      .catch(error => console.log('error', error));
    }
  }
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  background: rgb(80, 77, 77);
  width: 100%;
  height: 100%;
  padding: 0px;
  margin: 0px;
}

.nav {
  width: 100%;
  display: flex;
  flex-direction: row;
  align-items: center;
  color: azure;
}

.nav > button {
  margin: 10px;
  padding: 10px;
}
</style>
