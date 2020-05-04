<template>
  <div>
      <table class="table table-dark w-75 overflow-auto" v-if="repairHistory.length">
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
</template>

<script>
export default {
    name: 'RepairHistoryTable',
    props: {
        repairHistory: Array
    }
}
</script>

<style>
</style>