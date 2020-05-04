<template>
  <div>
    <table class="table table-hover table-bordered table-dark w-100 overflow-auto m-auto" v-if="tankHistory.length">
      <thead>
        <tr>
          <th>Gdzie</th>
          <th>Kiedy</th>
          <th>Ile</th>
          <th>Czego</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="tank in tankHistory" :key="tank.id">
          <td>{{ tank.petrolStation }}</td>
          <td>{{ tank.date.date }}</td>
          <td>{{ tank.amount }} l</td>
          <td>{{ tank.idPetrolType }}</td>
        </tr>
      </tbody>
    </table>
    <p v-else>No tank history</p>
  </div>
</template>

<script>
export default {
  name: "TankHistoryTable",
  props: {
    tankHistory: Array || Object
  },
  watch: {
    tankHistory: function() {}
  }
};
</script>

<style>
</style>