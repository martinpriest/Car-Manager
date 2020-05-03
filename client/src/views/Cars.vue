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
          <GoogleMap/>
        </div>
      </div>
      <div class="car-actions">
        <CarAction/>
      </div>
    </div>
  </div>
</template>

<script>
import CarMenu from './../components/cars/CarMenu'
import CarProfile from './../components/cars/CarProfile'
import GoogleMap from './../components/cars/GoogleMap'
import CarAction from './../components/cars/CarAction'

export default {
    name: 'Cars',
    components: {
      CarMenu, CarProfile, GoogleMap, CarAction
    },
    data: function() {
      return {
        cars: [],
        actualCar: Number
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
          console.log(result);
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
  #cars {
    display: flex;
    flex-direction: row;
    width: 100%;
    height: 100%;
    border: blue solid 4px;
  }

  .car-menu {
    display: flex;
    color: white;
    font-size: 16px;
    width: 20%;
    height: 100%;
    border: pink solid 2px;
  }

  .car-container {
    display: flex;
    flex-direction: column;
    border: yellow solid 3px;
    height: 100%;
    width: 100%;
    
  }
    
  .car-profile-container {
      width: 100%;
      height: 50%;
      border: red solid 2px;
      display: flex;
      flex-direction: row;
  }

  .car-profile {
    width: 30%;
    height: 100%;
    border: blue 2px solid;
  }

  .car-map {
    width: 70%;
    height: 100%;
  }

  .car-actions {
    width: 100%;
    height: 50%;
    border: purple solid 3px;
  }
</style>