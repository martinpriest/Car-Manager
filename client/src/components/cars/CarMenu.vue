<template>
<div class="w-100">
    <ul class="car-list">
        <li class="car-list-element w-100" v-for="car in cars" :key ="car.id" v-on:click="pickCar(car.id)">
            <span>{{car.name}}</span>
        </li>
    </ul>
    <button class="btn btn-success w-75" id="addCar" @click="addCar = true">Add Car</button>

    <AddCarModal v-if="addCar" @close="addCar = false">
        <h3 slot="header">Add new car</h3>
    </AddCarModal>
</div>
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
    },
    methods: {
        pickCar(car) {
            this.$emit("carId", car);
        }
    }
}
</script>

<style>
    .car-list {
        list-style-type: none;
        margin: 0;
        padding: 0;
        list-style-type: none;
        list-style-position: inside;
    }

    .car-list-element {
        padding-top: 10px;
        border-bottom: 1px solid black;
    }

    .car-list-element:hover {
        padding-top: 10px;
        border-bottom: 3px solid black;
        color: blanchedalmond;
        cursor: pointer;
    }
</style>
