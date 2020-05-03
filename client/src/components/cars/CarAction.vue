<template>
  <div id="car-action">
      <CarTankHistory v-bind:actualCar="actualCar"/>
  </div>
</template>

<script>
import CarTankHistory from './CarAction/TankHistory/CarTankHistory'

export default {
    name: 'CarAction',
    components: {
      CarTankHistory
    },
    props: {
      actualCar: Number
    }
}
</script>

<style>
</style>