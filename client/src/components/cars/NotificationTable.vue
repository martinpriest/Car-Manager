<template>
  <div>

<div v-if="showTable">
  <b-button class="mb-2" variant="success" @click="showAddNotificationForm">Add notification</b-button>

    <table
      class="table table-bordered table-hover table-dark w-75 overflow-auto m-auto"
      v-if="notification.length"
    >
      <thead>
        <tr>
          <th>Car name</th>
          <th>Notification</th>
          <th>Date</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>

      <tbody>
        <tr
          v-for="record in notification"
          :key="record.id"
          :data-id-notification="record.id"
        >
          <td>{{ record.carName }}</td>
          <td>{{ record.notificationType }}</td>
          <td>{{ record.notificationDate }}</td>
          <td>
            <b-form-checkbox
              id="car-profile-is-public"
              name="car-profile-is-public"
            ></b-form-checkbox>
          </td>
          <td><b-button variant="danger" @click="deleteNotification(record)">Delete</b-button></td>
        </tr>
      </tbody>
    </table>
    <p v-else>No notification</p>
</div>

    <div v-if="showNotificationForm" class="w-75 mx-auto">
      <!-- TYPE -->
      <b-row class="pt-1">
        <b-col cols="4">Type:</b-col>
        <b-col cols="8">
          <NotificationTypeSelect @notificationType="updateNotification"/>
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
    actualCar: Number,
    actualCarName: String,
    notification: [Object, Array]
  },
  data() {
    
    let today = new Date().toISOString().substr(0, 10);
    return {
      showTable: true,
      showNotificationForm: false,
      
      addNotificationForm: {
        idCar: this.actualCar,
        idNotificationType: 1,
        date: today,
        description: "Default description"
      }
    };
  },
  methods: {
      deleteNotification(notToDelete) {
      var requestOptions = {
        method: "DELETE",
        redirect: "follow",
        credentials: "include"
      };

      fetch(`${process.env.VUE_APP_API_URL}/notification/${notToDelete.id}`, requestOptions)
        .then(response => response.json())
        .then(result => {
          console.log(result);
          var index = this.notification.map(x => {
            return x.id;
          }).indexOf(notToDelete.id);

          this.notification.splice(index, 1);
        })
        .catch(error => console.log("error", error));
      },
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

          var e = document.getElementById("notificationSelect");
          var notTypeName = e.options[e.selectedIndex].text;

          var newRecord = {
            idCar: this.addNotificationForm.idCar,
            notificationDate: this.addNotificationForm.date,
            status: 0,
            notificationType: notTypeName,
            id: result.id,
            carName: this.actualCarName,
            description: "Default"
          }
        console.log(newRecord);
          this.notification.push(newRecord)
          
          this.showNotificationForm = false;
          this.showTable = true;
        })
        .catch((err) => {
          alert(`${err}`);
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