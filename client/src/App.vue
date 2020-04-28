<template>
  <div class="app">
    <div class="nav">
      <router-link to="/">Logout</router-link>
      <router-link to="/dashboard">Dashboard</router-link>
      <router-link to="/cars">Car</router-link>
      <router-link to="/raports">Raports</router-link>
      <router-link to="/setting">Setting</router-link>
    </div>
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
</style>
