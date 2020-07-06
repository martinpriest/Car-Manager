<template>
<div>

  <select class="form-control" name="petrol-type" id="petrol-type" v-model="actualPetrolType" @change="pickPetrolType()">
      <option v-for="type in petrolTypes" :value="{id: type.id, name: type.name}" :key ="type.id">{{type.name}}</option>
  </select>
</div>

</template>

<script>
export default {
    name: 'PetrolTypeSelect',
    data: function() {
        return {
            
          actualPetrolType: {
            id: 1,
            name: "LPG"
          },
            petrolTypes: []
        }
    },
    props: {
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
      pickPetrolType() {
        let petrolType = {
          id: this.actualPetrolType.id,
          name: this.actualPetrolType.name,
        }
        this.$emit("petrolTypeId", petrolType);
      }
    }
}
</script>

<style>

</style>