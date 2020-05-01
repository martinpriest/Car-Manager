<template>
<div class="register-box">
      <img src="./../../assets/logocar.jpg" class="avatar" alt="Car logo">
      <h1>Register Here</h1>
        <label for="register-username">Username</label>
        <input id="register-username" type="text" placeholder="Enter Username">
        <label for="register-email">E-mail</label>
        <input id="register-email" type="text" placeholder="Enter E-mail">
        <label for="register-password">Password</label>
        <input id="register-password" type="password" placeholder="Create Password">
        <label for="register-password2">Repeat password</label>
        <input id="register-password2" type="password" placeholder="Repeat Password">
        <input type="submit" value="Create an account" v-on:click="register()">
    </div>
</template>

<script>
export default {
    name: 'RegisterForm',
    methods: {
      register: function() {
        let username = document.querySelector("#register-username");
        let email = document.querySelector("#register-email");
        let password = document.querySelector("#register-password");
        // let password2 = document.querySelector("#register-password2");

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

        fetch("http://marcin.innome.pl:8000/user/create", requestOptions)
        .then(response => response.json())
        .then((result) => {
          alert(result.message);
        })
        .catch(error => console.log('error', error));
      }
    },
    data: function() {
        return {
            counter: 0
        }
    }
}
</script>

<style>
.register-box {
  width: 320px;
  height: auto;
  background: #000;
  color: #fff;
  top: 50%;
  left: 75%;
  position: absolute;
  transform: translate(-50%, -50%);
  box-sizing: border-box;
  padding: 70px 30px;
}

.register-box .avatar {
  width: 100px;
  height: 100px;
  border-radius: 50%;
  position: absolute;
  top: -50px;
  left: calc(50% - 50px);
}

.register-box h1 {
  margin: 0;
  padding: 0 0 20px;
  text-align: center;
  font-size: 22px;
}

.register-box label {
  margin: 0;
  padding: 0;
  font-weight: bold;
  display: block;
}

.register-box input {
  width: 100%;
  margin-bottom: 20px;
}

.register-box input[type="text"], .register-box input[type="password"] {
  border: none;
  border-bottom: 1px solid #fff;
  background: transparent;
  outline: none;
  height: 40px;
  color: #fff;
  font-size: 16px;
}

.register-box input[type="submit"] {
  border: none;
  outline: none;
  height: 40px;
  background: #b80f22;
  color: #fff;
  font-size: 18px;
  border-radius: 20px;
}

.register-box input[type="submit"]:hover {
  cursor: pointer;
  background: #ffc107;
  color: #000;
}
</style>
