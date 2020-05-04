<template>
    <div class="car-profile-box">
        <p>
            <img src="./../../assets/car-default.svg" alt="Car image">
        </p>
        <p>Name: {{ carName }}</p>
        <p>Make: {{ carMake }}</p>
        <p>Model: {{ carModel }}</p>
        <p>Color: {{ carColor }}</p>
        <p>Mileage: {{ carMileage }} km</p>
        <button class="btn btn-success">Add notification</button>
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
            carImageUrl: "",
        }
    },
    props: {
        actualCar: Number
    },
    created() {
        // this.actualCar = 1;
    },
    watch: {
        actualCar: function() {

            var requestOptions = {
                method: 'GET',
                redirect: 'follow',
                credentials: 'include'
            };

            fetch(`http://marcin.innome.pl:8000/car/${this.actualCar}`, requestOptions)
                .then(response => response.json())
                .then((result) => {
                    this.carName = result.name;
                    this.carMake = result.mark;
                    this.carModel = result.model;
                    this.carColor = result.color;
                    this.carMileage = result.engineMileage;
                    this.carImageUrl = `${result.imgPath}`;
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