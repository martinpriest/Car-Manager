<template>
    <div class="car-table-box">
        <table class="table table-dark">
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
    </div>
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
.car-table-box {
    color: #fff;
}
</style>