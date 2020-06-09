<template>
<div class="dashboard">
    <div class="dashboard-item">
        <div class="dashboard-item-header">
            <h5>Car table</h5>
        </div>
        <div class="dashboard-item-table">
            <CarTable v-bind:cars="cars"/>
        </div>
    </div>
    <div class="dashboard-item">
        <h5>Cost chart</h5>
    </div>
    <div class="dashboard-item notification-container">
        <h5>Recent notification</h5>
        <Notification v-bind:cars="cars"/>
    </div>
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

        fetch(`${process.env.VUE_APP_API_URL}/car`, requestOptions)
            .then(response => response.json())
            .then((result) => {
                this.cars = result;
            })
            .catch(error => console.log('error', error));
    },
    methods: {
    }
}
</script>

<style scoped>
.dashboard {
    width: 100%;
    height: 100%;
    display: grid;
    grid-template-columns: 1fr 1fr;
    grid-template-rows: 50% 50%;
}

.dashboard-item {
    color: white;
    background: rgb(36, 36, 36);
    border-radius: 5px;
    margin: 10px;
    padding: 10px;
}

.dashboard-item-header {
    height: 10%;
    color: white;
}

.dashboard-item-table {
    height: 85%;
    overflow: auto;
}

.notification-container {
    grid-column-start: 1;
    grid-column-end: 3;
}
</style>