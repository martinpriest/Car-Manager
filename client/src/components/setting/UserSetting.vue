<template>
<div class="userchange-box">
      <img src="./../../assets/logocar.jpg" class="avatar" alt="Car logo">
      <h1>Change User Settings</h1>
      <form>
        <label for="password">Password</label>
        <input id="password" type="password" placeholder="Enter Old Password">
        <label for="change-username">New Login</label>
        <input id="change-username" type="text" placeholder="Enter New Login">
        <label for="change-email">Change E-mail</label>
        <input id="change-email" type="text" placeholder="Enter New E-mail">
        <label for="change-password">New Password</label>
        <input id="change-password" type="password" placeholder="Create New Password">
        <label for="change-password2">New Password</label>
        <input id="change-password2" type="password" placeholder="Repeat New Password">
        <input type="submit" value="Update" v-on:click="update()">
        </form>
    </div>
</template>

<script>
export default {
    name: 'UserSetting',
    methods: {
      update: function() {
        let password = document.querySelector("#password");
        let newLogin = document.querySelector("#change-username");
        let newMail = document.querySelector("#change-email");
        let newPassword = document.querySelector("#change-password");
        //let password2 = document.querySelector("#change-password2");

        var json = {
          password: password.value,
          newLogin: newLogin.value,
          newMail: newMail.value,
          newPassword: newPassword.value
        };

        var requestOptions = {
          method: 'PUT',
          body: JSON.stringify(json),
          redirect: 'follow',
          credentials: 'include'
        };

        fetch("http://marcin.innome.pl:8000/user/edit", requestOptions)
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
.userchange-box {
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

.userchange-box .avatar {
  width: 100px;
  height: 100px;
  border-radius: 50%;
  position: absolute;
  top: -50px;
  left: calc(50% - 50px);
}

.userchange-box h1 {
  margin: 0;
  padding: 0 0 20px;
  text-align: center;
  font-size: 22px;
}

.userchange-box label {
  margin: 0;
  padding: 0;
  font-weight: bold;
  display: block;
}

.userchange-box input {
  width: 100%;
  margin-bottom: 20px;
}

.userchange-box input[type="text"], .userchange-box input[type="password"] {
  border: none;
  border-bottom: 1px solid #fff;
  background: transparent;
  outline: none;
  height: 40px;
  color: #fff;
  font-size: 16px;
}

.userchange-box input[type="submit"] {
  border: none;
  outline: none;
  height: 40px;
  background: #b80f22;
  color: #fff;
  font-size: 18px;
  border-radius: 20px;
}

.userchange-box input[type="submit"]:hover {
  cursor: pointer;
  background: #ffc107;
}
</style>
