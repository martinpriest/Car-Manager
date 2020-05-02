<template>
<ul>
    <li v-for="car in cars" :key ="car.id">{{car.name}}</li>
    <button id="addCar" @click="addCar = true">Add Car</button>
    <AddCarModal v-if="addCar" @close="addCar = false">
        <h3 slot="header">Add new car</h3>
      </AddCarModal>
</ul>
</template>

<script>
import AddCarModal from './AddCarModal'
export default {
    name: 'CarMenu',
    components: {
        AddCarModal
    },
    props: {
        cars: Array,
        actualCar: Object,
    },
    data: function() {
        return {
            addCar: false
        }
    }
}
</script>

<style>

</style>
