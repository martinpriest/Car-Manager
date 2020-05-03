<template>
  <div>
      <table v-if="tankHistory.length">
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
<!-- <AddCarModal v-if="showModal" @close="showModal = false">
        <h3 slot="header">custom header</h3>
      </AddCarModal> -->
</template>

<script>
export default {
    name: 'TankHistoryTable',
    props: {
        tankHistory: Array
    },
    watch: {
        tankHistory: function(newVal, oldVal) {
        console.log('Prop changed: ', newVal, ' | was: ', oldVal);
        }
    }
}
</script>

<style>
</style>