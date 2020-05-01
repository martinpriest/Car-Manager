<template>
  <div>
      <CarMenu/>
      <CarProfile/>
      <GoogleMap/>
      <CarAction/>
      <AddCarModal cars="cars"  class="car-modal"/>
  </div>
</template>

<script>
import CarMenu from './../components/cars/CarMenu'
import CarProfile from './../components/cars/CarProfile'
import GoogleMap from './../components/cars/GoogleMap'
import AddCarModal from './../components/cars/AddCarModal'
import CarAction from './../components/cars/CarAction'

export default {
    name: 'Cars',
    components: {
      CarMenu, CarProfile, GoogleMap, AddCarModal, CarAction
    },
    data: function() {
      return {
        cars: []
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
          // this.$router.push({ path: '/cars' }).catch(err => {console.log(err)})
        })
        .catch(error => console.log('error', error));
      }
}
</script>

<style>
  .car-modal {
    display: none;
  }
</style>