<template>
<ul>
    <li v-for="car in cars" :key ="car.id" v-on:click="pickCar(car.id)">{{car.name}}</li>
</ul>
</template>

<script>
export default {
    name: 'CarMenu',
    props: {
        cars: Array
    },
    methods: {
        pickCar(car) {
            console.log(car);
            this.$emit("carId", car);
        }
    }
}
</script>

<style>

</style>