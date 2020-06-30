<template>
<div class="app">
  <div class="logo"><img src="./../assets/logo.png" style="width: 300px" alt=""></div>
  <div class="container">
    <LoginForm/>
    <RegisterForm/>
  </div>
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
  background: black;
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
    /* border: black solid 1px; */
  }

  .logo {
    /* border: black solid 1px; */
  }

  .container {
    
    /* border: black solid 1px; */
  }
</style>
