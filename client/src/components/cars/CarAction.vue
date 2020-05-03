<template>
  <div id="car-action">
      <CarLocalizationHistory v-bind:actualCar="actualCar"/>
      <CarTankHistory v-bind:actualCar="actualCar"/>
  </div>
</template>

<script>
import CarTankHistory from './CarAction/TankHistory/CarTankHistory'
import CarLocalizationHistory from './CarAction/LocalizationHistory/CarLocalizationHistory'

export default {
    name: 'CarAction',
    components: {
      CarTankHistory, CarLocalizationHistory
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
  align-content: center;
  align-items: center;
}
</style>
