<template>
    <div>
    <select class="form-control w-100" name="car-group" id="car-group" v-model="actualCarGroup" @change="pickCarGroup($event)">
        <option v-for="carGroup in carGroups" :value="carGroup.id" :key ="carGroup.id">{{carGroup.name}}</option>
    </select>
    </div>
</template>

<script>
export default {
    name: 'CarGroupSelect',
    data: function() {
        return {
            carGroups: []
        }
    },
    props: {
      actualCarGroup: Number
    },
    created: function() {
        var requestOptions = {
          method: 'GET',
          redirect: 'follow',
          credentials: 'include'
        };

        fetch(`${process.env.VUE_APP_API_URL}/car_group/`, requestOptions)
        .then(response => response.json())
        .then((result) => {
          this.carGroups = result;
        })
        .catch(error => console.log('error', error));
    },
    methods: {
      pickCarGroup(event) {
        this.$emit("idCarGroup", parseInt(event.target.value));
      }
    }
}
</script>

<style>

</style>