<template>
  <div>
      <table v-if="repairHistory.length">
          <tr>
              <th>Data</th>
              <th>Opis</th>
          </tr>
          <tr v-for="repair in repairHistory" :key ="repair.id">
              <td>{{ repair.date.date }}</td>
              <td>{{ repair.description }}</td>
          </tr>
      </table>
      <p v-else>No repair history</p>
  </div>
<!-- <AddCarModal v-if="showModal" @close="showModal = false">
        <h3 slot="header">custom header</h3>
      </AddCarModal> -->
</template>

<script>
export default {
    name: 'RepairHistoryTable',
    props: {
        repairHistory: Array
    },
    watch: {
        repairHistory: function(newVal, oldVal) {
        console.log('Prop changed: ', newVal, ' | was: ', oldVal);
        }
    }
}
</script>

<style>
</style>