<template>
<div>

  <select class="form-control" name="petrol-type" id="petrol-type" v-model="actualPetrolType" @change="pickPetrolType($event)">
      <option v-for="type in petrolTypes" :value="type.id" :key ="type.id">{{type.name}}</option>
  </select>
</div>

</template>

<script>
export default {
    name: 'PetrolTypeSelect',
    data: function() {
        return {
            petrolTypes: []
        }
    },
    props: {
      actualPetrolType: Number
    },
    created: function() {
        var requestOptions = {
          method: 'GET',
          redirect: 'follow',
          credentials: 'include'
        };

        fetch(`${process.env.VUE_APP_API_URL}/petrol_types/`, requestOptions)
        .then(response => response.json())
        .then((result) => {
          this.petrolTypes = result;
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