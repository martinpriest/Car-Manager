<template>
<div class="app">
  <img src="./../assets/transportation.svg" style="width: 100px" alt="">
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