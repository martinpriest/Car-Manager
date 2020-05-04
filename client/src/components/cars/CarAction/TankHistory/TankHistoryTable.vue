<template>
  <div>
      <table class="table table-dark w-75 overflow-auto" v-if="tankHistory.length">
          <tr>
              <th>Gdzie</th>
              <th>Kiedy</th>
              <th>Ile</th>
              <th>Czego</th>
          </tr>
          <tr v-for="tank in tankHistory" :key ="tank.id">
              <td>{{ tank.petrolStation }}</td>
              <td>{{ tank.date.date }}</td>
              <td>{{ tank.amount }} l</td>
              <td>{{ tank.idPetrolType }}</td>
          </tr>
      </table>
      <p v-else>No tank history</p>
  </div>
</template>

<script>
export default {
    name: 'TankHistoryTable',
    props: {
        tankHistory: Array || Object
    },
    watch: {
        tankHistory: function() {
        }
    }
}
</script>

<style>
</style>