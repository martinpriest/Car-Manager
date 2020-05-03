<template>
  <div id="app">

<nav>
  <div v-show="this.loginStatus" id="main-nav" class="navbar navbar-expand-lg navbar-light bg-light text-light">

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
  </div>
</nav>


    <router-view />
  </div>
</template>

<script>

export default {
  name: 'App',
  components: {
    
  }, 
  data: function() {
    return {
      loginStatus: Boolean
    }
  },
  created() {

      var requestOptions = {
        method: 'GET',
        redirect: 'follow',
        credentials: 'include'
      };

    fetch("http://marcin.innome.pl:8000/user/status", requestOptions)
      .then(response => response.json())
      .then((data) => {
        let login = data.status;
        if (!login) {
          this.loginStatus = false;
          alert("Nie zalogowales sie");
          return false;
        } else {
          this.$router.push({ path: '/cars' }).catch(err => {console.log(err)})
          this.loginStatus = true;
          return true;
        }
      })
  },
  methods: {
    logout: function() {
      var requestOptions = {
        method: 'GET',
        redirect: 'follow',
        credentials: 'include'
      };

      fetch("http://marcin.innome.pl:8000/user/logout", requestOptions)
      .then(response => response.json())
      .then(() => {
        this.$router.push({ path: '/' }).catch(err => {console.log(err)})
        this.loginStatus = false;
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
