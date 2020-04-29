<template>
  <div class="app">

<nav class="navbar navbar-expand-lg navbar-light bg-dark text-light">
  <a class="navbar-brand" href="#">Car Manager</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <router-link to="/dashboard"><a class="nav-item nav-link active" href="#">Dashboard<span class="sr-only">(current)</span></a></router-link>
      <router-link to="/raports"><a class="nav-item nav-link" href="#">Features</a></router-link>
      <router-link to="/setting"><a class="nav-item nav-link" href="#">Pricing</a></router-link>
      <router-link to="/"><a class="nav-item nav-link disabled" href="#">Logout</a></router-link>
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
    
  }
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}

.nav {
  padding: 20px;
  margin: 10px;
  width: 100%;
  display: flex;
  flex-direction: row;
  align-items: center;
}

.nav > button {
  margin: 10px;
  padding: 10px;
}
</style>
