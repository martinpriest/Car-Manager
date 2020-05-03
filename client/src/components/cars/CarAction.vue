<template>
  <div id="car-action">
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
import CarRepairHistory from "./CarAction/RepairHistory/CarRepairHistory"

export default {
    name: 'CarAction',
    components: {
      CarTankHistory,
      CarRepairHistory
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

.tank-history {
    flex: 1;
}

.repair-history {
    flex: 1;
}
</style>