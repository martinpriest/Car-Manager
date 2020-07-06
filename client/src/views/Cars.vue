<template>

<div class="mx-auto">
<b-container>
  <!-- CAR MENU -->
  <b-row class="mt-2" style="max-height: 60px;">
    <b-col cols="12">
      <CarMenu v-bind:cars="cars" @carId="updateCarId" :actualCar="actualCar"/>
    </b-col>
  </b-row>
  <!-- CAR TABS -->
  <b-row class="pt-3">
    <b-col>

  <b-tabs content-class="mt-3" fill class="car-profile-box">
    <b-tab title="Profile" active>
      <div class="m-3">
        <CarProfile v-bind:actualCar="actualCar"/>
      </div>
    </b-tab>
    <b-tab title="Map">
      <div class="car-map">
          <GoogleMap v-bind:actualCar="actualCar"/>
        </div>
    </b-tab>
    <b-tab title="Localization" class="m-3">
      <CarLocalizationHistory v-bind:actualCar="actualCar"/>
    </b-tab>
    <b-tab title="Repair" class="m-3">
      <CarRepairHistory v-bind:actualCar="actualCar"/>
    </b-tab>
    <b-tab title="Tank" class="m-3">
      <CarTankHistory v-bind:actualCar="actualCar"/>
    </b-tab>
    <b-tab title="Notification" class="m-3">
      <NotificationTable v-bind:actualCar="actualCar"/>
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
import CarLocalizationHistory from './../components/cars/LocalizationHistory/CarLocalizationHistory'
import CarRepairHistory from './../components/cars/RepairHistory/CarRepairHistory'
import CarTankHistory from './../components/cars/TankHistory/CarTankHistory'
import NotificationTable from './../components/cars/NotificationTable'

export default {
    name: 'Cars',
    components: {
      CarMenu, CarProfile, GoogleMap, CarLocalizationHistory, CarRepairHistory, CarTankHistory, NotificationTable
    },
    data: function() {
      return {
        cars: [],
        actualCar: null
      }
    },
    created: function() {

        var requestOptions = {
          method: 'GET',
          redirect: 'follow',
          credentials: 'include'
        };

        fetch(`${process.env.VUE_APP_API_URL}/car`, requestOptions)
        .then(response => response.json())
        .then((result) => {
          this.cars = result;
          this.actualCar = result[0].id;
        })
        .catch(error => console.log('error', error));
      },
    methods: {
      updateCarId(carId) {
        this.actualCar = carId;
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