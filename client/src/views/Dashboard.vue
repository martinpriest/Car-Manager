<template>
<div class="dashboard">
    <CarTable v-bind:cars="cars"/>
<!--    <CostChart/>-->
    <Notification v-bind:cars="cars"/>
</div>
</template>

<script>
import CarTable from "../components/dashboard/CarTable";
// import CostChart from "../components/dashboard/CostChart";
import Notification from "../components/dashboard/Notification";

export default {
    name: 'Dashboard',
    components: {
        CarTable,
        // CostChart,
        Notification
    },
    data: function() {
        return {
            cars: []
        }
    },
    created: function() {
        var requestOptions = {
            method: 'GET',
            redirect: 'follow',
            credentials: 'include'
        };

        fetch("http://marcin.innome.pl:8000/car", requestOptions)
            .then(response => response.json())
            .then((result) => {
                console.log(result);
                this.cars = result;
            })
            .catch(error => console.log('error', error));
    },
    methods: {
    }
}
</script>

<style>
    h1 {
        color: white;
    }
</style>