<template>
  <div class="notification-box mx">
    <div v-if="showTable">
        <b-table v-if="items.length" dark striped hover :items="items" :fields="fields"></b-table>

      <p v-else>No notification</p>
      <!-- <b-button variant="success" @click="showNotificationForm">Add notification</b-button> -->

    </div>
    <!-- <div v-if="showAddNotification">
      <CarSelect @idCar="updateCar" class="mb-2 mt-2"/>
      <NotificationTypeSelect @notificationType="updateNotification" />
      <b-row class="pt-1">
        <b-col cols="4">Description:</b-col>
        <b-col cols="8">
          <b-form-input
            v-model="addNotificationForm.description"
          >{{addNotificationForm.description}}</b-form-input>
        </b-col>
      </b-row>
      <b-form-input v-model="addNotificationForm.date" type="date" placeholder></b-form-input>
      <b-button variant="success" @click="addNotification">Add notification</b-button>

    </div> -->
  </div>
</template>

<script>
// import NotificationTypeSelect from "../reusable/NotificationTypeSelect";
// import CarSelect from "../reusable/CarSelect";
export default {
  name: "Notification",
  components: {
    // NotificationTypeSelect, CarSelect
  },
  props: {
    cars: Array
  },
  data: function() {
    
    let today = new Date().toISOString().substr(0, 10);
    return {
      showTable: true,
      showAddNotification: false,
      items: [],
      addNotificationForm: {
        idCar: 1,
        idNotificationType: 1,
        date: today,
        description: "Default description"
      },
            fields: [
                {key: 'carName', sortable: true },
                {key: 'notificationType', sortable: true },
                {key: 'notificationDate', sortable: true }
            ],
    };
  },
  created: function() {
    var requestOptions = {
      method: "GET",
      redirect: "follow",
      credentials: "include"
    };

    fetch(`${process.env.VUE_APP_API_URL}/notification/recent`, requestOptions)
      .then(response => response.json())
      .then(result => {
        result.forEach((element) => {
                    this.items.push(element)
                })
      })
      .catch(error => console.log("error", error));
  },
  methods: {
    showNotificationForm() {
      this.showTable = false;
      this.showAddNotification = true;
    },
    addNotification() {

      var requestOptions = {
        method: "POST",
        body: JSON.stringify(this.addNotificationForm),
        redirect: "follow",
        credentials: "include"
      };

      fetch(
        `${process.env.VUE_APP_API_URL}/notification/create`,
        requestOptions
      )
        .then(response => response.json())
        .then(result => {
          alert(result.message);
          this.showTable = true;
          this.showAddNotification = false;
        })
        .catch(() => {
          alert("Cos nie poszlo");
        });
    },
    updateNotification: function(notificationType) {
      console.log(`W FUNKCJI: ${notificationType}`);
      this.addNotificationForm.idNotificationType = parseInt(notificationType);
    },
    updateCar: function(car) {
      console.log(`W FUNKCJI idCar: ${car}`);
      this.addNotificationForm.idCar = parseInt(car);
    }
  }
};
</script>

<style>
.notification-box {
  color: #fff;
}
</style>