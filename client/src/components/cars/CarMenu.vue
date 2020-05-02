<template>
<ul>
    <li v-for="car in cars" :key ="car.id">{{car.name}}</li>
</ul>
</template>

<script>
export default {
    name: 'CarMenu',
    props: {
        cars: Array,
        actualCar: Object
    }
}
</script>

<style>

</style>