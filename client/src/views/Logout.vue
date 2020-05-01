<template>
<div class="app">
  <img src="./../assets/logo.png" style="width: 300px" alt="">
  <LoginForm/>
  <RegisterForm/>
</div>
</template>

<script>
import LoginForm from './../components/logout/LoginForm'
import RegisterForm from './../components/logout/RegisterForm'
export default {
    name: 'Logout',
    components: {
      LoginForm, RegisterForm
    }
}
</script>

<style>
body {
  margin: 0;
  padding: 0;
  background: url("./../assets/tlo.jpg") no-repeat center top;
  background-size: cover;
  font-family: sans-serif;
  height: 100vh;
}
  .app {
    display: flex;
    flex-direction: column;
    width: 100%;
    max-width: 1200px;
    height: 100vh;
    margin: 0 auto;
    align-content: center;
    align-items: center;
  }
</style>
