<template>
  <div id="cars">
    <div class="car-menu">
      <CarMenu v-bind:cars="cars" @carId="updateCarId"/>
    </div>
    
  <b-tabs content-class="mt-3" class="car-profile-box">
    <b-tab title="Profile" active>
      <div class="car-profile">
        <CarProfile v-bind:actualCar="actualCar"/>
      </div>
    </b-tab>
    <b-tab title="Map">
      <div class="car-map">
          <GoogleMap/>
        </div>
    </b-tab>
    <b-tab title="Localization">
      <CarLocalizationHistory v-bind:actualCar="actualCar"/>
    </b-tab>
    <b-tab title="Repair history">
      <CarRepairHistory v-bind:actualCar="actualCar"/>
    </b-tab>
    <b-tab title="Tank history">
      <CarTankHistory v-bind:actualCar="actualCar"/>
    </b-tab>
  </b-tabs>
    </div>
</template>

<script>
import CarMenu from './../components/cars/CarMenu'
import CarProfile from './../components/cars/CarProfile'
import GoogleMap from './../components/cars/GoogleMap'
import CarLocalizationHistory from './../components/cars/LocalizationHistory/CarLocalizationHistory'
import CarRepairHistory from './../components/cars/RepairHistory/CarRepairHistory'
import CarTankHistory from './../components/cars/TankHistory/CarTankHistory'

export default {
    name: 'Cars',
    components: {
      CarMenu, CarProfile, GoogleMap, CarLocalizationHistory, CarRepairHistory, CarTankHistory
    },
    data: function() {
      return {
        cars: [],
        carGroups: [],
        actualCar: 1
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
          console.log(`Actual car: ${this.actualCar}`)
        })
        .catch(error => console.log('error', error));

        fetch(`${process.env.VUE_APP_API_URL}/car_group`, requestOptions)
        .then(response => response.json())
        .then((result) => {
          this.carGroups = result;
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

  #cars {
    display: grid;
    grid-auto-rows: auto;
    grid-template-columns: 1fr;
    width: 100%;
  }
.car-view-box {
  display: grid;
  background: rgb(36, 36, 36);;
}

.car-profile-box {
    color: #fff;
    display: flex;
    flex-direction: column;
    height: 90%;
    background: rgb(36, 36, 36);
    border-radius: 5px;
    margin: 10px;
}


    .car-list {
        list-style-type: none;
        margin: 0;
        padding: 0;
    background: olive;
        list-style-type: none;
        list-style-position: inside;
    }

    .car-list-element {
        padding-top: 10px;
        border-bottom: 1px solid black;
    }

    .car-list-element:hover {
        padding-top: 10px;
        border-bottom: 3px solid black;
        color: blanchedalmond;
        cursor: pointer;
    }

  .car-map {
    width: 100%;
    height: 300px;
  }
/* Smartphones (portrait and landscape) ----------- */
@media only screen 
and (min-device-width : 120px) 
and (max-device-width : 480px) {

  .car-menu {
    display: flex;
    color: white;
    font-size: 16px;
    width: 100%;
    border-right: black solid 4px;
  }

.car-profile-box {
    color: #fff;
    display: flex;
    flex-direction: column;
    width: 90%;
    height: 90%;
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
}

@media all and (max-width: 480px) {
  #cars {
    display: grid;
    width: 100%;

  }
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