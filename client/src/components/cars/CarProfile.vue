<template>
    <div class="car-profile-box">
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
    props: {
        actualCar: Number
    },
    watch: {
        actualCar: function() {
            console.log(this.actualCar);

            var requestOptions = {
                method: 'GET',
                redirect: 'follow',
                credentials: 'include'
            };

            fetch(`http://marcin.innome.pl:8000/car/${this.actualCar}`, requestOptions)
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