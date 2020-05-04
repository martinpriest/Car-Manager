<template>
  <div id="cars">
    <div class="car-menu">
      <CarMenu v-bind:cars="cars" @carId="updateCarId"/>
    </div>
    <div class="car-container">
      <div class="car-profile-container">
        <div class="car-profile">
          <CarProfile v-bind:actualCar="actualCar"/>
        </div>
        <div class="car-map">
          <!-- <GoogleMap/> -->
        </div>
      </div>
      <div class="car-actions">
        <CarAction v-bind:actualCar="actualCar"/>
      </div>
    </div>
  </div>
</template>

<script>
import CarMenu from './../components/cars/CarMenu'
import CarProfile from './../components/cars/CarProfile'
// import GoogleMap from './../components/cars/GoogleMap'
import CarAction from './../components/cars/CarAction'

export default {
    name: 'Cars',
    components: {
      CarMenu, CarProfile, CarAction //GoogleMap,
    },
    data: function() {
      return {
        cars: [],
        actualCar: 1
      }
    },
    created: function() {

        var requestOptions = {
          method: 'GET',
          redirect: 'follow',
          credentials: 'include'
        };

        fetch("http://marcin.innome.pl:8000/car", requestOptions)
        .then(response => response.json())
        .then((result) => {
          this.cars = result;
          this.actualCar = result[0].id;
          console.log(`Acutal car: ${this.actualCar}`)
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
    display: flex;
    flex-direction: row;
    width: 100%;
    height: 100%;
  }

  .car-menu {
    display: flex;
    color: white;
    font-size: 16px;
    width: 20%;
    height: 100%;
    border-right: black solid 4px;
  }

  .car-container {
    display: flex;
    flex-direction: column;
    height: 100%;
    width: 100%;
    
  }
    
  .car-profile-container {
      width: 100%;
      height: 50%;
      display: flex;
      flex-direction: row;
  }

  .car-profile {
    width: 30%;
    height: 100%;
    border-right: black solid 4px;
  }

  .car-map {
    width: 70%;
    height: 100%;
    /* border: black solid 4px; */
  }

  .car-actions {
    width: 100%;
    height: 50%;
    border-top: black solid 4px;
    padding: 5px;
  }
</style>