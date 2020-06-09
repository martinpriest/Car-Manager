<template>
  <div id="car-action">
      <div class="history-container">
          <CarLocalizationHistory v-bind:actualCar="actualCar"/>
      </div>
      <div class="history-container">
          <CarTankHistory v-bind:actualCar="actualCar"/>
      </div>
      <div class="history-container">
          <CarRepairHistory v-bind:actualCar="actualCar"/>
      </div>
  </div>
</template>

<script>
import CarTankHistory from './CarAction/TankHistory/CarTankHistory'
import CarLocalizationHistory from './CarAction/LocalizationHistory/CarLocalizationHistory'
import CarRepairHistory from "./CarAction/RepairHistory/CarRepairHistory";

export default {
    name: 'CarAction',
    components: {
      CarTankHistory, CarLocalizationHistory, CarRepairHistory
    },
    props: {
      actualCar: Number
    }
}
</script>

<style>
#car-action {
  display: flex;
  flex-direction: row;
  width: 100%;
  height: 100%;
}

.history-container {
    flex: 1;
    display: flex;
    flex-direction: column;
    height: 90%;
    background: rgb(36, 36, 36);
    border-radius: 5px;
    margin: 10px;
}
</style>
