<template>
<div class="login-box">
      <img src="./../../assets/user-icon/user-login.svg" class="avatar" alt="Car logo">
      <h1>Login Here</h1>
        <label for="username">Username</label>
        <input id="username" type="text" placeholder="Enter Username">
        <label  for="password">Password</label>
        <input id="password" type="password" placeholder="Enter Password">
        <input type="submit" value="Log In" v-on:click="checkLogin()">
    </div>
</template>

<script>
export default {
    name: 'LoginForm',
    methods: {
      checkLogin: function() {
        let username = document.querySelector("#username");
        let password = document.querySelector("#password");

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

        fetch("http://marcin.innome.pl:8000/user/login", requestOptions)
        .then(response => response.json())
        .then((data) => {
          if(data.message == "Logged in") this.$router.push({ path: '/cars' }).catch(err => {console.log(err)})
          else alert("Nieprawidłowe dane");
        })
        .catch(error => console.log('error', error));
      }
    },
    data: function() {
        return {
            jakasZmienna : "Siema",
            login: Boolean
        }
    }

}
</script>

<style>
.login-box {
  width: 320px;
  height: 420px;
  background: #000;
  color: #fff;
  top: 50%;
  left: 25%;
  position: absolute;
  transform: translate(-50%, -50%);
  box-sizing: border-box;
  padding: 70px 30px;
}

.login-box .avatar {
  width: 100px;
  height: 100px;
  border-radius: 50%;
  position: absolute;
  top: -50px;
  left: calc(50% - 50px);
  color: white;
  background-color: white;
}

.login-box h1 {
  margin: 0;
  padding: 0 0 20px;
  text-align: center;
  font-size: 22px;
}

.login-box label {
  margin: 0;
  padding: 0;
  font-weight: bold;
  display: block;
}

.login-box input {
  width: 100%;
  margin-bottom: 20px;
}

.login-box input[type="text"], .login-box input[type="password"] {
  border: none;
  border-bottom: 1px solid #fff;
  background: transparent;
  outline: none;
  height: 40px;
  color: #fff;
  font-size: 16px;
}

.login-box input[type="submit"] {
  border: none;
  outline: none;
  height: 40px;
  background: #b80f22;
  color: #fff;
  font-size: 18px;
  border-radius: 20px;
}

.login-box input[type="submit"]:hover {
  cursor: pointer;
  background: #ffc107;
}
</style>
