<template>
    <div class="car-profile-box">
        <h1>Car profile</h1>
        <p>
            <label for="car-id">ID:</label>
            <input type="number" id="car-id">
            <input type="submit" id="submit" value="Submit" v-on:click="getData()">
        </p>
        <p>
            <img :src="carImageUrl" alt="Car image">
        </p>
        <p>Name: {{ carName }}</p>
        <p>Make: {{ carMake }}</p>
        <p>Model: {{ carModel }}</p>
        <p>Color: {{ carColor }}</p>
        <p>Mileage: {{ carMileage }} km</p>
    </div>
</template>

<script>
export default {
    name: 'CarProfile',
    data: function() {
        return {
            carName: "",
            carMake: "",
            carModel: "",
            carColor: "",
            carMileage: "",
            carImageUrl: ""
        }
    },
    methods: {
        getData: function() {
            let carId = document.querySelector("#car-id");
            console.log(carId.value);

            var requestOptions = {
                method: 'GET',
                redirect: 'follow',
                credentials: 'include'
            };

            fetch(`http://marcin.innome.pl:8000/car/${carId.value}`, requestOptions)
                .then(response => response.json())
                .then((result) => {
                    console.log(result);
                    this.carName = result.name;
                    this.carMake = result.mark;
                    this.carModel = result.model;
                    this.carColor = result.color;
                    this.carMileage = result.engineMileage;
                    this.carImageUrl = `http://marcin.innome.pl:8000/${result.imgPath}`;
                })
                .catch(error => console.log('error', error));
        }
    }
}
</script>

<style>
    .car-profile-box {
        color: #fff;
    }
</style>