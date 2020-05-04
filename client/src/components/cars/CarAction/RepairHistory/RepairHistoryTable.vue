<template>
  <div>
    <table class="table table-hover table-bordered table-dark w-75 overflow-auto m-auto" v-if="repairHistory.length">
      <thead>
        <tr>
          <th>Data</th>
          <th>Opis</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="repair in repairHistory" :key="repair.id">
          <td>{{ repair.date.date }}</td>
          <td>{{ repair.description }}</td>
        </tr>
      </tbody>
    </table>
    <p v-else>No repair history</p>
  </div>
</template>

<script>
export default {
  name: "RepairHistoryTable",
  props: {
    repairHistory: Array
  }
};
</script>

<style>
</style>