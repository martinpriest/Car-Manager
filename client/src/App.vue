<template>
  <div id="app">

<div>
  <b-navbar v-if="this.loginStatus" toggleable="lg" type="dark" variant="dark">
    <b-navbar-brand href="#">CarManager</b-navbar-brand>

    <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

    <b-collapse id="nav-collapse" is-nav>
      <b-navbar-nav>
        <router-link to="/dashboard"><b-nav-item href="#dashboard">Dashboard</b-nav-item></router-link>
        <router-link to="/cars"><b-nav-item href="#cars">
              <img class="menu-icon" src="./assets/menu-icon/car-view.svg" alt="">Cars</b-nav-item></router-link>
        <!-- <router-link to="/reports"><b-nav-item href="#" disabled>Reports</b-nav-item></router-link>
        <router-link to="/shared-car"><b-nav-item href="#" disabled>Shared cars</b-nav-item></router-link> -->

      </b-navbar-nav>

      <!-- Right aligned nav items -->
      <b-navbar-nav class="ml-auto">

        <b-nav-item-dropdown right>
          <!-- Using 'button-content' slot -->
          <template v-slot:button-content>
            <em>User</em>
          </template>
          <router-link to="/setting"><b-dropdown-item href="#setting">Profile</b-dropdown-item></router-link>
          <router-link to="/"><b-dropdown-item href="#logout" v-on:click="logout()">Logout</b-dropdown-item></router-link>
        </b-nav-item-dropdown>
      </b-navbar-nav>
    </b-collapse>
  </b-navbar>
</div>

    <div class="view">
      <router-view />
    </div>
  </div>
</template>

<script>
export default {
  name: "App",
  components: {},
  data: function() {
    return {
      loginStatus: false
    };
  },
  created() {
    var requestOptions = {
      method: "GET",
      redirect: "follow",
      credentials: "include"
    };

    fetch(`${process.env.VUE_APP_API_URL}/user/status`, requestOptions)
      .then(response => response.json())
      .then(data => {
        let login = data.status;
        if (!login) {
          this.loginStatus = false;
          this.$router.push({ path: "/" }).catch(err => {
            console.log(err);
          });
          alert("Nie zalogowales sie");
          return false;
        } else {
          this.$router.push({ path: "/cars" }).catch(err => {
            console.log(err);
          });
          this.loginStatus = true;
          return true;
        }
      });
  },
  methods: {
    logout: function() {
      var requestOptions = {
        method: "GET",
        redirect: "follow",
        credentials: "include"
      };

      fetch(`${process.env.VUE_APP_API_URL}/user/logout`, requestOptions)
        .then(response => response.json())
        .then(() => {
          this.$router.push({ path: "/" }).catch(err => {
            console.log(err);
          });
          this.loginStatus = false;
        })
        .catch(error => console.log("error", error));
    }
  }
};
</script>

<style>
body {
  width: 100%;
  height: 100%;
  padding: 0px;
  margin: 0px;
  background: black;
}
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  background: rgb(80, 77, 77);
  width: 100%;
  padding: 0px;
  margin: 0px;
  display: flex;
  flex-direction: column;

}

.menu-icon {
  width: 25px;
  padding: 2px;
}

.view {
  height: calc(100% - 54px);
  width: 100%;
  min-height: 100vh;
  max-width: 1600px;
  background: black;
  background-attachment: fixed;
  display: flex;
  margin: 0 auto;
}

::-webkit-scrollbar {
  width: 10px;
}

/* Track */
::-webkit-scrollbar-track {
  background: #f1f1f1; 
}
 
/* Handle */
::-webkit-scrollbar-thumb {
  background: #888; 
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
  background: #555; 
}
</style>
