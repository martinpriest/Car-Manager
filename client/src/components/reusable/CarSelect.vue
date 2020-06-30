<template>
    <div>
        <select class="form-control w-100" name="car-group" id="car-group" v-model="actualCarGroup" @change="pickCarGroup($event)">
            <option v-for="carGroup in carGroups" :value="carGroup.id" :key ="carGroup.id">{{carGroup.name}}</option>
        </select>
    </div>
</template>

<script>
export default {
    name: 'CarSelect',
    data: function() {
        return {
            cars: []
        }
    },
    props: {
      actualCar: Number
    },
    created: function() {
        var requestOptions = {
          method: 'GET',
          redirect: 'follow',
          credentials: 'include'
        };

        fetch(`${process.env.VUE_APP_API_URL}/car/`, requestOptions)
        .then(response => response.json())
        .then((result) => {
          this.cars = result;
        })
        .catch(error => console.log('error', error));
    },
    methods: {
      pickPetrolType(event) {
        this.$emit("petrolTypeId", parseInt(event.target.value));
      }
    }
}
</script>

<style>

</style>