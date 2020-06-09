<template>
    <table class="table table-hover table-bordered table-dark w-100 overflow-auto m-auto">
        <thead>
        <tr>
            <th>Name</th>
            <th>Make</th>
            <th>Model</th>
            <th>Color</th>
            <th>Mileage</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="car in cars" :key ="car.id">
            <td>{{car.name}}</td>
            <td>{{car.mark}}</td>
            <td>{{car.model}}</td>
            <td>{{car.color}}</td>
            <td>{{car.engineMileage}} km</td>
        </tr>
        </tbody>
    </table>
</template>

<script>
export default {
    name: 'CarTable',
    props: {
        cars: Array
    },
    methods: {
    }
}
</script>

<style>
</style>