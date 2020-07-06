<template>
  <div>
    <h3>User setting</h3>

  <b-form>
        <!-- Login -->
        <b-row class="pt-2">
          <b-col cols="4">Login:</b-col>
          <b-col cols="8">
            <b-form-input v-model="login" type="text"></b-form-input>
          </b-col>
        </b-row>
        <!-- New password -->
        <b-row class="pt-2">
          <b-col cols="4">New password:</b-col>
          <b-col cols="8">
            <b-form-input v-model="newPassword" type="password"></b-form-input>
          </b-col>
        </b-row>
        <!-- Repeat new password -->
        <b-row class="pt-2">
          <b-col cols="4">Repeat new password:</b-col>
          <b-col cols="8">
            <b-form-input v-model="newPassword2" type="password"></b-form-input>
          </b-col>
        </b-row>
        <!-- New email -->
        <b-row class="pt-2">
          <b-col cols="4">Email:</b-col>
          <b-col cols="8">
            <b-form-input v-model="newEmail" type="email"></b-form-input>
          </b-col>
        </b-row>
        <b-row class="pt-2">
          <b-col cols="12">
            <b-button
              variant="success"
              @click="update"
            >Change</b-button>
          </b-col>
        </b-row>
      </b-form>



  </div>
</template>

<script>
export default {
    name: 'UserSetting',
    methods: {
      update: function() {

        var json = {
          password: this.password,
          newLogin: this.login,
          newMail: this.newEmail,
          newPassword: this.newPassword,
          newPassword2: this.newPassword2
        };

        var requestOptions = {
          method: 'PUT',
          body: JSON.stringify(json),
          redirect: 'follow',
          credentials: 'include'
        };

        fetch(`${process.env.VUE_APP_API_URL}/user/edit`, requestOptions)
        .then(response => response.json())
        .then((result) => {
          alert(result.message);
        })
        .catch(error => console.log('error', error));
      }
    },
    data() {
      return {
        login: '',
        password: '',
        newPassword: '',
        newPassword2: '',
        newEmail: ''
      }
    },
    created() {

    }
}
</script>

<style>
</style>
