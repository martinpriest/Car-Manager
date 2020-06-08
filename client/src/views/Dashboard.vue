<template>
<div class="dashboard">
    <div class="car-chart-container">
        <div class="car-table">
            <CarTable v-bind:cars="cars"/>
        </div>
        <div class="cost-chart">
            <h1>Cost chart</h1>
            <!--<CostChart/>-->
        </div>
    </div>
    <div class="notification">
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
h1 {
    color: white;
}

.dashboard {
    display: flex;
    flex-direction: column;
    flex: 1;
    width: 100%;
    height: 100%;
}

.car-chart-container {
    display: flex;
    flex-direction: row;
    flex: 1;
}

.car-table {
    display: flex;
    color: white;
    font-size: 16px;
    flex: 1;
}

.cost-chart {
    display: flex;
    color: white;
    font-size: 16px;
    flex: 1;
}

.notification {
    display: flex;
    color: white;
    font-size: 16px;
    flex: 1;
}
</style>