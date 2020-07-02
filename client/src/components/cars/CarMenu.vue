<template>
<div class="car-profile-box" style="max-height: 60px;">
<b-container class="bv-example-row">
    <b-row>
        <b-col cols="6">
            <b-dropdown id="dropdown-left" text="Choose car" variant="primary" class="m-2" menu-class="w-100">
                <b-dropdown-item class="menu-item" v-for="car in cars" :key ="car.id" v-on:click="pickCar(car.id, car.name)">{{car.name}}</b-dropdown-item>
            </b-dropdown>
        </b-col>
        <b-col cols="6">
            <b-button id="addCar" class="m-2" style="font-size: 12px" variant="success" @click="addCar = true">Add car</b-button>
            <!-- <button class="btn btn-success w-100" id="addCar" @click="addCar = true">Add Car</button> -->
        </b-col>
  </b-row>
</b-container>

    

    

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
        actualCar: Number,
    },
    data: function() {
        return {
            addCar: false
        }
    },
    methods: {
        pickCar(car, name) {
            this.$emit("carId", car);
            document.querySelector("#dropdown-left__BV_toggle_").textContent = name;
        }
    }
}
</script>

<style>
</style>
