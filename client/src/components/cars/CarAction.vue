<template>
  <div id="car-action">
      <div class="localization-history">
          <CarLocalizationHistory v-bind:actualCar="actualCar"/>
      </div>
      <div class="tank-history">
          <CarTankHistory v-bind:actualCar="actualCar"/>
      </div>
      <div class="repair-history">
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

.localization-history {
    flex: 1;
    display: flex;
    flex-direction: column;
}

.tank-history {
    flex: 1;
    display: flex;
    flex-direction: column;
}

.repair-history {
    flex: 1;
    display: flex;
    flex-direction: column;
}
</style>
