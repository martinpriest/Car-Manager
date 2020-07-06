<template>

<div class="mx-auto">
<b-container>
  <!-- CAR MENU -->
  <b-row class="mt-2" style="max-height: 60px;">
    <b-col cols="12">
      <CarMenu :cars="cars" @carId="updateCarId" @carName="updateCarName"/>
    </b-col>
  </b-row>
  <!-- CAR TABS -->
  <b-row class="pt-3">
    <b-col>

  <b-tabs content-class="mt-3" fill class="car-profile-box">
    <b-tab title="Profile" active>
      <div class="m-3">
        <CarProfile :actualCar="actualCar"/>
      </div>
    </b-tab>
    <b-tab title="Map">
      <div class="car-map">
          <GoogleMap :actualCar="actualCar" :localizationHistory="localizationHistory" :repairHistory="repairHistory" :tankHistory="tankHistory"/>
        </div>
    </b-tab>
    <b-tab title="Localization" class="m-3">
      <LocalizationHistoryTable :localizationHistory="localizationHistory"/>
    </b-tab>
    <b-tab title="Repair" class="m-3">
      <RepairHistoryTable :repairHistory="repairHistory"/>
    </b-tab>
    <b-tab title="Tank" class="m-3">
      <TankHistoryTable :tankHistory="tankHistory"/>
    </b-tab>
    <b-tab title="Notification" class="m-3">
      <NotificationTable :actualCarName="actualCarName" :actualCar="actualCar" :notification="notification"/>
    </b-tab>
  </b-tabs>


    </b-col>
  </b-row>
</b-container>
    
  
    </div>
</template>

<script>
import CarMenu from './../components/cars/CarMenu'
import CarProfile from './../components/cars/CarProfile'
import GoogleMap from './../components/cars/GoogleMap'
import LocalizationHistoryTable from './../components/cars/LocalizationHistoryTable'
import RepairHistoryTable from './../components/cars/RepairHistoryTable'
import TankHistoryTable from './../components/cars/TankHistoryTable'
import NotificationTable from './../components/cars/NotificationTable'

export default {
    name: 'CarsNew',
    components: {
      CarMenu, CarProfile, GoogleMap, LocalizationHistoryTable, RepairHistoryTable, TankHistoryTable, NotificationTable
    },
    data: function() {
      return {
        actualCar: null,
        actualCarName: "",
        cars: [],
        repairHistory: [],
        localizationHistory: [],
        tankHistory: [],
        notification: [],
        mapMarker: []
      }
    },
    created: function() {
        // fetch all car
        var requestOptions = {
          method: 'GET',
          redirect: 'follow',
          credentials: 'include'
        };

        fetch(`${process.env.VUE_APP_API_URL}/car`, requestOptions)
        .then(response => response.json())
        .then((result) => {
            if(!result.message) {
                this.actualCar = result[0].id;
                this.actualCarName = result[0].name;
                document.querySelector("#dropdown-left__BV_toggle_").textContent = result[0].name;
                this.cars = result;
            }
        })
        .catch(error => console.log('error', error));
        
        // fetch actual car info
        var json = {
          idCar: this.actualCar
        };

        var requestOptions2 = {
          method: 'POST',
          body: JSON.stringify(json),
          redirect: 'follow',
          credentials: 'include'
        };
        // fetch actual car tank history
        fetch(`${process.env.VUE_APP_API_URL}/tank_history/`, requestOptions2)
        .then(response => response.json())
        .then((result) => {
          if(result.message) this.tankHistory = []
            else this.tankHistory = result;
        })
        .catch(error => console.log('error', error));
        // fetch actual car repair history
        fetch(`${process.env.VUE_APP_API_URL}/repair_history/`, requestOptions2)
        .then(response => response.json())
        .then((result) => {
          if(result.message) this.repairHistory = []
            else this.repairHistory = result;
        })
        .catch(error => console.log('error', error));
        // fetch actual car localization history
        fetch(`${process.env.VUE_APP_API_URL}/localization_history/`, requestOptions2)
        .then(response => response.json())
        .then((result) => {
            if(result.message) this.localizationHistory = []
            else this.localizationHistory = result;
        })
        .catch(error => console.log('error', error));
        // fetch actual car notification
        fetch(`${process.env.VUE_APP_API_URL}/notification/`, requestOptions2)
        .then(response => response.json())
        .then(result => {
          if(result.message) this.notification = []
            else this.notification = result;
        })
      .catch(error => console.log("error", error));
      },
    methods: {
      updateCarId(carId) {
        this.actualCar = carId;
        this.tankHistory = [];
        this.notification = [];
        this.repairHistory = [];
        this.localizationHistory = [];

        var json = {
          idCar: this.actualCar
        };

        var requestOptions2 = {
          method: 'POST',
          body: JSON.stringify(json),
          redirect: 'follow',
          credentials: 'include'
        };
        // fetch actual car tank history
        fetch(`${process.env.VUE_APP_API_URL}/tank_history/`, requestOptions2)
        .then(response => response.json())
        .then((result) => {
          if(result.message) this.tankHistory = []
            else this.tankHistory = result;
        })
        .catch(error => console.log('error', error));
        // fetch actual car repair history
        fetch(`${process.env.VUE_APP_API_URL}/repair_history/`, requestOptions2)
        .then(response => response.json())
        .then((result) => {
          if(result.message) this.repairHistory = []
            else this.repairHistory = result;
        })
        .catch(error => console.log('error', error));
        // fetch actual car localization history
        fetch(`${process.env.VUE_APP_API_URL}/localization_history/`, requestOptions2)
        .then(response => response.json())
        .then((result) => {
          if(result.message) this.localizationHistory = []
            else this.localizationHistory = result;
        })
        .catch(error => console.log('error', error));
        // fetch actual car notification
        fetch(`${process.env.VUE_APP_API_URL}/notification/`, requestOptions2)
        .then(response => response.json())
        .then(result => {
          if(result.message) this.notification = []
            else this.notification = result;
        })
      },
      updateCarName(name) {
          this.actualCarName = name;
      }
    }
}
</script>

<style>
  .car-map {
    width: 100%;
    height: 400px;
  }

.car-profile-box {
    color: #fff;
    display: flex;
    flex-direction: column;
    height: 100%;
    background: rgb(36, 36, 36);
    border-radius: 5px;
    margin: auto;
}
  .car-profile {
    width: 100%;
    border-right: black solid 4px;
  }

  #car-action {
  display: flex;
  flex-direction: row;
  width: 100%;
}

.history-container {
    flex: 1;
    display: flex;
    flex-direction: column;
    background: rgb(36, 36, 36);
    border-radius: 5px;
    margin: 10px;
}


.modal-mask {
  position: fixed;
  z-index: 9998;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: table;
  transition: opacity 0.3s ease;
}

.modal-wrapper {
  display: table-cell;
  vertical-align: middle;
}

.modal-container {
  width: 300px;
  margin: 0px auto;
  padding: 20px 30px;
  background-color: #fff;
  border-radius: 2px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33);
  transition: all 0.3s ease;
  font-family: Helvetica, Arial, sans-serif;
}

.modal-header h3 {
  margin-top: 0;
  color: black !important;
}

.modal-body {
  margin: 20px 0;
}

.modal-default-button {
  float: right;
}

.modal-enter {
  opacity: 0;
}

.modal-leave-active {
  opacity: 0;
}

.modal-enter .modal-container,
.modal-leave-active .modal-container {
  -webkit-transform: scale(1.1);
  transform: scale(1.1);
}
@media all and (max-width: 480px) {
}
@media all and (min-width: 480px) and (max-width: 768px) { }
@media all and (min-width: 768px) and (max-width: 1024px) { }
@media all and (min-width: 1024px) and (max-width: 1280px) { }



  

  

  .car-container {
    display: flex;
    flex-direction: column;
    height: 100%;
    width: 100%;
    
  }

  

  .car-actions {
    width: 100%;
    height: 50%;
    border-top: black solid 4px;
    padding: 5px;
  }
</style>