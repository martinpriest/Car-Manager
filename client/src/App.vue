<template>
  <div id="app">
    <div
      v-show="this.loginStatus"
      id="main-nav"
      class="navbar navbar-expand-lg navbar-light bg-light text-light"
    >
      <nav>
        <button
          class="navbar-toggler"
          type="button"
          data-toggle="collapse"
          data-target="#navbarNavAltMarkup"
          aria-controls="navbarNavAltMarkup"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
          <div class="navbar-nav text-light">
            <router-link to="/dashboard">
              <img class="menu-icon" src="./assets/menu-icon/dashboard-view.svg" alt="">
              <a class="nav-item nav-link active" href="#dashboard">
                Dashboard
                <span class="sr-only">(current)</span>
              </a>
            </router-link>
            <router-link to="/cars">
              <img class="menu-icon" src="./assets/menu-icon/car-view.svg" alt="">
              <a class="nav-item nav-link" href="#cars">Cars</a>
            </router-link>
            <router-link to="/reports">
              <img class="menu-icon" src="./assets/menu-icon/report-view.svg" alt="">
              <a class="nav-item nav-link disabled" href="#reports">Reports</a>
            </router-link>
            <router-link to="/setting">
              <img class="menu-icon" src="./assets/menu-icon/setting-view.svg" alt="">
              <a class="nav-item nav-link" href="#setting">Setting</a>
            </router-link>
            <router-link to="/">
              <img class="menu-icon" src="./assets/menu-icon/logout-view.svg" alt="">
              <a class="nav-item nav-link" href="#" v-on:click="logout()">Logout</a>
            </router-link>
          </div>
        </div>
      </nav>
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
      loginStatus: Boolean
    };
  },
  created() {
    var requestOptions = {
      method: "GET",
      redirect: "follow",
      credentials: "include"
    };

    fetch("http://marcin.innome.pl:8000/user/status", requestOptions)
      .then(response => response.json())
      .then(data => {
        let login = data.status;
        if (!login) {
          this.loginStatus = false;
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

      fetch("http://marcin.innome.pl:8000/user/logout", requestOptions)
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
  height: 100%;
  padding: 0px;
  margin: 0px;
}
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  background: rgb(80, 77, 77);
  width: 100%;
  height: 100%;
  padding: 0px;
  margin: 0px;
  display: flex;
  flex-direction: column;

}

#main-nav {
  display: flex;
  width: 100%;
  height: 54px;
}
#main-nav .nav-link {
  padding-top: 0px;
}

.menu-icon {
  width: 25px;
  padding: 2px;
}

.view {
  height: calc(100% - 54px);
  width: 100%;
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
