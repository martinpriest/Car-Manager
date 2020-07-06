<template>
  <div>
    <div v-if="showTable">
      <b-table v-if="items.length" dark striped hover :items="items" :fields="fields"></b-table>
      <p v-else>No notification</p>
      <b-button variant="success" @click="showAddNotificationForm">Add notification</b-button>
    </div>
    <div v-if="showNotificationForm" class="w-75 mx-auto">
      <!-- TYPE -->
      <b-row class="pt-1">
        <b-col cols="4">Type:</b-col>
        <b-col cols="8">
          <NotificationTypeSelect @notificationType="updateNotification" />
        </b-col>
      </b-row>
      <!-- DESCRIPTION -->
      <b-row class="pt-1">
        <b-col cols="4">Description:</b-col>
        <b-col cols="8">
          <b-form-input
            v-model="addNotificationForm.description"
          >{{addNotificationForm.description}}</b-form-input>
        </b-col>
      </b-row>

      <!-- DATE -->
      <b-row class="pt-1">
        <b-col cols="4">Date:</b-col>
        <b-col cols="8">
          
      <b-form-input v-model="addNotificationForm.date" type="date" placeholder></b-form-input>
        </b-col>
      </b-row>

      <b-button class="mt-2" variant="success" @click="addNotification">Add notification</b-button>
    </div>
  </div>
</template>

<script>
import NotificationTypeSelect from "../reusable/NotificationTypeSelect";
export default {
  name: "NotificationTable",
  components: {
    NotificationTypeSelect
  },
  props: {
    actualCar: Number
  },
  data() {
    
    let today = new Date().toISOString().substr(0, 10);
    return {
      showTable: true,
      showNotificationForm: false,
      items: [],
      fields: [
        { key: "carName", sortable: false },
        { key: "notificationType", sortable: true },
        { key: "notificationDate", sortable: true }
      ],
      addNotificationForm: {
        idCar: 1,
        idNotificationType: 1,
        date: today,
        description: "Default description"
      }
    };
  },
  created: function() {
    var json = {
      idCar: this.actualCar
    };

    var requestOptions = {
      method: "POST",
      body: JSON.stringify(json),
      redirect: "follow",
      credentials: "include"
    };

    fetch(`${process.env.VUE_APP_API_URL}/notification/`, requestOptions)
      .then(response => response.json())
      .then(result => {
        if(!result.message) {
          result.forEach(element => {
          this.items.push(element);
        });
        }
        
      })
      .catch(error => console.log("error", error));
  },
  watch: {
    actualCar: function() {
      var json = {
        idCar: this.actualCar
      };

      var requestOptions = {
        method: "POST",
        body: JSON.stringify(json),
        redirect: "follow",
        credentials: "include"
      };

      fetch(`${process.env.VUE_APP_API_URL}/notification/`, requestOptions)
        .then(response => response.json())
        .then(result => {
          this.items = [];
          if(!result.message) {
result.forEach(element => {
            this.items.push(element);
          });
          }
          
        })
        .catch(error => console.log("error", error));
    }
  },
  methods: {
      addNotification() {

        this.addNotificationForm.idCar = this.actualCar;
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
          this.showNotificationForm = false;
        })
        .catch(() => {
          alert("Cos nie poszlo");
        });
      },
    showAddNotificationForm() {
      this.showTable = false;
      this.showNotificationForm = true;
    },
    updateNotification: function(notificationType) {
      this.addNotificationForm.idNotificationType = parseInt(notificationType);
    },
  }
};
</script>

<style>
</style>