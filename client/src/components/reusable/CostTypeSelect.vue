<template>
  <div>
    <b-form-select v-model="selected" :options="options" @change="pickCostType($event)"></b-form-select>
  </div>
</template>

<script>
export default {
    name: 'CostTypeSelect',
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

        fetch(`${process.env.VUE_APP_API_URL}/cost_types/`, requestOptions)
        .then(response => response.json())
        .then((result) => {
          result.forEach((record) => {
              this.options.push({value: record.id, text: record.name})
          })
        })
        .catch(error => console.log('error', error));
    },
    methods: {
      pickCostType(event) {
        this.$emit("idCostType", event);
      }
    }
}
</script>

<style>

</style>