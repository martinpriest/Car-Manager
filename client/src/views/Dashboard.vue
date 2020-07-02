<template>

<div class="mx-auto">
<b-container>
  <!-- CAR TABS -->
  <b-row class="pt-3">
    <b-col>

  <b-tabs content-class="mt-3" fill class="car-profile-box">
    <b-tab title="Car summary" active>
      <div class="m-3">
        <CarTable v-bind:cars="cars"/>
      </div>
    </b-tab>
    <b-tab title="Cost summary">
      <div class="car-map">
          <CostChart v-bind:cars="cars"/>
        </div>
    </b-tab>
    <b-tab title="Recent notification" class="m-3">
      <Notification v-bind:cars="cars"/>
    </b-tab>
  </b-tabs>


    </b-col>
  </b-row>
</b-container>
    
  
    </div>

</template>

<script>
import CarTable from "../components/dashboard/CarTable";
import CostChart from "../components/dashboard/CostChart";
import Notification from "../components/dashboard/Notification";

export default {
    name: 'Dashboard',
    components: {
        CarTable,
        CostChart,
        Notification
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

        fetch(`${process.env.VUE_APP_API_URL}/car`, requestOptions)
            .then(response => response.json())
            .then((result) => {
                this.cars = result;
            })
            .catch(error => console.log('error', error));
    },
    methods: {
    }
}
</script>

<style scoped>
</style>