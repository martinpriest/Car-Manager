<template>
  <div>
    <b-table dark striped hover :items="items" :fields="fields"
    
      :sort-by.sync="sortBy"
      :sort-desc.sync="sortDesc"
      responsive="sm">

    </b-table>
  </div>
</template>

<script>
export default {
    name: 'CarTable',
    props: {
        cars: Array
    },
    data() {
        return {
            sortBy: 'totalCost',
            sortDesc: false,
            items: [

            ],
            fields: [
                {key: 'carName', sortable: true },
                {key: 'totalCost', sortable: true },
                {key: 'totalTankCost', sortable: true },
                {key: 'totalRepairCost', sortable: true}
            ],
        }
    },
    created() {
        var requestOptions = {
            method: 'GET',
            redirect: 'follow',
            credentials: 'include'
        };

        fetch(`${process.env.VUE_APP_API_URL}/cost_history/aggregate2`, requestOptions)
            .then(response => response.json())
            .then((data) => {
                data.forEach((element) => {
                    this.items.push(element)
                })
            })
            .catch(error => console.log('error', error));
    },
    methods: {
    }
}
</script>

<style>
</style>