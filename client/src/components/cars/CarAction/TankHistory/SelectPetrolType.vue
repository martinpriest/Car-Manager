<template>
<div>
<label for="petrol-type">Petrol:</label>
  <select name="petrol-type" id="petrol-type">
      
      <option v-for="type in petrolTypes" :key ="type.id">{{type.name}}</option>
  </select>
</div>

</template>

<script>
export default {
    name: 'SelectPetrolType',
    data: function() {
        return {
            petrolTypes: []
        }
    },
    created: function() {
        var requestOptions = {
          method: 'GET',
          redirect: 'follow',
          credentials: 'include'
        };

        fetch("http://marcin.innome.pl:8000/petrol_types/", requestOptions)
        .then(response => response.json())
        .then((result) => {
          this.petrolTypes = result;
          console.log("ELO");
          console.log(this.petrolTypes);
        })
        .catch(error => console.log('error', error));
    }
}
</script>

<style>

</style>