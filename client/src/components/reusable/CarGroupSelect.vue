<template>
  <div>
    <b-form-select v-model="selected" :options="options" @change="pickCarGroup($event)"></b-form-select>
  </div>
</template>

<script>
export default {
    name: 'CarGroupSelect',
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

        fetch(`${process.env.VUE_APP_API_URL}/car_group/`, requestOptions)
        .then(response => response.json())
        .then((result) => {
          result.forEach((carGroup) => {
              this.options.push({value: carGroup.id, text: carGroup.name})
          })
        })
        .catch(error => console.log('error', error));
    },
    methods: {
      pickCarGroup(event) {
        this.$emit("idCarGroup", event);
      }
    }
}
</script>

<style>

</style>