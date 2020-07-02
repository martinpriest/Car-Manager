<template>
  <div>
    <b-form-select v-model="selected" :options="options" @change="pickCar($event)"></b-form-select>
  </div>
</template>

<script>
export default {
    name: 'CarSelect',
    data: function() {
        return {
            selected: null,
            options: []
        }
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
          result.forEach((car) => {
              this.options.push({value: car.id, text: car.name})
          })
        })
        .catch(error => console.log('error', error));
    },
    methods: {
      pickCar(event) {
          console.log(`EMITOWALEM idCar: ${event}`)
        this.$emit("idCar", event);
      }
    }
}
</script>

<style>

</style>